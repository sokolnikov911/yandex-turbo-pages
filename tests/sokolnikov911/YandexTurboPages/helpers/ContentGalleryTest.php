<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentGalleryTest extends TestCase
{
    private $header = 'Some gallery description';
    private $images = ['http://example/img1.jpg', 'http://example/img2.jpg'];
    public function testBaseImage()
    {
        $gallery = Content::gallery($this->images);
        $baseGallery = "<div data-block=\"gallery\">
                <img src=\"http://example/img1.jpg\" />
                <img src=\"http://example/img2.jpg\" />
            </div>";
        $this->assertXmlStringEqualsXmlString($baseGallery, $gallery);
    }
    public function testGalleryWithHeader()
    {
        $gallery = Content::gallery($this->images, $this->header);
        $fullGallery = "<div data-block=\"gallery\">
                <header>" . $this->header . "</header>
                <img src=\"http://example/img1.jpg\" />
                <img src=\"http://example/img2.jpg\" />
            </div>";
        $this->assertXmlStringEqualsXmlString($fullGallery, $gallery);
    }
}