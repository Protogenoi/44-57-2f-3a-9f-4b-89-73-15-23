<?php

class UserActions {
    
    public $isAlive = true;
    public $hello_name;
    
    function __construct($hello_name) {
        
        $this->hello_name = $hello_name;
        
    }
            
    
    
            function UpdateToken() {
        
 //$token = bin2hex(random_bytes(16)); PHP7
 
        $token=bin2hex(openssl_random_pseudo_bytes(16));
                
        $database = new Database();
        $database->beginTransaction();

        $database->query("UPDATE users SET token=:TOKEN WHERE login=:USER");
        $database->bind(':USER', $this->hello_name);
        $database->bind(':TOKEN', $token);
        $database->execute();  

        $database->endTransaction();
        
        }
    
}
