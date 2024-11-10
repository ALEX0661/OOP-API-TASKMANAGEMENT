<?php
require_once "./config/Database.php";
require_once "./modules/Get.php";
require_once "./modules/Post.php";

$db = new Connection();
$pdo = $db->connect();

$Get = new Get($pdo);
$Post = new Post($pdo);

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

/*
    case 'POST':
        switch ($request[0]) {
            case 'posttasks':
                if (count($request) > 1) {
                    echo json_encode($Get->getTaskinfo($request[1]));
                } else {
                    echo json_encode($Get->getTaskinfo());
                }
                break;

            case 'updatetasks':
                if (count($request) > 1) {
                    echo json_encode($Get->getTaskinfo($request[1]));
                } else {
                    echo json_encode($Get->getTaskinfo());
                }
                break;


            case 'deletetasks':
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
*/
    default:
        echo "Forbidden";
        break;
}
?>
