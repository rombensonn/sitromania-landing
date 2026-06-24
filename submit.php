<?php

declare(strict_types=1);

session_start();

$configPath = __DIR__ . '/config.php';
if (is_file($configPath)) {
    require $configPath;
}

header('X-Content-Type-Options: nosniff');

function wantsJson(): bool
{
    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    $requestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';

    return str_contains($accept, 'application/json') || strtolower($requestedWith) === 'xmlhttprequest';
}

function respond(bool $ok, string $message, int $status = 200): void
{
    http_response_code($status);

    if (wantsJson()) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok, 'message' => $message], JSON_UNESCAPED_UNICODE);
        exit;
    }

    header('Content-Type: text/html; charset=utf-8');
    $title = $ok ? 'Заявка отправлена' : 'Заявка не отправлена';
    $escapedTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $escapedMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    echo <<<HTML
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{$escapedTitle} | СитроМания 24/7</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="result-page">
  <main class="result-card">
    <p class="eyebrow">СитроМания 24/7</p>
    <h1>{$escapedTitle}</h1>
    <p>{$escapedMessage}</p>
    <a class="btn btn-primary" href="./#request">Вернуться на сайт</a>
  </main>
</body>
</html>
HTML;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Отправьте заявку через форму на сайте.', 405);
}

$name = trim((string)($_POST['name'] ?? ''));
$phone = trim((string)($_POST['phone'] ?? ''));
$service = trim((string)($_POST['service'] ?? ''));
$comment = trim((string)($_POST['comment'] ?? ''));
$agreement = (string)($_POST['agreement'] ?? '');
$website = trim((string)($_POST['website'] ?? ''));
$csrf = (string)($_POST['csrf_token'] ?? '');

if ($website !== '') {
    respond(true, 'Спасибо, заявка принята.');
}

$errors = [];
if (!hash_equals((string)($_SESSION['csrf_token'] ?? ''), $csrf)) {
    $errors[] = 'Обновите страницу и отправьте форму ещё раз.';
}
if ($name === '' || mb_strlen($name) < 2) {
    $errors[] = 'Укажите имя.';
}
if ($phone === '' || !preg_match('/^\+?[0-9\s()\-]{7,20}$/u', $phone)) {
    $errors[] = 'Укажите корректный телефон.';
}
if ($agreement !== '1') {
    $errors[] = 'Нужно согласие на обработку данных.';
}

if ($errors !== []) {
    respond(false, implode(' ', $errors), 422);
}

$token = defined('TELEGRAM_BOT_TOKEN') ? TELEGRAM_BOT_TOKEN : (string)getenv('TELEGRAM_BOT_TOKEN');
$chatId = defined('TELEGRAM_CHAT_ID') ? TELEGRAM_CHAT_ID : (string)getenv('TELEGRAM_CHAT_ID');

if ($token === '' || $chatId === '') {
    respond(false, 'Telegram не настроен. Создайте config.php по примеру config.example.php.', 500);
}

$cleanService = $service !== '' ? $service : 'Не выбрана';
$cleanComment = $comment !== '' ? $comment : 'Без комментария';
$page = $_SERVER['HTTP_REFERER'] ?? 'Прямая отправка';
$message = implode("\n", [
    '<b>Новая заявка с сайта СитроМания 24/7</b>',
    '',
    '<b>Имя:</b> ' . htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
    '<b>Телефон:</b> ' . htmlspecialchars($phone, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
    '<b>Услуга:</b> ' . htmlspecialchars($cleanService, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
    '<b>Комментарий:</b> ' . htmlspecialchars($cleanComment, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
    '',
    '<b>Страница:</b> ' . htmlspecialchars($page, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
]);

$payload = [
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'HTML',
    'disable_web_page_preview' => true,
];

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($payload, JSON_UNESCAPED_UNICODE),
        'timeout' => 8,
        'ignore_errors' => true,
    ],
]);

$url = 'https://api.telegram.org/bot' . $token . '/sendMessage';
$response = @file_get_contents($url, false, $context);
$statusLine = $http_response_header[0] ?? '';

if ($response === false || !str_contains($statusLine, '200')) {
    respond(false, 'Не удалось отправить заявку. Позвоните нам по телефону +7 (920) 926-78-71.', 502);
}

respond(true, 'Спасибо, заявка отправлена. Мы свяжемся с вами в ближайшее время.');
