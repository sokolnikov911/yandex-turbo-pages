<?php

namespace sokolnikov911\YandexTurboPages;

use DOMDocument;

/**
 * Class Feed
 * @package sokolnikov911\YandexTurboPages
 */
class Feed implements FeedInterface
{
    const ENCODING_UTF_8 = 'UTF-8';
    const ENCODING_WINDOWS_1251 = 'windows-1251';
    const ENCODING_KOI8_R = 'KOI8-R';

    /** @var ChannelInterface[] */
    protected $channels = [];

    private $encoding;

    public function __construct(string $encoding = self::ENCODING_UTF_8)
    {
        $this->encoding = $encoding;
    }

    public function addChannel(ChannelInterface $channel): FeedInterface
    {
        $this->channels[] = $channel;
        return $this;
    }

    public function render(): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="' . $this->encoding
            . '" ?><rss version="2.0" xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/" xmlns:turbo="http://turbo.yandex.ru" />',
            LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        foreach ($this->channels as $channel) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($channel->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->appendChild($dom->importNode(dom_import_simplexml($xml), true));
        $dom->formatOutput = true;
        return $dom->saveXML();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
