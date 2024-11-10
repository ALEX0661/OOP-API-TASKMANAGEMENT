<?php
class Post{
    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function postTask(){
        //code for retrieving data on DB
        return "Task Created";
    }

    public function updateTask(){
        //code for retrieving data on DB
        return "Task Updated";
    }

    public function deleteTask(){
        //code for retrieving data on DB
        return "Task deleted";
    }
}

?>