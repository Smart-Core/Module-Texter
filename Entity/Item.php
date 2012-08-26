<?php

namespace SmartCore\Module\Texter\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="aaa_text_items",
 *         indexes={
 *             @ORM\Index(name="site_id", columns={"site_id"}),
 *         }
* )
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $item_id;
    
    /**
     * @ORM\Column(type="integer")
     * 
     * ORM\Id
     * ORM\GeneratedValue(strategy="NONE")
     */
    protected $site_id = 0;

    /**
     * @ORM\Column(type="string", length=8, nullable=TRUE)
     */
    protected $language = null;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $text = '';

    /**
     * @ORM\Column(type="text", nullable=TRUE)
     */
    protected $meta = null;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $create_datetime;

    /**
     * @ORM\Column(type="integer")
     */
    protected $create_user_id = 0;

}