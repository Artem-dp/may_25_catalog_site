<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Управление каталогом</h1>
    <div class="btn-group">
        <?php
        $currentLang = $_GET['lang'] ?? \app\core\Language::getDefaultLanguage();

        foreach (\app\core\Language::getLanguages() as $lang): ?>
            <a class="btn btn-outline-secondary <?= $lang['code'] === $currentLang ? 'active' : '' ?>"
               href="/admin/catalog?lang=<?= $lang['code'] ?>"><?= $lang['code'] ?></a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Upload Form Card -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-cloud-upload me-2"></i>Загрузка CSV файла</h5>
    </div>
    <div class="card-body">
        <form action="/admin/catalog/upload" method="post" enctype="multipart/form-data" id="uploadForm">
            <div class="row">
                <div class="col-md-8">
                    <label for="csv_file" class="form-label fw-bold">
                        <i class="bi bi-file-earmark-spreadsheet me-1"></i>Выберите CSV файл
                    </label>
                    <input type="file"
                           class="form-control"
                           id="csv_file"
                           name="csv_file"
                           accept=".csv"
                           required>
                    <div class="form-text">
                        <i class="bi bi-info-circle me-1"></i>
                        Поддерживаются только файлы в формате CSV
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 " style="margin-top: 32px;">
                        <i class="bi bi-upload me-2"></i>Загрузить
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Catalog Tree Card -->
<div class="card shadow-sm">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-diagram-3 me-2"></i>Структура каталога</h5>
        <div>
            <button class="btn btn-sm btn-light" id="expandAll">
                <i class="bi bi-arrows-expand"></i> Развернуть все
            </button>
            <button class="btn btn-sm btn-light ms-2" id="collapseAll">
                <i class="bi bi-arrows-collapse"></i> Свернуть все
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($catalog)): ?>
            <div id="catalogTree">
                <ul class="tree">
                    <?php foreach ($catalog as $category): ?>
                        <li>
                            <div class="tree-item category">
                                <?php $productCount = count($category['products']); ?>
                                <?php if ($productCount > 0): ?>
                                    <span class="tree-toggle">−</span>
                                <?php else: ?>
                                    <span style="width: 20px; display: inline-block;"></span>
                                <?php endif; ?>

                                <div class="tree-content">
                                    <i class="bi bi-folder category-icon"></i>
                                    <strong><?= htmlspecialchars($category['name']) ?></strong>
                                </div>

                                <?php if ($productCount > 0): ?>
                                    <span class="badge bg-primary tree-badge"><?= $productCount ?></span>
                                <?php endif; ?>
                            </div>

                            <?php if ($productCount > 0): ?>
                                <ul>
                                    <?php foreach ($category['products'] as $product):
                                        ?>
                                        <li>
                                            <div class="tree-item product">
                                                <span style="width: 20px; display: inline-block;"></span>
                                                <div class="tree-content">
                                                    <i class="bi bi-box-seam product-icon"></i>
                                                    <?= htmlspecialchars($product['name']) ?>
                                                </div>
                                                <small class="text-muted">ID: <?= $product['id'] ?></small>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                <p class="mt-3">Каталог пустой. Загрузите CSV файл для начала работы.</p>
            </div>
        <?php endif; ?>
    </div>
</div>


