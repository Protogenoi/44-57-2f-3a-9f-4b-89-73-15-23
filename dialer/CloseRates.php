<!DOCTYPE html>
<html lang="en">
    <title>ADL | Real Time Report</title>
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
                    jQuery(".container").html(results);
                }
            });
        }

        t = setInterval(refresh_div, 10000);
    </script>
</head>
<body class="backcolour">
    <div class="contain-to-grid">
        <?php
        include("../includes/ADL_PDO_CON.php");


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
                    } else {
                        $Conversionrate = $LEADS / $SALES;
                        $Formattedrate = number_format($Conversionrate, 1);
                    }

                    echo '<td class="status_READY10"><strong style="font-size: 50px;">' . $CLOSER_NAME . ' <br>' . $LEADS . '/' . $SALES . '<br>' . $Formattedrate . '</strong></td>';
                }
            }
            ?>
        </table>

        <?php $STAT_QRY = $pdo->prepare("SELECT 
    closer,
    COUNT(IF(sale = 'QML',
        1,
        NULL)) AS QML,
    COUNT(IF(sale = 'QQQ',
        1,
        NULL)) AS QQQ,
    COUNT(IF(sale = 'QCBK',
        1,
        NULL)) AS QCBK,
    COUNT(IF(sale = 'DIDNO',
        1,
        NULL)) AS DIDNO,
    COUNT(IF(sale = 'QNQ',
        1,
        NULL)) AS QNQ,
    COUNT(IF(sale = 'QUN',
        1,
        NULL)) AS QUN,
    COUNT(IF(sale = 'QDE'
            OR sale = 'DEC',
        1,
        NULL)) AS QDE,
    COUNT(IF(sale = 'NoCard',
        1,
        NULL)) AS NoCard,
    COUNT(IF(sale = 'SALE',
        1,
        NULL)) AS Sales,
    COUNT(IF(sale NOT IN ('SALE' , 'NoCard',
            'QDE',
            'DEC',
            'QUN',
            'QNQ',
            'DIDNO',
            'QCBK',
            'QQQ',
            'QML'),
        1,
        NULL)) AS Other
FROM
    closer_trackers
WHERE
date_added > DATE(NOW())
GROUP BY closer
ORDER BY closer"); ?>

        <table id='main2' cellspacing='0' cellpadding='10'>
            <th class='status_PAUSED'>Closer</th>
            <th class='status_PAUSED'>Sales</th>
            <th class='status_PAUSED'>Quote Mortgage Lead</th>
            <th class='status_PAUSED'>Quoted</th>
            <th class='status_PAUSED'>Quote Callback</th>
            <th class='status_PAUSED'>Didn't Beat</th>
            <th class='status_PAUSED'>No Quote</th>
            <th class='status_PAUSED'>Underwritten</th>
            <th class='status_PAUSED'>Decline</th>
            <th class='status_PAUSED'>No Card</th>
            <th class='status_PAUSED'>Other</th>


<?php
$STAT_QRY->execute();
if ($STAT_QRY->rowCount() > 0) {
    while ($STAT_result = $STAT_QRY->fetch(PDO::FETCH_ASSOC)) {

        $QML = $STAT_result['QML'];
        $QQQ = $STAT_result['QQQ'];
        $QCBK = $STAT_result['QCBK'];
        $DIDNO = $STAT_result['DIDNO'];
        $QNQ = $STAT_result['QNQ'];
        $QUN = $STAT_result['QUN'];
        $QDE = $STAT_result['QDE'];
        $NoCard = $STAT_result['NoCard'];
        $OTHER = $STAT_result['Other'];

        $Sales = $STAT_result['Sales'];
        $Leads = $STAT_result['Leads'];
        $CLOSER_NAME = $STAT_result['closer'];

        switch ($CLOSER_NAME) {
            case("Matt"):
                $LEADS = $Leads - 0;
                $SALES = $Sales + 0;
                break;
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
                $SALES = $Sales + 0;
                break;
            case("Gavin"):
                $LEADS = $Leads - 0;
                $SALES = $Sales + 0;
                break;
            case("James"):
                $LEADS = $Leads - 0;
                $SALES = $Sales + 0;
                break;
            case("Ricky"):
                $LEADS = $Leads - 0;
                $SALES = $Sales + 0;
                break;
            default:
                $LEADS = $Leads;
                $SALES = $Sales;
                break;
        }

        echo '<tr><td class="status_READY10"><strong style="font-size: 50px;">' . $CLOSER_NAME . ' </strong></td>';
        echo '<td class="status_PAUSED12"><strong style="font-size: 50px;">' . $SALES . '</strong></td>';
        echo '<td class="status_PAUSED12"><strong style="font-size: 50px;">' . $QML . '</strong></td>';
        echo '<td class="status_PAUSED12"><strong style="font-size: 50px;">' . $QQQ . '</strong></td>';
        echo '<td class="status_PAUSED12"><strong style="font-size: 50px;">' . $QCBK . '</strong></td>';
        echo '<td class="status_PAUSED12"><strong style="font-size: 50px;">' . $DIDNO . '</strong></td>';
        echo '<td class="status_PAUSED12"><strong style="font-size: 50px;">' . $QNQ . '</strong></td><';
        echo '<td class="status_PAUSED12"><strong style="font-size: 50px;">' . $QUN . '</strong></td>';
        echo '<td class="status_PAUSED12"><strong style="font-size: 50px;">' . $QDE . '</strong></td>';
        echo '<td class="status_PAUSED12"><strong style="font-size: 50px;">' . $NoCard . '</strong></td>';
        echo '<td class="status_PAUSED12"><strong style="font-size: 50px;">' . $OTHER . '</strong></td>';
    }
}
?>
            <</table>
    </div>

</body>
</html>
