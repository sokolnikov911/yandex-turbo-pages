<?php

namespace sokolnikov911\YandexTurboPages;

/**
 * Interface CounterInterface
 * @package sokolnikov911\YandexTurboPages
 */
class Counter implements CounterInterface
{
    const TYPE_LIVE_INTERNET    = 'LiveInternet';
    const TYPE_GOOGLE_ANALYTICS = 'Google';
    const TYPE_MEDIASCOPE       = 'Mediascope';
    const TYPE_MAIL_RU          = 'MailRu';
    const TYPE_RAMBLER          = 'Rambler';
    const TYPE_YANDEX           = 'Yandex';
    const TYPE_CUSTOM           = 'custom';

    private $type;
    private $id;
    private $url;

    public function __construct(string $type, string $id = null, string $url = null)
    {
        $this->type = $type;
        $this->id   = $id;
        $this->url  = $url;

        if ($type == self::TYPE_CUSTOM && !isset($url)) {
            throw new \UnexpectedValueException('Please set url for custom counter');
        }

        if ($type != self::TYPE_CUSTOM && !isset($id)) {
            throw new \UnexpectedValueException('Please set id for non custom counter');
        }
    }

    public function appendTo(ChannelInterface $channel): CounterInterface
    {
        $channel->addCounter($this);
        return $this;
    }

    public function asXML(): SimpleXMLElement
    {
        $idPart = $this->id ? ' id="' . $this->id . '" ' : '';
        $urlPart = $this->url ? ' url="' . $this->url . '" ' : '';

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><yandex:analytics type="'
            . $this->type . '"' . $idPart . $urlPart . '></yandex:analytics>',
            LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        return $xml;
    }
}