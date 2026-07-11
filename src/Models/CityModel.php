<?php

namespace SupremoCRM\Agenda\Models;

use PDO;

use SupremoCRM\Agenda\Core\Database;

/**
 * Model de Cidades
 * 
 * Gerencia operações CRUD e consultas para cidades.
 */
class CityModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Busca todas as cidades com dados dos estados.
     * 
     * @param string|null $search Termo de busca (nome da cidade ou estado)
     * 
     * @return array Lista de cidades
     */
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

    /**
     * Busca cidades por estado.
     * 
     * @param int $stateId ID do estado
     * 
     * @return array Lista de cidades do estado
     */
    public function getByState(int $stateId)
    {
        $stmt = $this->db->prepare("SELECT * FROM cities WHERE state_id = ? ORDER BY name");
        $stmt->execute([$stateId]);

        return $stmt->fetchAll();
    }

    /**
     * Busca cidade por ID.
     * 
     * @param int $id ID da cidade
     * 
     * @return array|false Dados da cidade ou false se não encontrada
     */
    public function getById(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM cities WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    /**
     * Busca cidades com paginação.
     * 
     * @param string|null $search Termo de busca
     * @param int $page Página atual
     * @param int $perPage Itens por página
     * 
     * @return array Dados paginados
     */
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

    /**
     * Cria uma nova cidade.
     * 
     * @param array $data Dados da cidade (name, state_id)
     * 
     * @return bool True em sucesso
     */
    public function create(array $data)
    {
        $sql = "INSERT INTO cities (name, state_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$data['name'], $data['state_id']]);
    }

    /**
     * Atualiza uma cidade.
     * 
     * @param int $id ID da cidade
     * @param array $data Dados atualizados
     * 
     * @return bool True em sucesso
     */
    public function update(int $id, array $data)
    {
        $sql = "UPDATE cities SET name = ?, state_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$data['name'], $data['state_id'], $id]);
    }

    /**
     * Exclui uma cidade.
     * 
     * @param int $id ID da cidade
     * 
     * @return bool True em sucesso
     */
    public function delete(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM cities WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Retorna a conexão PDO.
     * 
     * @return PDO Objeto PDO
     */
    public function getDb()
    {
        return $this->db;
    }
}
