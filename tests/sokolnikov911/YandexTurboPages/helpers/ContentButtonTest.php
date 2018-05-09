<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ContentButtonTest extends TestCase
{
    private $text = 'Button text';
    private $url = 'http://example.com/page.html';
    private $phone = '+7(123)456-78-90';
    private $textColor = 'black';
    private $buttonColor = 'green';
    private $isBoldText = true;
    private $isDisabled = true;

    public function testFullUrlButton()
    {
        $button = Content::button($this->text, $this->url, null, $this->buttonColor, $this->textColor,
            $this->isBoldText, $this->isDisabled);
        $fullButton = "<button
                    formaction=\"" . $this->url . "\"
                    data-background-color=\"" . $this->buttonColor . "\"
                    data-color=\"" . $this->textColor . "\"
                    data-primary=\"true\"
                    disabled=\"true\">" . $this->text . "</button>";
        $this->assertXmlStringEqualsXmlString($fullButton, $button);
    }

    public function testFullPhoneButton()
    {
        $button = Content::button($this->text, null, $this->phone, $this->buttonColor, $this->textColor,
            $this->isBoldText, $this->isDisabled);
        $fullButton = "<button
                    formaction=\"tel:" . $this->phone . "\"
                    data-background-color=\"" . $this->buttonColor . "\"
                    data-color=\"" . $this->textColor . "\"
                    data-primary=\"true\"
                    disabled=\"true\">" . $this->text . "</button>";
        $this->assertXmlStringEqualsXmlString($fullButton, $button);
    }

    public function testBaseButton()
    {
        $button = Content::button($this->text, $this->url);
        $baseButton = "<button
                    formaction=\"" . $this->url . "\">" . $this->text . "</button>";
        $this->assertXmlStringEqualsXmlString($baseButton, $button);
    }

    public function testButtonException()
    {
        $this->expectException(\UnexpectedValueException::class);
        Content::button($this->text);
    }
}