# php-file-stream

[![Build Status](https://travis-ci.org/zhelyabuzhsky/yii2-sitemap.svg)](https://travis-ci.org/pastuhov/php-file-stream)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zhelyabuzhsky/yii2-sitemap/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/php-file-stream/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/zhelyabuzhsky/yii2-sitemap/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/php-file-stream/?branch=master)
[![Total Downloads](https://poser.pugx.org/zhelyabuzhsky/yii2-sitemap/downloads)](https://packagist.org/packages/pastuhov/php-file-stream)

A PHP class to generate sitemap files for large web-sites or YML (Yandex Market Language) files

## Install

Via Composer

``` bash
$ composer require pastuhov/php-file-stream
```

## Features

* multiple sitemaps (large sites)
* fast and safe file replacement from tmp to public directory

## Usage

### Simple YML export

```php

    $stream = new FileStream(
        'export.yml',
        '/var/tmp',
        '/var/www'
    );

    $stream->write('<yml_catalog date="2010-04-01 17:00">');
    
    ...
    
    $stream->write('</yml_catalog>');
```

### Advanced usage (large site sitemap, >10k urls)

```php

    $stream = new FileStream(
        'sitemap{count}.xml',
        '/var/tmp',
        '/var/www'
        '<urlset>',
        '</urlset>',
        10000
    );

    foreach ($urls as $url) {
        $stream->write(
            '<url><loc>' . $url . '</loc></url>' . PHP_EOL
        );
    }

```

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email kirill@pastukhov.su instead of using the issue tracker.

## Credits

- [Kirill Pastukhov](https://github.com/pastuhov)
- [All Contributors](../../contributors)

## License

GNU General Public License, version 2. Please see [License File](LICENSE) for more information.

