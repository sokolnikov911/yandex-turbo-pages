<?php

namespace sokolnikov911\YandexTurboPages;

/**
 * Interface RelatedItemsInterface
 * @package sokolnikov911\YandexTurboPages
 */
interface RelatedItemsListInterface
{
    /**
     * Append related items list to the item
     * @param ItemInterface $item
     * @return RelatedItemsListInterface
     */
    public function appendTo(ItemInterface $item): RelatedItemsListInterface;

    /**
     * Add related item object
     * @param RelatedItem $relatedItem
     * @return RelatedItemsListInterface
     */
    public function addItem(RelatedItem $relatedItem): RelatedItemsListInterface;

    /**
     * Return XML object
     * @return SimpleXMLElement
     */
    public function asXML(): SimpleXMLElement;
}
