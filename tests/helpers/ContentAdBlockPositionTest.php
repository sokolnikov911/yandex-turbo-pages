<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentAdBlockPositionTest extends TestCase
{
    public function testAdBlockPosition()
    {
        $adBlockPositionGenerated = Content::adBlockPosition('first_ad_place');
        $adBlockPositionExample = '<figure data-turbo-ad-id="first_ad_place"></figure>';
        $this->assertXmlStringEqualsXmlString($adBlockPositionExample, $adBlockPositionGenerated);
    }
}