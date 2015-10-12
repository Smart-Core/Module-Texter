<?php

namespace SmartCore\Module\Texter\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Smart\CoreBundle\Doctrine\ColumnTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="texter")
 */
class Item
{
    use ColumnTrait\Id;
    use ColumnTrait\CreatedAt;
    use ColumnTrait\UpdatedAt;
    use ColumnTrait\Text;
    use ColumnTrait\FosUser;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    protected $locale;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    protected $editor;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    protected $meta;

    /**
     * @var ItemHistory[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ItemHistory", mappedBy="item", cascade={"persist", "remove"}, fetch="EXTRA_LAZY")
     */
    protected $history;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->locale   = 'ru';
        $this->meta     = [];
        $this->text     = null;
        $this->editor   = 1;
        $this->history  = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getText();
    }

    /**
     * @return string
     */
    public function getAnnounce()
    {
        $a = strip_tags($this->text);

        $dotted = (mb_strlen($a, 'utf-8') > 100) ? '...' : '';

        return mb_substr($a, 0, 100, 'utf-8').$dotted;
    }

    /**
     * @param int $editor
     *
     * @return $this
     */
    public function setEditor($editor)
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * @return int
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return empty($this->meta) ? [] : $this->meta;
    }

    /**
     * @param array $meta
     *
     * @return $this
     */
    public function setMeta(array $meta)
    {
        if (is_array($meta)) {
            foreach ($meta as $key => $value) {
                if (empty($value)) {
                    unset($meta[$key]);
                }
            }
        } else {
            $this->meta = [];
        }

        $this->meta = $meta;

        return $this;
    }

    /**
     * @return ItemHistory[]|ArrayCollection
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @param ItemHistory[]|ArrayCollection $history
     *
     * @return $this
     */
    public function setHistory($history)
    {
        $this->history = $history;

        return $this;
    }
}
