<h2>Управление языками</h2>

<form method="POST" action="/admin/languages/add" class="mb-3">
    <label for="lang_code">Код языка</label>
    <input type="text" id="lang_code" name="code" placeholder="Код (en)" class="form-control mb-2" required>

    <label for="lang_name">Название языка</label>
    <input type="text" id="lang_name" name="name" placeholder="Название языка" class="form-control mb-2" required>

    <button class="btn btn-primary">Добавить</button>
</form>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Код</th>
        <th>Название</th>
        <th>Действие</th>
    </tr>

    <?php foreach ($languages as $lang): ?>
        <tr>
            <td><?= $lang['id'] ?></td>
            <td><?= $lang['code'] ?></td>
            <td><?= $lang['name'] ?></td>
            <td>
                <a href="/admin/languages/delete?id=<?= $lang['id'] ?>" class="btn btn-danger btn-sm">
                    Удалить
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
