<?php 

include('config.php');

 try {

    
 $pdo = new PDO('mysql:host='.$DB_SERVER.';dbname='.$DB_DATABASE, $DB_ADL_USER, $DB_ADL_PASS);

 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//  echo "ADL connected successfully";
  }
catch(PDOException $e) 
   { echo "Connection failed: " . $e->getMessage();
 }

//datacon.php

$conn = new mysqli($DB_SERVER, $DB_ADL_USER, $DB_ADL_PASS, $DB_DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//dbcon.php

$connection = mysql_connect($DB_SERVER,$DB_ADL_USER,$DB_ADL_PASS) or die ("Couldn't connect to server."); 
$db = mysql_select_db($DB_DATABASE, $connection) or die ("Couldn't select database."); 

//dbconnect.php

$mysqli = new mysqli($DB_SERVER, $DB_ADL_USER, $DB_ADL_PASS, $DB_DATABASE);

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  
//mysqliadl.php

$dbc = @mysqli_connect($DB_SERVER, $DB_ADL_USER, $DB_ADL_PASS, $DB_DATABASE) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
mysqli_set_charset($dbc, 'utf8');

//unknown mysql convert connnection

$connection = ($GLOBALS["___mysqli_ston"] = mysqli_connect($DB_SERVER, $DB_ADL_USER, $DB_ADL_PASS)) or die ("Couldn't connect to server."); 
$db = ((bool)mysqli_query( $connection, "USE " . $DB_DATABASE)) or die ("Couldn't select database."); 

//ewsfiles.php

$connect = ($GLOBALS["___mysqli_ston"] = mysqli_connect($DB_SERVER, $DB_ADL_USER, $DB_ADL_PASS));
((bool)mysqli_query($connect, "USE " . $DB_DATABASE));

?>

