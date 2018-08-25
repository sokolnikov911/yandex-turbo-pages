<?php

namespace sokolnikov911\YandexTurboPages;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$feed = new Feed();

/*
 Yandex Ad network (РСЯ)
 Just use adNetwork method with with ID of your RTB block.
 You can use third optional attribute of adNetwork method for selecting id of turboContent element
 in which Ad should placed (you also can use Content::adBlockPosition('') method for generate ad block position element
 in any place of your content).
 */

$channel = new Channel();
$channel
    ->title('Channel Title')
    ->link('http://blog.example.com')
    ->description('Channel Description')
    ->language('ru')
    ->adNetwork(Channel::AD_TYPE_YANDEX, 'RA-123456-7', 'first_ad_place')
    ->appendTo($feed);

echo $feed;
