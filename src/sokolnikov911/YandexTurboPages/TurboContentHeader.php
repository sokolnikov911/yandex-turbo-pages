<?php

namespace sokolnikov911\YandexTurboPages;

use DOMDocument;

/**
 * Class TurboContentHeader
 * @package sokolnikov911\YandexTurboPages
 * @deprecated 2.0.0 Use Content::header instead
 */
class TurboContentHeader implements TurboContentHeaderInterface
{
    /** @var string */
    protected $titleH1;

    /** @var string */
    protected $titleH2;

    /** @var string */
    protected $img;

    public function titleH1(string $titleH1): TurboContentHeaderInterface
    {
        $this->titleH1 = $titleH1;
        return $this;
    }

    public function titleH2(string $titleH2): TurboContentHeaderInterface
    {
        $this->titleH2 = $titleH2;
        return $this;
    }

    public function img(string $img): TurboContentHeaderInterface
    {
        $this->img = $img;
        return $this;
    }

    public function asHTML(): string
    {
        $DOMDoc = new DOMDocument('1.0', 'UTF-8');

        $titleH2 = $this->titleH2 ? $this->titleH2 : '';

        $headerDOMElement = $DOMDoc->createElement('header', $titleH2);
        $headerDOMElement = $DOMDoc->appendChild($headerDOMElement);

        if (!empty($this->titleH1)) {
            $h1DOMElement = $DOMDoc->createElement('h1', $this->titleH1);
            $headerDOMElement->appendChild($h1DOMElement);
        }

        if (!empty($this->img)) {
            $figureDOMElement = $DOMDoc->createElement('figure');

            $imgDOMElement = $DOMDoc->createElement('img');
            $imgDOMElement->setAttribute('src', $this->img);
            $figureDOMElement->appendChild($imgDOMElement);

            $headerDOMElement->appendChild($figureDOMElement);
        }

        return strval(html_entity_decode($DOMDoc->saveHTML()));
    }
}
