# bubujka/cltr

Сбор в базу данных mysql информации по времени исполнения _всех_ страниц на сайте.


## Установка

Из консоли:
```bash
$ composer require bubujka/cltr=dev-master
```

Или в файле composer.json:
```json
"require": {
    "bubujka/cltr": "dev-master"
}
```


## Настройка

Где-то в коде приложения:
```php
<?php
cltr\pdo_host('localhost');
cltr\pdo_dbname('my_blog');
cltr\pdo_user('root');
cltr\pdo_password('OloloO111');
cltr\pdo_table('page_time');

cltr\start();
// и в конце выполнения
cltr\stop();
```

