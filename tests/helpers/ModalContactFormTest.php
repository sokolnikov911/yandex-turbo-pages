<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class ModalContactFormTest extends TestCase
{
    private $email = 'email@domain.com';
    private $text = 'Request callback';
    private $urlToAgreement = 'http://domain.com/agreement.html';
    private $companyName = 'Company Name';
    private $textColor = 'black';
    private $buttonColor = 'green';
    private $isBoldText = true;
    private $isDisabled = true;

    public function testAllFormOptions()
    {
        $form = Content::modalCallbackForm($this->email, $this->text, $this->companyName, $this->urlToAgreement,
            $this->buttonColor, $this->textColor, $this->isBoldText, $this->isDisabled);

        $fullForm = "<button
                    data-send-to=\"" . $this->email . "\"
                    data-agreement-company=\"" . $this->companyName . "\"
                    data-agreement-link=\"" . $this->urlToAgreement . "\"
                    data-background-color=\"" . $this->buttonColor . "\"
                    data-color=\"" . $this->textColor . "\"
                    data-primary=\"true\"
                    disabled=\"true\">" . $this->text . "</button>";

        $this->assertXmlStringEqualsXmlString($fullForm, $form);
    }

    public function testBaseModalForm()
    {
        $form = Content::modalCallbackForm($this->email, $this->text);

        $baseForm = "<button
                    data-send-to=\"" . $this->email . "\">" . $this->text . "</button>";

        $this->assertXmlStringEqualsXmlString($baseForm, $form);
    }

    public function testExceptionWithoutCompanyName()
    {
        $this->expectException(\Exception::class);

        Content::modalCallbackForm($this->email, $this->text, null, $this->urlToAgreement);
    }

    public function testExceptionWithoutAgreement()
    {
        $this->expectException(\Exception::class);

        Content::modalCallbackForm($this->email, $this->text, $this->companyName, null);
    }
}