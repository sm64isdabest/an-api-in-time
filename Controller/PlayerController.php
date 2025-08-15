<?php

namespace Controller;

use Model\Player;

class PlayerController
{
    // Listar jogadores
    public function getPlayers()
    {
        $player = new Player();
        $players = $player->getPlayers();

        if ($players) {
            header("Content-Type: application/json", true, 200);
            echo json_encode($players);
        } else {
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Nenhum jogador encontrado"]);
        }
    }

    // Buscar jogador por ID
    public function getPlayerById($id)
    {
        $player = new Player();
        $data = $player->getById($id);

        if ($data) {
            header("Content-Type: application/json", true, 200);
            echo json_encode($data);
        } else {
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Jogador não encontrado"]);
        }
    }

    // Buscar jogador por nome de usuário
    public function getPlayerByUsername($username)
    {
        $player = new Player();
        $data = $player->getByUsername($username);

        if ($data) {
            header("Content-Type: application/json", true, 200);
            echo json_encode($data);
        } else {
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Jogador não encontrado"]);
        }
    }

    // Filtrar jogadores por critérios numéricos
    // Exemplo: ?unlocked_hats_min=2&collected_timepieces_max=5
    public function getFilteredPlayers()
    {
        $player = new Player();
        $filters = [
            'unlocked_hats_min' => $_GET['unlocked_hats_min'] ?? null,
            'unlocked_hats_max' => $_GET['unlocked_hats_max'] ?? null,
            'completed_chapters_min' => $_GET['completed_chapters_min'] ?? null,
            'completed_chapters_max' => $_GET['completed_chapters_max'] ?? null,
            'collected_timepieces_min' => $_GET['collected_timepieces_min'] ?? null,
            'collected_timepieces_max' => $_GET['collected_timepieces_max'] ?? null,
        ];

        $data = $player->getFilteredPlayers(array_filter($filters));

        if ($data) {
            header("Content-Type: application/json", true, 200);
            echo json_encode($data);
        } else {
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Jogador não encontrado"]);
        }
    }

    // Criar jogador
    public function createPlayer()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->username) && isset($data->unlocked_hats) && isset($data->completed_chapters) && isset($data->collected_timepieces)) {
            $player = new Player();
            $player->username = $data->username;
            $player->unlocked_hats = $data->unlocked_hats ?? null;
            $player->completed_chapters = $data->completed_chapters ?? null;
            $player->collected_timepieces = $data->collected_timepieces ?? null;

            if ($player->createPlayer()) {
                header("Content-Type: application/json", true, 201);
                echo json_encode(["message" => "Jogador criado com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Falha ao criar jogador"]);
            }
        } else {
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "Dados inválidos"]);
        }
    }

    // Atualizar jogador
    public function updatePlayer()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->id) && isset($data->username) && isset($data->unlocked_hats) && isset($data->completed_chapters) && isset($data->collected_timepieces)) {
            $player = new Player();
            $player->id = $data->id;
            $player->username = $data->username;
            $player->unlocked_hats = $data->unlocked_hats ?? null;
            $player->completed_chapters = $data->completed_chapters ?? null;
            $player->collected_timepieces = $data->collected_timepieces ?? null;

            if ($player->updatePlayer()) {
                header("Content-Type: application/json", true, 200);
                echo json_encode(["message" => "Jogador atualizado com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Falha ao atualizar jogador"]);
            }
        } else {
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "Dados inválidos"]);
        }
    }

    // Deletar jogador
    public function deletePlayer()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $player = new Player();
            $player->id = $id;

            if ($player->deletePlayer()) {
                header("Content-Type: application/json", true, 200);
                echo json_encode(["message" => "Jogador excluído com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Falha ao excluir jogador"]);
            }
        } else {
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "ID inválido"]);
        }
    }
}

?>