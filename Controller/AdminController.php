<?php

namespace SmartCore\Module\Texter\Controller;

use SmartCore\Bundle\EngineBundle\Module\Controller;
use SmartCore\Bundle\EngineBundle\Response;

class AdminController extends Controller
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
     */
    public function indexAction($slug = null)
    {
        $item = $this->getRepo('TexterModule:Item')->findOneBy(array(
            'item_id' => $this->text_item_id,
        ));

        return $this->render('TexterModule:Admin:edit.html.twig', array(
            '_node_id' => $this->node['id'],
            'text' => $item->getText(),
            'meta' => $item->getMeta(),
        ));
    }
}
