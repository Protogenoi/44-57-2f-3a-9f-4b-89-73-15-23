<?php
require_once(__DIR__ . '../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '../../../includes/adl_features.php');
require_once(__DIR__ . '../../../includes/Access_Levels.php');
require_once(__DIR__ . '../../../includes/adlfunctions.php');
require_once(__DIR__ . '../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /CRMmain.php');
    die;
}
?>
<!DOCTYPE html>
<html>
    <title>ADL | SMS Reports</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
        <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>

        <?php
        require_once(__DIR__ . '../../../includes/navbar.php');

        $SEARCH_BY = filter_input(INPUT_GET, 'SEARCH_BY', FILTER_SANITIZE_SPECIAL_CHARS);
        ?>

        <div class="container">

<?php
if ($companynamere = 'The Review Bureau' || $companynamere = 'ADL_CUS') {
    if ($ffsms == '1') {
        ?>

                    <form class="form-vertical" method="GET"  action="Report.php">
                        <fieldset>

                            <legend>SMS Response Check<i> (click row to view)</i></legend>


                            <div class="col-md-2">
                                <div class="form-group">
                                    <select id="SEARCH_BY" name="SEARCH_BY" class="form-control" onchange="this.form.submit()" >
                                        <option value="Sent" <?php
            if (isset($SEARCH_BY)) {
                if ($SEARCH_BY == 'Sent') {
                    echo "selected";
                } else {
                    echo "selected";
                }
            }
        ?> >Sent</option>
                                        <option value="Failed" <?php
                                                if (isset($SEARCH_BY)) {
                                                    if ($SEARCH_BY == 'Failed') {
                                                        echo "selected";
                                                    }
                                                }
                                                ?> >Failed</option>
                                        <option value="Responses" <?php
                                                if (isset($SEARCH_BY)) {
                                                    if ($SEARCH_BY == 'Responses') {
                                                        echo "selected";
                                                    }
                                                }
                                                ?> >Responses</option>
                                    </select>
                                </div>
                            </div>


                        </fieldset>
                    </form>
        <?php
        if (isset($SEARCH_BY)) {
            try {


                if ($SEARCH_BY == 'Sent') {

                    $SEARCH = $pdo->prepare("SELECT 
    client_id, message, date_sent, note_type
FROM
    client_note
WHERE
    note_type = 'SMS Delivered'");
                }

                if ($SEARCH_BY == 'Failed') {

                    $SEARCH = $pdo->prepare("SELECT 
    client_id, message, date_sent, note_type
FROM
    client_note
WHERE
        note_type = 'SMS Failed'");
                }

                if ($SEARCH_BY == 'Responses') {

                    $SEARCH = $pdo->prepare("SELECT 
    client_id, message, date_sent, note_type
FROM
    client_note
WHERE
    note_type = 'Client SMS Reply'");
                } 
                ?>        

                            <table id="clients" class="table table-striped table-hover" width="auto" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>SMS Response</th>
                                        <th>SMS Message</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>SMS Response</th>
                                        <th>Message</th>
                                    </tr>
                                </tfoot>

                <?php
                $SEARCH->execute();
                if ($SEARCH->rowCount() > 0) {
                    while ($result = $SEARCH->fetch(PDO::FETCH_ASSOC)) {


                        echo "<tr class='clickable-row' data-href='../ViewClient.php?search=" . $result['client_id'] . "#menu4'><td>" . $result['date_sent'] . "</td>";
                        echo "<td>" . $result['note_type'] . "</td>";
                        echo "<td>" . $result['message'] . "</td>";
                        echo "</tr>";
                    }
                } else {

                    echo "<div class='notice notice-info' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Info:</strong> No messages found for $SEARCH_BY<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";
                }
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
            ?>



                        </table>
                            <?php
                        }
                    }
                }
                ?>

        </div>

        <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
        <script type="text/javascript">
            $(document).ready(function () {
                $('#LOADING').modal('show');
            });
            $(window).load(function () {
                $('#LOADING').modal('hide');
            });
        </script>
        <script>
            jQuery(document).ready(function ($) {
                $(".clickable-row").click(function () {
                    window.location = $(this).data("href");
                });
            });
        </script>
        <div class="modal modal-static fade" id="LOADING" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <center><i class="fa fa-spinner fa-pulse fa-5x fa-lg"></i></center>
                            <br>
                            <h3>Searching SMS database... </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
