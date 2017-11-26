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

// Google Analytics
$googleCounter = new Counter(Counter::TYPE_GOOGLE_ANALYTICS, 'XX-1234567-89');
$googleCounter->appendTo($channel);

// Yandex Metrika
$yandexCounter = new Counter(Counter::TYPE_YANDEX, 12345678);
$yandexCounter->appendTo($channel);

// Rambler TOP100
$googleCounter = new Counter(Counter::TYPE_RAMBLER, 1234567);
$googleCounter->appendTo($channel);

// TOP Mail.ru
$googleCounter = new Counter(Counter::TYPE_MAIL_RU, 1234567);
$googleCounter->appendTo($channel);

// Liveinternet
$yandexCounter = new Counter(Counter::TYPE_LIVE_INTERNET, 'SiteName');
$yandexCounter->appendTo($channel);

// Mediascope
$yandexCounter = new Counter(Counter::TYPE_MEDIASCOPE, 123456);
$yandexCounter->appendTo($channel);


echo $feed;
