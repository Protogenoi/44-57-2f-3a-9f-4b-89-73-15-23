<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 9);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../classes/database_class.php');
require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$dateto = filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$datefrom = filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);

$OPTION = filter_input(INPUT_GET, 'option', FILTER_SANITIZE_SPECIAL_CHARS);

$query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
$PAD_ID = filter_input(INPUT_GET, 'PAD_ID', FILTER_SANITIZE_SPECIAL_CHARS);

$Today_DATE = date("d-M-Y");
$Today_DATES = date("l jS \of F Y");
$Today_TIME = date("h:i:s");
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | PAD</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <style>
        .label-purple {
            background-color: #8e44ad;
        }
        .clockpicker-popover {
            z-index: 999999;
        }
        .ui-datepicker{ z-index:1151 !important; }
    </style>
</head>
<body>
    <?php
    require_once(__DIR__ . '/../../includes/navbar.php');
    ?>
    <br>         

    <div class="container">

        <ul class="nav nav-pills">

            <li class="active"><a data-toggle="pill" href="#OVERVIEW">Overview</a></li>
            <li><a data-toggle="pill" href="#POD1">POD 1 </a></li>
            <li><a data-toggle="pill" href="#POD2">POD 2</a></li>
            <li><a data-toggle="pill" href="#POD3">POD 3</a></li>
            <li><a data-toggle="pill" href="#POD4">POD 4</a></li>
            <li><a data-toggle="pill" href="#POD5">POD 5</a></li>
            <li><a data-toggle="pill" href="#POD6">POD 6</a></li>
            <li><a data-toggle="pill" href="#TRAINING">Training</a></li>
            <li><a data-toggle="pill" href="#CLOSERS">Closers</a></li>
            <li><a data-toggle="pill" href="#ADMIN">Admin</a></li>
            <li><a data-toggle="pill" href="#YES">2017-04-07</a></li>
        </ul>       

        <div class="tab-content">
            <div id="OVERVIEW" class="tab-pane fade in active">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Pad Statistics</h3>
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
                                    ?>">
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-xs-2">
                                    <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-search"></span></button>
                                </div>
                            </div>

                            </fieldset>
                        </form><br><br>
                        <div class="col-md-12">

                            <div class="col-md-4">
                                <?php
                                if (isset($datefrom)) {
                                    $stmt = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    DATE(pad_statistics_added_date)=:date");
                                    $stmt->bindParam(':date', $datefrom, PDO::PARAM_STR);
$stmt->execute();
                                $data2 = $stmt->fetch(PDO::FETCH_ASSOC);

                                    $stmt_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    DATE(pad_statistics_added_date) =:date
GROUP BY pad_statistics_status");
                                    $stmt_status->bindParam(':date', $datefrom, PDO::PARAM_STR);
                                     $stmt_status->execute();
                                } else {

                                    $stmt = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE()");
                                     $stmt->execute();
                                $data2 = $stmt->fetch(PDO::FETCH_ASSOC);


                                    $stmt_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE()
GROUP BY pad_statistics_status");
                                    $stmt_status->execute();
                                }

                                
                                while ($data3 = $stmt_status->fetch(PDO::FETCH_ASSOC)) {
                                    ?> 
                                    <?php echo $data3['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data3['status_count'];
                                }

                                $TOTAL_COMM_ALL = number_format($data2['COMM'], 2);
                                ?>
                                Total: <?php echo "£$TOTAL_COMM_ALL"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

<?php echo "<h3>$Today_DATES</h3>"; ?>
<?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <button data-toggle="collapse" data-target="#DocsArrived" class="btn btn-default">Team Statistics<br>SHOW/HIDE</button>
                            </div>


                            <div id="DocsArrived" class="collapse">

<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {
echo "SMMOOSH $datefrom";
        require_once(__DIR__ . '/../models/pad/OVERVIEW/OverviewsPAD.php');
        $TeamPad = new TeamPadModal($pdo);
        $TeamPadList = $TeamPad->getTeamPad($datefrom);
        require_once(__DIR__ . '/../views/pad/OVERVIEW/Overviews-PAD.php');
    }
} if (!isset($datefrom))  {
    $Team_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE pad_statistics_added_date>=CURDATE()");
    $Team_PAD_CK->execute();
    if ($Team_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/OVERVIEW/OverviewsPAD.php');
        $TeamPad = new TeamPadModal($pdo);
        $TeamPadList = $TeamPad->getTeamPad();
        require_once(__DIR__ . '/../views/pad/OVERVIEW/Overviews-PAD.php');
    }
}
?>     

                            </div>
                        </div>
                        <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Overview</span>
                                <form method="post" action="../php/Pad.php?query=add">
                                    <table id="pad" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Lead</th>
                                                <th>COMM</th>
                                                <th>Closer</th>
                                                <th>Notes</th>
                                                <th>Team</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <td><input size="12" class="form-control" type="text" name="lead" id="provider-json"></td>                      
                                        <td><input size="12" class="form-control" type="text" name="col"></td>
                                        <td><input size="12" class="form-control" type="text" name="closer"></td>
                                        <td><input type="text" class="form-control" name="notes"></td>
                                        <td> <select name="group" class="form-control" required>
                                                <option value="">Select Team</option>
                                                <option value="POD 1">POD 1</option>
                                                <option value="POD 2">POD 2</option>
                                                <option value="POD 3">POD 3</option>
                                                <option value="POD 4">POD 4</option>
                                                <option value="POD 5">POD 5</option>
                                                <option value="POD 6">POD 6</option>
                                                <option value="Training">Training</option>
                                                <option value="Closers">Closers</option>
                                                <option value="Admin">Admin</option>
                                            </select></td>
                                        <td> <select name="status" class="form-control" required>
                                                <option value="">Select Status</option>
                                                <option value="White">White</option>
                                                <option value="Green" style="background:green">Green</option>
                                                <option value="Red" style="background:red" background:red>Red</option>
                                            </select></td>
                                        <td><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> SAVE</button></td>
                                    </table>
                                </form>

<?php
if (isset($datefrom)) {
    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/AllTodayPAD.php');
        $TodayPad = new TodayPadModal($pdo);
        $TodayPadList = $TodayPad->getTodayPad($datefrom);
        require_once(__DIR__ . '/../views/pad/AllToday-PAD.php');
    }
} else {
    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE pad_statistics_added_date>=CURDATE()");
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/AllTodayPAD.php');
        $TodayPad = new TodayPadModal($pdo);
        $TodayPadList = $TodayPad->getTodayPad();
        require_once(__DIR__ . '/../views/pad/AllToday-PAD.php');
    }
}
?>           

                            </div>
                        </div>
                    </div>

                </div>

            </div><!--END OVERVIEW-->

            <div id="POD1" class="tab-pane fade in"> <!-- POD 1 -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">POD 1 Statistics</h3>
                    </div>
                    <div class="panel-body">

                        <div class="col-md-12">

                            <div class="col-md-4">
<?php
$stmt_ONE_COM = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 1'");
$stmt_ONE_COM->execute();
$data_ONE_COM = $stmt_ONE_COM->fetch(PDO::FETCH_ASSOC);

$stmt_ONE_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 1'
GROUP BY pad_statistics_status");
$stmt_ONE_status->execute();
while ($data_ONE_status = $stmt_ONE_status->fetch(PDO::FETCH_ASSOC)) {
    ?> 
                                    <?php echo $data_ONE_status['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data_ONE_status['status_count'];
                                }

                                $ONE_COMM_ALL = number_format($data_ONE_COM['COMM'], 2);
                                ?>
                                Total: <?php echo "£$ONE_COMM_ALL"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

<?php echo "<h3>$Today_DATES</h3>"; ?>
<?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th>POD 1 Statistics</th>
                                </tr>
                                <tr>
                                    <th>Team</th>
                                    <th>AVG</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
<?php
if (isset($datefrom)) {
    $TEAM = 'POD 1';
    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date) =:date AND pad_statistics_group='POD 1'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD1/TeamPAD.php');
        $TeamPad = new POD1TeamPadModal($pdo);
        $TeamPadList = $TeamPad->POD1getTeamPad($datefrom, $TEAM);
        require_once(__DIR__ . '/../views/pad/Team-PAD.php');
    }
} else {
    $TEAM = 'POD 1';
    $Team_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date) >=CURDATE() AND pad_statistics_group='POD 1'");
    $Team_PAD_CK->execute();
    if ($Team_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD1/TeamPAD.php');
        $TeamPad = new POD1TeamPadModal($pdo);
        $TeamPadList = $TeamPad->POD1getTeamPad($TEAM);
        require_once(__DIR__ . '/../views/pad/Team-PAD.php');
    }
}
?>     
                        </table>

                        <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>
                                <form method="post" action="../php/Pad.php?query=add">
                                    <table id="pad" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Lead</th>
                                                <th>COMM</th>
                                                <th>Closer</th>
                                                <th>Notes</th>
                                                <th>Team</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <td><input size="12" class="form-control" type="text" name="lead" id="provider-json"></td>                      
                                        <td><input size="12" class="form-control" type="text" name="col"></td>
                                        <td><input size="12" class="form-control" type="text" name="closer"></td>
                                        <td><input type="text" class="form-control" name="notes"></td>
                                        <td> <select name="group" class="form-control" required>
                                                <option value="">Select Team</option>
                                                <option value="POD 1">POD 1</option>
                                                <option value="POD 2">POD 2</option>
                                                <option value="POD 3">POD 3</option>
                                                <option value="POD 4">POD 4</option>
                                                <option value="POD 5">POD 5</option>
                                                <option value="POD 6">POD 6</option>
                                                <option value="Training">Training</option>
                                                <option value="Closers">Closers</option>
                                                <option value="Admin">Admin</option>
                                            </select></td>
                                        <td> <select name="status" class="form-control" required>
                                                <option value="">Select Status</option>
                                                <option value="White">White</option>
                                                <option value="Green" style="background:green">Green</option>
                                                <option value="Red" style="background:red" background:red>Red</option>
                                            </select></td>
                                        <td><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> SAVE</button></td>
                                    </table>
                                </form>

<?php
if (isset($datefrom)) {
    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='POD 1'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD1/TodayPAD.php');
        $TodayPad = new POD1TodayPadModal($pdo);
        $TodayPadList = $TodayPad->POD1getTodayPad($datefrom);
        require_once(__DIR__ . '/../views/pad/Today-PAD.php');
    }
} else {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE pad_statistics_added_date>=CURDATE() AND pad_statistics_group='POD 1'");
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD1/TodayPAD.php');
        $TodayPad = new POD1TodayPadModal($pdo);
        $TodayPadList = $TodayPad->POD1getTodayPad();
        require_once(__DIR__ . '/../views/pad/Today-PAD.php');
    }
}
?>           

                            </div>
                        </div>
                    </div>

                </div>
            </div>    <!-- END POD1 -->              

            <div id="POD2" class="tab-pane fade in"> <!-- POD 2 -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">POD 2 Statistics</h3>
                    </div>
                    <div class="panel-body">

                        <div class="col-md-12">

                            <div class="col-md-4">
<?php
$stmt_TWO_COM = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 2'");
$stmt_TWO_COM->execute();
$data_TWO_COM = $stmt_TWO_COM->fetch(PDO::FETCH_ASSOC);

$stmt_TWO_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 2'
GROUP BY pad_statistics_status");
$stmt_TWO_status->execute();
while ($data_TWO_status = $stmt_TWO_status->fetch(PDO::FETCH_ASSOC)) {
    ?> 
                                    <?php echo $data_TWO_status['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data_TWO_status['status_count'];
                                }

                                $TWO_COMM_ALL = number_format($data_TWO_COM['COMM'], 2);
                                ?>
                                Total: <?php echo "£$TWO_COMM_ALL"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

<?php echo "<h3>$Today_DATES</h3>"; ?>
<?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th>POD 2 Statistics</th>
                                </tr>
                                <tr>
                                    <th>Team</th>
                                    <th>AVG</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='POD 2'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD2/TeamPAD.php');
        $POD2TeamPad = new POD2TeamPadModal($pdo);
        $POD2TeamPadList = $POD2TeamPad->POD2getTeamPad($datefrom);
        require_once(__DIR__ . '/../views/pad/POD2/Team-PAD.php');
    }
} else {

    $Team_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)>=CURDATE() AND pad_statistics_group='POD 2'");
    $Team_PAD_CK->execute();
    if ($Team_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD2/TeamPAD.php');
        $POD2TeamPad = new POD2TeamPadModal($pdo);
        $POD2TeamPadList = $POD2TeamPad->POD2getTeamPad();
        require_once(__DIR__ . '/../views/pad/POD2/Team-PAD.php');
    }
}
?>     
                        </table>


                        <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>

<?php
if (isset($datefrom)) {
    $TEAM = "POD 2";
    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='POD 2'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD2/TodayPAD.php');
        $POD2TodayPad = new POD2TodayPadModal($pdo);
        $POD2TodayPadList = $POD2TodayPad->POD2getTodayPad($datefrom, $TEAM);
        require_once(__DIR__ . '/../views/pad/POD2/Today-PAD.php');
    }
} else {
    $TEAM = "POD 2";
    $TODAY_PAD_CK = $pdo->prepare("SELECT 
    pad_statistics_id
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE()
        AND pad_statistics_group = 'POD 2'");
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD2/TodayPAD.php');
        $POD2TodayPad = new POD2TodayPadModal($pdo);
        $POD2TodayPadList = $POD2TodayPad->POD2getTodayPad($TEAM);
        require_once(__DIR__ . '/../views/pad/POD2/Today-PAD.php');
    }
}
?>           

                            </div>
                        </div>
                    </div>

                </div>
            </div>    <!-- END POD2 -->              

            <div id="POD3" class="tab-pane fade in"> <!-- POD 3 -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">POD 3 Statistics</h3>
                    </div>
                    <div class="panel-body">

                        <div class="col-md-12">

                            <div class="col-md-4">
<?php
$stmt_THREE_COM = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 3'");
$stmt_THREE_COM->execute();
$data_THREE_COM = $stmt_THREE_COM->fetch(PDO::FETCH_ASSOC);

$stmt_THREE_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 3'
GROUP BY pad_statistics_status");
$stmt_THREE_status->execute();
while ($data_THREE_status = $stmt_THREE_status->fetch(PDO::FETCH_ASSOC)) {
    ?> 
                                    <?php echo $data_THREE_status['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data_THREE_status['status_count'];
                                }

                                $THREE_COMM_ALL = number_format($data_THREE_COM['COMM'], 3);
                                ?>
                                Total: <?php echo "£$THREE_COMM_ALL"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

<?php echo "<h3>$Today_DATES</h3>"; ?>
<?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th>POD 3 Statistics</th>
                                </tr>
                                <tr>
                                    <th>Team</th>
                                    <th>AVG</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='POD 3'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD3/TeamPAD.php');
        $POD3TeamPad = new POD3TeamPadModal($pdo);
        $POD3TeamPadList = $POD3TeamPad->POD3getTeamPad($datefrom);
        require_once(__DIR__ . '/../views/pad/POD3/Team-PAD.php');
    }
} else {

    $Team_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)>=CURDATE() AND pad_statistics_group='POD 3'");
    $Team_PAD_CK->execute();
    if ($Team_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD3/TeamPAD.php');
        $POD3TeamPad = new POD3TeamPadModal($pdo);
        $POD3TeamPadList = $POD3TeamPad->POD3getTeamPad();
        require_once(__DIR__ . '/../views/pad/POD3/Team-PAD.php');
    }
}
?>     
                        </table>


                        <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>

<?php
if (isset($datefrom)) {
    $TEAM = "POD 3";
    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='POD 3'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD3/TodayPAD.php');
        $POD3TodayPad = new POD3TodayPadModal($pdo);
        $POD3TodayPadList = $POD3TodayPad->POD3getTodayPad($datefrom, $TEAM);
        require_once(__DIR__ . '/../views/pad/POD3/Today-PAD.php');
    }
} else {
    $TEAM = "POD 3";
    $TODAY_PAD_CK = $pdo->prepare("SELECT 
    pad_statistics_id
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE()
        AND pad_statistics_group = 'POD 3'");
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD3/TodayPAD.php');
        $POD3TodayPad = new POD3TodayPadModal($pdo);
        $POD3TodayPadList = $POD3TodayPad->POD3getTodayPad($TEAM);
        require_once(__DIR__ . '/../views/pad/POD3/Today-PAD.php');
    }
}
?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>    <!-- END POD3 -->

            <div id="POD4" class="tab-pane fade in"> <!-- POD 4 -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">POD 4 Statistics</h3>
                    </div>
                    <div class="panel-body">

                        <div class="col-md-12">

                            <div class="col-md-4">
<?php
$stmt_FOUR_COM = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 4'");
$stmt_FOUR_COM->execute();
$data_FOUR_COM = $stmt_FOUR_COM->fetch(PDO::FETCH_ASSOC);

$stmt_FOUR_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 4'
GROUP BY pad_statistics_status");
$stmt_FOUR_status->execute();
while ($data_FOUR_status = $stmt_FOUR_status->fetch(PDO::FETCH_ASSOC)) {
    ?> 
                                    <?php echo $data_FOUR_status['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data_FOUR_status['status_count'];
                                }

                                $FOUR_COMM_ALL = number_format($data_FOUR_COM['COMM'], 4);
                                ?>
                                Total: <?php echo "£$FOUR_COMM_ALL"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

<?php echo "<h3>$Today_DATES</h3>"; ?>
<?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th>POD 4 Statistics</th>
                                </tr>
                                <tr>
                                    <th>Team</th>
                                    <th>AVG</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='POD 4'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD4/TeamPAD.php');
        $POD4TeamPad = new POD4TeamPadModal($pdo);
        $POD4TeamPadList = $POD4TeamPad->POD4getTeamPad($datefrom);
        require_once(__DIR__ . '/../views/pad/POD4/Team-PAD.php');
    }
} else {

    $Team_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)>=CURDATE() AND pad_statistics_group='POD 4'");
    $Team_PAD_CK->execute();
    if ($Team_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD4/TeamPAD.php');
        $POD4TeamPad = new POD4TeamPadModal($pdo);
        $POD4TeamPadList = $POD4TeamPad->POD4getTeamPad();
        require_once(__DIR__ . '/../views/pad/POD4/Team-PAD.php');
    }
}
?>     
                        </table>


                        <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>

<?php
if (isset($datefrom)) {
    $TEAM = "POD 4";
    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='POD 4'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD4/TodayPAD.php');
        $POD4TodayPad = new POD4TodayPadModal($pdo);
        $POD4TodayPadList = $POD4TodayPad->POD4getTodayPad($datefrom, $TEAM);
        require_once(__DIR__ . '/../views/pad/POD4/Today-PAD.php');
    }
} else {
    $TEAM = "POD 4";
    $TODAY_PAD_CK = $pdo->prepare("SELECT 
    pad_statistics_id
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE()
        AND pad_statistics_group = 'POD 4'");
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD4/TodayPAD.php');
        $POD4TodayPad = new POD4TodayPadModal($pdo);
        $POD4TodayPadList = $POD4TodayPad->POD4getTodayPad($TEAM);
        require_once(__DIR__ . '/../views/pad/POD4/Today-PAD.php');
    }
}
?>   

                            </div>
                        </div>
                    </div>

                </div>
            </div>    <!-- END POD4 -->  

            <div id="POD5" class="tab-pane fade in"> <!-- POD 5 -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">POD 5 Statistics</h3>
                    </div>
                    <div class="panel-body">

                        <div class="col-md-12">

                            <div class="col-md-4">
<?php
$stmt_FIVE_COM = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 5'");
$stmt_FIVE_COM->execute();
$data_FIVE_COM = $stmt_FIVE_COM->fetch(PDO::FETCH_ASSOC);

$stmt_FIVE_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 5'
GROUP BY pad_statistics_status");
$stmt_FIVE_status->execute();
while ($data_FIVE_status = $stmt_FIVE_status->fetch(PDO::FETCH_ASSOC)) {
    ?> 
                                    <?php echo $data_FIVE_status['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data_FIVE_status['status_count'];
                                }

                                $FIVE_COMM_ALL = number_format($data_FIVE_COM['COMM'], 5);
                                ?>
                                Total: <?php echo "£$FIVE_COMM_ALL"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

<?php echo "<h3>$Today_DATES</h3>"; ?>
<?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th>POD 5 Statistics</th>
                                </tr>
                                <tr>
                                    <th>Team</th>
                                    <th>AVG</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='POD 5'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD5/TeamPAD.php');
        $POD5TeamPad = new POD5TeamPadModal($pdo);
        $POD5TeamPadList = $POD5TeamPad->POD5getTeamPad($datefrom);
        require_once(__DIR__ . '/../views/pad/POD5/Team-PAD.php');
    }
} else {

    $Team_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)>=CURDATE() AND pad_statistics_group='POD 5'");
    $Team_PAD_CK->execute();
    if ($Team_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD5/TeamPAD.php');
        $POD5TeamPad = new POD5TeamPadModal($pdo);
        $POD5TeamPadList = $POD5TeamPad->POD5getTeamPad();
        require_once(__DIR__ . '/../views/pad/POD5/Team-PAD.php');
    }
}
?>     
                        </table>


                        <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>

<?php
if (isset($datefrom)) {
    $TEAM = "POD 5";
    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='POD 5'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD5/TodayPAD.php');
        $POD5TodayPad = new POD5TodayPadModal($pdo);
        $POD5TodayPadList = $POD5TodayPad->POD5getTodayPad($datefrom, $TEAM);
        require_once(__DIR__ . '/../views/pad/POD5/Today-PAD.php');
    }
} else {
    $TEAM = "POD 5";
    $TODAY_PAD_CK = $pdo->prepare("SELECT 
    pad_statistics_id
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE()
        AND pad_statistics_group = 'POD 5'");
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD5/TodayPAD.php');
        $POD5TodayPad = new POD5TodayPadModal($pdo);
        $POD5TodayPadList = $POD5TodayPad->POD5getTodayPad($TEAM);
        require_once(__DIR__ . '/../views/pad/POD5/Today-PAD.php');
    }
}
?>           

                            </div>
                        </div>
                    </div>

                </div>
            </div>    <!-- END POD5 -->                  

            <div id="POD6" class="tab-pane fade in"> <!-- POD 6 -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">POD 6 Statistics</h3>
                    </div>
                    <div class="panel-body">

                        <div class="col-md-12">

                            <div class="col-md-4">
<?php
$stmt_SIX_COM = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 6'");
$stmt_SIX_COM->execute();
$data_SIX_COM = $stmt_SIX_COM->fetch(PDO::FETCH_ASSOC);

$stmt_SIX_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 6'
GROUP BY pad_statistics_status");
$stmt_SIX_status->execute();
while ($data_SIX_status = $stmt_SIX_status->fetch(PDO::FETCH_ASSOC)) {
    ?> 
                                    <?php echo $data_SIX_status['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data_SIX_status['status_count'];
                                }

                                $SIX_COMM_ALL = number_format($data_SIX_COM['COMM'], 6);
                                ?>
                                Total: <?php echo "£$SIX_COMM_ALL"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

<?php echo "<h3>$Today_DATES</h3>"; ?>
<?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th>POD 6 Statistics</th>
                                </tr>
                                <tr>
                                    <th>Team</th>
                                    <th>AVG</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='POD 6'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD6/TeamPAD.php');
        $POD6TeamPad = new POD6TeamPadModal($pdo);
        $POD6TeamPadList = $POD6TeamPad->POD6getTeamPad($datefrom);
        require_once(__DIR__ . '/../views/pad/POD6/Team-PAD.php');
    }
} else {

    $Team_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)>=CURDATE() AND pad_statistics_group='POD 6'");
    $Team_PAD_CK->execute();
    if ($Team_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD6/TeamPAD.php');
        $POD6TeamPad = new POD6TeamPadModal($pdo);
        $POD6TeamPadList = $POD6TeamPad->POD6getTeamPad();
        require_once(__DIR__ . '/../views/pad/POD6/Team-PAD.php');
    }
}
?>     
                        </table>


                        <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>

<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='POD 6'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD6/TodayPAD.php');
        $POD6TodayPad = new POD6TodayPadModal($pdo);
        $POD6TodayPadList = $POD6TodayPad->POD6getTodayPad($datefrom);
        require_once(__DIR__ . '/../views/pad/POD6/Today-PAD.php');
    }
} else {
    $TEAM = "POD 6";
    $TODAY_PAD_CK = $pdo->prepare("SELECT 
    pad_statistics_id
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE()
        AND pad_statistics_group = 'POD 6'");
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/POD6/TodayPAD.php');
        $POD6TodayPad = new POD6TodayPadModal($pdo);
        $POD6TodayPadList = $POD6TodayPad->POD6getTodayPad();
        require_once(__DIR__ . '/../views/pad/POD6/Today-PAD.php');
    }
}
?>           

                            </div>
                        </div>
                    </div>

                </div>
            </div>    <!-- END POD6 --> 

            <div id="TRAINING" class="tab-pane fade in"> <!-- Training -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Training Statistics</h3>
                    </div>
                    <div class="panel-body">

                        <div class="col-md-12">

                            <div class="col-md-4">
<?php
$stmt_TRAIN_COM = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='Training'");
$stmt_TRAIN_COM->execute();
$data_TRAIN_COM = $stmt_TRAIN_COM->fetch(PDO::FETCH_ASSOC);

$stmt_TRAIN_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='Training'
GROUP BY pad_statistics_status");
$stmt_TRAIN_status->execute();
while ($data_TRAIN_status = $stmt_TRAIN_status->fetch(PDO::FETCH_ASSOC)) {
    ?> 
                                    <?php echo $data_TRAIN_status['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data_TRAIN_status['status_count'];
                                }

                                $TRAIN_COMM_ALL = number_format($data_TRAIN_COM['COMM'], 6);
                                ?>
                                Total: <?php echo "£$TRAIN_COMM_ALL"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

<?php echo "<h3>$Today_DATES</h3>"; ?>
<?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Training Statistics</th>
                                </tr>
                                <tr>
                                    <th>Team</th>
                                    <th>AVG</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='Training'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/TRAINING/TeamPAD.php');
        $TRAININGTeamPad = new TRAININGTeamPadModal($pdo);
        $TRAININGTeamPadList = $TRAININGTeamPad->TRAININGgetTeamPad($datefrom);
        require_once(__DIR__ . '/../views/pad/TRAINING/Team-PAD.php');
    }
} else {

    $Team_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)>=CURDATE() AND pad_statistics_group='Training'");
    $Team_PAD_CK->execute();
    if ($Team_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/TRAINING/TeamPAD.php');
        $TRAININGTeamPad = new TRAININGTeamPadModal($pdo);
        $TRAININGTeamPadList = $TRAININGTeamPad->TRAININGgetTeamPad();
        require_once(__DIR__ . '/../views/pad/TRAINING/Team-PAD.php');
    }
}
?>     
                        </table>


                        <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>

<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='Training'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/TRAINING/TodayPAD.php');
        $TRAININGTodayPad = new TRAININGTodayPadModal($pdo);
        $TRAININGTodayPadList = $TRAININGTodayPad->TRAININGgetTodayPad($datefrom);
        require_once(__DIR__ . '/../views/pad/TRAINING/Today-PAD.php');
    }
} else {

    $TODAY_PAD_CK = $pdo->prepare("SELECT 
    pad_statistics_id
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE()
        AND pad_statistics_group = 'Training'");
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/TRAINING/TodayPAD.php');
        $TRAININGTodayPad = new TRAININGTodayPadModal($pdo);
        $TRAININGTodayPadList = $TRAININGTodayPad->TRAININGgetTodayPad();
        require_once(__DIR__ . '/../views/pad/TRAINING/Today-PAD.php');
    }
}
?>      
                            </div>
                        </div>
                    </div>

                </div>
            </div>    <!-- END Training -->             

            <div id="CLOSERS" class="tab-pane fade in"> <!-- CLOSER TEAM -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Closer Statistics</h3>
                    </div>
                    <div class="panel-body">

                        <div class="col-md-12">

                            <div class="col-md-4">
<?php
$stmt_CLO_COM = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='Closers'");
$stmt_CLO_COM->execute();
$data_CLO_COM = $stmt_CLO_COM->fetch(PDO::FETCH_ASSOC);

$stmt_CLO_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='Closers'
GROUP BY pad_statistics_status");
$stmt_CLO_status->execute();
while ($data_CLO_status = $stmt_CLO_status->fetch(PDO::FETCH_ASSOC)) {
    ?> 
                                    <?php echo $data_CLO_status['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data_CLO_status['status_count'];
                                }

                                $CLO_COMM_ALL = number_format($data_CLO_COM['COMM'], 6);
                                ?>
                                Total: <?php echo "£$CLO_COMM_ALL"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

<?php echo "<h3>$Today_DATES</h3>"; ?>
<?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Closer Statistics</th>
                                </tr>
                                <tr>
                                    <th>Team</th>
                                    <th>AVG</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='Closers'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/CLOSER/TeamPAD.php');
        $CLOSERTeamPad = new CLOSERTeamPadModal($pdo);
        $CLOSERTeamPadList = $CLOSERTeamPad->CLOSERgetTeamPad($datefrom);
        require_once(__DIR__ . '/../views/pad/CLOSER/Team-PAD.php');
    }
} else {

    $Team_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)>=CURDATE() AND pad_statistics_group='Closers'");
    $Team_PAD_CK->execute();
    if ($Team_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/CLOSER/TeamPAD.php');
        $CLOSERTeamPad = new CLOSERTeamPadModal($pdo);
        $CLOSERTeamPadList = $CLOSERTeamPad->CLOSERgetTeamPad();
        require_once(__DIR__ . '/../views/pad/CLOSER/Team-PAD.php');
    }
}
?>     
                        </table>


                        <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>

<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='Closers'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/CLOSER/TodayPAD.php');
        $CLOSERTodayPad = new CLOSERTodayPadModal($pdo);
        $CLOSERTodayPadList = $CLOSERTodayPad->CLOSERgetTodayPad($datefrom);
        require_once(__DIR__ . '/../views/pad/CLOSER/Today-PAD.php');
    }
} else {
    $TEAM = "Closer";
    $TODAY_PAD_CK = $pdo->prepare("SELECT 
    pad_statistics_id
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE()
        AND pad_statistics_group = 'Closers'");
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/CLOSER/TodayPAD.php');
        $CLOSERTodayPad = new CLOSERTodayPadModal($pdo);
        $CLOSERTodayPadList = $CLOSERTodayPad->CLOSERgetTodayPad();
        require_once(__DIR__ . '/../views/pad/CLOSER/Today-PAD.php');
    }
}
?>       

                            </div>
                        </div>
                    </div>

                </div>
            </div>            <!-- END OF CLOSERS -->

            <div id="ADMIN" class="tab-pane fade in">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Admin Statistics</h3>
                    </div>
                    <div class="panel-body">

                        <div class="col-md-12">

                            <div class="col-md-4">
<?php
$stmt_ADM_COM = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='Admin'");
$stmt_ADM_COM->execute();
$data_ADM_COM = $stmt_ADM_COM->fetch(PDO::FETCH_ASSOC);

$stmt_ADM_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='Admin'
GROUP BY pad_statistics_status");
$stmt_ADM_status->execute();
while ($data_ADM_status = $stmt_ADM_status->fetch(PDO::FETCH_ASSOC)) {
    ?> 
                                    <?php echo $data_ADM_status['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data_ADM_status['status_count'];
                                }

                                $ADM_COMM_ALL = number_format($data_ADM_COM['COMM'], 6);
                                ?>
                                Total: <?php echo "£$ADM_COMM_ALL"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

<?php echo "<h3>$Today_DATES</h3>"; ?>
<?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>

                        <table  class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Admin Statistics</th>
                                </tr>
                                <tr>
                                    <th>Team</th>
                                    <th>AVG</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='Admin'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/ADMIN/TeamPAD.php');
        $ADMINTeamPad = new ADMINTeamPadModal($pdo);
        $ADMINTeamPadList = $ADMINTeamPad->ADMINgetTeamPad($datefrom);
        require_once(__DIR__ . '/../views/pad/ADMIN/Team-PAD.php');
    }
} else {

    $Team_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)>=CURDATE() AND pad_statistics_group='Admin'");
    $Team_PAD_CK->execute();
    if ($Team_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/ADMIN/TeamPAD.php');
        $ADMINTeamPad = new ADMINTeamPadModal($pdo);
        $ADMINTeamPadList = $ADMINTeamPad->ADMINgetTeamPad();
        require_once(__DIR__ . '/../views/pad/ADMIN/Team-PAD.php');
    }
}
?>     
                        </table>


                        <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>

<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date AND pad_statistics_group='Admin'");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/ADMIN/TodayPAD.php');
        $ADMINTodayPad = new ADMINTodayPadModal($pdo);
        $ADMINTodayPadList = $ADMINTodayPad->ADMINgetTodayPad($datefrom);
        require_once(__DIR__ . '/../views/pad/ADMIN/Today-PAD.php');
    }
} else {

    $TODAY_PAD_CK = $pdo->prepare("SELECT 
    pad_statistics_id
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE()
        AND pad_statistics_group = 'Admin'");
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/ADMIN/TodayPAD.php');
        $ADMINTodayPad = new ADMINTodayPadModal($pdo);
        $ADMINTodayPadList = $ADMINTodayPad->ADMINgetTodayPad();
        require_once(__DIR__ . '/../views/pad/ADMIN/Today-PAD.php');
    }
}
?>  
                            </div>
                        </div>
                    </div>

                </div>
            </div>    <!-- END ADMIN -->


            <div id="YES" class="tab-pane fade in">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">2017-04-07 Statistics</h3>
                    </div>
                    <div class="panel-body">

                        <div class="col-md-12">

                            <div class="col-md-4">
<?php
$stmt_YES_COM = $pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM
FROM
    pad_statistics
WHERE
    DATE(pad_statistics_added_date) ='2017-04-07'");
$stmt_YES_COM->execute();
$data_YES_COM = $stmt_YES_COM->fetch(PDO::FETCH_ASSOC);

$stmt_YES_status = $pdo->prepare("SELECT 
    COUNT(pad_statistics_status) AS status_count,
    pad_statistics_status
FROM
    pad_statistics
WHERE
    DATE(pad_statistics_added_date) ='2017-04-07'
GROUP BY pad_statistics_status");
$stmt_YES_status->execute();
while ($data_YES_status = $stmt_YES_status->fetch(PDO::FETCH_ASSOC)) {
    ?> 
                                    <?php echo $data_YES_status['pad_statistics_status']; ?> 
                                    <?php
                                    echo $data_YES_status['status_count'];
                                }

                                $YES_COMM_ALL = number_format($data_YES_COM['COMM'], 6);
                                ?>
                                Total: <?php echo "£$YES_COMM_ALL"; ?>

                            </div>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">

<?php echo "<h3>2017-04-07</h3>"; ?>
<?php echo "<h4>$Today_TIME</h4>"; ?>

                            </div>

                        </div>


                        <div class="row">
                            <div class="list-group">
                                <span class="label label-primary">Pad</span>

<?php
if (isset($datefrom)) {

    $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics WHERE DATE(pad_statistics_added_date)=:date");
    $TODAY_PAD_CK->bindParam(':date', $datefrom, PDO::PARAM_STR);
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/YesterdayPAD.php');
        $Yesterday_Pad = new YesterdayPadModal($pdo);
        $YesterdayPadList = $Yesterday_Pad->getYesterdayPad($datefrom);
        require_once(__DIR__ . '/../views/pad/Yesterday-PAD.php');
    }
} else {

    $TODAY_PAD_CK = $pdo->prepare("SELECT 
    pad_statistics_id
FROM
    pad_statistics
WHERE
    DATE(pad_statistics_added_date) ='2017-04-07'
       ");
    $TODAY_PAD_CK->execute();
    if ($TODAY_PAD_CK->rowCount() > 0) {

        require_once(__DIR__ . '/../models/pad/YesterdayPAD.php');
        $Yesterday_Pad = new YesterdayPadModal($pdo);
        $YesterdayPadList = $Yesterday_Pad->getYesterdayPad();
        require_once(__DIR__ . '/../views/pad/Yesterday-PAD.php');
    }
}
?>  
                            </div>
                        </div>
                    </div>

                </div>
            </div>    <!-- END YES -->

        </div><!--END TAB CONTENT-->
    </div>
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
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
</body>
</html>