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

    // Buscar por nome
    public function getByName($name)
    {
        $sql = "SELECT * FROM chapters WHERE name LIKE :name";
        $stmt = $this->conn->prepare($sql);
        $search = "%" . $name . "%";
        $stmt->bindParam(":name", $search, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar por nome do chefe
    public function getByBossName($boss_name)
    {
        $sql = "SELECT * FROM chapters WHERE boss_name LIKE :boss_name";
        $stmt = $this->conn->prepare($sql);
        $search = "%" . $boss_name . "%";
        $stmt->bindParam(":boss_name", $search, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Filtrar capítulos com base em critérios numéricos
    public function getFilteredChapters($filters = [])
    {
        $sql = "SELECT * FROM chapters WHERE 1=1";
        $params = [];

        // Filtros numéricos para Atos
        if (!empty($filters['acts_min'])) {
            $sql .= " AND acts >= :acts_min";
            $params[':acts_min'] = (int) $filters['acts_min'];
        }
        if (!empty($filters['acts_max'])) {
            $sql .= " AND acts <= :acts_max";
            $params[':acts_max'] = (int) $filters['acts_max'];
        }

        // Filtros numéricos para Timepieces
        if (!empty($filters['timepieces_min'])) {
            $sql .= " AND timepieces >= :timepieces_min";
            $params[':timepieces_min'] = (int) $filters['timepieces_min'];
        }
        if (!empty($filters['timepieces_max'])) {
            $sql .= " AND timepieces <= :timepieces_max";
            $params[':timepieces_max'] = (int) $filters['timepieces_max'];
        }

        // Filtros numéricos para Time Rifts
        if (!empty($filters['time_rifts_min'])) {
            $sql .= " AND time_rifts >= :time_rifts_min";
            $params[':time_rifts_min'] = (int) $filters['time_rifts_min'];
        }
        if (!empty($filters['time_rifts_max'])) {
            $sql .= " AND time_rifts <= :time_rifts_max";
            $params[':time_rifts_max'] = (int) $filters['time_rifts_max'];
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        $stmt->bindValue(':time_rifts', $this->time_rifts, PDO::PARAM_STR);
        $stmt->bindParam(':timepieces', $this->timepieces, PDO::PARAM_INT);
        $stmt->bindValue(':boss_name', $this->boss_name, PDO::PARAM_STR);

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

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
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

    // Excluir capítulo
    public function deleteChapter()
    {
        $sql = "DELETE FROM chapters WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

?>