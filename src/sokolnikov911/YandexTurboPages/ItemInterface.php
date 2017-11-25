<?php

namespace sokolnikov911\YandexTurboPages;

/**
 * Interface ItemInterface
 * @package sokolnikov911\YandexTurboPages
 */
interface ItemInterface
{
    /**
     * Set item URL
     * @param string $link
     * @return $this
     */
    public function link(string $link): ItemInterface;

    /**
     * Set page content
     * @param string $turboContent
     * @return $this
     */
    public function turboContent(string $turboContent): ItemInterface;

    /**
     * Set item category
     * @param string $category Category name
     * @return $this
     */
    public function category(string $category): ItemInterface;

    /**
     * Set published date
     * @param int $pubDate Unix timestamp
     * @return $this
     */
    public function pubDate(int $pubDate): ItemInterface;

    /**
     * Set the author
     * @param string $author Email of item author
     * @return $this
     */
    public function author(string $author): ItemInterface;

    /**
     * Append item to the channel
     * @param ChannelInterface $channel
     * @return $this
     */
    public function appendTo(ChannelInterface $channel): ItemInterface;

    /**
     * Add list of related items to item
     * @param RelatedItemsListInterface $relatedItemsList
     * @return ItemInterface
     */
    public function addRelatedItemsList(RelatedItemsListInterface $relatedItemsList): ItemInterface;

    /**
     * Return XML object
     * @return SimpleXMLElement
     */
    public function asXML(): simpleXMLElement;
}
