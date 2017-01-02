<?php

namespace SmartCore\Module\Texter\Controller;

use SmartCore\Bundle\CMSBundle\Module\CacheTrait;
use SmartCore\Module\Texter\Entity\Item;
use SmartCore\Module\Texter\Entity\ItemHistory;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    use CacheTrait;

    /**
     * @param  Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        if (!empty($this->node)) {
            return $this->itemAction($request, $this->text_item_id);
        }

        // @todo pagination
        $items = $this->getDoctrine()->getRepository('TexterModule:Item')->findAll();

        /** @var $item Item */
        foreach ($items as $item) {
            $folderPath = null;
            foreach ($this->get('cms.node')->findByModule('Texter') as $node) {
                if ($node->getParam('text_item_id') === (int) $item->getId()) {
                    $folderPath = $this->get('cms.folder')->getUri($node);

                    break;
                }
            }

            $item->_folderPath = $folderPath;
        }

        return $this->render('TexterModule:Admin:index.html.twig', [
            'items' => $items,
        ]);
    }

    /**
     * @param  Request $request
     * @param  int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function itemAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $em->find('TexterModule:Item', $id);

        $folderPath = null;
        foreach ($this->get('cms.node')->findByModule('Texter') as $node) {
            if ($node->getParam('text_item_id') === (int) $item->getId()) {
                $folderPath = $this->get('cms.folder')->getUri($node);

                break;
            }
        }

        if ($request->isMethod('POST')) {
            $oldItem = clone $item;

            $data = $request->request->get('texter');
            $item->setText($data['text']);
            $item->setMeta($data['meta']);

            $this->getCacheService()->deleteTag('smart_module.texter');

            // @todo сделать глобальную настройку, включающую выравниватель кода.
            if ($item->getEditor()) {
                $item->setText($this->get('html.tidy')->prettifyFragment($item->getText()));
            }

            try {
                $em->persist($item);
                $em->flush($item);

                $history = new ItemHistory($oldItem);
                $em->persist($history);
                $em->flush($history);

                $this->addFlash('success', 'Текст обновлён (id: <b>'.$item->getId().'</b>)'); // @todo перевод.

                if ($request->request->has('update_and_redirect_to_site') and $folderPath) {
                    return $this->redirect($folderPath);
                } else {
                    return $this->redirect($this->generateUrl('smart_module.texter.admin'));
                }
            } catch (\Exception $e) {
                $this->addFlash('error', ['sql_debug' => $e->getMessage()]);

                return $this->redirect($this->generateUrl('smart_module.texter.admin.edit', ['id' => $id]));
            }
        }

        $item->_folderPath = $folderPath;

        return $this->render('TexterModule:Admin:edit.html.twig', [
            '_node_id' => empty($this->node) ?: $this->node->getId(),
            'item'     => $item,
        ]);
    }

    /**
     * @param  Item $item
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @todo пагинацию.
     */
    public function historyAction(Item $item)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $itemsHistory = $em->getRepository('TexterModule:ItemHistory')->findBy(
            ['item' => $item],
            ['created_at' => 'DESC']
        );

        return $this->render('TexterModule:Admin:history.html.twig', [
            'item' => $item,
            'items_history' => $itemsHistory,
        ]);
    }

    /**
     * @param ItemHistory $itemHistory
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function historyViewAction(ItemHistory $itemHistory)
    {
        return $this->render('TexterModule:Admin:history_view.html.twig', [
            'item_history' => $itemHistory,
        ]);
    }

    /**
     * @param  int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function rollbackAction($id)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $historyItem = $em->find('TexterModule:ItemHistory', $id);

        if ($historyItem) {
            $item = $em->find('TexterModule:Item', $historyItem->getItemId());
            $item
                ->setEditor($historyItem->getEditor())
                ->setLocale($historyItem->getLocale())
                ->setMeta($historyItem->getMeta())
                ->setText($historyItem->getText())
                ->setText($historyItem->getText())
                ->setUser($historyItem->getUser())
            ;

            $em->persist($item);
            $em->flush($item);

            $this->addFlash('success', 'Откат успешно выполнен.'); // @todo перевод.
        } else {
            $this->addFlash('error', 'Непредвиденная ошибка при выполнении отката'); // @todo перевод.
        }

        return $this->redirect($this->generateUrl('smart_module.texter.admin'));
    }
}
