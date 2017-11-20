<?php 
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
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
if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /../../CRMmain.php'); die;

}

if ($fflife=='0') {
        
        header('Location: /../../CRMmain.php?FeatureDisabled'); die;
    }

    $SEARCH = filter_input(INPUT_GET, 'SEARCH', FILTER_SANITIZE_SPECIAL_CHARS);
    $RETURN = filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Keyfacts</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.css">
        <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php
    require_once(__DIR__ . '/../../includes/navbar.php');

    ?>

      <div class="container">
          
          <div class='notice notice-primary' role='alert'><h2> <center><strong><?php if(isset($SEARCH) && $SEARCH=='NotSent') { echo "No attempts at sending a KeyFacts email to client"; } else { echo "KeyFacts email attempts"; } ?></strong></center></h2> </div>
    <br> 
    <?php if(isset($RETURN) && $RETURN=='IGNORE') { ?>
    
          <div class='notice notice-success' role='alert'><center><strong><i class="fa fa-exclamation"></i> Keyfacts email alert dismissed!</strong></center> </div>
    
    
    <?php } ?>
    
    <form action="" method="GET">
                <div class="form-group col-xs-3">
                    <label class="col-md-4 control-label" for="query"></label>
                    <select id="SEARCH" name="SEARCH" class="form-control" onchange="this.form.submit()" required>
                                <option <?php if(isset($SEARCH) && $SEARCH=='Sent') { echo "selected"; } ?> value="Sent" selected>Keyfact attempts</option>
                                <option <?php if(isset($SEARCH) && $SEARCH=='NotSent') { echo "selected"; } ?> value="NotSent">Keyfacts no attempts</option>  
                    </select>
                </div>
            </form>
    <?php if(isset($SEARCH) && $SEARCH=='NotSent') {  ?>
    <table id="KeyfactsNotSent" class="display" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th><?php if(isset($SEARCH)) { if($SEARCH=='NotSent') { echo "ADL Client Added Date"; } if($SEARCH=="Sent") { echo "Sent Date"; } } if(!isset($SEARCH)) { echo "Sent Date"; } ?></th>
                <th>Email</th>
                <th>User</th>
                <?php if(isset($SEARCH)) { if($SEARCH=='NotSent') { echo "<th>View</th>"; } }?>
                <?php if(isset($SEARCH)) { if($SEARCH=='NotSent') { echo "<th>Dismiss?</th>"; } }?>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Date</th>
                <th>Email</th>
                <th>User</th>
                <?php if(isset($SEARCH)) { if($SEARCH=='NotSent') { echo "<th>View</th>"; } }?>
                <?php if(isset($SEARCH)) { if($SEARCH=='NotSent') { echo "<th>Dismiss?</th>"; } }?>
            </tr>
        </tfoot>
    </table>
    <?php } if(!isset($SEARCH)) { ?>
    <table id="Keyfacts" class="display" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th><?php if(isset($SEARCH)) { if($SEARCH=='NotSent') { echo "ADL Client Added Date"; } if($SEARCH=="Sent") { echo "Sent Date"; } } if(!isset($SEARCH)) { echo "Sent Date"; } ?></th>
                <th>Email</th>
                <th>User</th>
                <?php if(isset($SEARCH)) { if($SEARCH=='NotSent') { echo "<th>View</th>"; } }?>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Date</th>
                <th>Email</th>
                <th>User</th>
                <?php if(isset($SEARCH)) { if($SEARCH=='NotSent') { echo "<th>View</th>"; } }?>
            </tr>
        </tfoot>
    </table>    
    <?php } if(isset($SEARCH) && $SEARCH=='Sent') {  ?>
    <table id="Keyfacts" class="display" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th><?php if(isset($SEARCH)) { if($SEARCH=='NotSent') { echo "ADL Client Added Date"; } if($SEARCH=="Sent") { echo "Sent Date"; } } if(!isset($SEARCH)) { echo "Sent Date"; } ?></th>
                <th>Email</th>
                <th>User</th>
                <?php if(isset($SEARCH)) { if($SEARCH=='NotSent') { echo "<th>View</th>"; } }?>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Date</th>
                <th>Email</th>
                <th>User</th>
                <?php if(isset($SEARCH)) { if($SEARCH=='NotSent') { echo "<th>View</th>"; } }?>
            </tr>
        </tfoot>
    </table>    
    <?php }?>
</div>


        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
        <script src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 

<?php if(isset($SEARCH)) {
    if($SEARCH=='Sent') { ?>
   <script type="text/javascript" language="javascript" >

            $(document).ready(function () {
                var table = $('#Keyfacts').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 25,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                    "ajax": "../app/JSON/KeyFacts.php?EXECUTE=1",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "keyfactsemail_added_date"},
                        {"data": "keyfactsemail_email"},
                        {"data": "keyfactsemail_added_by"}

                    ]
                });

            });
        </script>
    <?php } 
    if($SEARCH=='NotSent') { ?>
     <script type="text/javascript" language="javascript" >

            $(document).ready(function () {
                var table = $('#KeyfactsNotSent').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 25,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                    "ajax": "../app/JSON/KeyFacts.php?EXECUTE=2",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "submitted_date"},
                        {"data": "email"},
                        {"data": "closer"},
                                                {"data": "client_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="/Life/ViewClient.php?search=' + data + ' " target="_blank">View</a>';
                            }},
                                                {"data": "email",
                            "render": function (data, type, full, meta) {
                                return '<a href="/Life/php/Keyfacts.php?EXECUTE=1&EMAIL=' + data + ' " target="_blank"><i class="fa fa-check-circle-o"></i></a>';
                            }}                        

                    ]
                });

            });
        </script>      
<?php } } 
if(!isset($SEARCH)) {?>
        <script type="text/javascript" language="javascript" >

            $(document).ready(function () {
                var table = $('#Keyfacts').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 25,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                    "ajax": "../app/JSON/KeyFacts.php?EXECUTE=1",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "keyfactsemail_added_date"},
                        {"data": "keyfactsemail_email"},
                        {"data": "keyfactsemail_added_by"}

                    ]
                });

            });
        </script>
<?php } ?>
</body>
</html>
