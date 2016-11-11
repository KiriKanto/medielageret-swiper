<?php

class DB{ 
    
    //Fields
    public $host;
    public $user;
    public $pass;
    public $count;
    private $conn;
    private $debug = false;
    private $query;
    
    //properties
    public function debug($bool = true)
    {
        $this->debug = $bool;
    }
    
    private function setQuery($sql)
    {
        $this->query = $this->conn->prepare($sql);
    }
    
    //Methods
    //public function __construct()
    public function DB($dbhost, $dbname, $dbuser = 'root', $dbpass = '')
    {
        $this->host = $dbhost; //Gem i klasen til seneere brug
        $this->user = $dbuser;
        $this->pass = $dbpass;
        
        try {
            $this->conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        
    }
    
    public function query($sql, $params = false)
    {    
        $this->setQuery($sql);
        $this->execute($params);
        $this->count = $this->query->rowCount();
        
        return $this->query->fetchAll(PDO::FETCH_OBJ);
    }

    public function Single($sql, $params = false){
        $data = $this->query($sql, $params);
        if(sizeof($data) === 1){
            return $data[0];
        }
    }

    public function FirstOrDefault($sql, $params = false){
        return $this->query($sql, $params)[0];
    }

    public function LastOrDefault($sql, $params = false){
        return $this->query($sql, $params)[$this->count - 1];
    }

    public function ToList($sql, $params = false){
        return $this->query($sql, $params);
    }

    public function LastInsertId($sql, $params = false){
        $this->query($sql, $params);
        return $this->conn->lastInsertId();
    }
    
    private function execute($params)
    {
        if($params){
            $this->query->execute($params);
        } else {
            $this->query->execute();
        }
        if($this->debug){
            echo '<pre id="debug_params">',$this->query->debugDumpParams(),'</pre>';
        }
    }
   
}