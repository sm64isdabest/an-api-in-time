<?php

require_once __DIR__ . '/vendor/autoload.php';

use Controller\ChapterController;
use Controller\HatController;
use Controller\PlayerController;

$chapterController = new ChapterController();
$hatController = new HatController();
$playerController = new PlayerController();

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
                } elseif (
                    isset($_GET['acts_min']) || isset($_GET['acts_max']) ||
                    isset($_GET['timepieces_min']) || isset($_GET['timepieces_max']) ||
                    isset($_GET['time_rifts_min']) || isset($_GET['time_rifts_max'])
                ) {
                    $chapterController->getFilteredChapters();
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
                    $hatController->getHatById($_GET['id']);
                } elseif (isset($_GET['name'])) {
                    $hatController->getHatByName($_GET['name']);
                } elseif (isset($_GET['ability'])) {
                    $hatController->getHatByAbility($_GET['ability']);
                } elseif (
                    isset($_GET['yarn_cost_min']) || isset($_GET['yarn_cost_max'])
                ) {
                    $hatController->getFilteredHats();
                } else {
                    $hatController->getHats();
                }
                break;
            case 'POST':
                $hatController->createHat();
                break;
            case 'PUT':
                $hatController->updateHat();
                break;
            case 'DELETE':
                $hatController->deleteHat();
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
                    $playerController->getPlayerById($_GET['id']);
                } elseif (isset($_GET['username'])) {
                    $playerController->getPlayerByUsername($_GET['username']);
                } elseif (
                    isset($_GET['unlocked_hats_min']) || isset($_GET['unlocked_hats_max']) ||
                    isset($_GET['completed_chapters_min']) || isset($_GET['completed_chapters_max']) ||
                    isset($_GET['collected_timepieces_min']) || isset($_GET['collected_timepieces_max'])
                ) {
                    $playerController->getFilteredPlayers();
                } else {
                    $playerController->getPlayers();
                }
                break;
            case 'POST':
                $playerController->createPlayer();
                break;
            case 'PUT':
                $playerController->updatePlayer();
                break;
            case 'DELETE':
                $playerController->deletePlayer();
                break;
            default:
                http_response_code(405);
                echo json_encode(["message" => "Method not allowed"]);
                break;
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["message" => "Endpoint não encontrado"]);
        break;
}

?>