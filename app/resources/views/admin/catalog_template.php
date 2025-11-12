<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Управление каталогом</h1>
    <div class="btn-group">
        <a class="btn btn-outline-secondary <?= $lang==='uk'?'active':'' ?>" href="/admin/catalog?lang=uk">UK</a>
        <a class="btn btn-outline-secondary <?= $lang==='en'?'active':'' ?>" href="/admin/catalog?lang=en">EN</a>
        <a class="btn btn-outline-secondary <?= $lang==='ru'?'active':'' ?>" href="/admin/catalog?lang=ru">RU</a>
    </div>
</div>

<!-- Upload Form Card -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-cloud-upload me-2"></i>Загрузка CSV файла</h5>
    </div>
    <div class="card-body">
        <form action="/admin/catalog/upload" method="post" enctype="multipart/form-data" id="uploadForm">
            <div class="row align-items-end">
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
                    <button type="submit" class="btn btn-primary w-100">
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
        <?php if (isset($categoriesLangs) && !empty($categoriesLangs)):
            // Групуємо переклади категорій по category_id
            $categoriesGrouped = [];
            foreach ($categoriesLangs as $catLang) {
                $catId = $catLang['category_id'];
                if (!isset($categoriesGrouped[$catId])) {
                    $categoriesGrouped[$catId] = [];
                }
                $categoriesGrouped[$catId][$catLang['lang_id']] = $catLang['name'];
            }

            // Групуємо переклади товарів по product_id
            $productsGrouped = [];
            if (isset($productsLangs)) {
                foreach ($productsLangs as $prodLang) {
                    $prodId = $prodLang['product_id'];
                    if (!isset($productsGrouped[$prodId])) {
                        $productsGrouped[$prodId] = [
                            'category_id' => $prodLang['category_id'],
                            'langs' => []
                        ];
                    }
                    $productsGrouped[$prodId]['langs'][$prodLang['lang_id']] = $prodLang['name'];
                }
            }
        ?>
            <div id="catalogTree">
                <ul class="tree">
                    <?php foreach ($categoriesGrouped as $categoryId => $categoryTranslations):
                        // Отримуємо назву категорії для поточної мови
                        $categoryName = $categoryTranslations[$currentLangId] ?? reset($categoryTranslations);

                        // Підраховуємо товари в категорії
                        $categoryProducts = array_filter($productsGrouped, function($product) use ($categoryId) {
                            return $product['category_id'] === $categoryId;
                        });
                        $productCount = count($categoryProducts);
                    ?>
                        <li>
                            <div class="tree-item category">
                                <?php if ($productCount > 0): ?>
                                    <span class="tree-toggle">−</span>
                                <?php else: ?>
                                    <span style="width: 20px; display: inline-block;"></span>
                                <?php endif; ?>

                                <div class="tree-content">
                                    <i class="bi bi-folder category-icon"></i>
                                    <strong><?= htmlspecialchars($categoryName) ?></strong>
                                </div>

                                <?php if ($productCount > 0): ?>
                                    <span class="badge bg-primary tree-badge"><?= $productCount ?></span>
                                <?php endif; ?>
                            </div>

                            <?php if ($productCount > 0): ?>
                                <ul>
                                    <?php foreach ($categoryProducts as $productId => $product):
                                        $productName = $product['langs'][$currentLangId] ?? reset($product['langs']);
                                    ?>
                                        <li>
                                            <div class="tree-item product">
                                                <span style="width: 20px; display: inline-block;"></span>
                                                <div class="tree-content">
                                                    <i class="bi bi-box-seam product-icon"></i>
                                                    <?= htmlspecialchars($productName) ?>
                                                </div>
                                                <small class="text-muted">ID: <?= $productId ?></small>
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


