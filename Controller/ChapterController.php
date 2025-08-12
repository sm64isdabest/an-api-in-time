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

        if (isset($data->id) && isset($data->name) && isset($data->description)) {
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