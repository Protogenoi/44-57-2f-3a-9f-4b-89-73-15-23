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

require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
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

        require_once(__DIR__ . '/../../classes/database_class.php');
        require_once(__DIR__ . '/../../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$CID = filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT);
$home = filter_input(INPUT_GET, 'home', FILTER_SANITIZE_SPECIAL_CHARS);


if (isset($CID)) {

    $query = $pdo->prepare("SELECT company, leadauditid, leadauditid2, client_id, title, first_name, last_name, dob, email, phone_number, alt_number, title2, first_name2, last_name2, dob2, email2, address1, address2, address3, town, post_code, date_added, submitted_by, leadid1, leadid2, leadid3, leadid12, leadid22, leadid32, callauditid, callauditid2 FROM client_details WHERE client_id = :CID AND company='TRB Home Insurance'");
    $query->bindParam(':CID', $CID, PDO::PARAM_INT);
    $query->execute();
    $data2 = $query->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL | Edit Home Client</title>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
        
    <script type="text/javascript" language="javascript" src="js/jquery/jquery-3.0.0.min.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="/resources/lib/sweet-alert/sweet-alert.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

        <script>
            $(function () {
                $("#dob").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "-100:-0"
                });
            });
        </script>
        <script>
            $(function () {
                $("#dob2").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "-100:-0"
                });
            });
        </script>

        <?php
        if ($ffpost_code == '1') {

            $PostcodeQuery = $pdo->prepare("select api_key from api_keys WHERE type ='PostCode' limit 1");
            $PostcodeQuery->execute()or die(print_r($query->errorInfo(), true));
            $PDre = $PostcodeQuery->fetch(PDO::FETCH_ASSOC);
            $PostCodeKey = $PDre['api_key'];
            ?>

            <script src="/resources/lib/ideal-postcodes/jquery.postcodes.min.js"></script>

        <?php } ?>
    </head>

    <body>
        <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>


        <div class="container">

            <div class="editclient">
                <div class="notice notice-warning">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Warning!</strong> You are now editing <?php echo $data2['title']; ?> <?php echo $data2['first_name']; ?> <?php echo $data2['last_name']; ?> / <?php echo $data2['title2'] ?> <?php echo $data2['first_name2'] ?> <?php echo $data2['last_name2'] ?> details.
                </div>

                <div class="panel-group">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Edit Client</div>
                        <div class="panel-body">
                            <form id="from1" class="AddClient" action="php/EditClientSubmit.php?home=y" method="POST" autocomplete="off">
                                <input  class="form-control" type="hidden" name="CID" value="<?php echo $CID; ?>">
                                <input  class="form-control" type="hidden" name="edited" value="<?php echo $hello_name; ?>">  

                                <p><div class="form-group">
                                    <div class="col-md-2">

                                        <h4><span class="label label-info">Company</span></h4>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" name="company" id="company" style="width: 170px" required="yes">
                                            <option value="<?php echo $data2['company']; ?>"><?php echo $data2['company']; ?></option>
                                            <option value="Bluestone Protect">TRB Life Insurance</option>
                                            <option value="TRB Vitality">TRB Vitality</option>
                                            <option value="TRB Home Insurance">TRB Home Insurance</option>
                                            <option value="Assura">Assura Life Insurance</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                </p>
                                <div class="col-md-12"></div>


                                <div class="col-md-4">
                                    <h3><span class="label label-info">Client Details (1)</span></h3>
                                    <br>

                                    <p>
                                    <div class="form-group">
                                        <label for="title">Title:</label>
                                        <select class="form-control" name="title" id="title" style="width: 170px" required>
                                            <option value="<?php echo $data2['title']; ?>"><?php echo $data2['title']; ?></option>
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
                                        <input  class="form-control" type="text" id="first_name" name="first_name" value="<?php echo $data2['first_name']; ?>" class="form-control" style="width: 170px" required>
                                    </p>


                                    <p>
                                        <label for="last_name">Last Name:</label>
                                        <input  class="form-control" type="text" id="last_name" name="last_name" value="<?php echo $data2['last_name']; ?>" class="form-control" style="width: 170px" required>
                                    </p>


                                    <p>
                                        <label for="dob">Date of Birth:</label>
                                        <input  class="form-control" type="text" id="dob" name="dob" value="<?php echo $data2['dob']; ?>" class="form-control" style="width: 170px" required>
                                    </p>


                                    <p>
                                        <label for="email">Email:</label>
                                        <input  class="form-control" type="email" id="email" name="email" value="<?php echo $data2['email']; ?>" class="form-control" style="width: 170px">
                                    </p>

                                    </p>
                                    <h3><span class="label label-info">System Info (1)</span></h3>
                                    <br>
                                    </p>

                                    <p>
                                        <label for="callauditid">Closer Call Audit ID</label>
                                        <input  class="form-control" type="text" id="callauditid" name="callauditid" value="<?php echo $data2['callauditid']; ?>" class="form-control" style="width: 170px">
                                    </p>

                                    <p>
                                        <label for="leadauditid">Lead Call Audit ID</label>
                                        <input  class="form-control" type="text" id="leadauditid" name="leadauditid" value="<?php echo $data2['leadauditid']; ?>" class="form-control" style="width: 170px">
                                    </p>

                                    <p>
                                        <label for="leadid1">Lead ID 1</label>
                                        <input  class="form-control" type="text" id="leadid1" name="leadid1" value="<?php echo $data2['leadid1']; ?>"class="form-control" style="width: 170px" >
                                    </p>

                                    <p>
                                        <label for="leadid2">Lead ID 2</label>
                                        <input  class="form-control" type="text" id="leadid2" name="leadid2" value="<?php echo $data2['leadid2']; ?>" class="form-control" style="width: 170px">
                                    </p>

                                    <p>
                                        <label for="leadid3">Lead ID 3</label>
                                        <input  class="form-control" type="text" id="leadid3" name="leadid3" value="<?php echo $data2['leadid3']; ?>" class="form-control" style="width: 170px">
                                    </p>

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
                                            <option value="<?php echo $data2['title2']; ?>"><?php echo $data2['title2']; ?></option>
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
                                        <input  class="form-control" type="text" id="first_name2" name="first_name2" value="<?php echo $data2['first_name2']; ?>" class="form-control" style="width: 170px">
                                    </p>
                                    <p>
                                        <label for="last_name2">Last Name:</label>
                                        <input  class="form-control" type="text" id="last_name2" name="last_name2" value="<?php echo $data2['last_name2']; ?>" class="form-control" style="width: 170px">
                                    </p>

                                    <p>
                                        <label for="dob2">Date of Birth:</label>
                                        <input  class="form-control" type="text" id="dob2" name="dob2" value="<?php echo $data2['dob2']; ?>" class="form-control" style="width: 170px">
                                    </p>

                                    <p>
                                        <label for="email2">Email:</label>
                                        <input  class="form-control" type="email2" id="email2" name="email2" value="<?php echo $data2['email2']; ?>" class="form-control" style="width: 170px">

                                    <p>
                                    <h3><span class="label label-info">System Info (2)</span></h3>
                                    <br>
                                    </p>


                                    <p>
                                        <label for="callauditid2">Closer Call Audit ID</label>
                                        <input  class="form-control" type="text" id="callauditid2" name="callauditid2" value="<?php echo $data2['callauditid2']; ?>" class="form-control" style="width: 170px" disabled>
                                    </p>

                                    <p>
                                        <label for="leadauditid2">Lead Call Audit ID</label>
                                        <input  class="form-control" type="text" id="leadauditid2" name="leadauditid2" value="<?php echo $data2['leadauditid2']; ?>" class="form-control" style="width: 170px" disabled>
                                    </p>

                                    <p>
                                        <label for="leadid12">Lead ID 1</label>
                                        <input  class="form-control" type="text" id="leadid12" name="leadid12" value="<?php echo $data2['leadid12']; ?>" class="form-control" style="width: 170px" disabled>
                                    </p>

                                    <p>
                                        <label for="leadid22">Lead ID 2</label>
                                        <input  class="form-control" type="text" id="leadid22" name="leadid22" value="<?php echo $data2['leadid22']; ?>" class="form-control" style="width: 170px" disabled>
                                    </p>

                                    <p>
                                        <label for="leadid32">Lead ID 3</label>
                                        <input  class="form-control" type="text" id="leadid32" name="leadid32" value="<?php echo $data2['leadid32']; ?>" class="form-control" style="width: 170px" disabled>
                                    </p>

                                </div>

                                <div class="col-md-4">
                                    <p>
                                    <h3><span class="label label-info">Contact Details</span></h3>
                                    <br>
                                    </p>

                                    <p>
                                        <label for="phone_number">Contact Number:</label>
                                        <input  class="form-control" type="tel" id="phone_number" name="phone_number" value="<?php echo $data2['phone_number']; ?>" class="form-control" style="width: 170px" required>
                                    </p>


                                    <p>
                                        <label for="alt_number">Alt Number:</label>
                                        <input  class="form-control" type="tel" id="alt_number" name="alt_number" value="<?php echo $data2['alt_number']; ?>" class="form-control" style="width: 170px">
                                    </p>

                                    <br>
                                    <?php if ($ffpost_code == '1') { ?>
                                        <div id="lookup_field"></div>
                                    <?php }

                                    if ($ffpost_code == '0') {
                                        ?>

                                        <div class="alert alert-info"><strong>Info!</strong> Post code lookup feature not enabled.</div>

<?php } ?>
                                    <br>

                                    <p>
                                        <label for="address1">Address Line 1:</label>
                                        <input  class="form-control" type="text" id="address1" name="address1" value="<?php echo $data2['address1']; ?>" class="form-control" style="width: 170px" required>
                                    </p>

                                    <p>
                                        <label for="address2">Address Line 2:</label>
                                        <input  class="form-control" type="text" id="address2" name="address2" value="<?php echo $data2['address2']; ?>" class="form-control" style="width: 170px" >
                                    </p>

                                    <p>
                                        <label for="address3">Address Line 3:</label>
                                        <input  class="form-control" type="text" id="address3" name="address3" value="<?php echo $data2['address3']; ?>"class="form-control" style="width: 170px">
                                    </p>

                                    <p>
                                        <label for="town">Post Town:</label>
                                        <input  class="form-control" type="text" id="town" name="town" value="<?php echo $data2['town']; ?>" class="form-control" style="width: 170px" required >
                                    </p>

                                    <p>
                                        <label for="post_code">Post Code:</label>
                                        <input  class="form-control" type="text" id="post_code" name="post_code" value="<?php echo $data2['post_code']; ?>" class="form-control" style="width: 170px" required>
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
                                    <br>
                                    <select class="form-control" name="changereason" required>
                                        <option value="">Select update reason...</option>
                                        <option value="Incorrect Client Name">Incorrect client name (1)</option>
                                        <option value="Incorrect DOB">Incorrect DOB (1)</option>
                                        <option value="Incorrect email">Incorrect email address (1)</option>
                                        <option value="Incorrect Client Name 2">Incorrect client name (2)</option>
                                        <option value="Incorrect DOB 2">Incorrect DOB (2)</option>
                                        <option value="Incorrect email 2">Incorrect email address (2)</option>
                                        <option value="Incorrect Contact number">Incorrect phone number(s)</option>
                                        <option value="Incorrect Contact address">Incorrect address</option>
                                        <option value="Moved address">Moved address</option>
                                        <option value="New contact number">New contact number</option>
                                        <option value="Added Call Recording Lead ID">Added Call Recording Lead ID</option>
                                        <option value="Added Closer Audit ID">Added Closer Audit ID</option>
                                        <option value="Added Lead Audit ID">Added Lead Audit ID</option>
                                        <option value="Added Client Two">Added Client Two</option>
                                        <?php if (in_array($hello_name,$Level_10_Access,true)) { ?>
                                            <option value="Admin Change">Admin Change</option>
<?php } ?>
                                    </select>

                                    <br>
                                    <button class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>

                            </form>
                            <a href="ViewClient.php?CID=<?php echo $CID; ?>" class="btn btn-warning"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('#from1').addEventListener('submit', function (e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Save changes?",
                text: "You will not be able to recover any overwritten data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            swal({
                                title: 'Complete!',
                                text: 'Client details updated!',
                                type: 'success'
                            }, function () {
                                form.submit();
                            });

                        } else {
                            swal("Cancelled", "No Changes have been submitted", "error");
                        }
                    });
        });

    </script>
</body>
</html>
