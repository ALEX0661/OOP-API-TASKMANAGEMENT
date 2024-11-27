<?php
require_once "./config/Database.php";
require_once "./modules/Get.php";
require_once "./modules/Post.php";
require_once "./modules/Patch.php";
require_once "./modules/Delete.php";
require_once "./modules/Auth.php";


$db = new Connection();
$pdo = $db->connect();

$Get = new Get($pdo);
$Post = new Post($pdo);
$Patch = new Patch($pdo);
$Delete = new Delete($pdo);
$Auth = new Authentication($pdo);

if (isset($_REQUEST['request'])) {
    $request = explode("/", $_REQUEST['request']);
} else {
    echo "URL does not exist.";
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($request[0]) {
            case 'gettasks':
                if (count($request) > 1) {
                    echo json_encode($Get->getTaskinfo($request[1]));
                } else {
                    echo json_encode($Get->getTaskinfo());
                }
                break;
            default:
                echo "Invalid request.";
                break;
        }
        break;

    case 'POST':
        switch ($request[0]) {
            case 'posttasks':
                $body = json_decode(file_get_contents("php://input"));
                echo json_encode($Post->postTask($body));
                break;
            default:
                echo "Invalid request.";
                break;
        }
        break;

    case 'PATCH':
        $body = json_decode(file_get_contents("php://input"));
        switch ($request[0]) {
            case 'updatetasks':
                echo json_encode($Patch->updateTask($body, $request[1]));
                break;
            case 'archivetask':
                echo json_encode($Patch->archiveTask($request[1]));
                break;
            default:
                echo "Invalid request.";
                break;
        }
        break;

    case 'DELETE':
        switch ($request[0]) {
            case 'deletetasks':
                echo json_encode($Delete->deleteTask($request[1]));
                break;
            default:
                echo "Invalid request.";
                break;
        }
        break;

    default:
        echo "Forbidden";
        break;
}
?>
