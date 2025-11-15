<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\core\Language;
use app\core\Router;
use app\exceptions\CatalogUploadException;
use app\models\admin\CatalogModel;

class CatalogController extends Controller
{
    /**
     * displaying catalog page
     * @return void
     */
    public function index(): void
    {
        $lang = $_GET['lang'] ?? Language::getDefaultLanguage();
        $allowedLangs = Language::getLanguages();
        $currentLang = array_find($allowedLangs, function ($item) use ($lang) {
            return $item['code'] === $lang;
        });
        $catalogModel = new CatalogModel();
        $catalog = $catalogModel->getCategoriesWithProducts($currentLang['id']);
        $this->render('admin/catalog_template', [
            'catalog' => $catalog,
        ], 'site/layouts/admin_template');
    }

    /**
     * import catalog from csv
     *
     * @return void
     * @throws CatalogUploadException
     */
    public function upload(): void
    {
        // TODO: have problems with timeout limit
        set_time_limit(300);

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

        $catalogModel = new CatalogModel();
        try {
            $catalogModel->saveCatalog($catalogArray);
            Router::redirect('/admin/catalog');
        } catch (\Exception $e) {
            throw new CatalogUploadException($e->getMessage());
        }

    }

    /**
     * download image from url + save to public/uploads/products/
     *
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
        $imgContent = file_get_contents($url);
        $imgInfo = getimagesizefromstring($imgContent);
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

        $imgContent = file_get_contents($url);
        if ($imgContent === false) {
            throw new CatalogUploadException("Failed to download image: $url");
        }
        file_put_contents($filepath, $imgContent);

        return '/uploads/products/' . $filename;
    }

}