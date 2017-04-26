<!DOCTYPE html>
<html lang="en">
    <title>ADL | Lead Rates</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="imagetoolbar" content="no" />
    <link rel="stylesheet" href="../styles/realtimereport.css" type="text/css" />
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
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
    <script type="text/javascript" language="javascript" src="../js/jquery/jquery-3.0.0.min.js"></script>
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

        <table id='main2' cellspacing='0' cellpadding='10'>

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
        $dyn_table .= '<tr><td ' . $CR_BG_COL . '><strong style="font-size: 40px;">' . $AGENT_NAME . ' <br>' . $LEADS . '/' . $SALES . '<br>' . $Formattedrate . '</strong></td>';
    } else {
        $dyn_table .= '<td ' . $CR_BG_COL . '><strong style="font-size: 40px;">' . $AGENT_NAME . ' <br>' . $LEADS . '/' . $SALES . '<br>' . $Formattedrate . '</strong></td>';
    }
    $i++;
}
$dyn_table .= '</tr></table>';
} 
echo $dyn_table;
                    
          
            
            ?>
        </table>

    </div>

</body>
</html>
