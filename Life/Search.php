<?php
require_once(__DIR__ . '../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '../../includes/user_tracking.php'); 

require_once(__DIR__ . '../../includes/adl_features.php');
require_once(__DIR__ . '../../includes/Access_Levels.php');
require_once(__DIR__ . '../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}


if (in_array($hello_name, $Level_3_Access, true) || in_array($hello_name, $COM_MANAGER_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 


$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

    require_once(__DIR__ . '../../classes/database_class.php');
    require_once(__DIR__ . '../../class/login/login.php');

        $SELECT_USER_TOKEN = new UserActions($hello_name,"NoToken");
        $SELECT_USER_TOKEN->SelectToken();
        $OUT=$SELECT_USER_TOKEN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
?>
<!DOCTYPE html>
<html>
    <title>ADL | Search</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/styles/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>

        <?php require_once(__DIR__ . '../../includes/navbar.php'); ?>


        <div class="container">

            <?php

            if ($fflife == '1') {
                ?>
                <table id="clients" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Client Name</th>
                            <th>Client Name</th>
                            <th>Post Code</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Client Name</th>
                            <th>Client Name</th>
                            <th>Post Code</th>
                            <th>View</th>
                        </tr>
                    </tfoot>
                </table>
            <?php }
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

        <script type="text/javascript" language="javascript" >

            $(document).ready(function () {
                var table = $('#clients').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 1,
                    "aLengthMenu": [[1], [1]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                    "ajax": "/datatables/ClientSearch.php?ClientSearch=6&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "Name"},
                        {"data": "Name2"},
                        {"data": "post_code"},
                        {"data": "client_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="/Life/ViewClient.php?search=' + data + '">View</a>';
                            }}
                    ]
                });

            });
        </script>
    </body>
</html>
<?php } else {    header('Location: /CRMmain.php');
    die;
}
