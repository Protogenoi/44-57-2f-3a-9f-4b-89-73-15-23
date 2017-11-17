<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
include('../../includes/adlfunctions.php');

if($fflife=='0') {
    
    header('Location: ../../CRMmain.php'); die;
    
}

include('../../includes/ADL_PDO_CON.php');
include('../../includes/ADL_MYSQLI_CON.php');

include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_8_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;

}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ADL | EWS Policy Search</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
            <style>
        div.smallcontainer {
            margin: 0 auto;
            font: 70%/1.45em "Helvetica Neue",HelveticaNeue,Verdana,Arial,Helvetica,sans-serif;
        }
            </style>
    </head>
    <body>
        
        <?php
                
                include('../../includes/navbar.php');
                include('../../includes/ADL_PDO_CON.php');
                include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
    $EWSView= filter_input(INPUT_GET, 'EWSView', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($EWSView)) {
        
        $policy_numberSearch= filter_input(INPUT_GET, 'policy_number', FILTER_SANITIZE_NUMBER_INT);
        $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
        
        if($EWSView=='1') {
            
            if($companynamere=='Bluestone Protect' || $companynamere=='ADL_CUS') {
                         if (in_array($hello_name,$Level_8_Access, true)) {
                             
                        $query = $pdo->prepare("SELECT policy_number, policy_type, warning AS EWSSTATUS, last_full_premium_paid, net_premium, premium_os, clawback_due, clawback_date, policy_start_date, off_risk_date, reqs, ournotes, date_added, ews_status_status AS ADLSTATUS, client_name FROM ews_data WHERE policy_number=:policy");
                        
                        ?>
        
        <div class="smallcontainer">
            
                       
                        <table class="table">
                    <thead>
                        <tr>
                            <th>Date Added</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>Policy Type</th>
                            <th>Warning</th>
                            <th>Orig Status</th>
                            <th>Last Premium Paid</th>
                            <th>Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start</th>
                            <th>Risk Date</th>
                            <th>Reqs</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                        
                 
     
    
    <?php
                        $query->bindParam(':policy', $policy_numberSearch, PDO::PARAM_STR, 12);
                                                    $query->execute();
                            if ($query->rowCount()>0) {
                                while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                                    
                                    $EWSSTATUS=$result['EWSSTATUS'];
                                    $ADLSTATUS=$result['ADLSTATUS'];
                                    $polref=$result['policy_number'];
                             
                                    
                              echo '<tr>';
                                    echo "<td>".$result['date_added']."</td>";
                                    echo "<td>".$result['client_name']."</td>";
                                    echo "<td><form target='_blank' action='//www10.landg.com/ProtectionPortal/home.htm' method='post'><input type='hidden' name='searchCriteria.reference' id='searchCriteria.reference' value='$polref'><input type='hidden' name='searchCriteria.referenceType' id='searchCriteria.referenceType' value='B'><input type='hidden' name='searchCriteria.includeLife' value='true' ><button type='submit' value='Search' name='command' class='btn btn-default btn-sm'><i class='fa fa-search'></i> $polref</button></form></td>";
                                    
                                    echo "<td>".$result['policy_type']."</td>";                                    
                                                          
                                    if($EWSSTATUS) {
                                        switch ($EWSSTATUS) {
                                            case "RE-INSTATED":
                                                echo "<td><span class='label label-warning'>$EWSSTATUS</span></td>";
                                                break;
                                            case "REDRAWN":
                                                case "WILL REDRAW":
                                                    echo "<td><span class='label label-purple'>$EWSSTATUS</td>";
                                                    break;
                                                case "Cancelled":
                                                    case "CFO":
                                                        case "LAPSED":
                                                            case "CANCELLED DD":
                                                                case "BOUNCED DD":
                                                                    echo "<td><span class='label label-danger'>$EWSSTATUS</td>";
                                                                    break;
                                                                default:
                                                                    echo "<td><span class='label label-info'>$EWSSTATUS</td>";
                                                                    
                                        }
                                        
                                        }
                                        
                                        if($ADLSTATUS) {
                                            
                                            switch ($ADLSTATUS) {
                                                case "RE-INSTATED":
                                                    echo "<td><span class='label label-warning'>$ADLSTATUS</span></td>";
                                                    break;
                                                case "REDRAWN":
                                                    case "WILL REDRAW":
                                                        echo "<td><span class='label label-purple'>$ADLSTATUS</td>";
                                                        break;
                                                    case "Cancelled":
                                                        case "CFO":
                                                            case "LAPSED":
                                                                case "CANCELLED DD":
                                                                    case "BOUNCED DD":
                                                                        echo "<td><span class='label label-danger'>$ADLSTATUS</td>";
                                                                        break;
                                                                    default:
                                                                        echo "<td><span class='label label-info'>$ADLSTATUS</td>";
                                                                        
                                            }
                                            
                                            }
                                            
                                            echo "<td>".$result['last_full_premium_paid']."</td>";
                                            echo "<td>".$result['net_premium']."</td>";
                                            echo "<td>".$result['premium_os']."</td>";
                                            echo "<td>".$result['clawback_due']."</td>";
                                            echo "<td>".$result['clawback_date']."</td>";
                                            echo "<td>".$result['policy_start_date']."</td>";
                                            echo "<td>".$result['off_risk_date']."</td>";
                                            echo "<td>".$result['reqs']."</td>";
                                            echo "<td>".$result['ournotes']."</td>";
                                            echo "<td>".$result['color_status']."</td>";
                                            echo "</tr>";
                                                                                    }
                                                                                    }
                                                                                    
                                                                                    else {
                                                                                        echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data/information found (Policy)</div>";
                                                                                        
                                                                                    }
                                                                                
                                                                                ?>
                        </table>
                            
                            <?php
                             

                             
                             }
                                                                                
                                                                                }  
                                                                                
                                     if($companynamere!='Bluestone Protect') {
                                                      
                        $query = $pdo->prepare("SELECT policy_number, policy_type, warning AS EWSSTATUS, last_full_premium_paid, net_premium, premium_os, clawback_due, clawback_date, policy_start_date, off_risk_date, reqs, ournotes, date_added, ews_status_status AS ADLSTATUS, client_name FROM ews_data WHERE policy_number=:policy");
                        
                        ?>
        
        <div class="smallcontainer">
            
                       
                        <table class="table">
                    <thead>
                        <tr>
                            <th>Date Added</th>
                            <th>Client</th>
                            <th>Policy</th>
                            <th>Policy Type</th>
                            <th>Warning</th>
                            <th>Old Status</th>
                            <th>Last Premium Paid</th>
                            <th>Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start</th>
                            <th>Risk Date</th>
                            <th>Reqs</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                        
                 
     
    
    <?php
                        $query->bindParam(':policy', $policy_numberSearch, PDO::PARAM_STR, 12);
                                                    $query->execute();
                            if ($query->rowCount()>0) {
                                while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                                    
                                    $EWSSTATUS=$result['EWSSTATUS'];
                                    $ADLSTATUS=$result['ADLSTATUS'];
                                    $polref=$result['policy_number'];
                             
                                    
                              echo '<tr>';
                                    echo "<td>".$result['date_added']."</td>";
                                    echo "<td>".$result['client_name']."</td>";
                                    echo "<td><form target='_blank' action='//www10.landg.com/ProtectionPortal/home.htm' method='post'><input type='hidden' name='searchCriteria.reference' id='searchCriteria.reference' value='$polref'><input type='hidden' name='searchCriteria.referenceType' id='searchCriteria.referenceType' value='B'><input type='hidden' name='searchCriteria.includeLife' value='true' ><button type='submit' value='Search' name='command' class='btn btn-default btn-sm'><i class='fa fa-search'></i> $polref</button></form></td>";
                                    
                                    echo "<td>".$result['policy_type']."</td>";                                    
                                                          
                                    if($EWSSTATUS) {
                                        switch ($EWSSTATUS) {
                                            case "RE-INSTATED":
                                                echo "<td><span class='label label-warning'>$EWSSTATUS</span></td>";
                                                break;
                                            case "REDRAWN":
                                                case "WILL REDRAW":
                                                    echo "<td><span class='label label-purple'>$EWSSTATUS</td>";
                                                    break;
                                                case "Cancelled":
                                                    case "CFO":
                                                        case "LAPSED":
                                                            case "CANCELLED DD":
                                                                case "BOUNCED DD":
                                                                    echo "<td><span class='label label-danger'>$EWSSTATUS</td>";
                                                                    break;
                                                                default:
                                                                    echo "<td><span class='label label-info'>$EWSSTATUS</td>";
                                                                    
                                        }
                                        
                                        }
                                        
                                        if($ADLSTATUS) {
                                            
                                            switch ($ADLSTATUS) {
                                                case "RE-INSTATED":
                                                    echo "<td><span class='label label-warning'>$ADLSTATUS</span></td>";
                                                    break;
                                                case "REDRAWN":
                                                    case "WILL REDRAW":
                                                        echo "<td><span class='label label-purple'>$ADLSTATUS</td>";
                                                        break;
                                                    case "Cancelled":
                                                        case "CFO":
                                                            case "LAPSED":
                                                                case "CANCELLED DD":
                                                                    case "BOUNCED DD":
                                                                        echo "<td><span class='label label-danger'>$ADLSTATUS</td>";
                                                                        break;
                                                                    default:
                                                                        echo "<td><span class='label label-info'>$ADLSTATUS</td>";
                                                                        
                                            }
                                            
                                            }
                                            
                                            echo "<td>".$result['last_full_premium_paid']."</td>";
                                            echo "<td>".$result['net_premium']."</td>";
                                            echo "<td>".$result['premium_os']."</td>";
                                            echo "<td>".$result['clawback_due']."</td>";
                                            echo "<td>".$result['clawback_date']."</td>";
                                            echo "<td>".$result['policy_start_date']."</td>";
                                            echo "<td>".$result['off_risk_date']."</td>";
                                            echo "<td>".$result['reqs']."</td>";
                                            echo "<td>".$result['ournotes']."</td>";
                                            echo "<td>".$result['color_status']."</td>";
                                            echo "</tr>";
                                                                                    }
                                                                                    }
                                                                                    
                                                                                    else {
                                                                                        echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data/information found (Policy)</div>";
                                                                                        
                                                                                    }
                                                                                
                                                                                ?>
                        </table>
                            
                            <?php
                             

                             
                                                                                                             
                                                                                }                                                          
                             
                         }
                         }
                         
                         ?>

    </div>
        
                <div class="container">
                    <center>
            <div class="btn-group">
                <a href="../../EWSfiles.php" class="btn btn-primary"><i class="fa fa-exclamation-triangle"></i> View Full EWS</a>
                <a href="../ViewClient.php?search=<?php echo $search;?>" class="btn btn-warning"><i class="fa fa-arrow-circle-o-left"></i> Back to Client</a>
            </div>
                    </center>
        </div>
        
        <script src="../../js/jquery.min.js"></script>
        <script src="../../resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    </body>
</html>
