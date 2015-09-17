<?php
namespace Victoire\Widget\CardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\Bundle\WidgetBundle\Entity\Widget;
use Victoire\Bundle\CoreBundle\Annotations as VIC;
use Victoire\Bundle\MediaBundle\Entity\Media;
use Victoire\Widget\ImageBundle\Entity\WidgetImage;

/**
 * WidgetCard
 *
 * @ORM\Table("vic_widget_card")
 * @ORM\Entity
 */
class WidgetCard extends Widget
{
    use \Victoire\Bundle\WidgetBundle\Entity\Traits\LinkTrait;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="\Victoire\Bundle\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     * @VIC\ReceiverProperty("imageable")
     *
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     * @VIC\ReceiverProperty("textable")
     */
    protected $title;

    /**
     * @var text
     *
     * @ORM\Column(name="shortDescription", type="text", nullable=true)
     * @VIC\ReceiverProperty("textable")
     */
    protected $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="buttonText", type="string", length=255, nullable=true)
     */
    protected $buttonText;

    /**
     * @var string
     *
     * @ORM\Column(name="buttonIcon", type="string", length=255, nullable=true)
     */
    protected $buttonIcon;

    /**
     * @var string default|warning|info|success|primary|danger
     *
     * @ORM\Column(name="style", type="string", length=10)
     */
    protected $style;

    /**
     * @var string
     *
     * @ORM\Column(name="legend", type="string", length=255, nullable=true)
     * @VIC\ReceiverProperty("textable")
     */
    protected $legend;

    /**
     * @var date
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     * @VIC\ReceiverProperty("dateable")
     */
    protected $date;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", nullable=true)
     * @VIC\ReceiverProperty("textable")
     */
    protected $price;

    /**
     * @var text
     *
     * @ORM\Column(name="popover", type="text", nullable=true)
     */
    protected $popover;

    /**
     * @var string
     *
     * @ORM\Column(name="cardType", type="string", length=255, nullable=true)
     * @VIC\ReceiverProperty("textable")
     */
    protected $cardType;

    /**
     * @ORM\Column(name="themeCard", type="string", length=255, nullable=true)
     */
    protected $themeCard;

    /**
     * To String function
     * Used in render choices type (Especially in VictoireWidgetRenderBundle)
     * //TODO Check the generated value and make it more consistent
     *
     * @return String
     */
    public function __toString()
    {
        return 'Card #'.$this->id.' - '.$this->title;
    }


    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return $this
     */
    public function setShortdescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortdescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set buttonText
     *
     * @param string $buttonText
     * @return $this
     */
    public function setButtontext($buttonText)
    {
        $this->buttonText = $buttonText;

        return $this;
    }

    /**
     * Get buttonText
     *
     * @return string
     */
    public function getButtontext()
    {
        return $this->buttonText;
    }

    /**
     * Set buttonIcon
     *
     * @param string $buttonIcon
     * @return $this
     */
    public function setButtonicon($buttonIcon)
    {
        $this->buttonIcon = $buttonIcon;

        return $this;
    }

    /**
     * Get buttonIcon
     *
     * @return string
     */
    public function getButtonicon()
    {
        return $this->buttonIcon;
    }

    /**
     * Get style
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set style
     *
     * @param string $style
     * @return $this
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Set legend
     *
     * @param string $legend
     * @return $this
     */
    public function setLegend($legend)
    {
        $this->legend = $legend;

        return $this;
    }

    /**
     * Get legend
     *
     * @return string
     */
    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set popover
     *
     * @param string $popover
     * @return $this
     */
    public function setPopover($popover)
    {
        $this->popover = $popover;

        return $this;
    }

    /**
     * Get popover
     *
     * @return string
     */
    public function getPopover()
    {
        return $this->popover;
    }

    /**
     * Set cardType
     *
     * @param string $cardType
     * @return $this
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;

        return $this;
    }

    /**
     * Get cardType
     *
     * @return string
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * @return string
     */
    public function getThemeCard()
    {
        return $this->themeCard;
    }

    /**
     * @param string $themeCard
     * @return $this
     */
    public function setThemeCard($themeCard)
    {
        $this->themeCard = $themeCard;

        return $this;
    }

    /**
     * Set image
     * @param string|Media $image
     * @return WidgetImage
     */
    public function setImage(Media $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

}
