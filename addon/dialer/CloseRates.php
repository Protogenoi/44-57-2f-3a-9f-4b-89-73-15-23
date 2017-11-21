<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 * 
*/  

?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Close Rates</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="imagetoolbar" content="no" />
    <link rel="stylesheet" href="/resources/templates/ADL/wallboard.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="icon" type="/image/x-icon" href="/img/favicon.ico"  />
    <style>
        .vertical-center-row {
            display: table-cell;
            vertical-align: middle;
        }
        .backcolour {
            background-color:#05668d !important;
        }
 .blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {  
  50% { opacity: 0; }
}       
h1 {
    font-size: 600%;
}
    </style>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script>
        function refresh_div() {
            jQuery.ajax({
                url: ' ',
                type: 'POST',
                success: function (results) {
                    jQuery(".contain-to-grid").html(results);
                }
            });
        }

        t = setInterval(refresh_div, 10000);
    </script>
</head>
<body class="backcolour">
    <div class="contain-to-grid">
        <?php
        require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

        $query = $pdo->prepare("SELECT 
closer,
    COUNT(IF(sale = 'SALE',
        1,
        NULL)) AS Sales,
 COUNT(IF(sale IN ('SALE' , 'NoCard',
            'QDE',
            'DEC',
            'QUN',
            'QNQ',
            'DIDNO',
            'QCBK',
            'QQQ',
            'Other',
            'QML'),
        1,
        NULL)) AS Leads
FROM
    closer_trackers

WHERE
date_added > DATE(NOW())
GROUP BY closer
ORDER BY Sales, Leads");
        ?>

        <table id='main2' cellspacing='0' cellpadding='10'>

            <?php
            $query->execute();
            if ($query->rowCount() > 0) {
                while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                    $Sales = $result['Sales'];
                    $Leads = $result['Leads'];
                    $CLOSER_NAME = $result['closer'];

                    switch ($CLOSER_NAME) {
                        case("Richard"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales + 0;
                            break;
                        case("Kyle"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales + 0;
                            break;
                        case("Sarah"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales - 0;
                            break;
                        case("Gavin"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales + 0;
                            break;
                        case("James"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales + 0;
                            break;
                        case("David"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales - 0;
                        case("Hayley"):
                            $LEADS = $Leads - 0;
                            $SALES = $Sales - 0;
                            break;
                        default:
                            $LEADS = $Leads;
                            $SALES = $Sales;
                            break;
                    }

                    if ($SALES == '0') {
                        $Formattedrate = "0.0";
                        $CR_BG_COL = "bgcolor='white'";
                    } else {
                        $Conversionrate = $LEADS / $SALES;
                        $Formattedrate = number_format($Conversionrate, 1);
                    }

                    if ($Formattedrate >4.9 && $Formattedrate<6) {
                        $CR_BG_COL = "bgcolor='orange'";
                    }
                    if ($Formattedrate <=4.9 && $Formattedrate >= 1) {
                        $CR_BG_COL = "bgcolor='green'";
                    }
                    if ($Formattedrate >= 6) {
                        $CR_BG_COL = "bgcolor='red'";
                    }
                    echo '<td ' . $CR_BG_COL . '><strong style="font-size: 50px;">' . $CLOSER_NAME . ' <br>' . $LEADS . '/' . $SALES . '<br>' . $Formattedrate . '</strong></td>';
                }
            }
            ?>
        </table>

<?php        
$NEWLEAD = $pdo->prepare("select agent,closer from dealsheet_call ");
$NEWLEAD->execute();
if ($NEWLEAD->rowCount()>0) {
while ($result=$NEWLEAD->fetch(PDO::FETCH_ASSOC)){

?>
      
                      <div class="row blink_me">
                <div class="col-sm-12">
                    <center><h1 style="color:white;"><i class="fa fa-exclamation"></i> <?php echo $result['agent']; ?> SEND LEAD TO <?php echo $result['closer']; ?> <i class="fa fa-exclamation"></i></h1></center>
                </div>
      </div>
      
      
      <?php

}
}        

        $TRACKER = $pdo->prepare("SELECT date_updated, tracker_id, agent, closer, client, current_premium, our_premium, comments, sale, date_updated FROM closer_trackers WHERE date_updated >= CURDATE() ORDER BY date_added DESC LIMIT 5");
        $TRACKER->execute();

        if ($TRACKER->rowCount() > 0) {
            ?>

            <table id="tracker" class="table" id="users">
                <thead>
                    <tr>
                        <th>Closer</th>
                        <th>Agent</th>
                        <th>Client</th>
                        <th>Current Premium</th>
                        <th>Our Premium</th>
                        <th>Notes</th>
                        <th>DISPO</th>
                    </tr>
                </thead> <?php
                while ($TRACKERresult = $TRACKER->fetch(PDO::FETCH_ASSOC)) {
                    
                    $TRK_tracker_id = $TRACKERresult['tracker_id'];
                    $TRK_agent = $TRACKERresult['agent'];
                    $TRK_closer = $TRACKERresult['closer'];
                    $TRK_client = $TRACKERresult['client'];

                    $TRK_current_premium = $TRACKERresult['current_premium'];
                    $TRK_our_premium = $TRACKERresult['our_premium'];
                    $TRK_comments = $TRACKERresult['comments'];
                    $TRK_sale = $TRACKERresult['sale'];

                    switch ($TRK_sale) {
                        case "QCBK":
                            $TRK_sale = "Quoted Callback";
                            $TRK_BG = "#cc99ff";
                            break;
                        case "SALE":
                            $TRK_sale = "SALE";
                            $TRK_BG = "#00ff00";
                            break;
                        case "QQQ":
                            $TRK_sale = "Quoted";
                            $TRK_BG = "#66ccff";
                            break;
                        case "NoCard":
                            $TRK_sale = "No Card Details";
                            $TRK_BG = "##cc0000";
                            break;
                        case "QUN":
                            $TRK_sale = "Underwritten";
                            $TRK_BG = "#ff0066";
                            break;
                        case "QNQ":
                            $TRK_sale = "No Quote";
                            $TRK_BG = "#ffcc00";
                            break;
                        case "DIDNO":
                            $TRK_sale = "Quote Not Beaten";
                            $TRK_BG = "#ff6600";
                            break;
                        case "QML":
                            $TRK_sale = "Quote Mortgage Lead";
                            $TRK_BG = "#669900";
                            break;
                        case "QDE":
                            $TRK_sale = "Decline";
                            $TRK_BG = "#FF0000";
                            break;
                         case "Thought we were an insurer":
                            $TRK_sale = "Insurer";
                            $TRK_BG = "#ff33cc";
                            break;
                         case "Hangup on XFER":
                            $TRK_sale = "Hang Up";
                            $TRK_BG = "#ff33cc";
                            break;
                        default:
                            $TRK_sale = $TRK_sale;
                            $TRK_BG = "#ffffff";
                    }
                    ?>

                    <tr>
                        <td bgcolor="#ffffff"> <strong style="font-size: 40px;"> <?php echo $TRK_closer; ?></strong></td>
                        <td bgcolor="#ffffff"><strong style="font-size: 40px;"><?php echo $TRK_agent; ?></strong></td>
                        <td bgcolor="#ffffff"><strong><?php echo $TRK_client; ?></strong></td>
                        <td bgcolor="#ffffff"><strong><?php echo $TRK_current_premium; ?></strong></td>
                        <td bgcolor="#ffffff"><strong><?php echo $TRK_our_premium; ?></strong></td>
                        <td bgcolor="#ffffff"><strong style="font-size: 40px;"><?php echo $TRK_comments; ?></strong></td>
                        <td bgcolor="<?php echo $TRK_BG; ?>"><strong style="font-size: 40px;"><?php echo $TRK_sale; ?></strong></td>

                    <?php
                    }
                }
                ?>          
        </table> 


    </div>
<?php require_once(__DIR__ . '/../../app/Holidays.php'); ?>
</body>
</html>
