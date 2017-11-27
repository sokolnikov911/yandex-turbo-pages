<?php

namespace sokolnikov911\YandexTurboPages;

/**
 * Class RelatedItem
 * @package sokolnikov911\YandexTurboPages
 */
class RelatedItem implements RelatedItemInterface
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $link;

    /** @var string */
    protected $img;

    public function __construct(string $title, string $link, string $img = '')
    {
        $this->link = $link;
        $this->title = $title;
        $this->img = $img;
    }

    public function appendTo(RelatedItemsListInterface $relatedItemsList): RelatedItemInterface
    {
        $relatedItemsList->addItem($this);
        return $this;
    }

    public function asXML(): SimpleXMLElement
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><link>'
            . $this->title . '</link>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        $xml->addAttribute('url', $this->link);

        if (!empty($this->img)) {
            $xml->addAttribute('img', $this->img);
        }

        return $xml;
    }
}
