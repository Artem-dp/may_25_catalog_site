<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\exceptions\CatalogUploadException;

class CatalogController extends Controller
{
    public function index(): void
    {
        // Отримуємо мову з GET параметра, за замовчуванням 'uk'
        $lang = $_GET['lang'] ?? 'uk';

        // Валідація мови
        $allowedLangs = ['uk', 'en', 'ru'];
        if (!in_array($lang, $allowedLangs)) {
            $lang = 'uk';
        }

        // Мапа lang_code => lang_id
        $langMap = ['uk' => 1, 'en' => 2, 'ru' => 3];
        $currentLangId = $langMap[$lang];

        // TODO: Отримати дані з БД
        // SELECT c.id, cl.name, cl.lang_id
        // FROM categories c
        // LEFT JOIN categories_langs cl ON c.id = cl.category_id
        //
        // SELECT p.id, p.category_id, p.image_path, pl.name, pl.lang_id
        // FROM products p
        // LEFT JOIN products_langs pl ON p.id = pl.product_id

        // Фейкові дані для прикладу з мультимовністю
        // Структура: категорії з перекладами
        $categoriesLangs = [
            // Категорія 1 - Електроніка
            ['category_id' => 1, 'lang_id' => 1, 'name' => 'Електроніка'],
            ['category_id' => 1, 'lang_id' => 2, 'name' => 'Electronics'],
            ['category_id' => 1, 'lang_id' => 3, 'name' => 'Электроника'],

            // Категорія 2 - Одяг
            ['category_id' => 2, 'lang_id' => 1, 'name' => 'Одяг'],
            ['category_id' => 2, 'lang_id' => 2, 'name' => 'Clothing'],
            ['category_id' => 2, 'lang_id' => 3, 'name' => 'Одежда'],

            // Категорія 3 - Книги
            ['category_id' => 3, 'lang_id' => 1, 'name' => 'Книги'],
            ['category_id' => 3, 'lang_id' => 2, 'name' => 'Books'],
            ['category_id' => 3, 'lang_id' => 3, 'name' => 'Книги'],
        ];

        $productsLangs = [
            // Товар 1 - Ноутбук ASUS
            ['product_id' => 1, 'category_id' => 1, 'lang_id' => 1, 'name' => 'Ноутбук ASUS'],
            ['product_id' => 1, 'category_id' => 1, 'lang_id' => 2, 'name' => 'ASUS Laptop'],
            ['product_id' => 1, 'category_id' => 1, 'lang_id' => 3, 'name' => 'Ноутбук ASUS'],

            // Товар 2 - Смартфон Samsung
            ['product_id' => 2, 'category_id' => 1, 'lang_id' => 1, 'name' => 'Смартфон Samsung'],
            ['product_id' => 2, 'category_id' => 1, 'lang_id' => 2, 'name' => 'Samsung Smartphone'],
            ['product_id' => 2, 'category_id' => 1, 'lang_id' => 3, 'name' => 'Смартфон Samsung'],

            // Товар 3 - Навушники Sony
            ['product_id' => 3, 'category_id' => 1, 'lang_id' => 1, 'name' => 'Навушники Sony'],
            ['product_id' => 3, 'category_id' => 1, 'lang_id' => 2, 'name' => 'Sony Headphones'],
            ['product_id' => 3, 'category_id' => 1, 'lang_id' => 3, 'name' => 'Наушники Sony'],

            // Товар 4 - Футболка Nike
            ['product_id' => 4, 'category_id' => 2, 'lang_id' => 1, 'name' => 'Футболка Nike'],
            ['product_id' => 4, 'category_id' => 2, 'lang_id' => 2, 'name' => 'Nike T-Shirt'],
            ['product_id' => 4, 'category_id' => 2, 'lang_id' => 3, 'name' => 'Футболка Nike'],

            // Товар 5 - Джинси Levis
            ['product_id' => 5, 'category_id' => 2, 'lang_id' => 1, 'name' => 'Джинси Levis'],
            ['product_id' => 5, 'category_id' => 2, 'lang_id' => 2, 'name' => 'Levis Jeans'],
            ['product_id' => 5, 'category_id' => 2, 'lang_id' => 3, 'name' => 'Джинсы Levis'],

            // Товар 6 - Гаррі Поттер
            ['product_id' => 6, 'category_id' => 3, 'lang_id' => 1, 'name' => 'Гаррі Поттер'],
            ['product_id' => 6, 'category_id' => 3, 'lang_id' => 2, 'name' => 'Harry Potter'],
            ['product_id' => 6, 'category_id' => 3, 'lang_id' => 3, 'name' => 'Гарри Поттер'],
        ];

        $this->render('admin/catalog_template', [
            'title' => 'Управление каталогом',
            'lang' => $lang,
            'currentLangId' => $currentLangId,
            'categoriesLangs' => $categoriesLangs,
            'productsLangs' => $productsLangs
        ], 'site/layouts/admin_template');
    }

    public function upload(): void
    {
        if (!isset($_FILES['csv_file'])) {
            throw new \Exception('File not found');
        }

        $file = $_FILES['csv_file'];

        $processedFile = fopen($file['tmp_name'], 'r');
        if ($processedFile === false) {
            throw new CatalogUploadException('Failed to open file');
        }

        $header = fgetcsv($processedFile, 0, ',', '"', '');
        if ($header === false) {
            fclose($processedFile);
            throw new CatalogUploadException('Failed to read CSV header');
        }

        //header parsing
        //save column indexes
        $categoryColumns = [];
        $productColumns = [];
        $imageUrlColumn = null;

        foreach ($header as $index => $columnName) {
            if (str_starts_with($columnName, 'category_name_')) {
                $langCode = str_replace('category_name_', '', $columnName);
                $categoryColumns[$langCode] = $index;
            } elseif (str_starts_with($columnName, 'product_name_')) {
                $langCode = str_replace('product_name_', '', $columnName);
                $productColumns[$langCode] = $index;
            } elseif ($columnName === 'image_url') {
                $imageUrlColumn = $index;
            }
        }


        // Prepare structure for DB
        $categories = [];

        while (($row = fgetcsv($processedFile, 0, ',', '"', '')) !== false) {
            if (empty($row)) {
                continue;
            }
            $categoryTranslations = [];

            foreach ($categoryColumns as $langCode => $columnIndex) {
                $categoryTranslations[$langCode] = $row[$columnIndex];
            }

            $categoryKey = $categoryTranslations[array_key_first($categoryTranslations)];

            $productTranslations = [];
            foreach ($productColumns as $langCode => $columnIndex) {
                $productTranslations[$langCode] = $row[$columnIndex];
            }
            //image url
            $imageUrl = null;
            if ($imageUrlColumn !== null && isset($row[$imageUrlColumn])) {
                $imageUrl = $row[$imageUrlColumn];
            }

            //save category to array
            if (!isset($categories[$categoryKey])) {
                $categories[$categoryKey] = [
                    'translations' => $categoryTranslations,
                    'products' => []
                ];
            }
            //add product to category
            $categories[$categoryKey]['products'][] = [
                'translations' => $productTranslations,
                'image_url' => $this->downloadImage($imageUrl)
            ];
        }
        fclose($processedFile);

        $catalogArray = array_values($categories);

        //TODO: model method saveCatalog
        var_dump($catalogArray);

    }

    /**
     * download image from url + save to public/uploads/products/
     * @param string $url
     * @return string
     * @throws CatalogUploadException
     */
    private function downloadImage(string $url): string
    {
        $fileId = str_replace('https://drive.google.com/file/d/', '', $url);
        if (($pos = strpos($fileId, '/view')) !== false) {
            $fileId = substr($fileId, 0, $pos);
        }

        $url = "https://drive.usercontent.google.com/download?id={$fileId}&export=download&authuser=0&confirm=t";
        $imageContent = file_get_contents($url);
        $imgInfo = getimagesizefromstring($imageContent);
        if (!$imgInfo) {
            throw new CatalogUploadException("Invalid image format");
        }

        $uploadDir = ROOT_PATH . 'public/uploads/products/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }


        $mimeToExt = [
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/bmp' => 'bmp',
        ];

        $mimeType = $imgInfo['mime'];
        $extension = $mimeToExt[$mimeType];

        $filename = uniqid() . '.' . $extension;
        $filepath = $uploadDir . $filename;

        $imageContent = file_get_contents($url);
        if ($imageContent === false) {
            throw new CatalogUploadException("Failed to download image: $url");
        }

        file_put_contents($filepath, $imageContent);

        return '/uploads/products/' . $filename;
    }


}