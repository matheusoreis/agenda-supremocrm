<?php

namespace SupremoCRM\Agenda\Core;

use PDO;
use PDOException;


/**
 * Gerenciador de conexão com banco de dados
 * 
 * Singleton para garantir uma única instância da conexão.
 */
class Database
{
    private static ?Database $instance = null;
    private PDO $connection;


    /**
     * Impede instância direta.
     * 
     * Configura e estabelece a conexão com o banco de dados usando
     * as credenciais definidas.
     * 
     * @throws PDOException Em caso de falha na conexão
     */
    private function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";

            $this->connection = new PDO(
                $dsn,
                $config['username'],
                $config['password']
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Obtém a instância única da classe.
     * 
     * Se a instância ainda não foi criada, cria uma nova.
     * Caso contrário, retorna a instância existente.
     * 
     * @return Database A instância única da classe
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Retorna o objeto PDO de conexão.
     * 
     * Método público para acessar a conexão PDO diretamente,
     * permitindo a execução de consultas SQL preparadas.
     * 
     * @return PDO O objeto de conexão PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
