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

    private $type;
    private $id;

    public function __construct(string $type, string $id){
        $this->type = $type;
        $this->id = $id;
    }

    public function appendTo(ChannelInterface $channel)
    {
        $channel->addCounter($this);
        return $this;
    }

    public function asXML(){
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><yandex:analytics id="'
            . $this->id . '"  type="' . $this->type . '"></yandex:analytics>',
            LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        return $xml;
    }
}