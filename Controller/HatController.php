<?php

namespace Controller;

use Model\Hat;

class HatController
{
    // Listar chapéus
    public function getHats()
    {
        $hat = new Hat();
        $hats = $hat->getHats();

        if ($hats) {
            header("Content-Type: application/json", true, 200);
            echo json_encode($hats);
        } else {
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Nenhum chapéu encontrado"]);
        }
    }

    // Buscar chapéu por ID
    public function getHatById($id)
    {
        $hat = new Hat();
        $data = $hat->getById($id);

        if ($data) {
            header("Content-Type: application/json", true, 200);
            echo json_encode($data);
        } else {
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Chapéu não encontrado"]);
        }
    }

    // Buscar chapéu por nome
    public function getHatByName($name)
    {
        $hat = new Hat();
        $data = $hat->getByName($name);

        if ($data) {
            header("Content-Type: application/json", true, 200);
            echo json_encode($data);
        } else {
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Chapéu não encontrado"]);
        }
    }

    // Criar chapéu
    public function createHat()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->name) && isset($data->icon_url) && isset($data->ability) && isset($data->yarn_cost)) {
            $hat = new Hat();
            $hat->name = $data->name;
            $hat->icon_url = $data->icon_url;
            $hat->ability = $data->ability;
            $hat->yarn_cost = $data->yarn_cost ?? null;

            if ($hat->createHat()) {
                header("Content-Type: application/json", true, 201);
                echo json_encode(["message" => "Chapéu criado com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Falha ao criar chapéu"]);
            }
        } else {
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "Dados inválidos"]);
        }
    }

    // Atualizar chapéu
    public function updateHat()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->id) && isset($data->name) && isset($data->icon_url) && isset($data->ability) && isset($data->yarn_cost)) {
            $hat = new Hat();
            $hat->id = $data->id;
            $hat->name = $data->name;
            $hat->icon_url = $data->icon_url;
            $hat->ability = $data->ability;
            $hat->yarn_cost = $data->yarn_cost ?? null;

            if ($hat->updateHat()) {
                header("Content-Type: application/json", true, 200);
                echo json_encode(["message" => "Chapéu atualizado com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Falha ao atualizar chapéu"]);
            }
        } else {
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "Dados inválidos"]);
        }
    }

    // Deletar chapéu
    public function deleteHat()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $hat = new Hat();
            $hat->id = $id;

            if ($hat->deleteHat()) {
                header("Content-Type: application/json", true, 200);
                echo json_encode(["message" => "Chapéu excluído com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Falha ao excluir chapéu"]);
            }
        } else {
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "ID inválido"]);
        }
    }
}

?>