<?php

namespace SmartCore\Module\Texter\Controller;

use SmartCore\Bundle\EngineBundle\Controller\Module;
//use SmartCore\Bundle\EngineBundle\Controller\Controller;

class TestController extends Module // Controller
{
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
}