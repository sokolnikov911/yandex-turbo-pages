<?php

namespace sokolnikov911\YandexTurboPages;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$feed = new Feed();

$channel = new Channel();
$channel
    ->title('Channel Title')
    ->link('http://blog.example.com')
    ->description('Channel Description')
    ->language('ru')
    ->adNetwork(Channel::AD_TYPE_YANDEX, 123456, 'first_ad_place')
    ->appendTo($feed);

$googleCounter = new Counter(Counter::TYPE_GOOGLE_ANALYTICS, 'XX-1234567-89');
$googleCounter->appendTo($channel);

$yandexCounter = new Counter(Counter::TYPE_YANDEX, 1234567);
$yandexCounter->appendTo($channel);

$item = new Item();
$item
    ->title('Thirst page!')
    ->link('http://www.example.com/page1.html')
    ->author('John Smith')
    ->category('Technology')
    ->turboContent('Some content here!<br>Second content string.')
    ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
    ->appendTo($channel);

$relatedItemsList = new RelatedItemsList();

$relatedItem = new RelatedItem('Related article 1', 'http://www.example.com/related1.html');
$relatedItem->appendTo($relatedItemsList);

$relatedItem = new RelatedItem('Related article 2', 'http://www.example.com/related2.html',
    'http://www.example.com/related2.jpg');
$relatedItem->appendTo($relatedItemsList);

$relatedItemsList
    ->appendTo($item);

$item = new Item();
$item
    ->title('Second page!')
    ->link('http://www.example.com/page2.html')
    ->author('John Smith')
    ->category('Technology')
    ->turboContent('Yet another content here!')
    ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
    ->appendTo($channel);

echo $feed;
