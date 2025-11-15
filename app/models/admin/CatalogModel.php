<?php

namespace app\models\admin;

use app\core\Database;
use app\core\Language;

class CatalogModel extends Database
{

    /**
     * @var \mysqli
     */
    private \mysqli $db;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * @param array $data
     * @return true
     * @throws \Exception
     */
    public function saveCatalog(array $data): bool
    {
        $this->db->autocommit(false);
        $this->db->begin_transaction();
        try {
            // clear catalog tables
            $this->clearAllCatalogData();

            $languages = Language::getLanguages();
            $langMap = [];
            //get lang ids
            foreach ($languages as $lang) {
                $langMap[$lang['code']] = $lang['id'];
            }

            foreach ($data as $categoryData) {

                $categoryId = $this->createCategory();

                foreach ($categoryData['translations'] as $langCode => $name) {
                    if (isset($langMap[$langCode])) {
                        $this->saveCategoryTranslation(
                            $categoryId,
                            $langMap[$langCode],
                            $name
                        );
                    }
                }

                if (isset($categoryData['products'])) {
                    foreach ($categoryData['products'] as $productData) {

                        $imageUrl = $productData['image_url'] ?? null;
                        $productId = $this->createProduct($categoryId, $imageUrl);
                        foreach ($productData['translations'] as $langCode => $name) {
                            if (isset($langMap[$langCode])) {
                                $this->saveProductTranslation(
                                    $productId,
                                    $langMap[$langCode],
                                    $name
                                );
                            }
                        }
                    }
                }
            }
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollback();
            throw new \Exception("Error saving catalog: " . $e->getMessage());
        }
    }

    /**
     * @return void
     */
    private function clearAllCatalogData():void
    {
//        TODO: kostil because
//          Error: Cannot truncate a table referenced in a foreign key constraint (`catalog_db`.`products_langs`, CONSTRAINT `products_langs_ibfk_1`)
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
        $this->db->query("TRUNCATE TABLE products_langs");
        $this->db->query("TRUNCATE TABLE products");
        $this->db->query("TRUNCATE TABLE categories_langs");
        $this->db->query("TRUNCATE TABLE categories");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
    }

    /**
     * create new category
     *
     * @return int category id
     */
    private function createCategory():int
    {
        $stmt = $this->db->prepare("INSERT INTO categories (created_at) VALUES (CURRENT_TIMESTAMP)");
        $stmt->execute();
        return $this->db->insert_id;
    }

    /**
     * create category translation
     *
     * @param int $categoryId
     * @param int $langId
     * @param string $name
     * @return void
     */
    private function saveCategoryTranslation(int $categoryId, int $langId,string $name):void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO categories_langs (category_id, lang_id, name) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iis", $categoryId, $langId, $name);
        $stmt->execute();
    }

    /**
     * create product
     *
     * @param int $categoryId
     * @param string|null $imageUrl
     * @return int product id
     */
    private function createProduct(int $categoryId,?string $imageUrl = null):int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO products (category_id, image, created_at) VALUES (?, ?, CURRENT_TIMESTAMP)"
        );
        $stmt->bind_param("is", $categoryId, $imageUrl);
        $stmt->execute();

        return $this->db->insert_id;
    }

    /**
     * create product translation
     * @param int $productId
     * @param int $langId
     * @param string $name
     * @return void
     */
    private function saveProductTranslation(int $productId,int $langId,string $name):void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO products_langs (product_id, lang_id, name) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iis", $productId, $langId, $name);
        $stmt->execute();
    }

    /**
     * get catalog
     * @param int $currentLang
     * @return array
     */
    public function getCategoriesWithProducts(int $currentLang): array
    {
        $sql = "
      SELECT
          categories.id,
          categories_langs.name AS category_name,
          products.id AS product_id,
          products_langs.name AS product_name,
          products.image
      FROM categories
      JOIN categories_langs ON categories.id = categories_langs.category_id
      JOIN products ON categories.id = products.category_id
      JOIN products_langs ON products.id = products_langs.product_id
      WHERE categories_langs.lang_id = ?
        AND products_langs.lang_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $currentLang, $currentLang);
        $stmt->execute();
        $result =  $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $categories = [];

        foreach ($result as $row) {
            $categoryId = $row['id'];

            if (!isset($categories[$categoryId])) {
                $categories[$categoryId] = [
                    'id' => $row['id'],
                    'name' => $row['category_name'],
                    'products' => []
                ];
            }

            if ($row['product_id']) {
                $categories[$categoryId]['products'][] = [
                    'id' => $row['product_id'],
                    'name' => $row['product_name'],
                    'image' => $row['image']
                ];
            }
        }

        return array_values($categories);
    }

    /**
     * return products count
     *
     * @return int
     */
    public static function getProductsCount(): int
    {
        $db = new Database();
        $db = $db->connect();
        $stmt = $db->prepare("SELECT COUNT(*) AS count FROM products");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'];
    }

    /**
     * return categories count
     *
     * @return int
     */
    public static function getCategoriesCount(): int
    {
        $db = new Database();
        $db = $db->connect();
        $stmt = $db->prepare("SELECT COUNT(*) AS count FROM categories");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'];
    }
}