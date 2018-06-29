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

require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../../classes/database_class.php');
require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}
if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /../../../CRMmain.php');
    die;
}

if ($fflife == '0') {

    header('Location: /../../../CRMmain.php?FeatureDisabled');
    die;
}

$SEARCH = filter_input(INPUT_GET, 'SEARCH', FILTER_SANITIZE_SPECIAL_CHARS);

require_once(__DIR__ . '/../../../class/login/login.php');

$CHECK_USER_LOGIN = new UserActions($hello_name, "NoToken");
$CHECK_USER_LOGIN->SelectToken();
$OUT = $CHECK_USER_LOGIN->SelectToken();

if (isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT'] != 'NoToken') {

    $TOKEN = $OUT['TOKEN_SELECT'];
}

$CHECK_USER_LOGIN->CheckAccessLevel();
$USER_ACCESS_LEVEL = $CHECK_USER_LOGIN->CheckAccessLevel();

$ACCESS_LEVEL = $USER_ACCESS_LEVEL['ACCESS_LEVEL'];

if ($ACCESS_LEVEL < 3) {

    header('Location: /../../../../index.php?AccessDenied&USER=' . $hello_name . '&COMPANY=' . $COMPANY_ENTITY);
    die;
}

        $ADL_PAGE_TITLE = "Missing Client Uploads";
        require_once(__DIR__ . '/../../../app/core/head.php'); 
        
        ?>

    <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.css">
</head>
<body>

    <?php
    require_once(__DIR__ . '/../../../includes/navbar.php');
    ?>

    <div class="container">

        <div class='notice notice-primary' role='alert'><h2> <center><strong><?php if (isset($SEARCH)) {
        if ($SEARCH == 'Insurer Keyfacts') {
            echo "Insurer Keyfacts missing";
        } if ($SEARCH == 'Dealsheet') {
            echo "Dealsheets missing";
        } if ($SEARCH == 'Closer Recording') {
            echo "Closer call recordings missing";
        } if ($SEARCH == 'Agent Recording') {
            echo "Agent call recordings missing";
        }
        if ($SEARCH == 'LG App') {
            echo "Legal and General Application missing";
        }
        if ($SEARCH == 'Missing Policy') {
            echo "No policies have been added for these clients";
        }  
        if ($SEARCH == 'Welcome SMS') {
            echo "No welcome SMS has been sent to this client";
        }          
    } ?></strong></center></h2> </div>
        <br> 

        <form action="" method="GET">
            <div class="form-group col-xs-3">
                <label class="col-md-4 control-label" for="query"></label>
                <select id="SEARCH" name="SEARCH" class="form-control" onchange="this.form.submit()" required>
<?php if (isset($SEARCH)) { ?>
                        <option <?php if ($SEARCH == 'Insurer Keyfacts') {
        echo "selected";
    } ?> value="Insurer Keyfacts">Insurer Keyfacts</option>                        
                        <option <?php if ($SEARCH == 'Dealsheet') {
            echo "selected";
        } ?> value="Dealsheet">Dealsheet</option>
                        <option <?php if ($SEARCH == 'Closer Recording') {
            echo "selected";
        } ?> value="Closer Recording">Closer Recording</option>
                        <option <?php if ($SEARCH == 'Agent Recording') {
            echo "selected";
        } ?> value="Agent Recording">Agent Recording</option>
                        <option <?php if ($SEARCH == 'LG App') {
            echo "selected";
        } ?> value="LG App">Legal and General App</option>  
                        <option <?php if ($SEARCH == 'Zurich App') {
            echo "selected";
        } ?> value="Zurich App">Zurich App</option>  
                        <option <?php if ($SEARCH == 'Royal London App') {
            echo "selected";
        } ?> value="Royal London App">Royal London App</option>                          
                        <option <?php if ($SEARCH == 'SW App') {
            echo "selected";
        } ?> value="SW App">Scottish Widows App</option>  
                        <option <?php if ($SEARCH == 'Aegon App') {
            echo "selected";
        } ?> value="Aegon App">Aegon App</option>                          
                        <option <?php if ($SEARCH == 'Vitality App') {
            echo "selected";
        } ?> value="Vitality App">Vitality App</option>                          
                        <option <?php if ($SEARCH == 'Welcome SMS') {
            echo "selected";
        } ?> value="Welcome SMS">Welcome SMS</option> 
                        <option <?php if ($SEARCH == 'Missing Policy') {
            echo "selected";
        } ?> value="Missing Policy">No policy added</option>                         
<?php } ?>

                </select>
            </div>
        </form>

<?php if (isset($SEARCH)) { ?>
            <table id="KeyFacts" class="display" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>Date</th>
                        <th>Client Name</th>
                        <th>Client Name</th>
                        <th>Post Code</th>
                        <th>Insurer</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Date</th>
                        <th>Client Name</th>
                        <th>Client Name</th>
                        <th>Post Code</th>
                        <th>Insurer</th>
                        <th>View</th>
                    </tr>
                </tfoot>
            </table>    
<?php } ?>
    </div>


        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
        <script src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 

<?php if (isset($SEARCH)) { ?>
        <script type="text/javascript" language="javascript" >

                             $(document).ready(function () {
                                 var table = $('#KeyFacts').DataTable({
                                     "response": true,
                                     "processing": true,
                                     "iDisplayLength": 25,
                                     "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                                     "language": {
                                         "processing": "<div></div><div></div><div></div><div></div><div></div>"
                                     },
                                     "ajax": "/addon/Life/JSON/Uploads.php?EXECUTE=<?php if (isset($SEARCH)) {
        if ($SEARCH == 'Insurer Keyfacts') {
            echo "1";
        } if ($SEARCH == 'Closer Recording') {
            echo "2";
        } if ($SEARCH == 'Agent Recording') {
            echo "3";
        } if ($SEARCH == 'Dealsheet') {
            echo "4";
        }
        if ($SEARCH == 'LG App') {
            echo "5";
        } 
        if ($SEARCH == 'Welcome SMS') {
            echo "6";
        }   
        if ($SEARCH == 'Missing Policy') {
            echo "7";
        }          
        if ($SEARCH == 'Vitality App') {
            echo "8";
        }  
        if ($SEARCH == 'SW App') {
            echo "9";
        } 
        if ($SEARCH == 'Zurich App') {
            echo "10";
        } 
        if ($SEARCH == 'Royal London App') {
            echo "11";
        } 
        if ($SEARCH == 'Aegon App') {
            echo "12";
        }         
    } ?>&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                                     "columns": [
                                         {
                                             "className": 'details-control',
                                             "orderable": false,
                                             "data": null,
                                             "defaultContent": ''
                                         },
                                         {"data": "submitted_date"},
                                         {"data": "Name"},
                                         {"data": "Name2"},
                                         {"data": "post_code"},
                                         {"data": "company"},
                                         {"data": "client_id",
                                             "render": function (data, type, full, meta) {
                                                 return '<a href="/app/Client.php?search=' + data + '">View</a>';
                                             }}

                                     ]
                                 });

                             });
        </script>
<?php } ?>
</body>
</html>