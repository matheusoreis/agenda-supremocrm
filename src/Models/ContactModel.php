<?php

namespace SupremoCRM\Agenda\Models;

use PDO;

use SupremoCRM\Agenda\Core\Database;

class ContactModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll($search = null)
    {
        $sql = "SELECT c.*, 
                ci.name as city_name, 
                s.name as state_name,
                s.abbreviation as state_abbr
                FROM contacts c
                LEFT JOIN cities ci ON c.city_id = ci.id
                LEFT JOIN states s ON c.state_id = s.id";

        if ($search) {
            $sql .= " WHERE c.name LIKE :search 
                     OR c.phone LIKE :search 
                     OR ci.name LIKE :search 
                     OR s.name LIKE :search";
        }

        $sql .= " ORDER BY c.name ASC";

        $stmt = $this->db->prepare($sql);

        if ($search) {
            $searchTerm = "%{$search}%";
            $stmt->bindParam(':search', $searchTerm);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById(int $id)
    {
        $sql = "SELECT c.*, 
                ci.name as city_name, 
                s.name as state_name,
                s.abbreviation as state_abbr
                FROM contacts c
                LEFT JOIN cities ci ON c.city_id = ci.id
                LEFT JOIN states s ON c.state_id = s.id
                WHERE c.id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO contacts (name, phone, city_id, state_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['name'],
            $data['phone'],
            $data['city_id'],
            $data['state_id']
        ]);
    }

    public function update(int $id, array $data)
    {
        $sql = "UPDATE contacts SET name = ?, phone = ?, city_id = ?, state_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['name'],
            $data['phone'],
            $data['city_id'],
            $data['state_id'],
            $id
        ]);
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM contacts WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }
}
