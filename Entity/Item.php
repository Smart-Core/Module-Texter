<?php

namespace SmartCore\Module\Texter\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="text_items")
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
     * @ORM\Column(type="string", length=8, nullable=TRUE)
     */
    protected $language;
    
    /**
     * @ORM\Column(type="text", nullable=TRUE)
     */
    protected $text;

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
        $this->datetime = new \DateTime();
        $this->language = 'ru';
        $this->meta = null; //new ArrayCollection();
        $this->text = null;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }

    public function getId()
    {
        return $this->item_id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setMeta($meta)
    {
        foreach($meta as $key => $value) {
            if (empty($value)) {
                unset($meta[$key]);
            }
        }

        $this->meta = $meta;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}
