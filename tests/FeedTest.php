<?php

namespace sokolnikov911\YandexTurboPages;

use Mockery;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class FeedTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private $channelInterface = '\sokolnikov911\YandexTurboPages\ChannelInterface';

    public function testCreateFeed()
    {
        $feed = new Feed();
        $this->assertObjectHasAttribute('encoding', $feed);
    }

    public function testFeedEncoding()
    {
        $feed = new Feed(Feed::ENCODING_UTF_8);
        $this->assertAttributeEquals('UTF-8', 'encoding', $feed);
    }

    public function testRenderFeed()
    {
        $feed = new Feed();
        $expectFeed = '<?xml version="1.0" encoding="UTF-8"?><rss xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/" xmlns:turbo="http://turbo.yandex.ru" version="2.0"/>';
        $this->assertXmlStringEqualsXmlString($feed->render(), $expectFeed);
    }

    public function testFeed__toString()
    {
        $feed = new Feed();
        $expectFeed = '<?xml version="1.0" encoding="UTF-8"?><rss xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/" xmlns:turbo="http://turbo.yandex.ru" version="2.0"/>';
        $this->assertXmlStringEqualsXmlString(strval($feed), $expectFeed);
    }

    public function testAddChannel()
    {
        $channel = Mockery::mock($this->channelInterface);
        $feed = new Feed();
        $this->assertSame($feed, $feed->addChannel($channel));
        $this->assertAttributeSame([$channel], 'channels', $feed);
    }
}
