<?php

namespace SupremoCRM\Agenda\Models;

use PDO;

use SupremoCRM\Agenda\Core\Database;

/**
 * Model de Estados.
 * 
 * Gerencia operações CRUD e consultas para estados
 */
class StateModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Busca todos os estados.
     * 
     * @param string|null $search Termo de busca
     * 
     * @return array Lista de estados
     */
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

    /**
     * Busca estados com paginação.
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

        $sql = "SELECT * FROM states";
        $countSql = "SELECT COUNT(*) as total FROM states";

        if ($search) {
            $sql .= " WHERE name LIKE :search OR abbreviation LIKE :search";
            $countSql .= " WHERE name LIKE :search OR abbreviation LIKE :search";
        }

        $sql .= " ORDER BY name LIMIT :limit OFFSET :offset";

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
     * Busca estado por ID.
     * 
     * @param int $id ID do estado
     * 
     * @return array|false Dados do estado ou false
     */
    public function getById(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM states WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Busca estado por ID do IBGE.
     * 
     * @param int $ibgeId Código IBGE do estado
     * 
     * @return array|false Dados do estado ou false
     */
    public function getByIbgeId(int $ibgeId)
    {
        $stmt = $this->db->prepare("SELECT * FROM states WHERE ibge_id = ?");
        $stmt->execute([$ibgeId]);
        return $stmt->fetch();
    }

    /**
     * Cria um novo estado.
     * 
     * @param array $data Dados do estado
     * 
     * @return bool True em sucesso
     */
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

    /**
     * Atualiza um estado.
     * 
     * @param int $id ID do estado
     * @param array $data Dados atualizados
     * 
     * @return bool True em sucesso
     */
    public function update(int $id, array $data)
    {
        $sql = "UPDATE states SET name = ?, abbreviation = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['name'], $data['abbreviation'], $id]);
    }

    /**
     * Exclui um estado.
     * 
     * @param int $id ID do estado
     * 
     * @return bool True em sucesso
     */
    public function delete(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM states WHERE id = ?");
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
