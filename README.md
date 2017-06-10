# Transliterate
Небольшой пакет для транслитерации кирилицы :poop:

### Дисклеймер
>Работать - работает. Сорян, если что не так.

Умеет:
* строку в url ```['type' => 'url']```
* строку в имя файла ```['type' => 'filename']```

### Установка:
```
composer require elforastero/transliterate
```

```php
//config/app.php

'providers' => [
  //...
  ElForastero\Transliterate\TransliterationServiceProvider::class,
],

'aliases' => [
  //...
  'Transliterate' => ElForastero\Transliterate\TransliterationFacade::class,
],
```

### Использование:
```php
use Transliterate;
...

$string = '\'"#^_^ Если б мишки были пчёлами, то они бы нипочем, никогда и не подумали так высо́ко строить дом.';

$string = Transliterate::make($string);
// Esli b mishki bili pchyolami to oni bi nipochem nikogda i ne podumali tak visoko stroit dom

$string = Transliterate::make($string, ['type' => 'url', 'lowercase' => true]);
// esli-b-mishki-bili-pchyolami-to-oni-bi-nipochem-nikogda-i-ne-podumali-tak-visoko-stroit-dom

$string = Transliterate::make($string, ['type' => 'filename', 'lowercase' => true]);
// esli_b_mishki_bili_pchyolami_to_oni_bi_nipochem_nikogda_i_ne_podumali_tak_visoko_stroit_dom

$string = Transliterate::make($string, ['type' => 'url', 'lowercase' => true, 'map' => 'gost2000']);
// esli-b-mishki-by'li-pchyolami-to-oni-by'-nipochem-nikogda-i-ne-podumali-tak-vy'soko-stroit`-dom
```

### Доступные параметры:
```php
[
  'type' => 'url',
  // 'url', 'filename' или 'text'. Первым заменяем пробелы на '-', вторым на '_'.
  // По дефолту 'text', который ничего не заменяет.
  
  'lowercase' => true, // Преобразовать строку в нижний регистр.
  'map' => 'gost2000', // Транслитерация по ГОСТ 7.79-2000.
]
```

### Дополнительно
```php
// Получить карту транслитерации, используемую по-умолчанию
Transliteration::getDefaultMap();

// Карта по ГОСТ 2000
Transliteration::getGost2000Map();
```
