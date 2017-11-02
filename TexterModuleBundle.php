<?php

namespace SmartCore\Module\Texter;

use SmartCore\Bundle\CMSBundle\Entity\Node;
use SmartCore\Bundle\CMSBundle\Module\ModuleBundle;
use SmartCore\Module\Texter\Entity\TextItem;

class TexterModuleBundle extends ModuleBundle
{
    protected $adminMenuBeforeCode = '<i class="fa fa-text-height"></i>';

    /**
     * Действие при создании ноды.
     *
     * @param Node $node
     */
    public function createNode(Node $node)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        $item = new TextItem();
        $item->setUser($this->container->get('security.token_storage')->getToken()->getUser());

        $em->persist($item);
        $em->flush($item);

        $node->setParams([
            'text_item_id' => $item->getId(),
            'editor' => true,
        ]);
    }

    /**
     * Действие при обновлении ноды.
     *
     * @param Node $node
     */
    public function updateNode(Node $node)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        $item = $em->find(TextItem::class, $node->getParam('text_item_id'));

        if ($item) {
            $item->setEditor((int) $node->getParam('editor'));
            $em->persist($item);
            $em->flush($item);
        }
    }
}
