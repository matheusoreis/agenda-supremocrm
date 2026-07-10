<?php

namespace SupremoCRM\Agenda\Models;

use PDO;

use SupremoCRM\Agenda\Core\Database;

class StateModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM states ORDER BY name");

        return $stmt->fetchAll();
    }

    public function getById(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM states WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO states (name, abbreviation) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$data['name'], $data['abbreviation']]);
    }

    public function update(int $id, array $data)
    {
        $sql = "UPDATE states SET name = ?, abbreviation = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$data['name'], $data['abbreviation'], $id]);
    }

    public function delete(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM states WHERE id = ?");

        return $stmt->execute([$id]);
    }
}
