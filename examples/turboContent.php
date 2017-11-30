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
    ->appendTo($feed);


$turboHeader = new TurboContentHeader();
$turboHeader
    ->titleH1('Title H1')
    ->titleH2('Second title line')
    ->img('http://site.com/img.jpg');

$item = new Item();
$item
    ->title('Thirst page!')
    ->link('http://www.example.com/page1.html')
    ->author('John Smith')
    ->category('Technology')
    ->turboContent($turboHeader->asHTML() . 'Some content here!<br>Second content string.')
    ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
    ->appendTo($channel);

echo $feed;
