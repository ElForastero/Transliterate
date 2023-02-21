## Transliterate

![GitHub](https://img.shields.io/github/license/mashape/apistatus.svg)
![GitHub release](https://img.shields.io/github/release/elforastero/transliterate.svg)
![Packagist](https://img.shields.io/packagist/dt/elforastero/transliterate.svg)

Небольшой пакет для транслитерации кириллицы с возможностью создания своих собственных карт транслитерации.

![Code example](example.png)

- [Предустановленные карты](#Предустановленные-карты)
- [Системные требования](#Системные-требования)
- [Установка](#Установка)
- [Конфигурация](#Конфигурация)
- [Использование](#Использование)
- [Создание карт транслитерации](#Создание-карт-транслитерации)
- [Создание трансформеров](#Создание-трансформеров)

## Предустановленные карты

- Русский
    - Дефолтная
    - ГОСТ 7.79 2000
- Украинский
    - Национальная


## Системные требования
- laravel >= 5.6
- ext-intl

## Установка
```
> composer require elforastero/transliterate
```

> ⚠️ Для Laravel v5 используйте ветку v2: `composer require elforastero/transliterate "^2.0"`

Laravel начиная с версии *5.5* не нуждается в дополнительной конфигурации благодаря механизму Package Discovery.

Если вы не используте Package Discovery, необходимо зарегистрировать `Service Provider`, добавив его в массив `providers`, конфигурационного файла `app.php`.

```php
ElForastero\Transliterate\ServiceProvider::class,
```

Если вы хотите использовать алиас, добавьте его в массив `facades` в `app.php`.

Рекомендую в качестве алиаса использовать `Transliterate`, чтобы избежать конфликтов с Transliterator классом из расширения Intl.

```php
'Transliterate' => ElForastero\Transliterate\Facade::class,
```

## Конфигурация

Для копирования конфига `transliterate.php` в директорию `configs` выполните

```
> php artisan vendor:publish --provider="ElForastero\Transliterate\ServiceProvider"
```

## Использование

Вы можете использовать фасад для транслитерации строк.

```php
use Transliterate;

Transliterate::make('Двадцать тысяч льё под водой');
// "Dvadcat tisyach lyo pod vodoy"
```

Альтернативная карта транслитерации может быть передана вторым параметром.

```php
use ElForastero\Transliterate\Transliterator;

$transliterator = new Transliterator(Map::LANG_RU, Map::GOST_7_79_2000);
$transliterator->make('Двадцать тысяч льё под водой');
// "Dvadcat` ty'syach l`yo pod vodoj"
```

## Генерация URL

Метод `slugify` генерирует URL, убирая из строки все знаки препинания и заменяя пробелы на "-".

```php
Transliterate::slugify('Съешь еще этих мягких французских булок, да выпей чаю!');
// sesh-eshhe-etih-myagkih-francuzskih-bulok-da-vipey-chayu
```

## Создание карт транслитерации

Каждая карта представляет собой ассоциативный массив с символами подлежащими замене в качестве ключей, и значениями на которые они будут заменены.

Карта создается в виде отдельного файла с возвращаемым массивом:

```php
// /resources/maps/ua/ukraine.php

return [
    'ї' => 'i',
    'і' => 'i',
    'є' => 'ie',
];
```

Добавьте путь к созданной карте в массив `maps`, конфига `transliterate.php`:

```php
'ua' => [
    'ukraine' => dirname(__DIR__) . '/resources/maps/ua/ukraine.php',
]
```

После этого карту можно использовать.

```php
$transliterator = new Transliterator('ua', 'ukraine');
$transliterator->make('Ваша транслітерація');
```

## Создание трансформеров

Трансформеры - функции которые будут автоматически применены к результату транслитерации. Полезно если вам необходимо каждый раз производить одни и те же действия с транслитерируемой строкой. Регистрируется трансформер в массиве `transformers`.

Например, можно автоматечески убирать конечные пробелы.

```php
ElForastero\Transliterate\Transformer::register(\Closure::fromCallable('trim')),
```

Или дополнительно приводить строки к нижнему регистру.

```php
ElForastero\Transliterate\Transformer::register(\Closure::fromCallable('trim')),
ElForastero\Transliterate\Transformer::register(\Closure::fromCallable('strtolower')),
```

> Будьте внимательны, поскольку трансформеры применяются при каждом вызове `Transliterator::make`.

### Разработка

Для прогона PHPUnit тестов можно воспользоваться лежащим в корне Dockerfile:

```bash
docker-compose up --build

...
php_1  | Runtime:       PHP 8.0.22
php_1  | Configuration: /srv/app/phpunit.xml
php_1  |
php_1  | .....                                                               5 / 5 (100%)
php_1  |
php_1  | Time: 00:00.959, Memory: 14.00 MB
php_1  |
php_1  | OK (5 tests, 6 assertions)
```
