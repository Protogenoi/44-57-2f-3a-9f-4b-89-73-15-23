<?php   
 try {
 
include('config.php');
    
 $pdo = new PDO('mysql:host='.$DB_SERVER.';dbname='.$DB_DATABASE, $DB_ADL_USER, $DB_ADL_PASS);

 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//  echo "ADL connected successfully";
  }
catch(PDOException $e) 
   { echo "Connection failed: " . $e->getMessage();
 }

 
?>

