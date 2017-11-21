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

?><!DOCTYPE html>
<html lang="en">
    <title>ADL | Lead Rates</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="imagetoolbar" content="no" />
    <link rel="stylesheet" href="/resources/templates/ADL/wallboard.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="icon" type="../image/x-icon" href="/img/favicon.ico"  />
    <style>
        .vertical-center-row {
            display: table-cell;
            vertical-align: middle;
        }
        .backcolour {
            background-color:#05668d !important;
        }
    </style>
    <script type="text/javascript" language="javascript" src="../resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script>
        function refresh_div() {
            jQuery.ajax({
                url: ' ',
                type: 'POST',
                success: function (results) {
                    jQuery(".container-fluid").html(results);
                }
            });
        }

        t = setInterval(refresh_div, 10000);
    </script>
</head>
<body class="backcolour">
   <div class="container-fluid">
        <?php
        include("../includes/ADL_PDO_CON.php");


        $query = $pdo->prepare("SELECT 
agent,
    COUNT(IF(sale = 'SALE',
        1,
        NULL)) AS Sales,
 COUNT(IF(sale IN ('SALE' , 'NoCard',
            'QDE',
            'DEC',
            'QUN',
            'DIDNO',
            'QCBK',
            'QQQ',
            'QML'),
        1,
        NULL)) AS Leads
FROM
    closer_trackers

WHERE
date_added > DATE(NOW())
GROUP BY agent
ORDER BY Sales, Leads");
        ?>

        <table class="table-condensed" cellspacing='0' cellpadding='10'>

            <?php
            $dyn_table = '<table id="main2" cellspacing="0" "cellpadding="10">';
            
            $query->execute();
            if ($query->rowCount() > 0) {
                    $i = 0;
                while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                    $SALES = $result['Sales'];
                    $LEADS = $result['Leads'];
                    $AGENT_NAME = $result['agent'];


                    if ($SALES == '0') {
                        $Formattedrate = "0.0";
                        $CR_BG_COL = "bgcolor='white'";
                    } else {
                        $Conversionrate = $LEADS / $SALES;
                        $Formattedrate = number_format($Conversionrate, 1);
                    }

                    if ($SALES >= 1) {
                        $CR_BG_COL = "bgcolor='green'";
                    }
                    if ($SALES <1) {
                        $CR_BG_COL = "bgcolor='red'";
                    }
                   
                    
                     if ($i % 7 == 0) { 
        $dyn_table .= '<tr><td ' . $CR_BG_COL . '><strong style="font-size: 40px;">' . $AGENT_NAME . ' <br>' . $LEADS . '/' . $SALES . ' (' . $Formattedrate . ')</strong></td>';
    } else {
        $dyn_table .= '<td ' . $CR_BG_COL . '><strong style="font-size: 40px;">' . $AGENT_NAME . ' <br>' . $LEADS . '/' . $SALES . ' (' . $Formattedrate . ')</strong></td>';
    }
    $i++;
}
$dyn_table .= '</tr></table>';
} 
echo $dyn_table;
                    
          
            
            ?>
        </table>
       
        <?php
  


        $NO_LEADS = $pdo->prepare("SELECT 
    dialer_agents_name
FROM
    dialer_agents
WHERE
    dialer_agents_name NOT IN (SELECT 
            agent
        FROM
            closer_trackers WHERE date_added >= CURDATE());");
        ?>

        <table id='main2' cellspacing='0' cellpadding='10'>

            <?php
            $dyn_table2 = '<table id="main2" cellspacing="0" "cellpadding="10">';
            
            $NO_LEADS->execute();
            if ($NO_LEADS->rowCount() > 0) {
                    $i2 = 0;
                while ($result = $NO_LEADS->fetch(PDO::FETCH_ASSOC)) {

                    $AGENT_NAME2 = $result['dialer_agents_name'];


                   
                    
                     if ($i2 % 7 == 0) { 
        $dyn_table2 .= '<tr><td bgcolor="white"><strong style="font-size: 40px;">' . $AGENT_NAME2 . '</strong></td>';
    } else {
        $dyn_table2 .= '<td bgcolor="white"><strong style="font-size: 40px;">' . $AGENT_NAME2 . ' </strong></td>';
    }
    $i2++;
}
$dyn_table2 .= '</tr></table>';
} 
echo $dyn_table2;
                    
          
            
            ?>
        </table>       

    </div>

</body>
</html>
