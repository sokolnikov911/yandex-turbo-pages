<?php

namespace sokolnikov911\YandexTurboPages;

/**
 * Interface ItemInterface
 * @package sokolnikov911\YandexTurboPages
 */
interface ItemInterface
{
    /**
     * Set turbo mode
     * @param bool $turbo
     */
    public function __construct(bool $turbo);

    /**
     * Set item title
     * @param string $title
     * @return ItemInterface
     */
    public function title(string $title): ItemInterface;

    /**
     * Set item URL
     * @param string $link
     * @return ItemInterface
     */
    public function link(string $link): ItemInterface;

    /**
     * Set page content
     * @param string $turboSource
     * @return ItemInterface
     */
    public function turboSource(string $turboSource): ItemInterface;

    /**
     * Set page content
     * @param string $turboTopic
     * @return ItemInterface
     */
    public function turboTopic(string $turboTopic): ItemInterface;

    /**
     * Set page content
     * @param string $turboContent
     * @return ItemInterface
     */
    public function turboContent(string $turboContent): ItemInterface;

    /**
     * Set item category
     * @param string $category Category name
     * @return ItemInterface
     */
    public function category(string $category): ItemInterface;

    /**
     * Set published date
     * @param int $pubDate Unix timestamp
     * @return ItemInterface
     */
    public function pubDate(int $pubDate): ItemInterface;

    /**
     * Set the author
     * @param string $author Email of item author
     * @return ItemInterface
     */
    public function author(string $author): ItemInterface;

    /**
     * Set the yandex:full-text
     * @param string $fullText yandex:full-text
     * @return ItemInterface
     */
    public function fullText(string $fullText): ItemInterface;

    /**
     * Append item to the channel
     * @param ChannelInterface $channel
     * @return ItemInterface
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
