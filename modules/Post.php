<?php
include_once "Common.php";

class Post extends Common {

    protected $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }

    // Post new Campaign
    public function createCampaign($body){
        // Validate input data
        if (empty($body['title']) || empty($body['goal'])) {
            return $this->generateResponse(null, "failed", "Title and goal are required.", 400);
        }

        // Insert campaign data into the database
        $result = $this->postData("campaigns_tbl", $body, $this->pdo);

        if ($result['code'] == 200) {
            $this->logger("admin", "POST", "Created a new campaign: " . $body['title']);
            return $this->generateResponse($result['data'], "success", "Successfully created a new campaign.", $result['code']);
        }
        
        // Handle failure
        $this->logger("admin", "POST", $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    // Post new Pledge
    public function createPledge($body){
        // Validate input data
        if (empty($body['campaign_id']) || empty($body['amount'])) {
            return $this->generateResponse(null, "failed", "Campaign ID and pledge amount are required.", 400);
        }

        // Insert pledge data into the database
        $result = $this->postData("pledges_tbl", $body, $this->pdo);

        if ($result['code'] == 200) {
            $this->logger("user", "POST", "Created a new pledge for campaign ID: " . $body['campaign_id']);
            return $this->generateResponse($result['data'], "success", "Successfully created a new pledge.", $result['code']);
        }
        
        // Handle failure
        $this->logger("user", "POST", $result['errmsg']);
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

}
?>
