<?php

namespace Model;

use PDO;
use Model\Connection;

class Hat
{
    private $conn;
    public $id;
    public $name;
    public $icon_url;
    public $ability;
    public $yarn_cost;
    public $created_at;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    // Listar todos
    public function getHats()
    {
        $sql = "SELECT * FROM hats";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar por ID
    public function getById($id)
    {
        $sql = "SELECT * FROM hats WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar por nome
    public function getByName($name)
    {
        $sql = "SELECT * FROM hats WHERE name LIKE :name";
        $stmt = $this->conn->prepare($sql);
        $search = "%" . $name . "%";
        $stmt->bindParam(":name", $search, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar por habilidade
    public function getByAbility($ability)
    {
        $sql = "SELECT * FROM hats WHERE ability LIKE :ability";
        $stmt = $this->conn->prepare($sql);
        $search = "%" . $ability . "%";
        $stmt->bindParam(":ability", $search, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Filtrar chapéus com base em critérios numéricos
    public function getFilteredHats($filters = [])
    {
        $sql = "SELECT * FROM hats WHERE 1=1";
        $params = [];

        // Filtros numéricos para custo de fio
        if (!empty($filters['yarn_cost_min'])) {
            $sql .= " AND yarn_cost >= :yarn_cost_min";
            $params[':yarn_cost_min'] = (int) $filters['yarn_cost_min'];
        }
        if (!empty($filters['yarn_cost_max'])) {
            $sql .= " AND yarn_cost <= :yarn_cost_max";
            $params[':yarn_cost_max'] = (int) $filters['yarn_cost_max'];
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Criar chapéu
    public function createHat()
    {
        $sql = "INSERT INTO hats 
            (name, icon_url, ability, yarn_cost, created_at) 
            VALUES (:name, :icon_url, :ability, :yarn_cost, NOW())";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':icon_url', $this->icon_url, PDO::PARAM_STR);
        $stmt->bindParam(':ability', $this->ability, PDO::PARAM_STR);
        $stmt->bindValue(':yarn_cost', $this->yarn_cost, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Atualizar chapéu
    public function updateHat()
    {
        $sql = "UPDATE hats 
            SET name = :name, icon_url = :icon_url, ability = :ability, 
                yarn_cost = :yarn_cost 
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':icon_url', $this->icon_url, PDO::PARAM_STR);
        $stmt->bindParam(':ability', $this->ability, PDO::PARAM_STR);
        $stmt->bindParam(':yarn_cost', $this->yarn_cost, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Excluir chapéu
    public function deleteHat()
    {
        $sql = "DELETE FROM hats WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

?>