<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentCommentsTest extends TestCase
{
    private $commentsUrl = 'http://example.com/page.html';
    private $commentsArray = [
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

    public function testCommentsArray()
    {
        $comments = Content::comment($this->commentsUrl, $this->commentsArray);

        $commentsExpected = '
        <div data-block="comments" data-url="http://example.com/page.html">
            <div data-block="comment"
                data-author="First Author Name" 
                data-avatar-url="http://example.com/user1.jpg"
                data-subtitle="2017-12-10">
                    <div data-block="content">
                        <header>Comment Title</header>
                        <p>Somme comment text</p>
                    </div>                    
                    <div data-block="comments">
                        <div data-block="comment"
                            data-author="Third Author Name" 
                            data-avatar-url="http://example.com/user3.jpg"
                            data-subtitle="2017-12-12">
                                <div data-block="content">
                                    <header>Comment Title</header>
                                    <p>Some answer text</p>
                                </div>
                        </div>
                        <div data-block="comment"
                            data-author="Another Author Name" 
                            data-avatar-url="http://example.com/user4.jpg"
                            data-subtitle="2017-12-13">
                                <div data-block="content">
                                    <header>Comment Title</header>
                                    <p>Another answer text</p>
                                </div>
                        </div>
                    </div>
            </div>
            <div data-block="comment"
                data-author="Second Author Name" 
                data-avatar-url="http://example.com/user2.jpg"
                data-subtitle="2017-12-11">
                    <div data-block="content">
                        <header>Comment Title</header>
                        <p>Some comment text</p>
                    </div>
            </div>
        </div>';

        $this->assertXmlStringEqualsXmlString($commentsExpected, $comments);
    }
}