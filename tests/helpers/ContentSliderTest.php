<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentSliderTest extends TestCase
{
    private $header = 'Some slider description';
    private $items = [
        ['url' => 'http://example.com/image1.jpg', 'title' => 'Image title 1', 'link' => ''],
        ['url' => 'http://example.com/image2.jpg', 'title' => 'Image title 2', 'link' => ''],
        ['url' => 'http://example.com/image3.jpg'],
        ['href' => 'http://example.com/page1.html', 'title' => 'Link title 1', 'text' => 'Link text 1']
    ];

    public function testBaseSlider()
    {
        $slider = Content::slider($this->items);
        $baseSlider = "<div data-block=\"slider\" data-view=\"square\" data-item-view=\"cover\">
                      <figure>
                          <figcaption>Image title 1</figcaption>
                          <img src=\"http://example.com/image1.jpg\" />
                      </figure>
                      <figure>
                          <figcaption>Image title 2</figcaption>
                          <img src=\"http://example.com/image2.jpg\" />
                      </figure>
                      <figure>
                          <img src=\"http://example.com/image3.jpg\" />
                      </figure>
                      <figure>
                          <figcaption>Link title 1</figcaption>
                          <a href=\"http://example.com/page1.html\">Link text 1</a>
                      </figure>
                  </div>";

        $this->assertXmlStringEqualsXmlString($baseSlider, $slider);
    }

    public function testSliderWithHeader()
    {
        $slider = Content::slider($this->items, 'Slider header', Content::SLIDER_DATA_VIEW_PORTRAIT, Content::SLIDER_DATA_ITEM_VIEW_CONTAIN);
        $baseSlider = "<div data-block=\"slider\" data-view=\"portrait\" data-item-view=\"contain\">
                      <header>Slider header</header>
                      <figure>
                          <figcaption>Image title 1</figcaption>
                          <img src=\"http://example.com/image1.jpg\" />
                      </figure>
                      <figure>
                          <figcaption>Image title 2</figcaption>
                          <img src=\"http://example.com/image2.jpg\" />
                      </figure>
                      <figure>
                          <img src=\"http://example.com/image3.jpg\" />
                      </figure>
                      <figure>
                          <figcaption>Link title 1</figcaption>
                          <a href=\"http://example.com/page1.html\">Link text 1</a>
                      </figure>
                  </div>";

        $this->assertXmlStringEqualsXmlString($baseSlider, $slider);
    }
}