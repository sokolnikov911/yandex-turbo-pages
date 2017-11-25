<?php

namespace sokolnikov911\YandexTurboPages;

use SimpleXMLElement as SimpleXMLE;

/**
 * Class SimpleXMLElement
 * @package sokolnikov911\YandexTurboPages
 */
class SimpleXMLElement extends SimpleXMLE
{
    /**
     * @param string $name
     * @param string $value
     * @param string $namespace
     * @return SimpleXMLE
     */
    public function addChild($name, $value = null, $namespace = null): SimpleXMLE
    {
        if ($value !== null and is_string($value) === true) {
            $value = $this->convertSymbols($value);
        }

        return parent::addChild($name, $value, $namespace);
    }

    /**
     * @param string $name
     * @param string $value
     * @param string $namespace
     * @return SimpleXMLE
     */
    public function addCdataChild($name, $value = null, $namespace = null): SimpleXMLE
    {
        if ($value !== null and is_string($value) === true) {
            $value = $this->convertSymbols($value);
        }

        $element = $this->addChild($name, null, $namespace);
        $dom = dom_import_simplexml($element);
        $elementOwner = $dom->ownerDocument;
        $dom->appendChild($elementOwner->createCDATASection($value));
        return $element;
    }
    
    private function convertSymbols(string $content): string
    {
        $content = str_replace('&',  '&amp;',  $content);
        
        return $content;
    }
}
