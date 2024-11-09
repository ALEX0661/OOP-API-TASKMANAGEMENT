<?php
class Get {
    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }
    

    public function getTaskinfo($task_id = null)
    {
        $sqlString = "SELECT * FROM task";
        if ($task_id !== null) {
            $sqlString .= " WHERE task_id = " . $task_id;
        }

        $data = array();
        $errmsg = "";
        $code = 0;

        try {
            if ($result = $this->pdo->query($sqlString)->fetchAll()) {
                foreach ($result as $record) {
                    array_push($data, $record);
                }
                $result = null;
                $code = 200;
                return array("data" => $data, "code" => $code);
            } else {
                $errmsg = "No data found";
                $code = 404;
            }
        } catch (PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 403;
        }

        return array("code" => $code, "errmsg" => $errmsg); 
    }
}
?>
                                
