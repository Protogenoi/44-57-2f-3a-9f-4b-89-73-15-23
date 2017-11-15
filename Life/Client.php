<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
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

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if ($ffpost_code == '1') {
    require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

    $PostcodeQuery = $pdo->prepare("select api_key from api_keys WHERE type ='PostCode' limit 1");
    $PostcodeQuery->execute()or die(print_r($query->errorInfo(), true));
    $PDre = $PostcodeQuery->fetch(PDO::FETCH_ASSOC);
    $PostCodeKey = $PDre['api_key'];
}

if (in_array($hello_name, $Level_3_Access, true)) { 
    $EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT); 
    if(isset($EXECUTE) && $EXECUTE=='1') { 
        
        require_once(__DIR__ . '/../classes/database_class.php');
require_once(__DIR__ . '/class/Client.php');
$INSURER = filter_input(INPUT_POST, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS);    
    
$TITLE = filter_input(INPUT_POST, 'TITLE', FILTER_SANITIZE_SPECIAL_CHARS);
$FIRST = filter_input(INPUT_POST, 'FIRST', FILTER_SANITIZE_SPECIAL_CHARS);
$LAST = filter_input(INPUT_POST, 'LAST', FILTER_SANITIZE_SPECIAL_CHARS);
$DOB = filter_input(INPUT_POST, 'DOB', FILTER_SANITIZE_SPECIAL_CHARS);
$EMAIL = filter_input(INPUT_POST, 'EMAIL', FILTER_SANITIZE_SPECIAL_CHARS);
$PHONE = filter_input(INPUT_POST, 'NUMBER', FILTER_SANITIZE_SPECIAL_CHARS);
$ALT = filter_input(INPUT_POST, 'ALT', FILTER_SANITIZE_SPECIAL_CHARS);

$TITLE2 = filter_input(INPUT_POST, 'TITLE2', FILTER_SANITIZE_SPECIAL_CHARS);
$FIRST2 = filter_input(INPUT_POST, 'FIRST2', FILTER_SANITIZE_SPECIAL_CHARS);
$LAST2 = filter_input(INPUT_POST, 'LAST2', FILTER_SANITIZE_SPECIAL_CHARS);
$DOB2 = filter_input(INPUT_POST, 'DOB2', FILTER_SANITIZE_SPECIAL_CHARS);
$EMAIL2 = filter_input(INPUT_POST, 'EMAIL2', FILTER_SANITIZE_SPECIAL_CHARS);

$ADD1 = filter_input(INPUT_POST, 'ADD1', FILTER_SANITIZE_SPECIAL_CHARS);
$ADD2 = filter_input(INPUT_POST, 'ADD2', FILTER_SANITIZE_SPECIAL_CHARS);
$ADD3 = filter_input(INPUT_POST, 'ADD3', FILTER_SANITIZE_SPECIAL_CHARS);
$TOWN = filter_input(INPUT_POST, 'TOWN', FILTER_SANITIZE_SPECIAL_CHARS);
$POST = strtoupper(filter_input(INPUT_POST, 'POST', FILTER_SANITIZE_SPECIAL_CHARS));
    
$NewClient = new NewClient($hello_name,$INSURER,$COMPANY_ENTITY,$TITLE,$FIRST,$LAST,$DOB,$EMAIL,$NUMBER,$ALT,$TITLE2,$FIRST2,$LAST2,$DOB2,$EMAIL2,$ADD1,$ADD2,$ADD3,$TOWN,$POST);

$NewClient->checkVARS();

//CHECK FOR INCORRECT DATA
$NewClient->addClientValidation(); 

//IF NO ERROR CHECK FOR DUPES
if(!isset($check['VALIDATION']) && $check['VALIDATION']!='INVALID') {
  $NewClient->dupeCheck();  
  $data = $NewClient->dupeCheck();
}


if(!isset($data['EXECUTE']) && $data['EXECUTE']!='DUPE') {
    $NewClient->addClient();
    $NewClient->selectTasks();
}


$check= $NewClient->addClientValidation();  
 
if(empty($data)) {
$data= $NewClient->addClientValidation(); 
}

    }
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Add Client</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/Notices.css" type="text/css" />
    <link rel="stylesheet" href="/styles/PostCode.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

    <script type="text/javascript" language="javascript" src="js/jquery/jquery-3.0.0.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <?php if ($ffpost_code == '1') { ?>
        <script src="/js/jquery.postcodes.min.js"></script>
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
<?php if(isset($data['EXECUTE']) && $data['EXECUTE']=='DUPE') { ?>
        <div class="notice notice-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Error!</strong> Duplicate address details found or phone number<br><br><a href='../../Life/ViewClient.php?search=<?php if(isset($data['DUPE_ID'])) { echo $data['DUPE_ID']; } ?>' target="_blank" class="btn btn-default"><i class='fa fa-eye'> View Client</a></i></div>
<?php } ?>
<?php if(isset($check['VALIDATION']) && $check['VALIDATION']=='INVALID') { ?>
        <div class="notice notice-warning fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Warning!</strong> Please check over the details that you have inputted.</div>
<?php } ?>          
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-user-plus"></i> Add Client</div>
                <div class="panel-body">
<form class="form-horizontal" action="?EXECUTE=1" method="POST">
                    
                        <div class="row">
                        <div class="col-sm-12">
                            
                            <div class="row">
                            <div class="col-sm-4">
                                
                             <div class="form-group  has-<?php if(isset($check['CUS_STATUS'])) { echo $check['CUS_STATUS']; } ?> has-feedback">
                                <label class="col-sm-4 control-label" style="text-align:left;" for="product">Product:</label>
                                <div class="col-sm-6">
                                <select class="form-control" name="INSURER" id="custype" style="width: 170px" required>
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
                             </div>
                                
                            </div>
                            
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4"></div>
                            
                        </div>
                            
                            <div class="col-sm-4">
                                <h3><span class="label label-info">Client Details (1)</span></h3><br>
                                
                             <div class="form-group has-<?php if(isset($check['TITLE_STATUS'])) { echo $check['TITLE_STATUS']; } ?> has-feedback">
                                <label class="col-sm-4 control-label" style="text-align:left;" for="title">Title:</label>
                                <div class="col-sm-6">
                                <select class="form-control" name="TITLE" id="TITLE" required>
                                    <option value="">Select...</option>
                                    <option value="Mr" <?php if(isset($data['title']) && $data['title']=='Mr') { echo "selected"; }?> >Mr</option>
                                    <option value="Dr" <?php if(isset($data['title']) && $data['title']=='Dr') { echo "selected"; }?>>Dr</option>
                                    <option value="Miss" <?php if(isset($data['title']) && $data['title']=='Miss') { echo "selected"; }?>>Miss</option>
                                    <option value="Mrs" <?php if(isset($data['title']) && $data['title']=='Mrs') { echo "selected"; }?>>Mrs</option>
                                    <option value="Ms" <?php if(isset($data['title']) && $data['title']=='Ms') { echo "selected"; }?>>Ms</option>
                                    <option value="Other" <?php if(isset($data['title']) && $data['title']=='Other') { echo "selected"; }?>>Other</option>
                                </select>
                            </div>                 
                            </div>                               
                                
                                <div class="form-group has-<?php if(isset($check['FIRST_STATUS'])) { echo $check['FIRST_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="first_name">First Name:</label>
                                    <div class="col-sm-6">
                                    <input required value="<?php if(isset($data['first'])) { echo $data['first']; } ?>" name="FIRST" type="text" class="form-control" id="first_name" aria-describedby="input<?php if(isset($check['FIRST_STATUS'])) { echo $check['FIRST_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['FIRST_ICON'])) { echo $check['FIRST_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="first_name" class="sr-only"><?php if(isset($check['FIRST_STATUS'])) { echo $check['FIRST_STATUS']; } ?></span>
                                </div> 
                                </div>
                                
                                <div class="form-group has-<?php if(isset($check['LAST_STATUS'])) { echo $check['LAST_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="last_name">Surname:</label>
                                    <div class="col-sm-6">
                                    <input required value="<?php if(isset($data['last'])) { echo $data['last']; } ?>" name="LAST" type="text" class="form-control" id="last_name" aria-describedby="input<?php if(isset($check['LAST_STATUS'])) { echo $check['LAST_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['LAST_ICON'])) { echo $check['LAST_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="last_name" class="sr-only"><?php if(isset($check['LAST_STATUS'])) { echo $check['LAST_STATUS']; } ?></span>
                                </div>                    
                                </div>
                                
                                <div class="form-group has-<?php if(isset($check['DOB_STATUS'])) { echo $check['DOB_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="dob">Date of Birth:</label>
                                    <div class="col-sm-6">
                                    <input required value="<?php if(isset($data['dob'])) { echo $data['dob']; } ?>" name="DOB" type="text" class="form-control" id="dob" aria-describedby="input<?php if(isset($check['DOB_STATUS'])) { echo $check['DOB_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['DOB_ICON'])) { echo $check['DOB_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="dob" class="sr-only"><?php if(isset($check['DOB_STATUS'])) { echo $check['DOB_STATUS']; } ?></span>
                                </div>                    
                                </div>    
                                
                                <div class="form-group has-<?php if(isset($check['EMAIL_STATUS'])) { echo $check['EMAIL_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="email">Email:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($data['email'])) { echo $data['email']; } ?>" name="EMAIL" type="email" class="form-control" id="email" aria-describedby="input<?php if(isset($check['EMAIL_STATUS'])) { echo $check['EMAIL_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['EMAIL_ICON'])) { echo $check['EMAIL_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="email" class="sr-only"><?php if(isset($check['EMAIL_STATUS'])) { echo $check['EMAIL_STATUS']; } ?></span>
                                </div>                    
                                </div>                                   

                                
                            </div>
                            
                            <div class="col-sm-4">
                                <h3><span class="label label-info">Client Details (2)</span></h3><br>
                                
                            <div class="form-group  has-<?php if(isset($check['TITLE_STATUS2'])) { echo $check['TITLE_STATUS2']; } ?> has-feedback">
                                <label class="col-sm-4 control-label" style="text-align:left;" for="title2">Title:</label>
                                <div class="col-sm-6">
                                <select class="form-control" name="TITLE" id="title2">
                                    <option value="">Select...</option>
                                    <option value="Mr" <?php if(isset($data['title2']) && $data['title2']=='Mr') { echo "selected"; }?> >Mr</option>
                                    <option value="Dr" <?php if(isset($data['title2']) && $data['title2']=='Dr') { echo "selected"; }?>>Dr</option>
                                    <option value="Miss" <?php if(isset($data['title2']) && $data['title2']=='Miss') { echo "selected"; }?>>Miss</option>
                                    <option value="Mrs" <?php if(isset($data['title2']) && $data['title2']=='Mrs') { echo "selected"; }?>>Mrs</option>
                                    <option value="Ms" <?php if(isset($data['title2']) && $data['title2']=='Ms') { echo "selected"; }?>>Ms</option>
                                    <option value="Other" <?php if(isset($data['title2']) && $data['title2']=='Other') { echo "selected"; }?>>Other</option>
                                </select>
                            </div>                 
                            </div>
                                
                                <div class="form-group has-<?php if(isset($check['FIRST_STATUS2'])) { echo $check['FIRST_STATUS2']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="first2_name">First Name:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($data['first2'])) { echo $data['first2']; } ?>" name="FIRST2" type="text" class="form-control" id="first2_name" aria-describedby="input<?php if(isset($check['FIRST_STATUS2'])) { echo $check['FIRST_STATUS2']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['FIRST_ICON'])) { echo $check['FIRST_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="first2_name" class="sr-only"><?php if(isset($check['FIRST_STATUS2'])) { echo $check['FIRST_STATUS2']; } ?></span>
                                </div> 
                                </div>
                                
                                <div class="form-group has-<?php if(isset($check['LAST_STATUS2'])) { echo $check['LAST_STATUS2']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="last2_name">Surname:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($data['last2'])) { echo $data['last2']; } ?>" name="LAST2" type="text" class="form-control" id="last2_name" aria-describedby="input<?php if(isset($check['LAST_STATUS2'])) { echo $check['LAST_STATUS2']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['LAST_ICON'])) { echo $check['LAST_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="last2_name" class="sr-only"><?php if(isset($check['LAST_STATUS2'])) { echo $check['LAST_STATUS2']; } ?></span>
                                </div>                    
                                </div>
                                
                                <div class="form-group has-<?php if(isset($check['DOB_STATUS2'])) { echo $check['DOB_STATUS2']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="dob2">Date of Birth:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($data['dob2'])) { echo $data['dob2']; } ?>" name="DOB2" type="text" class="form-control" id="dob2" aria-describedby="input<?php if(isset($check['DOB_STATUS2'])) { echo $check['DOB_STATUS2']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['DOB_ICON'])) { echo $check['DOB_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="dob2" class="sr-only"><?php if(isset($check['DOB_STATUS2'])) { echo $check['DOB_STATUS2']; } ?></span>
                                </div>                    
                                </div>    
                                
                                <div class="form-group has-<?php if(isset($check['EMAIL_STATUS2'])) { echo $check['EMAIL_STATUS2']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="email2">Email:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($data['email2'])) { echo $data['email2']; } ?>" name="EMAIL2" type="email2" class="form-control" id="email2" aria-describedby="input<?php if(isset($check['EMAIL_STATUS2'])) { echo $check['EMAIL_STATUS2']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['EMAIL_ICON'])) { echo $check['EMAIL_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="email2" class="sr-only"><?php if(isset($check['EMAIL_STATUS2'])) { echo $check['EMAIL_STATUS2']; } ?></span>
                                </div>                    
                                </div>                                 
                                
                            </div>
                            
                            <div class="col-sm-4">
                                <h3><span class="label label-info">Contact Details</span></h3><br>
                                
                                <div class="form-group has-<?php if(isset($check['PHONE_STATUS'])) { echo $check['PHONE_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="phone_number">Number:</label>
                                    <div class="col-sm-6">
                                    <input required pattern=".{11}|.{11,11}" maxlength="11" title="Enter a valid phone number" value="<?php if(isset($data['phone'])) { echo $data['phone']; } ?>" name="NUMBER" type="text" class="form-control" id="phone_number" aria-describedby="input<?php if(isset($check['PHONE_STATUS'])) { echo $check['PHONE_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['PHONE_ICON'])) { echo $check['PHONE_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="phone_number" class="sr-only"><?php if(isset($check['PHONE_STATUS'])) { echo $check['PHONE_STATUS']; } ?></span>
                                </div>                    
                                </div>  
                               
                                <div class="form-group has-<?php if(isset($check['ALT_STATUS'])) { echo $check['ALT_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="alt_number">Alt:</label>
                                    <div class="col-sm-6">
                                    <input pattern=".{11}|.{11,11}" maxlength="11" title="Enter a valid phone number" value="<?php if(isset($data['phone'])) { echo $data['phone']; } ?>" name="ALT" type="text" class="form-control" id="alt_number" aria-describedby="input<?php if(isset($check['ALT_STATUS'])) { echo $check['ALT_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['ALT_ICON'])) { echo $check['ALT_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="alt_number" class="sr-only"><?php if(isset($check['ALT_STATUS'])) { echo $check['ALT_STATUS']; } ?></span>
                                </div>                    
                                </div>     
                                
                            <?php if ($ffpost_code == '1') { ?>
                                <div id="lookup_field"></div>
                                <?php
                            }

                            if ($ffpost_code == '0') {
                                ?>

                                <div class="alert alert-info"><strong>Info!</strong> Post code lookup feature not enabled.</div>

                            <?php } ?>
                                
                                <div class="form-group has-<?php if(isset($check['ADD1_STATUS'])) { echo $check['ADD1_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="address1">Address 1:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($data['add1'])) { echo $data['add1']; } ?>" name="ADD1" type="text" class="form-control" id="address1" aria-describedby="input<?php if(isset($check['ADD1_STATUS'])) { echo $check['ADD1_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['ADD1_ICON'])) { echo $check['ADD1_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="address1" class="sr-only"><?php if(isset($check['ADD1_STATUS'])) { echo $check['ADD1_STATUS']; } ?></span>
                                </div>                    
                                </div>   
                                
                                <div class="form-group has-<?php if(isset($check['ADD2_STATUS'])) { echo $check['ADD2_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="address2">Address 2:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($data['add2'])) { echo $data['add2']; } ?>" name="ADD2" type="text" class="form-control" id="address2" aria-describedby="input<?php if(isset($check['ADD2_STATUS'])) { echo $check['ADD2_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['ADD2_ICON'])) { echo $check['ADD2_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="address2" class="sr-only"><?php if(isset($check['ADD2_STATUS'])) { echo $check['ADD2_STATUS']; } ?></span>
                                </div>                    
                                </div>  

                                <div class="form-group has-<?php if(isset($check['ADD3_STATUS'])) { echo $check['ADD3_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="address3">Address 3:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($data['add3'])) { echo $data['add3']; } ?>" name="ADD3" type="text" class="form-control" id="address3" aria-describedby="input<?php if(isset($check['ADD3_STATUS'])) { echo $check['ADD3_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['ADD3_ICON'])) { echo $check['ADD3_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="address3" class="sr-only"><?php if(isset($check['ADD3_STATUS'])) { echo $check['ADD3_STATUS']; } ?></span>
                                </div>                    
                                </div>                                  
                                
                                <div class="form-group has-<?php if(isset($check['TOWN_STATUS'])) { echo $check['TOWN_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="town">Town:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($data['town'])) { echo $data['town']; } ?>" name="TOWN" type="text" class="form-control" id="town" aria-describedby="input<?php if(isset($check['TOWN_STATUS'])) { echo $check['TOWN_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['TOWN_ICON'])) { echo $check['TOWN_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="town" class="sr-only"><?php if(isset($check['TOWN_STATUS'])) { echo $check['TOWN_STATUS']; } ?></span>
                                </div>                    
                                </div> 
                                
                                <div class="form-group has-<?php if(isset($check['POST_STATUS'])) { echo $check['POST_STATUS']; } ?> has-feedback">
                                    <label class="col-sm-4 control-label" style="text-align:left;" for="post_code">Post Code:</label>
                                    <div class="col-sm-6">
                                    <input value="<?php if(isset($data['post'])) { echo $data['post']; } ?>" name="POST" type="text" class="form-control" id="post_code" aria-describedby="input<?php if(isset($check['POST_STATUS'])) { echo $check['POST_STATUS']; } ?>4Status">
                                    <span class="glyphicon <?php if(isset($check['POST_ICON'])) { echo $check['POST_ICON']; } ?> form-control-feedback" aria-hidden="true"></span>
                                    <span id="post_code" class="sr-only"><?php if(isset($check['POST_STATUS'])) { echo $check['POST_STATUS']; } ?></span>
                                </div>                    
                                </div> 
                                
     
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
                            <button type="submit" class="btn-md btn-success btn-block"><i class="fa fa-save"></i> Save</button>
                        </div>
                            </div>
</form>

           
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php } else {
     header('Location: /CRMmain.php?NOACCESS');
    die;
}