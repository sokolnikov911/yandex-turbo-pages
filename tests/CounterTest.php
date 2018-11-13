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
        $counterUrl = uniqid();
        $counter = new Counter($counterType, $counterId, $counterUrl);
        $this->assertAttributeEquals($counterType, 'type', $counter);
        $this->assertAttributeEquals($counterId, 'id', $counter);
        $this->assertAttributeEquals($counterUrl, 'url', $counter);
    }

    public function testCustomCounter()
    {
        $counterType = Counter::TYPE_CUSTOM;
        $counterId = null;
        $counterUrl = uniqid();
        $counter = new Counter($counterType, $counterId, $counterUrl);
        $this->assertAttributeEquals($counterType, 'type', $counter);
        $this->assertAttributeEquals($counterId, 'id', $counter);
        $this->assertAttributeEquals($counterUrl, 'url', $counter);
    }

    public function testCustomCounterException()
    {
        $counterType = Counter::TYPE_CUSTOM;
        $counterId = null;
        $counterUrl = null;
        $this->expectException(\UnexpectedValueException::class);
        new Counter($counterType, $counterId, $counterUrl);
    }

    public function testNonCustomCounter()
    {
        $counterType = Counter::TYPE_YANDEX;
        $counterId = uniqid();
        $counterUrl = null;
        $counter = new Counter($counterType, $counterId, $counterUrl);
        $this->assertAttributeEquals($counterType, 'type', $counter);
        $this->assertAttributeEquals($counterId, 'id', $counter);
        $this->assertAttributeEquals($counterUrl, 'url', $counter);
    }

    public function testNonCustomCounterException()
    {
        $counterType = Counter::TYPE_YANDEX;
        $counterId = null;
        $counterUrl = null;
        $this->expectException(\UnexpectedValueException::class);
        new Counter($counterType, $counterId, $counterUrl);
    }

    public function testNonCustomCounterAsXML()
    {
        $counterType = uniqid();
        $counterId = uniqid();

        $counter = new Counter($counterType, $counterId);

        $expect = '
            <yandex:analytics id="' . $counterId . '" type="' . $counterType . '"/>
        ';
        $this->assertXmlStringEqualsXmlString($expect, $counter->asXML()->asXML());
    }

    public function testCustomCounterAsXML()
    {
        $counterType = Counter::TYPE_CUSTOM;
        $counterUrl = uniqid();

        $counter = new Counter($counterType, null, $counterUrl);

        $expect = '
            <yandex:analytics url="' . $counterUrl . '" type="' . $counterType . '"/>
        ';
        $this->assertXmlStringEqualsXmlString($expect, $counter->asXML()->asXML());
    }
}
