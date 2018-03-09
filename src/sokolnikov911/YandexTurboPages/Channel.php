<?php

namespace sokolnikov911\YandexTurboPages;

/**
 * Class Channel
 * @package sokolnikov911\YandexTurboPages
 */
class Channel implements ChannelInterface
{
    const AD_TYPE_YANDEX = 'Yandex';
    const AD_TYPE_ADFOX = 'AdFox';

    /** @var string */
    protected $title;

    /** @var string */
    protected $link;

    /** @var string */
    protected $description;

    /** @var string */
    protected $language;

    /** @var string */
    protected $adType;

    /** @var string */
    protected $adId;

    /** @var string */
    protected $adTurboAdId;

    /** @var string */
    protected $adCode;

    /** @var ItemInterface[] */
    protected $items = [];

    /** @var CounterInterface[] */
    protected $counters = [];

    public function title(string $title): ChannelInterface
    {
        $title = (mb_strlen($title) > 240) ? mb_substr($title, 0, 239) . '…' : $title;
        $this->title = $title;
        return $this;
    }

    public function link(string $link): ChannelInterface
    {
        $this->link = $link;
        return $this;
    }

    public function description(string $description): ChannelInterface
    {
        $this->description = $description;
        return $this;
    }

    public function language(string $language): ChannelInterface
    {
        $this->language = $language;
        return $this;
    }

    public function adNetwork(string $type = self::AD_TYPE_YANDEX, string $id = '',
                              string $turboAdId, string $code = ''): ChannelInterface
    {
        $this->adType      = $type;
        $this->adId        = $id;
        $this->adTurboAdId = $turboAdId;
        $this->adCode      = $code;

        return $this;
    }

    public function addItem(ItemInterface $item): ChannelInterface
    {
        $this->items[] = $item;
        return $this;
    }

    public function addCounter(CounterInterface $counter): ChannelInterface
    {
        $this->counters[] = $counter;
        return $this;
    }

    public function appendTo(FeedInterface $feed): ChannelInterface
    {
        $feed->addChannel($this);
        return $this;
    }

    public function asXML(): SimpleXMLElement
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><channel></channel>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);
        $xml->addChild('title', $this->title);
        $xml->addChild('link', $this->link);
        $xml->addChild('description', $this->description);

        if ($this->language !== null) {
            $xml->addChild('language', $this->language);
        }

        if ($this->adType &&
            ((($this->adType == Channel::AD_TYPE_YANDEX) && $this->adId) ||
                (($this->adType == Channel::AD_TYPE_ADFOX) && $this->adCode))) {

            $adChild = $xml->addChild('yandex:adNetwork', '', 'http://news.yandex.ru');
            $adChild->addAttribute('type', $this->adType);

            if ($this->adId) {
                $adChild->addAttribute('id', $this->adId);
            }

            if ($this->adTurboAdId) {
                $adChild->addAttribute('turbo-ad-id', $this->adTurboAdId);
            }

            if (($this->adType == self::AD_TYPE_ADFOX) && $this->adCode) {
                $dom = dom_import_simplexml($adChild);
                $elementOwner = $dom->ownerDocument;
                $dom->appendChild($elementOwner->createCDATASection($this->adCode));
            }
        }

        foreach ($this->counters as $counter) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($counter->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        foreach ($this->items as $item) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($item->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        return $xml;
    }
}
