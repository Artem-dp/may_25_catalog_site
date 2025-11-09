<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Главная</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="../../../../../public/css/home_template.css" />
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
                <a class="sq" href="https://www.viber.com/" target="_blank"><i class="fa-brands fa-viber"></i></a>
                <a class="sq" href="https://telegram.org/" target="_blank"><i class="fa-brands fa-telegram"></i></a>
                <a class="sq" href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
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
      <?php include_once '../layouts/default_template.php'?>
    </section>
</main>
<footer>
    <div class="container">
        <div class="footer">Разработчик</div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="../../../../../public/js/home_template.js" ></script>
</body>
</html>

