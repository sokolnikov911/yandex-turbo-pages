<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentImageTest extends TestCase
{
    private $imgUrl = 'http://example.com/img.jpg';
    private $imgCaption = 'Image Caption';

    public function testBaseGallery()
    {
        $image = Content::img($this->imgUrl);
        $baseImage = '<figure><img src="' . $this->imgUrl . '" /></figure>';
        $this->assertXmlStringEqualsXmlString($baseImage, $image);
    }

    public function testGalleryWithHeader()
    {
        $image = Content::img($this->imgUrl, $this->imgCaption);
        $fullImage = '<figure><img src="' . $this->imgUrl . '" /><figcaption>' . $this->imgCaption
            . '</figcaption></figure>';
        $this->assertXmlStringEqualsXmlString($fullImage, $image);
    }
}