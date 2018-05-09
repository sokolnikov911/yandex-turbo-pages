<?php

namespace sokolnikov911\YandexTurboPages;

/**
 * Class Item
 * @package sokolnikov911\YandexTurboPages
 */
class Item implements ItemInterface
{
    /** @var boolean */
    protected $turbo;

    /** @var string */
    protected $title;

    /** @var string */
    protected $link;

    /** @var string */
    protected $category;

    /** @var int */
    protected $pubDate;

    /** @var string */
    protected $author;

    /** @var string */
    protected $fullText;

    /** @var string */
    protected $turboSource;

    /** @var string */
    protected $turboTopic;

    /** @var string */
    protected $turboContent;

    /** @var RelatedItemsListInterface */
    protected $relatedItemsList;

    public function __construct(bool $turbo = true)
    {
        $this->turbo = $turbo;
    }

    public function title(string $title): ItemInterface
    {
        $title = (mb_strlen($title) > 240) ? mb_substr($title, 0, 239) . '…' : $title;
        $this->title = $title;
        return $this;
    }

    public function link(string $link): ItemInterface
    {
        $this->link = $link;
        return $this;
    }

    public function category(string $category): ItemInterface
    {
        $this->category = $category;
        return $this;
    }

    public function pubDate(int $pubDate): ItemInterface
    {
        $this->pubDate = $pubDate;
        return $this;
    }

    public function turboSource(string $turboSource): ItemInterface
    {
        $this->turboSource = $turboSource;
        return $this;
    }

    public function turboTopic(string $turboTopic): ItemInterface
    {
        $this->turboTopic = $turboTopic;
        return $this;
    }

    public function turboContent(string $turboContent): ItemInterface
    {
        $this->turboContent = $turboContent;
        return $this;
    }

    public function author(string $author): ItemInterface
    {
        $this->author = $author;
        return $this;
    }

    public function fullText(string $fullText): ItemInterface
    {
        $this->fullText = $fullText;
        return $this;
    }

    public function appendTo(ChannelInterface $channel): ItemInterface
    {
        $channel->addItem($this);
        return $this;
    }

    public function addRelatedItemsList(RelatedItemsListInterface $relatedItemsList): ItemInterface
    {
        $this->relatedItemsList = $relatedItemsList;
        return $this;
    }

    public function asXML(): SimpleXMLElement
    {
        $isTurboEnabled = $this->turbo ? 'true' : 'false';

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><item turbo="' . $isTurboEnabled
            . '"></item>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        $xml->addChild('title', $this->title);
        $xml->addChild('link', $this->link);
        $xml->addCdataChild('turbo:content', $this->turboContent, 'http://turbo.yandex.ru');
        $xml->addChild('pubDate', date(DATE_RSS, $this->pubDate));

        if (!empty($this->category)) {
            $xml->addChild('category', $this->category);
        }

        if (!empty($this->author)) {
            $xml->addChild('author', $this->author);
        }

        if (!empty($this->fullText)) {
            $xml->addChild('yandex:full-text', $this->fullText, 'http://news.yandex.ru');
        }

        if (!empty($this->turboTopic)) {
            $xml->addChild('turbo:topic', $this->turboTopic, 'http://turbo.yandex.ru');
        }

        if (!empty($this->turboSource)) {
            $xml->addChild('turbo:source', $this->turboSource, 'http://turbo.yandex.ru');
        }

        if ($this->relatedItemsList) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($this->relatedItemsList->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        return $xml;
    }
}
