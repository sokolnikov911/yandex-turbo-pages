<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentSocialShareTest extends TestCase
{
    private $networks = [Content::SHARE_TYPE_FACEBOOK, Content::SHARE_TYPE_TWITTER];

    public function testBaseShare()
    {
        $share = Content::share();
        $baseShare = '<div data-block="share"></div>';
        $this->assertXmlStringEqualsXmlString($baseShare, $share);
    }

    public function testParticularShare()
    {
        $share = Content::share($this->networks);
        $particularShare = '<div data-block="share" data-network="facebook,twitter"></div>';
        $this->assertXmlStringEqualsXmlString($particularShare, $share);
    }
}