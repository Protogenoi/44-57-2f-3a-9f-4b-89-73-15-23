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
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=1;

require_once(__DIR__ . '/../../includes/adl_features.php');

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

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
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
        
        require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');
        
        $ADL_PAGE_TITLE = "Edit Policy";
        require_once(__DIR__ . '/../../app/core/head.php'); 
        
        ?> 
    <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
    <link rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
    <link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css">   
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 

</head>
<body>

    <?php
    require_once(__DIR__ . '/../../includes/navbar.php');

        $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $POST_NAME = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS);


    if (isset($search)) {

    $tracking_search= "%search=$search%";
}

    $query = $pdo->prepare("SELECT sic_cover_amount, non_indem_com, client_policy.extra_charge, CONCAT(client_details.title, ' ',client_details.first_name,' ',client_details.last_name) AS NAME, CONCAT(client_details.title2, ' ',client_details.first_name2,' ',client_details.last_name2) AS NAME2, client_policy.client_id, client_policy.id, client_policy.polterm, client_policy.client_name AS POL_NAME, client_policy.sale_date, client_policy.application_number, client_policy.policy_number, client_policy.premium, client_policy.type, client_policy.insurer, client_policy.submitted_by, client_policy.commission, client_policy.CommissionType, client_policy.policystatus, client_policy.submitted_date, client_policy.edited, client_policy.date_edited, client_policy.drip, client_policy.comm_term, client_policy.soj, client_policy.closer, client_policy.lead, client_policy.covera FROM client_policy JOIN client_details on client_details.client_id = client_policy.client_id WHERE client_policy.id =:search");
    $query->bindParam(':search', $id, PDO::PARAM_INT);
    $query->execute();
    $data2 = $query->fetch(PDO::FETCH_ASSOC);

    $NAME = $data2['NAME'];
    $NAME2 = $data2['NAME2'];
    $NAME3 = $data2['NAME'] ." and ". $data2['NAME2'];
    $SOJ=$data2['soj'];
    
if(empty($POST_NAME)) {
        $POST_NAME=$data2['POL_NAME'];
        unset($NAME2);
    }    
   
    ?>
    <div class="container">
        <?php require_once(__DIR__ . '/../../includes/user_tracking.php');  ?>
        <div class="editpolicy">
            <div class="notice notice-warning">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Warning!</strong> You are now editing <?php echo $data2['POL_NAME']; ?>'s Policy .
            </div>

            <div class="panel-group">
                <div class="panel panel-primary">
                    <div class="panel-heading">Edit Policy</div>
                    <div class="panel-body">

                        <form id="from1" id="form1" class="AddClient" method="post" action="/addon/Life/php/EditPolicy.php">
                            <input type="hidden" name="NAME1" value="<?php echo $NAME; ?>">

                            <input type="hidden" name="NAME2" value="<?php if(isset($NAME2)) { echo $NAME2; } ?>">
                            <input type="hidden" name="NAME3" value="<?php echo $NAME3; ?>">
                            <input  class="form-control"type="hidden" name="keyfield" value="<?php echo $search ?>">
                            <input  class="form-control"type="hidden" name="policyID" value="<?php echo $data2['policy_number'] ?>">
                            <input  class="form-control"type="hidden" name="policyunid" value="<?php echo $data2['id'] ?>"> 
                            <input  class="form-control"type="hidden" name="search" value="<?php echo $search ?>">

                            <div class="col-md-4">

                                <div class="alert alert-info"><strong>Client Name:</strong> 
                                    Naming one person will create a single policy. Naming two person's will create a joint policy. <br><br> 
                                    <select class="form-control" name="client_name" id="client_name" style="width: 170px" required>
                                        <?php if (isset($POST_NAME)) {  ?>
                                        <option value="<?php echo $NAME; ?>" <?php if($POST_NAME == $NAME) { echo "selected"; }  ?> ><?php echo $NAME ?></option>
                                        
                                        <?php if (!empty($NAME2)) { ?>
                                        
                                        <option value="<?php echo $NAME2; ?>" <?php if($POST_NAME == $NAME2) { echo "selected"; } ?> ><?php echo $NAME2; ?></option>   
                                        <option value="<?php echo $NAME3; ?>" <?php if($SOJ == 'Joint') { echo "selected"; } ?> ><?php echo $NAME3; ?></option>  
                                        
                                            <?php
                                            
                                        } }
                                        ?>
                                        
                                    </select>

                                </div>   

                                <div class="alert alert-info"><strong>Policy Number:</strong> 
                                    For Awaiting polices, a unique ID is generated. <br><br>  <input  class="form-control"type="text" id="policy_number" name="policy_number" value="<?php echo $data2["policy_number"] ?>" <?php
                                    if ($data2['insurer'] == 'Legal and General') {
                                        echo "maxlength='10'";
                                    }
                                    ?> class="form-control" style="width: 170px" required>


                                </div>                                   
<?php

$AN_NUMBER_ARRAY=array("Legal and General","Zurich","Scottish Widows","LV");

?>
                                <div class="alert alert-info"><strong>Application Number:</strong> 
                                            <?php if (isset($data2["insurer"])) {
                                                if ($data2["insurer"] == 'Legal and General') {
                                                    ?> <span class="help-block">For L&G Direct use LG Direct</span>  <?php
                                                }
                                            }
                                            if (isset($data2["insurer"])) {
                                                if (!in_array($data2['insurer'],$AN_NUMBER_ARRAY)) {
                                                    ?>
                                            <p>
                                            <div class="form-group">
                                                <select class="form-control" name="application_number" id="application_number" style="width: 170px" required>
                                                    <option <?php
                                                    if ($data2['application_number'] == 'One Family') {
                                                        echo "selected";
                                                    } else {
                                                        if ($data2['insurer'] == 'One Family') {
                                                            echo "selected";
                                                        }
                                                    }
                                                    ?> value="One Family">One Family</option>                                                  
                                                    <option <?php
                                                    if ($data2['application_number'] == 'Royal London') {
                                                        echo "selected";
                                                    } else {
                                                        if ($data2['insurer'] == 'Royal London') {
                                                            echo "selected";
                                                        }
                                                    }
                                                    ?> value="Royal London">Royal London</option>
                                                    <option <?php
                                                    if ($data2['application_number'] == 'Vitality') {
                                                        echo "selected";
                                                    } else {
                                                        if ($data2['insurer'] == 'Vitality') {
                                                            echo "selected";
                                                        }
                                                    }
                                                    ?> value="Vitality">Vitality</option>
                                                    <option <?php
                                            if ($data2['application_number'] == 'Aviva') {
                                                echo "selected";
                                            } else {
                                                if ($data2['insurer'] == 'Aviva') {
                                                    echo "selected";
                                                }
                                            }
                                            ?> value="Aviva">Aviva</option>
                                                </select>
                                            </div>
                                            </p>
        <?php
    }

    if (in_array($data2['insurer'],$AN_NUMBER_ARRAY)) {
        ?>

                                            <input  class="form-control"type="text" id="application_number" name="application_number" value="<?php echo $data2["application_number"] ?>" class="form-control" style="width: 170px" required>

        <?php
    }
}
?>


                                </div>    



                                <p>
                                <div class="form-group">
                                    <label for="type">Type:</label>
                                    <select class="form-control" name="type" id="type" style="width: 170px" required>
                                        <option value="<?php echo $data2["type"]; ?>"><?php echo $data2["type"]; ?></option>
                                        <option value="LTA">LTA</option>
                                        <option value="LTA SIC">LTA SIC (Vitality)</option>
                                        <option value="DTA SIC">DTA SIC (Vitality)</option>
                                        <option value="VITALITY WOL">Whole of Life (Vitality)</option>
                                        <option value="LTA CIC">LTA + CIC</option>
                                        <option value="DTA">DTA</option>
                                        <option value="DTA CIC">DTA + CIC</option>
                                        <option value="CIC">CIC</option>
                                        <option value="FPIP">FPIP</option>
                                        <option value="Income Protection">Income Protection</option>
                                        <option value="WOL">WOL (One Family)</option>
                                    </select>
                                </div>
                                </p>

                                <p>
                                <div class="form-group">
                                    <label for="insurer">Insurer:</label>
                                    <select class="form-control" name="insurer" id="insurer" style="width: 170px" required>
                                        <option <?php
                                            if ($data2["insurer"] == 'Aegon') {
                                                echo "selected";
                                            }
                                            ?> value="Aegon">Aegon</option>                                        
                                        <option <?php
                                            if ($data2["insurer"] == 'One Family') {
                                                echo "selected";
                                            }
                                            ?> value="One Family">One Family</option>
                                        <option <?php
                                            if ($data2["insurer"] == 'Royal London') {
                                                echo "selected";
                                            }
                                            ?> value="Royal London">Royal London</option>
                                        <option <?php
                                            if ($data2["insurer"] == 'LV') {
                                                echo "selected";
                                            }
                                            ?> value="LV">LV</option>                                        
                                                                               <option <?php
                                            if ($data2["insurer"] == 'Zurich') {
                                                echo "selected";
                                            }
                                            ?> value="Zurich">Zurich</option>
                                        <option <?php
                                            if ($data2["insurer"] == 'Scottish Widows') {
                                                echo "selected";
                                            }
                                            ?> value="Scottish Widows">Scottish Widows</option>                                                                              
                                        <option <?php
                                            if ($data2["insurer"] == 'Legal and General') {
                                                echo "selected";
                                            }
                                            ?> value="Legal and General">Legal & General</option>
                                        <option <?php
                                            if ($data2["insurer"] == 'Vitality') {
                                                echo "selected";
                                            }
                                            ?> value="Vitality">Vitality</option>
                                        <option <?php
                                            if ($data2["insurer"] == 'Bright Grey') {
                                                echo "selected";
                                            }
                                            ?> value="Bright Grey">Bright Grey</option>
                                        <option <?php
                                            if ($data2["insurer"] == 'Aviva') {
                                                echo "selected";
                                            }
                                            ?> value="Aviva">Aviva</option>
                                    </select>
                                </div>
                                </p>
                            </div>

                            <div class="col-md-4">
                                <p>
                                <div class="form-row">
                                    <label for="premium">Premium:</label>
                                    <div class="input-group"> 
                                        <span class="input-group-addon">£</span>
                                        <input  class="form-control currency"style="width: 140px" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" type="number" value="<?php echo $data2['premium'] ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" />
                                    </div> 
                                </div>
                                </p>
                                
                                <p>
                                <div class="form-row">
                                    <label for="EXTRA_CHARGE">Extra Charges:</label>
                                    <div class="input-group"> 
                                        <span class="input-group-addon">£</span>
                                        <input  class="form-control currency"style="width: 140px" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" type="number" value="<?php if(isset($data2['extra_charge'])) { echo $data2['extra_charge']; } else { echo 0; }  ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="EXTRA_CHARGE" name="EXTRA_CHARGE" />
                                    </div> 
                                </div>
                                </p>  
                                
                                     <p>
                                    <div class="form-group">
                                        <label for="CommissionType">Comms:</label>
                                        <select class="form-control" name="CommissionType" id="CommissionType" style="width: 170px" required>
                                            <option <?php
                                                if ($data2["CommissionType"] == 'Indemnity') {
                                                    echo "selected";
                                                }
                                                ?> value="Indemnity">Indemnity</option>
                                            <option <?php
                                                if ($data2["CommissionType"] == 'Non Idenmity') {
                                                    echo "selected";
                                                }
                                                ?> value="Non Idenmity">Non-Idemnity</option>
                                            <option <?php
                                                if ($data2["CommissionType"] == 'NA') {
                                                    echo "selected";
                                                }
                                                ?> value="NA">N/A</option>
                                        </select>
                                    </div>
                                    </p>                               

<?php if (in_array($hello_name, $Level_10_Access, true) || $hello_name == "Tina" || $hello_name="carys") { ?>
                                    <p>
                                    <div class="form-row">
                                        <label for="covera">Commission</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input  class="form-control currency"style="width: 140px" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" type="number" value="<?php echo $data2['commission'] ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" />
                                        </div>
                                    </div>

                                    </p>

                                    <p>
                                    <div class="form-row">
                                        <label for="NonIdem">Non-Idem Comm</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input  class="form-control currency"style="width: 140px" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" type="number" value="<?php if(isset($data2['non_indem_com'])) { echo $data2['non_indem_com']; } else { echo 0; } ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="NonIdem" name="NonIdem" />
                                        </div>
                                    </div>

                                    </p>                                    
                                    
<?php } else { ?>
                                    <p>
                                    <div class="form-row">
                                        <div class="alert alert-info"><strong>Commission: See an authorised person to update the amount</strong><br>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input  class="form-control currency" style="width: 140px" min="0" type="text" readonly="true" value="<?php echo $data2['commission'] ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" />
                                            </div>
                                        </div>  
                                    </div>
                                    </p>
                                    
                                    <p>
                                    <div class="form-row">
                                        <div class="alert alert-info"><strong>Commission: See an authorised person to update the amount</strong><br>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input  class="form-control currency" style="width: 140px" min="0" type="text" readonly="true" value="<?php echo $data2['non_indem_com'] ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="NonIdem" name="NonIdem" />
                                            </div>
                                        </div>  
                                    </div>
                                    </p>                                    
<?php } ?>
                                <p>
                                <div class="form-row">
                                    <label for="covera">Cover Amount</label>
                                    <div class="input-group"> 
                                        <span class="input-group-addon">£</span>
                                        <input  class="form-control currency"style="width: 140px" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" type="number" value="<?php echo $data2['covera'] ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="covera" />
                                    </div> 
                                    </p>
                                    
                                <p>
                                    <label for="SIC_COVER_AMOUNT">SIC Cover Amount</label>
                                    <div class="input-group"> 
                                        <span class="input-group-addon">£</span>
                                        <input  class="form-control currency"style="width: 140px" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" type="number" value="<?php if(isset($data2['sic_cover_amount'])) { echo $data2['sic_cover_amount']; } else { echo 0; } ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="SIC_COVER_AMOUNT" name="SIC_COVER_AMOUNT" />
                                    </div> 
                                    </p>                                    

                                    <p>
                                    <div class="form-row">
                                        <label for="polterm">Policy Term</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">yrs</span>
<?php if ($data2['insurer'] == 'One Family') { ?>
                                                <input style="width: 125px" type="text" class="form-control" id="polterm" name="polterm" value="WOL" placeholder="WOL">
                                            <?php } else { ?>
                                                <input style="width: 125px" type="text" class="form-control" id="polterm" name="polterm" value="<?php echo $data2['polterm'] ?>" required/>
                                            <?php } ?>
                                        </div> 
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-group">
                                        <label for="comm_term">Clawback Term:</label>
                                        <select class="form-control" name="comm_term" id="comm_term" style="width: 170px" required>
                                            <option value="<?php echo $data2["comm_term"]; ?>"><?php echo $data2["comm_term"]; ?></option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '1 year') {
                                                    echo "selected";
                                                }
                                                ?> value="1 year">1 year</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '2 year') {
                                                    echo "selected";
                                                }
                                                ?> value="2 year">2 year</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '3 year') {
                                                    echo "selected";
                                                }
                                                ?> value="3 year">3 year</option>
                                            <option <?php
                                            if (isset($data2["comm_term"]) && $data2['comm_term'] == '4 year') {
                                                echo "selected";
                                            }
                                            ?> value="4 year">4 year</option>
                                            <option <?php
                                            if (isset($data2["comm_term"]) && $data2['comm_term'] == '5 year') {
                                                echo "selected";
                                            }
                                            ?> value="5 year">5 year</option>
                                            <option <?php
                                            if ($data2["insurer"] == 'One Family') {
                                                echo "selected";
                                            } else {
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '0') {
                                                    echo "selected";
                                                }
                                            }
                                            ?> value="0">0</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '12') {
                                                    echo "selected";
                                                }
                                                ?> value="12">12</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '22') {
                                                    echo "selected";
                                                }
                                                ?> value="22">22</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '23') {
                                                    echo "selected";
                                                }
                                                ?> value="23">23</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '24') {
                                                    echo "selected";
                                                }
                                                ?> value="24">24</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '25') {
                                                    echo "selected";
                                                }
                                                ?> value="25">25</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '26') {
                                                    echo "selected";
                                                }
                                                ?> value="26">26</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '27') {
                                                    echo "selected";
                                                }
                                                ?> value="27">27</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '28') {
                                                    echo "selected";
                                                }
                                                ?> value="28">28</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '29') {
                                                    echo "selected";
                                                }
                                                ?> value="29">29</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '30') {
                                                    echo "selected";
                                                }
                                                ?> value="30">30</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '31') {
                                                    echo "selected";
                                                }
                                                ?> value="31">31</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '32') {
                                                    echo "selected";
                                                }
                                                ?> value="32">32</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '33') {
                                                    echo "selected";
                                                }
                                                ?> value="33">33</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '34') {
                                                    echo "selected";
                                                }
                                                ?> value="34">34</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '35') {
                                                    echo "selected";
                                                }
                                                ?> value="35">35</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '36') {
                                                    echo "selected";
                                                }
                                                ?> value="36">36</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '37') {
                                                    echo "selected";
                                                }
                                                ?> value="37">37</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '38') {
                                                    echo "selected";
                                                }
                                                ?> value="38">38</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '39') {
                                                    echo "selected";
                                                }
                                                ?> value="39">39</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '40') {
                                                    echo "selected";
                                                }
                                                ?> value="40">40</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '41') {
                                                    echo "selected";
                                                }
                                                ?> value="41">41</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '42') {
                                                    echo "selected";
                                                }
                                                ?> value="42">42</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '43') {
                                                    echo "selected";
                                                }
                                                ?> value="43">43</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '44') {
                                                    echo "selected";
                                                }
                                                ?> value="44">44</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '45') {
                                                    echo "selected";
                                                }
                                                ?> value="45">45</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '46') {
                                                    echo "selected";
                                                }
                                                ?> value="46">46</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '47') {
                                                    echo "selected";
                                                }
                                                ?> value="47">47</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '48') {
                                                    echo "selected";
                                                }
                                                ?> value="48">48</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '49') {
                                                    echo "selected";
                                                }
                                                ?> value="49">49</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '50') {
                                                    echo "selected";
                                                }
                                                ?> value="50">50</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '51') {
                                                    echo "selected";
                                                }
                                                ?> value="51">51</option>
                                            <option <?php
                                                if (isset($data2["comm_term"]) && $data2['comm_term'] == '52') {
                                                    echo "selected";
                                                }
                                                ?> value="52">52</option>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-row">
                                        <label for="commission">Drip</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input  class="form-control currency"style="width: 140px" type="number" value="<?php echo $data2["drip"] ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" required/>
                                        </div> 
                                        </p>


                                    </div>



                                    <label for="closer">Closer:</label>
                                    <input type='text' id='closer' name='closer' style="width: 140px" value="<?php echo $data2["closer"]; ?>" required>
                                    <script>var options = {
                                            url: "/../../app/JSON/Closers.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                                            getValue: "full_name",
                                            list: {
                                                match: {
                                                    enabled: true
                                                }
                                            }
                                        };

                                        $("#closer").easyAutocomplete(options);</script>

                                    <label for="lead">Lead Gen:</label>
                                    <input type='text' id='lead' name='lead' style="width: 140px" value="<?php echo $data2["lead"]; ?>" required>
                                    <script>var options = {
                                            url: "/../../app/JSON/Closers.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                                            getValue: "full_name",
                                            list: {
                                                match: {
                                                    enabled: true
                                                }
                                            }
                                        };

                                        $("#lead").easyAutocomplete(options);</script>

                                </div>

                            </div>

                            <div class="col-md-4">


                                <div class="alert alert-info"><strong>Sale Date:</strong> 
                                    This is the sale date on the dealsheet. <br><br>  <input  class="form-control"type="text" id="submitted_date" name="submitted_date" value="<?php echo $data2["submitted_date"]; ?>" class="form-control" style="width: 170px" required>


                                </div>   


                                <div class="alert alert-info"><strong>Submitted Date:</strong> 
                                    This is the policy live date on the insurers portal. <br> <br>  <input  class="form-control"type="text" id="sale_date" name="sale_date" value="<?php
                                                                                                            if ($data2['policystatus'] == 'Awaiting') {
                                                                                                                echo "TBC";
                                                                                                            } else {
                                                                                                                echo $data2["sale_date"];
                                                                                                            }
                                                ?>" class="form-control" style="width: 170px" required>
                                </div>                              
                                <div class="alert alert-info"><strong>Policy Status:</strong> 
                                    For any policy where the submitted date is unknown. The policy status should be Awaiting. <br><br>     <div class="form-group">
                                        <select class="form-control" name="PolicyStatus" id="PolicyStatus" style="width: 170px" required>
                                            <option value="<?php echo $data2['policystatus'] ?>"><?php echo $data2['policystatus']; ?></option>
                                            <option value="Live">Live</option>                                                           
                                            <option value="Awaiting">Awaiting</option>
                                            <option value="NTU">NTU</option>
                                            <option value="Declined">Declined</option>
                                            <option value="Redrawn">Redrawn</option>
                                            <option value="Cancelled">Cancelled</option>
                                            <?php if (in_array($hello_name, $Level_9_Access, true)) { ?>
                                            <option value="On Hold">On Hold</option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>                                    
                                <select class="form-control" name="changereason" required>
                                    <option value="">Select update reason...</option>
                                    <option value="Updated TBC Policy Number">Updated TBC Policy Number</option>
                                    <option value="Incorrect Policy Number">Incorrect Policy Number</option>
                                    <option value="Incorrect Single/Joint">Incorrect Single/Joint</option>
                                    <option value="Incorrect Application Number">Application Number</option>
                                    <option value="Incorrect Policy Holder">Incorrect Policy Holder</option>
                                    <option value="Incorrect Sale Date">Incorrect Sale Date</option>
                                    <option value="Incorrect Submitted Date<">Incorrect Submitted Date</option>
                                    <option value="Incorrect Policy Type">Incorrect Policy Type  (LTA, DTA, etc...)</option>
                                    <option value="Incorrect Insurer">Incorrect Insurer</option>
                                    <option value="Incorrect Premium">Incorrect Premium</option>
<?php if (in_array($hello_name, $Level_10_Access, true)) { ?>
                                        <option value="Incorrect Commission">Incorrect Commission</option>
<?php } ?>
                                    <option value="Incorrect Comm Type">Incorrect Comms Type</option>
                                    <option value="Incorrect Clawback Term">Incorrect Clawback Term</option>
                                    <option value="Incorrect Drip">Incorrect Drip</option>
                                    <option value="Incorrect Lead Gen">Incorrect Lead Gen</option>
                                    <option value="Incorrect Closer">Incorrect Closer</option>
                                    <option value="Update Policy Status">Update Policy Status</option>
                                    <option value="Updated Cover Amount">Update Cover Amount</option>
<?php if (in_array($hello_name, $Level_10_Access, true)) { ?>
                                        <option value="Admin Change">Admin Change</option>
<?php } ?>
                                </select>
                                <br>


                                <button name='search' value="<?php echo $search ?>" class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>



                                <a href="/app/Client.php?search=<?php echo $search ?>" class="btn btn-warning"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>

                            </div>                                            

                        </form>
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
                            text: 'Policy details updated!',
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

<script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
<script src="/resources/lib/sweet-alert/sweet-alert.min.js"></script>
<script>
    $(function () {
        $("#dob").datepicker();
    });
</script>
<script>
    $(function () {
        $("#dob2").datepicker();
    });
</script>
<script>
    $("readonly").keydown(function (e) {
        e.preventDefault();
    });
</script>
<script>
    webshims.setOptions('forms-ext', {
        replaceUI: 'auto',
        types: 'number'
    });
    webshims.polyfill('forms forms-ext');
</script>
<script>
    $(function () {
        $("#sale_date").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>
<script>
    $(function () {
        $("#submitted_date").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>
</body>
</html>