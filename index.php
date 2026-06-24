<?php

declare(strict_types=1);

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$phoneDisplay = '+7 (920) 926-78-71';
$phoneHref = '+79209267871';
$address = 'Владимирская область, Ковров, ул. Урицкого, 14А';
$mapsUrl = 'https://yandex.ru/maps/org/sitromaniya_24_7/31728976855/';
$routeUrl = 'https://yandex.ru/maps/?rtext=~56.376500,41.306262&rtt=auto';
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
$scheme = $isHttps ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'sitromania24-7.ru';
$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
$baseUrl = $scheme . '://' . $host . ($scriptDir === '' ? '/' : $scriptDir . '/');
$canonicalUrl = $baseUrl;

$services = [
    [
        'title' => 'Выездной сервис и диагностика',
        'lead' => 'Приезжаем к автомобилю, находим причину неисправности и помогаем решить, ехать дальше или в сервис.',
        'for' => 'Для водителей, которые застряли на трассе, во дворе, у работы или приехали в Ковров транзитом.',
        'why' => 'Круглосуточный выезд, инструменты с собой, спокойное объяснение проблемы и вариантов ремонта.',
    ],
    [
        'title' => 'Выездной шиномонтаж',
        'lead' => 'Помощь при проколе, повреждении колеса, проблемах с запаской и срочной заменой резины.',
        'for' => 'Когда колесо подвело ночью, на объездной дороге или нет возможности доехать до шиномонтажа.',
        'why' => 'Быстро приезжаем, подбираем решение на месте и держим адекватную цену даже в позднее время.',
    ],
    [
        'title' => 'ТО, масло и ГРМ',
        'lead' => 'Плановое обслуживание: замена масла, фильтров, ремня или цепи ГРМ, проверка основных узлов.',
        'for' => 'Для тех, кто хочет пройти обслуживание без сюрпризов и не доводить машину до дорогого ремонта.',
        'why' => 'Подскажем по запчастям, выполним работу аккуратно и объясним, что действительно стоит менять.',
    ],
    [
        'title' => 'Ходовая, тормоза и рулевое',
        'lead' => 'Диагностика и ремонт подвески, амортизаторов, шаровых, тормозной системы и рулевых реек.',
        'for' => 'Если появились стуки, вибрации, увод автомобиля, скрежет при торможении или люфт руля.',
        'why' => 'Опыт с легковыми, коммерческими и разными марками: от ВАЗ и УАЗ до Citroen, Renault, Toyota, BMW.',
    ],
    [
        'title' => 'Двигатель, охлаждение и выхлоп',
        'lead' => 'Ремонт двигателя, эндоскопия, система охлаждения, удаление катализаторов и выхлопная система.',
        'for' => 'Когда двигатель троит, перегревается, теряет тягу, дымит или появились ошибки по выхлопу.',
        'why' => 'Начинаем с диагностики, чтобы не менять лишнее и сразу выбрать понятный план работ.',
    ],
    [
        'title' => 'Электрика, стартеры и генераторы',
        'lead' => 'Ремонт автоэлектрики и электроники, проверка зарядки, стартера, генератора и цепей питания.',
        'for' => 'Если машина не заводится, садится аккумулятор, пропадает свет или появляются ошибки на панели.',
        'why' => 'Выезжаем к автомобилю, проверяем питание и помогаем оживить машину без лишней эвакуации.',
    ],
    [
        'title' => 'КПП, сцепление и АКПП',
        'lead' => 'Ремонт сцепления, коробок передач и связанных узлов трансмиссии.',
        'for' => 'Когда передачи включаются тяжело, появились рывки, шумы, пробуксовка или течи.',
        'why' => 'Честно объясняем объём работ и заранее обсуждаем запчасти, сроки и стоимость.',
    ],
    [
        'title' => 'Кузов, покраска, полировка, фаркоп',
        'lead' => 'Кузовной ремонт, покраска, полировка автомобиля и установка фаркопа.',
        'for' => 'Для восстановления внешнего вида, подготовки авто к продаже или установки полезного оборудования.',
        'why' => 'Можно совместить с диагностикой и обслуживанием, чтобы решить несколько задач за один визит.',
    ],
];

$advantages = [
    ['title' => 'Работаем 24/7', 'text' => 'Можно звонить ночью, в выходные и в дороге. В аварийной ситуации важна не вывеска, а реальная помощь.'],
    ['title' => 'Выезд к автомобилю', 'text' => 'Диагностика и часть работ возможны на месте, без немедленной эвакуации и лишних расходов.'],
    ['title' => 'Понятная цена', 'text' => 'Клиенты отмечают демократичные цены и соответствие стоимости качеству работ.'],
    ['title' => 'Широкий профиль', 'text' => 'От шиномонтажа и ТО до двигателя, электрики, подвески, КПП и кузовных работ.'],
];

$reviews = [
    ['name' => 'Соня Елагина', 'text' => 'Ночью помогли на дороге под Ковровом, быстро нашли причину поломки, организовали запчасти и вернули автомобиль в строй.'],
    ['name' => 'Дарья', 'text' => 'Мастер оперативно выехал, приехал с нужными инструментами и запчастью, работа была сделана быстро и качественно.'],
    ['name' => 'Илья Давыдов', 'text' => 'Быстро приехали, помогли с резиной и решили вопрос за адекватную цену. Клиент отмечает, что обратится снова.'],
    ['name' => 'Белоусова', 'text' => 'После повреждения двух колёс на дороге мастер приехал поздно вечером со всем нужным инструментом и помог на месте.'],
    ['name' => 'Василий Трифонов', 'text' => 'Отмечает профессионализм мастера и готовность выехать ночью, когда помощь нужна прямо на дороге.'],
    ['name' => 'Александр', 'text' => 'Понравилось, что сначала объяснили причину неисправности, а потом согласовали понятный план ремонта.'],
    ['name' => 'Марина', 'text' => 'Обращалась по срочной диагностике: быстро приняли, спокойно всё рассказали и не навязывали лишние работы.'],
    ['name' => 'Дмитрий', 'text' => 'Выручили с ходовой и тормозами, подобрали запчасти и вернули машину без затянутых сроков.'],
    ['name' => 'Никита', 'text' => 'Удобно, что можно решить вопрос с ТО, электрикой и шиномонтажом в одном сервисе, даже в нестандартное время.'],
];

$brands = [
    ['name' => 'Citroen', 'logo' => 'assets/img/brands/citroen.svg'],
    ['name' => 'Peugeot', 'logo' => 'assets/img/brands/peugeot.svg'],
    ['name' => 'Renault', 'logo' => 'assets/img/brands/renault.svg'],
    ['name' => 'Lada', 'logo' => 'assets/img/brands/lada.svg'],
    ['name' => 'ВАЗ', 'logo' => 'assets/img/brands/vaz.svg'],
    ['name' => 'УАЗ', 'logo' => 'assets/img/brands/uaz.jpg'],
    ['name' => 'Toyota', 'logo' => 'assets/img/brands/toyota.svg'],
    ['name' => 'Nissan', 'logo' => 'assets/img/brands/nissan.svg'],
    ['name' => 'Kia', 'logo' => 'assets/img/brands/kia.svg'],
    ['name' => 'Hyundai', 'logo' => 'assets/img/brands/hyundai.svg'],
    ['name' => 'Ford', 'logo' => 'assets/img/brands/ford.svg'],
    ['name' => 'Volkswagen', 'logo' => 'assets/img/brands/volkswagen.svg'],
    ['name' => 'Opel', 'logo' => 'assets/img/brands/opel.svg'],
    ['name' => 'Mitsubishi', 'logo' => 'assets/img/brands/mitsubishi.svg'],
    ['name' => 'Chevrolet', 'logo' => 'assets/img/brands/chevrolet.svg'],
    ['name' => 'BMW', 'logo' => 'assets/img/brands/bmw.svg'],
    ['name' => 'Mercedes-Benz', 'logo' => 'assets/img/brands/mercedes-benz.svg'],
    ['name' => 'Haval', 'logo' => 'assets/img/brands/haval.svg'],
    ['name' => 'Omoda', 'logo' => 'assets/img/brands/omoda.svg'],
    ['name' => 'Changan', 'logo' => 'assets/img/brands/changan.svg'],
    ['name' => 'EXEED', 'logo' => 'assets/img/brands/exeed.png'],
    ['name' => 'Коммерческий транспорт', 'logo' => 'assets/img/brands/commercial.jpg'],
];

$photos = [
    ['src' => 'assets/img/yandex/service-1.webp', 'alt' => 'Фото автосервиса СитроМания 24/7 из карточки Яндекс Карт'],
    ['src' => 'assets/img/yandex/service-2.webp', 'alt' => 'Рабочая зона автосервиса СитроМания 24/7'],
    ['src' => 'assets/img/yandex/service-3.webp', 'alt' => 'Ремонт автомобиля в СитроМания 24/7'],
    ['src' => 'assets/img/yandex/service-4.webp', 'alt' => 'Оборудование автосервиса СитроМания 24/7'],
    ['src' => 'assets/img/yandex/service-5.webp', 'alt' => 'Фото работ автосервиса СитроМания 24/7'],
    ['src' => 'assets/img/yandex/service-6.webp', 'alt' => 'Автомобиль на обслуживании в СитроМания 24/7'],
];

$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'AutoRepair',
    'name' => 'СитроМания 24/7',
    'url' => $canonicalUrl,
    'telephone' => $phoneDisplay,
    'image' => array_map(static fn(array $photo): string => $baseUrl . ltrim($photo['src'], '/'), $photos),
    'address' => [
        '@type' => 'PostalAddress',
        'addressCountry' => 'RU',
        'addressRegion' => 'Владимирская область',
        'addressLocality' => 'Ковров',
        'streetAddress' => 'улица Урицкого, 14А',
    ],
    'geo' => [
        '@type' => 'GeoCoordinates',
        'latitude' => 56.376500,
        'longitude' => 41.306262,
    ],
    'openingHours' => 'Mo-Su 00:00-23:59',
    'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => '4.8',
        'ratingCount' => '24',
        'reviewCount' => '19',
    ],
    'makesOffer' => array_map(static fn(array $service): array => [
        '@type' => 'Offer',
        'itemOffered' => [
            '@type' => 'Service',
            'name' => $service['title'],
            'description' => $service['lead'],
        ],
    ], $services),
];

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>СитроМания 24/7 в Коврове | Автосервис, выездная помощь, шиномонтаж</title>
  <meta name="description" content="Круглосуточный автосервис СитроМания 24/7 в Коврове: выездная помощь, диагностика, шиномонтаж, ТО, ремонт ходовой, двигателя, электрики и КПП.">
  <link rel="canonical" href="<?= e($canonicalUrl) ?>">
  <meta property="og:type" content="website">
  <meta property="og:title" content="СитроМания 24/7 - круглосуточный автосервис в Коврове">
  <meta property="og:description" content="Выездной сервис, шиномонтаж, диагностика и ремонт автомобилей 24/7. Адрес: ул. Урицкого, 14А.">
  <meta property="og:url" content="<?= e($canonicalUrl) ?>">
  <meta property="og:image" content="<?= e($baseUrl . 'assets/img/yandex/service-1.webp') ?>">
  <link rel="preload" href="assets/img/yandex/service-1.webp" as="image">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400..900&display=swap">
  <link rel="stylesheet" href="assets/css/styles.css">
  <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
</head>
<body>
  <header class="site-header" aria-label="Главная навигация">
    <a class="brand" href="#top" aria-label="СитроМания 24/7">
      <span class="brand__mark">C24</span>
      <span>
        <strong>СитроМания 24/7</strong>
        <small>Автосервис в Коврове</small>
      </span>
    </a>
    <nav class="nav" aria-label="Разделы страницы">
      <a href="#services">Услуги</a>
      <a href="#proof">Отзывы</a>
      <a href="#contacts">Контакты</a>
    </nav>
    <a class="header-phone" href="tel:<?= e($phoneHref) ?>"><?= e($phoneDisplay) ?></a>
  </header>

  <main id="top">
    <section class="hero">
      <div class="hero__content">
        <p class="eyebrow">Ковров, ул. Урицкого, 14А</p>
        <h1>Круглосуточный автосервис и выездная помощь в Коврове</h1>
        <p class="hero__lead">СитроМания 24/7 помогает, когда автомобиль не ждёт удобного времени: диагностика на месте, выездной шиномонтаж, ТО и ремонт в сервисе.</p>
        <div class="hero__actions">
          <a class="btn btn-primary" href="#request">Оставить заявку</a>
          <a class="btn btn-secondary" href="tel:<?= e($phoneHref) ?>">Позвонить</a>
        </div>
        <dl class="trust-strip" aria-label="Данные из карточки Яндекс Карт">
          <div><dt>Рейтинг</dt><dd>4,8</dd></div>
          <div><dt>Оценки</dt><dd>24</dd></div>
          <div><dt>Отзывы</dt><dd>19</dd></div>
          <div><dt>Режим</dt><dd>24/7</dd></div>
        </dl>
      </div>
      <div class="hero__media" aria-label="Фото автосервиса из Яндекс Карт">
        <div class="hero__photo-card hero__photo-card--main">
          <img class="hero__image hero__image--main" src="assets/img/yandex/service-1.webp" alt="Автосервис СитроМания 24/7 в Коврове" width="750" height="1000">
        </div>
      </div>
    </section>

    <section class="section section--services" id="services">
      <div class="section__head">
        <p class="eyebrow">Услуги</p>
        <h2>Сразу понятно, с чем можно обратиться</h2>
        <p>Второй блок посвящён услугам подробно: что делаем, когда это нужно и почему удобно обращаться именно в СитроМанию 24/7.</p>
      </div>
      <div class="services-grid">
        <?php foreach ($services as $index => $service): ?>
          <article class="service-card">
            <span class="service-card__num"><?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3><?= e($service['title']) ?></h3>
            <p><?= e($service['lead']) ?></p>
            <dl>
              <div>
                <dt>Когда нужно</dt>
                <dd><?= e($service['for']) ?></dd>
              </div>
              <div>
                <dt>Почему у нас</dt>
                <dd><?= e($service['why']) ?></dd>
              </div>
            </dl>
            <a class="service-card__cta" href="#request">Записаться</a>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section night-shift" aria-labelledby="night-title">
      <div class="night-shift__glow" aria-hidden="true"></div>
      <div class="night-shift__content">
        <p class="eyebrow">Круглосуточно</p>
        <h2 id="night-title">Работаем 24/7. Каждый день.</h2>
        <p>Поломка не смотрит на часы. Можно звонить ночью, утром, в выходной или по дороге через Ковров: выездная диагностика, шиномонтаж и срочная помощь доступны круглый год.</p>
        <div class="night-shift__actions">
          <a class="btn btn-primary" href="#request">Записаться</a>
          <a class="btn btn-secondary btn-secondary--light" href="tel:<?= e($phoneHref) ?>">Позвонить сейчас</a>
        </div>
      </div>
    </section>

    <section class="section section--split">
      <div>
        <p class="eyebrow">Почему выбирают</p>
        <h2>Помощь без лишней суеты: по телефону, на дороге и в сервисе</h2>
        <p>Клиенты чаще всего отмечают оперативность, человеческое отношение, аккуратный ремонт и готовность выехать, когда другие уже закрыты.</p>
      </div>
      <div class="advantage-grid">
        <?php foreach ($advantages as $advantage): ?>
          <article class="advantage-card">
            <h3><?= e($advantage['title']) ?></h3>
            <p><?= e($advantage['text']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section section--dark">
      <div class="section__head section__head--light">
        <p class="eyebrow">Сценарии</p>
        <h2>Когда лучше звонить сразу</h2>
      </div>
      <div class="scenario-grid">
        <article><h3>Машина встала ночью</h3><p>Позвоните, опишите симптомы и место. Если возможно помочь на месте, мастер выедет с инструментом.</p></article>
        <article><h3>Проблема с колесом</h3><p>Прокол, два повреждённых колеса, нет нормальной запаски или нужна резина. Подберём быстрый вариант.</p></article>
        <article><h3>Непонятный стук или ошибка</h3><p>Проведём диагностику, объясним риск продолжать движение и предложим ремонт без лишних замен.</p></article>
      </div>
    </section>

    <section class="section" id="proof">
      <div class="section__head">
        <p class="eyebrow">Соцдоказательство</p>
        <h2>4,8 на Яндекс Картах и живые истории помощи</h2>
        <p>В карточке отмечены 100% положительные темы по персоналу, времени ожидания и ремонту.</p>
      </div>
      <div class="reviews-grid">
        <?php foreach ($reviews as $review): ?>
          <article class="review-card">
            <div class="stars" aria-label="Оценка 5 из 5">★★★★★</div>
            <p><?= e($review['text']) ?></p>
            <strong><?= e($review['name']) ?></strong>
          </article>
        <?php endforeach; ?>
      </div>
      <a class="text-link" href="<?= e($mapsUrl) ?>" target="_blank" rel="noopener">Смотреть карточку и все отзывы на Яндекс Картах</a>
    </section>

    <section class="section section--brands">
      <div class="section__head">
        <p class="eyebrow">Марки</p>
        <h2>Работаем с отечественными, европейскими, японскими, корейскими и китайскими авто</h2>
      </div>
      <div class="brand-badges" aria-label="Марки автомобилей">
        <?php foreach ($brands as $brand): ?>
          <span class="brand-badge">
            <span class="brand-badge__logo">
              <img src="<?= e($brand['logo']) ?>" alt="Логотип <?= e($brand['name']) ?>">
            </span>
            <span><?= e($brand['name']) ?></span>
          </span>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section section--process">
      <div class="section__head">
        <p class="eyebrow">Как работаем</p>
        <h2>Три шага до понятного решения</h2>
      </div>
      <ol class="process-list">
        <li><strong>Звонок или заявка.</strong><span>Вы описываете автомобиль, проблему и где находитесь.</span></li>
        <li><strong>Диагностика.</strong><span>Мастер уточняет симптомы, выезжает или ждёт вас в сервисе.</span></li>
        <li><strong>Ремонт и проверка.</strong><span>Согласовываем работы, выполняем ремонт и проверяем результат.</span></li>
      </ol>
    </section>

    <section class="section section--gallery" id="photos">
      <div class="section__head">
        <p class="eyebrow">Фото</p>
        <h2>Галерея</h2>
        <p>Реальные фотографии сервиса из карточки Яндекс Карт.</p>
      </div>
      <div class="photo-grid">
        <?php foreach ($photos as $photo): ?>
          <figure>
            <img src="<?= e($photo['src']) ?>" alt="<?= e($photo['alt']) ?>">
          </figure>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section section--contacts" id="contacts">
      <div class="contacts-card">
        <p class="eyebrow">Контакты</p>
        <h2>СитроМания 24/7</h2>
        <dl class="contacts-list">
          <div><dt>Телефон</dt><dd><a href="tel:<?= e($phoneHref) ?>"><?= e($phoneDisplay) ?></a></dd></div>
          <div><dt>Адрес</dt><dd><?= e($address) ?></dd></div>
          <div><dt>Время работы</dt><dd>Круглосуточно, каждый день</dd></div>
        </dl>
        <div class="contacts-actions">
          <a class="btn btn-primary" href="#request">Оставить заявку</a>
          <a class="btn btn-secondary" href="<?= e($routeUrl) ?>" target="_blank" rel="noopener">Построить маршрут</a>
        </div>
      </div>
      <div class="map-wrap" aria-label="Карта проезда">
        <iframe title="СитроМания 24/7 на Яндекс Картах" src="https://yandex.ru/map-widget/v1/?ll=41.306262%2C56.376500&mode=search&oid=31728976855&ol=biz&z=16" loading="lazy"></iframe>
      </div>
    </section>

    <section class="section section--faq">
      <div class="section__head">
        <p class="eyebrow">FAQ</p>
        <h2>Частые вопросы перед обращением</h2>
      </div>
      <div class="faq">
        <?php
        $faq = [
            ['q' => 'Можно ли обратиться ночью?', 'a' => 'Да. Сервис указан как круглосуточный, а выездная помощь особенно полезна ночью и в дороге.'],
            ['q' => 'Вы приезжаете к машине?', 'a' => 'Да, в карточке есть выездной сервис, выездная диагностика и выездной шиномонтаж. Возможность ремонта на месте зависит от поломки.'],
            ['q' => 'Можно ли заказать запчасти?', 'a' => 'Да, в перечне работ указаны запчасти и комплектующие под заказ. Детали лучше согласовать по телефону.'],
            ['q' => 'Какие автомобили обслуживаете?', 'a' => 'Легковые, коммерческие, отечественные и импортные автомобили, включая Citroen, Peugeot, Renault, Lada, Toyota, Kia, Hyundai, Volkswagen и другие марки.'],
            ['q' => 'Что быстрее: заявка или звонок?', 'a' => 'Если ситуация срочная, лучше звонить. Заявка удобна, когда нужно описать проблему и дождаться обратной связи.'],
        ];
        foreach ($faq as $item):
        ?>
          <article class="faq__item">
            <button class="faq__button" type="button" aria-expanded="false">
              <span><?= e($item['q']) ?></span>
              <span class="faq__icon" aria-hidden="true"></span>
            </button>
            <div class="faq__panel">
              <p><?= e($item['a']) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section request-section" id="request">
      <div class="request-copy">
        <p class="eyebrow">Заявка</p>
        <h2>Опишите проблему, и мастер свяжется с вами</h2>
        <p>Для срочной помощи звоните сразу. Если удобнее оставить данные, заполните форму: заявка уйдёт напрямую в Telegram.</p>
        <a class="phone-large" href="tel:<?= e($phoneHref) ?>"><?= e($phoneDisplay) ?></a>
      </div>
      <form class="lead-form" action="submit.php" method="post" data-lead-form>
        <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
        <div class="hp-field" aria-hidden="true">
          <label for="website">Сайт</label>
          <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
        </div>
        <label>
          <span>Имя</span>
          <input name="name" type="text" autocomplete="name" minlength="2" required placeholder="Например, Алексей">
        </label>
        <label>
          <span>Телефон</span>
          <input name="phone" type="tel" autocomplete="tel" required pattern="^\+?[0-9\s()\-]{7,20}$" placeholder="+7 920 926 78 71">
        </label>
        <label>
          <span>Что нужно сделать</span>
          <select name="service">
            <option value="">Выберите услугу</option>
            <?php foreach ($services as $service): ?>
              <option value="<?= e($service['title']) ?>"><?= e($service['title']) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>
          <span>Комментарий</span>
          <textarea name="comment" rows="4" placeholder="Марка авто, что случилось, где находится машина"></textarea>
        </label>
        <label class="checkbox">
          <input type="checkbox" name="agreement" value="1" required>
          <span>Согласен на обработку персональных данных для обратной связи по заявке</span>
        </label>
        <button class="btn btn-primary btn-full" type="submit">Оставить заявку</button>
        <p class="form-status" data-form-status hidden></p>
      </form>
    </section>
  </main>

  <footer class="site-footer">
    <p><strong>СитроМания 24/7</strong> - автосервис, автотехцентр и выездная помощь в Коврове.</p>
    <p><a href="tel:<?= e($phoneHref) ?>"><?= e($phoneDisplay) ?></a> · <a href="<?= e($mapsUrl) ?>" target="_blank" rel="noopener">Яндекс Карты</a></p>
  </footer>

  <div class="mobile-cta" aria-label="Быстрые действия">
    <a class="btn btn-secondary" href="tel:<?= e($phoneHref) ?>">Позвонить</a>
    <a class="btn btn-primary" href="#request">Заявка</a>
  </div>

  <script src="assets/js/main.js" defer></script>
  <script type="module" src="assets/js/motion.js"></script>
</body>
</html>
