<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentSearchInputTest extends TestCase
{
    private $placeholder = 'Some placeholder';
    private $url = 'http://example.com/search/{text}';

    public function testSearchWithPlaceholder()
    {
        $input = Content::searchInput($this->url, $this->placeholder);

        $expected = '<form action="' . $this->url . '" method="GET"><input type="search" name="text" placeholder="' . $this->placeholder . '"/></form>';

        $this->assertXmlStringEqualsXmlString($expected, $input);
    }

    public function testSearchWithoutPlaceholder()
    {
        $input = Content::searchInput($this->url);

        $expected = '<form action="' . $this->url . '" method="GET"><input type="search" name="text" /></form>';

        $this->assertXmlStringEqualsXmlString($expected, $input);
    }
}