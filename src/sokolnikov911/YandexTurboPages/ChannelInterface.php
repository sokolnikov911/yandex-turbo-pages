<?php

namespace sokolnikov911\YandexTurboPages;

/**
 * Interface ChannelInterface
 * @package sokolnikov911\YandexTurboPages
 */
interface ChannelInterface
{
    /**
     * Set channel title
     * @param string $title
     * @return ChannelInterface
     */
    public function title(string $title): ChannelInterface;

    /**
     * Set channel URL
     * @param string $link
     * @return ChannelInterface
     */
    public function link(string $link): ChannelInterface;

    /**
     * Set channel description
     * @param string $description
     * @return ChannelInterface
     */
    public function description(string $description): ChannelInterface;

    /**
     * Set ISO 639-1 language code
     * @param string $language
     * @return ChannelInterface
     */
    public function language(string $language): ChannelInterface;

    /**
     * Set ISO 639-1 language code
     * @param string $type Type of Ad Network: Yandex or ADFOX
     * @param string $id Id of Yandex Ad block, if Yandex Ad network used
     * @param string $turboAdId Id of <figure> element in content, in which Ad block should placed
     * @param string $code ADFOX code, if ADFOX used
     * @return ChannelInterface
     */
    public function adNetwork(string $type, string $id = '', string $turboAdId = '', string $code = ''): ChannelInterface;

    /**
     * Add item object
     * @param ItemInterface $item
     * @return ChannelInterface
     */
    public function addItem(ItemInterface $item): ChannelInterface;

    /**
     * Add counter object
     * @param CounterInterface $counter
     * @return ChannelInterface
     */
    public function addCounter(CounterInterface $counter): ChannelInterface;

    /**
     * Append to feed
     * @param FeedInterface $feed
     * @return ChannelInterface
     */
    public function appendTo(FeedInterface $feed): ChannelInterface;

    /**
     * Return XML object
     * @return SimpleXMLElement
     */
    public function asXML(): SimpleXMLElement;
}
