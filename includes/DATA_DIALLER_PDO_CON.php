<?php  

include('config.php');
   try {

$TRB_DB_PDO = new PDO('mysql:host='.$DB_TRB_DATA_SERVER.';dbname='.$DB_TRB_DATA_DATABASE, $DB_TRB_DATA_USER, $DB_TRB_DATA_PASS);

$TRB_DB_PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

#echo "Connected successfully";

   }
   
   catch(PDOException $e) {
       
       
       
       ?>
                      <div class="row">
                <div class="col-sm-12">
                    <strong><center><h1 style="color:red;"> Connection to dialler lost<br><?php echo "Connection failed: " . $e->getMessage(); ?> <i class="fa fa-exclamation"></i></h1></center></strong>
                </div>
      </div>
<?php
       
   }

?>
