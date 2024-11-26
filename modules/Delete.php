<?php
class Delete {

    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function deleteTask($task_id) {
        $errmsg = "";
        $code = 0;

        try {
            $sqlString = "DELETE FROM task WHERE task_id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$task_id]);

            $code = 200;
            $data = "Task successfully deleted.";

            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        return array("errmsg" => $errmsg, "code" => $code);
    }
}
?>
