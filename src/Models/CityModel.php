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

    public function getAll($search = null)
    {
        $sql = "SELECT ci.*, s.name as state_name, s.abbreviation as state_abbr
            FROM cities ci
            JOIN states s ON ci.state_id = s.id";

        if ($search) {
            $sql .= " WHERE ci.name LIKE :search OR s.name LIKE :search";
            $sql .= " ORDER BY ci.name";

            $stmt = $this->db->prepare($sql);
            $searchTerm = "%{$search}%";
            $stmt->bindParam(':search', $searchTerm);
        } else {
            $sql .= " ORDER BY ci.name";
            $stmt = $this->db->prepare($sql);
        }

        $stmt->execute();

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

    public function getPaginated($search = null, $page = 1, $perPage = 20)
    {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT ci.*, s.name as state_name, s.abbreviation as state_abbr
            FROM cities ci
            JOIN states s ON ci.state_id = s.id";

        $countSql = "SELECT COUNT(*) as total FROM cities ci JOIN states s ON ci.state_id = s.id";

        if ($search) {
            $sql .= " WHERE ci.name LIKE :search OR s.name LIKE :search";
            $countSql .= " WHERE ci.name LIKE :search OR s.name LIKE :search";
        }

        $sql .= " ORDER BY ci.name LIMIT :limit OFFSET :offset";

        $stmtCount = $this->db->prepare($countSql);
        if ($search) {
            $searchTerm = "%{$search}%";
            $stmtCount->bindParam(':search', $searchTerm);
        }

        $stmtCount->execute();
        $total = $stmtCount->fetch()['total'];

        $stmt = $this->db->prepare($sql);
        if ($search) {
            $searchTerm = "%{$search}%";
            $stmt->bindParam(':search', $searchTerm);
        }

        $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll();

        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'lastPage' => ceil($total / $perPage)
        ];
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

    public function getDb()
    {
        return $this->db;
    }
}
