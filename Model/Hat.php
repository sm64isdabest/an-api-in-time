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
        $sql = "SELECT * FROM hats WHERE name = :name";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Criar chapéu
    public function createHat()
    {
        $sql = "INSERT INTO hats
            (name, icon_url, ability, yarn_cost, created_at)
            VALUES (:name, :icon_url, :ability, :yarn_cost, NOW())";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":name" => $this->name,
            ":icon_url" => $this->icon_url,
            ":ability" => $this->ability,
            ":yarn_cost" => $this->yarn_cost
        ]);
    }

    // Atualizar chapéu
    public function updateHat()
    {
        $sql = "UPDATE hats
            SET name = :name, icon_url = :icon_url, ability = :ability, yarn_cost = :yarn_cost
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

    // Excluir chapéu
    public function deleteHat()
    {
        $sql = "DELETE FROM hats WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}

?>