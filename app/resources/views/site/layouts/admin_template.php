<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? 'Панель управления' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
<!-- Header -->
<nav class="navbar navbar-dark bg-dark fixed-top shadow-sm">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <div class="avatar-circle me-2">A</div>
            <span class="navbar-brand mb-0">Панель управления</span>
        </div>
        <div>
            <a href="/admin/logout" class="btn btn-outline-light btn-sm">
                <i class="bi bi-box-arrow-right"></i> Выйти
            </a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<nav class="sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="/admin/dashboard">
                    <i class="bi bi-speedometer2"></i>
                    Панель управления
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/catalog">
                    <i class="bi bi-grid"></i>
                    Каталог
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/about">
                    <i class="bi bi-info-circle"></i>
                    О нас
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/settings">
                    <i class="bi bi-gear"></i>
                    Настройки
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Main Content -->
<main class="main-content">
    <div class="container-fluid py-4">
        <?php require_once $viewFile ?>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Rzb4ac3gKJPaL5tVYFnYzLxoVSeKUgO1SHxGjHBe1tVVxSNQzJPaNEe5n3X/Mghe"
        crossorigin="anonymous"></script>
<script src="/js/admin.js"></script>
</body>
</html>
