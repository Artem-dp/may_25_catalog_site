<section>
    <h1> <?= $title ?> </h1>
    <p>
        <?= $content ?>
    </p>
</section>
<?php foreach ($catalog as $category):?>
<?php //var_dump($category)?>
<section>
    <h2><?= $category['name'] ?> </h2>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
    <?php foreach ($category['products'] as $product):?>
            <div class="swiper-slide">
                <figure>
                    <img src="<?=$product['image']?>" alt="<?= $product['name']?>">
                    <figcaption><?= $product['name']?></figcaption>
                </figure>
            </div>
    <?php endforeach;?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>
<?php endforeach; ?>