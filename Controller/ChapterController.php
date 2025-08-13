<?php

namespace Controller;

use Model\Chapter;

class ChapterController
{
    // Listar capítulos
    public function getChapters()
    {
        $chapter = new Chapter();
        $chapters = $chapter->getChapters();

        if ($chapters) {
            header("Content-Type: application/json", true, 200);
            echo json_encode($chapters);
        } else {
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Nenhum capítulo encontrado"]);
        }
    }

    // Buscar capítulo por ID
    public function getChapterById($id)
    {
        $chapter = new Chapter();
        $data = $chapter->getById($id);

        if ($data) {
            header("Content-Type: application/json", true, 200);
            echo json_encode($data);
        } else {
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Capítulo não encontrado"]);
        }
    }

    // Buscar capítulo por nome
    public function getChapterByName($name)
    {
        $chapter = new Chapter();
        $data = $chapter->getByName($name);

        if ($data) {
            header("Content-Type: application/json", true, 200);
            echo json_encode($data);
        } else {
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Capítulo não encontrado"]);
        }
    }

    // Buscar capítulo por nome do chefe
    public function getChapterByBossName($boss_name)
    {
        $chapter = new Chapter();
        $data = $chapter->getByBossName($boss_name);

        if ($data) {
            header("Content-Type: application/json", true, 200);
            echo json_encode($data);
        } else {
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Capítulo não encontrado"]);
        }
    }

    // Filtrar capítulos por critérios numéricos
    // Exemplo: ?acts_min=2&timepieces_max=5
    public function getFilteredChapters()
    {
        $chapter = new Chapter();
        $filters = [
            'acts_min' => $_GET['acts_min'] ?? null,
            'acts_max' => $_GET['acts_max'] ?? null,
            'timepieces_min' => $_GET['timepieces_min'] ?? null,
            'timepieces_max' => $_GET['timepieces_max'] ?? null,
            'time_rifts_min' => $_GET['time_rifts_min'] ?? null,
            'time_rifts_max' => $_GET['time_rifts_max'] ?? null,
        ];

        $data = $chapter->getFilteredChapters(array_filter($filters));

        if ($data) {
            header("Content-Type: application/json", true, 200);
            echo json_encode($data);
        } else {
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Capítulo não encontrado"]);
        }
    }

    // Criar capítulo
    public function createChapter()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->name) && isset($data->description) && isset($data->acts) && isset($data->time_rifts) && isset($data->timepieces) && isset($data->boss_name)) {
            $chapter = new Chapter();
            $chapter->name = $data->name;
            $chapter->description = $data->description;
            $chapter->acts = $data->acts ?? null;
            $chapter->time_rifts = $data->time_rifts ?? null;
            $chapter->timepieces = $data->timepieces ?? null;
            $chapter->boss_name = $data->boss_name ?? null;

            if ($chapter->createChapter()) {
                header("Content-Type: application/json", true, 201);
                echo json_encode(["message" => "Capítulo criado com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Falha ao criar capítulo"]);
            }
        } else {
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "Dados inválidos"]);
        }
    }

    // Atualizar capítulo
    public function updateChapter()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->id) && isset($data->name) && isset($data->description) && isset($data->acts) && isset($data->timepieces) && isset($data->time_rifts) && isset($data->boss_name)) {
            $chapter = new Chapter();
            $chapter->id = $data->id;
            $chapter->name = $data->name;
            $chapter->description = $data->description;
            $chapter->acts = $data->acts ?? null;
            $chapter->time_rifts = $data->time_rifts ?? null;
            $chapter->timepieces = $data->timepieces ?? null;
            $chapter->boss_name = $data->boss_name ?? null;

            if ($chapter->updateChapter()) {
                header("Content-Type: application/json", true, 200);
                echo json_encode(["message" => "Capítulo atualizado com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Falha ao atualizar capítulo"]);
            }
        } else {
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "Dados inválidos"]);
        }
    }

    // Deletar capítulo
    public function deleteChapter()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $chapter = new Chapter();
            $chapter->id = $id;

            if ($chapter->deleteChapter()) {
                header("Content-Type: application/json", true, 200);
                echo json_encode(["message" => "Capítulo excluído com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Falha ao excluir capítulo"]);
            }
        } else {
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "ID inválido"]);
        }
    }
}

?>