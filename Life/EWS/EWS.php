<?php
include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

include('../../includes/adl_features.php');
include('../../includes/Access_Levels.php');
include('../../includes/ADL_PDO_CON.php');
include('../../includes/ADL_MYSQLI_CON.php');

if($ffews=='0') {
    header('Location: ../../CRMmain.php?FEATURE=EWS');
}

if (!in_array($hello_name,$Level_8_Access, true)) {
    header('Location: ../../CRMmain.php'); die;
}

$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);

$dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$EWS_DATE= filter_input(INPUT_GET, 'EWS_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html>
    <title>ADL | EWS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">    
    <link rel="stylesheet" type="text/css" href="/styles/datatables/jquery.dataTables.min.css"> 
    <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
    <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">    
    <link rel="stylesheet" type="text/css" href="/datatables/css/jquery-ui.css">  
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />   
        <style>
        div.smallcontainer {
            margin: 0 auto;
            font: 70%/1.45em "Helvetica Neue",HelveticaNeue,Verdana,Arial,Helvetica,sans-serif;
        }
        .panel-body .btn:not(.btn-block) { width:120px;margin-bottom:10px; }
    </style>
</head>
<body>
<?php require_once(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS). '/includes/navbar.php'); 
    
?>
    <div class="container">
        
        <?php
        
        $RETURN= filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_NUMBER_INT);
        
        if(isset($RETURN)) {
            if($RETURN=='EWSUploaded') {
                
            echo "<div class='notice notice-success' role='alert'><strong><i class='fa fa-upload fa-lg'></i> Success:</strong> EWS uploaded!</div>";

                
            }
        }
        
        ?>
        
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#OVERVIEW">Overview</a></li>
            <li><a data-toggle="pill" href="#menu2">EWS</a></li>
            <li><a data-toggle="pill" href="#menu5">Upload Data</a></li>
        </ul>
    </div>
    
    <div class="tab-content">
        
        <div class="tab-pane fade in active" id="OVERVIEW">
            
            <div class="container"> 
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">EWS Statistics</h3>
                    </div>
                    <div class="panel-body">



                        <form action=" " method="get">

                            <div class="form-group">
                                <div class="col-xs-2">
                                    <input type="text" id="datefrom" name="datefrom" placeholder="DATE FROM:" class="form-control" value="<?php
                                    if (isset($datefrom)) {
                                        echo $datefrom;
                                    }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-2">
                                    <input type="text" id="dateto" name="dateto" class="form-control" placeholder="DATE TO:" value="<?php
                                    if (isset($dateto)) {
                                        echo $dateto;
                                    }
                                    ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-2">
                                    <select class="form-control" name="EWS_DATE">
                                        <?php
                                        $EWS_DATE_QRY = $pdo->prepare("SELECT DATE(date_added) AS date_added FROM ews_data group by DATE(date_added) ORDER BY date_added DESC");
                                        $EWS_DATE_QRY->execute()or die(print_r($_COM_DATE_query->errorInfo(), true));
                                        if ($EWS_DATE_QRY->rowCount() > 0) {
                                            while ($row = $EWS_DATE_QRY->fetch(PDO::FETCH_ASSOC)) {
                                                if (isset($row['date_added'])) {
                                                    ?>
                                                    <option value="<?php echo $row['date_added']; ?>"><?php echo $row['date_added']; ?></option>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>   
                                    </select>
                                </div>
                            </div>       

                            <div class="form-group">
                                <div class="col-xs-2">
                                    <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-search"></span></button>
                                </div>
                            </div>

                            </fieldset>
                        </form>        
                        <?php

                        if (isset($datefrom)) {
                            
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/raw/CFO.php');
    $RawCFO = new RawCFOModal($pdo);
    $RawCFOList = $RawCFO->getRawCFO($EWS_DATE);
    require_once(__DIR__ . '/views/EWS/raw/CFO.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/raw/LAPSED.php');
    $RawLapsed = new RawLapsedModal($pdo);
    $RawLapsedList = $RawLapsed->getRawLapsed($EWS_DATE);
    require_once(__DIR__ . '/views/EWS/raw/Lapsed.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/raw/BOUNCED_DD.php');
    $RawBOUNCED_DD = new RawBOUNCED_DDModal($pdo);
    $RawBOUNCED_DDList = $RawBOUNCED_DD->getRawBOUNCED_DD($EWS_DATE);
    require_once(__DIR__ . '/views/EWS/raw/BOUNCED_DD.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/raw/CANCELLED_DD.php');
    $RawCANCELLED_DD = new RawCANCELLED_DDModal($pdo);
    $RawCANCELLED_DDList = $RawCANCELLED_DD->getRawCANCELLED_DD($EWS_DATE);
    require_once(__DIR__ . '/views/EWS/raw/CANCELLED_DD.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/raw/CANCELLED.php');
    $RawCANCELLED = new RawCANCELLEDModal($pdo);
    $RawCANCELLEDList = $RawCANCELLED->getRawCANCELLED($EWS_DATE);
    require_once(__DIR__ . '/views/EWS/raw/CANCELLED.php');                            
    //END OF CALCULATION   
    
//CALCULATE TOTAL WITH DATES
    require_once(__DIR__ . '/models/EWS/raw/TOTAL.php');
    $RawTOTAL = new RawTOTALModal($pdo);
    $RawTOTALList = $RawTOTAL->getRawTOTAL($EWS_DATE);
    require_once(__DIR__ . '/views/EWS/raw/TOTAL.php');                            
    //END OF CALCULATION       
                        ?>       

                        <table  class="table table-hover">
                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "RAW EWS Statistics for $EWS_DATE";?> 
                                        <i class="fa fa-question-circle-o" style="color:skyblue" title="Download complete RAW EWS <?php echo "$EWS_DATE"; ?>."></i> <a href="../Export/EWS.php?EXECUTE=RAW_EWS&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i> RAW</a>
                                        <i class="fa fa-question-circle-o" style="color:skyblue" title="Download RAW EWS for Assigned user <?php echo "$EWS_DATE"; ?>."></i> <a href="../Export/EWS.php?EXECUTE=ASSIGNED_RAW_EWS&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i> Assigned RAW</a>
                                    </th>
                                </tr>
                               
                                <th>CFO <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as CFO for EWS uploaded on the <?php echo "$EWS_DATE"; ?>."</i> <a href="../Export/EWS.php?EXECUTE=RAW&WARNING=CFO&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Lapsed <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as Lapsed for EWS uploaded on the <?php echo "$EWS_DATE"; ?>." ></i> <a href="../Export/EWS.php?EXECUTE=RAW&WARNING=LAPSED&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Bounced DD <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as Bounced DD for EWS uploaded on the <?php echo "$EWS_DATE"; ?>."></i> <a href="../Export/EWS.php?EXECUTE=RAW&WARNING=BOUNCED DD&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Cancelled DD <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as Cancelled DD for EWS uploaded on the <?php echo "$EWS_DATE"; ?>."</i> <a href="../Export/EWS.php?EXECUTE=RAW&WARNING=CANCELLED DD&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Cancelled <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as CFO and Lapsed for EWS uploaded on the <?php echo "$EWS_DATE"; ?>."</i> <a href="../Export/EWS.php?EXECUTE=RAW_CANCELLED&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Uploaded</th>
                            </tr>
                            </thead>

                            <?php
                            
                            echo "<tr>
                                    <td>$RAW_CFO</td>
                                    <td>$RAW_Lapsed</td>
                                    <td>$RAW_BOUNCED_DD</td>
                                    <td>$RAW_CANCELLED_DD</td>
                                    <td>$RAW_CANCELLED (£$RAW_CFO_LAPSED_SUM)</td>
                                    <td>$TOTAL_RAW</td>
                                    </tr>
                                    \n";
                         ?>
 

                        </table>  
                            
                            <?php  
//DATE SEARCH AND RAW DATE
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/compare/CFO.php');
    $COMPARECFO = new COMPARECFOModal($pdo);
    $COMPARECFOList = $COMPARECFO->getCOMPARECFO($EWS_DATE);
    require_once(__DIR__ . '/views/EWS/compare/CFO.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/compare/LAPSED.php');
    $COMPARELapsed = new COMPARELapsedModal($pdo);
    $COMPARELapsedList = $COMPARELapsed->getCOMPARELapsed($EWS_DATE);
    require_once(__DIR__ . '/views/EWS/compare/Lapsed.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/compare/BOUNCED_DD.php');
    $COMPAREBOUNCED_DD = new COMPAREBOUNCED_DDModal($pdo);
    $COMPAREBOUNCED_DDList = $COMPAREBOUNCED_DD->getCOMPAREBOUNCED_DD($EWS_DATE);
    require_once(__DIR__ . '/views/EWS/compare/BOUNCED_DD.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/compare/CANCELLED_DD.php');
    $COMPARECANCELLED_DD = new COMPARECANCELLED_DDModal($pdo);
    $COMPARECANCELLED_DDList = $COMPARECANCELLED_DD->getCOMPARECANCELLED_DD($EWS_DATE);
    require_once(__DIR__ . '/views/EWS/compare/CANCELLED_DD.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/compare/CANCELLED.php');
    $COMPARECANCELLED = new COMPARECANCELLEDModal($pdo);
    $COMPARECANCELLEDList = $COMPARECANCELLED->getCOMPARECANCELLED($EWS_DATE);
    require_once(__DIR__ . '/views/EWS/compare/CANCELLED.php');                            
    //END OF CALCULATION                              
    
//CALCULATE TOTAL WITH DATES
    require_once(__DIR__ . '/models/EWS/compare/TOTAL.php');
    $COMPARETOTAL = new COMPARETOTALModal($pdo);
    $COMPARETOTALList = $COMPARETOTAL->getCOMPARETOTAL($datefrom, $dateto);
    require_once(__DIR__ . '/views/EWS/compare/TOTAL.php');                            
    //END OF CALCULATION          
?>
                        
                        <table  class="table table-hover">
                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "Updated RAW Statistics for $EWS_DATE";?> 
                                        <i class="fa fa-question-circle-o" style="color:skyblue" title="Download Updated RAW EWS <?php echo "$EWS_DATE"; ?>."></i> <a href="../Export/EWS.php?EXECUTE=UPDATED_EWS&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i> Updated</a>
                                    </th>
                                </tr>
                               
                                <th>CFO <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as CFO for EWS uploaded on the <?php echo "$EWS_DATE"; ?>."</i> <a href="../Export/EWS.php?EXECUTE=RAW&WARNING=CFO&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Lapsed <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as Lapsed for EWS uploaded on the <?php echo "$EWS_DATE"; ?>." ></i> <a href="../Export/EWS.php?EXECUTE=RAW&WARNING=LAPSED&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Bounced DD <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as Bounced DD for EWS uploaded on the <?php echo "$EWS_DATE"; ?>."></i> <a href="../Export/EWS.php?EXECUTE=RAW&WARNING=BOUNCED DD&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Cancelled DD <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as Cancelled DD for EWS uploaded on the <?php echo "$EWS_DATE"; ?>."</i> <a href="../Export/EWS.php?EXECUTE=RAW&WARNING=CANCELLED DD&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Cancelled <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as CFO and Lapsed for EWS uploaded on the <?php echo "$EWS_DATE"; ?>."</i> <a href="../Export/EWS.php?EXECUTE=RAW_CANCELLED&EWS_DATE=<?php echo $EWS_DATE; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Updated</th>
                            </tr>
                            </thead>

                            <?php
                            
                            echo "<tr>
                                    <td>$COM_CFO</td>
                                    <td>$COM_Lapsed</td>
                                    <td>$COM_BOUNCED_DD</td>
                                    <td>$COM_CANCELLED_DD</td>
                                    <td>$COM_CANCELLED (£$COM_CFO_LAPSED_SUM)</td>
                                    <td>$TOTAL_COMPARE</th>
                                    </tr>
                                    \n";
                         ?>
 

                        </table>                          
                        
<?php
    
//EWS STATS    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/statuses/CFO.php');
    $TotalCFO = new TotalCFOModal($pdo);
    $TotalCFOList = $TotalCFO->getTotalCFO($datefrom, $dateto);
    require_once(__DIR__ . '/views/EWS/statuses/CFO.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/statuses/LAPSED.php');
    $TotalLapsed = new TotalLapsedModal($pdo);
    $TotalLapsedList = $TotalLapsed->getTotalLapsed($datefrom, $dateto);
    require_once(__DIR__ . '/views/EWS/statuses/Lapsed.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/statuses/BOUNCED_DD.php');
    $TotalBOUNCED_DD = new TotalBOUNCED_DDModal($pdo);
    $TotalBOUNCED_DDList = $TotalBOUNCED_DD->getTotalBOUNCED_DD($datefrom, $dateto);
    require_once(__DIR__ . '/views/EWS/statuses/BOUNCED_DD.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/statuses/CANCELLED_DD.php');
    $TotalCANCELLED_DD = new TotalCANCELLED_DDModal($pdo);
    $TotalCANCELLED_DDList = $TotalCANCELLED_DD->getTotalCANCELLED_DD($datefrom, $dateto);
    require_once(__DIR__ . '/views/EWS/statuses/CANCELLED_DD.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/statuses/CANCELLED.php');
    $TotalCANCELLED = new TotalCANCELLEDModal($pdo);
    $TotalCANCELLEDList = $TotalCANCELLED->getTotalCANCELLED($datefrom, $dateto);
    require_once(__DIR__ . '/views/EWS/statuses/CANCELLED.php');                            
    //END OF CALCULATION    
//CALCULATE TOTAL WITH DATES
    require_once(__DIR__ . '/models/EWS/statuses/TOTAL.php');
    $TotalTOTAL = new TotalTOTALModal($pdo);
    $TotalTOTALList = $TotalTOTAL->getTotalTOTAL($datefrom, $dateto);
    require_once(__DIR__ . '/views/EWS/statuses/TOTAL.php');                            
    //END OF CALCULATION      
                        ?>       

                        <table  class="table table-hover">
                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "EWS Statistics for $datefrom - $dateto";?>
                                    </th>
                                </tr>
                               
                                <th>CFO <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as CFO within the date range of <?php echo "$datefrom - $dateto"; ?> and need to be worked."</i> <a href="../Export/EWS.php?EXECUTE=EWS&WARNING=CFO&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>Lapsed <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as Lapsed within the date range of <?php echo "$datefrom - $dateto"; ?> and need to be worked." ></i> <a href="../Export/EWS.php?EXECUTE=EWS&WARNING=LAPSED&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Bounced DD <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as Bounced DD within the date range of <?php echo "$datefrom - $dateto"; ?> and need to be worked."></i> <a href="../Export/EWS.php?EXECUTE=EWS&WARNING=BOUNCED DD&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Cancelled DD <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as Cancelled DD within the date range of <?php echo "$datefrom - $dateto"; ?> and need to be worked."</i> <a href="../Export/EWS.php?EXECUTE=EWS&WARNING=CANCELLED DD&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Cancelled <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as CFO and Lapsed within the date range of <?php echo "$datefrom - $dateto"; ?> and need to be worked."</i> <a href="../Export/EWS.php?EXECUTE=EWS_CANCELLED&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>New</th>
                            </tr>
                            </thead>

                            <?php
                            
                            echo "<tr>
                                    <td>$CFO</td>
                                    <td>$Lapsed</td>
                                    <td>$BOUNCED_DD</td>
                                    <td>$CANCELLED_DD</td>
                                    <td>$CANCELLED (£$NEW_CFO_LAPSED_SUM)</td>
                                    <td>$TOTAL_EWS</td>
                                    </tr>
                                    \n";
                         ?>
 

                        </table>
    <?php                    
    ////ADL EWS STATS

    //CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/statuses/REINSTATED.php');
    $TotalREINSTATED = new TotalREINSTATEDModal($pdo);
    $TotalREINSTATEDList = $TotalREINSTATED->getTotalREINSTATED($datefrom, $dateto);
    require_once(__DIR__ . '/views/EWS/statuses/REINSTATED.php');                            
    //END OF CALCULATION
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/statuses/WILL_CANCEL.php');
    $TotalWILL_CANCEL = new TotalWILL_CANCELModal($pdo);
    $TotalWILL_CANCELList = $TotalWILL_CANCEL->getTotalWILL_CANCEL($datefrom, $dateto);
    require_once(__DIR__ . '/views/EWS/statuses/WILL_CANCEL.php');                            
    //END OF CALCULATION   
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/statuses/WILL_REDRAW.php');
    $TotalWILL_REDRAW = new TotalWILL_REDRAWModal($pdo);
    $TotalWILL_REDRAWList = $TotalWILL_REDRAW->getTotalWILL_REDRAW($datefrom, $dateto);
    require_once(__DIR__ . '/views/EWS/statuses/WILL_REDRAW.php');                            
    //END OF CALCULATION    
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/statuses/REDRAWN.php');
    $TotalREDRAWN = new TotalREDRAWNModal($pdo);
    $TotalREDRAWNList = $TotalREDRAWN->getTotalREDRAWN($datefrom, $dateto);
    require_once(__DIR__ . '/views/EWS/statuses/REDRAWN.php');                            
    //END OF CALCULATION   
    
//CALCULATE AWAITING AMOUNT WITH DATES
    require_once(__DIR__ . '/models/EWS/statuses/ADL_CANCELLED.php');
    $TotalADL_CANCELLED = new TotalADL_CANCELLEDModal($pdo);
    $TotalADL_CANCELLEDList = $TotalADL_CANCELLED->getTotalADL_CANCELLED($datefrom, $dateto);
    require_once(__DIR__ . '/views/EWS/statuses/ADL_CANCELLED.php');                            
    //END OF CALCULATION    
    
    ?>
                        <table  class="table table-hover">
                            <thead>

                                <tr>
                                    <th colspan="8"><?php echo "ADL EWS Statistics for $datefrom - $dateto";?>
                                    </th>
                                </tr>
                               
                                <th>RE-INSTATED <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as RE-INSTATED within the date range of <?php echo "$datefrom - $dateto"; ?>."</i> <a href="../Export/EWS.php?EXECUTE=ADL&WARNING=RE-INSTATED&&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th> 
                                <th>WILL CANCEL <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as WILL CANCEL within the date range of <?php echo "$datefrom - $dateto"; ?>." ></i> <a href="../Export/EWS.php?EXECUTE=ADL&WARNING=WILL CANCEL&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>WILL REDRAW <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as WILL REDRAW within the date range of <?php echo "$datefrom - $dateto"; ?>."></i> <a href="../Export/EWS.php?EXECUTE=ADL&WARNING=WILL REDRAW&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>REDRAWN <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as REDRAWN within the date range of <?php echo "$datefrom - $dateto"; ?>."</i> <a href="../Export/EWS.php?EXECUTE=ADL&WARNING=REDRAWN&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                                <th>Cancelled <i class="fa fa-question-circle-o" style="color:skyblue" title="Total policies classed as CANCELLED within the date range of <?php echo "$datefrom - $dateto"; ?>."</i> <a href="../Export/EWS.php?EXECUTE=ADL&WARNING=CANCELLED&datefrom=<?php echo $datefrom; ?>&dateto=<?php echo $dateto; ?>"><i class="fa fa-download" style="color:orange" title="Download"></i></a></th>
                            </tr>
                            </thead>

                            <?php
                            
                            echo "<tr>
                                    <td>$REINSTATED</td>
                                    <td>$WILL_CANCEL</td>
                                    <td>$WILL_REDRAW</td>
                                    <td>$REDRAWN</td>
                                    <td>$ADL_CANCELLED</td>                                      
                                    </tr>
                                    \n";
                         ?>
 

                        </table>                          
                        
                        <?php } ?> 
                        
                    </div>
                </div>
            </div>            
            
            
        </div>
            
        <div id="menu2" class="tab-pane fade">   
            
            <div class="smallcontainer">
                
                <div class="row">
                <table id="white" class="display compact" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date Added</th>
                            <th>Master No</th>
                            <th>Agent No</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>DOB</th>
                            <th>Address 1</th>
                            <th>Address 2</th>
                            <th>Address 3</th>
                            <th>Address 4</th>
                            <th>Post Code</th>
                            <th>Policy Type</th>
                            <th>Last Full Premium Paid</th>
                            <th>Net Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start Date</th>
                            <th>Off Risk Date</th>
                            <th>Seller Name</th>
                            <th>frn</th>
                            <th>Reqs</th>
                            <th>EWS Warning</th>
                            <th>Updated Date</th>
                            <th>ID</th>
                            <th>ADL Warning</th>
                            <th>Our Notes</th>
                            <th>Colour</th>
                            <th>Assigned</th>
                        </tr>
                    </thead>
                        
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Date Added</th>
                            <th>Master No</th>
                            <th>Agent No</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>DOB</th>
                            <th>Address 1</th>
                            <th>Address 2</th>
                            <th>Address 3</th>
                            <th>Address 4</th>                            
                            <th>Post Code</th>
                            <th>Policy Type</th>
                            <th>Last Full Premium Paid</th>
                            <th>Net Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start Date</th>
                            <th>Off Risk Date</th>
                            <th>Seller Name</th>
                            <th>frn</th>
                            <th>Reqs</th>
                            <th>EWS Warning</th>
                            <th>Updated Date</th>
                            <th>ID</th>
                            <th>ADL Warning</th>
                            <th>Our Notes</th>
                            <th>Colour</th>
                            <th>Assigned</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
                <br>
                <br>
                <br>
                    
            </div>       
                
        </div>
            
        <!-- TAB 2 END -->
            
        <!-- TAB 5 START -->
            
        <div id="menu5" class="tab-pane fade">  
            
            
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-hdd"></span> Upload data</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <h3>Upload EWS data</h3>
                                        
                                    <form action="upload/EWS.php?EXECUTE=1" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                        <input name="csv" type="file" id="csv" />                                        
                                        <button type="submit" class="btn btn-success " data-toggle="modal" data-target="#processing-modal"><span class="glyphicon glyphicon-open"></span> Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                            
                        <br /><br />
 
    
                    </div>
                </div>
            </div> 
        </div>
    </div>
    
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-1.11.1.min.js"></script>    
    <script type="text/javascript" language="javascript" src="/datatables/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript" src="/datatables/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="/datatables/js/jquery.dataTables.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>    
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

    

    <script type="text/javascript" language="javascript" >
               
        $(document).ready(function() {
            var table = $('#white').DataTable( {
                dom: 'C<"clear">lfrtip',
                "fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData["color_status"] != '' )  {
                        $('td', nRow).css("color", aData["color_status"]);
                    }
                    
                     if ( aData["color_status"] == "Black" )  {
                        $('td', nRow).addClass( 'black' );
                    }
                
    },
                "response":true,
                "processing": true,
                "iDisplayLength": 2000,
                "aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000], [5, 10, 25, 50, 100, 125, 150, 200, 2000, 2500, 3000]],
                "language": {
                    "processing": "<div></div><div></div><div></div><div></div><div></div>"

                },
                "ajax": "datatables/EWS.php?EWS=1",
                 
                "columns": [
                    {
                        "className":      'details-control',
                        "data":           null,
                        "deferRender": true,                        
                        "defaultContent": ''
                    },
                    { "data": "date_added"},                   
                    { "data": "master_agent_no"},
                    { "data": "agent_no"},
                    { "data": "policy_number"},
                    { "data": "client_name"},
                    { "data": "dob"},
                    { "data": "address1"},
                    { "data": "address2"},
                    { "data": "address3"},
                    { "data": "address4"},
                    { "data": "post_code" },
                    { "data": "policy_type" },
                    { "data": "last_full_premium_paid" },
                    { "data": "net_premium" },
                    { "data": "premium_os" },
                    { "data": "clawback_due" },
                    { "data": "clawback_date" },
                    { "data": "policy_start_date" },
                    { "data": "off_risk_date" },
                    { "data": "seller_name" },
                    { "data": "frn" },
                    { "data": "reqs" },
                    { "data": "ews_status_status" },
                    { "data": "updated_date"},
                    { "data": "client_id",
                        "render": function(data, type, full, meta) {
                            return '<a href="/Life/ViewClient.php?search=' + data + '" target="_blank">"' + data + '"</a>';
                        } },                     
                    { "data": "warning" },
                    { "data": "ournotes" },
                    { "data": "color_status" },
                    { "data": "assigned" }

                ],
                "order": [[1, 'DESC']]
            } );

           
        } );      
</script>

   
    

   <div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <center><img src="/img/loading.gif" class="icon" /></center>
                    <h4>Uploading EWS... <button type="button" class="close" style="float: none;" data-dismiss="modal" aria-hidden="true">×</button></h4>
                </div>
            </div>
        </div>
    </div>
</div>  
        

    <script type="text/javascript">
    $(document).ready(function() {                                                                                                    
                                                                                                        
    
        $('#LOADINGEWS').modal('show');
    })
    
    ;
    
    $(window).load(function(){
        $('#LOADINGEWS').modal('hide');
    });
</script> 
    <script>
        $(function () {
            $("#datefrom").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
        $(function () {
            $("#dateto").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
    </script>  
<div class="modal modal-static fade" id="LOADINGEWS" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <center><i class="fa fa-spinner fa-pulse fa-5x fa-lg"></i></center>
                    <br>
                    <h3>Loading EWS... </h3>
                </div>
            </div>
        </div>
    </div>
</div> 
</body>
</html>

