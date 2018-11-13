<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentOwnVideoTest extends TestCase
{
    private $videoUrl = 'http://example.com/video.mp4';
    private $imgUrl = 'http://example.com/img.jpg';
    private $videoCaption = 'Video Caption';

    public function testBaseVideo()
    {
        $video = Content::ownVideo($this->videoUrl);
        $baseVideo = '<figure><video><source src="' . $this->videoUrl . '" type="video/mp4" /></video></figure>';
        $this->assertXmlStringEqualsXmlString($baseVideo, $video);
    }

    public function testFullVideo()
    {
        $video = Content::ownVideo($this->videoUrl, $this->videoCaption, Content::OWN_VIDEO_TYPE_MP4, $this->imgUrl);
        $fullVideo = '<figure><video><source src="' . $this->videoUrl . '" type="video/mp4" /></video>' .
            '<img src="' . $this->imgUrl . '" />' .
            '<figcaption>' . $this->videoCaption . '</figcaption></figure>';
        $this->assertXmlStringEqualsXmlString($fullVideo, $video);
    }
}