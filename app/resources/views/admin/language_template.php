<h2>Выбор языка</h2>

<p>Текущий язык: <strong><?= $current ?></strong></p>

<ul>
    <?php foreach ($languages as $code => $name): ?>
        <li>
            <?= $name ?> (<?= $code ?>)
            <?php if ($code !== $current): ?>
                <a href="/admin/language/switch?code=<?= $code ?>">Переключиться</a>
            <?php else: ?>
                ✅ активен
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>