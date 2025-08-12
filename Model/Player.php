<?php

namespace Model;

use PDO;
use Model\Connection;

class Player
{
    private $conn;
    public $id;
    public $username;
    public $current_hat_id;
    public $unlocked_hats; // transformar em array de IDs de chapéus desbloqueados
    public $completed_chapters; // transformar em array de IDs de capítulos completados
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

    // Criar capítulo
    public function createPlayer()
    {
        $sql = "INSERT INTO players
            (username, current_hat_id, unlocked_hats, completed_chapters, collected_timepieces, created_at)
            VALUES (:username, :current_hat_id, :unlocked_hats, :completed_chapters, :collected_timepieces, NOW())";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":username" => $this->username,
            ":current_hat_id" => $this->current_hat_id,
            ":unlocked_hats" => $this->unlocked_hats,
            ":completed_chapters" => $this->completed_chapters,
            ":collected_timepieces" => $this->collected_timepieces
        ]);
    }

    // Atualizar capítulo
    public function updatePlayer()
    {
        $sql = "UPDATE players
            SET username = :username, current_hat_id = :current_hat_id, unlocked_hats = :unlocked_hats,
            completed_chapters = :completed_chapters, collected_timepieces = :collected_timepieces
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":id" => $this->id,
            ":name" => $this->name,
            ":icon_url" => $this->icon_url,
            ":ability" => $this->ability,
            ":yarn_cost" => $this->yarn_cost
        ]);
    }

    // Excluir capítulo
    public function deleteHat()
    {
        $sql = "DELETE FROM hats WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}

?>