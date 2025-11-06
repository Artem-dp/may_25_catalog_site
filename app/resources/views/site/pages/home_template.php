<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Главная</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="css/home_template.css" />
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
                <option value="ru" selected>Русский</option>
                <option value="en">English</option>
            </select>
        </form>
        <div class="right-block">
            <div class="phone">
                <span class="phone_label">Телефон</span>
                <span> 88005553535 </span>
            </div>
            <div class="socials">
                <a class="sq" href="https://www.viber.com/"     target="_blank"></a>
                <a class="sq" href="https://telegram.org/"      target="_blank"></a>
                <a class="sq" href="https://www.instagram.com/" target="_blank"></a>
            </div>
        </div>
    </div>
</header>
<main class="container">
    <section>
        <h1>О нас</h1>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque harum mollitia neque quasi repudiandae vitae? Beatae ex excepturi hic libero obcaecati quas quis rerum tempore temporibus ut? Aliquid delectus, deleniti doloremque esse eum eveniet iusto laborum neque nisi nobis non obcaecati odio provident quia rem soluta ut? Ad asperiores aspernatur dolor, est eum hic illum iusto quam qui quisquam reprehenderit similique suscipit veniam. Consequatur corporis dolor eaque eos fugit, laborum libero pariatur provident quae. Aut commodi cum dolores excepturi exercitationem odit! Eligendi fugiat iste iure labore laboriosam magnam neque odio odit rerum sed? Id odio temporibus voluptates. Ab accusantium architecto assumenda aut, consequuntur culpa cupiditate dolorem doloribus ea eaque eligendi eum incidunt inventore ipsa itaque labore mollitia nostrum odio quis recusandae reprehenderit sequi sint suscipit veniam voluptate? Adipisci assumenda atque autem debitis, deserunt et facere fugiat impedit magni maiores minus nisi non obcaecati, officiis porро quia ratione ullam velit, voluptas?
        </p>
    </section>
    <section>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <figure class="slide">
                        <div class="slide-media">
                            <img src="https://picsum.photos/seed/cat1/1200/800" alt="Вид на воду">
                        </div>
                        <figcaption class="slide-caption">Какой прекрасный вид</figcaption>
                    </figure>
                </div>
                <div class="swiper-slide">
                    <figure class="slide">
                        <div class="slide-media">
                            <img src="https://picsum.photos/seed/cat2/1200/800" alt="Машинка">
                        </div>
                        <figcaption class="slide-caption">Машинка</figcaption>
                    </figure>
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>
</main>
<footer>
    <div class="container">
        <div class="footer">Разработчик</div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="js/home_template.js" defer></script>
</body>
</html>

