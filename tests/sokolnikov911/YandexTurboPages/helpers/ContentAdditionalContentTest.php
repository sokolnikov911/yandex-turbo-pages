<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentAdditionalContentTest extends TestCase
{
    private $items = [
        [
            'href' => 'http://example.com/page1.html',
            'title' => 'Item title 1',
            'description' => 'Item description',
            'thumb' => 'http://example/image1.jpg',
            'thumb_position' => Content::ADDITIONAL_CONTENT_THUMB_POSITION_LEFT,
            'thumb_ratio' => Content::ADDITIONAL_CONTENT_THUMB_RATIO_1_1
        ],
        [
            'href' => 'http://example.com/page2.html',
            'title' => 'Item title 2',
        ],
    ];

    public function testBaseAdditionalContentBlock()
    {
        $additionalContent = Content::additionalContent($this->items);
        $baseAdditionalContentBlock = "<div data-block=\"feed\">
    <div data-block=\"feed-item\"
        data-href=\"http://example.com/page1.html\"
        data-title=\"Item title 1\"
        data-thumb=\"http://example/image1.jpg\"
        data-thumb-position=\"left\"
        data-thumb-ratio=\"1x1\"
        data-description=\"Item description\"/>
    <div data-block=\"feed-item\"
        data-href=\"http://example.com/page2.html\"
        data-title=\"Item title 2\"/>
</div>";

        $this->assertXmlStringEqualsXmlString($baseAdditionalContentBlock, $additionalContent);
    }

    public function testAdditionalContentBlock()
    {
        $additionalContent = Content::additionalContent($this->items, 'Block title', Content::ADDITIONAL_CONTENT_ORIENTATION_HORIZONTAL);
        $baseAdditionalContentBlock = "<div data-block=\"feed\" data-layout=\"horizontal\" data-title=\"Block title\">
    <div data-block=\"feed-item\"
        data-href=\"http://example.com/page1.html\"
        data-title=\"Item title 1\"
        data-thumb=\"http://example/image1.jpg\"
        data-thumb-position=\"left\"
        data-thumb-ratio=\"1x1\"
        data-description=\"Item description\"/>
    <div data-block=\"feed-item\"
        data-href=\"http://example.com/page2.html\"
        data-title=\"Item title 2\"/>
</div>";

        $this->assertXmlStringEqualsXmlString($baseAdditionalContentBlock, $additionalContent);
    }

    public function testExceptionWithoutHref()
    {
        $items = [
        [
            'title' => 'Item title 1'
        ],
    ];

        $this->expectException(\Exception::class);
        Content::additionalContent($items);
    }

    public function testExceptionWithoutTitle()
    {
        $items = [
            [
                'href' => 'http://example.com/page1.html'
            ],
        ];

        $this->expectException(\Exception::class);
        Content::additionalContent($items);
    }
}