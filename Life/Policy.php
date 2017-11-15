<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../classes/database_class.php');
require_once(__DIR__ . '/class/Policy.php');

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

if (in_array($hello_name, $Level_3_Access, true)) {

$CID = filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT);
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$INSURER = filter_input(INPUT_GET, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE)) {
    if ($EXECUTE == '1') {
        
        $custtype = filter_input(INPUT_POST, 'custtype', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $CID = filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT);
        $NAME = filter_input(INPUT_POST, 'NAME', FILTER_SANITIZE_SPECIAL_CHARS);
        $APP = filter_input(INPUT_POST, 'APP', FILTER_SANITIZE_SPECIAL_CHARS);
        $POLICY = filter_input(INPUT_POST, 'POLICY', FILTER_SANITIZE_SPECIAL_CHARS);
        $TYPE = filter_input(INPUT_POST, 'TYPE', FILTER_SANITIZE_SPECIAL_CHARS);
        $INSURER = filter_input(INPUT_POST, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS);
        $PREMIUM = filter_input(INPUT_POST, 'PREMIUM', FILTER_SANITIZE_SPECIAL_CHARS);
        $COMMISSION = filter_input(INPUT_POST, 'COMMISSION', FILTER_SANITIZE_SPECIAL_CHARS);
        $COVER = filter_input(INPUT_POST, 'COVER', FILTER_SANITIZE_SPECIAL_CHARS);
        $TERM = filter_input(INPUT_POST, 'TERM', FILTER_SANITIZE_SPECIAL_CHARS);
        $COMM = filter_input(INPUT_POST, 'COMM', FILTER_SANITIZE_SPECIAL_CHARS);
        $CB_TERM = filter_input(INPUT_POST, 'CB_TERM', FILTER_SANITIZE_SPECIAL_CHARS);
        $DRIP = filter_input(INPUT_POST, 'DRIP', FILTER_SANITIZE_SPECIAL_CHARS);
        $CLOSER = filter_input(INPUT_POST, 'CLOSER', FILTER_SANITIZE_SPECIAL_CHARS);
        $AGENT = filter_input(INPUT_POST, 'AGENT', FILTER_SANITIZE_SPECIAL_CHARS);
        $SALE = filter_input(INPUT_POST, 'SALE', FILTER_SANITIZE_SPECIAL_CHARS);
        $SUB = filter_input(INPUT_POST, 'SUB', FILTER_SANITIZE_SPECIAL_CHARS); 
        $STATUS = filter_input(INPUT_POST, 'STATUS', FILTER_SANITIZE_SPECIAL_CHARS);
        

$NewPolicy = new newPolicy($hello_name,$COMPANY_ENTITY,$CID,$NAME,$APP,$POLICY,$TYPE,$INSURER,$PREMIUM,$COMMISSION,$COVER,$TERM,$COMM,$CB_TERM,$DRIP,$CLOSER,$AGENT,$SALE,$SUB,$STATUS);

$NewPolicy->checkVARS();
$data=$NewPolicy->selectPolicy();


$NewPolicy->addPolicyValidation();
$DATA_RETURN=$NewPolicy->addPolicyValidation();

if(isset($DATA_RETURN) && $DATA_RETURN['VALIDATION']=="VALID") {
    $NewPolicy->DupeCheck();
    
}

$DATA_DUPE=$NewPolicy->DupeCheck();

if(isset($DATA_DUPE['DUPE']) && $DATA_DUPE['DUPE']=='NO') {
    
   $NewPolicy->AddPolicy();
    
}

    }
if($EXECUTE=='2') {
    $NewPolicy = new newPolicy($hello_name,$COMPANY_ENTITY,$CID,"0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0");

    
$NewPolicy->selectPolicy();
    $NewPolicy->checkVARS();
$data=$NewPolicy->selectPolicy();

}    
    
?>
<!DOCTYPE html>
        <html lang="en">
            <title>ADL | Add Policy</title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="/styles/Notices.css" type="text/css" />
            <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
            <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
            <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
            <link  rel="stylesheet" href="/styles/sweet-alert.min.css" />
            <link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
            <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
            <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
            <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
            <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
            <script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
            <script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
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

            <?php require_once(__DIR__ . '/../includes/navbar.php'); ?>

            <br>

            <div class="container">
                
<?php if(isset($DATA_RETURN['VALIDATION']) && $DATA_RETURN['VALIDATION']=='INVALID') { ?>
        <div class="notice notice-warning fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Warning!</strong> Please check over the details that you have inputted.</div>
<?php } ?> 
        
<?php if(isset($DATA_DUPE['DUPE']) && $DATA_DUPE['DUPE']=='YES') { ?>
        <div class="notice notice-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>DUPE Policy!</strong> There is already a policy on this system with policy number <?php if(isset($DATA_RETURN['POLICY'])) { echo $DATA_RETURN['POLICY']; } ?>.
            <br><br>
             <a class="btn btn-md btn-default" href="ViewPolicy.php?policyID=<?php echo $DATA_DUPE['PID']; ?>&search=<?php echo $DATA_DUPE['CID']; ?>" target="_blank" ><i class="fa fa-search"></i> View dupe policy</a>
        </div>
<?php } ?>         
        
                <div class="panel-group">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Add <?php echo $INSURER; ?> Policy</div>
                        <div class="panel-body">
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form-horizontal" method="POST" action="?EXECUTE=1&CID=<?php echo $CID ?>">
                                        
                                        <div class="col-sm-4">
                                            
                                            
                                            <div class="alert alert-info"><strong>Client Name:</strong> 
                                    Naming one person will create a single policy. Naming two person's will create a joint policy. <br><br>
                                    <div class="form-group has-<?php if(isset($DATA_RETURN['NAME_STATUS'])) { echo $DATA_RETURN['NAME_STATUS']; } ?> has-feedback">
                                        <div class="col-sm-10">
                                            <select class='form-control' name='NAME' id='NAME' required>
                                                <option value="<?php echo $data['NAME']; ?>"><?php echo $data['NAME']; ?></option>
                                            <?php if (isset($NAME2)) { ?>
                                                <option value="<?php echo $data['NAME2']; ?>"><?php echo $data['NAME2']; ?></option>
                                                <option value="<?php echo "$data[NAME] and  $data[NAME2]"; ?>"><?php echo "$data[NAME] and  $data[NAME2]"; ?></option>
                                            <?php } ?> 
                                            </select> 
                                        </div>
                                    </div>
                                            </div>
                                    
                                <div class="form-group has-<?php if(isset($DATA_RETURN['APP_STATUS'])) { echo $DATA_RETURN['APP_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="APP">APP Number:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($DATA_RETURN['APP'])) { echo $DATA_RETURN['APP']; } ?>" name="APP" type="text" class="form-control" id="APP" aria-describedby="input<?php if(isset($DATA_RETURN['APP_STATUS'])) { echo $DATA_RETURN['APP_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($DATA_RETURN['APP_ICON'])) { echo $DATA_RETURN['APP_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="APP" class="sr-only"><?php if(isset($DATA_RETURN['APP_STATUS'])) { echo $DATA_RETURN['APP_STATUS']; } ?></span>
                                </div> 
                                </div>
                                            
                                            <div class="alert alert-info"><strong>Policy Number:</strong> 
                                    For Awaiting/TBC polices, leave as TBC. A unique ID will be generated. <br><br>
                                    <div class="form-group has-<?php if(isset($DATA_RETURN['POLICY_STATUS'])) { echo $DATA_RETURN['POLICY_STATUS']; } ?> has-feedback">
                                        <div class="col-sm-10">
                                             <input value="<?php if(isset($DATA_RETURN['POLICY'])) { echo $DATA_RETURN['POLICY']; } ?>" name="POLICY" type="text" class="form-control" id="POLICY" aria-describedby="input<?php if(isset($DATA_RETURN['POLICY_STATUS'])) { echo $DATA_RETURN['POLICY_STATUS']; } ?>4Status"> 
                                    <span class="glyphicon <?php if(isset($DATA_RETURN['POLICY_ICON'])) { echo $DATA_RETURN['POLICY_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="POLICY" class="sr-only"><?php if(isset($DATA_RETURN['POLICY_STATUS'])) { echo $DATA_RETURN['POLICY_STATUS']; } ?></span>
                                        </div>
                                    </div>
                                            </div>     
                                            
                                <div class="form-group has-<?php if(isset($DATA_RETURN['TYPE_STATUS'])) { echo $DATA_RETURN['TYPE_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="TYPE">Type:</label>
                                    <div class="col-sm-6">
                                    <select class="form-control" name="TYPE" id="TYPE" required>
                                            <option value="">Select...</option>
                                            <option <?php if(isset($DATA_RETURN['TYPE']) && $DATA_RETURN['TYPE']=='LTA') { echo "selected"; } ?> value="LTA">LTA</option>
                                            <option <?php if(isset($DATA_RETURN['TYPE']) && $DATA_RETURN['TYPE']=='ARCHIVE') { echo "selected"; } ?> value="ARCHIVE" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'ARCHIVE') {
                                                    echo "selected";
                                                }
                                            } 
                                            ?> >ARCHIVE</option>
                                                    <?php
                                                    if (isset($INSURER)) {
                                                        if ($INSURER == 'TRB Vitality' || $INSURER == 'Vitality') {
                                                            ?>
                                                    <option <?php if(isset($DATA_RETURN['TYPE']) && $DATA_RETURN['TYPE']=='LTA SIC') { echo "selected"; } ?> value="LTA SIC">LTA SIC (Vitality)</option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <option <?php if(isset($DATA_RETURN['TYPE']) && $DATA_RETURN['TYPE']=='LTA CIC') { echo "selected"; } ?> value="LTA CIC">LTA + CIC</option>
                                            <option <?php if(isset($DATA_RETURN['TYPE']) && $DATA_RETURN['TYPE']=='DTA') { echo "selected"; } ?> value="DTA">DTA</option>
                                            <option <?php if(isset($DATA_RETURN['TYPE']) && $DATA_RETURN['TYPE']=='DTA CIC') { echo "selected"; } ?> value="DTA CIC">DTA + CIC</option>
                                            <option <?php if(isset($DATA_RETURN['TYPE']) && $DATA_RETURN['TYPE']=='CIC') { echo "selected"; } ?> value="CIC">CIC</option>
                                            <option <?php if(isset($DATA_RETURN['TYPE']) && $DATA_RETURN['TYPE']=='FPIP') { echo "selected"; } ?> value="FPIP">FPIP</option>
                                            <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'TRB Aviva' || $INSURER == 'Aviva') {
                                                    ?> 
                                                    <option <?php if(isset($DATA_RETURN['TYPE']) && $DATA_RETURN['TYPE']=='Income Protection') { echo "selected"; } ?> value="Income Protection">Income Protection</option>
                                                <?php }
                                            }
                                           
                                       if(isset($INSURER) && $INSURER =='TRB WOL' || $INSURER=='One Family') { ?>
                                                    
                                            <option <?php if(isset($DATA_RETURN['TYPE']) && $DATA_RETURN['TYPE']=='WOL') { echo "selected"; } ?> value="WOL" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'TRB WOL' || $INSURER=="One Family"){
                                                    echo "selected";
                                                }
                                            }
                                            ?> >WOL</option>
                                            <?php } ?>
                                        </select>
                                </div> 
                                </div>                                            
                                    
                                <div class="form-group has-<?php if(isset($DATA_RETURN['INSURER_STATUS'])) { echo $DATA_RETURN['INSURER_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="INSURER">Insurer:</label>
                                    <div class="col-sm-6">
 <select class="form-control" name="INSURER" id="INSURER" required>
                                            <option value="">Select...</option>
                                            <option <?php if(isset($DATA_RETURN['INSURER']) && $DATA_RETURN['INSURER']=='Legal and General') { echo "selected"; } ?> value="Legal and General" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'Legal and General' || $INSURER == 'Bluestone Protect') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Legal & General</option>
                                            
                                            <option <?php if(isset($DATA_RETURN['INSURER']) && $DATA_RETURN['INSURER']=='Vitality') { echo "selected"; } ?>  value="Vitality" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'TRB Vitality' || $INSURER == 'Vitality') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Vitality</option>
                                            <option <?php if(isset($DATA_RETURN['INSURER']) && $DATA_RETURN['INSURER']=='Assura') { echo "selected"; } ?> value="Assura" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'ASSURA') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Assura</option>
                                            <option <?php if(isset($DATA_RETURN['INSURER']) && $DATA_RETURN['INSURER']=='Bright Grey') { echo "selected"; } ?> value="Bright Grey">Bright Grey</option>
                                            <option <?php if(isset($DATA_RETURN['INSURER']) && $DATA_RETURN['INSURER']=='Royal London') { echo "selected"; } ?> value="Royal London" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'TRB Royal London' || $INSURER == 'Royal London') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Royal London</option>
                                            <option <?php if(isset($DATA_RETURN['INSURER']) && $DATA_RETURN['INSURER']=='Legal and General') { echo "One Family"; } ?> value="One Family" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'TRB WOL' || $INSURER == 'One Family') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>One Family</option>
                                            <option <?php if(isset($DATA_RETURN['INSURER']) && $DATA_RETURN['INSURER']=='Aviva') { echo "selected"; } ?> value="Aviva" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'TRB Aviva' || $INSURER == 'Aviva') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Aviva</option>
                                        </select>
                                </div> 
                                </div>                                            
                                            
                                            </div>
                                        
                                        <div class="col-sm-4">
                                            
                                            <div class="form-group has-<?php if(isset($DATA_RETURN['PREMIUM_STATUS'])) { echo $DATA_RETURN['PREMIUM_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="premium">Premium:</label>
                                    <div class="col-sm-6">
                                        <div class="input-group"> 
                                        <span class="input-group-addon">£</span>
                                    <input value="<?php if(isset($DATA_RETURN['PREMIUM'])) { echo $DATA_RETURN['PREMIUM']; } ?>" name="PREMIUM" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" id="premium" aria-describedby="input<?php if(isset($DATA_RETURN['PREMIUM_STATUS'])) { echo $DATA_RETURN['PREMIUM_STATUS']; } ?>4Status">
                                        </div>
                                    <span class="glyphicon <?php if(isset($DATA_RETURN['PREMIUM_ICON'])) { echo $DATA_RETURN['PREMIUM_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="premium" class="sr-only"><?php if(isset($DATA_RETURN['PREMIUM_STATUS'])) { echo $DATA_RETURN['PREMIUM_STATUS']; } ?></span>
                                </div> 
                                </div>
                                            
                                            <div class="form-group has-<?php if(isset($DATA_RETURN['COMMISSION_STATUS'])) { echo $DATA_RETURN['COMMISSION_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="commission">Commission:</label>
                                    <div class="col-sm-6">
                                        <div class="input-group"> 
                                        <span class="input-group-addon">£</span>
                                    <input value="<?php if(isset($DATA_RETURN['COMMISSION'])) { echo $DATA_RETURN['COMMISSION']; } ?>" name="COMMISSION" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency commission value1" id="commission" aria-describedby="input<?php if(isset($DATA_RETURN['COMMISSION_STATUS'])) { echo $DATA_RETURN['COMMISSION_STATUS']; } ?>4Status">
                                        </div>
                                    <span class="glyphicon <?php if(isset($DATA_RETURN['COMMISSION_ICON'])) { echo $DATA_RETURN['COMMISSION_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="commission" class="sr-only"><?php if(isset($DATA_RETURN['COMMISSION_STATUS'])) { echo $DATA_RETURN['COMMISSION_STATUS']; } ?></span>
                                </div> 
                                </div>

                                            <div class="form-group has-<?php if(isset($DATA_RETURN['COVER_STATUS'])) { echo $DATA_RETURN['COVER_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="cover">Cover:</label>
                                    <div class="col-sm-6">
                                        <div class="input-group"> 
                                        <span class="input-group-addon">£</span>
                                    <input value="<?php if(isset($DATA_RETURN['COVER'])) { echo $DATA_RETURN['COVER']; } ?>" name="COVER" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency cover value1" id="cover" aria-describedby="input<?php if(isset($DATA_RETURN['COVER_STATUS'])) { echo $DATA_RETURN['COVER_STATUS']; } ?>4Status">
                                        </div>
                                    <span class="glyphicon <?php if(isset($DATA_RETURN['COVER_ICON'])) { echo $DATA_RETURN['COVER_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="cover" class="sr-only"><?php if(isset($DATA_RETURN['COVER_STATUS'])) { echo $DATA_RETURN['COVER_STATUS']; } ?></span>
                                </div> 
                                </div>
                                            
                                            <div class="form-group has-<?php if(isset($DATA_RETURN['TERM_STATUS'])) { echo $DATA_RETURN['TERM_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="term">Term:</label>
                                    <div class="col-sm-6">
                                        <div class="input-group"> 
                                        <span class="input-group-addon">yrs</span>
                                    <input value="<?php if(isset($DATA_RETURN['TERM'])) { echo $DATA_RETURN['TERM']; } ?>" name="TERM" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency term value1" id="term" aria-describedby="input<?php if(isset($DATA_RETURN['TERM_STATUS'])) { echo $DATA_RETURN['TERM_STATUS']; } ?>4Status">
                                        </div>
                                    <span class="glyphicon <?php if(isset($DATA_RETURN['TERM_ICON'])) { echo $DATA_RETURN['TERM_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="term" class="sr-only"><?php if(isset($DATA_RETURN['TERM_STATUS'])) { echo $DATA_RETURN['TERM_STATUS']; } ?></span>
                                </div> 
                                </div> 
                                            
                                <div class="form-group has-<?php if(isset($DATA_RETURN['COMM_STATUS'])) { echo $DATA_RETURN['COMM_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="type">COMM:</label>
                                    <div class="col-sm-6">
<select class="form-control" name="COMM" id="CommissionType" required>
                                                        <option value="">Select...</option>
                                                        <option <?php if(isset($DATA_RETURN['COMM']) && $DATA_RETURN['COMM']=='Indemnity') { echo "selected"; } ?> value="Indemnity">Indemnity</option>
                                                        <option <?php if(isset($DATA_RETURN['COMM']) && $DATA_RETURN['COMM']=='Non Indemnity') { echo "selected"; } ?> value="Non Indemnity">Non-Idemnity</option>
                                                        <option <?php if(isset($DATA_RETURN['COMM']) && $DATA_RETURN['COMM']=='NA') { echo "selected"; } ?> value="NA" <?php
                                                        if (isset($COMM_TYPE)) {
                                                            if ($COMM_TYPE == 'TRB WOL' || $COMM_TYPE == 'One Family') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?>>N/A</option>
                                                    </select>
                                </div> 
                                </div>    
                                            
                                <div class="form-group has-<?php if(isset($DATA_RETURN['CB_TERM_STATUS'])) { echo $DATA_RETURN['CB_TERM_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="type">CB Term:</label>
                                    <div class="col-sm-6">
                                                    <select class="form-control" name="CB_TERM" id="CB_TERM" required>
                                                        <option value="">Select...</option>
                                                    <?php for ($CB_GEN_TERM = 52; $CB_GEN_TERM > 11; $CB_GEN_TERM = $CB_GEN_TERM - 1) {
                                                            if($CB_GEN_TERM< 12) {
                                                               break; 
                                                    } 
                                                            ?>
                                                        <option <?php if(isset($DATA_RETURN['CB_TERM']) && $DATA_RETURN['CB_TERM']==$CB_GEN_TERM) { echo "selected"; } ?> value="<?php echo $CB_GEN_TERM;?>"><?php echo $CB_GEN_TERM; ?></option>
                                                        <?php } ?>
                                                        <option <?php if(isset($DATA_RETURN['CB_TERM']) && $DATA_RETURN['CB_TERM']=='1 year') { echo "selected"; } ?> value="1 year">1 year</option>
                                                        <option <?php if(isset($DATA_RETURN['CB_TERM']) && $DATA_RETURN['CB_TERM']=='2 year') { echo "selected"; } ?> value="2 year">2 year</option>
                                                        <option <?php if(isset($DATA_RETURN['CB_TERM']) && $DATA_RETURN['CB_TERM']=='3 year') { echo "selected"; } ?> value="3 year">3 year</option>
                                                        <option <?php if(isset($DATA_RETURN['CB_TERM']) && $DATA_RETURN['CB_TERM']=='4 year') { echo "selected"; } ?> value="4 year">4 year</option>
                                                        <option <?php if(isset($DATA_RETURN['CB_TERM']) && $DATA_RETURN['CB_TERM']=='5 year') { echo "selected"; } ?> value="5 year">5 year</option>
                                                        <option <?php if(isset($DATA_RETURN['CB_TERM']) && $DATA_RETURN['CB_TERM']=='One Family') { echo "selected"; }
                                                        if (isset($CB_TERM)) {
                                                            if ($CB_TERM == 'TRB WOL' || $CB_TERM == 'One Family' || $CB_TERM == 'ARCHIVE') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="0">0</option>
                                                    </select>
                                </div> 
                                </div>     
                                            
                                            <div class="form-group has-<?php if(isset($DATA_RETURN['DRIP_STATUS'])) { echo $DATA_RETURN['DRIP_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="drip">Drip:</label>
                                    <div class="col-sm-6">
                                        <div class="input-group"> 
                                        <span class="input-group-addon">£</span>
                                    <input value="<?php if(isset($DATA_RETURN['DRIP'])) { echo $DATA_RETURN['DRIP']; } ?>" name="DRIP" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency drip value1" id="drip" aria-describedby="input<?php if(isset($DATA_RETURN['DRIP_STATUS'])) { echo $DATA_RETURN['DRIP_STATUS']; } ?>4Status">
                                        </div>
                                    <span class="glyphicon <?php if(isset($DATA_RETURN['DRIP_ICON'])) { echo $DATA_RETURN['DRIP_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="drip" class="sr-only"><?php if(isset($DATA_RETURN['DRIP_STATUS'])) { echo $DATA_RETURN['DRIP_STATUS']; } ?></span>
                                </div> 
                                </div>

                                <div class="form-group has-<?php if(isset($DATA_RETURN['CLOSER_STATUS'])) { echo $DATA_RETURN['CLOSER_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="closer">Closer:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($DATA_RETURN['CLOSER'])) { echo $DATA_RETURN['CLOSER']; } ?>" name="CLOSER" type="text" class="form-control" id="closer" aria-describedby="input<?php if(isset($DATA_RETURN['CLOSER_STATUS'])) { echo $DATA_RETURN['CLOSER_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($DATA_RETURN['CLOSER_ICON'])) { echo $DATA_RETURN['CLOSER_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="closer" class="sr-only"><?php if(isset($DATA_RETURN['CLOSER_STATUS'])) { echo $DATA_RETURN['CLOSER_STATUS']; } ?></span>
                                </div> 
                                </div>  
                                            <script>var options = {
                                                            url: "../JSON/Closers.php",
                                                            getValue: "full_name",
                                                            list: {
                                                                match: {
                                                                    enabled: true
                                                                }
                                                            }
                                                        };

                                                        $("#closer").easyAutocomplete(options);</script>                                           
                                        
                                            
                               <div class="form-group has-<?php if(isset($DATA_RETURN['AGENT_STATUS'])) { echo $DATA_RETURN['AGENT_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="AGENT">Agent:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($DATA_RETURN['AGENT'])) { echo $DATA_RETURN['AGENT']; } ?>" name="AGENT" type="text" class="form-control" id="agent" aria-describedby="input<?php if(isset($DATA_RETURN['AGENT_STATUS'])) { echo $DATA_RETURN['AGENT_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($DATA_RETURN['AGENT_ICON'])) { echo $DATA_RETURN['AGENT_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="agent" class="sr-only"><?php if(isset($DATA_RETURN['AGENT_STATUS'])) { echo $DATA_RETURN['AGENT_STATUS']; } ?></span>
                                </div> 
                                </div>  
                                            <script>var options = {
                                                            url: "../JSON/Agents.php",
                                                            getValue: "full_name",
                                                            list: {
                                                                match: {
                                                                    enabled: true
                                                                }
                                                            }
                                                        };

                                                        $("#agent").easyAutocomplete(options);</script>                                               
                                    
                                    </div>
                                        
                                        
                                        
                                    <div class="col-sm-4"> 
                                    
                                    
                                            <div class="alert alert-info"><strong>Sale Date:</strong> 
                                    This is the sale date on the dealsheet. <br><br>
                                    <div class="form-group has-<?php if(isset($DATA_RETURN['SUB_STATUS'])) { echo $DATA_RETURN['SUB_STATUS']; } ?> has-feedback">
                                        <div class="col-sm-10">
                                             <input value="<?php if(isset($DATA_RETURN['SUB'])) { echo $DATA_RETURN['SUB']; } else { echo date('Y-m-d H:i:s'); } ?>" name="SUB" type="text" class="form-control" id="SUBmitted_date" aria-describedby="input<?php if(isset($DATA_RETURN['SUB_STATUS'])) { echo $DATA_RETURN['SUB_STATUS']; } ?>4Status"> 
                                        <span class="glyphicon <?php if(isset($DATA_RETURN['SUB_ICON'])) { echo $DATA_RETURN['SUB_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="SUB" class="sr-only"><?php if(isset($DATA_RETURN['SUB_STATUS'])) { echo $DATA_RETURN['SUB_STATUS']; } ?></span>
                                        </div>
                                    </div>
                                            </div>    
                                        
                                            <div class="alert alert-info"><strong>Submitted Date:</strong> 
                                    This is the policy live date on the insurers portal. <br><br>
                                    <div class="form-group has-<?php if(isset($DATA_RETURN['SALE_STATUS'])) { echo $DATA_RETURN['SALE_STATUS']; } ?> has-feedback">
                                        <div class="col-sm-10">
                                             <input value="<?php if(isset($DATA_RETURN['SALE'])) { echo $DATA_RETURN['SALE']; } else { echo date('Y-m-d H:i:s'); } ?>" name="SALE" type="text" class="form-control" id="SALEmitted_date" aria-describedby="input<?php if(isset($DATA_RETURN['SALE_STATUS'])) { echo $DATA_RETURN['SALE_STATUS']; } ?>4Status"> 
                                        <span class="glyphicon <?php if(isset($DATA_RETURN['SALE_ICON'])) { echo $DATA_RETURN['SALE_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="SALE" class="sr-only"><?php if(isset($DATA_RETURN['SALE_STATUS'])) { echo $DATA_RETURN['SALE_STATUS']; } ?></span>
                                        </div>
                                    </div>
                                            </div> 
                                        
                                             <div class="alert alert-info"><strong>Policy Status:</strong> 
                                    For any policy where the submitted date is unknown. The policy status should be Awaiting. <br><br>
                                    <div class="form-group has-<?php if(isset($DATA_RETURN['POLICY_STATUS'])) { echo $DATA_RETURN['POLICY_STATUS']; } ?> has-feedback">
                                        <div class="col-sm-10">
                                            <select class="form-control" name="STATUS" id="PolicyStatus" required>
                                        <option value="">Select...</option>
                                        <option <?php if(isset($DATA_RETURN['STATUS']) && $DATA_RETURN['STATUS']=='Live') { echo "selected"; } ?> value="Live">Live</option>
                                        <option <?php if(isset($DATA_RETURN['STATUS']) && $DATA_RETURN['STATUS']=='Awaiting') { echo "selected"; } ?> value="Awaiting">Awaiting</option>
                                        <option <?php if(isset($DATA_RETURN['STATUS']) && $DATA_RETURN['STATUS']=='Not Live') { echo "selected"; } ?> value="Not Live">Not Live</option>
                                        <option <?php if(isset($DATA_RETURN['STATUS']) && $DATA_RETURN['STATUS']=='NTU') { echo "selected"; } ?> value="NTU">NTU</option>
                                        <option <?php if(isset($DATA_RETURN['STATUS']) && $DATA_RETURN['STATUS']=='Decline') { echo "selected"; } ?> value="Declined">Declined</option>
                                        <option <?php if(isset($DATA_RETURN['STATUS']) && $DATA_RETURN['STATUS']=='Redrawn') { echo "selected"; } ?> value="Redrawn">Redrawn</option>
                                    </select>
                                        </div>
                                    </div>
                                            </div>                                       
                                             
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
                            </div>                                                                              
                                    
                                    </div>
                                
                            </form>
                                
                            </div>
                            </div>

                     
                </div>
            </div>
        </div>
    </div>
</body>
</html>
    
    <?php
  
                                
                                }
                                
                                } else {
                                    header('Location: ../CRMmain.php?AccessDenied');
                                    die;
                                    
                                }
                                    ?>