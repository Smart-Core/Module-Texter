<?php

namespace SmartCore\Module\Texter\Controller;

use SmartCore\Bundle\EngineBundle\Response;

class AdminController extends Controller
{
    public function indexAction($slug = null)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $item = $em->find('TexterModule:Item', $this->text_item_id);

        return $this->render('TexterModule:Admin:edit.html.twig', [
            '_node_id' => $this->node->getId(),
            'text' => $item->getText(),
            'meta' => $item->getMeta(),
        ]);
    }
}
