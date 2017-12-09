<?php

namespace sokolnikov911\YandexTurboPages;

use Mockery;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class ChannelTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private $itemInterface = '\sokolnikov911\YandexTurboPages\ItemInterface';
    private $counterInterface = '\sokolnikov911\YandexTurboPages\CounterInterface';

    public function testTitle()
    {
        $title = uniqid();
        $channel = new Channel();
        $this->assertSame($channel, $channel->title($title));
        $this->assertAttributeSame($title, 'title', $channel);
    }

    public function testLongTitle()
    {
        $longTitle = 'bLm9hNfgHXiMcn2RizL4UeYdVJZv3bYE5hesuRO7CBPXBobFjEq3v62Mo0nxMKLEC0qQugUl7p4iNZMRbzXLkPSdt92ANNYtVmFXIvemTiqiJ8sg0InzjUcybWu1tflOFlj160ncNHJ3UKECvX8iSRqSwm0om3KgTkolqtE4c1aXqQshEeZ3yyK6dfTmc71Ng6UKXXIHuczx2E327cZi90itBN19SPIG147GjdxBl4EOJq8gejojIHNAh15X0LTQhtcL';
        $title = mb_substr($longTitle, 0, 239) . '…';
        $channel = new Channel();
        $this->assertSame($channel, $channel->title($longTitle));
        $this->assertAttributeSame($title, 'title', $channel);
    }

    public function testLink()
    {
        $url = uniqid();
        $channel = new Channel();
        $this->assertSame($channel, $channel->link($url));
        $this->assertAttributeSame($url, 'link', $channel);
    }

    public function testDescription()
    {
        $description = uniqid();
        $channel = new Channel();
        $this->assertSame($channel, $channel->description($description));
        $this->assertAttributeSame($description, 'description', $channel);
    }

    public function testLanguage()
    {
        $language = uniqid();
        $channel = new Channel();
        $this->assertSame($channel, $channel->language($language));
        $this->assertAttributeSame($language, 'language', $channel);
    }

    public function testAdNetwork()
    {
        $type = uniqid();
        $id = uniqid();
        $turboAdId = uniqid();
        $code = uniqid();

        $channel = new Channel();
        $this->assertSame($channel, $channel->adNetwork($type, $id, $turboAdId, $code));
        $this->assertAttributeSame($type, 'adType', $channel);
        $this->assertAttributeSame($id, 'adId', $channel);
        $this->assertAttributeSame($turboAdId, 'adTurboAdId', $channel);
        $this->assertAttributeSame($code, 'adCode', $channel);
    }

    public function testAddItem()
    {
        $item = Mockery::mock($this->itemInterface);
        $channel = new Channel();
        $this->assertSame($channel, $channel->addItem($item));
        $this->assertAttributeSame([$item], 'items', $channel);
    }

    public function testAddCounter()
    {
        $counter = Mockery::mock($this->counterInterface);
        $channel = new Channel();
        $this->assertSame($channel, $channel->addCounter($counter));
        $this->assertAttributeSame([$counter], 'counters', $channel);
    }

    public function testAppendTo()
    {
        $channel = new Channel();
        $feed = new Feed();
        $this->assertSame($channel, $channel->appendTo($feed));
        $this->assertAttributeSame([$channel], 'channels', $feed);
    }

    /**
     * @param       $expect
     * @param array $data
     * @dataProvider dataForAsXML
     */
    public function testAsXML($expect, array $data)
    {
        $channel = new Channel();

        foreach ($data as $key => $value) {
            $channel->$key($value);
        }

        $this->assertXmlStringEqualsXmlString($expect, $channel->asXML()->asXML());
    }

    public static function dataForAsXML()
    {
        return [
            [
                "
                <channel>
                    <title>GoUpstate.com News Headlines</title>
                    <link/>
                    <description/>
                </channel>
                ",
                [
                    'title'       => "GoUpstate.com News Headlines"
                ]
            ],
            [
                "
                <channel>
                    <title>GoUpstate.com News Headlines</title>
                    <link>http://www.goupstate.com/</link>
                    <description/>
                </channel>
                ",
                [
                'title'       => "GoUpstate.com News Headlines",
                'link'        => 'http://www.goupstate.com/',
                ],
            ],
            [
                "
                <channel>
                    <title>GoUpstate.com News Headlines</title>
                    <link>http://www.goupstate.com/</link>
                    <description>The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.</description>
                </channel>
                ",
                [
                    'title'       => "GoUpstate.com News Headlines",
                    'link'        => 'http://www.goupstate.com/',
                    'description' => "The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.",
                ]
            ],
            [
                "
                <channel>
                    <title>GoUpstate.com News Headlines</title>
                    <link>http://www.goupstate.com/</link>
                    <description>The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.</description>
                    <language>ru</language>
                </channel>
                ",
                [
                    'title'       => "GoUpstate.com News Headlines",
                    'link'        => 'http://www.goupstate.com/',
                    'description' => "The latest news from GoUpstate.com, a Spartanburg Herald-Journal Web site.",
                    'language'    => 'ru',
                ]
            ]
        ];
    }

    public function testAsXMLWithYandexAd()
    {
        $channel = new Channel();
        $channel->adNetwork(Channel::AD_TYPE_YANDEX, 'RA-123456-7', 'first_ad_place');

        $expect = "
                <channel>
                    <title/>
                    <link/>
                    <description/>
                    <yandex:adNetwork xmlns:yandex=\"http://news.yandex.ru\" type=\"Yandex\" id=\"RA-123456-7\" turbo-ad-id=\"first_ad_place\"/>
                </channel>
        ";

        $this->assertXmlStringEqualsXmlString($expect, $channel->asXML()->asXML());
    }

    public function testAsXMLWithAdFox()
    {
        $adFoxCode = '<div id="идентификатор контейнера"></div>
        <script>
            window.Ya.adfoxCode.create({
                ownerId: 123456,
                containerId: \'идентификатор контейнера\',
                params: {
                    pp: \'g\',
                    ps: \'cmic\',
                    p2: \'fqem\'
                }
            });
        </script>';

        $channel = new Channel();
        $channel->adNetwork(Channel::AD_TYPE_ADFOX, '', 'first_ad_place', $adFoxCode);

        $expect = "
    <channel>
        <title/>
        <link/>
        <description/>
        <yandex:adNetwork xmlns:yandex=\"http://news.yandex.ru\" type=\"AdFox\" turbo-ad-id=\"first_ad_place\"><![CDATA[<div id=\"идентификатор контейнера\"></div>
        <script>
            window.Ya.adfoxCode.create({
                ownerId: 123456,
                containerId: 'идентификатор контейнера',
                params: {
                    pp: 'g',
                    ps: 'cmic',
                    p2: 'fqem'
                }
            });
        </script>]]></yandex:adNetwork>
    </channel>
        ";

        $this->assertXmlStringEqualsXmlString($expect, $channel->asXML()->asXML());
    }

    public function testAsXMLWithCounters()
    {
        $channel = new Channel();
        $yandexMetrika = new Counter(Counter::TYPE_YANDEX, 12345678);
        $yandexMetrika->appendTo($channel);

        $expect = "
                <channel>
                    <title/>
                    <link/>
                    <description/>
                    <yandex:analytics id=\"12345678\" type=\"Yandex\"/>
                </channel>
        ";

        $this->assertXmlStringEqualsXmlString($expect, $channel->asXML()->asXML());
    }
}
