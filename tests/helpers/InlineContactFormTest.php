<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use PHPUnit\Framework\TestCase;

class InlineContactFormTest extends TestCase
{
    private $email = 'email@domain.com';
    private $urlToAgreement = 'http://domain.com/agreement.html';
    private $companyName = 'Company Name';

    public function testAllFormOptions()
    {
        $form = Content::inlineCallbackForm($this->email, $this->companyName, $this->urlToAgreement);

        $fullForm = "<form
                    data-type=\"callback\"
                    data-send-to=\"" . $this->email . "\"
                    data-agreement-company=\"" . $this->companyName . "\"
                    data-agreement-link=\"" . $this->urlToAgreement . "\"></form>";

        $this->assertXmlStringEqualsXmlString($fullForm, $form);
    }

    public function testBaseModalForm()
    {
        $form = Content::inlineCallbackForm($this->email);

        $baseForm = "<form
                    data-type=\"callback\"
                    data-send-to=\"" . $this->email . "\"
                    ></form>";

        $this->assertXmlStringEqualsXmlString($baseForm, $form);
    }

    public function testExceptionWithoutCompanyName()
    {
        $this->expectException(\Exception::class);

        Content::inlineCallbackForm($this->email, null, $this->urlToAgreement);
    }

    public function testExceptionWithoutAgreement()
    {
        $this->expectException(\Exception::class);

        Content::inlineCallbackForm($this->email, $this->companyName, null);
    }
}