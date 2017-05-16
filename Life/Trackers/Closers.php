<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}


if ($ffdealsheets == '0') {
    header('Location: /../../../CRMmain.php?Feature=NotEnabled');
    die;
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
$datefrom = filter_input(INPUT_POST, 'DATES', FILTER_SANITIZE_SPECIAL_CHARS);
$CLOSER = filter_input(INPUT_POST, 'CLOSER', FILTER_SANITIZE_SPECIAL_CHARS);

$Today_DATE = date("d-M-Y");
$Today_DATES = date("l jS \of F Y");
$Today_TIME = date("h:i:s");
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Closer Trackers</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/styles/Notices.css">
    <link rel="stylesheet" type="text/css" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/styles/sweet-alert.min.css" />
    <link rel="stylesheet" type="text/css" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
<link rel="stylesheet" href="/summernote-master/dist/summernote.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <body>

        <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>

        <?php
        if (isset($EXECUTE)) {
        if($EXECUTE=='1') { ?>
                    
  <div class="container">

                    <div class="col-md-12">

                        <div class="col-md-4">
                                 <div class="btn-group">
                                     <a class="btn btn-default btn-sm" href="Agent.php?EXECUTE=1"><i class="fa fa-check-circle-o"></i> Agent Trackers</a>
                                     <a class="btn btn-default btn-sm" href="Upsells.php?EXECUTE=DEFAULT"><i class="fa fa-check-circle-o"></i> Upsell Trackers</a>
                                 </div>   
                            
                        </div>
                        <div class="col-md-4"></div>

                        <div class="col-md-4">

                            <?php echo "<h3>$Today_DATES</h3>"; ?>
                            <?php echo "<h4>$Today_TIME</h4>"; ?>

                        </div>

                    </div>

                    <div class="list-group">
                        <span class="label label-primary">Closer Trackers</span>
                        <br><br>
                        <form action="?EXECUTE=1" method="post">

                            <div class="col-md-12">
                                <div class="col-md-4">
                             <select class="form-control" name="CLOSER" id="CLOSER">
                                <option value="All">All</option>
                                <option value="Mike">Mike</option>
                                <option value="David">David</option>
                                <option value="Sarah">Sarah</option>
                                <option value="Hayley">Hayley</option>
                                <option value="Richard">Richard</option>
                                <option value="Gavin">Gavin</option>
                                <option value="Kyle">Kyle</option>
                                <option value="James">James<option>
                            </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <input type="text" id="DATES" name="DATES" value="<?php if(isset($datefrom)) { echo "$datefrom"; } ?>" class="form-control">
                          </div>
                                
                             <div class="col-md-4">
                                 <div class="btn-group">
                                 <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-calendar-check-o"></i> Set Dates</button>
                                 <a class="btn btn-danger btn-sm" href="?EXECUTE=1"><i class="fa fa-recycle"></i> RESET</a>
                                 </div>
                          </div>

                              
                            </div>

                        </form>
                    </div>
  </div>
<div class="container-fluid">
                        <?php
if (isset($datefrom)) {
    if(isset($CLOSER)) {
        if($CLOSER!='All') {
    $CLO_CHK = $pdo->prepare("SELECT tracker_id from closer_trackers WHERE DATE(date_updated)=:date AND closer=:closer");
    $CLO_CHK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $CLO_CHK->bindParam(':closer', $CLOSER, PDO::PARAM_STR);
    $CLO_CHK->execute();
    if ($CLO_CHK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/trackers/CLOSER/CloserPAD.php');
        $CloserPad = new CLOSERPadModal($pdo);
        $CloserPadList = $CloserPad->getCLOSERPad($datefrom,$CLOSER);
        require_once(__DIR__ . '/../views/trackers/CLOSER/Closer-PAD.php');
    }
} 

if($CLOSER=='All') {
        $CLO_CHK = $pdo->prepare("SELECT tracker_id from closer_trackers WHERE DATE(date_updated)=:date");
    $CLO_CHK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $CLO_CHK->execute();
    if ($CLO_CHK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/trackers/CLOSER/AllCloserPAD.php');
        $CloserPad = new AllCLOSERPadModal($pdo);
        $CloserPadList = $CloserPad->AllgetCLOSERPad($datefrom);
        require_once(__DIR__ . '/../views/trackers/CLOSER/AllCloser-PAD.php');
    }
}
    }
} 

if (!isset($datefrom)) {
    $CLO_CHK = $pdo->prepare("SELECT tracker_id from closer_trackers WHERE date_updated >=CURDATE()");
    $CLO_CHK->execute();
    if ($CLO_CHK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/trackers/CLOSER/CloserPAD.php');
        $CloserPad = new CLOSERPadModal($pdo);
        $CloserPadList = $CloserPad->getCLOSERPad();
        require_once(__DIR__ . '/../views/trackers/CLOSER/Closer-PAD.php');
    }
}
?>  

                    </div>

     <?php   }
}
?>

    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
    <script src="/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
    <script>
        $(function () {
            $("#DATES").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
    </script>
</body>
</html>
