<?php 

include('includes/adlfunctions.php'); 

if ($ffdialler=='0') {
        
        header('Location: ../../CRMmain.php'); die;
    }

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1); 
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Pause Times</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
    </head>
    <body>
        <?php
        
        include('../../includes/navbar.php');
        include('../../includes/DiallerPDOcon.php');
        include('../../includes/dialler_functions.php');
        include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
        ?>
        
        <div class="container">
        
        <?php
        ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

            $userquery = $bureaupdo->prepare("select user, full_name from vicidial_users WHERE user_group IN('Life','Closer','Web') AND active='Y' ORDER by full_name ASC;");
            $userquery->execute()or die(print_r($userquery->errorInfo(), true));
            
            ?>
            
             <form class="form-inline" method="GET">
                <fieldset>
                    <legend>Select Agent</legend>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="selectagent"></label>
                        <div class="col-md-4">
                            <select id="selectagent" name="selectagent" class="form-control">
                                <option value="">Select Agent...</option> 
            
            <?php
            
            if ($userquery->rowCount()>0) {
                while ($row=$userquery->fetch(PDO::FETCH_ASSOC)) {
                        ?>
            
           
                                
                                <?php
                                
                                $userid = $row['user'];
                                $full_name=$row['full_name'];
                                
                                echo "<option value='$userid'>$full_name</option>";
          
                }
            }
            
            ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="singlebutton"></label>
                        <div class="col-md-4">
                            <button id="singlebutton" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                
                </fieldset>
            </form>
            
            <?php
            
            $user= filter_input(INPUT_GET, 'selectagent', FILTER_SANITIZE_NUMBER_INT);
            
            if(isset($user)) {
  
            $query = $bureaupdo->prepare("select if(pause_sec=0,0,pause_sec) as time,sub_status as pause_code, event_time from vicidial_agent_log where user=:user AND sub_status != '' AND date(event_time) = date(now()) ORDER BY event_time DESC");
            $query->bindParam(':user', $user, PDO::PARAM_INT);
            
            echo "<table  class='table table-hover table-condensed'>
                <thead>
                <tr>
                <th colspan='7'>Pause Times for $user</th>
                </tr>
                <th>Time</th>
                <th>Pause Code</th>
                <th>Event Time</th>
                </tr>
                </thead>";
            
            $query->execute()or die(print_r($query->errorInfo(), true));
            if ($query->rowCount()>0) {
                while ($row=$query->fetch(PDO::FETCH_ASSOC)){
                    
                    $time=$row['time'];
                    
                    echo "<tr>
                    <td>".gmdate("H:i:s", $time)."</td>
                    <td>".$row['pause_code']."</td>
                    <td>".$row['event_time']."</td>
                    </tr>";
                    echo "\n";
                    
                }
                
                } else {
                    echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                    
                }
                
                echo "</table>";
                
            }
                
        ?>
            
        </div>
     <script src="../../js/jquery.min.js"></script>
<script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>       
    </body>
</html>
