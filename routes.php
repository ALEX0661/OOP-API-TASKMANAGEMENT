<?php

// Import dependencies
require_once "./config/database.php";
require_once "./modules/Get.php";
require_once "./modules/Post.php";
require_once "./modules/Patch.php";
require_once "./modules/Delete.php";
require_once "./modules/Auth.php";

// Initialize database connection
$db = new Connection();
$pdo = $db->connect();

// Instantiate module classes
$post = new Post($pdo);
$patch = new Patch($pdo);
$get = new Get($pdo);
$delete = new Delete($pdo);
$auth = new Authentication($pdo);

// Retrieve and parse request
if (isset($_REQUEST['request'])) {
    $request = explode("/", $_REQUEST['request']);
} else {
    echo "Invalid URL.";
    exit;
}

// Handle HTTP request methods
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if ($auth->isAuthorized()) {
            switch ($request[0]) {
                case "campaigns":
                    echo json_encode($get->getCampaigns($request[1] ?? null));
                    break;

                case "pledges":
                    echo json_encode($get->getPledges($request[1] ?? null));
                    break;

                case "users":
                    echo json_encode($get->getUsers($request[1] ?? null));
                    break;

                case "log":
                    echo json_encode($get->getLogs($request[1] ?? date("Y-m-d")));
                break;

                default:
                    http_response_code(404);
                    echo "Invalid endpoint.";
                    break;
            }
        } else {
            http_response_code(401);
            echo "Unauthorized access.";
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

            case "campaigns":
                echo json_encode($post->createCampaign($body));
                break;

            case "pledges":
                echo json_encode($post->createPledge($body));
                break;

            default:
                http_response_code(400);
                echo "Invalid endpoint.";
                break;
        }
        break;

    case "PATCH":
        $body = json_decode(file_get_contents("php://input"), true);
        switch ($request[0]) {
            case "campaigns":
                echo json_encode($patch->updateCampaign($body, $request[1]));
                break;

            case "pledges":
                echo json_encode($patch->updatePledge($body, $request[1]));
                break;

            case "archive_campaign":
                echo json_encode($patch->archiveCampaign($request[1]));
                break;

            case "archive_pledge":
                echo json_encode($patch->archivePledge($request[1]));
                break;

            default:
                http_response_code(400);
                echo "Invalid endpoint.";
                break;
        }
        break;

    case "DELETE":
        switch ($request[0]) {
            case "campaigns":
                echo json_encode($delete->deleteCampaign($request[1]));
                break;

            case "pledges":
                echo json_encode($delete->deletePledge($request[1]));
                break;

            default:
                http_response_code(400);
                echo "Invalid endpoint.";
                break;
        }
        break;

    default:
        http_response_code(405);
        echo "Invalid request method.";
        break;
}
?>
