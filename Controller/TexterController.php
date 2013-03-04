<?php

namespace SmartCore\Module\Texter\Controller;

use SmartCore\Bundle\EngineBundle\Module\Controller;
use SmartCore\Bundle\EngineBundle\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TexterController extends Controller
{
    /**
     * Для каждого экземпляра ноды хранится ИД текстовой записи.
     * @var int
     */
    protected $text_item_id;

    /**
     * Какой редактор использовать.
     * !!!note: пока используется как флаг, где 0 - не использовать визивиг, а 1 - использовать.
     * @var string
     */
    protected $editor = 0;

    /**
     * Экшен по умолчанию.
     *
     * @param integer $item_id
     */
    public function indexAction($item_id = null)
    {
        $item = $this->getRepo('TexterModule:Item')->find($item_id ? $item_id : $this->text_item_id);

        $this->View->setEngine('echo');
        //$this->View->setEngine('twig');
        $this->View->text = $item->getText();

        foreach ($item->getMeta() as $key => $value) {
            $this->get('html')->meta($key, $value);
        }
        
        return new Response($this->View);
    }

    /**
     * Обработчик POST данных.
     *
     * @return Response
     */
    public function postAction(Request $request, $item_id = null)
    {
        $data = $request->request->get('texter');
        $item = $this->getRepo('TexterModule:Item')->find($item_id ? $item_id : $this->text_item_id);

        $item->setText($data['text']);
        $item->setMeta($data['meta']);

        try {
            $this->EM()->persist($item);
            $this->EM()->flush();
        } catch (\Exception $e) {
            $errors = array();
            if ($this->get('kernel')->isDebug()) {
                $errors['sql_debug'] = $e->getMessage();
            }

            return new JsonResponse(array('status' => 'INVALID', 'message' => 'Ошибка при сохранении данных.', 'errors' => $errors));
        }

        return new JsonResponse(array('status' => 'OK', 'message' => 'Текст обновлён'));
    }
}
