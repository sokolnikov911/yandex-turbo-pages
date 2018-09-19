<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentExternalVideoTest extends TestCase
{
    private $videoUrl = 'http://example.com/video.mp4';
    private $options = [
        'width' => 640,
        'height' => 480,
        'frameborder' => 1,
        'allowfullscreen' => 'true',
        'referrerpolicy' => 'unsafe-url',
        'sandbox' => 'allow-forms allow-modals',
        'hd' => 3
    ];

    public function testBaseVideo()
    {
        $video = Content::externalVideo($this->videoUrl);
        $baseVideo = '<iframe src="' . $this->videoUrl . '"></iframe>';
        $this->assertXmlStringEqualsXmlString($baseVideo, $video);
    }

    public function testFullVideo()
    {
        $video = Content::externalVideo($this->videoUrl, $this->options);
        $fullVideo = '<iframe src="' . $this->videoUrl . '" width="640" height="480" frameborder="1" allowfullscreen="true"
            referrerpolicy="unsafe-url" sandbox="allow-forms allow-modals" hd="3"></iframe>';
        $this->assertXmlStringEqualsXmlString($fullVideo, $video);
    }
}