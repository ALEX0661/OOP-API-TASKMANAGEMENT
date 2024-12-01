<?php

class Common {

    protected function logger($user, $method, $action) {
        $filename = "./logs/" . date("Y-m-d") . ".log";
        $datetime = date("Y-m-d H:i:s");
        $logMessage = "$datetime, $method, $user, $action" . PHP_EOL;

        if (!file_exists(dirname($filename))) {
            mkdir(dirname($filename), 0777, true);
        }

        error_log($logMessage, 3, $filename);
    }

    private function generateInsertString($tablename, $body) {
        $keys = array_keys($body);
        $fields = implode(",", $keys);
        $parameters = implode(",", array_fill(0, count($keys), "?"));
        return "INSERT INTO $tablename ($fields) VALUES ($parameters)";
    }

    protected function getDataByTable($tableName, $condition, \PDO $pdo) {
        $sqlString = "SELECT * FROM $tableName WHERE $condition";
        return $this->executeQuery($sqlString, $pdo);
    }

    protected function getDataBySQL($sqlString, \PDO $pdo) {
        return $this->executeQuery($sqlString, $pdo);
    }

    private function executeQuery($sqlString, \PDO $pdo) {
        $data = [];
        $errmsg = "";
        $code = 0;

        try {
            $result = $pdo->query($sqlString)->fetchAll();
            if ($result) {
                $data = $result;
                $code = 200;
            } else {
                $errmsg = "No data found";
                $code = 404;
            }
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 500;
        }

        return ["code" => $code, "data" => $data, "errmsg" => $errmsg];
    }

    protected function generateResponse($data, $remark, $message, $statusCode) {
        http_response_code($statusCode);
        return [
            "payload" => $data,
            "status" => [
                "remark" => $remark,
                "message" => $message
            ],
            "prepared_by" => "Team NaN",
            "date_generated" => date("Y-m-d H:i:s")
        ];
    }

    public function postData($tableName, $body, \PDO $pdo) {
        $values = array_values($body);
        $errmsg = "";
        $code = 0;

        try {
            $sqlString = $this->generateInsertString($tableName, $body);
            $sql = $pdo->prepare($sqlString);
            $sql->execute($values);

            $code = 201;
            $data = "Data successfully inserted.";
            return ["data" => $data, "code" => $code];
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        return ["errmsg" => $errmsg, "code" => $code];
    }
}

?>
