<!doctype html>
<html lang="<?= \app\core\Language::getCurrentLanguage() ?>">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Главная</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="/css/home_template.css"/>
</head>
<body>
<header>
    <div class="container header-row">
        <a class="logo" href="/">
            <img src="" alt="Логотип сайта">
        </a>
        <form class="lang" method="get" action="/">
            <label for="lang"></label>
            <select id="lang" name="lang">
                <?php foreach (\app\core\Language::getLanguages() as $language): ?>
                    <option value="<?= $language['code'] ?>" <?= $language['code'] === \app\core\Language::getCurrentLanguage() ? 'selected' : '' ?>><?= $language['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        <div class="right-block">
            <div class="phone">
                <span class="phone_label">Телефон</span>
                <span>88005553535</span>
            </div>
            <div class="socials">
                <a class="sq" href="https://www.viber.com/" target="_blank"></a>
                <a class="sq" href="https://telegram.org/" target="_blank"></a>
                <a class="sq" href="https://www.instagram.com/" target="_blank"></a>
            </div>
        </div>
    </div>
</header>
<main class="container">
    <?php require_once $viewFile ?>
</main>
<footer>
    <div class="container">
        <div class="footer">Разработчик</div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="/js/home_template.js" defer></script>
</body>
</html>

<div class="swiper mySwiper">
    <div class="swiper-wrapper">

        <div class="swiper-slide">
            <figure>
                <img src="https://picsum.photos/id/1001/400/250" alt="Кошка 1">
                <figcaption>Кошка на подоконнике</figcaption>
            </figure>
        </div>

        <div class="swiper-slide">
            <figure>
                <img src="https://picsum.photos/id/1002/400/250" alt="Кошка 2">
                <figcaption>Любопытный котик</figcaption>
            </figure>
        </div>

        <div class="swiper-slide">
            <figure>
                <img src="https://picsum.photos/id/1003/400/250" alt="Кошка 3">
                <figcaption>Кот на прогулке</figcaption>
            </figure>
        </div>

        <div class="swiper-slide">
            <figure>
                <img src="https://picsum.photos/id/1004/400/250" alt="Кошка 4">
                <figcaption>Задумчивый кот</figcaption>
            </figure>
        </div>

        <div class="swiper-slide">
            <figure>
                <img src="https://picsum.photos/id/1005/400/250" alt="Кошка 5">
                <figcaption>Котик в одеяле</figcaption>
            </figure>
        </div>

        <div class="swiper-slide">
            <figure>
                <img src="https://picsum.photos/id/1006/400/250" alt="Кошка 6">
                <figcaption>Кот играет с клубком</figcaption>
            </figure>
        </div>

        <div class="swiper-slide">
            <figure>
                <img src="https://picsum.photos/id/1008/400/250" alt="Кошка 7">
                <figcaption>Пушистый хвостик</figcaption>
            </figure>
        </div>

        <div class="swiper-slide">
            <figure>
                <img src="https://picsum.photos/id/1010/400/250" alt="Кошка 8">
                <figcaption>Солнечный полдень</figcaption>
            </figure>
        </div>

        <div class="swiper-slide">
            <figure>
                <img src="https://picsum.photos/id/1012/400/250" alt="Кошка 9">
                <figcaption>Котик в коробке</figcaption>
            </figure>
        </div>

    </div>

    <div class="swiper-pagination"></div>
</div>
