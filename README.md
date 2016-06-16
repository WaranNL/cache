# Waran Cache

## Demo
```php
use Waran\Cache;

$cache = new Cache;
if(!$cache->read('cache_name'))
{
    $cache->write('cache_name', 'cache_data'));
}

```


## About
Waran Cache is a simple cache class that saves your data in individual files.


## Install
```bash
composer require brysemeijer/cache 1.0.x-dev
```


## TODO
- automatic type detection (e.g. array, json, raw, etc.)
- travis-ci, scrutinizer, packaist images...


### License
This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

