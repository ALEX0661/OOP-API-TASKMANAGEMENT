<?php
class Patch {

    protected $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }

    // Update Campaign details
    public function updateCampaign($body, $id){
        $values = [];
        $errmsg = "";
        $code = 0;

        // Collect all values from the request body
        foreach ($body as $value) {
            array_push($values, $value);
        }

        // Add the campaign ID to the values array
        array_push($values, $id);

        try {
            // SQL query to update campaign details
            $sqlString = "UPDATE campaigns_tbl SET title=?, description=?, goal=?, status=? WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute($values);

            $code = 200;
            $data = null;

            // Return the successful response
            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        // Return the error response in case of failure
        return array("errmsg" => $errmsg, "code" => $code);
    }

    // Archive a Campaign (soft delete)
    public function archiveCampaign($id){
        $errmsg = "";
        $code = 0;

        try {
            // SQL query to soft-delete the campaign by updating the 'isdeleted' flag
            $sqlString = "UPDATE campaigns_tbl SET isdeleted=1 WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);

            $code = 200;
            $data = null;

            // Return the successful response
            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        // Return the error response in case of failure
        return array("errmsg" => $errmsg, "code" => $code);
    }

    // Update Pledge details
    public function updatePledge($body, $id){
        $values = [];
        $errmsg = "";
        $code = 0;

        // Collect all values from the request body
        foreach ($body as $value) {
            array_push($values, $value);
        }

        // Add the pledge ID to the values array
        array_push($values, $id);

        try {
            // SQL query to update pledge details
            $sqlString = "UPDATE pledges_tbl SET amount=?, message=? WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute($values);

            $code = 200;
            $data = null;

            // Return the successful response
            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        // Return the error response in case of failure
        return array("errmsg" => $errmsg, "code" => $code);
    }

    // Archive a Pledge (soft delete)
    public function archivePledge($id){
        $errmsg = "";
        $code = 0;

        try {
            // SQL query to soft-delete the pledge by updating the 'isdeleted' flag
            $sqlString = "UPDATE pledges_tbl SET isdeleted=1 WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);

            $code = 200;
            $data = null;

            // Return the successful response
            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        // Return the error response in case of failure
        return array("errmsg" => $errmsg, "code" => $code);
    }
}
?>
