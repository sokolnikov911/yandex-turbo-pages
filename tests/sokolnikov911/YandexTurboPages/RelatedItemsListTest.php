<?php

namespace sokolnikov911\YandexTurboPages;

use PHPUnit\Framework\TestCase;

class RelatedItemsListTest extends TestCase
{
    public function testAppendTo()
    {
        $relatedItemsList = new RelatedItemsList();
        $item = new Item();
        $this->assertSame($relatedItemsList, $relatedItemsList->appendTo($item));
        $this->assertAttributeSame($relatedItemsList, 'relatedItemsList', $item);
    }

    public function testAddItem()
    {
        $relatedItem = new RelatedItem('Title', 'http://www.site.com/page.html'
            , 'http://www.site.com/image.jpg');
        $relatedItemsList = new RelatedItemsList();
        $this->assertSame($relatedItemsList, $relatedItemsList->addItem($relatedItem));
        $this->assertAttributeSame([$relatedItem], 'relatedItems', $relatedItemsList);
    }

    public function testAsXML()
    {
        $relatedItemsList = new RelatedItemsList();
        $expect = '<yandex:related/>';
        $this->assertXmlStringEqualsXmlString($expect, $relatedItemsList->asXML()->asXML());
    }

    public function testAsXMLWithRelatedPage()
    {
        $relatedItemsList = new RelatedItemsList();
        $relatedItem = new RelatedItem('Title', 'http://www.site.com/page.html'
            , 'http://www.site.com/image.jpg');
        $this->assertSame($relatedItemsList, $relatedItemsList->addItem($relatedItem));
        $expect = '
        <yandex:related>
            <link url="http://www.site.com/page.html" img="http://www.site.com/image.jpg">Title</link>
        </yandex:related>
        ';
        $this->assertXmlStringEqualsXmlString($expect, $relatedItemsList->asXML()->asXML());
    }
}
