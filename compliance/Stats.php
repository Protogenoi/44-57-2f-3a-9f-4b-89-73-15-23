<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

$Level_2_Access = array("Jade");

if (in_array($hello_name, $Level_2_Access, true)) {

    header('Location: ../Life/Financial_Menu.php');
    die;
}

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_1_Access, true)) {

    header('Location: /index.php?AccessDenied');
    die;
}
    $YEAR=date('Y');
    $MONTH=date('M'); 
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL | Sale Statistics</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
                <link rel="stylesheet" href="/styles/Notices.css">
        <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/styles/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/../includes/NAV.php'); ?> 

    <div class="container-fluid"><br>
        
        <?php require_once(__DIR__ . '/../compliance/php/notifications.php'); ?> 
        
                        <div class="row">
            <?php require_once(__DIR__ . '/includes/LeftSide.html'); ?> 
            
            <div class="col-9">
        
<div class="card"">
<h3 class="card-header">
Sale stats
</h3>
<div class="card-block">

<p class="card-text">
 
    
<h4 class="card-title">Add agent stats</h4>


       <table id="ClientListTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Agent</th>
                                        <?php if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
                                        <th>Company</th>
                                        <?php } ?>
                                        <th>Sales</th>
                                        <th>Standard</th>
                                        <th>CIC</th>
                                        <th>CFO</th>
                                        <th>Lapsed</th>
                                        <th>Cancel Rate</th>
                                        <th colspan="4">Options</th>
                                    </tr>
                                </thead>
                                
                                <form method='POST' action='php/Stats.php?EXECUTE=1'>
                                    <tr>
                                        <td>   <div class="form-group">
 <select class="form-control" name="STAT_ADVISOR" id="STAT_ADVISOR">
     <option value="">Select Agent...</option>
 </select>
   </div>  </td>
                                                                     <?php
        
        if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
        
                                    <td><div class="form-group">
    <select class="form-control" name='COMPANY_ENTITY'>
        <option value='Bluestone Protect'>Bluestone Protect</option>
        <option value='Protect Family Plans'>Protect Family Plans</option>
        <option value='Protected Life Ltd'>Protected Life Ltd</option>
        <option value='We Insure'>We Insure</option>
        <option value='The Financial Assessment Centre'>The Financial Assessment Centre</option>
        <option value='Assured Protect and Mortgages'>Assured Protect and Mortgages</option>
    </select>
                                        </div></td>
 
            
      <?php  }       ?>
                                        <td><input class='form-control' type='text' name='STAT_SALES' value="0"></td>

                                    <td><input class='form-control' type='text' name='STAT_STANDARD' value="0"></td>
                                    <td><input class='form-control' type='text' name='STAT_CIC' value="0"></td>
                                    <td><input class='form-control' type='text' name='STAT_CFO' value="0"></td>
                                    <td><input class='form-control' type='text' name='STAT_LAP' value="0"></td>
                                    <td><input class='form-control' type='text' name='STAT_CR' value="0"></td>
                                    <td><button type='submit'><i class='fa fa-save'></i></button></td></tr>      
                                    </form>
       </table>

<h4 class="card-title">Stats for the month for <?php echo "$MONTH - $YEAR"; ?></h4>
<?php

if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) {
    
      $QUERY = $pdo->prepare("SELECT 
    compliance_sale_stats_id,
    compliance_sale_stats_sales,
    compliance_sale_stats_company,
    compliance_sale_stats_standard_pols,
    compliance_sale_stats_cic_pols,
    compliance_sale_stats_cfo_pols,
    compliance_sale_stats_lapsed_pols,
    compliance_sale_stats_cancel_rate,
    compliance_sale_stats_advisor
FROM
    compliance_sale_stats
    WHERE
    compliance_sale_stats_year=:YEAR
    AND
    compliance_sale_stats_month=:MONTH");
     $QUERY->bindParam(':YEAR', $YEAR, PDO::PARAM_STR);
     $QUERY->bindParam(':MONTH', $MONTH, PDO::PARAM_STR);
     $QUERY->execute();
    
}

else {


      $QUERY = $pdo->prepare("SELECT 
    compliance_sale_stats_id,
    compliance_sale_stats_sales,
    compliance_sale_stats_company,
    compliance_sale_stats_standard_pols,
    compliance_sale_stats_cic_pols,
    compliance_sale_stats_cfo_pols,
    compliance_sale_stats_lapsed_pols,
    compliance_sale_stats_cancel_rate,
    compliance_sale_stats_advisor
FROM
    compliance_sale_stats
WHERE
    compliance_sale_stats_company =:COMPANY
    AND
    compliance_sale_stats_year=:YEAR
    AND
    compliance_sale_stats_month=:MONTH");
     $QUERY->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
     $QUERY->bindParam(':YEAR', $YEAR, PDO::PARAM_STR);
     $QUERY->bindParam(':MONTH', $MONTH, PDO::PARAM_STR);
     $QUERY->execute();
     
}
                                if ($QUERY->rowCount() > 0) {

?>

       <table id="ClientListTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Agent</th>
                                        <th>Company</th>
                                        <th>Sales</th>
                                        <th>Standard</th>
                                        <th>CIC</th>
                                        <th>CFO</th>
                                        <th>Lapsed</th>
                                        <th>Cancel Rate</th>
                                        <th colspan="4">Options</th>
                                    </tr>
                                </thead>
                                <?php 
                                
                                while ($result = $QUERY->fetch(PDO::FETCH_ASSOC)) {
                                    
                                    if(isset($result['compliance_sale_stats_advisor'] )) {
                                    $STAT_ADVISOR=$result['compliance_sale_stats_advisor'] ;
                                    }
                                    if(isset($result['compliance_sale_stats_company'] )) {
                                    $STAT_COMPANY=$result['compliance_sale_stats_company'] ;
                                    }
                                    if(isset($result['compliance_sale_stats_sales'])) {
                                    $STAT_SALES=$result['compliance_sale_stats_sales'];
                                    }
                                    if(isset($result['compliance_sale_stats_standard_pols'])) {
                                    $STAT_STANDARD=$result['compliance_sale_stats_standard_pols'];
                                    }
                                    if(isset($result['compliance_sale_stats_cic_pols'])) {
                                    $STAT_CIC=$result['compliance_sale_stats_cic_pols'];
                                    }
                                    if(isset($result['compliance_sale_stats_cfo_pols'])) {
                                    $STAT_CFO=$result['compliance_sale_stats_cfo_pols'];
                                    }
                                    if(isset($result['compliance_sale_stats_lapsed_pols'])) {
                                    $STAT_LAP=$result['compliance_sale_stats_lapsed_pols'];
                                    }
                                    if(isset($result['compliance_sale_stats_cancel_rate'])) {
                                    $STAT_CR=$result['compliance_sale_stats_cancel_rate'];
                                    }
                                    if(isset($result['compliance_sale_stats_id'])) {
                                    $STAT_ID=$result['compliance_sale_stats_id'];
                                    }
                                    
                                    echo "<form method='POST' action='php/Stats.php?EXECUTE=2&STAT_ID=$STAT_ID'><tr><td>$STAT_ADVISOR</td>"; 
                                    
                                            if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
        
                                <td> <div class="form-group">
    <select class="form-control" name='COMPANY_ENTITY'>
        <option <?php if(isset($STAT_COMPANY) && $STAT_COMPANY=='Bluestone Protect') { echo "selected"; } ?> value='Bluestone Protect'>Bluestone Protect</option>
        <option <?php if(isset($STAT_COMPANY) && $STAT_COMPANY=='Protect Family Plans') { echo "selected"; } ?> value='Protect Family Plans'>Protect Family Plans</option>
        <option <?php if(isset($STAT_COMPANY) && $STAT_COMPANY=='Protected Life Ltd') { echo "selected"; } ?> value='Protected Life Ltd'>Protected Life Ltd</option>
        <option <?php if(isset($STAT_COMPANY) && $STAT_COMPANY=='We Insure') { echo "selected"; } ?> value='We Insure'>We Insure</option>
        <option <?php if(isset($STAT_COMPANY) && $STAT_COMPANY=='The Financial Assessment Centre') { echo "selected"; } ?> value='The Financial Assessment Centre'>The Financial Assessment Centre</option>
        <option <?php if(isset($STAT_COMPANY) && $STAT_COMPANY=='Assured Protect and Mortgages') { echo "selected"; } ?> value='Assured Protect and Mortgages'>Assured Protect and Mortgages</option>
    </select>
                                    </div></td>
 
            
      <?php  } else {
        
    
                                
      echo "<td>$STAT_COMPANY</td>"; }
                                   echo " <td><input class='form-control' type='text' name='STAT_SALES' value='$STAT_SALES'></td>
                                    <td><input class='form-control' type='text' name='STAT_STANDARD' value='$STAT_STANDARD'></td>
                                    <td><input class='form-control' type='text' name='STAT_CIC' value='$STAT_CIC'></td>
                                    <td><input class='form-control' type='text' name='STAT_CFO' value='$STAT_CFO'></td>
                                    <td><input class='form-control' type='text' name='STAT_LAP' value='$STAT_LAP'></td>
                                    <td><input class='form-control' type='text' name='STAT_CR' value='$STAT_CR'></td>
                                    <td><button type='submit'><i class='fa fa-save'></i></button></td></tr>      
                                    </form>";
                                }
                                
                                
                                
                              ?> </table> <?php } 
                                ?>
       
</p>
</div>
<div class="card-footer">
ADL
</div>
</div>        
            </div>
                        </div>
               
    </div>
    
            <script src="/js/jquery/jquery-3.0.0.min.js"></script>
                    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="/js/datatables/jquery.DATATABLES.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>  
        
        <script type="text/javascript" language="javascript" >

            $(document).ready(function () {
                var table = $('#clients').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 25,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                    "ajax": "datatables/Compliance.php?EXECUTE=1",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "compliance_uploads_date"},
                        {"data": "compliance_uploads_title"},
                        {"data": "compliance_uploads_company"},
                        {"data": "compliance_uploads_location",
                            "render": function (data, type, full, meta) {
                                return '<a href="/../' + data + '" target="_blank"><i class="fa fa-search"></i></a>';
                            }}
                    ]
                });

            });
        </script>
                  <script type="text/JavaScript">
                                    var $select = $('#STAT_ADVISOR');
                                    $.getJSON('/compliance/JSON/Agents.php?EXECUTE=1', function(data){
                                    $select.html('agent_name');
                                    $.each(data, function(key, val){ 
                                    $select.append('<option value="' + val.FULL_NAME + '">' + val.FULL_NAME + '</option>');
                                    })
                                    });
                                </script>
</body>
</html>
