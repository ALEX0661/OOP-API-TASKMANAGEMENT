<?php
class Patch {
    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function updateTask($body, $task_id) {
        $values = [];
        $errmsg = "";
        $code = 0;

        foreach($body as $value){
            array_push($values, $value);
        }

        array_push($values, $task_id);

        try {
            $sqlString = "UPDATE task SET title = ?, description = ?, priority = ?, status = ?, updated_at = ?, due_date = ?, updated_at = ? 
                          WHERE task_id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute($values);

            $code = 200;
            $data = "Task successfully updated.";

            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        return array("errmsg" => $errmsg, "code" => $code);
    }

    public function archiveTask($task_id) {
        $errmsg = "";
        $code = 0;

        try {
            $sqlString = "UPDATE task SET isdeleted = 1 WHERE task_id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$task_id]);

            $code = 200;
            $data = "Task successfully archived.";

            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        return array("errmsg" => $errmsg, "code" => $code);
    }
}
?>
