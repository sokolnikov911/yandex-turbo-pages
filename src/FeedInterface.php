<?php

namespace sokolnikov911\YandexTurboPages;

/**
 * Interface FeedInterface
 * @package sokolnikov911\YandexTurboPages
 */
interface FeedInterface
{
    /**
     * Add channel
     * @param ChannelInterface $channel
     * @return FeedInterface
     */
    public function addChannel(ChannelInterface $channel): FeedInterface;

    /**
     * Render XML
     * @return string
     */
    public function render(): string ;

    /**
     * Render XML
     * @return string
     */
    public function __toString(): string ;
}
