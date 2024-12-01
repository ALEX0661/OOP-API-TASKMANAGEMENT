<?php
class Delete {

    protected $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }

    // Delete a Campaign by ID
    public function deleteCampaign($id){

        $errmsg = "";
        $code = 0;

        try {
            // Delete the campaign from the database
            $sqlString = "DELETE FROM campaigns_tbl WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);

            $code = 200;
            $data = null;

            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        return array("errmsg" => $errmsg, "code" => $code);
    }

    // Delete a Pledge by ID
    public function deletePledge($id){

        $errmsg = "";
        $code = 0;

        try {
            // Delete the pledge from the database
            $sqlString = "DELETE FROM pledges_tbl WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);

            $code = 200;
            $data = null;

            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        return array("errmsg" => $errmsg, "code" => $code);
    }
}
?>
