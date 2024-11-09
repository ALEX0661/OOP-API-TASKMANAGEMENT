<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
date_default_timezone_set("Asia/Manila");

define("DB_SERVER", "localhost");
define("DB_NAME", "Tsk_Mngmnt");
define("DB_USER", "root");
define("DB_PWORD", "");

class Connection {
    private $connectionstring;
    private $options;

    public function __construct() {
        $this->connectionstring = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8";
        $this->options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
    }

    public function connect() {
        return new \PDO($this->connectionstring, DB_USER, DB_PWORD, $this->options);
    }
}
?>
