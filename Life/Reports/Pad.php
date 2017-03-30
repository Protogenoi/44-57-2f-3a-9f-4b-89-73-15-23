<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 6);
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
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$dateto = filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$datefrom = filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);

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
        
                        <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Pad Statistics</h3>
                    </div>
                    <div class="panel-body">
                        
                        
                        <form action=" " method="get">

                            <div class="form-group">
                                <div class="col-xs-2">
                                    <input type="text" id="datefrom" name="datefrom" placeholder="DATE FROM:" class="form-control" value="<?php if (isset($datefrom)) {
                            echo $datefrom;
                        } ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-2">
                                    <input type="text" id="dateto" name="dateto" class="form-control" placeholder="DATE TO:" value="<?php if (isset($dateto)) {
                                            echo $dateto;
                                        } ?>" required>
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

                <div class="col-md-4"></div>
                <div class="col-md-4"></div>

                <div class="col-md-4">

        <?php echo "<h3>$Today_DATES</h3>"; ?>
        <?php echo "<h4>$Today_TIME</h4>"; ?>

                </div>

            </div>
                        <div class="row">
                         <div class="list-group">
                <span class="label label-primary">Pad</span>
                <form method="post" action="<?php if (isset($query) && $query=='Edit') {
            echo '../php/Pad.php?query=edit';
        } else {
            echo '../php/Pad.php?query=add';
        } ?>">
                    <table id="pad" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Lead</th>
                                <th>BLANK</th>
                                <th>Closer</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>

        <?php
        if (isset($query) && $query=='Edit') {

            $PAD_EDIT = $pdo->prepare("SELECT pad_statistics_lead, pad_statistics_closer, pad_statistics_notes, pad_statistics_status, pad_statistics_col FROM pad_statistics WHERE pad_statistics_id=:id");
            $PAD_EDIT->bindParam(':id', $PAD_ID, PDO::PARAM_INT);
            $PAD_EDIT->execute();
            if ($PAD_EDIT->rowCount() > 0) {
                $PAD_EDIT_result = $PAD_EDIT->fetch(PDO::FETCH_ASSOC);

                $PAD_id = $PAD_EDIT_result['pad_statistics_id'];
                $PAD_lead = $PAD_EDIT_result['pad_statistics_lead'];
                $PAD_closer = $PAD_EDIT_result['pad_statistics_closer'];
                $PAD_notes = $PAD_EDIT_result['pad_statistics_notes'];
                $PAD_status = $PAD_EDIT_result['pad_statistics_status'];
                $PAD_our_col = $PAD_EDIT_result['pad_statistics_col'];
                ?>

                                <input type="hidden" value="<?php echo $PAD_id; ?>" name="pad_id">
                                <td><input size="12" class="form-control" type="text" name="lead" id="provider-json" value="<?php if (isset($PAD_lead)) {
                    echo $PAD_lead;
                } ?>"></td>                      
                                <td><input size="12" class="form-control" type="text" name="col" value="<?php if (isset($PAD_our_col)) {
                    echo $PAD_our_col;
                } ?>"></td>
                                <td><input size="12" class="form-control" type="text" name="closer" value="<?php if (isset($PAD_closer)) {
                    echo $PAD_closer;
                } ?>"></td>
                                <td><input size="8" class="form-control" type="text" name="notes" value="<?php if (isset($PAD_notes)) {
                    echo $PAD_notes;
                } ?>"></td>
                                <td><select name="status" class="form-control" required>
                                        <option>Select Status</option>
                                        <option <?php if (isset($PAD_status)) {
                    if ($PAD_status == 'Green') {
                        echo "selected";
                    }
                } ?> value="Green">Green</option>
                                        <option <?php if (isset($PAD_status)) {
                    if ($PAD_status == 'Red') {
                        echo "selected";
                    }
                } ?> value="Red">Red</option>
                                    
                                    </select></td>

                                <td><button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-save"></i> UPDATE</button></td> 
                                <td><a href="?query=CloserTrackers" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> CANCEL</a></td>

            <?php
            }
        } else {
            ?>
                            <td><input size="12" class="form-control" type="text" name="lead" id="provider-json"></td>                      
                            <td><input size="12" class="form-control" type="text" name="col"></td>
                            <td><input size="12" class="form-control" type="text" name="closer"></td>
                            <td><input type="text" class="form-control" name="notes"></td>
                            <td> <select name="status" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="Green">Green</option>
                                    <option value="Red">Red</option>
                                </select></td>
                            <td><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> SAVE</button></td>
        <?php } ?>

                    </table>
                </form>
   <?php      
   
                                $TODAY_PAD_CK = $pdo->prepare("SELECT pad_statistics_id from pad_statistics");
                                $TODAY_PAD_CK->execute();
                                if ($TODAY_PAD_CK->rowCount() > 0) {

                                    require_once(__DIR__ . '/../models/TodayPAD.php');
                                    $TodayPad = new TodayPadModal($pdo);
                                    $TodayPadList = $TodayPad->getTodayPad($search);
                                    require_once(__DIR__ . '/../views/Today-PAD.php');
                                }   ?>           
                        
                    </div>
                        </div>
                        </div>
        
    </div>
                <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
                <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
            <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 

</body>
</html>