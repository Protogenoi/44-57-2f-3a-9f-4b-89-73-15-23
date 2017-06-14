<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 9);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

 include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: ../index.php?AccessDenied'); die;

}

include('../../includes/adlfunctions.php');

$MONTH= filter_input(INPUT_GET, 'MONTH', FILTER_SANITIZE_SPECIAL_CHARS);
$YEAR= filter_input(INPUT_GET, 'YEAR', FILTER_SANITIZE_SPECIAL_CHARS);

        $RETURN= filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(isset($RETURN)) {
            $DATE= filter_input(INPUT_GET, 'DATE', FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
           $DATE= filter_input(INPUT_POST, 'DATE', FILTER_SANITIZE_SPECIAL_CHARS); 
        }
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | RAG Report</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../bootstrap-3.3.5-dist/cosmo/bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap-3.3.5-dist/cosmo/bootstrap.css">
    <link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../styles/sweet-alert.min.css" />
    <link rel="stylesheet" href="../../styles/Notices.css" />
    <link rel="stylesheet" href="../../styles/LargeIcons.css" type="text/css" />
    <link rel="stylesheet" href="../../styles/datatables/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

</head>
<body>
    
    <?php 
    include('../../includes/navbar.php');
     
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
?> 
    
<div class="container">
    
    <?php if(isset($RETURN)) {
        if($RETURN=='WEEKSTATS') {

$START_DATE= filter_input(INPUT_POST, 'START_DATE', FILTER_SANITIZE_SPECIAL_CHARS); 
$END_DATE= filter_input(INPUT_POST, 'END_DATE', FILTER_SANITIZE_SPECIAL_CHARS); 
if(empty($START_DATE)) {
    $START_DATE= filter_input(INPUT_GET, 'START_DATE', FILTER_SANITIZE_SPECIAL_CHARS); 
$END_DATE= filter_input(INPUT_GET, 'END_DATE', FILTER_SANITIZE_SPECIAL_CHARS); 

}

            
            ?>
    
    <div class='notice notice-default' role='alert'><h1><strong> <center><?php if(isset($START_DATE)) { echo "RAG Week Stats search: $START_DATE - $END_DATE"; } ?></center></strong></h1> </div>
    <br>
      <div class="row fixed-toolbar">
                <div class="col-xs-5">
                    <a href="RAG.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <div class="col-xs-7">
                    <div class="text-right">   
                        <a class="btn btn-primary" href='/Staff/Export/Export.php?EXECUTE=1&START_DATE=<?php echo "$START_DATE&END_DATE=$END_DATE";?>'><i class="fa fa-download"></i> Export</a>
                        <a class="btn btn-warning" href='?RETURN=AVERAGESTATS&START_DATE=<?php echo "$START_DATE&END_DATE=$END_DATE";?>'><i class="fa fa-bar-chart "></i> Average Stats</a>
                        <a class="btn btn-info" href='?RETURN=REGISTERSTATS&START_DATE=<?php echo $START_DATE; ?>&END_DATE=<?php echo $END_DATE; ?>'><i class="fa fa-calendar-check-o"></i> Employee Register</a>
                    </div>
                </div>
            </div>
    <br>
    <?php
    

$RAG_WEEK_QRY = $pdo->prepare("SELECT SUM(lead_rag.cancels) AS cancels, CONCAT(employee_details.firstname, ' ', employee_details.lastname) AS NAME, SUM(lead_rag.sales) AS sales, SUM(lead_rag.hours) AS hours, SUM(lead_rag.minus) AS minus, SUM(lead_rag.leads) AS leads FROM lead_rag JOIN employee_details ON employee_details.employee_id = lead_rag.employee_id WHERE substr(lead_rag.date,5) between :START_DATE AND :END_DATE GROUP BY lead_rag.employee_id");
$RAG_WEEK_QRY->bindParam(':START_DATE', $START_DATE, PDO::PARAM_STR);
$RAG_WEEK_QRY->bindParam(':END_DATE', $END_DATE, PDO::PARAM_STR);
$RAG_WEEK_QRY->execute();
if ($RAG_WEEK_QRY->rowCount()>0) { ?>
 
    <div class="row">        
        <table class="table">
            <tr>
                <th>Employee</th>
                <th>TOTAL SALES</th>
                <th>TOTAL LEADS</th>
                <th>TOTAL CR</th>
                <th>TOTAL CANCELS</th>
                <th>TOTAL Hours</th>
                <th>TOTAL Minus</th>
            </tr>     
<?php 

while ($result=$RAG_WEEK_QRY->fetch(PDO::FETCH_ASSOC)){

    $SALES=$result['sales'];
    $LEADS=$result['leads'];
    $HOURS=$result['hours'];
    $MINUS=$result['minus'];
    $NAME=$result['NAME'];
    $CANCELS=$result['cancels'];

?>
    
    <tr> 
    <td><input type="text" class="form-control" readonly value="<?php echo $NAME; ?>" name="EMPLOYEE"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $SALES; ?>" name="SALES"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $LEADS; ?>" name="LEADS"></td>
    <td><input type="text" class="form-control" readonly value="<?php $var=$SALES/$LEADS; echo number_format((float)$var, 2, '.', ''); ?>" name="CR"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $CANCELS; ?>" name="CANCELS"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $HOURS; ?>" name="HOURS"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $MINUS; ?>" name="MINUS"></td>
    </tr> 
    
<?php } ?> </table><?php }?>
        
    </div>
    <?php        
        }

        if($RETURN=='AVERAGESTATS') {

$START_DATE= filter_input(INPUT_GET, 'START_DATE', FILTER_SANITIZE_SPECIAL_CHARS); 
$END_DATE= filter_input(INPUT_GET, 'END_DATE', FILTER_SANITIZE_SPECIAL_CHARS); 
            
            ?>
    
    <div class='notice notice-default' role='alert'><h1><strong> <center><?php if(isset($START_DATE)) { echo "RAG Average stats search: $START_DATE - $END_DATE"; } ?></center></strong></h1> </div>
    <br>
      <div class="row fixed-toolbar">
                <div class="col-xs-5">
                    <a href="RAG.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <div class="col-xs-7">
                    <div class="text-right">           
                        <a class="btn btn-warning" href='?RETURN=WEEKSTATS&START_DATE=<?php echo $START_DATE; ?>&END_DATE=<?php echo $END_DATE; ?>'><i class="fa fa-bar-chart"></i> Week Stats</a>
                        <a class="btn btn-info" href='?RETURN=REGISTERSTATS&START_DATE=<?php echo $START_DATE; ?>&END_DATE=<?php echo $END_DATE; ?>'><i class="fa fa-calendar-check-o"></i> Employee Register</a> 
                    </div>
                </div>
            </div>
    <br>
    <?php

$RAG_WEEK_QRY = $pdo->prepare("SELECT AVG(lead_rag.cancels) AS cancels, CONCAT(employee_details.firstname, ' ', employee_details.lastname) AS NAME, AVG(lead_rag.sales) AS sales, AVG(lead_rag.hours) AS hours, AVG(lead_rag.minus) AS minus, AVG(lead_rag.leads) AS leads FROM lead_rag JOIN employee_details ON employee_details.employee_id = lead_rag.employee_id WHERE substr(lead_rag.date,5) between :START_DATE AND :END_DATE GROUP BY lead_rag.employee_id");
$RAG_WEEK_QRY->bindParam(':START_DATE', $START_DATE, PDO::PARAM_STR);
$RAG_WEEK_QRY->bindParam(':END_DATE', $END_DATE, PDO::PARAM_STR);
$RAG_WEEK_QRY->execute();
if ($RAG_WEEK_QRY->rowCount()>0) { ?>
 
    <div class="row">        
        <table class="table">
            <tr>
                <th>Employee</th>
                <th>AVG SALES</th>
                <th>AVG LEADS</th>
                <th>AVG CR</th>
                <th>AVG CANCELS</th>
                <th>AVG Hours</th>
                <th>AVG Minus</th>
            </tr>     
<?php 

while ($result=$RAG_WEEK_QRY->fetch(PDO::FETCH_ASSOC)){

    $SALES=$result['sales'];
    $LEADS=$result['leads'];
    $HOURS=$result['hours'];
    $MINUS=$result['minus'];
    $NAME=$result['NAME'];
    $CANCELS=$result['cancels'];

?>
    
    <tr> 
    <td><input type="text" class="form-control" readonly value="<?php echo $NAME; ?>" name="EMPLOYEE"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $SALES; ?>" name="SALES"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $LEADS; ?>" name="LEADS"></td>
    <td><input type="text" class="form-control" readonly value="<?php $var=$SALES/$LEADS; echo number_format((float)$var, 2, '.', ''); ?>" name="CR"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $CANCELS; ?>" name="CANCELS"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $HOURS; ?>" name="HOURS"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $MINUS; ?>" name="MINUS"></td>
    </tr> 
    
<?php } ?> </table><?php }?>
        
    </div>
    <?php        
        } 
        
        if($RETURN=='REGISTERSTATS') {

$START_DATE= filter_input(INPUT_GET, 'START_DATE', FILTER_SANITIZE_SPECIAL_CHARS); 
$END_DATE= filter_input(INPUT_GET, 'END_DATE', FILTER_SANITIZE_SPECIAL_CHARS); 
            
            ?>
    
    <div class='notice notice-default' role='alert'><h1><strong> <center><?php if(isset($START_DATE)) { echo "RAG Employee Register stats search: $START_DATE - $END_DATE"; } ?></center></strong></h1> </div>
    <br>
      <div class="row fixed-toolbar">
                <div class="col-xs-5">
                    <a href="RAG.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <div class="col-xs-7">
                    <div class="text-right">           
                        <a class="btn btn-warning" href='?RETURN=WEEKSTATS&START_DATE=<?php echo $START_DATE; ?>&END_DATE=<?php echo $END_DATE; ?>'><i class="fa fa-bar-chart"></i> Week Stats</a>
                        <a class="btn btn-warning" href='?RETURN=AVERAGESTATS&START_DATE=<?php echo "$START_DATE&END_DATE=$END_DATE";?>'><i class="fa fa-bar-chart "></i> Average Stats</a>
                    </div>
                </div>
            </div>
    <br>
    <?php

$RAG_WEEK_QRY = $pdo->prepare("SELECT CONCAT(employee_details.firstname, ' ', employee_details.lastname) AS NAME, SUM(worked) as worked, SUM(holiday) AS holiday, SUM(sick) as sick, SUM(awol) as awol, SUM(training) as training, SUM(authorised) as authorised FROM lead_rag JOIN employee_details ON employee_details.employee_id = lead_rag.employee_id JOIN employee_register ON employee_register.lead_rag_id = lead_rag.id WHERE substr(lead_rag.date,5) between :START_DATE AND :END_DATE GROUP BY lead_rag.employee_id");
$RAG_WEEK_QRY->bindParam(':START_DATE', $START_DATE, PDO::PARAM_STR);
$RAG_WEEK_QRY->bindParam(':END_DATE', $END_DATE, PDO::PARAM_STR);
$RAG_WEEK_QRY->execute();
if ($RAG_WEEK_QRY->rowCount()>0) { ?>
 
    <div class="row">        
        <table class="table">
            <tr>
                <th>Employee</th>
                <th>Days Worked</th>
                <th>Holidays</th>
                <th>Sickness</th>
                <th>AWOL</th>
                <th>Days Training</th>
                <th>Authorised Leave</th>
            </tr>     
<?php 

while ($result=$RAG_WEEK_QRY->fetch(PDO::FETCH_ASSOC)){

    $WORKED=$result['worked'];
    $HOLIDAY=$result['holiday'];
    $SICK=$result['sick'];
    $AWOL=$result['awol'];
    $TRAINING=$result['training'];
    $AUTHORISED=$result['authorised'];
    $NAME=$result['NAME'];

?>
    
    <tr> 
    <td><input type="text" class="form-control" readonly value="<?php echo $NAME; ?>" name="EMPLOYEE"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $WORKED; ?>" name="WORKED"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $HOLIDAY; ?>" name="HOLIDAYS"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $SICK; ?>" name="SICK"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $AWOL; ?>" name="AWOL"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $TRAINING; ?>" name="TRAINING"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $AUTHORISED; ?>" name="Authorised"></td>
    </tr> 
    
<?php } ?> </table><?php }?>
        
    </div>
    <?php        
        }          
        
        
    }
  ?>
    <?php if(empty($MONTH) && $RETURN!='WEEKSTATS' && $RETURN!='AVERAGESTATS' && $RETURN!='REGISTERSTATS') { ?>
    
    <div class="row">
        <div class="col-sm-6">
            <th><a href="?MONTH=JAN&YEAR=<?php echo date(Y); ?>" class="btn btn-default btn-lg"><i class="fa fa-calendar-o"></i><br> JAN <br>2017</a></th>
            <th><a href="?MONTH=FEB&YEAR=<?php echo date(Y); ?>" class="btn btn-warning btn-lg"><i class="fa fa-calendar-o"></i><br> FEB <br>2017</a></th>
            <th><a href="?MONTH=MAR&YEAR=<?php echo date(Y); ?>" class="btn btn-default btn-lg"><i class="fa fa-calendar-o"></i><br> MAR <br>2017</a></th>
        </div>
                <div class="col-sm-6">
            <th><a href="?MONTH=JUL&YEAR=<?php echo date(Y); ?>" class="btn btn-default btn-lg"><i class="fa fa-calendar-o"></i><br> JUL <br>2017</a></th>
            <th><a href="?MONTH=AUG&YEAR=<?php echo date(Y); ?>" class="btn btn-warning btn-lg"><i class="fa fa-calendar-o"></i><br> AUG <br>2017</a></th>            
            <th><a href="?MONTH=SEP&YEAR=<?php echo date(Y); ?>" class="btn btn-default btn-lg"><i class="fa fa-calendar-o"></i><br> SEP <br>2017</a></th>
        </div>
                <div class="col-sm-6">

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <th><a href="?MONTH=APR&YEAR=<?php echo date(Y); ?>" class="btn btn-default btn-lg"><i class="fa fa-calendar-o"></i><br> APR <br>2017</a></th>
            <th><a href="?MONTH=MAY&YEAR=<?php echo date(Y); ?>" class="btn btn-warning btn-lg"><i class="fa fa-calendar-o"></i><br> MAY <br>2017</a></th>
            <th><a href="?MONTH=JUN&YEAR=<?php echo date(Y); ?>" class="btn btn-default btn-lg"><i class="fa fa-calendar-o"></i><br> JUN <br>2017</a></th>
        </div>
                <div class="col-sm-6">
                    <th><a href="?MONTH=OCT&YEAR=<?php echo date(Y); ?>" class="btn btn-default btn-lg"><i class="fa fa-calendar-o"></i><br> OCT <br>2017</a></th>
                    <th><a href="?MONTH=NOV&YEAR=<?php echo date(Y); ?>" class="btn btn-warning btn-lg"><i class="fa fa-calendar-o"></i><br> NOV <br>2017</a></th>
                    <th><a href="?MONTH=DEC&YEAR=<?php echo date(Y); ?>" class="btn btn-default btn-lg"><i class="fa fa-calendar-o"></i><br> DEC <br>2017</a></th>
        </div>
                <div class="col-sm-6">
            
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
  
        </div>
                <div class="col-sm-6">
        </div>
                <div class="col-sm-6">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
        </div>
                <div class="col-sm-6">
        </div>
                <div class="col-sm-6">
        </div>
    </div>
    <?php } if(isset($MONTH) && empty($DATE))  { ?>
    
    <div class='notice notice-default' role='alert'><h1><strong> <center><?php if(isset($MONTH)) { echo "$MONTH - $YEAR"; } ?></center></strong></h1> </div>
    
        <?php 
    
    switch ($MONTH) {
        case"JAN":
            $CONVERT_MONTH='01';
            break;
                case"FEB":
            $CONVERT_MONTH='02';
            break;
                case"MAR":
            $CONVERT_MONTH='03';
            break;
                case"APR":
            $CONVERT_MONTH='04';
            break;
                case"MAY":
            $CONVERT_MONTH='05';
            break;
                case"JUN":
            $CONVERT_MONTH='06';
            break;
                case"JUL":
            $CONVERT_MONTH='07';
            break;
                case"AUG":
            $CONVERT_MONTH='08';
            break;
                case"SEP":
            $CONVERT_MONTH='09';
            break;
        case"OCT":
            $CONVERT_MONTH='10';
            break;
                case"NOV":
            $CONVERT_MONTH='11';
            break;
                case"DEC":
            $CONVERT_MONTH='12';
            break;
        default:
            $CONVERT_MONTH='1';
    }
    
        $list=array();

for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, $CONVERT_MONTH, $d, $YEAR);          
    if (date('m', $time)==$CONVERT_MONTH)       
        $list[]=date('D d-m-y', $time);
}
?>
    <form class="form" method="POST" action="RAG.php<?php echo "?MONTH=$MONTH&YEAR=$YEAR"; ?>">
        <div class="col-md-4">
    <select class="form-control" name="DATE" onchange="this.form.submit()" required>
        <option <?php if(isset($DATE)) { if($DATE==$list[0]) { echo "selected"; } } ?> value="<?php echo $list[0]; ?>"><?php echo $list[0]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[1]) { echo "selected"; } } ?>  value="<?php echo $list[1]; ?>"><?php echo $list[1]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[2]) { echo "selected"; } } ?>  value="<?php echo $list[2]; ?>"><?php echo $list[2]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[3]) { echo "selected"; } } ?>  value="<?php echo $list[3]; ?>"><?php echo $list[3]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[4]) { echo "selected"; } } ?> value="<?php echo $list[4]; ?>"><?php echo $list[4]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[5]) { echo "selected"; } } ?> value="<?php echo $list[5]; ?>"><?php echo $list[5]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[6]) { echo "selected"; } } ?> value="<?php echo $list[6]; ?>"><?php echo $list[6]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[7]) { echo "selected"; } } ?> value="<?php echo $list[7]; ?>"><?php echo $list[7]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[8]) { echo "selected"; } } ?> value="<?php echo $list[8]; ?>"><?php echo $list[8]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[9]) { echo "selected"; } } ?> value="<?php echo $list[9]; ?>"><?php echo $list[9]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[10]) { echo "selected"; } } ?> value="<?php echo $list[10]; ?>"><?php echo $list[10]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[11]) { echo "selected"; } } ?> value="<?php echo $list[11]; ?>"><?php echo $list[11]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[12]) { echo "selected"; } } ?> value="<?php echo $list[12]; ?>"><?php echo $list[12]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[13]) { echo "selected"; } } ?> value="<?php echo $list[13]; ?>"><?php echo $list[13]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[14]) { echo "selected"; } } ?> value="<?php echo $list[14]; ?>"><?php echo $list[14]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[15]) { echo "selected"; } } ?> value="<?php echo $list[15]; ?>"><?php echo $list[15]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[16]) { echo "selected"; } } ?> value="<?php echo $list[16]; ?>"><?php echo $list[16]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[17]) { echo "selected"; } } ?> value="<?php echo $list[17]; ?>"><?php echo $list[17]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[18]) { echo "selected"; } } ?> value="<?php echo $list[18]; ?>"><?php echo $list[18]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[19]) { echo "selected"; } } ?> value="<?php echo $list[19]; ?>"><?php echo $list[19]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[20]) { echo "selected"; } } ?> value="<?php echo $list[20]; ?>"><?php echo $list[20]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[21]) { echo "selected"; } } ?> value="<?php echo $list[21]; ?>"><?php echo $list[21]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[22]) { echo "selected"; } } ?> value="<?php echo $list[22]; ?>"><?php echo $list[22]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[23]) { echo "selected"; } } ?> value="<?php echo $list[23]; ?>"><?php echo $list[23]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[24]) { echo "selected"; } } ?> value="<?php echo $list[24]; ?>"><?php echo $list[24]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[25]) { echo "selected"; } } ?> value="<?php echo $list[25]; ?>"><?php echo $list[25]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[26]) { echo "selected"; } } ?> value="<?php echo $list[26]; ?>"><?php echo $list[26]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[27]) { echo "selected"; } } ?> value="<?php echo $list[27]; ?>"><?php echo $list[27]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[28]) { echo "selected"; } } ?> value="<?php echo $list[28]; ?>"><?php echo $list[28]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[29]) { echo "selected"; } } ?> value="<?php echo $list[29]; ?>"><?php echo $list[29]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[30]) { echo "selected"; } } ?> value="<?php echo $list[30]; ?>"><?php echo $list[30]; ?></option>
    </select>
        </div>
        
      
    </form>
    
    <?php } 
    if(isset($DATE)) { ?>
    
    <div class='notice notice-default' role='alert'><h1><strong> <center><?php if(isset($MONTH)) { echo "$MONTH - $DATE"; } ?></center></strong></h1> </div>
    <br>
    <?php include('../php/Notifications.php'); ?>
    <br>
  <div class="row fixed-toolbar">
                <div class="col-xs-5">
                    <a href="RAG.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <div class="col-xs-7">
                    <div class="text-right">           
                        <a class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i> Add Agent</a>                        
                        <a class="btn btn-warning" data-toggle="modal" data-target="#myModal2" data-backdrop="static" data-keyboard="false" href="#"><i class="fa fa-bar-chart "></i> Week Stats</a>                      
                    </div>
                </div>
            </div>
    
    <br>
    <?php 
    
    switch ($MONTH) {
        case"JAN":
            $CONVERT_MONTH='01';
            break;
                case"FEB":
            $CONVERT_MONTH='02';
            break;
                case"MAR":
            $CONVERT_MONTH='03';
            break;
                case"APR":
            $CONVERT_MONTH='04';
            break;
                case"MAY":
            $CONVERT_MONTH='05';
            break;
                case"JUN":
            $CONVERT_MONTH='06';
            break;
                case"JUL":
            $CONVERT_MONTH='07';
            break;
                case"AUG":
            $CONVERT_MONTH='08';
            break;
                case"SEP":
            $CONVERT_MONTH='09';
            break;
        case"OCT":
            $CONVERT_MONTH='10';
            break;
                case"NOV":
            $CONVERT_MONTH='11';
            break;
                case"DEC":
            $CONVERT_MONTH='12';
            break;
        default:
            $CONVERT_MONTH='01';
    }
    
        $list=array();


for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, $CONVERT_MONTH, $d, $YEAR);          
    if (date('m', $time)==$CONVERT_MONTH)       
        $list[]=date('D d-m-y', $time);
}
#echo "<pre>";
#print_r($list);
#echo "</pre>";

?>
    <form class="form" method="POST" action="RAG.php<?php echo "?MONTH=$MONTH&YEAR=$YEAR"; ?>">
        <div class="col-md-4">
    <select class="form-control" name="DATE" onchange="this.form.submit()" required>
        <option <?php if(isset($DATE)) { if($DATE==$list[0]) { echo "selected"; } } ?> value="<?php echo $list[0]; ?>"><?php echo $list[0]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[1]) { echo "selected"; } } ?>  value="<?php echo $list[1]; ?>"><?php echo $list[1]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[2]) { echo "selected"; } } ?>  value="<?php echo $list[2]; ?>"><?php echo $list[2]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[3]) { echo "selected"; } } ?>  value="<?php echo $list[3]; ?>"><?php echo $list[3]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[4]) { echo "selected"; } } ?> value="<?php echo $list[4]; ?>"><?php echo $list[4]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[5]) { echo "selected"; } } ?> value="<?php echo $list[5]; ?>"><?php echo $list[5]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[6]) { echo "selected"; } } ?> value="<?php echo $list[6]; ?>"><?php echo $list[6]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[7]) { echo "selected"; } } ?> value="<?php echo $list[7]; ?>"><?php echo $list[7]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[8]) { echo "selected"; } } ?> value="<?php echo $list[8]; ?>"><?php echo $list[8]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[9]) { echo "selected"; } } ?> value="<?php echo $list[9]; ?>"><?php echo $list[9]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[10]) { echo "selected"; } } ?> value="<?php echo $list[10]; ?>"><?php echo $list[10]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[11]) { echo "selected"; } } ?> value="<?php echo $list[11]; ?>"><?php echo $list[11]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[12]) { echo "selected"; } } ?> value="<?php echo $list[12]; ?>"><?php echo $list[12]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[13]) { echo "selected"; } } ?> value="<?php echo $list[13]; ?>"><?php echo $list[13]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[14]) { echo "selected"; } } ?> value="<?php echo $list[14]; ?>"><?php echo $list[14]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[15]) { echo "selected"; } } ?> value="<?php echo $list[15]; ?>"><?php echo $list[15]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[16]) { echo "selected"; } } ?> value="<?php echo $list[16]; ?>"><?php echo $list[16]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[17]) { echo "selected"; } } ?> value="<?php echo $list[17]; ?>"><?php echo $list[17]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[18]) { echo "selected"; } } ?> value="<?php echo $list[18]; ?>"><?php echo $list[18]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[19]) { echo "selected"; } } ?> value="<?php echo $list[19]; ?>"><?php echo $list[19]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[20]) { echo "selected"; } } ?> value="<?php echo $list[20]; ?>"><?php echo $list[20]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[21]) { echo "selected"; } } ?> value="<?php echo $list[21]; ?>"><?php echo $list[21]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[22]) { echo "selected"; } } ?> value="<?php echo $list[22]; ?>"><?php echo $list[22]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[23]) { echo "selected"; } } ?> value="<?php echo $list[23]; ?>"><?php echo $list[23]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[24]) { echo "selected"; } } ?> value="<?php echo $list[24]; ?>"><?php echo $list[24]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[25]) { echo "selected"; } } ?> value="<?php echo $list[25]; ?>"><?php echo $list[25]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[26]) { echo "selected"; } } ?> value="<?php echo $list[26]; ?>"><?php echo $list[26]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[27]) { echo "selected"; } } ?> value="<?php echo $list[27]; ?>"><?php echo $list[27]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[28]) { echo "selected"; } } ?> value="<?php echo $list[28]; ?>"><?php echo $list[28]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[29]) { echo "selected"; } } ?> value="<?php echo $list[29]; ?>"><?php echo $list[29]; ?></option>
        <option <?php if(isset($DATE)) { if($DATE==$list[30]) { echo "selected"; } } ?> value="<?php echo $list[30]; ?>"><?php echo $list[30]; ?></option>
    </select>
        </div>
        
      
    </form>
    
<?php 

$RAG_QRY = $pdo->prepare("select lead_rag.cancels, employee_register.worked, employee_register.bank, employee_register.holiday, employee_register.sick, employee_register.awol, employee_register.authorised, employee_register.training, lead_rag.id, CONCAT(employee_details.firstname, ' ', employee_details.lastname) AS NAME, employee_details.employee_id, lead_rag.sales, lead_rag.leads, lead_rag.hours, lead_rag.minus, lead_rag.updated_by, lead_rag.updated_date from lead_rag JOIN employee_details on lead_rag.employee_id = employee_details.employee_id JOIN employee_register on employee_register.lead_rag_id = lead_rag.id WHERE lead_rag.date=:DATE ORDER BY employee_details.lastname");
$RAG_QRY->bindParam(':DATE', $DATE, PDO::PARAM_STR);
$RAG_QRY->execute();
if ($RAG_QRY->rowCount()>0) { ?>
 
    <div class="row">        
        <table class="table">
            <tr>
                <th>Employee</th>
                <th>SALES</th>
                <th>LEADS</th>
                <th>CR</th>
                <th>Cancels</th>
                <th>Hours</th>
                <th>Minus 25</th>
                <th>Register</th>
                <th></th>                
            </tr>     
<?php 

while ($result=$RAG_QRY->fetch(PDO::FETCH_ASSOC)){
    
    $SALES=$result['sales'];
    $LEADS=$result['leads'];
    $HOURS=$result['hours'];
    $MINUS=$result['minus'];
    $UPDATED_BY=$result['updated_by'];
    $UPDATED_DATE=$result['updated_date'];
    $REF=$result['employee_id'];
    $NAME=$result['NAME'];
    $RAGID=$result['id'];
    $CANCELS=$result['cancels'];
    
    $WORKED=$result['worked'];
    $HOLIDAY=$result['holiday'];
    $TRAINING=$result['training'];
    $AWOL=$result['awol'];
    $SICK=$result['sick'];
    $AUTHORISED=$result['authorised'];

?>
    <form method="POST" action="../php/RAG.php?EXECUTE=2<?php echo "&REF=$REF&MONTH=$MONTH&YEAR=$YEAR&DATE=$DATE&LEADRAG=$RAGID"; ?>">      
    <tr> 
    <td><input type="text" class="form-control" readonly value="<?php echo $NAME; ?>" name="EMPLOYEE"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $SALES; ?>" name="SALES"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $LEADS; ?>" name="LEADS"></td>
    <td><input type="text" class="form-control" readonly value="<?php $var=$SALES/$LEADS; echo number_format((float)$var, 2, '.', ''); ?>" name="CR"></td>
    <td><input type="text" class="form-control" value="<?php echo $CANCELS; ?>" name="CANCELS"></td>
    <td><input type="text" class="form-control" value="<?php echo $HOURS; ?>" name="HOURS"></td>
    <td><input type="text" class="form-control" value="<?php echo $MINUS; ?>" name="MINUS"></td>
    <td><select name="REGISTER" class="form-control">
            <option <?php if(isset($WORKED)) { if($WORKED>'0') { echo "selected"; } } ?> value="1">Worked</option>
            <option <?php if(isset($HOLIDAY)) { if($HOLIDAY>'0') { echo "selected"; } } ?>  value="2">Holidays</option>
            <option <?php if(isset($SICK)) { if($SICK>'0') { echo "selected"; } } ?>  value="3">Sickness</option>
            <option <?php if(isset($AWOL)) { if($AWOL>'0') { echo "selected"; } } ?>  value="4">AWOL</option>
            <option <?php if(isset($AUTHORISED)) { if($AUTHORISED>'0') { echo "selected"; } } ?>  value="5">Authorised Leave</option>
            <option <?php if(isset($TRAINING)) { if($TRAINING>'0') { echo "selected"; } } ?>  value="6">Days Training</option>
            <option <?php if(isset($BANK)) { if($BANK>'0') { echo "selected"; } } ?>  value="7">Bank Holiday</option>
        </select></td>
    <td><button type="submit" class="btn btn-success btn-md"><i class="fa fa-check-circle-o"></i> Update</button></td>     
    </tr> 
    </form>
<?php } ?> </table><?php }?>
        
    </div>
    
    <?php } ?>
    
</div>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add Agents</h4>
        </div>
        <div class="modal-body">

                <div class="row">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#Modal1">Agents</a></li>
                    </ul>
                </div>
            
            <div class="panel">
                        <div class="panel-body">
                            <form class="form" action="../php/RAG.php?EXECUTE=1&DATE=<?php echo $DATE; ?>&MONTH=<?php echo $MONTH; ?>&YEAR=<?php echo $YEAR; ?>" method="POST" id="addform">
                            <div class="tab-content">
                                <div id="Modal1" class="tab-pane fade in active"> 
            
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    
                    
                    <?php 

$ADD_RAG_QRY = $pdo->prepare("select CONCAT(firstname, ' ', lastname) AS NAME, employee_id, position from employee_details WHERE employee_id NOT IN(select employee_id from lead_rag WHERE date =:DATE)");
$ADD_RAG_QRY->bindParam(':DATE', $DATE, PDO::PARAM_STR);
$ADD_RAG_QRY->execute();
if ($ADD_RAG_QRY->rowCount()>0) { ?>
 
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Agent</label>
                            <select name="REF" class="form-control">
                                
 <?php 

while ($result=$ADD_RAG_QRY->fetch(PDO::FETCH_ASSOC)){

    $EMPLOYEE_ID=$result['employee_id'];
    $NAME=$result['NAME']; ?>
                                
<option value="<?php if(isset($EMPLOYEE_ID)) { echo $EMPLOYEE_ID; } ?>"><?php if(isset($NAME)) { echo $NAME; } ?></option>

 <?php } ?>        </select>
                        </div>
                    </div>    
                        
                        
                        <?php }?>
                                        
                </div>
            </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
          
          <div class="modal-footer">
              <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Add Agent!</button>
<script>
        document.querySelector('#addform').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Add agent to RAG?",
                text: "Confirm to add agent!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Agent Added!',
                        text: 'Agent has been added to the RAG!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No changes were made", "error");
                }
            });
        });

</script>
          </form>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
          </div>
      </div>
    </div>
</div>     
      <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">RAG Week Stats</h4>
        </div>
        <div class="modal-body">

                <div class="row">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#Modal1">Select data range</a></li>
                    </ul>
                </div>
            
            <div class="panel">
                        <div class="panel-body">
                            <form class="form" action="RAG.php?RETURN=WEEKSTATS" method="POST" id="searchform">
                            <div class="tab-content">
                                <div id="Modal1" class="tab-pane fade in active"> 
            
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    
                                                            <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Start Date</label>
                                                <input type="text" name="START_DATE" id="START_DATE" class="form-control" value="<?php if(isset($START_DATE)) { echo $START_DATE; } ?>">
                                            </div>
                                        </div>
                    
                                                            <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">End Date</label>
                                                <input type="text" name="END_DATE" id="END_DATE" class="form-control" value="<?php if(isset($END_DATE)) { echo $END_DATE; } ?>">
                                            </div>
                                        </div>
                                        
                </div>
            </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
          
          <div class="modal-footer">
              <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Search!</button>
<script>
        document.querySelector('#searchform').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Search RAG for these dates?",
                text: "Yes search!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Data range searched!',
                        text: 'RAG populated!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No changes were made", "error");
                }
            });
        });

</script>
          </form>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
          </div>
      </div>
    </div>
</div> 

      <div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">RAG Average Stats</h4>
        </div>
        <div class="modal-body">

                <div class="row">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#Modal1">Average Stats</a></li>
                    </ul>
                </div>
            
            <div class="panel">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="Modal1" class="tab-pane fade in active"> 
            
            <div class="col-lg-12 col-md-12">
                <div class="row">                    
                    

     
    <tr> 
    <td><input type="text" class="form-control" readonly value="<?php echo $NAME; ?>" name="EMPLOYEE"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $SALES; ?>" name="SALES"></td>
    <td><input type="text" class="form-control" readonly value="<?php echo $LEADS; ?>" name="LEADS"></td>
    <td><input type="text" class="form-control" readonly value="<?php $var=$SALES/$LEADS; echo number_format((float)$var, 2, '.', ''); ?>" name="CR"></td>
    <td><input type="text" class="form-control" value="<?php echo $HOURS; ?>" name="HOURS"></td>
    <td><input type="text" class="form-control" value="<?php echo $MINUS; ?>" name="MINUS"></td>
    <td><button type="submit" class="btn btn-success btn-md"><i class="fa fa-check-circle-o"></i> Update</button></td>     
    </tr> 

</table>
                                        
                </div>
            </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
          
          <div class="modal-footer">

              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
          </div>
      </div>
    </div>
</div>        
    
<script type="text/javascript" language="javascript" src="../../js/sweet-alert.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script>
  $(function() {
    $( "#START_DATE" ).datepicker({
        dateFormat: 'dd-mm-y',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:-0"
        });
  });
  $(function() {
    $( "#END_DATE" ).datepicker({
        dateFormat: 'dd-mm-y',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:-0"
        });
  });
  </script>
</body>
</html>
