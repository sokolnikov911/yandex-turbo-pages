<?php

namespace sokolnikov911\YandexTurboPages;

/**
 * Interface RelatedItemInterface
 * @package sokolnikov911\YandexTurboPages
 */
interface RelatedItemInterface
{
    /**
     * Create RelatedItem object with data
     * @param string $link
     * @param string $title
     * @param string $img
     */
    public function __construct(string $title, string $link, string $img = '');

    /**
     * Append RelatedItem to the RelatedItemsList
     * @param RelatedItemsListInterface $relatedItemsList
     * @return RelatedItemInterface
     */
    public function appendTo(RelatedItemsListInterface $relatedItemsList): RelatedItemInterface;

    /**
     * Return XML object
     * @return SimpleXMLElement
     */
    public function asXML(): simpleXMLElement;
}
