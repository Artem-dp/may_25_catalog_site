<?php
namespace app\models\admin;

use app\core\Database;
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
        $stmt = $this->db->prepare("SELECT id FROM langs WHERE code = ? LIMIT 1");
        if (!$stmt) {
            throw new \RuntimeException("Prepare failed: " . $this->db->error);
        }
//        $$this->getByLang($langCode)
        $stmt->bind_param('s', $langCode);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if (!$row) {
            return false;
        }
        $langId = (int)$row['id'];

        $sqlUpsert = "
        INSERT INTO options_langs (lang_id, name, value)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE
            name  = VALUES(name),
            value = VALUES(value)
    ";

        $stmt = $this->db->prepare($sqlUpsert);
        if (!$stmt) {
            throw new \RuntimeException("Prepare failed: " . $this->db->error);
        }

        $stmt->bind_param('iss',$langId, $title, $content);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}
