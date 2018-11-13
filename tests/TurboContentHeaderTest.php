<?php

namespace sokolnikov911\YandexTurboPages;

use PHPUnit\Framework\TestCase;
use DOMDocument;

class TurboContentHeaderTest extends TestCase
{
    public function testTitleH1()
    {
        $title = uniqid();
        $header = new TurboContentHeader();
        $this->assertSame($header, $header->titleH1($title));
        $this->assertAttributeSame($title, 'titleH1', $header);
    }

    public function testTitleH2()
    {
        $title = uniqid();
        $header = new TurboContentHeader();
        $this->assertSame($header, $header->titleH2($title));
        $this->assertAttributeSame($title, 'titleH2', $header);
    }

    public function testImg()
    {
        $img = uniqid();
        $header = new TurboContentHeader();
        $this->assertSame($header, $header->img($img));
        $this->assertAttributeSame($img, 'img', $header);
    }

    public function testAsHTML()
    {
        libxml_use_internal_errors(true);

        $data = $this->dataForHtml();
        $header = new TurboContentHeader();
        $header
            ->titleH1($data['titleH1'])
            ->titleH2($data['titleH2'])
            ->img($data['img']);

        $expectedHtml = '<header>Second title line<h1>First title line</h1><figure><img src="http://page.com/img.jpg"></figure></header>';
        $expectedDom = new DOMDocument();
        $expectedDom->loadHTML($expectedHtml);
        $expectedDom->preserveWhiteSpace = false;

        $actualDom = new DOMDocument();
        $actualDom->loadHTML($header->asHTML());
        $actualDom->preserveWhiteSpace = false;

        $this->assertEquals($expectedDom->saveHTML(), $actualDom->saveHTML());
    }

    private function dataForHtml(): array
    {
        $data = [
            'titleH1' => 'First title line',
            'titleH2' => 'Second title line',
            'img' => 'http://page.com/img.jpg'
        ];

        return $data;
    }
}
