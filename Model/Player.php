<?php

namespace Model;

use PDO;
use Model\Connection;

class Player
{
    private $conn;
    public $id;
    public $username;
    public $unlocked_hats;
    public $completed_chapters;
    public $collected_timepieces;
    public $created_at;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    // Listar todos
    public function getPlayers()
    {
        $sql = "SELECT * FROM players";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar por ID
    public function getById($id)
    {
        $sql = "SELECT * FROM players WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar por nome de usuário
    public function getByUsername($username)
    {
        $sql = "SELECT * FROM players WHERE username LIKE :username";
        $stmt = $this->conn->prepare($sql);
        $search = "%" . $username . "%";
        $stmt->bindParam(":username", $search, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Filtrar jogadores com base em critérios numéricos
    public function getFilteredPlayers($filters = [])
    {
        $sql = "SELECT * FROM players WHERE 1=1";
        $params = [];

        // Filtros numéricos para chapéus desbloqueados
        if (!empty($filters['unlocked_hats_min'])) {
            $sql .= " AND unlocked_hats >= :unlocked_hats_min";
            $params[':unlocked_hats_min'] = (int) $filters['unlocked_hats_min'];
        }
        if (!empty($filters['unlocked_hats_max'])) {
            $sql .= " AND unlocked_hats <= :unlocked_hats_max";
            $params[':unlocked_hats_max'] = (int) $filters['unlocked_hats_max'];
        }

        // Filtros numéricos para cápitulos concluídos
        if (!empty($filters['completed_chapters_min'])) {
            $sql .= " AND completed_chapters >= :completed_chapters_min";
            $params[':completed_chapters_min'] = (int) $filters['completed_chapters_min'];
        }
        if (!empty($filters['completed_chapters_max'])) {
            $sql .= " AND completed_chapters <= :completed_chapters_max";
            $params[':completed_chapters_max'] = (int) $filters['completed_chapters_max'];
        }

        // Filtros numéricos para ampulhetas coletadas
        if (!empty($filters['collected_timepieces_min'])) {
            $sql .= " AND collected_timepieces >= :collected_timepieces_min";
            $params[':collected_timepieces_min'] = (int) $filters['collected_timepieces_min'];
        }
        if (!empty($filters['collected_timepieces_max'])) {
            $sql .= " AND collected_timepieces <= :collected_timepieces_max";
            $params[':collected_timepieces_max'] = (int) $filters['collected_timepieces_max'];
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Criar jogadores
    public function createPlayer()
    {
        $sql = "INSERT INTO players 
            (username, unlocked_hats, completed_chapters, collected_timepieces, created_at) 
            VALUES (:username, :unlocked_hats, :completed_chapters, :collected_timepieces, NOW())";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':unlocked_hats', $this->unlocked_hats, PDO::PARAM_INT);
        $stmt->bindParam(':completed_chapters', $this->completed_chapters, PDO::PARAM_INT);
        $stmt->bindValue(':collected_timepieces', $this->collected_timepieces, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Atualizar jogador
    public function updatePlayer()
    {
        $sql = "UPDATE players 
            SET username = :username, unlocked_hats = :unlocked_hats, completed_chapters = :completed_chapters, 
                collected_timepieces = :collected_timepieces 
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':unlocked_hats', $this->unlocked_hats, PDO::PARAM_INT);
        $stmt->bindParam(':completed_chapters', $this->completed_chapters, PDO::PARAM_INT);
        $stmt->bindValue(':collected_timepieces', $this->collected_timepieces, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Excluir jogador
    public function deletePlayer()
    {
        $sql = "DELETE FROM players WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

?>