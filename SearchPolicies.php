<?php
require_once(__DIR__ . '/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/includes/adl_features.php');
require_once(__DIR__ . '/includes/Access_Levels.php');
require_once(__DIR__ . '/includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($fflife == '0') {

    header('Location: /CRMmain.php');
    die;
}

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /CRMmain.php');
    die;
}
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html>
    <title>ADL | Search Policy</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
        <link rel="stylesheet" href="styles/layoutcrm.css" type="text/css" />
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/styles/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">
        <link rel="stylesheet" type="text/css" href="js/jquery-ui-1.11.4/jquery-ui.css">
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>

        <?php require_once(__DIR__ . '/includes/navbar.php'); ?>

        <div class="container">
            <div class="row">
                <div class="twelve columns">
                    <ul class="ca-menu">

                        <li>
                            <a href="SearchClients.php">
                                <span class="ca-icon"><i class="fa fa-search"></i></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Search<br/>Clients</h2>
                                    <h3 class="ca-sub"></h3>
                                </div>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <form action="" method="GET">
                <div class="form-group col-xs-3">
                    <label class="col-md-4 control-label" for="query"></label>
                    <select id="EXECUTE" name="EXECUTE" class="form-control" onchange="this.form.submit()" required>
                        <?php
                        if (isset($EXECUTE)) {
                            if ($EXECUTE == 'Life') {
                                ?> 
                                <option value="Life" selected>Search Life Policies</option>
                                <option value="Home">Search Home Policies</option>
                                <?php
                            }
                        }
                        ?>
                        <?php
                        if (isset($EXECUTE)) {
                            if ($EXECUTE == 'Home') {
                                ?> 
                                <option value="Life">Search Life Policies</option>
                                <option value="Home"selected >Search Home Policies</option>
                                <?php
                            }
                        }
                        ?>     
                        <?php if (empty($EXECUTE)) { ?>
                            <option value="">Select...</option>
                            <option value="Life">Search Life Policies</option>
                            <option value="Home">Search Home Policies</option>
                        <?php }
                        ?>   
                    </select>
                </div>
            </form>


            <?php
            if (isset($EXECUTE)) {
                if ($EXECUTE == 'Life') {
                    ?>

                    <table id="policy" class="display" width="auto" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Policy Holder</th>
                                <th>Holder</th>
                                <th>Policy</th>
                                <th>AN</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Add Policy</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Policy Holder</th>
                                <th>Holder</th>
                                <th>Policy</th>
                                <th>AN</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Add Policy</th>
                            </tr>
                        </tfoot>
                    </table>

                    <?php
                }

                if ($EXECUTE == 'Home') {
                    ?>

                    <table id="home" class="display" width="auto" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Sale Date</th>
                                <th>Client</th>
                                <th>Policy</th>
                                <th>Insurer</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Add Policy</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Sale Date</th>
                                <th>Client</th>
                                <th>Policy</th>
                                <th>Insurer</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Add Policy</th>
                            </tr>
                        </tfoot>
                    </table>

                    <?php
                }
            }
            ?>

        </div>

        <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="/js/datatables/jquery.DATATABLES.min.js"></script>
        <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
        <script type="text/javascript">
                        $(document).ready(function () {


                            $('#LOADING').modal('show');
                        })

                                ;

                        $(window).load(function () {
                            $('#LOADING').modal('hide');
                        });
        </script> 
        <div class="modal modal-static fade" id="LOADING" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <center><i class="fa fa-spinner fa-pulse fa-5x fa-lg"></i></center>
                            <br>
                            <h3>Populating client details... </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>  

        <?php
        if (isset($EXECUTE)) {
            if ($EXECUTE == 'Life') {
                ?>
                <script type="text/javascript" language="javascript" >
                    /* Formatting function for row details - modify as you need */
                    function format(d) {
                        // `d` is the original data object for the row
                        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                                '<tr>' +
                                '<td>Insurer:</td>' +
                                '<td>' + d.insurer + ' </td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Application Number:</td>' +
                                '<td>' + d.application_number + ' </td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Policy Type:</td>' +
                                '<td>' + d.type + ' </td>' +
                                '</tr>' +
                                '</table>';
                    }

                    $(document).ready(function () {
                        var table = $('#policy').DataTable({
                            "response": true,
                            "processing": true,
                            "iDisplayLength": 10,
                            "aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
                            "language": {
                                "processing": "<div></div><div></div><div></div><div></div><div></div>"

                            },
                            "ajax": "/datatables/getpolicy.php?EXECUTE=Life",
                            "columns": [
                                {
                                    "className": 'details-control',
                                    "orderable": false,
                                    "data": null,
                                    "defaultContent": ''
                                },
                                {"data": "sale_date"},
                                {"data": "client_name"},
                                {"data": "policy_number"},
                                {"data": "application_number"},
                                {"data": "PolicyStatus"},
                                {"data": "client_id",
                                    "render": function (data, type, full, meta) {
                                        return '<a href="/Life/ViewClient.php?search=' + data + '">View</a>';
                                    }},
                                {"data": "client_id",
                                    "render": function (data, type, full, meta) {
                                        return '<a href="Life/AddPolicy.php?EXECUTE=1&search=' + data + '">Add Policy</a>';
                                    }},
                            ],
                            "order": [[1, 'asc']]
                        });

                        // Add event listener for opening and closing details
                        $('#policy tbody').on('click', 'td.details-control', function () {
                            var tr = $(this).closest('tr');
                            var row = table.row(tr);

                            if (row.child.isShown()) {
                                // This row is already open - close it
                                row.child.hide();
                                tr.removeClass('shown');
                            } else {
                                // Open this row
                                row.child(format(row.data())).show();
                                tr.addClass('shown');
                            }
                        });
                    });
                </script>
                <?php
            }
            if ($EXECUTE == 'Home') {
                ?>
                <script type="text/javascript" language="javascript" >
                    /* Formatting function for row details - modify as you need */
                    function format(d) {
                        // `d` is the original data object for the row
                        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                                '<tr>' +
                                '<td>Insurer:</td>' +
                                '<td>' + d.insurer + ' </td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Application Number:</td>' +
                                '<td>' + d.application_number + ' </td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Policy Type:</td>' +
                                '<td>' + d.type + ' </td>' +
                                '</tr>' +
                                '</table>';
                    }

                    $(document).ready(function () {
                        var table = $('#home').DataTable({
                            "response": true,
                            "processing": true,
                            "iDisplayLength": 10,
                            "aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
                            "language": {
                                "processing": "<div></div><div></div><div></div><div></div><div></div>"

                            },
                            "ajax": "/datatables/getpolicy.php?EXECUTE=Home",
                            "columns": [
                                {
                                    "className": 'details-control',
                                    "orderable": false,
                                    "data": null,
                                    "defaultContent": ''
                                },
                                {"data": "added_date"},
                                {"data": "client_name"},
                                {"data": "policy_number"},
                                {"data": "insurer"},
                                {"data": "status"},
                                {"data": "client_id",
                                    "render": function (data, type, full, meta) {
                                        return '<a href="/Life/ViewClient.php?search=' + data + '">View</a>';
                                    }},
                                {"data": "client_id",
                                    "render": function (data, type, full, meta) {
                                        return '<a href="Home/AddPolicy.php?Home=y&CID=' + data + '">Add Policy</a>';
                                    }},
                            ],
                            "order": [[1, 'asc']]
                        });

                        // Add event listener for opening and closing details
                        $('#policy tbody').on('click', 'td.details-control', function () {
                            var tr = $(this).closest('tr');
                            var row = table.row(tr);

                            if (row.child.isShown()) {
                                // This row is already open - close it
                                row.child.hide();
                                tr.removeClass('shown');
                            } else {
                                // Open this row
                                row.child(format(row.data())).show();
                                tr.addClass('shown');
                            }
                        });
                    });
                </script>
                <?php
            }
        }
        ?>
    </body>
</html>
