<!-- Welcome Section -->
<div class="mb-4">
    <h1 class="h3 mb-2">Добро пожаловать в панель управления</h1>
    <p class="text-muted">Управляйте содержимым вашего сайта</p>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Категории</p>
                        <h3 class="mb-0"><?= $stats['categories'] ?? 0 ?></h3>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-folder text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Товары</p>
                        <h3 class="mb-0"><?= $stats['products'] ?? 0 ?></h3>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="bi bi-box-seam text-success" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Языки</p>
                        <h3 class="mb-0"><?= $stats['languages'] ?? 3 ?></h3>
                    </div>
                    <div class="rounded-circle bg-info bg-opacity-10 p-3">
                        <i class="bi bi-translate text-info" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Быстрые действия</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="/admin/catalog" class="text-decoration-none">
                            <div class="d-flex align-items-center p-3 bg-light rounded hover-shadow">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                    <i class="bi bi-grid text-primary" style="font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-dark">Управление каталогом</h6>
                                    <small class="text-muted">Категории и товары</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6">
                        <a href="/admin/about" class="text-decoration-none">
                            <div class="d-flex align-items-center p-3 bg-light rounded hover-shadow">
                                <div class="rounded-circle bg-info bg-opacity-10 p-2 me-3">
                                    <i class="bi bi-info-circle text-info" style="font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-dark">Редактировать "О нас"</h6>
                                    <small class="text-muted">Информация о компании</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6">
                        <a href="/admin/catalog?lang=uk" class="text-decoration-none">
                            <div class="d-flex align-items-center p-3 bg-light rounded hover-shadow">
                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                    <i class="bi bi-upload text-success" style="font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-dark">Загрузить CSV</h6>
                                    <small class="text-muted">Импорт товаров</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6">
                        <a href="/admin/settings" class="text-decoration-none">
                            <div class="d-flex align-items-center p-3 bg-light rounded hover-shadow">
                                <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-3">
                                    <i class="bi bi-gear text-warning" style="font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-dark">Настройки</h6>
                                    <small class="text-muted">Конфигурация системы</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Информация</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Система</small>
                    <strong>PHP <?= phpversion() ?></strong>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Доступные языки</small>
                    <div class="d-flex gap-1">
                        <span class="badge bg-primary">UK</span>
                        <span class="badge bg-primary">EN</span>
                        <span class="badge bg-primary">RU</span>
                    </div>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Статус</small>
                    <span class="badge bg-success">
                        <i class="bi bi-check-circle me-1"></i>Система работает
                    </span>
                </div>
                <hr>
                <div class="alert alert-info mb-0 py-2 px-3">
                    <small>
                        <i class="bi bi-lightbulb me-1"></i>
                        <strong>Совет:</strong> Используйте CSV для массовой загрузки товаров
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
