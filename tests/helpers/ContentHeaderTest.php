<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentHeaderTest extends TestCase
{
    private $title = 'Page title';
    private $subTitle = 'Page second title';
    private $imgUrl = 'http://example.com/img.jpg';
    private $imgCaption = 'Image Caption';
    private $menu = [
        ['url' => 'http://example/page1.html', 'title' => 'Page title 1'],
        ['url' => 'http://example/page2.html', 'title' => 'Page title 2'],
    ];

    public function testBaseHeader()
    {
        $header = Content::header($this->title);
        $baseHeader = '<header><h1>' . $this->title . '</h1></header>';
        $this->assertXmlStringEqualsXmlString($baseHeader, $header);
    }

    public function testFullHeader()
    {
        $header = Content::header($this->title, $this->subTitle, $this->imgUrl, $this->imgCaption);
        $baseHeader = "<header>
                <h1>" . $this->title . "</h1>
                <h2>" . $this->subTitle . "</h2>
                <figure>
                    <img src=\"" . $this->imgUrl . "\" />
                    <figcaption>" . $this->imgCaption . "</figcaption>
                </figure>
            </header>";
        $this->assertXmlStringEqualsXmlString($baseHeader, $header);
    }

    public function testHeaderWithMenu()
    {
        $header = Content::header($this->title, null, null, null, $this->menu);
        $baseHeader = "<header>
                <h1>" . $this->title . "</h1>
                <menu>
                    <a href=\"http://example/page1.html\">Page title 1</a>
                    <a href=\"http://example/page2.html\">Page title 2</a>
                </menu>
            </header>";
        $this->assertXmlStringEqualsXmlString($baseHeader, $header);
    }
}