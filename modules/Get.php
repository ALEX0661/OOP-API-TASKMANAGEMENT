<?php
include_once "Common.php";

class Get extends Common {

    protected $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }

    // Get all campaigns or a specific campaign by ID
    public function getCampaigns($id = null){
        $condition = "isdeleted = 0";
        if ($id != null) {
            $condition .= " AND id = " . $id;
        }

        $result = $this->getDataByTable('campaigns_tbl', $condition, $this->pdo);

        if ($result['code'] == 200) {
            return $this->generateResponse($result['data'], "success", "Successfully retrieved campaigns.", $result['code']);
        }
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    // Get all pledges or a specific pledge by ID
    public function getPledges($id = null){
        $condition = "isdeleted = 0";
        if ($id != null) {
            $condition .= " AND id = " . $id;
        }

        $result = $this->getDataByTable('pledges_tbl', $condition, $this->pdo);

        if ($result['code'] == 200) {
            return $this->generateResponse($result['data'], "success", "Successfully retrieved pledges.", $result['code']);
        }
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    // Get all users or a specific user by ID
    public function getUsers($id = null){
        $condition = "isdeleted = 0";
        if ($id != null) {
            $condition .= " AND id = " . $id;
        }

        $result = $this->getDataByTable('users_tbl', $condition, $this->pdo);

        if ($result['code'] == 200) {
            return $this->generateResponse($result['data'], "success", "Successfully retrieved users.", $result['code']);
        }
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    // Get logs for debugging (or for admin)
    public function getLogs($date){
        $filename = "./logs/" . $date . ".log";

        $logs = array();
        try {
            $file = new SplFileObject($filename);
            while (!$file->eof()) {
                array_push($logs, $file->fgets());
            }
            $remarks = "success";
            $message = "Successfully retrieved logs.";
        } catch (Exception $e) {
            $remarks = "failed";
            $message = $e->getMessage();
        }

        return $this->generateResponse(array("logs" => $logs), $remarks, $message, 200);
    }
}
?>
