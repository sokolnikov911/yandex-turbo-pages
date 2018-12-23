<?php

namespace sokolnikov911\YandexTurboPages\helpers;

use sokolnikov911\YandexTurboPages\Channel;

class Content
{
    const SHARE_TYPE_FACEBOOK = 'facebook';
    const SHARE_TYPE_GOOGLE = 'google';
    const SHARE_TYPE_ODNOKLASSNIKI = 'odnoklassniki';
    const SHARE_TYPE_TELEGRAM = 'telegram';
    const SHARE_TYPE_TWITTER = 'twitter';
    const SHARE_TYPE_VKONTAKTE = 'vkontakte';

    const SLIDER_DATA_VIEW_SQUARE = 'square';
    const SLIDER_DATA_VIEW_PORTRAIT = 'portrait';
    const SLIDER_DATA_VIEW_LANDSCAPE = 'landscape';

    const SLIDER_DATA_ITEM_VIEW_COVER = 'cover';
    const SLIDER_DATA_ITEM_VIEW_CONTAIN = 'contain';

    const OWN_VIDEO_TYPE_MP4 = 'video/mp4';

    const ADDITIONAL_CONTENT_ORIENTATION_VERTICAL = 'vertical';
    const ADDITIONAL_CONTENT_ORIENTATION_HORIZONTAL = 'horizontal';

    const ADDITIONAL_CONTENT_THUMB_POSITION_LEFT = 'left';
    const ADDITIONAL_CONTENT_THUMB_POSITION_RIGHT = 'right';
    const ADDITIONAL_CONTENT_THUMB_POSITION_TOP = 'top';

    const ADDITIONAL_CONTENT_THUMB_RATIO_1_1 = '1x1';
    const ADDITIONAL_CONTENT_THUMB_RATIO_2_3 = '2x3';
    const ADDITIONAL_CONTENT_THUMB_RATIO_3_2 = '3x2';
    const ADDITIONAL_CONTENT_THUMB_RATIO_3_4 = '3x4';
    const ADDITIONAL_CONTENT_THUMB_RATIO_4_3 = '4x3';
    const ADDITIONAL_CONTENT_THUMB_RATIO_16_9 = '16x9';
    const ADDITIONAL_CONTENT_THUMB_RATIO_16_10 = '16x10';


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
     * Generate video element
     * @param string $videoUrl
     * @param string|null $videoCaption
     * @param string $imgUrl
     * @param string $type
     * @return string
     */
    public static function ownVideo(string $videoUrl, string $videoCaption = null, string $type = self::OWN_VIDEO_TYPE_MP4, string $imgUrl = null): string
    {
        $videoString = '<video><source src="' . $videoUrl . '" type="' . $type . '" /></video>';
        $videoString .= $imgUrl ? '<img src="' . $imgUrl . '" />' : '';
        $videoString .= $videoCaption ? '<figcaption>' . $videoCaption . '</figcaption>' : '';

        return '<figure>' . $videoString . '</figure>';
    }

    /**
     * Generate video element for external video
     * @param string $videoUrl
     * @param array $options Options Array with next variables: width, height, frameborder, allowfullscreen,
     * referrerpolicy, sandbox, hd. Options example:
     * [
     *  'width' => 640,
     *  'height' => 480,
     *  'frameborder' => 1,
     *  'allowfullscreen' => 'true',
     *  'referrerpolicy' => 'unsafe-url',
     *  'sandbox' => 'allow-forms allow-modals',
     *  'hd' => 3
     * ]
     * @return string
     */
    public static function externalVideo(string $videoUrl, array $options = []): string
    {
        $videoString = '<iframe src="' . $videoUrl . '"';

        foreach ($options as $key => $value) {
            $videoString .= ' ' . $key . '="' . $value . '"';
        }

        $videoString .= '></iframe>';

        return $videoString;
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
     * Generate media slider
     * @param array $itemsArray Array of items with data
     * [
     *     ['url' => 'http://example.com/image1.jpg', 'title' => 'Image title 1', 'link' => ''],
     *     ['url' => 'http://example.com/image2.jpg', 'title' => 'Image title 2', 'link' => ''],
     *     ['url' => 'http://example.com/image3.jpg'],
     *     ['href' => 'http://example.com/page1.html', 'title' => 'Link title 1', 'text' => 'Link text 1']
     * ]
     * @param string|null $header
     * @param string $dataView
     * @param string $dataItemView
     * @return string
     */
    public static function slider(array $itemsArray, string $header = null,
                                  string $dataView = self::SLIDER_DATA_VIEW_SQUARE,
                                  string $dataItemView = self::SLIDER_DATA_ITEM_VIEW_COVER): string
    {
        $sliderString = $header ? '<header>' . $header . '</header>' : '';

        $sliderString .= self::generateSliderItemsBlock($itemsArray);

        return '<div data-block="slider" data-view="' . $dataView . '" data-item-view="'
            . $dataItemView . '">' . $sliderString . '</div>';
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
     * Generate rating block
     * @param float $currentRating
     * @param float $maxRating
     * @return string
     */
    public static function rating(float $currentRating, float $maxRating): string
    {
        if (($currentRating > $maxRating) || ($maxRating <= 0) || ($currentRating < 0)) {
            throw new \UnexpectedValueException("Current rating can't be bigger than max value. And max value must be bigger than 0.");
        }

        return '<div itemscope="" itemtype="http://schema.org/Rating">
                       <meta itemprop="ratingValue" content="' . $currentRating . '" />
                       <meta itemprop="bestRating" content="' . $maxRating . '" />
                </div>';
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
        $textColorString = $textColor ? 'data-color="' . $textColor . '"' : '';
        $isBoldTextString = $isBoldText ? 'data-primary="true"' : '';
        $isDisabledString = $isDisabled ? 'disabled="true"' : '';

        return "<button
                    formaction=\"" . $formAction . "\"
                    " . $buttonColorString . "
                    " . $textColorString . "
                    " . $isBoldTextString . "
                    " . $isDisabledString . ">" . $text . "</button>";
    }

    /**
     * Generate comment block
     * @param string $url URL to comments page
     * @param array $commentsArray multidimensional or one-dimensional array of comments,
     * can has unlimited includes, example:
     * [
     *  [
     *      'author' => 'First Author Name',
     *      'avatar' => 'http://example.com/user1.jpg',
     *      'title' => 'Comment Title',
     *      'subtitle' => '2017-12-10',
     *      'content' => 'Somme comment text',
     *      'comments' => [
     *          [
     *              'author' => 'Third Author Name',
     *              'avatar' => 'http://example.com/user3.jpg',
     *              'title' => 'Comment Title',
     *              'subtitle' => '2017-12-12',
     *              'content' => 'Some answer text'
     *          ],
     *          [
     *              'author' => 'Another Author Name',
     *              'avatar' => 'http://example.com/user4.jpg',
     *              'title' => 'Comment Title',
     *              'subtitle' => '2017-12-13',
     *              'content' => 'Another answer text'
     *          ],
     *      ]
     *  ],
     *  [
     *      'author' => 'Second Author Name',
     *      'avatar' => 'http://example.com/user2.jpg',
     *      'title' => 'Comment Title',
     *      'subtitle' => '2017-12-11',
     *      'content' => 'Some comment text'
     *  ],
     * ]
     * @return string
     */
    public static function comment(string $url, array $commentsArray): string
    {
        $commentBlock = self::generateCommentBlock($commentsArray);

        return '<div data-block="comments" data-url="' . $url . '">' . $commentBlock . '</div>';
    }

    /**
     * Generate accordion
     * @param array $accordionArray array accordion elements
     * [
     *     ['title' => 'Page title 1', 'text' => 'Text 1'],
     *     ['title' => 'Page title 2', 'text' => 'Text 2', 'expanded' => true],
     * ]
     * @return string
     */
    public static function accordion(array $accordionArray): string
    {
        $accordionString = '<div data-block="accordion">';

        foreach ($accordionArray as $item) {
            $expanded = isset($item['expanded']) && $item['expanded'] ? ' data-expanded="true"' : '';
            $accordionString .= '<div data-block="item" data-title="' . $item['title'] . '"' . $expanded . '>' . $item['text'] . '</div>';
        }

        $accordionString .= '</div>';

        return $accordionString;
    }

    /**
     * Generate Ad block position element
     * @param string $turboAdId value of $turboAdId used in Channel() class
     * @return string
     *
     * @see Channel::$adTurboAdId
     */
    public static function adBlockPosition(string $turboAdId): string
    {
        return '<figure data-turbo-ad-id="' . $turboAdId . '"></figure>';
    }

    /**
     * Generate block with additional content
     * @param array $itemsArray Array of items with data
     * [
     *     [
     *          'href' => 'http://example.com/page1.html',
     *          'title' => 'Item title 1',
     *          'description' => 'Item description',
     *          'thumb' => 'http://example/image1.jpg',
     *          'thumb_position' => Content::ADDITIONAL_CONTENT_THUMB_POSITION_LEFT,
     *          'thumb_ratio' => Content::ADDITIONAL_CONTENT_THUMB_RATIO_1_1
     *     ],
     *     [
     *          'href' => 'http://example.com/page2.html',
     *          'title' => 'Item title 2'
     *     ],
     * ]
     * @param string|null $title
     * @param string|null $orientation
     * @return string
     * @throws \Exception
     */
    public static function additionalContent(array $itemsArray, string $title = null, string $orientation = null): string
    {
        $contentString = '<div data-block="feed"';

        $contentString .= $orientation ? ' data-layout="' . $orientation . '"' : '';
        $contentString .= $title ? ' data-title="' . $title . '"' : '';

        $contentString .= '>';

        return $contentString . self::generateAdditionalContentItemsList($itemsArray) . '</div>';
    }

    /**
     * Generate inline callback form
     * @param string $recipientEmail
     * @param string|null $companyName
     * @param string|null $linkToAgreement
     * @return string
     * @throws \Exception
     */
    public static function inlineCallbackForm(string $recipientEmail, string $companyName = null, string $linkToAgreement = null): string
    {
        if (($companyName && !$linkToAgreement) || (!$companyName && $linkToAgreement)) {
            throw new \Exception("You should use both 'companyName' and 'linkToAgreement' or nothing");
        }

        $contentString = '';

        $contentString .= $companyName ? ' data-agreement-company="' . $companyName . '"' : '';
        $contentString .= $linkToAgreement ? ' data-agreement-link="' . $linkToAgreement . '"' : '';

        return '<form data-type="callback" data-send-to="' . $recipientEmail . '" ' . $contentString . '></form>';
    }

    /**
     * Generate modal callback form
     * @param string $recipientEmail
     * @param string $buttonText
     * @param string|null $companyName
     * @param string|null $linkToAgreement
     * @param string|null $buttonColor Can be Text or HEX
     * @param string|null $textColor Can be Text or HEX
     * @param bool $isBoldText
     * @param bool $isDisabled
     * @return string
     * @throws \Exception
     */
    public static function modalCallbackForm(string $recipientEmail, string $buttonText, string $companyName = null, string $linkToAgreement = null,
                                             string $buttonColor = null, string $textColor = null,
                                             bool $isBoldText = false, bool $isDisabled = false): string
    {
        if (($companyName && !$linkToAgreement) || (!$companyName && $linkToAgreement)) {
            throw new \Exception("You should use both 'companyName' and 'linkToAgreement' or nothing");
        }

        $contentString = '';

        $contentString .= $companyName ? ' data-agreement-company="' . $companyName . '"' : '';
        $contentString .= $linkToAgreement ? ' data-agreement-link="' . $linkToAgreement . '"' : '';
        $contentString .= $buttonColor ? ' data-background-color="' . $buttonColor . '"' : '';
        $contentString .= $textColor ? ' data-color="' . $textColor . '"' : '';
        $contentString .= $isBoldText ? ' data-primary="true"' : '';
        $contentString .= $isDisabled ? ' disabled="true"' : '';

        return '<button data-send-to="' . $recipientEmail . '" ' . $contentString . '>' . $buttonText . '</button>';
    }

    /**
     * Generate search input
     * @param string $searchUrl Search engine URL in format https://example.com/search/{text}
     * @param string $placeholder
     * @return string
     */
    public static function searchInput(string $searchUrl, string $placeholder = ''): string
    {
        $placeholder = $placeholder ? 'placeholder="' . $placeholder . '"'  : '';

        return '<form action="' . $searchUrl . '" method="GET"><input type="search" name="text" ' . $placeholder . '/></form>';
    }

    /**
     * Generate content block for media slider
     * @param array $itemsArray Array of items with data
     * [
     *     ['url' => 'http://example.com/image1.jpg', 'title' => 'Image title 1', 'link' => ''],
     *     ['url' => 'http://example.com/image2.jpg', 'title' => 'Image title 2', 'link' => ''],
     *     ['url' => 'http://example.com/image3.jpg'],
     *     ['href' => 'http://example.com/page1.html', 'title' => 'Link title 1', 'text' => 'Link text 1']
     * ]
     * @return string
     */
    private static function generateSliderItemsBlock(array $itemsArray): string
    {
        $sliderString = '';

        foreach ($itemsArray as $item) {
            $sliderString .= '<figure>';

            if (isset($item['title'])) {
                $sliderString .= '<figcaption>' . $item['title'] . '</figcaption>';
            }

            if (isset($item['url'])) {
                $sliderString .= '<img src="' . $item['url'] . '" />';
            } elseif (isset($item['href'])) {
                $sliderString .= '<a href="' . $item['href'] . '">' . $item['text'] . '</a>';
            }

            $sliderString .= '</figure>';
        }

        return $sliderString;
    }

    private static function generateCommentBlock(array $commentsArray): string
    {
        $commentBlock = '';

        foreach ($commentsArray as $commentArray) {
            $author = isset($commentArray['author']) ? 'data-author="' . $commentArray['author'] . '"' : '';
            $avatar = isset($commentArray['avatar']) ? 'data-avatar-url="' . $commentArray['avatar'] . '"' : '';
            $subtitle = isset($commentArray['subtitle']) ? 'data-subtitle="' . $commentArray['subtitle'] . '"' : '';

            $commentBlock .= '<div
                        data-block="comment"
                        ' . $author . ' 
                        ' . $avatar . '
                        ' . $subtitle . '                         
                        ><div data-block="content">';

            $commentBlock .= isset($commentArray['title']) ? '<header>' . $commentArray['title'] . '</header>' : '';
            $commentBlock .= isset($commentArray['content']) ? '<p>' . $commentArray['content'] . '</p></div>' : '';

            if (isset($commentArray['comments'])) {
                $commentBlock .= '<div data-block="comments">';
                $commentBlock .= self::generateCommentBlock($commentArray['comments']);
                $commentBlock .= '</div>';
            }

            $commentBlock .= '</div>';
        }

        return $commentBlock;
    }

    /**
     * Generate header menu
     * @param array $menuArray array of arrays with pairs of url and title
     * [
     *     ['url' => 'http://example.com/page1.html', 'title' => 'Page title 1'],
     *     ['url' => 'http://example.com/page2.html', 'title' => 'Page title 2'],
     * ]
     * @return string
     */
    private static function generateMenu(array $menuArray): string
    {
        $menuString = '';

        foreach ($menuArray as $menuItem) {
            $menuString .= '<a href="' . $menuItem['url'] . '">' . $menuItem['title'] . '</a>';
        }

        return '<menu>' . $menuString . '</menu>';
    }

    /**
     * Generate additional content items list
     * @param array $itemsArray array of arrays with data of additional content items
     * [
     *     [
     *          'href' => 'http://example.com/page1.html',
     *          'title' => 'Item title 1',
     *          'description' => 'Item description',
     *          'thumb' => 'http://example/image1.jpg',
     *          'thumb_position' => Content::ADDITIONAL_CONTENT_THUMB_POSITION_LEFT,
     *          'thumb_ratio' => Content::ADDITIONAL_CONTENT_THUMB_RATIO_1_1
     *     ],
     *     [
     *          'href' => 'http://example.com/page2.html',
     *          'title' => 'Item title 2'
     *     ],
     * ]
     * @return string
     * @throws \Exception
     */
    private static function generateAdditionalContentItemsList(array $itemsArray): string
    {
        $itemsString = '';

        foreach ($itemsArray as $item) {

            if (!isset($item['href']) || !isset($item['title'])) {
                throw new \Exception("Title and Url attributes are required");
            }

            $itemsString .= '<div data-block="feed-item"
                data-href="' . $item['href'] . '"
                data-title="' . $item['title'] . '"';

            $itemsString .= isset($item['description']) ? ' data-description="' . $item['description'] . '"' : '';
            $itemsString .= isset($item['thumb']) ? ' data-thumb="' . $item['thumb'] . '"' : '';
            $itemsString .= isset($item['thumb_position']) ? ' data-thumb-position="' . $item['thumb_position'] . '"' : '';
            $itemsString .= isset($item['thumb_ratio']) ? ' data-thumb-ratio="' . $item['thumb_ratio'] . '"' : '';

            $itemsString .= '/>';
        }

        return $itemsString;
    }
}