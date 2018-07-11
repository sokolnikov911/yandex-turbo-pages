<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentRatingTest extends TestCase
{
    public function testRating()
    {
        $rating = Content::rating(3, 5);
        $code = "<div itemscope=\"\" itemtype=\"http://schema.org/Rating\">
                       <meta itemprop=\"ratingValue\" content=\"3\" />
                       <meta itemprop=\"bestRating\" content=\"5\" />
                   </div>";
        $this->assertXmlStringEqualsXmlString($rating, $code);
    }

    public function testBigCurrentValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        Content::rating(6, 5);
    }

    public function testIncorrectMaxValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        Content::rating(6, -1);
    }

    public function testZeroMaxValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        Content::rating(6, 0);
    }
}