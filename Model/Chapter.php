<?php

namespace Model;

use PDO;
use Model\Connection;

class Chapter
{
    private $conn;
    public $id;
    public $name;
    public $description;
    public $acts;
    public $time_rifts;
    public $timepieces;
    public $boss_name;
    public $created_at;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    // Listar todos
    public function getChapters()
    {
        $sql = "SELECT * FROM chapters";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar por ID
    public function getById($id)
    {
        $sql = "SELECT * FROM chapters WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Criar capítulo
    public function createChapter()
    {
        $sql = "INSERT INTO chapters 
            (name, description, acts, time_rifts, timepieces, boss_name, created_at) 
            VALUES (:name, :description, :acts, :time_rifts, :timepieces, :boss_name, NOW())";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':acts', $this->acts, PDO::PARAM_INT);
        $stmt->bindParam(':time_rifts', $this->time_rifts, PDO::PARAM_INT);
        $stmt->bindParam(':timepieces', $this->timepieces, PDO::PARAM_INT);
        $stmt->bindParam(':boss_name', $this->boss_name, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Atualizar capítulo
    public function updateChapter()
    {
        $sql = "UPDATE chapters 
            SET name = :name, description = :description, acts = :acts, 
                time_rifts = :time_rifts, timepieces = :timepieces, boss_name = :boss_name 
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":id" => $this->id,
            ":name" => $this->name,
            ":description" => $this->description,
            ":acts" => $this->acts,
            ":time_rifts" => $this->time_rifts,
            ":timepieces" => $this->timepieces,
            ":boss_name" => $this->boss_name
        ]);
    }

    // Excluir capítulo
    public function deleteChapter()
    {
        $sql = "DELETE FROM chapters WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}

?>