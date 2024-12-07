<?php
class Patch {

    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function patchCampaign($body, $id) {
        $values = [];
        $errmsg = "";
        $code = 0;

        foreach ($body as $value) {
            array_push($values, $value);
        }

        array_push($values, $id);

        try {
            $sqlString = "UPDATE campaigns_tbl SET title = ?, description = ?, goal_amount = ?, deadline = ? WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute($values);

            $code = 200;
            $data = null;

            return ["data" => $data, "code" => $code];
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        return ["errmsg" => $errmsg, "code" => $code];
    }

    public function archiveCampaign($id) {
        $errmsg = "";
        $code = 0;

        try {
            $sqlString = "UPDATE campaigns_tbl SET is_deleted = 1 WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);

            $code = 200;
            $data = null;

            return ["data" => $data, "code" => $code];
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        return ["errmsg" => $errmsg, "code" => $code];
    }

    public function patchPledge($body, $id) {
        $values = [];
        $errmsg = "";
        $code = 0;

        foreach ($body as $value) {
            array_push($values, $value);
        }

        array_push($values, $id);

        try {
            $sqlString = "UPDATE pledges_tbl SET amount = ?, backer_name = ?, message = ? WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute($values);

            $code = 200;
            $data = null;

            return ["data" => $data, "code" => $code];
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        return ["errmsg" => $errmsg, "code" => $code];
    }

    public function archivePledge($id) {
        $errmsg = "";
        $code = 0;

        try {
            $sqlString = "UPDATE pledges_tbl SET is_deleted = 1 WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);

            $code = 200;
            $data = null;

            return ["data" => $data, "code" => $code];
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        return ["errmsg" => $errmsg, "code" => $code];
    }
}

?>
