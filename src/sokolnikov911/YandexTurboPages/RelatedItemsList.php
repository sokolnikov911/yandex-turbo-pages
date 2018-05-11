<?php

namespace sokolnikov911\YandexTurboPages;

/**
 * Class RelatedItemsList
 * @package sokolnikov911\YandexTurboPages
 */
class RelatedItemsList implements RelatedItemsListInterface
{
    /** @var RelatedItemInterface[] */
    protected $relatedItems = [];

    protected $infinity;

    /**
     * Add channel
     * @param bool $infinity Use or not infinity scroll of related items
     * @return void
     */
    public function __construct(bool $infinity = false)
    {
        $this->infinity = $infinity;
    }

    public function appendTo(ItemInterface $item): RelatedItemsListInterface
    {
        $item->addRelatedItemsList($this);
        return $this;
    }

    public function addItem(RelatedItem $relatedItem): RelatedItemsListInterface
    {
        $this->relatedItems[] = $relatedItem;
        return $this;
    }

    public function asXML(): SimpleXMLElement
    {
        $infinity = $this->infinity ? 'type="infinity"' : '';

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><yandex:related '
            . $infinity . '></yandex:related>',
            LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        foreach ($this->relatedItems as $item) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($item->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        return $xml;
    }
}
