<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
 * 
*/

require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 6);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../app/analyticstracking.php');
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

    require_once(__DIR__ . '/../../classes/database_class.php');
    require_once(__DIR__ . '/../../class/login/login.php');

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
        
        $ADL_PAGE_TITLE = "Sale Search";
        require_once(__DIR__ . '/../../app/core/head.php'); 
        
        
        ?>
        <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
        <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
    </head>
    <body>

        <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>


        <div class="container">

            <?php if ($fflife == '1') { ?>
              
<div class='notice notice-primary' role='alert'><center><strong>Search sales by sale date.</strong></center></div> 

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
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
        <script src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 

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
                            "ajax": "/addon/Life/JSON/Search.php?EXECUTE=10&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>&CLOSER=<?php echo $CLOSER; ?>&DATETO=<?php echo $DATETO; ?>&DATEFROM=<?php echo $DATEFROM; ?>",
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
                                        return '<a href="/app/Client.php?search=' + data + '">View</a>';
                                    }}
                            ],
                            "order": [[1, 'asc']]
                        });

                        $('#policy tbody').on('click', 'td.details-control', function () {
                            var tr = $(this).closest('tr');
                            var row = table.row(tr);

                            if (row.child.isShown()) {
                                row.child.hide();
                                tr.removeClass('shown');
                            } else {
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