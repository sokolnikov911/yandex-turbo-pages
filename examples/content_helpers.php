<?php

namespace sokolnikov911\YandexTurboPages\helpers;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// generate comments block

$commentsArray = [
    [
        'author' => 'First Author Name',
        'avatar' => 'http://example.com/user1.jpg',
        'title' => 'Comment Title',
        'subtitle' => '2017-12-10',
        'content' => 'Somme comment text',
        'comments' => [
            [
                'author' => 'Third Author Name',
                'avatar' => 'http://example.com/user3.jpg',
                'title' => 'Comment Title',
                'subtitle' => '2017-12-12',
                'content' => 'Some answer text'
            ],
            [
                'author' => 'Another Author Name',
                'avatar' => 'http://example.com/user4.jpg',
                'title' => 'Comment Title',
                'subtitle' => '2017-12-13',
                'content' => 'Another answer text'
            ],
        ]
    ],
    [
        'author' => 'Second Author Name',
        'avatar' => 'http://example.com/user2.jpg',
        'title' => 'Comment Title',
        'subtitle' => '2017-12-11',
        'content' => 'Some comment text'
    ],
];

$comments = Content::comment('http://example.com/page.html', $commentsArray);
echo $comments;