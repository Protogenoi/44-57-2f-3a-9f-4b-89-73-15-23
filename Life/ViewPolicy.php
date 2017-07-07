<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=1;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
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

if (isset($hello_name)) {

    if ($companynamere == 'Bluestone Protect') {

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
            case "Rhibayliss":
                $hello_name_full = "Rhiannon Bayliss";
                break;
            case "Abbiek":
                $hello_name_full = "Abbie Kenyon";
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
            case "Amy":
                $hello_name_full = "Amy Clayfield";
                break;
            case "Mike":
                $hello_name_full = "Michael Lloyd";
                break;
            default:
                $hello_name_full = $hello_name;
        }
    }

    if ($companynamere == 'ADL_CUS') {
        switch ($hello_name) {
            case "Michael":
                $hello_name_full = "Michael Owen";
                break;
            case "Dean":
                $hello_name_full = "Dean Howell";
                break;
            case "Helen":
                $hello_name_full = "Helen Hinder";
                break;
            case "Andrew":
                $hello_name_full = "Andrew Collier";
                break;
            case "David":
                $hello_name_full = "David Govier";
                break;
            default:
                $hello_name_full = $hello_name;
        }
    }
}

    $WHICH_COMPANY = filter_input(INPUT_GET, 'WHICH_COMPANY', FILTER_SANITIZE_SPECIAL_CHARS);
    $policyID = filter_input(INPUT_GET, 'policyID', FILTER_SANITIZE_NUMBER_INT);
    $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);

    $query = $pdo->prepare("SELECT id, polterm, client_name, sale_date, application_number, policy_number, premium, type, insurer, submitted_by, commission, CommissionType, policystatus, submitted_date, edited, date_edited, drip, comm_term, soj, closer, lead, covera FROM client_policy WHERE id =:PID and client_id=:CID");
    $query->bindParam(':PID', $policyID, PDO::PARAM_INT);
    $query->bindParam(':CID', $search, PDO::PARAM_INT);
    $query->execute();
    $data2 = $query->fetch(PDO::FETCH_ASSOC);

    $query2 = $pdo->prepare("SELECT email, email2 FROM client_details WHERE client_id=:CID");
    $query2->bindParam(':CID', $search, PDO::PARAM_INT);
    $query2->execute();
    $data3 = $query2->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | View Policy</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/styles/sweet-alert.min.css" />
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <style type="text/css">
        .policyview{
            margin: 20px;
        }
    </style>
</head>
<body>

    <?php require_once(__DIR__ . '/../includes/navbar.php'); ?>
    
    <div class="container">
        
         <?php require_once(__DIR__ . '/../includes/user_tracking.php');  ?>
        
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
                        if ($companynamere == 'Bluestone Protect' || $companynamere == 'ADL_CUS') {
                            if (in_array($hello_name, $Level_8_Access, true)) {


                                $polid = $data2['id'];
                                $policy_number = $data2["policy_number"];
                                $clientname = $data2['client_name'];

                                $ews_stuff = $pdo->prepare("SELECT
ews_data.policy_number
, ews_data.id
, ews_data.warning
, ews_data.ournotes
, ews_data.date_added
, ews_data.ews_status_status
, ews_data.client_name
, ews_data.color_status
	FROM ews_data
	LEFT JOIN client_policy 
	ON ews_data.policy_number=client_policy.policy_number
	WHERE ews_data.policy_number=:policy AND client_policy.id=:polid");
                                $ews_stuff->bindParam(':policy', $policy_number, PDO::PARAM_STR, 12);
                                $ews_stuff->bindParam(':polid', $polid, PDO::PARAM_STR, 12);
                                $ews_stuff->execute();
                                $ewsresult = $ews_stuff->fetch(PDO::FETCH_ASSOC);

                                $color_status = $ewsresult['color_status'];
                                $warning = $ewsresult['warning'];
                                $ournotes = $ewsresult['ournotes'];
                                $ews_status_status = $ewsresult['ews_status_status'];
                                ?>

                                <form action="php/EWSUpdate.php?EXECUTE=1" method="POST" id="from1" autocomplete="off" class="form-horizontal">

                                    <input type='hidden' name='client_id' value='<?php echo $search; ?>'>
                                    <input type='hidden' name='policy_number' value='<?php echo $policy_number; ?>'>
                                    <input type='hidden' name='client_name' value='<?php echo $clientname; ?>'>


                                    <fieldset>

                                        <legend>Update EWS</legend>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="warning">Current Status</label>  
                                            <div class="col-md-4">
                                                <input id="warning" name="warning" class="form-control input-md" type="text" value='<?php echo $warning; ?>' readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="status">New Status</label>
                                            <div class="col-md-4">
                                                <select id="status" name="status" class="form-control" required>
                                                    <option value="<?php echo $ews_status_status; ?>"><?php echo $ews_status_status; ?></option>
                                                    <option value="RE-INSTATED">RE-INSTATED</option>
                                                    <option value="WILL CANCEL">WILL CANCEL</option>
                                                    <option value="REDRAWN">REDRAWN</option>
                                                    <option value="WILL REDRAW">WILL REDRAW</option>
                                                    <option value="CANCELLED">CANCELLED</option>
                                                    <option value="FUTURE CALLBACK">Future Callback</option>
                                                </select>
                                            </div>
                                        </div>

                                        <?php
                                        switch ($color_status) {
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
                                            <label class="col-md-4 control-label" for="selectbasic">Set Colour</label>
                                            <div class="col-md-4">
                                                <select id="colour" name="colour" class="form-control" required>
                                                    <option <?php
                                                    if (isset($color_status)) {
                                                        echo $SELECT_COLOR;
                                                    }
                                                    ?> value="<?php
                                                        if (isset($color_status)) {
                                                            echo $color_status;
                                                        }
                                                        ?>" ><?php
                                                            if (isset($color_status)) {
                                                                echo $color_status;
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
                                            <label class="col-md-4 control-label" for="textarea">Notes</label>
                                            <div class="col-md-4">                     
                                                <textarea class="form-control" id="textarea" name="notes" maxlength="800" placeholder="800 CHARS Max"><?php echo $ournotes; ?></textarea>
                                                <span id="chars">800</span> characters remaining
                                            </div>
                                        </div>

                                    <?php } if (in_array($hello_name, $Level_3_Access, true)) { ?>

                                        <center>

                                            <div class="form-group">
                                                <div class="col-md-10">
                                                    <?php if (in_array($hello_name, $Level_3_Access, true)) { ?>
                                                        <button id="button1id" name="button1id" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Update</button>
                                                    <?php } ?>
                                                    <a href="ViewClient.php?search=<?php echo $search; ?>" class="btn btn-warning "><i class="fa fa-arrow-circle-o-left"></i> Back</a>
                                                    <a href="EditPolicy.php?id=<?php echo $policyID; ?>&search=<?php echo $search; ?>" class="btn btn-warning "><i class="fa fa-edit"></i> Edit Policy</a>
                                                    <br><br>
                                                </div>
                                            </div>

                                        </center>
                                    </fieldset>

                                </form>
                                <?php
                            }
                        }

                        if ($companynamere != 'Bluestone Protect') {
                            if ($companynamere != 'ADL_CUS') {

                                $polid = $data2['id'];
                                $policy_number = $data2["policy_number"];
                                $clientname = $data2['client_name'];

                                $ews_stuff = $pdo->prepare("SELECT
ews_data.policy_number
, ews_data.id
, ews_data.warning
, ews_data.ournotes
, ews_data.date_added
, ews_data.ews_status_status
, ews_data.client_name
, ews_data.color_status
	FROM ews_data
	LEFT JOIN client_policy 
	ON ews_data.policy_number=client_policy.policy_number
	WHERE ews_data.policy_number=:policy AND client_policy.id=:polid");
                                $ews_stuff->bindParam(':policy', $policy_number, PDO::PARAM_STR, 12);
                                $ews_stuff->bindParam(':polid', $polid, PDO::PARAM_STR, 12);
                                $ews_stuff->execute();
                                $ewsresult = $ews_stuff->fetch(PDO::FETCH_ASSOC);


                                $warning = $ewsresult['warning'];
                                $ournotes = $ewsresult['ournotes'];
                                $ews_status_status = $ewsresult['ews_status_status'];
                                ?>

                                <form action="php/EWSUpdate.php?EXECUTE=1" method="POST" id="from1" autocomplete="off" class="form-horizontal">

                                    <input type='hidden' name='client_id' value='<?php echo $search; ?>'>
                                    <input type='hidden' name='policy_number' value='<?php echo $policy_number; ?>'>
                                    <input type='hidden' name='client_name' value='<?php echo $clientname; ?>'>


                                    <fieldset>

                                        <legend>Update EWS</legend>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="warning">Current Status</label>  
                                            <div class="col-md-4">
                                                <input id="warning" name="warning" class="form-control input-md" type="text" value='<?php echo $warning; ?>' readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="status">New Status</label>
                                            <div class="col-md-4">
                                                <select id="status" name="status" class="form-control" required>
                                                    <option value="<?php echo $ews_status_status; ?>"><?php echo $ews_status_status; ?></option>
                                                    <option value="RE-INSTATED">RE-INSTATED</option>
                                                    <option value="WILL CANCEL">WILL CANCEL</option>
                                                    <option value="REDRAWN">REDRAWN</option>
                                                    <option value="WILL REDRAW">WILL REDRAW</option>
                                                    <option value="CANCELLED">CANCELLED</option>
                                                    <option value="FUTURE CALLBACK">Future Callback</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="selectbasic">Set Colour</label>
                                            <div class="col-md-4">
                                                <select id="colour" name="colour" class="form-control" required>
                                                    <option value="" ></option>
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
                                            <label class="col-md-4 control-label" for="textarea">Notes</label>
                                            <div class="col-md-4">                     
                                                <textarea class="form-control" id="textarea" name="notes" maxlength="800" placeholder="800 CHARS Max"><?php echo $ournotes; ?></textarea>
                                                <span id="chars">800</span> characters remaining
                                            </div>
                                        </div>

                                        <center>

                                            <div class="form-group">
                                                <div class="col-md-10">
                                                    <button id="button1id" name="button1id" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Update</button>
                                                    <a href="ViewClient.php?search=<?php echo $search; ?>" class="btn btn-warning "><i class="fa fa-arrow-circle-o-left"></i> Back</a>
                                                    <a href="EditPolicy.php?policyID=<?php echo $policyID; ?>" class="btn btn-warning "><i class="fa fa-edit"></i> Edit Policy</a>
                                                </div>
                                            </div>


                                        </center>
                                    </fieldset>

                                </form>
                            <?php
                            }
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
                                    <a class="list-group-item" data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i>&nbsp; Send Policy Number</a>
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
                                <div class="form-row">
                                    <label for="commission">Commission</label>
                                    <div class="input-group"> 
                                        <span class="input-group-addon">£</span>
                                        <input style="width: 170px" type="number" value="<?php echo $data2['commission']; ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" class="form-control" readonly style="width: 200px"/>
                                    </div> 
                                    </p>

                                    <p>
                                    <div class="form-row">
                                        <label for="covera">Cover Amount</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input style="width: 170px" type="number" value="<?php echo $data2['covera']; ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="covera" class="form-control" readonly style="width: 200px"/>
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
                                                <label for="CommissionType">Commission Type</label>
                                                <input type="text" value="<?php echo $data2["CommissionType"]; ?>" class="form-control" readonly style="width: 200px">
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

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Email Policy Number <i>(My Account email follow-up)</i></h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Emails"; } else { echo "/email/php"; } ?>/SendPolicyNumber.php?search=<?php echo $search; ?>&insurer=<?php echo $data2["insurer"]; ?>&recipient=<?php echo $data2['client_name']; ?>&policy=<?php echo $data2['policy_number']; ?>">


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
    <div id="myModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Email uncontactable client</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Emails"; } else { echo "/email/php"; } ?>/SendUncontactable.php?EXECUTE=1&search=<?php echo $search; ?>&insurer=<?php echo $data2["insurer"]; ?>&recipient=<?php echo $data2['client_name']; ?>&policy=<?php echo $data2['policy_number']; ?>" method="POST">                         
                        <select class="form-control" name="email">  
                            <option value="<?php echo $data3['email']; ?>"><?php echo $data3['email']; ?></option>
                            <?php if (!empty($data3['email2'])) { ?>
                                <option value="<?php echo $data3['email2']; ?>"><?php echo $data3['email2']; ?></option>
<?php } ?>
                        </select>  
                        <p>Dear <?php echo $data2['client_name']; ?>,</p>
                        <p>           
                            There is an issue with your <strong>[INSURER]</strong> direct debit <strong><?php echo $data2["policy_number"] ?></strong>. </p>

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
                    <form action="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Emails"; } else { echo "/email/php"; } ?>/SendUncontactable.php?EXECUTE=2&search=<?php echo $search; ?>&insurer=<?php echo $data2["insurer"]; ?>&recipient=<?php echo $data2['client_name']; ?>&policy=<?php echo $data2['policy_number']; ?>" method="POST">                         
                        <select class="form-control" name="email">  
                            <option value="<?php echo $data3['email']; ?>"><?php echo $data3['email']; ?></option>
                            <?php if (!empty($data3['email2'])) { ?>
                                <option value="<?php echo $data3['email2']; ?>"><?php echo $data3['email2']; ?></option>
<?php } ?>
                        </select>  
                        <p>Dear <?php echo $data2['client_name']; ?>,</p>
                        <p>           
                            There is an issue with your <strong>[INSURER]</strong> life insurance application. </p>

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
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
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
    <script src="/js/sweet-alert.min.js"></script>
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
