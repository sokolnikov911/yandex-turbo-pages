<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentAccordionTest extends TestCase
{
    private $accordionArray = [
        ['title' => 'Page title 1', 'text' => 'Text 1'],
        ['title' => 'Page title 2', 'text' => 'Text 2', 'expanded' => true]
    ];

    public function testBaseHeader()
    {
        $accordion = Content::accordion($this->accordionArray);
        $baseAccordion = '<div data-block="accordion">
                       <div data-block="item" data-title="Page title 1">Text 1</div>
                       <div data-block="item" data-title="Page title 2" data-expanded="true">Text 2</div>
                   </div>';
        $this->assertXmlStringEqualsXmlString($baseAccordion, $accordion);
    }
}