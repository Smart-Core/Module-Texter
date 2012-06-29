<?php

namespace SmartCore\Module\Texter\Controller;

use SmartCore\Bundle\EngineBundle\Controller\Module;
use SmartCore\Bundle\EngineBundle\Response;

class TestController extends Module
{
    /**
     * ИД текстовой записи.
     * 
     * @var int
     */
    protected $text_item_id = 0;
    
    protected $editor = 0;

    /**
     * Конструктор.
     * 
     * @return void
     */
    protected function init()
    {
        $this->NodeProperties->setDefaultParams(array(
            'text_item_id'    => 0,
            'editor'        => 1,
        ));

        /*
        $this->View->setOptions(array(
            'engine'        => 'simple',
            'template_ext' => '.tpl',
        ));
        */
        $this->View->setRenderMethod('echoProperties');
    }

    public function indexAction($text = 888)
    {
        return $this->render("SmartCoreTexterModule::texter.html.twig", array(
            'text' => $text,
        ));
    }

    public function helloAction($text = 'Hello')
    {
        return $this->render("SmartCoreTexterModule::hello.html.twig", array(
            'text' => $text,
        ));
    }

    public function testAction($text = 'Hello')
    {
        $this->View->text = $text;

        return new Response($this->View);
    }
}