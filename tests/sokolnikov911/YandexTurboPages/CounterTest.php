<?php

namespace sokolnikov911\YandexTurboPages;

use PHPUnit\Framework\TestCase;

class CounterTest extends TestCase
{
    public function testAppendTo()
    {
        $counterType = uniqid();
        $counterId = uniqid();
        $counter = new Counter($counterType, $counterId);
        $channel = new Channel();
        $this->assertSame($counter, $counter->appendTo($channel));
        $this->assertAttributeSame([$counter], 'counters', $channel);
    }

    public function testCounterAttributes()
    {
        $counterType = uniqid();
        $counterId = uniqid();
        $counter = new Counter($counterType, $counterId);
        $this->assertAttributeEquals($counterType, 'type', $counter);
        $this->assertAttributeEquals($counterId, 'id', $counter);
    }

    public function testAsXML()
    {
        $counterType = uniqid();
        $counterId = uniqid();

        $counter = new Counter($counterType, $counterId);

        $expect = '
            <yandex:analytics id="' . $counterId . '" type="' . $counterType . '"/>
        ';
        $this->assertXmlStringEqualsXmlString($expect, $counter->asXML()->asXML());
    }
}
