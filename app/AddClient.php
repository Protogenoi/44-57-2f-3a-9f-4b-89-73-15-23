<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
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
 * 
*/  

require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');    

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../app/analyticstracking.php');
}

if ($ffpost_code == '1') {
    require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

    $PostcodeQuery = $pdo->prepare("select api_key from api_keys WHERE type ='PostCode' limit 1");
    $PostcodeQuery->execute()or die(print_r($query->errorInfo(), true));
    $PDre = $PostcodeQuery->fetch(PDO::FETCH_ASSOC);
    $PostCodeKey = $PDre['api_key'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Add Client</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/ADL/PostCode.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

    <?php if ($ffpost_code == '1') { ?>
        <script src="/resources/lib/ideal-postcodes/jquery.postcodes.min.js"></script>
    <?php } ?>

    <script>
        $(function () {
            $("#dob").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
        $(function () {
            $("#dob2").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
    </script>
</head>
<body>

    <?php require_once(__DIR__ . '/../includes/navbar.php'); ?>
    <br>
    <div class="container">

        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-user-plus"></i> Add Client</div>
                <div class="panel-body">

                    <form class="AddClient" id="AddProduct" action="php/AddClient.php" method="POST" autocomplete="off">

                        <div class="col-md-4">

                            <h3><span class="label label-info">Client Details (1)</span></h3>
                            <br>

                            <p>
                            <div class="form-group">
                                <label for="custtype">Product:</label>
                                <select class="form-control" name="custype" id="custype" style="width: 170px" required>
                                    <option value="">Select...</option>
                                    <?php
                                    $COMP_QRY = $pdo->prepare("SELECT insurance_company_name from insurance_company where insurance_company_active='1' ORDER BY insurance_company_id DESC");
                                    $COMP_QRY->execute();
                                    if ($COMP_QRY->rowCount() > 0) {
                                        while ($result = $COMP_QRY->fetch(PDO::FETCH_ASSOC)) {

                                            $CUSTYPE = $result['insurance_company_name'];

                                            switch ($CUSTYPE):
                                                
                                                case "The Review Bureau":
                                                    $CUSTYPE="Bluestone Protect";
                                                    $DISPLAY_CUS="TRB Legal and General";
                                                    break;
                                                case "TRB Archive":
                                                    $DISPLAY_CUS = "TRB Archive";
                                                    break;
                                                case "Bluestone Protect":
                                                    case "ADL Legal and General":
                                                case "ADL_CUS":
                                                    $DISPLAY_CUS = "Legal and General";
                                                    break;
                                                case "TRB Royal London":
                                                    $DISPLAY_CUS = "TRB Royal London";
                                                    break;
                                                case "TRB WOL":
                                                case "TRB One Family":
                                                    $CUSTYPE = "TRB WOL";
                                                    $DISPLAY_CUS = "TRB One Family";
                                                    break;
                                                case "TRB Vitality":
                                                    $DISPLAY_CUS = "TRB Vitality";
                                                    break;
                                                case "TRB Home Insurance":
                                                    $DISPLAY_CUS = "TRB Home Insurance";
                                                    break;
                                                case "TRB Aviva":
                                                    $DISPLAY_CUS = "TRB Aviva";
                                                    break;
                                                default:
                                                    $DISPLAY_CUS = $CUSTYPE;
                                                    
                                            endswitch;
                                            
                                            ?>
                                            <option value="<?php
                                            if (isset($CUSTYPE)) {
                                                echo $CUSTYPE;
                                            }
                                            ?>" <?php if(isset($DISPLAY_CUS) && $DISPLAY_CUS=="Legal and General") { echo "selected"; }?>><?php
                                                        if (isset($CUSTYPE)) {
                                                            echo $DISPLAY_CUS;
                                                        }
                                                        ?></option>
                                            <?php
                                        }
                                    }
                                    ?>         

                                </select>
                            </div>
                            </p>
                            
                            <p>
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <select class="form-control" name="title" id="title" style="width: 170px" required>
                                    <option value="">Select...</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Dr">Dr</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            </p>

                            <p>
                                <label for="first_name">First Name:</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" style="width: 170px" required>
                            </p>
                            <p>
                                <label for="last_name">Last Name:</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" style="width: 170px" required>
                            </p>
                            <p>
                                <label for="dob">Date of Birth:</label>
                                <input type="text" id="dob" name="dob" class="form-control" style="width: 170px" required>
                            </p>
                            <p>
                                <label for="email">Email:</label>
                                <input type="email" id="email" class="form-control" style="width: 170" name="email" placeholder="Use no@email.no for no email address" title="Use no@email.no for no email address">                            
                            </p>

                            <br>

                        </div>
                        <div class="col-md-4">
                            <p>

                            <h3><span class="label label-info">Client Details (2)</span></h3>
                            <br>

                            </p>
                            <p>
                            <div class="form-group">
                                <label for="title2">Title:</label>
                                <select class="form-control" name="title2" id="title2" style="width: 170px">
                                    <option value="">Select...</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Dr">Dr</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            </p>

                            <p>
                                <label for="first_name2">First Name:</label>
                                <input type="text" id="first_name2" name="first_name2" class="form-control" style="width: 170px">
                            </p>
                            <p>
                                <label for="last_name2">Last Name:</label>
                                <input type="text" id="last_name2" name="last_name2" class="form-control" style="width: 170px" >
                            </p>
                            <p>
                                <label for="dob2">Date of Birth:</label>
                                <input type="text" id="dob2" name="dob2" class="form-control" style="width: 170px">
                            </p>
                            <p>
                                <label for="email2">Email:</label>
                                <input type="email" id="email2" name="email2" class="form-control" style="width: 170px"">
                            </p>
                            <br>            
                        </div>

                        <div class="col-md-4">
                            <p>

                            <h3><span class="label label-info">Contact Details</span></h3>
                            <br>
                            </p>
                            <p>
                                <label for="phone_number">Contact Number:</label>
                                <input type="tel" id="phone_number" name="phone_number" class="form-control" style="width: 170px" required pattern=".{11}|.{11,11}" maxlength="11" title="Enter a valid phone number">
                            </p>
                            <p>
                                <label for="alt_number">Alt Number:</label>
                                <input type="tel" id="alt_number" name="alt_number" class="form-control" style="width: 170px" pattern=".{11}|.{11,11}" maxlength="11" title="Enter a valid phone number">
                            </p>
                            <br>
                            <?php if ($ffpost_code == '1') { ?>
                                <div id="lookup_field"></div>
                                <?php
                            }

                            if ($ffpost_code == '0') {
                                ?>

                                <div class="alert alert-info"><strong>Info!</strong> Post code lookup feature not enabled.</div>

                            <?php } ?>
                            <p>
                                <label for="address1">Address Line 1:</label>
                                <input type="text" id="address1" name="address1" class="form-control" style="width: 170px" required>
                            </p>
                            <p>
                                <label for="address2">Address Line 2:</label>
                                <input type="text" id="address2" name="address2" class="form-control" style="width: 170px">
                            </p>
                            <p>
                                <label for="address3">Address Line 3:</label>
                                <input type="text" id="address3" name="address3 class="form-control" style="width: 170px"">
                            </p>
                            <p>
                                <label for="town">Post Town:</label>
                                <input type="text" id="town" name="town" class="form-control" style="width: 170px">
                            </p>
                            <p>
                                <label for="post_code">Post Code:</label>
                                <input type="text" id="post_code" name="post_code" class="form-control" style="width: 170px" required>
                            </p>
                            <?php if ($ffpost_code == '1') { ?>
                                <script>
                                    $('#lookup_field').setupPostcodeLookup({
                                        api_key: '<?php echo $PostCodeKey; ?>',
                                        output_fields: {
                                            line_1: '#address1',
                                            line_2: '#address2',
                                            line_3: '#address3',
                                            post_town: '#town',
                                            postcode: '#post_code'
                                        }
                                    });
                                </script>
                            <?php } ?>
                        </div>
                        <br>
                        <br>
                        <center>
                            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Client</button></center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>