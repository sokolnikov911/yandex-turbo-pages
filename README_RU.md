PHP7 RSS feed генератор для Турбо-страниц Яндекса
=====================================

[![Latest Stable Version](https://poser.pugx.org/sokolnikov911/yandex-turbo-pages/v/stable)](https://packagist.org/packages/sokolnikov911/yandex-turbo-pages)
[![Total Downloads](https://poser.pugx.org/sokolnikov911/yandex-turbo-pages/downloads)](https://packagist.org/packages/sokolnikov911/yandex-turbo-pages)
[![Latest Unstable Version](https://poser.pugx.org/sokolnikov911/yandex-turbo-pages/v/unstable)](https://packagist.org/packages/sokolnikov911/yandex-turbo-pages)
[![License](https://poser.pugx.org/sokolnikov911/yandex-turbo-pages/license)](https://packagist.org/packages/sokolnikov911/yandex-turbo-pages)
[![composer.lock](https://poser.pugx.org/sokolnikov911/yandex-turbo-pages/composerlock)](https://packagist.org/packages/sokolnikov911/yandex-turbo-pages)


Генератор валидного RSS потока для Турбо-страниц Яндекса. Для этой работы этой версии пакета
необходим PHP как минимум 7 версии.


## Пример использования

Этот рабочий пример вы сможете найти в `examples/example.php`

```php
// Создает фид со всеми необходимыми неймспейсами
$feed = new Feed();

// создает канал с описанием и примером использования рекламного блока РСЯ, прикрепляет канал к фиду
$channel = new Channel();
$channel
    ->title('Channel Title')
    ->link('http://blog.example.com')
    ->description('Channel Description')
    ->language('ru')
    ->adNetwork(Channel::AD_TYPE_YANDEX, 1234567, 'first_ad_place')
    ->appendTo($feed);

// добавляем Гугл аналитику и прикрепляем к каналу
$googleCounter = new Counter(Counter::TYPE_GOOGLE_ANALYTICS, 'XX-1234567-89');
$googleCounter->appendTo($channel);

// добавляем счетчик Яндекс-метрики и прикрепляем к каналу
$yandexCounter = new Counter(Counter::TYPE_YANDEX, 12345678);
$yandexCounter->appendTo($channel);

// добавляем первую турбо-страницу с необходимым описанием и прикрепляем ее к каналу
$item = new Item();
$item
    ->title('Thirst page!')
    ->link('http://www.example.com/page1.html')
    ->author('John Smith')
    ->category('Technology')
    ->turboContent('Some content here!<br>Second content string.')
    ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
    ->appendTo($channel);

// создаем список связанный страниц (страницы по теме)
$relatedItemsList = new RelatedItemsList();

// добавляем первую связанную страницу в список
$relatedItem = new RelatedItem('Related article 1', 'http://www.example.com/related1.html');
$relatedItem->appendTo($relatedItemsList);

// добавляем вторую связанную страницу с картинкой в список
$relatedItem = new RelatedItem('Related article 2', 'http://www.example.com/related2.html',
    'http://www.example.com/related2.jpg');
$relatedItem->appendTo($relatedItemsList);

// прикрепляем список связанных страниц к турбо-странице
$relatedItemsList
    ->appendTo($item);

// создаем еще одну турбо-страницу
$item = new Item();
$item
    ->title('Second page!')
    ->link('http://www.example.com/page2.html')
    ->author('John Smith')
    ->category('Technology')
    ->turboContent('Yet another content here!')
    ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
    ->appendTo($channel);

// выводим XML код фида
echo $feed;
```



## Установка


```bash
# Устанавливаем Composer
curl -sS https://getcomposer.org/installer | php
```

Потом запускаем комманду композера для установки последней версии пакета **yandex-turbo-pages**

```bash
php composer.phar require sokolnikov911/yandex-turbo-pages
```

Подключаем автолоадер композора в файле, который является точкой входа в приложение (если это не было сделано ранее)

```php
require 'vendor/autoload.php';
```

Вы можете обновлять **yandex-turbo-pages** в любой момент используя composer:

 ```bash
composer.phar update
 ```
 
 
## Требования

Для RSS feed генератор для Турбо-страниц Яндекса требуется PHP версии не ниже 7,
т.к. в библиотеке используется полезнейшая штука − контроль типов.


## License

This library is licensed under the MIT License.