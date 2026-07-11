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

    public function getAll($search = null)
    {
        $sql = "SELECT * FROM states";

        if ($search) {
            $sql .= " WHERE name LIKE :search OR abbreviation LIKE :search";
            $sql .= " ORDER BY name";

            $stmt = $this->db->prepare($sql);
            $searchTerm = "%{$search}%";
            $stmt->bindParam(':search', $searchTerm);
        } else {
            $sql .= " ORDER BY name";
            $stmt = $this->db->prepare($sql);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPaginated($search = null, $page = 1, $perPage = 20)
    {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM states";
        $countSql = "SELECT COUNT(*) as total FROM states";

        if ($search) {
            $sql .= " WHERE name LIKE :search OR abbreviation LIKE :search";
            $countSql .= " WHERE name LIKE :search OR abbreviation LIKE :search";
        }

        $sql .= " ORDER BY name LIMIT :limit OFFSET :offset";

        // Contar total
        $stmtCount = $this->db->prepare($countSql);
        if ($search) {
            $searchTerm = "%{$search}%";
            $stmtCount->bindParam(':search', $searchTerm);
        }
        $stmtCount->execute();
        $total = $stmtCount->fetch()['total'];

        // Buscar dados
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

    public function getById(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM states WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByIbgeId(int $ibgeId)
    {
        $stmt = $this->db->prepare("SELECT * FROM states WHERE ibge_id = ?");
        $stmt->execute([$ibgeId]);
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO states (ibge_id, name, abbreviation) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['ibge_id'],
            $data['name'],
            $data['abbreviation']
        ]);
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

    public function getDb()
    {
        return $this->db;
    }
}
