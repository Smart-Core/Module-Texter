<?php

namespace SmartCore\Module\Texter\Controller;

use SmartCore\Bundle\CMSBundle\Module\NodeTrait;
use Smart\CoreBundle\Controller\Controller as BaseController;

class Controller extends BaseController
{
    use NodeTrait;

    /**
     * Для каждого экземпляра ноды хранится ИД текстовой записи.
     *
     * @var int
     */
    protected $text_item_id;

    /**
     * Какой редактор использовать.
     * Пока используется как флаг, где:
     *  0 - Codemirror
     *  1 - TinyMCE.
     *
     * @var int
     */
    protected $editor = 1;
}
