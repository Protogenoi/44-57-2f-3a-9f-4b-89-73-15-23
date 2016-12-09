<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1); 
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

    $Level_2_Access = array("Jade");

if (in_array($hello_name,$Level_2_Access, true)) {
    
    header('Location: /Life/Financial_Menu.php'); die;

}

 include('includes/Access_Levels.php');

if (in_array($hello_name,$Agent_Access, true)) {
    
    header('Location: /Life/LifeDealSheet.php'); die;

}

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: index.php?AccessDenied'); die;

}

include('includes/adlfunctions.php');

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL CRM</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.css">
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
<link href="img/favicon.ico" rel="icon" type="image/x-icon" />
<style>
html { height: 100% }
body { height: 100% }
#map { height: 300px; width: 100% }
      
</style>
<script type="text/javascript" language="javascript" src="js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>
<body>
    
    <?php 
    include('includes/navbar.php');
     
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
?> 
    
<div class="container">
    
    <?php 
    
    if($ffdialler=='0') { 
    echo "<div class=\"notice notice-danger\" role=\"alert\"><strong><center><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Problem with Dialler. Call Recording search disabled.</center></strong></div><br> ";   
    }
    
    $clientdeleted= filter_input(INPUT_GET, 'clientdeleted', FILTER_SANITIZE_SPECIAL_CHARS);  
    
if(isset($clientdeleted)){
    if ($clientdeleted =='y') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Client deleted from database</strong></div><br>");
    }
    if ($clientdeleted =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error: Client not deleted</strong></div><br>");
    }
}    
?>
    <div class="col-xs-12 .col-md-8">

<div class="row">
	<div class="twelve columns">
		<ul class="ca-menu">
                    
                    <?php  if (in_array($hello_name,$Level_3_Access, true)) { ?>
                    <li>
			<a href="/AddClient.php">
			<span class="ca-icon"><i class="fa fa-user-plus"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Add New<br/> Client</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                    <?php } ?>
                        
                        <li>
			<a href="/SearchClients.php">
			<span class="ca-icon"><i class="fa fa-search"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Search<br/>All Clients</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                    
                    <?php if($fflife=='1') { 
                        if (in_array($hello_name,$Level_3_Access, true)) {
                            ?>
                    <li>
                        <a href="Life/Main_Menu.php">
                            <span class="ca-icon"><i class="fa fa-medkit"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Life<br/> Insurance</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                        
                        <?php } } ?>
                        
                        
                        
                        <li>
                        <a href="<?php if(in_array($hello_name,$Level_3_Access, true)) { echo "/Home/Main_Menu.php"; } else { echo "#"; }?>">
			<span class="ca-icon"><i class="fa fa-home"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Home<br/>Insurance</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>

                        
                       
                        
                        <li>
                        <a href="<?php if($ffpba=='1' && in_array($hello_name,$Level_10_Access, true) || $hello_name=='Jakob') { echo "/PBA/Main_Menu.php"; } else { echo "#"; }?>">
			<span class="ca-icon"><i class="fa fa-credit-card"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">PBA<br/>Clients</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                                                                      
                         
                        <?php if($ffdialler=='1'){?>
			<li>
			<a href="/dialer/Recordings.php">
			<span class="ca-icon"><i class="fa fa-headphones"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Call<br/>Recordings</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                            <?php }  if($fftwitter=='1') { ?>
                        
                        <li>
			<a href="#twitter" role="button" data-toggle="modal" data-target="#twitter">
			<span class="ca-icon"><i class="fa fa-twitter"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">CRM Updates<br/>Tweet Suggestions</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                        <?php } ?>

                        
		</ul>
	</div>
</div>
    </div>



            <div id="twitter" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
          
                     <a class="twitter-timeline"  href="https://twitter.com/ADL_CRM" data-widget-id="692375914194300928">Tweets by @ADL_CRM</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i></button>
      </div>
    </div>

  </div>
</div>
    
    <div class="modal modal-static fade" id="LOADINGEWS" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <center><i class="fa fa-spinner fa-pulse fa-5x fa-lg"></i></center>
                    <br>
                    <h3>Loading <?php echo "$hello_name's"; ?> user settings... </h3>
                </div>
            </div>
        </div>
    </div>
</div> 

</div>
    
    <div class="footer navbar-fixed-bottom"><center><?php adl_version();?> <?php if($hello_name=='Michael') {
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<i>Page execution '.$total_time.' seconds.</i>';
    } ?></center></div>
    
    
    <?php if($ffgmaps=='1') { ?>
    
    <div id="map" class="col-md-6"></div>
    
     <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQ-TiUwPaHJKUPgtMKt1aa7JZPI35Gq1U&signed_in=true&callback=initMap"></script> 
    <script src="js/googlemapslocation.js"></script>
    
    <?php } ?>


        <script type="text/javascript">
    $(document).ready(function() {                                                                                                    
                                                                                                        
    
        $('#LOADINGEWS').modal('show');
    })
    
    ;
    
    $(window).load(function(){
        $('#LOADINGEWS').delay( 3000 ).modal('hide');
    });
</script> 

<div id="pappoint" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Appointment and callback reminders</h4>
      </div>
      <div class="modal-body">
        <?php


    if($fflife=='1') {
        
        $set_time = date("G:i", strtotime('-30 minutes'));
        $set_time_to = date("G:i", strtotime('+20 minutes'));
    
$query = $pdo->prepare("SELECT client_id, callback_time AS calltimeid, reminder, client_name, notes from scheduled_callbacks WHERE callback_date = CURDATE() AND reminder <= :timeto AND reminder >= :time AND complete='N' and assign =:hello");
$query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
$query->bindParam(':time', $set_time, PDO::PARAM_STR);
$query->bindParam(':timeto', $set_time_to, PDO::PARAM_STR);
echo "<table class=\"table\">";

echo "  <thead>
        <tr>
        <th><h3><span class=\"label label-primary\">Call back Reminders</span></h3></th>
        </tr>
        <tr>
        <th>Client</th>
        <th>Call back</th>
        <th>Reminder</th>
        <th>Notes</th>
        <th>Options</th>
        </tr>
        </thead>";

$query->execute();
if ($query->rowCount()>=1) {
       ?>
                          <script type="text/javascript">
    $(window).load(function(){
        $('#pappoint').modal('show');
    });
</script> 
<?php
    
while ($calllist=$query->fetch(PDO::FETCH_ASSOC)){
         
    $client_id =$calllist['client_id'];
    
	echo '<tr>';
	echo "<td>".$calllist['client_name']."</td>";
	echo "<td>".$calllist['calltimeid']."</td>"; 
        echo "<td>".$calllist['reminder']."</td>"; 
        echo "<td>".$calllist['notes']."</td>"; 
        echo "<form method='GET' action='Life/ViewClient.php'> <input type='hidden' value='$client_id' name='search'>";
        echo "<td><button type=\"submit\" class=\"btn btn-default btn-xs\"><i class='fa fa-folder-open'></i> </button></td></form>";
	echo "</tr>";

}
} else {
    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No call backs for today found</div>";
}
        echo "</table>";
        
        
        $query = $pdo->prepare("SELECT client_id, callback_time AS calltimeid, reminder, client_name, notes from scheduled_callbacks WHERE callback_date = CURDATE() AND complete='N' and assign =:hello");
$query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
echo "<table class=\"table\">";

echo "  <thead>
        <tr>
        <th><h3><span class=\"label label-primary\">Todays Call backs</span></h3></th>
        </tr>
        <tr>
        <th>Client</th>
        <th>Call back</th>
        <th>Reminder</th>
        <th>Notes</th>
        <th>Options</th>
        </tr>
        </thead>";

$query->execute();
if ($query->rowCount()>=1) {
   
while ($calllist=$query->fetch(PDO::FETCH_ASSOC)){
         
    $client_id =$calllist['client_id'];
    
	echo '<tr>';
	echo "<td>".$calllist['client_name']."</td>";
	echo "<td>".$calllist['calltimeid']."</td>"; 
        echo "<td>".$calllist['reminder']."</td>"; 
        echo "<td>".$calllist['notes']."</td>"; 
        echo "<form method='GET' action='Life/ViewClient.php'> <input type='hidden' value='$client_id' name='search'>";
        echo "<td><button type=\"submit\" class=\"btn btn-default btn-xs\"><i class='fa fa-folder-open'></i> </button></td></form>";
	echo "</tr>";

}
} else {
    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No call backs for today found</div>";
}
        echo "</table>";
        
    }
    
        if($ffpensions=='1') {
            
    $set_time = date("G:i", strtotime('-30 minutes'));
        $set_time_to = date("G:i", strtotime('+20 minutes'));
    
$query = $pdo->prepare("SELECT client_id, callback_time AS calltimeid, reminder, client_name, notes from scheduled_penion_callbacks WHERE callback_date = CURDATE() AND reminder <= :timeto AND reminder >= :time AND complete='N' and assign =:hello");
$query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
$query->bindParam(':time', $set_time, PDO::PARAM_STR);
$query->bindParam(':timeto', $set_time_to, PDO::PARAM_STR);
echo "<table class=\"table\">";

echo "  <thead>
        <tr>
        <th><h3><span class=\"label label-primary\">Call back Reminders</span></h3></th>
        </tr>
        <tr>
        <th>Client</th>
        <th>Call back</th>
        <th>Reminder</th>
        <th>Notes</th>
        <th>Options</th>
        </tr>
        </thead>";

$query->execute();
if ($query->rowCount()>=1) {
       ?>
                          <script type="text/javascript">
    $(window).load(function(){
        $('#pappoint').modal('show');
    });
</script> 
<?php
    
while ($calllist=$query->fetch(PDO::FETCH_ASSOC)){
         
    $client_id =$calllist['client_id'];
    
	echo '<tr>';
	echo "<td>".$calllist['client_name']."</td>";
	echo "<td>".$calllist['calltimeid']."</td>"; 
        echo "<td>".$calllist['reminder']."</td>"; 
        echo "<td>".$calllist['notes']."</td>"; 
        echo "<form method='GET' action='Pensions/ViewClient.php'> <input type='hidden' value='$client_id' name='search'>";
        echo "<td><button type=\"submit\" class=\"btn btn-default btn-xs\"><i class='fa fa-folder-open'></i> </button></td></form>";
	echo "</tr>";

}
} else {
    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No call backs for today found</div>";
}
        echo "</table>";        
            
    
$query = $pdo->prepare("SELECT client_id, CONCAT(callback_time, ' - ', callback_date) AS calltimeid, client_name, notes from scheduled_pension_callbacks WHERE callback_date = CURDATE() and complete='N'");

echo "<table class=\"table\">";

echo "  <thead>
        <tr>
        <th><h3><span class=\"label label-primary\">All Call back</span></h3></th>
        </tr>
        <tr>
        <th>Client</th>
        <th>Call back</th>
        <th>Notes</th>
        <th>Options</th>
        </tr>
        </thead>";

$query->execute();
if ($query->rowCount()>=0) {
    ?>
                   <script type="text/javascript">
    $(window).load(function(){
        $('#pappoint').modal('show');
    });
</script> <?php
while ($calllist=$query->fetch(PDO::FETCH_ASSOC)){
         
    $client_id =$calllist['client_id'];
    
	echo '<tr>';
	echo "<td>".$calllist['client_name']."</td>";
	echo "<td>".$calllist['calltimeid']."</td>"; 
        echo "<td>".$calllist['notes']."</td>"; 
        echo "<form method='GET' action='Life/ViewClient.php?search=$client_id'>";
        echo "<td><button type=\"submit\" class=\"btn btn-default btn-xs\"><i class='fa fa-folder-open'></i> </button></td></form>";
	echo "</tr>";

}
} else {
    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No call backs for today found</div>";
}
        echo "</table>";
    }
?> 
    </div>
         <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
      </div>
    </div>
  </div>
</div>
<?php include('php/Holidays.php'); ?>
<?php if(isset($hello_name)) { if(in_array($hello_name,array("Michael","Jakob","Nicola","carys","Abbiek","Georgia","Amy","Nathan","Mike"))){  
    $SANTA_TIME= date("H");
    ?>
 <audio autoplay>
     <?php if($SANTA_TIME=='10') { ?>
  <source src="sounds/santascoming.mp3" type="audio/mpeg">
     <?php }elseif($SANTA_TIME=='11') { ?>
<source src="/sounds/ninnymuggins.mp3" type="audio/mpeg">
</audio> <?php } elseif($SANTA_TIME=='12') { ?>
<source src="/sounds/arnold_reindeer.mp3" type="audio/mpeg">
</audio> <?php }  elseif($SANTA_TIME=='13') { ?>
<source src="/sounds/youstink.mp3" type="audio/mpeg">
</audio> <?php } elseif($SANTA_TIME=='14') { ?>
<source src="/sounds/sonofanut.mp3" type="audio/mpeg">
</audio> <?php } elseif($SANTA_TIME=='15') { ?>
<source src="/sounds/workshop.mp3" type="audio/mpeg">
</audio> <?php } elseif($SANTA_TIME=='16') { ?>
<source src="/sounds/ChristmasScat.mp3" type="audio/mpeg">
</audio> <?php } elseif($SANTA_TIME=='17') { ?>
<source src="/sounds/Buzz-your-girl-friend-Woof.mp3" type="audio/mpeg">
</audio> <?php } elseif($SANTA_TIME=='18') { ?>
<source src="/sounds/snakes_money.mp3" type="audio/mpeg">
</audio> <?php }
}
}
?>
</body>
</html>
