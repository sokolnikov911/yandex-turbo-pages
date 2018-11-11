PHP7 Yandex Turbo Pages RSS feed generator
=====================================

|  |  |
|----------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|  | [![Latest Stable Version](https://poser.pugx.org/sokolnikov911/yandex-turbo-pages/v/stable)](https://packagist.org/packages/sokolnikov911/yandex-turbo-pages) [![Total Downloads](https://poser.pugx.org/sokolnikov911/yandex-turbo-pages/downloads)](https://packagist.org/packages/sokolnikov911/yandex-turbo-pages) [![Latest Unstable Version](https://poser.pugx.org/sokolnikov911/yandex-turbo-pages/v/unstable)](https://packagist.org/packages/sokolnikov911/yandex-turbo-pages) [![composer.lock](https://poser.pugx.org/sokolnikov911/yandex-turbo-pages/composerlock)](https://packagist.org/packages/sokolnikov911/yandex-turbo-pages) [![PHPPackages Rank](http://phppackages.org/p/sokolnikov911/yandex-turbo-pages/badge/rank.svg)](http://phppackages.org/p/sokolnikov911/yandex-turbo-pages) [![PHPPackages Referenced By](http://phppackages.org/p/sokolnikov911/yandex-turbo-pages/badge/referenced-by.svg)](http://phppackages.org/p/sokolnikov911/yandex-turbo-pages) |
| Travis CI | [![Build Status](https://travis-ci.org/sokolnikov911/yandex-turbo-pages.svg?branch=master)](https://travis-ci.org/sokolnikov911/yandex-turbo-pages) |
| Scrutinizer CI | [![Build Status](https://scrutinizer-ci.com/g/sokolnikov911/yandex-turbo-pages/badges/build.png?b=master)](https://scrutinizer-ci.com/g/sokolnikov911/yandex-turbo-pages/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sokolnikov911/yandex-turbo-pages/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sokolnikov911/yandex-turbo-pages/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/sokolnikov911/yandex-turbo-pages/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sokolnikov911/yandex-turbo-pages/?branch=master) |

Russian version of README you can find here: [README_RU.md](https://github.com/sokolnikov911/yandex-turbo-pages/blob/master/README_RU.md).

Yandex Turbo Pages valid RSS feed generator for PHP 7+. In this version type hinting used, so you need
at least PHP 7.0.

Version for PHP 5.4 you can find [here](https://github.com/sokolnikov911/yandex-turbo-pages-php5).

## Examples

This example you can find in `examples/example.php`

```php
// creates Feed with all needed namespaces
$feed = new Feed();

// creates Channel with description and one ad from Yandex Ad Network
$channel = new Channel();
$channel
    ->title('Channel Title')
    ->link('http://blog.example.com')
    ->description('Channel Description')
    ->language('ru')
    ->adNetwork(Channel::AD_TYPE_YANDEX, 'RA-123456-7', 'first_ad_place')
    ->appendTo($feed);

// adds Google Analytics to feed
$googleCounter = new Counter(Counter::TYPE_GOOGLE_ANALYTICS, 'XX-1234567-89');
$googleCounter->appendTo($channel);

// adds Yandex Metrika to feed
$yandexCounter = new Counter(Counter::TYPE_YANDEX, 12345678);
$yandexCounter->appendTo($channel);

// creates first page of feed with link and enabled turbo, description and other content, and appends this page to channel
$item = new Item();
$item
    ->title('Thirst page!')
    ->link('http://www.example.com/page1.html')
    ->author('John Smith')
    ->category('Technology')
    ->turboContent('Some content here!<br>Second content string.')
    ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
    ->appendTo($channel);

// creates list of related pages
$relatedItemsList = new RelatedItemsList();

// adds link to first related page
$relatedItem = new RelatedItem('Related article 1', 'http://www.example.com/related1.html');
$relatedItem->appendTo($relatedItemsList);

// adds link to second related page with image
$relatedItem = new RelatedItem('Related article 2', 'http://www.example.com/related2.html',
    'http://www.example.com/related2.jpg');
$relatedItem->appendTo($relatedItemsList);

// appends list of related links to first page
$relatedItemsList
    ->appendTo($item);

// creates another one page with disabled turbo
$item = new Item(false);
$item
    ->title('Second page!')
    ->link('http://www.example.com/page2.html')
    ->author('John Smith')
    ->category('Technology')
    ->turboContent('Yet another content here!')
    ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
    ->appendTo($channel);

// displays the generated feed
echo $feed;
```

For generating content for turbo items you can use `Content` helper. For example:

```php
// generate header
$menuArray = [
    ['url' => 'http://example/page1.html', 'title' => 'Page title 1'],
    ['url' => 'http://example/page2.html', 'title' => 'Page title 2']
];
$header = Content::header('Main title', 'Second title',
    'http://example.com/image1.jpg', 'Image description', $menuArray);
```

At this time you can use helpers for generate next elements:
* page header including menu;
* image;
* images gallery;
* share buttons;
* link or phone button;
* comments;
* rating;
* accordion;
* video from own server;
* video from external server;
* ad block position element;
* media-content with slider;
* additional content block.

Examples of using helpers you can find in `examples/content_helpers.php`.


## Installing


```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of **yandex-turbo-pages**

```bash
php composer.phar require sokolnikov911/yandex-turbo-pages
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

You can then later update **yandex-turbo-pages** using composer:

 ```bash
composer.phar update
 ```
 
 
## Requirements

This Yandex Trurbo Pages RSS feed generator requires at least PHP 7.0 (yeahh, type hinting!).


## License

[![License](https://poser.pugx.org/sokolnikov911/yandex-turbo-pages/license)](https://packagist.org/packages/sokolnikov911/yandex-turbo-pages)

This library is licensed under the MIT License.