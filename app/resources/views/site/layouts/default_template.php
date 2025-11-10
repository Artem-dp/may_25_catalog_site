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

