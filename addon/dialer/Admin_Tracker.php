<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
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
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
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
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="icon" type="/image/x-icon" href="/img/favicon.ico"  />
    <script type="text/javascript" language="javascript" src="/resources/templates/fontawesome/svg-with-js/js/fontawesome-all.js"></script>
    <style>
        .backcolour {
            background-color:#05668d !important;
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

        t = setInterval(refresh_div, 1000);
    </script>
</head>
<body class="backcolour">
    <div class="contain-to-grid">
        <?php
        require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

    require_once(__DIR__ . '/models/CLOSERS/LAST_SALE-MODAL.php');
    $LAST_SALE = new LAST_SALEModal($pdo);
    $LAST_SALEList = $LAST_SALE->getLAST_SALE();
    require_once(__DIR__ . '/views/CLOSERS/LAST_SALE-VIEW.php');   


        $TRACKER = $pdo->prepare("SELECT insurer, date_updated, tracker_id, agent, closer, client, sale, date_updated FROM closer_trackers WHERE date_updated >= CURDATE() AND sale ='SALE' ORDER BY date_added DESC LIMIT 5");
        $TRACKER->execute();

        if ($TRACKER->rowCount() > 0) {
            ?>

            <table id="tracker" class="table" id="users">
                <thead>
                    <tr>
                        <th>Closer</th>
                        <th>Agent</th>
                        <th>Client</th>
                        <th>Insurer</th>
                        <th>DISPO</th>
                    </tr>
                </thead> <?php
                while ($TRACKERresult = $TRACKER->fetch(PDO::FETCH_ASSOC)) {
                    
                    $TRK_tracker_id = $TRACKERresult['tracker_id'];
                    $TRK_agent = $TRACKERresult['agent'];
                    $TRK_closer = $TRACKERresult['closer'];
                    $TRK_client = $TRACKERresult['client'];

                    $TRK_sale = $TRACKERresult['sale'];
                    $TRK_INSURER = $TRACKERresult['insurer'];

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
                    
                    if($TRK_closer == 'Martin Smith') {
                        $TRK_closer = 'Martin';
                    }
                    ?>

                    <tr>
                        <td bgcolor="#ffffff"><strong style="font-size: 40px;"> <?php echo $TRK_closer; ?></strong></td>
                        <td bgcolor="#ffffff"><strong style="font-size: 40px;"><?php echo $TRK_agent; ?></strong></td>
                        <td bgcolor="#ffffff"><strong style="font-size: 40px;"><?php echo $TRK_client; ?></strong></td>
                        <td bgcolor="#ffffff"><strong style="font-size: 40px;"><?php echo $TRK_INSURER; ?></strong></td>
                        <td bgcolor="<?php echo $TRK_BG; ?>"><strong style="font-size: 40px;"><?php echo $TRK_sale; ?></strong></td>

                    <?php
                    }
                }
                ?>          
        </table> 

<?php 
$Today_TIME=date("h:i:s");
$Today_DATES = date("l jS \of F Y"); ?>   
        
        
                    <div class="col-md-12">

                        <div class="col-md-4"></div>
                        <div class="col-md-4"><?php echo "<font color='white'><h3>$Today_TIME | $Today_DATES</h3</font>"; ?></div>
                        <div class="col-md-4"></div>

                    </div>          
        
    </div>    
</body>
</html>