<?php

namespace SmartCore\Module\Texter\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
    protected $site_id;

    /**
     * @ORM\Column(type="string", length=8, nullable=TRUE)
     */
    protected $language = null;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $text = '';

    /**
     * @ORM\Column(type="array")
     */
    protected $meta;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $datetime;

    /**
     * @ORM\Column(type="integer")
     */
    protected $user_id = 0;
    
    public function __construct()
    {
        //parent::__construct();
        $this->datetime = new \DateTime();
        $this->language = 'ru';
        $this->site_id = 0;
        $this->meta = new ArrayCollection();
    }

    /**
     * NewFunction
     */
    public function getSiteId()
    {
        return $this->site_id;
    }
    
    public function getText()
    {
        return $this->text;
    }


    public function getMeta()
    {
        return $this->meta;
    }
}