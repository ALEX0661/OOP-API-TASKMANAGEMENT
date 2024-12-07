<?php

// Import required files
require_once "./config/database.php";
require_once "./modules/Get.php";
require_once "./modules/Post.php";
require_once "./modules/Patch.php";
require_once "./modules/Delete.php";
require_once "./modules/Auth.php";
require_once "./modules/Crypt.php";

// Initialize database connection
$db = new Connection();
$pdo = $db->connect();

// Instantiate classes
$post = new Post($pdo);
$patch = new Patch($pdo);
$get = new Get($pdo);
$delete = new Delete($pdo);
$auth = new Authentication($pdo);
$crypt = new Crypt();

// Retrieve and split request endpoints
if (isset($_REQUEST['request'])) {
    $request = explode("/", $_REQUEST['request']);
} else {
    echo "URL does not exist.";
    exit;
}

// Handle HTTP request methods
switch ($_SERVER['REQUEST_METHOD']) {

    case "GET":
        if ($auth->isAuthorized()) {
            switch ($request[0]) {

                case "campaigns":
                    $dataString = json_encode($get->getCampaigns($request[1] ?? null));
                    echo $crypt->encryptData($dataString);
                    break;

                case "pledges":
                    $dataString = json_encode($get->getPledges($request[1] ?? null));
                    echo $crypt->encryptData($dataString);
                    break;

                default:
                    http_response_code(401);
                    echo "Invalid endpoint.";
                    break;

            }
        } else {
            http_response_code(401);
            echo "Unauthorized.";
        }
        break;

    case "POST":
        $body = json_decode(file_get_contents("php://input"), true);
        switch ($request[0]) {

            case "login":
                echo json_encode($auth->login($body));
                break;

            case "register":
                echo json_encode($auth->addAccount($body));
                break;

            case "campaign":
                echo json_encode($post->createCampaign($body));
                break;

            case "pledge":
                echo json_encode($post->createPledge($body));
                break;

            default:
                http_response_code(401);
                echo "Invalid endpoint.";
                break;
        }
        break;

    case "PATCH":
        $body = json_decode(file_get_contents("php://input"), true);
        switch ($request[0]) {

            case "campaign":
                echo json_encode($patch->updateCampaign($body, $request[1]));
                break;

            default:
                http_response_code(401);
                echo "Invalid endpoint.";
                break;
        }
        break;

    case "DELETE":
        switch ($request[0]) {

            case "campaign":
                echo json_encode($delete->archiveCampaign($request[1]));
                break;

            default:
                http_response_code(401);
                echo "Invalid endpoint.";
                break;
        }
        break;

    default:
        http_response_code(400);
        echo "Invalid Request Method.";
        break;
}

// Close database connection
$pdo = null;
