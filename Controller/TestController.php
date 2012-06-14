<?php

namespace SmartCore\Module\Texter\Controller;

use SmartCore\Bundle\EngineBundle\Engine\Module;
use SmartCore\Bundle\EngineBundle\Controller\Controller;

class TestController extends Controller // Module
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