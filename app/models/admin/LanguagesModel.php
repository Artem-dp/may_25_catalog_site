<?php

namespace app\models\admin;

use app\core\Database;
use app\core\Model;

class LanguagesModel extends Database
{
    private \mysqli $db;
    public function __construct()
    {
        $this->db = $this->connect();
    }

    public function getAll(): array
    {
        $rows = $this->db->query("SELECT * FROM langs ORDER BY id ASC");
        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'id'   => (int)$row['id'],
                'code' => $row['code'],
                'name' => $row['name']
            ];
        }

        return $result;
    }

    public function add(string $code, string $name): void
    {
        $this->db->query(
            "INSERT INTO languages (code, name) VALUES (:code, :name)",
            [
                ':code' => $code,
                ':name' => $name
            ]
        );
    }

    public function delete(int $id): void
    {
        $this->db->query(
            "DELETE FROM languages WHERE id = :id",
            [
                ':id' => $id
            ]
        );
    }
}