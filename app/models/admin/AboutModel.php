<?php
namespace app\models\admin;

use app\core\Database;
use mysqli;

class AboutModel
{
    private mysqli $db;

    private const OPTION_ID = 1;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    /**
     * Получить заголовок и контент раздела "О нас" для нужного языка.
     * @param string $langCode 'ru' | 'uk' | 'en'
     * @return array {title, content, lang}
     */
    public function getByLang(string $langCode): array
    {
        $sql = "
            SELECT 
                options_langs.name   AS title,
                options_langs.value  AS content,
                langs.code           AS lang
            FROM options
            JOIN options_langs 
                ON options_langs.option_id = options.id
            JOIN langs 
                ON langs.id = options_langs.lang_id
            WHERE options.id = ? 
              AND langs.code  = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $var1 = self::OPTION_ID;
        $stmt->bind_param('is', $var1, $langCode);
        $stmt->execute();

        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();

        return $row ?: ['title' => '', 'content' => '', 'lang' => $langCode];
    }

    /**
     * Создать/обновить перевод "О нас" для выбранного языка.
     * Вставка в options с фиксированным id (OPTION_ID) выполняется автоматически.
     */
    public function upsert(string $langCode, string $title, ?string $content): bool
    {
        // 1) гарантируем наличие строки в options с нужным id
        $sqlEnsureOption = "
            INSERT INTO options (id, created_at)
            VALUES (?, NOW())
            ON DUPLICATE KEY UPDATE id = id
        ";
        $stmt = $this->db->prepare($sqlEnsureOption);
        $OPTION_ID = self::OPTION_ID;
        $stmt->bind_param('i', $OPTION_ID);
        $stmt->execute();
        $stmt->close();

        // 2) получаем lang_id по коду языка
        $sqlLang = "SELECT id FROM langs WHERE code = ? LIMIT 1";
        $stmt = $this->db->prepare($sqlLang);
        $stmt->bind_param('s', $langCode);
        $stmt->execute();
        $langRow = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$langRow) {
            return false; // нет такого языка
        }
        $langId = (int)$langRow['id'];

        // 3) апсерт перевода в options_langs
        $sqlUpsert = "
            INSERT INTO options_langs (option_id, lang_id, name, value)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                name  = VALUES(name),
                value = VALUES(value)
        ";
        $stmt = $this->db->prepare($sqlUpsert);
        $stmt->bind_param('iiss', $OPTION_ID, $langId, $title, $content);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}
