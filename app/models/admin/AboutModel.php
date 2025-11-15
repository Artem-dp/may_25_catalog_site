<?php
namespace app\models\admin;

use app\core\Database;
use app\core\Language;
use mysqli;

class AboutModel
{
    private mysqli $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function getByLang(string $langCode): array
    {
        $sql = "
            SELECT 
                options_langs.name   AS title,
                options_langs.value  AS content,
                langs.code           AS lang
            FROM options_langs 
            JOIN langs 
                ON langs.id = options_langs.lang_id
            WHERE langs.code  = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $langCode);
        $stmt->execute();

        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();

        return $row ?: ['title' => '', 'content' => '', 'lang' => $langCode];
    }


    public function save(string $langCode, string $title, ?string $content): bool
    {
        $langs = Language::getLanguages();

        $lang = array_find($langs, function ($lang) use ($langCode) {
            return $lang['code'] === $langCode;
        });

        $langId = $lang['id'];

        $optionId = $this->getOrCreateOptionId($langId);

        $sqlUpsert = "
        INSERT INTO options_langs (option_id, lang_id, name, value)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            name  = VALUES(name),
            value = VALUES(value)
    ";

        $stmt = $this->db->prepare($sqlUpsert);
        if (!$stmt) {
            throw new \RuntimeException("Prepare failed: " . $this->db->error);
        }

        $stmt->bind_param('iiss', $optionId, $langId, $title, $content);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    private function getOrCreateOptionId(int $langId): int
    {
        $sql = "SELECT option_id FROM options_langs WHERE lang_id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $langId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row) {
            return (int)$row['option_id'];
        }

        // Якщо не знайдено, створюємо новий
        return $this->createOption();
    }

    private function createOption(): int
    {
        $sqlOption = 'INSERT INTO options (created_at) VALUES (CURRENT_TIMESTAMP)';
        $stmt = $this->db->prepare($sqlOption);
        $stmt->execute();
        $insertId = $this->db->insert_id;
        $stmt->close();

        return $insertId;
    }
}
