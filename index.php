<?php

require_once __DIR__ . '/vendor/autoload.php';

use Controller\ChapterController;
use Controller\HatController;
// use Controller\PlayerController;

$chapterController = new ChapterController();
$hatController = new HatController();
// $playerController = new PlayerController();

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? null;

// header("Content-Type: application/json; charset=utf-8");

switch ($endpoint) {
    case 'chapters':
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $chapterController->getChapterById($_GET['id']);
                } else {
                    $chapterController->getChapters();
                }
                break;
            case 'POST':
                $chapterController->createChapter();
                break;
            case 'PUT':
                $chapterController->updateChapter();
                break;
            case 'DELETE':
                $chapterController->deleteChapter();
                break;
            default:
                http_response_code(405);
                echo $method;
                echo json_encode(["message" => "Method not allowed"]);
                break;
        }
        break;

    // Exemplo para futuras rotas
    /*
    case 'hats':
        // similar estrutura para hats
        break;
    case 'players':
        // similar estrutura para players
        break;
    */

    default:
        http_response_code(404);
        echo json_encode(["message" => "Endpoint not found"]);
        break;
}

?>