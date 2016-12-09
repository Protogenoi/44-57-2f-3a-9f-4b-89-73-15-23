<?php

class Database {
    
    private $host      = "adlcrm.com";
    private $user      = "root";
    private $pass      = "Cerberus2^n";
    private $dbname    = "dev_adl_database";
 
    private $pdo;
    private $error;
    
    private $stmt;
    
        public function __construct(){
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instanace
        try{
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }
    
    public function query($query){
    $this->stmt = $this->pdo->prepare($query);
}

public function bind($param, $value, $type = null){
    if (is_null($type)) {
        switch (true) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
    }
    $this->stmt->bindValue($param, $value, $type);
}

public function execute(){
    return $this->stmt->execute();
}

public function resultset(){
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function single(){
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_ASSOC);
}

public function rowCount(){
    return $this->stmt->rowCount();
}

public function lastInsertId(){
    return $this->pdo->lastInsertId();
}

public function beginTransaction(){
    return $this->pdo->beginTransaction();
}

public function endTransaction(){
    return $this->pdo->commit();
}

public function cancelTransaction(){
    return $this->pdo->rollBack();
}

public function debugDumpParams(){
    return $this->stmt->debugDumpParams();
}
    
}