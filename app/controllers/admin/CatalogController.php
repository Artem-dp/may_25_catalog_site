<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\exceptions\CatalogUploadException;

class CatalogController extends Controller
{
    public function index():void
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
        if(!isset($_FILES['csv_file'])){
            throw new \Exception('File not found');
        }

        $file = $_FILES['csv_file'];

        // TODO: Витягнути мови з БД
        // SELECT id, code FROM langs
        $langs = [
            ['id' => 1, 'code' => 'uk'],
            ['id' => 2, 'code' => 'en'],
            ['id' => 3, 'code' => 'ru'],
        ];

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
        $categoriesLangs = [];
        $products = [];
        $productsLangs = [];


    }

    /**
     * download image from url + save to public/uploads/products/
     * @param string $url
     * @return string
     * @throws CatalogUploadException
     */
    private function downloadImage(string $url): string
    {


        $uploadDir = ROOT_PATH . 'public/uploads/products/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($url, PATHINFO_EXTENSION);
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