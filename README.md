Краткая справка для проверяющего задание.
============================

Реализованные технологии:
-------------------

```php
 Yii2 basic
 Php7-fpm
 Nginx
 MySQL
 Ubuntu
```

Адрес сайта на котором реализован проект http://mayarossa.ru/ (I часть задания)

II практическая часть с SQL-запросами находится здесь http://mayarossa.ru/site/index


В проекте использовалась последняя версия фреймворка Yii2 в basic комплектации. Можно было использовать advanced,
где пользовательская и админская части разделены по разным приложениям, но для демонстрации модульного принципа
построения приложения, я использовал basic шаблон. Некоторые важние рабочие моменты, такие, как, например, обработка
исключений или контроль доступа я не стал реализовывать, т.к того не требовало задание.

**В 1 части проекта реализовано 2 модуля:**

- `admin` - админсткая часть / создание и редактирование новостей
- `users` - клиентская часть / Модуль вывода новостей