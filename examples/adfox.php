<?php

namespace sokolnikov911\YandexTurboPages;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$feed = new Feed();

/*
 AdFox
 Just use adNetwork method with empty ID attribute.
 You can use third optional attribute of adNetwork method for selecting id of turboContent element
 in which Ad should placed (you also can use Content::adBlockPosition('') method for generate ad block position element
 in any place of your content).
 And don't forget to insert the AdFox banner code in the fourth attribute.
 */

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
$channel
    ->title('Channel Title')
    ->link('http://blog.example.com')
    ->description('Channel Description')
    ->language('ru')
    ->adNetwork(Channel::AD_TYPE_ADFOX, '', 'first_ad_place', $adFoxCode)
    ->appendTo($feed);

echo $feed;
