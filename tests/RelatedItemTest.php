<?php

namespace sokolnikov911\YandexTurboPages;

use PHPUnit\Framework\TestCase;

class RelatedItemTest extends TestCase
{
    public function testAppendTo()
    {
        $relatedItem = new RelatedItem('Title', 'http://site.com/page.html', 'http://site.com/img.jpg');
        $relatedItemsList = new RelatedItemsList();
        $this->assertSame($relatedItem, $relatedItem->appendTo($relatedItemsList));
        $this->assertAttributeSame([$relatedItem], 'relatedItems', $relatedItemsList);
    }

    public function testAttributes()
    {
        $relatedItem = new RelatedItem('Title', 'http://site.com/page.html', 'http://site.com/img.jpg');
        $this->assertAttributeEquals('Title', 'title', $relatedItem);
        $this->assertAttributeEquals('http://site.com/page.html', 'link', $relatedItem);
        $this->assertAttributeEquals('http://site.com/img.jpg', 'img', $relatedItem);
    }

    public function testAsXML()
    {
        $relatedItem = new RelatedItem('Title', 'http://site.com/page.html', 'http://site.com/img.jpg');
        $expect = '<link url="http://site.com/page.html" img="http://site.com/img.jpg">Title</link>';
        $this->assertXmlStringEqualsXmlString($expect, $relatedItem->asXML()->asXML());
    }
}
