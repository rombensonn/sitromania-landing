# СитроМания 24/7

Одностраничный PHP-лендинг для автосервиса и выездной помощи в Коврове.

## Запуск локально

```bash
php -S 127.0.0.1:8000
```

Откройте `http://127.0.0.1:8000/`.

## Telegram-заявки

1. Скопируйте пример конфига:

```bash
cp config.example.php config.php
```

2. Заполните значения:

```php
const TELEGRAM_BOT_TOKEN = 'token-from-botfather';
const TELEGRAM_CHAT_ID = 'chat-id';
```

`config.php` добавлен в `.gitignore`, чтобы реальные ключи не попадали в репозиторий.

## Проверки

```bash
php -l index.php
php -l submit.php
php -l config.example.php
```

Фотографии в `assets/img/yandex/` и `images/yandex/` сохранены локально из карточки Яндекс Карт.

Анимации подключены через локальный ESM-бандл Framer Motion DOM в `assets/js/` и `js/`.

Логотипы марок сохранены локально в `assets/img/brands/` и `images/brands/` из Simple Icons и Wikimedia Commons.

## GitHub Pages

Для статического предпросмотра подготовлен `index.html` в корне репозитория. Он использует папки `css/`, `js/` и `images/`, поэтому GitHub Pages можно включать из ветки `main`, папка `/ (root)`.

PHP-версия с Telegram-отправкой остаётся в `index.php` и `submit.php`. На GitHub Pages форма работает в демо-режиме, потому что Pages не исполняет PHP.
