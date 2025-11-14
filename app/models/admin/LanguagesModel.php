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
        $stmt = $this->db->prepare("INSERT INTO langs (`name`, `code`) VALUES (?, ?)");
        $stmt->bind_param('ss', $name, $code);
        $stmt->execute();
        $stmt->close();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM langs WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}