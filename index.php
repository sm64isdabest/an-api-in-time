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

switch ($endpoint) {
    // Capítulos
    case 'chapters':
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $chapterController->getChapterById($_GET['id']);
                } elseif (isset($_GET['name'])) {
                    $chapterController->getChapterByName($_GET['name']);
                } elseif (isset($_GET['boss_name'])) {
                    $chapterController->getChapterByBossName($_GET['boss_name']);
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
                echo json_encode(["message" => "Method not allowed"]);
                break;
        }
        break;

    // Chapéus
    case 'hats':
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $chapterController->getChapterById($_GET['id']);
                } elseif (isset($_GET['name'])) {
                    $chapterController->getChapterByName($_GET['name']);
                } elseif (isset($_GET['boss_name'])) {
                    $chapterController->getChapterByBossName($_GET['boss_name']);
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
                echo json_encode(["message" => "Method not allowed"]);
                break;
        }
        break;

    // Jogadores
    case 'players':
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $chapterController->getChapterById($_GET['id']);
                } elseif (isset($_GET['name'])) {
                    $chapterController->getChapterByName($_GET['name']);
                } elseif (isset($_GET['boss_name'])) {
                    $chapterController->getChapterByBossName($_GET['boss_name']);
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
                echo json_encode(["message" => "Method not allowed"]);
                break;
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["message" => "Endpoint not found"]);
        break;
}

?>