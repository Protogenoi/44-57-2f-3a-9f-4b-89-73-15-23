<?php
require_once(__DIR__ . '../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 6);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '../../includes/user_tracking.php'); 

require_once(__DIR__ . '../../includes/adl_features.php');
require_once(__DIR__ . '../../includes/Access_Levels.php');

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

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
$CLOSER = filter_input(INPUT_POST, 'CLOSER', FILTER_SANITIZE_SPECIAL_CHARS);
$DATEFROM = filter_input(INPUT_POST, 'DATEFROM', FILTER_SANITIZE_SPECIAL_CHARS);
$DATETO = filter_input(INPUT_POST, 'DATETO', FILTER_SANITIZE_SPECIAL_CHARS);

    require_once(__DIR__ . '../../classes/database_class.php');
    require_once(__DIR__ . '../../class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 6) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html>
    <title>ADL | Sale Search</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
        <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/DataTable/datatables.min.css"/>
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>

        <?php require_once(__DIR__ . '../../includes/navbar.php'); ?>


        <div class="container">

            <?php if ($fflife == '1') { ?>
              
<div class='notice notice-primary' role='alert'><center><strong>Search sales</strong></center></div> 

            <?php  if (in_array($hello_name, $ADMIN_SEARCH_ACCESS,true)) {?>

<form action='?EXECUTE=1' method='POST'>
    <table>
        <tr>
            <th>Closer</th>
            <th>Date from</th>
            <th>Date to</th>
            <th></th>
        </tr>
        <tr>
                    <td><select class="form-control" name="CLOSER">
                            <option value="Carys" <?php if(isset($CLOSER) && $CLOSER=='Carys') { echo "selected"; } ?> >Carys</option>
                            <option value="Nicola" <?php if(isset($CLOSER) && $CLOSER=='Nicola') { echo "selected"; } ?> >Nicola</option>
                            <option value="Richard" <?php if(isset($CLOSER) && $CLOSER=='Richard') { echo "selected"; } ?> >Richard</option>
                            <option value="Corey" <?php if(isset($CLOSER) && $CLOSER=='Corey') { echo "selected"; } ?> >Corey</option>
                            <option value="Kyle" <?php if(isset($CLOSER) && $CLOSER=='Kyle') { echo "selected"; } ?> >Kyle</option>
                            <option value="Martin" <?php if(isset($CLOSER) && $CLOSER=='Martin') { echo "selected"; } ?> >Martin</option>
                            <option value="Hayley" <?php if(isset($CLOSER) && $CLOSER=='Hayley') { echo "selected"; } ?> >Hayley</option>
                            <option value="Gavin" <?php if(isset($CLOSER) && $CLOSER=='Gavin') { echo "selected"; } ?> >Gavin</option>
                            <option value="Sarah" <?php if(isset($CLOSER) && $CLOSER=='Sarah') { echo "selected"; } ?> >Sarah</option>
                            <option value="James" <?php if(isset($CLOSER) && $CLOSER=='James') { echo "selected"; } ?> >James</option>
                </select></td>
            <td><input size="12" class="form-control" type="text" name="DATEFROM" id="DATEFROM" value="<?php if (isset($DATEFROM)) {
                    echo $DATEFROM;
                } ?>"></td>
            <td><input size="12" class="form-control" type="text" name="DATETO" id="DATETO" value="<?php if (isset($DATETO)) {
                    echo $DATETO;
                } ?>"></td>
            <td><button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-search"></i> Search</button></td>
        </tr>
    </table>
</form>

<?php if(isset($EXECUTE) && $EXECUTE==1) { ?>

<table id="home" class="display" width="auto" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Sale Date</th>
                                <th>Sub Date</th>
                                <th>Client</th>
                                <th>Policy</th>
                                <th>Comms</th>
                                <th>Insurer</th>
                                <th>Status</th>
                                <th>Closer</th>
                                <th>Lead</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                              <th>Sale Date</th>
                                <th>Sub Date</th>
                                <th>Client</th>
                                <th>Policy</th>
                                <th>Comms</th>
                                <th>Insurer</th>
                                <th>Status</th>
                                <th>Closer</th>
                                <th>Lead</th>
                                <th>View</th>
                            </tr>
                        </tfoot>
                    </table>
            
            
              <?php } 
     
            } }
            ?>
          
        </div>
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-1.11.1.min.js"></script>    
    <script type="text/javascript" language="javascript" src="/datatables/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="/datatables/js/jquery.dataTables.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>    
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
      <?php if (in_array($hello_name, $ADMIN_SEARCH_ACCESS,true)) {
          if(isset($EXECUTE) && $EXECUTE==1) { ?>  
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
                            "ajax": "/datatables/ClientSearch.php?ClientSearch=10&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>&CLOSER=<?php echo $CLOSER; ?>&DATETO=<?php echo $DATETO; ?>&DATEFROM=<?php echo $DATEFROM; ?>",
                            "columns": [
                                {
                                    "className": 'details-control',
                                    "orderable": false,
                                    "data": null,
                                    "defaultContent": ''
                                },
                                {"data": "sale_date"},
                                {"data": "submitted_date"},
                                {"data": "client_name"},
                                {"data": "policy_number"},
                                {"data": "commission"},
                                {"data": "insurer"},
                                {"data": "PolicyStatus"},
                                {"data": "closer"},
                                {"data": "lead"},
                                {"data": "client_id",
                                    "render": function (data, type, full, meta) {
                                        return '<a href="/Life/ViewClient.php?search=' + data + '">View</a>';
                                    }}
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
             <?php } } ?>
                
                                    <script>
        $(function () {
            $("#DATEFROM").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
        $(function () {
            $("#DATETO").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
    </script> 
    </body>
</html>