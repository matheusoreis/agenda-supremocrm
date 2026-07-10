<?php

namespace SupremoCRM\Agenda\Models;

use PDO;

use SupremoCRM\Agenda\Core\Database;

class CityModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT ci.*, s.name as state_name, s.abbreviation as state_abbr
                FROM cities ci
                JOIN states s ON ci.state_id = s.id
                ORDER BY ci.name";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function getByState(int $stateId)
    {
        $stmt = $this->db->prepare("SELECT * FROM cities WHERE state_id = ? ORDER BY name");
        $stmt->execute([$stateId]);

        return $stmt->fetchAll();
    }

    public function getById(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM cities WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO cities (name, state_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$data['name'], $data['state_id']]);
    }

    public function update(int $id, array $data)
    {
        $sql = "UPDATE cities SET name = ?, state_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$data['name'], $data['state_id'], $id]);
    }

    public function delete(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM cities WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
