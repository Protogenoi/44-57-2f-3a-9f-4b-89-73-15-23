<?php
require_once(__DIR__ . '/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/includes/adl_features.php');
require_once(__DIR__ . '/includes/Access_Levels.php');
require_once(__DIR__ . '/includes/adlfunctions.php');
require_once(__DIR__ . '/includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($fflife == '0') {

    header('Location: /CRMmain.php');
    die;
}

if (!in_array($hello_name, $Level_10_Access, true)) {

    header('Location: /CRMmain.php');
    die;
}

$datefrom = filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$dateto = filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html>
    <title>ADL | RAW COMM Upload</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

    <style>
        .panel-body .btn:not(.btn-block) { width:120px;margin-bottom:10px; }
    </style>

</head>
<body>

    <?php require_once(__DIR__ . '/includes/navbar.php'); ?>

    <div class="container">
        
        <?php 
        $database = new Database();
            $database->query("SELECT uploader from financial_statistics_history WHERE insert_date> DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY uploader");
            $database->execute(); 
            $FIN_ALERT = $database->single();  
            
            if ($database->rowCount()>=1) { ?>
        <div class='notice notice-warning' role='alert'><strong> <center><i class="fa fa-exclamation"></i> Financial's for Legal and General have already been uploaded for this week by <?php echo $FIN_ALERT['uploader']; ?>.</center></strong> </div>  
        <?php    }
        
        ?>
        

        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#menu3">RAW COMM Upload</a>
            </li>
            <li><a data-toggle="pill" href="#finsearch">Policy Search</a>
            </li>
        </ul>
    </div>
    <div class="tab-content">

        <div id="menu3" class="tab-pane fade in active">
            <div class="container">
                <br>
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
                                        <h3>Upload Legal & General financials</h3>

                                        <form action="/upload/finrupload.php?EXECUTE=1" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <input class="form-control" name="csv" type="file" id="csv" required/>
                                            <input type="hidden" name="Processor" value="<?php echo $hello_name ?>">
                                            <br>
                                            <button type="submit" name="Submit" value="Submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                        </form>

                                        <form action="/export/finreporttemp.php" method="post">
                                            <button type="submit" class="btn btn-info "><span class="glyphicon glyphicon-save"></span> Template</button>
                                        </form>
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                        <h3>Upload WOL financials</h3>


                                        <form action="/upload/finrupload.php?EXECUTE=2" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <input class="form-control" name="csv" type="file" id="csv" required/>
                                            <br>
                                            <button type="submit" name="Submit" value="Submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                        </form>
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                        <h3>Upload Royal London financials</h3>


                                        <form action="/upload/finrupload.php?EXECUTE=3" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <input class="form-control" name="csv" type="file" id="csv" required/>
                                            <br>
                                            <button type="submit" name="Submit" value="Submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                        </form>
                                    </div>   
                                    <div class="col-xs-6 col-md-6">
                                        <h3>Upload Vitality financials</h3>


                                        <form action="/upload/finrupload.php?EXECUTE=4" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <input class="form-control" name="csv" type="file" id="csv" required/>
                                            <br>
                                            <button type="submit" name="Submit" value="Submit" data-toggle="modal" data-target="#processing-modal" class="btn btn-success "><span class="glyphicon glyphicon-open"></span> Upload</button>
                                        </form>
                                    </div>                                      
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="text-center">
                                    <center><img src="img/loading.gif" class="icon" /></center>
                                    <h4>Uploading... <button type="button" class="close" style="float: none;" data-dismiss="modal" aria-hidden="true">×</button></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>

        <div id="finsearch" class="tab-pane fade">            
            <div class="container">

                <form class="form-inline" method="POST" action="Financial_Reports.php?SearchByPol=1#finsearch">
                    <fieldset>

                        <legend>Search Financials by Policy Number</legend>

                        <div class="form-group">

                            <div class="col-xs-2 col-lg-3">
                                <input id="policy_number" name="FINpolicy_number" <?php
                                if (isset($FINpolicy_number)) {
                                    echo "value=$FINpolicy_number";
                                }
                                ?> class="form-control input-md" required type="text">

                            </div>
                        </div>

                        <div class="btn-group">
                            <button id="button1id" name="button1id" class="btn btn-success"<i class="fa fa-search"></i> Search</button>
                            <a href="#" class="btn btn-danger "><i class="fa fa-refresh"></i> Reset</a>
                        </div>



                    </fieldset>
                </form>

                <?php
                if (isset($SearchByPol)) {
                    if ($SearchByPol == '1') {


                        $financial = $pdo->prepare("SELECT financial_statistics_history.*, client_policy.policy_number, client_policy.CommissionType, client_policy.policystatus, client_policy.closer, client_policy.lead, client_policy.id AS POLID FROM financial_statistics_history join client_policy on financial_statistics_history.Policy = client_policy.policy_number WHERE policy=:id GROUP BY financial_statistics_history.id");
                        $financial->bindParam(':id', $FINpolicy_number, PDO::PARAM_STR);
                        ?>

                        <table  class='table table-hover table-condensed'>
                            <thead>
                                <tr>
                                    <th colspan='7'>Financial Report</th>
                                </tr>
                            <th>Comm Date</th>
                            <th>Policy</th>
                            <th>Commission Type</th>
                            <th>Policy Status</th>
                            <th>Closer</th>
                            <th>Lead</th>
                            <th>Amount</th>
                            </thead>

                            <?php
                            $financial->execute()or die(print_r($financial->errorInfo(), true));
                            if ($financial->rowCount() > 0) {
                                while ($row = $financial->fetch(PDO::FETCH_ASSOC)) {

                                    $formattedpayment = number_format($row['payment'], 2);
                                    $formatteddeduction = number_format($row['deduction'], 2);
                                    $clientid = $row['policy_number'];

                                    echo '<tr class=' . $class . '>';
                                    echo "<td>" . $row['insert_date'] . "</td>";
                                    echo "<td><a target='_blank' href='/ViewPolicy.php?&policyID=" . $row['POLID'] . "'>" . $row['Policy'] . "</a></td>";
                                    echo "<td>" . $row['CommissionType'] . "</td>";
                                    echo "<td>" . $row['policystatus'] . "</td>";
                                    echo "<td>" . $row['closer'] . "</td>";
                                    echo "<td>" . $row['lead'] . "</td>";
                                    if (intval($row['Payment_Amount']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $row['Payment_Amount'] . "</span></td>";
                                    } else if (intval($row["Payment_Amount"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $row['Payment_Amount'] . "</span></td>";
                                    } else {
                                        echo "<td>" . $row['Payment_Amount'] . "</td>";
                                    }
                                    echo "</tr>";
                                    echo "\n";
                                }
                            } else {
                                echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                            }
                            ?>

                        </table>

                        <?php
                    }
                }
                ?>

            </div>
        </div>
    </div>

    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script> 
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
    <script type="text/javascript" language="javascript" src="js/datatables/jquery.DATATABLES.min.js"></script>
    <script>
        $("#CLICKTOHIDEFINFOUND").click(function () {
            $("#HIDEFINFOUND").fadeOut("slow", function () {

            });
        });

        $("#CLICKTOHIDEFINNOTFOUND").click(function () {
            $("#HIDEFINNOTFOUND").fadeOut("slow", function () {

            });
        });
    </script>
    <script>

        $(document).ready(function () {
            if (window.location.href.split('#').length > 1)
            {
                $tab_to_nav_to = window.location.href.split('#')[1];
                if ($(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']").length)
                {
                    $(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']")[0].click();
                }
            }
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
    </script>
    <script>
        $(function () {
            $("#dateto").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
    </script>  
</body>
</html>
