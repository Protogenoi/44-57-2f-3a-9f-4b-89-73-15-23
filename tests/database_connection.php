<?php

$ADL_DB_CONFIG = require_once(__DIR__ . '/../includes/adl_database_config.php');

class DatabaseConnection {
    
    public static function make($ADL_DB_CONFIG) {
        
        try {
            
            return new PDO (
                    
                    $ADL_DB_CONFIG['connection'].';dbname='.$ADL_DB_CONFIG['name'],
                    $ADL_DB_CONFIG['username'],
                    $ADL_DB_CONFIG['password'],
                    $ADL_DB_CONFIG['options']
                    
                    );

        } catch (PDOException $ex) {
            die($ex->getMessage());

        }
        
    }
    
}

$pdo = DatabaseConnection::make($ADL_DB_CONFIG['database']);