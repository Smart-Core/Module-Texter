<?php

namespace SmartCore\Module\Texter\Controller;

use SmartCore\Bundle\EngineBundle\Module\Controller;
use SmartCore\Bundle\EngineBundle\Response;

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
     */
    public function indexAction()
    {
        $item = $this->getRepo('TexterModule:Item')->findOneBy(array(
            'item_id' => $this->text_item_id,
        ));

        $this->View->setEngine('echo');
        $this->View->text = $item->getText();

        foreach ($item->getMeta() as $key => $value) {
            $this->engine('html')->meta($key, $value);
        }
        
        return new Response($this->View);
    }
}
