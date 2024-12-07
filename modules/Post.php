<?php

include_once "Common.php";

class Post extends Common {

    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function postCampaign($body) {
        $result = $this->postData("Campaigns_tbl", $body, $this->pdo);
        if ($result['code'] == 200) {
            $this->logger($body['user_id'], "POST", "Created a new campaign record");
            return $this->generateResponse($result['data'], "success", "Successfully created a new campaign.", $result['code']);
        }
        $this->logger($body['user_id'], "POST", $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    public function postPledge($body) {
        $result = $this->postData("Pledges_tbl", $body, $this->pdo);
        if ($result['code'] == 200) {
            $this->logger($body['user_id'], "POST", "Added a new pledge");
            return $this->generateResponse($result['data'], "success", "Successfully added a new pledge.", $result['code']);
        }
        $this->logger($body['user_id'], "POST", $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }
}

?>
