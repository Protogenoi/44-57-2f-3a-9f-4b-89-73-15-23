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
require_once filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/app/core/doc_root.php';

include (BASE_URL."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=1;

require_once(BASE_URL.'/includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}


require_once(BASE_URL.'/includes/adl_features.php');
require_once(BASE_URL.'/includes/Access_Levels.php');
require_once(BASE_URL.'/includes/adlfunctions.php');
require_once(BASE_URL.'/includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(BASE_URL.'/app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

        require_once(BASE_URL.'/classes/database_class.php');
        require_once(BASE_URL.'/class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

if (isset($hello_name)) {

        switch ($hello_name) {
            case "Michael":
                $hello_name_full = "Michael Owen";
                break;
            case "Jakob":
                $hello_name_full = "Jakob Lloyd";
                break;
            case "leighton":
                $hello_name_full = "Leighton Morris";
                break;
            case "Nicola":
                $hello_name_full = "Nicola Griffiths";
                break;
            case "carys":
                $hello_name_full = "Carys Riley";
                break;
            case "Matt":
                $hello_name_full = "Matthew Jones";
                break;
            case "Tina":
                $hello_name_full = "Tina Dennis";
                break;
            case "Nick":
                $hello_name_full = "Nick Dennis";
                break;
            case "Ryan":
                $hello_name_full = "Ryan Lloyd";
                break;
            default:
                $hello_name_full = $hello_name;
        }
}

    $WHICH_COMPANY = filter_input(INPUT_GET, 'WHICH_COMPANY', FILTER_SANITIZE_SPECIAL_CHARS);
    $policyID = filter_input(INPUT_GET, 'policyID', FILTER_SANITIZE_NUMBER_INT);
    $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
    
        if (isset($search)) {

    $tracking_search= "%search=$search%";
}

    $query = $pdo->prepare("SELECT sic_cover_amount, non_indem_com, extra_charge, id, polterm, client_name, sale_date, application_number, policy_number, premium, type, insurer, submitted_by, commission, CommissionType, policystatus, submitted_date, edited, date_edited, drip, comm_term, soj, closer, lead, covera FROM client_policy WHERE id =:PID and client_id=:CID");
    $query->bindParam(':PID', $policyID, PDO::PARAM_INT);
    $query->bindParam(':CID', $search, PDO::PARAM_INT);
    $query->execute();
    $data2 = $query->fetch(PDO::FETCH_ASSOC);
    
    if(empty($data2['covera'])) {
        $data2['covera']=0;
    } elseif(!is_numeric ( $data2['covera'] )) {
        $data2['covera']=0;
    }
    $COVER_AMOUNT = number_format($data2['covera'],2);
    $SIC_COVER_AMOUNT = number_format($data2['sic_cover_amount'],2);

    $query2 = $pdo->prepare("SELECT email, email2 FROM client_details WHERE client_id=:CID");
    $query2->bindParam(':CID', $search, PDO::PARAM_INT);
    $query2->execute();
    $data3 = $query2->fetch(PDO::FETCH_ASSOC);
    
        $ADL_PAGE_TITLE = "View Policy";
        require_once(BASE_URL.'/app/core/head.php'); 
        
        
        ?>
    <link rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
</head>
<body>

    <?php require_once(BASE_URL.'/includes/navbar.php'); ?>
    
    <div class="container">
        
         <?php require_once(BASE_URL.'/includes/user_tracking.php');  ?>
        
        <div class="policyview">
            <div class="notice notice-info fade in">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Note!</strong> You are now viewing <?php echo $data2['client_name'] ?>'s policy.
            </div>
        </div>

        <?php if ($data2['client_name'] == 'Joint Policy') { ?>

            <div class="policyview">
                <div class="notice notice-warning fade in">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Warning!</strong> Before sending any email's to this client, please update the policy holder to the correct client names.
                </div>
            </div>

        <?php } ?>


        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">View Policy</div>
                <div class="panel-body">
                    <div class="column-right">

                        <?php
                            if (in_array($hello_name, $Level_8_Access, true)) {

                                $polid = $data2['id'];
                                $policy_number = $data2["policy_number"];
                                $clientname = $data2['client_name'];

                                $ews_stuff = $pdo->prepare("SELECT
                                                                adl_ews_ref,
                                                                adl_ews_id,
                                                                adl_ews_notes,
                                                                adl_ews_orig_status,
                                                                adl_ews_status,
                                                                adl_ews_colour
                                                            FROM 
                                                                adl_ews
                                                            LEFT JOIN 
                                                                client_policy
                                                            ON 
                                                                adl_ews_ref=client_policy.policy_number
                                                            WHERE 
                                                                adl_ews_ref=:POLICY 
                                                            AND 
                                                                client_policy.id=:PID");
                                $ews_stuff->bindParam(':POLICY', $policy_number, PDO::PARAM_STR, 12);
                                $ews_stuff->bindParam(':PID', $polid, PDO::PARAM_STR, 12);
                                $ews_stuff->execute();
                                $ewsresult = $ews_stuff->fetch(PDO::FETCH_ASSOC);

                                $COLOUR = $ewsresult['adl_ews_colour'];
                                $ORIG_STATUS = $ewsresult['adl_ews_orig_status'];
                                $EWS_NOTES = $ewsresult['adl_ews_notes'];
                                $NEW_STATUS = $ewsresult['adl_ews_status'];
                                ?>

                                <form action="/addon/Life/EWS/php/update_ews_policy.php?EXECUTE=1" method="POST" id="from1" class="form-horizontal">

                                    <input type='hidden' name='CID' value='<?php echo $search; ?>'>
                                    <input type='hidden' name='POLICY' value='<?php echo $policy_number; ?>'>
                                    <input type='hidden' name='NAME' value='<?php echo $clientname; ?>'>


                                    <fieldset>

                                        <legend>Update EWS</legend>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="ORIG_STATUS">Current Status</label>  
                                            <div class="col-md-4">
                                                <input id="ORIG_STATUS" name="ORIG_STATUS" class="form-control input-md" type="text" value='<?php echo $ORIG_STATUS; ?>' readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="NEW_STATUS">New Status</label>
                                            <div class="col-md-4">
                                                <select id="NEW_STATUS" name="NEW_STATUS" class="form-control" required>
                                                    <?php 
                                                    if(empty($NEW_STATUS)) {
                                                    ?>
                                                    <option value="NEW" <?php if(isset($NEW_STATUS) && $NEW_STATUS =='NEW') { echo "selected"; } ?> >NEW</option>
                                                    <?php } ?>
                                                    <option value="RE-INSTATED" <?php if(isset($NEW_STATUS) && $NEW_STATUS =='RE-INSTATED') { echo "selected"; } ?> >RE-INSTATED</option>
                                                    <option value="WILL CANCEL" <?php if(isset($NEW_STATUS) && $NEW_STATUS =='WILL CANCEL') { echo "selected"; } ?> >WILL CANCEL</option>
                                                    <option value="REDRAWN" <?php if(isset($NEW_STATUS) && $NEW_STATUS =='REDRAWN') { echo "selected"; } ?> >REDRAWN</option>
                                                    <option value="WILL REDRAW" <?php if(isset($NEW_STATUS) && $NEW_STATUS =='WILL REDRAW') { echo "selected"; } ?> >WILL REDRAW</option>
                                                    <option value="CANCELLED" <?php if(isset($NEW_STATUS) && $NEW_STATUS =='CANCELLED') { echo "selected"; } ?> >CANCELLED</option>
                                                    <option value="FUTURE CALLBACK" <?php if(isset($NEW_STATUS) && $NEW_STATUS =='Future Callback') { echo "selected"; } ?> >Future Callback</option>
                                                </select>
                                            </div>
                                        </div>

                                        <?php
                                        switch ($COLOUR) {
                                            case("green"):
                                                $SELECT_COLOR = 'style="background-color:green;color:white;"';
                                                break;
                                            case("orange"):
                                                $SELECT_COLOR = 'style="background-color:orange;color:white;"';
                                                break;
                                            case("purple"):
                                                $SELECT_COLOR = 'style="background-color:purple;color:white;"';
                                                break;
                                            case("red"):
                                                $SELECT_COLOR = 'style="background-color:red;color:white;"';
                                                break;
                                            case("black"):
                                                $SELECT_COLOR = 'style="background-color:black;color:white;"';
                                                break;
                                            case("blue"):
                                                $SELECT_COLOR = 'style="background-color:blue;color:white;"';
                                                break;
                                            case("grey"):
                                                $SELECT_COLOR = 'style="background-color:grey;color:white;"';
                                                break;
                                            default:
                                                $SELECT_COLOR = 'style="background-color:black;color:white;"';
                                                break;
                                        }
                                        ?>


                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="COLOUR">Set colour</label>
                                            <div class="col-md-4">
                                                <select id="COLOUR" name="COLOUR" class="form-control" required>
                                                    <option <?php
                                                    if (isset($COLOUR)) {
                                                        echo $SELECT_COLOR;
                                                    }
                                                    ?> value="<?php
                                                        if (isset($COLOUR)) {
                                                            echo $COLOUR;
                                                        }
                                                        ?>" ><?php
                                                            if (isset($COLOUR)) {
                                                                echo $COLOUR;
                                                            }
                                                            ?></option>
                                                    <option value="green" style="background-color:green;color:white;">Green</option>
                                                    <option value="orange" style="background-color:orange;color:white;">Orange</option>
                                                    <option value="purple" style="background-color:purple;color:white;">Purple</option>
                                                    <option value="red" style="background-color:red;color:white;">Red</option>
                                                    <option value="black" style="background-color:black;color:white;">Black</option>
                                                    <option value="blue" style="background-color:blue;color:white;">Blue</option>
                                                    <option value="Grey" style="background-color:grey;color:white;">Grey</option>
                                                    <option value="yellow" style="background-color:yellow;color:black;">Yellow</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="EWS_NOTES">Notes</label>
                                            <div class="col-md-4">                     
                                                <textarea class="form-control" id="EWS_NOTES" name="EWS_NOTES"><?php if(isset($EWS_NOTES)) { echo $EWS_NOTES; } ?></textarea>
                                            </div>
                                        </div>

                                    <?php } if (in_array($hello_name, $Level_3_Access, true)) { ?>

                                        <center>

                                            <div class="form-group">
                                                <div class="col-md-10">
                                                    <?php if (in_array($hello_name, $Level_3_Access, true)) { ?>
                                                        <button id="button1id" name="button1id" class="btn btn-success"><i class="far fa-check-circle"></i> Update</button>
                                                    <?php } ?>
                                                    <a href="/app/Client.php?search=<?php echo $search; ?>" class="btn btn-warning "><i class="far fa-arrow-alt-circle-left"></i> Back</a>
                                                    <a href="EditPolicy.php?id=<?php echo $policyID; ?>&search=<?php echo $search; ?>" class="btn btn-warning "><i class="fa fa-edit"></i> Edit Policy</a>
                                                    <br><br>
                                                </div>
                                            </div>

                                        </center>
                                    </fieldset>

                                </form>
                                <?php
                            }

                        ?>
                        <form class="AddClient">
                            <p>
                                <label for="created">Added By</label>
                                <input type="text" value="<?php echo $data2["submitted_by"]; ?>" class="form-control" readonly style="width: 200px">
                            </p>
                            <p>
                                <label for="created">Date Added</label>
                                <input type="text" value="<?php echo $data2["submitted_date"]; ?>" class="form-control" readonly style="width: 200px">
                            </p> 
                            <p>
                                <label for="created">Edited By</label>
                                <input type="text" value="<?php
                                if (!empty($data2["date_edited"] && $data2["submitted_date"] != $data2["date_edited"])) {
                                    echo $data2["edited"];
                                }
                                ?>" class="form-control" readonly style="width: 200px">
                            </p>   
                            <p>
                                <label for="created">Date Edited</label>
                                <input type="text" value="<?php
                                if ($data2["submitted_date"] != $data2["date_edited"]) {
                                    echo $data2["date_edited"];
                                }
                                ?>" class="form-control" readonly style="width: 200px">
                            </p>   
                        </form>                  
                    </div>

                    <form class="AddClient">
                        <div class="column-left">

                            <p>
                                <input type="hidden" id="submitted_by" name="submitted_by" value="<?php echo $data2["submitted_by"]; ?>" class="form-control" readonly style="width: 200px">
                            </p>

                            <p>
                                <label for="client_name">Policy Holder</label>
                                <input type="text" id="client_name" name="client_name" value="<?php echo $data2['client_name']; ?>" class="form-control" readonly style="width: 200px">
                            </p>


                            <p>
                                <label for="soj">Single or Joint:</label>
                                <input type="text" value="<?php echo $data2['soj']; ?>" class="form-control" readonly style="width: 200px">
                            </p>
                            
                            <p>
                                <label for="submitted_date">Sale Date:</label>
                                <input type="text" id="submitted_date" name="submitted_date" value="<?php echo $data2["submitted_date"]; ?>" class="form-control" readonly style="width: 200px">
                                                        </p>

                            <p>
                                <label for="sale_date">Submitted Date:</label>
                                <input type="text" id="sale_date" name="sale_date" value="<?php echo $data2["sale_date"]; ?>" class="form-control" readonly style="width: 200px">
                            </p>


                            <p>
                                <label for="policy_number">Policy Number</label>
                                <input type="text" id="policy_number" name="policy_number" value="<?php echo $data2["policy_number"]; ?>" class="form-control" readonly style="width: 200px">
                            </p>


                            <p>
                                <label for="application_number">Application Number:</label>
                                <input type="text" id="application_number" name="application_number" value="<?php echo $data2["application_number"]; ?>" class="form-control" readonly style="width: 200px">
                            </p>


                            <p>
                                <label for="type">Type</label>
                                <input type="text" value="<?php echo $data2["type"]; ?>" class="form-control" readonly style="width: 200px">
                            </p>


                            <p>
                                <label for="insurer">Insurer</label>
                                <input type="text" value="<?php echo $data2["insurer"]; ?>" class="form-control" readonly style="width: 200px">
                            </p>

                            <div class="col-sm-12">

                                <div class="list-group">
                                    <span class="label label-primary">Policy Emails</span>
                                    <?php if(isset($data2["insurer"]) && $data2["insurer"]=='Legal and General') { ?>
                                    <a class="list-group-item" data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i>&nbsp; Send Policy Number</a>
                                    <?php } ?>
                                    <a class="list-group-item" data-toggle="modal" data-target="#myModal2"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i>&nbsp; Uncontactable Client (With Policy Number)</a>
                                    <a class="list-group-item" data-toggle="modal" data-target="#myModal3"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i>&nbsp; Uncontactable Client (Awaiting Policy Number)</a>
                                </div>

                            </div>
                        </div>
                        <div class="column-center">
                            <p>
                            <div class="form-row">
                                <label for="premium">Premium:</label>
                                <div class="input-group"> 
                                    <span class="input-group-addon">£</span>
                                    <input style="width: 170px" type="number" value="<?php echo $data2['premium']; ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" class="form-control" readonly style="width: 200px"/>
                                </div> 
                                </p>
                                
                            <p>
                                <label for="EXTRA_CHARGE">Extra Charge:</label>
                                <div class="input-group"> 
                                    <span class="input-group-addon">£</span>
                                    <input style="width: 170px" type="number" value="<?php if(isset($data2['extra_charge'])) { echo $data2['extra_charge']; } ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="EXTRA_CHARGE" name="EXTRA_CHARGE" class="form-control" readonly style="width: 200px"/>
                                </div> 
                                </p> 
                                
                                             <p>
                                                <label for="CommissionType">Commission Type</label>
                                                <input type="text" value="<?php echo $data2["CommissionType"]; ?>" class="form-control" readonly style="width: 200px">
                                            </p>                               

                                <p>
                                <div class="form-row">
                                    <label for="commission">Commission</label>
                                    <div class="input-group"> 
                                        <span class="input-group-addon">£</span>
                                        <input style="width: 170px" type="number" value="<?php echo $data2['commission']; ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" class="form-control" readonly style="width: 200px"/>
                                    </div> 
                                    </p>

                                <p>
                                <div class="form-row">
                                    <label for="NonIndem">Non-Idem Comm</label>
                                    <div class="input-group"> 
                                        <span class="input-group-addon">£</span>
                                        <input style="width: 170px" type="number" value="<?php echo $data2['non_indem_com']; ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="NonIndem" name="NonIndem" class="form-control" readonly style="width: 200px"/>
                                    </div> 
                                    </p>                                    
                                    
                                    <p>
                                    <div class="form-row">
                                        <label for="covera">Cover Amount</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input style="width: 170px" type="text" value="<?php echo $COVER_AMOUNT; ?>" class="form-control currency" id="covera" name="covera" class="form-control" readonly style="width: 200px"/>
                                        </div> 
                                        </p>
                                        
                                    <p>
                                    <div class="form-row">
                                        <label for="SIC_COVER_AMOUNT">SIC Cover Amount</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input style="width: 170px" type="text" value="<?php echo $SIC_COVER_AMOUNT; ?>" class="form-control currency" id="SIC_COVER_AMOUNT" name="SIC_COVER_AMOUNT" class="form-control" readonly style="width: 200px"/>
                                        </div> 
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="polterm">Policy Term</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">yrs</span>
                                                <input style="width: 160px" type="text" class="form-control" id="polterm" name="polterm" value="<?php echo $data2['polterm'] ?>" disabled/>
                                            </div> 
                                            </p>

                                            <p>
                                                <label for="comm_term">Clawback Term</label>
                                                <input type="text" value="<?php echo $data2["comm_term"]; ?>" class="form-control" readonly style="width: 200px">
                                                </select>
                                            </p>


                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Drip</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">£</span>
                                                    <input style="width: 170px" type="number" value="<?php echo $data2["drip"]; ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" class="form-control" readonly style="width: 200px"/>
                                                </div> 
                                                </p>

                                                <p>
                                                    <label for="PolicyStatus">Policy Status</label>
                                                    <input type="text" value="<?php echo $data2['policystatus']; ?>" class="form-control" readonly style="width: 200px">
                                                    </select>
                                                </p>

                                                <p>
                                                    <label for="closer">Closer:</label>
                                                    <input type='text' id='closer' name='closer' value="<?php echo $data2["closer"]; ?>" class="form-control" readonly style="width: 200px">
                                                </p>

                                                <p>
                                                    <label for="lead">Lead Gen:</label>
                                                    <input type='text' id='lead' name='lead' value="<?php echo $data2["lead"]; ?>" class="form-control" readonly style="width: 200px">
                                                </p>

                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>    
    </div>
<?php if(isset($data2["insurer"]) && $data2["insurer"]=='Legal and General') { ?>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Email Policy Number <i>(My Account email follow-up)</i></h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Emails/"; } elseif($COMPANY_ENTITY=='First Priority Group') { echo "Emails/"; } else { echo "Emails/TRB"; } ?>SendPolicyNumber.php?search=<?php echo $search; ?>&insurer=<?php echo $data2["insurer"]; ?>&recipient=<?php echo $data2['client_name']; ?>&policy=<?php echo $data2['policy_number']; ?>">


                        <select class="form-control" name="email">  
                            <option value="<?php echo $data3['email']; ?>"><?php echo $data3['email']; ?></option>
                            <?php if (!empty($data3['email2'])) { ?>
                                <option value="<?php echo $data3['email2']; ?>"><?php echo $data3['email2']; ?></option>
<?php } ?>
                        </select>  

                        <p>Dear <?php echo $data2['client_name']; ?>,</p>
                        <p>           
                            Following our recent phone conversation I have resent the 'My Account' email so you can create your personal online account with Legal and General. 
                            In order to do this you'll need the policy number which is: <strong><?php echo $data2["policy_number"] ?></strong>. </p>

                        <p>
                            Once this has been completed you'll be able to access all the policy information, terms and conditions as well as the 'Check Your Details' form. 
                            Please could you complete this section at your earliest convenience.
                        </p>
                        <p>If you require any further information please call our customer care team on <strong>[COMPANY TEL]</strong> Monday - Friday between the hours of 10am- 6:30pm.</p>

                        Kind regards,<br>
<?php echo $hello_name_full; ?>
                        </p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success confirmation"><i class="fa fa-envelope-o fa-fw"></i>&nbsp; Send Policy Number</button></form>
                </div>
            </div>

        </div>
    </div>
<?php } ?>
    <div id="myModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Email uncontactable client</h4>
                </div>
                <div class="modal-body">
                    
                    <form action="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect' || $WHICH_COMPANY=='Vitality') { echo "Emails/"; } elseif($COMPANY_ENTITY=='First Priority Group') { echo "Emails/"; } else { echo "Emails/TRB"; } ?>SendUncontactable.php?EXECUTE=1&search=<?php echo $search; ?>&insurer=<?php echo $data2["insurer"]; ?>&recipient=<?php echo $data2['client_name']; ?>&policy=<?php echo $data2['policy_number']; ?>" method="POST">                         
                        <select class="form-control" name="email">  
                            <option value="<?php echo $data3['email']; ?>"><?php echo $data3['email']; ?></option>
                            <?php if (!empty($data3['email2'])) { ?>
                                <option value="<?php echo $data3['email2']; ?>"><?php echo $data3['email2']; ?></option>
<?php } ?>
                        </select>  
                        <p>Dear <?php echo $data2['client_name']; ?>,</p>
                        <p>           
                            There is an issue with your <strong><?php if(isset($data2["insurer"])) { echo $data2["insurer"]; } ?></strong> direct debit <strong><?php echo $data2["policy_number"] ?></strong>. </p>

                        <p>
                            We have tried contacting you on numerous occasions but have been unsuccessful, It is very important we speak to you.
                        </p>
                        <p>Please contact us on <strong>[COMPANY_TEL]</strong> or email us back with a preferred contact time and number for us to call you. Office hours are between Monday to Friday 10:00 - 18:30.</p>
                        Many thanks,<br>
<?php echo $hello_name_full; ?><br>
                        <strong>[COMPANY_NAME]</strong>
                        </p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success confirmation"><i class="fa fa-envelope-o fa-fw"></i>&nbsp; Send uncontactable email</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div id="myModal3" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Email Awaiting uncontactable client</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect' || $WHICH_COMPANY=='Vitality') { echo "Emails/"; } elseif($COMPANY_ENTITY=='First Priority Group') { echo "Emails/"; } else { echo "Emails/TRB"; } ?>SendUncontactable.php?EXECUTE=2&search=<?php echo $search; ?>&insurer=<?php echo $data2["insurer"]; ?>&recipient=<?php echo $data2['client_name']; ?>&policy=<?php echo $data2['policy_number']; ?>" method="POST">                         
                        <select class="form-control" name="email">  
                            <option value="<?php echo $data3['email']; ?>"><?php echo $data3['email']; ?></option>
                            <?php if (!empty($data3['email2'])) { ?>
                                <option value="<?php echo $data3['email2']; ?>"><?php echo $data3['email2']; ?></option>
<?php } ?>
                        </select>  
                        <p>Dear <?php echo $data2['client_name']; ?>,</p>
                        <p>           
                            There is an issue with your <strong><?php if(isset($data2["insurer"])) { echo $data2["insurer"]; } ?></strong> life insurance application. </p>

                        <p>
                            We have tried contacting you on numerous occasions but have been unsuccessful, It is very important we speak to you.
                        </p>
                        <p>Please contact us on <strong>[COMPANY_TEL]</strong> or email us back with a preferred contact time and number for us to call you. Office hours are between Monday to Friday 10:00 - 18:30.</p>
                        Many thanks,<br>
<?php echo $hello_name_full; ?><br>
        <strong>[COMPANY_NAME]</strong>
                        </p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success confirmation"><i class="fa fa-envelope-o fa-fw"></i>&nbsp; Send Awaiting uncontactable email</button>
                    </form>
                </div>
            </div>

        </div>
    </div>    
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script>var maxLength = 800;
        $('textarea').keyup(function () {
            var length = $(this).val().length;
            var length = maxLength - length;
            $('#chars').text(length);
        });</script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
                                text: 'EWS updated!',
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
    <script src="/resources/lib/sweet-alert/sweet-alert.min.js"></script>
    <script type="text/javascript">
        var elems = document.getElementsByClassName('confirmation');
        var confirmIt = function (e) {
            if (!confirm('Are you sure you want to send this email? The email will be immediately sent.'))
                e.preventDefault();
        };
        for (var i = 0, l = elems.length; i < l; i++) {
            elems[i].addEventListener('click', confirmIt, false);
        }
    </script>
</body>
</html>
