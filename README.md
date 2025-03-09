# VK Rest Api Template

## Описание

**VK Rest Api Template** – это бойлерплейт для быстрой разработки REST API на PHP с использованием MySQL.

## Технологии

- **PHP** – основной язык программирования.
- **MySQL** – база данных.
- **Composer** – управление зависимостями.
- **PHPUnit** – тестирование.
- **PHPStan** – статический анализ кода.

## Установка и запуск

### 1. Установка

Для установки зависимостей используйте [Composer](https://getcomposer.org/). Введите команду в терминале:

```bash
composer install
```

### 2. Настройка окружения

Перед запуском необходимо:

- Переименовать `.env.example` в `.env` и задать нужные параметры.
- Настройте сервер (Nginx или Apache) с конфигурацией из папки `server_configs`.
- Импортировать таблицу из папки `database_dump`.
- Запустите проект на вашем сервере.

## Скрипты

Проект включает несколько полезных скриптов, которые можно запускать с помощью Composer:
- route:cache – Генерация кеша маршрутов:
```bash
composer route:cache
```
- route:clear – Очистка кеша маршрутов:
```bash
composer route:clear
```
- phpunit:test – Запуск тестов с использованием PHPUnit:
```bash
composer phpunit:test
```
- phpstan:analyse – Статический анализ кода с помощью PHPStan:
```bash
composer phpstan:analyse
```
- composer:autoload-optimize – Оптимизация автозагрузки:
```bash
composer composer:autoload-optimize
```
- composer:autoload-optimize-prod – Оптимизация автозагрузки для продакшн-окружения:
```bash
composer composer:autoload-optimize-prod
```

## Полезные ссылки

- [PHP](https://www.php.net/docs.php)
- [Composer](https://getcomposer.org/doc)
- [PHPUnit](https://phpunit.de/documentation.html)
- [PHPStan](https://phpstan.org/user-guide/getting-started)

## Вклад

Ваши вклады приветствуются! Если вы хотите улучшить проект, пожалуйста, создайте pull request или откройте issue.

## Лицензия

Этот проект лицензирован под лицензией MPL-2.0. Подробнее см. в файле [LICENSE](LICENSE).

## Контакты

- **Автор:** Андрей Кузьмичев
- **Telegram:** [@bnull](https://t.me/bnull)

