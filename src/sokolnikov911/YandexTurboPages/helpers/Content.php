<?php

namespace sokolnikov911\YandexTurboPages\helpers;

class Content
{
    const SHARE_TYPE_FACEBOOK  = 'facebook';
    const SHARE_TYPE_GOOGLE    = 'google';
    const SHARE_TYPE_ODNOKLASSNIKI = 'odnoklassniki';
    const SHARE_TYPE_TELEGRAM  = 'telegram';
    const SHARE_TYPE_TWITTER   = 'twitter';
    const SHARE_TYPE_VKONTAKTE = 'vkontakte';

    /**
     * Generate header element
     * @param string $h1
     * @param string|null $h2
     * @param string|null $imgUrl
     * @param string|null $imgCaption
     * @param array|null $menuArray array of arrays with pairs of url and content
     * [
     *     ['url' => 'http://example/page1.html', 'title' => 'Page title 1'],
     *     ['url' => 'http://example/page2.html', 'title' => 'Page title 2'],
     * ]
     * @return string
     */
    public static function header(string $h1, string $h2 = null, string $imgUrl = null,
        string $imgCaption = null, array $menuArray = null): string
    {
        $header = '<h1>' . $h1 . '</h1>';
        $header .= $h2 ? '<h2>' . $h2 . '</h2>' : '';
        $header .= $menuArray ? self::generateMenu($menuArray) : '';
        $header .= $imgUrl ? self::img($imgUrl, $imgCaption) : '';

        return '<header>' . $header . '</header>';
    }

    /**
     * Generate image element
     * @param string $imgUrl
     * @param string|null $imgCaption
     * @return string
     */
    public static function img(string $imgUrl, string $imgCaption = null): string
    {
        $imageString = '<img src="' . $imgUrl . '" />';

        $imageString .= $imgCaption ? '<figcaption>' . $imgCaption . '</figcaption>' : '';

        return '<figure>' . $imageString . '</figure>';
    }

    /**
     * Generate images gallery
     * @param array $imagesArray Array of images urls
     * ['http://example.com/image1.jpg', 'http://example.com/image2.jpg']
     * @param string|null $header
     * @return string
     */
    public static function gallery(array $imagesArray, string $header = null): string
    {
        $galleryString = $header ? '<header>' . $header . '</header>' : '';

        foreach ($imagesArray as $image) {
            $galleryString .= '<img src="' . $image . '" />';
        }

        return '<div data-block="gallery">' . $galleryString . '</div>';
    }

    /**
     * Generate share block
     * @param array|null $networks Array of network names
     * [Content::SHARE_TYPE_GOOGLE, Content::SHARE_TYPE_TWITTER]
     * Can be empty, in this way all possible network types will be showed.
     * @return string
     */
    public static function share(array $networks = null): string
    {
        $networksString = $networks
            ? 'data-network="' . implode(',', $networks) . '"'
            : '';

        return '<div data-block="share" ' . $networksString . '></div>';
    }

    /**
     * Generate button
     * @param string $text
     * @param string $url
     * @param string $phone Phone number in RFC-3966 format
     * @param string|null $buttonColor Can be Text or HEX
     * @param string|null $textColor Can be Text or HEX
     * @param bool $isBoldText
     * @param bool $isDisabled
     * @return string
     */
    public static function button(string $text, string $url = '', string $phone = '',
                                  string $buttonColor = null, string $textColor = null,
                                  bool $isBoldText = false, bool $isDisabled = false): string
    {
        if (!$url && !$phone) {
            throw new \UnexpectedValueException('Please set url or phone number for button');
        }

        $formAction = $url ? $url : 'tel:' . $phone;
        $buttonColorString = $buttonColor ? 'data-background-color="' . $buttonColor . '"' : '';
        $textColorString   = $textColor   ? 'data-color="' . $textColor . '"' : '';
        $isBoldTextString  = $isBoldText  ? 'data-primary="true"' : '';
        $isDisabledString  = $isDisabled  ? 'disabled="true"' : '';

        return "<button
                    formaction=\"" . $formAction . "\"
                    " . $buttonColorString . "
                    " . $textColorString . "
                    " . $isBoldTextString . "
                    " . $isDisabledString . ">" . $text . "</button>";
    }

    /**
     * Generate header menu
     * @param array $menuArray array of arrays with pairs of url and title
     * [
     *     ['url' => 'http://example/page1.html', 'title' => 'Page title 1'],
     *     ['url' => 'http://example/page2.html', 'title' => 'Page title 2'],
     * ]
     * @return string
     */
    private static function generateMenu(array $menuArray)
    {
        $menuString = '';

        foreach ($menuArray as $menuItem) {
            $menuString .= '<a href="' . $menuItem['url'] . '">' . $menuItem['title'] . '</a>';
        }

        return '<menu>' . $menuString . '</menu>';
    }
}