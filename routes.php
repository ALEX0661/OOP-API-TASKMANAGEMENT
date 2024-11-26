<?php
require_once "./config/Database.php";
require_once "./modules/Get.php";
require_once "./modules/Post.php";
require_once "./modules/Patch.php";
require_once "./modules/Delete.php";
require_once "./modules/Auth.php";

$db = new Connection();
$pdo = $db->connect();

$get = new Get($pdo);
$post = new Post($pdo);
$patch = new Patch($pdo);
$delete = new Delete($pdo);
$auth = new Authentication($pdo);

if (isset($_REQUEST['request'])) {
    $request = explode("/", $_REQUEST['request']);
} else {
    echo "URL does not exist.";
    exit;
}

$body = json_decode(file_get_contents("php://input"));

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($request[0]) {
            case 'tasks':
                if (count($request) > 1) {
                    echo json_encode($get->getTaskInfo($request[1]));
                } else {
                    echo json_encode($get->getTaskInfo());
                }
                break;
            default:
                http_response_code(401);
                echo "Invalid endpoint.";
                break;
        }
        break;

    case 'POST':
        switch ($request[0]) {
            case 'login':
                echo json_encode($auth->login($body));
                break;
            case 'user':
                echo json_encode($auth->addAccount($body));
                break;
            case 'tasks':
                echo json_encode($post->postTasks($body));
                break;
            default:
                http_response_code(401);
                echo "Invalid endpoint.";
                break;
        }
        break;

    case 'PATCH':
        switch ($request[0]) {
            case 'tasks':
                if (count($request) > 1) {
                    echo json_encode($patch->updateTask($body, $request[1]));
                } else {
                    http_response_code(400);
                    echo "Task ID is required for update.";
                }
                break;
            default:
                http_response_code(401);
                echo "Invalid endpoint.";
                break;
        }
        break;

    case 'DELETE':
        switch ($request[0]) {
            case 'tasks':
                if (count($request) > 1) {
                    echo json_encode($delete->deleteTask($request[1]));
                } else {
                    http_response_code(400);
                    echo "Task ID is required for deletion.";
                }
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
?>
