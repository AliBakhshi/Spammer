<?php

namespace Database;

class databaseModel {

    public $connection;

    function __construct()
    {
        $this->connection=mysqli_connect("localhost","root","","spammer");
        if(!$this->connection || $this->connection->connect_errno>0){
            die('<p style="color:red;font-weight: bolder;">Cannot Connect To Database !</p>');
        }
    }


    function InsertData($sql){
       if($this->connection->query($sql)!==true){
           die("error db : ".$this->connection->error);
       }
    }


    function __destruct()
    {
        mysqli_close($this->connection);
    }


}

