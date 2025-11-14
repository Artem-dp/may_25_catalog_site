<?php
/** @var array  $data  ['title','content','lang'] */
/** @var string $lang */
$lang = $data['lang'] ?? ($lang ?? 'ru');
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Админка — О нас</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
</head>
<body class="bg-light">
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Раздел «О нас»</h1>
        <div class="btn-group">
            <a class="btn btn-outline-secondary <?= $lang==='uk'?'active':'' ?>" href="/admin/about?lang=uk">UK</a>
            <a class="btn btn-outline-secondary <?= $lang==='ru'?'active':'' ?>" href="/admin/about?lang=ru">RU</a>
            <a class="btn btn-outline-secondary <?= $lang==='en'?'active':'' ?>" href="/admin/about?lang=en">EN</a>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="/admin/about/save">
                <input type="hidden" name="lang" value="<?= htmlspecialchars($lang) ?>">

                <div class="mb-3">
                    <label for="title" class="form-label">Заголовок</label>
                    <input id="title" name="title" type="text" class="form-control"
                           value="<?= htmlspecialchars($data['title'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Контент</label>
                    <textarea id="content" name="content" rows="12" class="form-control">
                    <?= htmlspecialchars($data['content'] ?? '') ?>
          </textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <a href="/admin/dashboard" class="btn btn-outline-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    ClassicEditor.create(document.querySelector('#content')).catch(console.error);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
