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
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$INSURER = filter_input(INPUT_GET, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE)) {
    if ($EXECUTE == '1') {

        $query = $pdo->prepare("SELECT submitted_date, company, client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name , CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2 from client_details where client_id = :CID");
        $query->bindParam(':CID', $search, PDO::PARAM_STR);
        $query->execute();
        $data2 = $query->fetch(PDO::FETCH_ASSOC);

        if(isset($data2['Name2'])) {
            $NAME2=$data2['Name2'];
        } 
        
        $ADL_PAGE_TITLE = "Add Policy";
        require_once(__DIR__ . '/../../app/core/head.php'); 
        
        ?>            
            <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
            <link  rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
            <link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
            <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
            <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
            <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
            <script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
            <script src="/resources/lib/js-webshim/minified/polyfiller.js"></script>
            <script>
                $(function () {
                    $("#sale_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });
                $(function () {
                    $("#submitted_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });
            </script>
            <script>
                webshims.setOptions('forms-ext', {
                    replaceUI: 'auto',
                    types: 'number'
                });
                webshims.polyfill('forms forms-ext');
            </script>
            <style>

                .form-row input {
                    padding: 3px 1px;
                    width: 100%;
                }
                input.currency {
                    text-align: right;
                    padding-right: 15px;
                }
                .input-group .form-control {
                    float: none;
                }
                .input-group .input-buttons {
                    position: relative;
                    z-index: 3;
                }
            </style>
        </head>
        <body>

            <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>

            <br>

            <div class="container">
                <div class="panel-group">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Add <?php echo $INSURER; ?> Policy</div>
                        <div class="panel-body">



                            <form class="AddClient" action="php/AddPolicy.php?EXECUTE=1&CID=<?php echo $search; ?>" method="POST">

                                <div class="col-md-4">

                                       <div class="alert alert-info"><strong>Client Name:</strong> 
                                    Naming one person will create a single policy. Naming two person's will create a joint policy. <br><br>
                                    <select class='form-control' name='client_name' id='client_name' style='width: 170px' required>
                                            <option value="<?php echo $data2['Name']; ?>"><?php echo $data2['Name']; ?></option>
                                            <?php if (isset($NAME2)) { ?>
                                            <option value="<?php echo $data2['Name2']; ?>"><?php echo $data2['Name2']; ?></option>
                                            <option value="<?php echo "$data2[Name] and  $data2[Name2]"; ?>"><?php echo "$data2[Name] and  $data2[Name2]"; ?></option>
                                            <?php } ?>    
                                    </select>
                                       </div>   
                                    
                                    <p>
                                        <label for="application_number">Application Number:</label>
                                            <input type="text" id="application_number" name="application_number"  class="form-control" style="width: 170px" value="<?php
                                            if ($INSURER == 'ONEFAMILY') {
                                                echo "WOL";
                                            } elseif ($INSURER == 'ROYALLONDON') {
                                                echo "Royal London";
                                            } elseif ($INSURER == 'VITALITY') {
                                                echo "Vitality";
                                            }
                                            elseif ($INSURER == 'LV') {
                                                echo "LV";
                                            }
                                            ?>" required>
                                        <label for="application_number"></label>
                                    </p>
                                    <br>

                            <div class="alert alert-info"><strong>Policy Number:</strong> 
                                For Awaiting/TBC polices, leave as TBC. A unique ID will be generated. <br><br> <input type='text' id='policy_number' name='policy_number' class="form-control" autocomplete="off" style="width: 170px" value="TBC">
                            </div>   
                                   
                                    <br>

                                    <p>
                                    <div class="form-group">
                                        <label for="type">Type:</label>
                                        <select class="form-control" name="type" id="type" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="LTA">LTA</option>
                                            <option value="ARCHIVE" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'ARCHIVE') {
                                                    echo "selected";
                                                }
                                            }
                                            ?> >ARCHIVE</option>
                                                    <?php
                                                    if (isset($INSURER)) {
                                                        if ($INSURER == 'VITALITY') {
                                                            ?>
                                                    <option value="LTA SIC">LTA SIC (Vitality)</option>
                                                    <option value="DTA SIC">DTA SIC (Vitality)</option>
                                                    <option value="VITALITY WOL">Whole of Life (Vitality)</option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <option value="LTA CIC">LTA + CIC</option>
                                            <option value="DTA">DTA</option>
                                            <option value="DTA CIC">DTA + CIC</option>
                                            <option value="CIC">CIC</option>
                                            <option value="FPIP">FPIP</option>
                                            <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'AVIVA') {
                                                    ?> 
                                                    <option value="Income Protection">Income Protection</option>
                                                <?php }
                                            }
                                           
                                       if(isset($INSURER) && $INSURER =='TRB WOL' || $INSURER=='One Family' || $INSURER=='ONEFAMILY') { ?>
                                                    
                                            <option value="WOL" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'TRB WOL' || $INSURER=="One Family" || $INSURER=="ONEFAMILY"){
                                                    echo "selected";
                                                }
                                            }
                                            ?> >WOL (One Family)</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-group">
                                        <label for="insurer">Insurer:</label>
                                        <select class="form-control" name="insurer" id="insurer" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="Aegon" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'Aegon') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Aegon</option>
                                            <option value="Legal and General" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'LANDG') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Legal & General</option>
                                             <option value="Zurich" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'ZURICH') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Zurich</option>
                                            <option value="LV" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'LV') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>LV</option>                                           
                                            <option value="Scottish Widows" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'SCOTTISH WIDOWS') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Scottish Widows</option>                                             
                                            <option value="Vitality" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'VITALITY') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Vitality</option>
                                            <option value="Assura" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'ASSURA') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Assura</option>
                                            <option value="Bright Grey">Bright Grey</option>
                                            <option value="Royal London" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'ROYALLONDON') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Royal London</option>
                                            <option value="One Family" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'ONEFAMILY') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>One Family</option>
                                            <option value="Aviva" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'AVIVA') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Aviva</option>
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
                                            <input <?php
                                            if ($INSURER == 'ARCHIVE') {
                                                echo "value='0'";
                                            }
                                            ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" id="premium" name="premium" required/>
                                        </div> 
                                        </p>
                                        
                                    <p>
                                        <label for="EXTRA_CHARGE">Extra Charges:</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input value="0" style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" id="EXTRA_CHARGE" name="EXTRA_CHARGE" required/>
                                        </div> 
                                        </p>  
                                        
                                        <p>
                                                <div class="form-group">
                                                    <label for="CommissionType">Comms:</label>
                                                    <select class="form-control" name="CommissionType" id="CommissionType" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                        <option value="Indemnity">Indemnity</option>
                                                        <option value="Non Idenmity">Non-Idemnity</option>
                                                        <option value="NA" <?php
                                                        if (isset($INSURER)) {
                                                            if ($INSURER == 'ONEFAMILY') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?>>N/A</option>
                                                    </select>
                                                </div>
                                                </p>                                        


                                        <p>

                                            <label for="commission">Commission</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input <?php
                                            if ($INSURER == 'ARCHIVE') {
                                                echo "value='0'";
                                            }
                                            ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required/>
                                        </div> 
                                        </p>
                                        
                                        <p>

                                            <label for="NonIndem">Non-Indem Comm</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input value='0' style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="NonIndem" name="NonIndem" required/>
                                        </div> 
                                        </p>                                         

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Cover Amount</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input <?php
                                                if ($INSURER == 'ARCHIVE') {
                                                    echo "value='0'";
                                                }
                                                ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="covera" required/>
                                            </div> 
                                            </p>
                                            
                                        <p>
       
                                            <label for="SIC_COVER_AMOUNT">SIC Cover Amount</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input <?php
                                                if ($INSURER == 'ARCHIVE') {
                                                    echo "value='0'";
                                                }
                                                ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="SIC_COVER_AMOUNT" name="SIC_COVER_AMOUNT" required/>
                                            </div> 
                                            </p>                                            

                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Policy Term</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">yrs</span>
                                                    <input <?php
                                                    if ($INSURER == 'ARCHIVE') {
                                                        echo "value='0'";
                                                    }
                                                    ?> style="width: 125px" autocomplete="off" type="text" class="form-control" id="polterm" name="polterm" <?php
                                                        if (isset($INSURER)) {
                                                            if ($INSURER == 'ONEFAMILY') {
                                                                echo "value='WOL'";
                                                            }
                                                        }
                                                        ?> required/>
                                                </div> 
                                                </p>


                                                <p>
                                                <div class="form-group">
                                                    <label for="comm_term">Clawback Term:</label>
                                                    <select class="form-control" name="comm_term" id="comm_term" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                    <?php for ($CB_TERM = 52; $CB_TERM > 11; $CB_TERM = $CB_TERM - 1) {
                                                            if($CB_TERM< 12) {
                                                               break; 
                                                    } 
                                                            ?>
                                                        <option value="<?php echo $CB_TERM;?>"><?php echo $CB_TERM; ?></option>
                                                        <?php } ?>
                                                        <option value="1 year">1 year</option>
                                                        <option value="2 year">2 year</option>
                                                        <option value="3 year">3 year</option>
                                                        <option value="4 year">4 year</option>
                                                        <option value="5 year">5 year</option>
                                                        <option <?php
                                                        if (isset($INSURER)) {
                                                            if ($INSURER == 'ONEFAMILY' || $INSURER == 'ARCHIVE') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="0">0</option>
                                                    </select>
                                                </div>
                                                </p>

                                                <p>
                                                <div class="form-row">
                                                    <label for="commission">Drip</label>
                                                    <div class="input-group"> 
                                                        <span class="input-group-addon">£</span>
                                                        <input <?php
                                                        if ($INSURER == 'ARCHIVE') {
                                                            echo "value='0'";
                                                        }
                                                        ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" required/>
                                                    </div> 
                                                    </p>



                                                    <p>
                                                        <label for="closer">Closer:</label>
                                                        <input type='text' id='closer' name='closer' style="width: 170px" class="form-control" style="width: 170px" required>
                                                    </p>
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
                                                    <br>

                                                    <p>
                                                        <label for="lead">Lead Gen:</label>
                                                        <input type='text' id='lead' name='lead' style="width: 170px" class="form-control" style="width: 170px" required>
                                                    </p>
                                                    <script>var options = {
                                                            url: "/../../app/JSON/Agents.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
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



                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="alert alert-info"><strong>Sale Date:</strong> 
                                This is the sale date on the dealsheet. <br><br> <input type="text" id="submitted_date" name="submitted_date" value="<?php
                                if ($INSURER == 'ARCHIVE') {
                                    echo "2013";
                                } else {
                                    echo date('Y-m-d H:i:s');
                                }
                                ?>" placeholder="<?php echo date('Y-m-d H:i:s'); ?>"class="form-control" style="width: 170px" required>

                            </div>   


                            <div class="alert alert-info"><strong>Submitted Date:</strong> 
                                This is the policy live date on the insurers portal. <br> <br><input type="text" id="sale_date" name="sale_date" value="<?php
                                if ($INSURER == 'ARCHIVE') {
                                    echo "2013";
                                } else {
                                    echo date('Y-m-d H:i:s');
                                }
                                ?>" placeholder="<?php echo date('Y-m-d H:i:s'); ?>"class="form-control" style="width: 170px" required>
                            </div>                              
                            <div class="alert alert-info"><strong>Policy Status:</strong> 
                                For any policy where the submitted date is unknown. The policy status should be Awaiting. <br><br>     <div class="form-group">
                                    <select class="form-control" name="PolicyStatus" id="PolicyStatus" style="width: 170px" required>
                                        <option value="">Select...</option>
                                        <option value="Live">Live</option>
                                        <option value="Awaiting">Awaiting</option>
                                        <option value="Not Live">Not Live</option>
                                        <option value="NTU">NTU</option>
                                        <option value="Declined">Declined</option>
                                        <option value="Redrawn">Redrawn</option>
                                        <option value="On Hold">On Hold</option>
                                    </select>
                                </div>

                            </div>                                    
 
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
                                <a href="/app/Client.php?search=<?php echo $search; ?>" class="btn btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
                            </div>                             
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>