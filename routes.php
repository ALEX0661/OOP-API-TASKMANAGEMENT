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
                    echo json_encode($Get->getTaskInfo($request[1]));
                } else {
                    echo json_encode($Get->getTaskInfo());
                }
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
