<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

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

        if ($ffpost_code == '1') {

            $PostcodeQuery = $pdo->prepare("select api_key from api_keys WHERE type ='PostCode' limit 1");
            $PostcodeQuery->execute()or die(print_r($query->errorInfo(), true));
            $PDre = $PostcodeQuery->fetch(PDO::FETCH_ASSOC);
            $PostCodeKey = $PDre['api_key'];
        }

if ($ffdealsheets == '0') {
    header('Location: ../CRMmain.php?Feature=NotEnabled');
    die;
}

$QUERY = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

$Today_DATE = date("d-M-Y");
$Today_DATES = date("l jS \of F Y");
$Today_TIME = date("h:i:s");

if(in_array($hello_name, $Closer_Access, true) || $hello_name=='Michael') {
    
    
            $CLO_CR = $pdo->prepare("SELECT 
    COUNT(IF(sale = 'SALE',
        1,
        NULL)) AS Sales,
 COUNT(IF(sale IN ('SALE' , 'NoCard',
            'QDE',
            'DEC',
            'QUN',
            'QNQ',
            'DIDNO',
            'QCBK',
            'QQQ',
            'Other',
            'QML'),
        1,
        NULL)) AS Leads
FROM
    closer_trackers

WHERE
date_added > DATE(NOW()) 
AND closer=:closer");
        $CLO_CR->bindParam(':closer', $hello_name, PDO::PARAM_STR);
        $CLO_CR->execute();
        $CLO_CR_RESULT = $CLO_CR->fetch(PDO::FETCH_ASSOC);
        
                            if ( $CLO_CR_RESULT['Sales'] == '0') {
                        $Formattedrate = "0.0";
                    } else {
                        $Conversionrate =  $CLO_CR_RESULT['Leads'] /  $CLO_CR_RESULT['Sales'];
                        $SINGLE_CLOSER_RATE = number_format($Conversionrate, 1);
                    }
    
}

switch ($hello_name) {

    case "511";
        $real_name = 'Kyle';
        break;
    case "103";
        $real_name = 'Sarah';
        break;
    case "5000";
        $real_name = 'Mike';
        break;
    case "1312";
        $real_name = 'Hayley';
        break;
    case "118";
        $real_name = 'Gavin';
        break;
    case "104";
        $real_name = 'Richard';
        break;
    case "201";
        $real_name = 'Stavros';
        break;
    case "555";
        $real_name = 'James';
        break;

    default;
        $real_name = $hello_name;
}
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Life Dealsheet</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/styles/Notices.css">
    <link rel="stylesheet" type="text/css" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/styles/sweet-alert.min.css" />
    <link rel="stylesheet" type="text/css" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
    <link rel="stylesheet" type="text/css" href="/style/admindash.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    
    <?php if(in_array($hello_name, $Closer_Access, true) || $hello_name=='Michael') { 
        if(isset($SINGLE_CLOSER_RATE)) {
        if($SINGLE_CLOSER_RATE>=6) { ?> <style>
            .CLOSE_RATE {
            background-color:#B00004;
    }
        </style> 
            <?php } 
                    if($SINGLE_CLOSER_RATE >4.9 && $SINGLE_CLOSER_RATE<6) { ?> <style>
            .CLOSE_RATE {
            background-color:#FD7900;
    }
        </style> 
            <?php } 
    
   if($SINGLE_CLOSER_RATE <=4.9 && $SINGLE_CLOSER_RATE >= 1) {  ?> 
        <style>
            .CLOSE_RATE {
            background-color:#16A53F;
        }
        </style> 
    <?php } }  }?>
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
    <body <?php if(in_array($hello_name, $Closer_Access, true)) { if($CLO_CR>='1.5') { echo "bgcolor='#B00004'"; } else { echo "bgcolor='#16A53F'" ?>   <?php } } ?>>

<?php     require_once(__DIR__ . '/../includes/navbar.php'); ?>
        
            <div class="container">
                <div class='notice notice-info' role='alert' id='HIDEGLEAD'><strong><i class='fa fa-exclamation fa-lg'></i> Info:</strong> <b>You are logged in as <font color="red"><?php echo $real_name; ?></font>. All dealsheets will be saved to this user, ensure that you are logged into your own account!</b></div>
            </div>
            <?php
            if (isset($QUERY)) {
                if ($QUERY == 'ViewCallBacks') {

                    require_once(__DIR__ . '/../classes/database_class.php');

                    $deal_id = filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_NUMBER_INT);

                    $database = new Database();

                    $database->query("SELECT date_added, agent, closer, title, forename, surname, dob, title2, forename2, surname2, dob2, postcode, mobile, home, email FROM dealsheet_prt1 WHERE deal_id=:deal_id");
                    $database->bind(':deal_id', $deal_id);
                    $database->execute();
                    $data2 = $database->single();

                    list($dob_year, $dob_month, $dob_day) = explode(" ", $data2['dob']);
                    list($dob_year2, $dob_month2, $dob_day2) = explode(" ", $data2['dob2']);

                    $database->query("SELECT q1a, q1b, q1c, q1d, q2a, q3a, q4a, q4b, q4c, q4d, q4e, q5a, q6a, q6b, q7a, comments, callback FROM dealsheet_prt2 WHERE deal_id=:deal_id");
                    $database->bind(':deal_id', $deal_id);
                    $database->execute();
                    $data3 = $database->single();

                    $database->query("SELECT exist_pol, pol_num_1, pol_num_1_pre, pol_num_1_com, pol_num_1_cov, pol_num_1_yr, pol_num_1_type, pol_num_1_soj, pol_num_2, pol_num_2_pre, pol_num_2_com, pol_num_2_cov, pol_num_2_yr, pol_num_2_type, pol_num_2_soj, pol_num_3, pol_num_3_pre, pol_num_3_com, pol_num_3_cov, pol_num_3_yr, pol_num_3_type, pol_num_3_soj, pol_num_4, pol_num_4_pre, pol_num_4_com, pol_num_4_cov, pol_num_4_yr, pol_num_4_type, pol_num_4_soj, chk_post, chk_dob, chk_mob, chk_home, chk_email, fee, total, years, month, comm_after, sac, date FROM dealsheet_prt3 WHERE deal_id=:deal_id");
                    $database->bind(':deal_id', $deal_id);
                    $database->execute();
                    $data4 = $database->single();
                    
                    $database->query("SELECT cb_date, cb_time, type, reason FROM dealsheet_prt4 WHERE deal_id=:deal_id");
                    $database->bind(':deal_id', $deal_id);
                    $database->execute();
                    $data5 = $database->single();                    
                    ?>

                    <div class="container">

                        <form id="Send" class="form" method="POST" action="php/DealSheet.php?dealsheet=CLOSERRESEND&REF=<?php echo $deal_id; ?>">
                            <div class="col-md-4">
                                <img height="80" src="/img/RBlogo.png"><br>
                            </div>

                            <div class="col-md-4">
                                <label class="col-md-6 control-label" for="textinput">DATE</label>
                                <input type="text" name="deal_date" class="form-control input-md" placeholder="" value="<?php echo $data2['date_added']; ?>">
                            </div>

                            <div class="col-md-4">
                                <p>
                                    <label class="col-md-6 control-label" for="agent">LEAD AGENT:</label>
                                    <input type='text' id='agent' name='agent' class="form-control input-md" value="<?php echo $data2['agent']; ?>" readonly>
                                </p>
                            </div>

                    </div>   
                    <br>

                    <div class="container">
                        <div class="panel-group">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><i class="fa fa-user"></i> Client Details</div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <center> <h4>Client 1</h4></center>
                                        </div>
                                        <div class="col-md-6">
                                            <center><h4>Client 2</h4></center>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-1 control-label" for="title">Title</label> 
                                            <select class="form-control input-md" name="title">
        <?php
        if (isset($data2['title'])) {
            ?>
                                                    <option value="<?php echo $data2['title']; ?>"><?php echo $data2['title']; ?></option>
                                                <?php } else { ?>
                                                    <option value="">Title</option>
                                                <?php } ?>
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Miss">Miss</option>
                                                <option value="Ms">Ms</option>
                                                <option value="Dr">Dr</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-1 control-label" for="title2">Title</label>  
                                            <select class="form-control input-md" name="title2">
        <?php
        if (isset($data2['title2'])) {
            ?>
                                                    <option value="<?php echo $data2['title2']; ?>"><?php echo $data2['title2']; ?></option>
                                                <?php } else { ?>
                                                    <option value="">Title (2)</option>
                                                <?php } ?>
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Miss">Miss</option>
                                                <option value="Ms">Ms</option>
                                                <option value="Dr">Dr</option>
                                            </select>  
                                        </div>

                                        <div class="col-md-12"><br></div>

                                        <div class="col-md-6">
                                            <label class="col-md-6 control-label" for="textinput">Forename</label>
                                            <input type="text" name="forename" class="form-control input-md" placeholder="Forename" value="<?php if (isset($data2['forename'])) {
                                                    echo $data2['forename'];
                                                } ?>">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-6 control-label" for="textinput">Forename (2)</label>
                                            <input type="text" name="forename2" class="form-control input-md" placeholder="Forename" value="<?php if (isset($data2['forename2'])) {
                                                    echo $data2['forename2'];
                                                } ?>">
                                        </div> 

                                        <div class="col-md-12"><br></div>     

                                        <div class="col-md-6">
                                            <label class="col-md-6 control-label" for="surname">Surname</label>
                                            <input type="text" name="surname" class="form-control input-md" placeholder="Surname" value="<?php if (isset($data2['surname'])) {
                                                    echo $data2['surname'];
                                                } ?>">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-6 control-label" for="surname2">Surname (2)</label>
                                            <input type="text" name="surname2" class="form-control input-md" placeholder="Surname" value="<?php if (isset($data2['surname2'])) {
                                                    echo $data2['surname2'];
                                                } ?>">
                                        </div>

                                    </div>

                                    <br>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <select class="form-control input-md" name="dob_day">
                                                    <?php
                                                    if (isset($dob_day)) {
                                                        ?>
                                                        <option value="<?php echo $dob_day; ?>"><?php echo $dob_day; ?></option>
        <?php } else { ?>
                                                        <option value="">Day</option>
        <?php } ?>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>  
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control input-md" name="dob_month">
                                                    <?php
                                                    if (isset($dob_month)) {
                                                        ?>
                                                        <option value="<?php echo $dob_month; ?>"><?php echo $dob_month; ?></option>
        <?php } else { ?>
                                                        <option value="">Month</option>
        <?php } ?>
                                                    <option value="Jan">Jan</option>
                                                    <option value="Feb">Feb</option>
                                                    <option value="Mar">Mar</option>
                                                    <option value="Apr">Apr</option>
                                                    <option value="May">May</option>
                                                    <option value="Jun">Jun</option>
                                                    <option value="Jul">Jul</option>
                                                    <option value="Aug">Aug</option>
                                                    <option value="Sep">Sep</option>
                                                    <option value="Oct">Oct</option>
                                                    <option value="Nov">Nov</option>
                                                    <option value="Dec">Dec</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control input-md" name="dob_year">
                                                    <?php
                                                    if (isset($dob_year)) {
                                                        ?>
                                                        <option value="<?php echo $dob_year; ?>"><?php echo $dob_year; ?></option>
                                                    <?php } else { ?>
                                                        <option value="">Year</option>
                                                    <?php } ?>
                                                    <?php
                                                    $INCyear = date("Y") - 100;

                                                    for ($i = 0; $i <= 100; ++$i) {
                                                        ?>
                                                        <option value="<?php echo $INCyear; ?>"><?php echo $INCyear; ?></option>
            <?php
            ++$INCyear;
        }
        ?>
                                                </select> 
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="col-md-4"> 
                                                <select class="form-control input-md" name="dob_day2">
                                                    <?php
                                                    if (isset($dob_day2)) {
                                                        ?>
                                                        <option value="<?php echo $dob_day2; ?>"><?php echo $dob_day2; ?></option>
        <?php } else { ?>
                                                        <option value="">Day (2)</option>
        <?php } ?>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>  
                                            </div>

                                            <div class="col-md-4"> 
                                                <select class="form-control input-md" name="dob_month2">
                                                    <?php
                                                    if (isset($dob_month2)) {
                                                        ?>
                                                        <option value="<?php echo $dob_month2; ?>"><?php echo $dob_month2; ?></option>
        <?php } else { ?>
                                                        <option value="">Month (2)</option>
        <?php } ?>
                                                    <option value="Jan">Jan</option>
                                                    <option value="Feb">Feb</option>
                                                    <option value="Mar">Mar</option>
                                                    <option value="Apr">Apr</option>
                                                    <option value="May">May</option>
                                                    <option value="Jun">Jun</option>
                                                    <option value="Jul">Jul</option>
                                                    <option value="Aug">Aug</option>
                                                    <option value="Sep">Sep</option>
                                                    <option value="Oct">Oct</option>
                                                    <option value="Nov">Nov</option>
                                                    <option value="Dec">Dec</option>
                                                </select>  
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control input-md" name="dob_year2">
                                                    <?php
                                                    if (isset($dob_year2)) {
                                                        ?>
                                                        <option value="<?php echo $dob_year2; ?>"><?php echo $dob_year2; ?></option>
                                                    <?php } else { ?>
                                                        <option value="">Year (2)</option>
                                                    <?php
                                                    }
                                                    $INCyear = date("Y") - 100;

                                                    for ($i = 0; $i <= 100; ++$i) {
                                                        ?>
                                                        <option value="<?php echo $INCyear; ?>"><?php echo $INCyear; ?></option>
            <?php
            ++$INCyear;
        }
        ?>
                                                </select>  
                                            </div>

                                        </div>

                                        <div class="col-md-12"><br></div>

                                        <div class="col-md-12">

                                            <div class="col-md-3">
                                                <label class="col-md-4 control-label" for="textinput">PostCode</label>
                                                <input type="text" name="postcode" class="form-control input-md" placeholder="Post Code" value="<?php if (isset($data2['postcode'])) {
            echo $data2['postcode'];
        } ?>">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="col-md-4 control-label" for="textinput">Mobile</label>
                                                <input type="text" name="mobile" class="form-control input-md" placeholder="Mobile No" required pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" value="<?php if (isset($data2['mobile'])) {
            echo $data2['mobile'];
        } ?>">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="col-md-4 control-label" for="textinput">Home</label>
                                                <input type="text" name="home" class="form-control input-md" placeholder="Home No" pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" value="<?php if (isset($data2['home'])) {
            echo $data2['home'];
        } ?>">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="col-md-4 control-label" for="textinput">Email</label>
                                                <input type="text" name="email" class="form-control input-md" placeholder="Email" value="<?php if (isset($data2['email'])) {
            echo $data2['email'];
        } ?>">
                                            </div>

                                        </div>

                                        <div class="col-md-12"><br></div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-info">
                            <div class="panel-heading"><i class="fa fa-exclamation-triangle"></i> Qualifying Section</div>
                            <div class="panel-body">

                                <h4 style="color:blue;">1. What was the main reason why you took out the policy in the first place?</h4>

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q1a" style="color:blue;">Family</label>
                                    <input type="text" name="q1a" class="form-control input-md" value="<?php if (isset($data3['q1a'])) {
            echo $data3['q1a'];
        } ?>">
                                </div>

                                <div class="col-md-2">
                                    <label class="col-md-2 control-label" for="q1b" style="color:blue;">Mortgage</label>
                                    <input type="text" name="q1b" class="form-control input-md" placeholder="£" value="<?php if (isset($data3['q1b'])) {
            echo $data3['q1b'];
        } ?>">
                                </div>

                                <div class="col-md-2">
                                    <label class="col-md-2 control-label" for="q1c" style="color:blue;">Years</label>
                                    <input type="text" name="q1c" class="form-control input-md" placeholder="5 years" value="<?php if (isset($data3['q1c'])) {
                                    echo $data3['q1c'];
                                } ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label" for="q1d" style="color:red;">Repayments/Interest Only</label>
                                    <select name="q1d" class="form-control input-md">
        <?php
        if (isset($data3['q1d'])) {
            ?>
                                            <option value="<?php echo $data3['q1d']; ?>"><?php echo $data3['q1d']; ?></option>
        <?php } else { ?>
                                            <option value="">Select</option>
        <?php } ?>
                                        <option value="Repayments">Repayments</option>
                                        <option value="Interest Only">Interest Only</option>
                                    </select> 
                                </div>

                                <div class="col-md-12"><br></div>  

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q2a">2. When was your last review on the policy?</label>
                                    <input type="text" name="q2a" class="form-control input-md" value="<?php if (isset($data3['q2a'])) {
            echo $data3['q2a'];
        } ?>">
                                </div>  

                                <div class="col-md-12"><br></div> 

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q3a">3. How did you take out the policy?</label>
                                    <input type="text" name="q3a" class="form-control input-md" placeholder="Broker, Financial Advisor, etc..." value="<?php if (isset($data3['q3a'])) {
            echo $data3['q3a'];
        } ?>">
                                </div> 

                                <div class="col-md-12"><br></div> 

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q4a">4. Have your circumstances changed since taking out the policy?</label>
                                    <input type="text" name="q4a" class="form-control input-md" placeholder="Married, divored, children, moved home, etc..." value="<?php if (isset($data3['q4a'])) {
            echo $data3['q4a'];
        } ?>">
                                </div>

                                <div class="col-md-12"><br></div>

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q4b" style="color:red;">How much are you paying on a monthly basis?</label>
                                    <input type="text" name="q4b" class="form-control input-md" placeholder="£" value="<?php if (isset($data3['q4b'])) {
            echo $data3['q4b'];
        } ?>">
                                </div>

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q4c" style="color:red;">How much are you covered for?</label>
                                    <input type="text" name="q4c" class="form-control input-md" placeholder="£" value="<?php if (isset($data3['q4c'])) {
            echo $data3['q4c'];
        } ?>">
                                </div>

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q4d" style="color:red;">How long do you have left on the policy?</label>
                                    <input type="text" name="q4d" class="form-control input-md" value="<?php if (isset($data3['q4d'])) {
            echo $data3['q4d'];
        } ?>">
                                </div>

                                <div class="col-md-12"><br></div> 

                                <center>

                                    <div class="col-md-12">
                                        <label class="radio-inline" for="q4e-0" style="color:blue;">
                                            <input name="q4e" id="radios-0" q4e="1" type="radio" <?php if (isset($data3['q4e'])) {
            if ($data3['q4e'] == '1') {
                echo "checked";
            }
        } ?>>
                                            Single Policy
                                        </label> 
                                        <label class="radio-inline" for="q4e-1" style="color:blue;">
                                            <input name="q4e" id="radios-1" q4e="2" type="radio" <?php if (isset($data3['q4e'])) {
            if ($data3['q4e'] == '2') {
                echo "checked";
            }
        } ?>>
                                            Joint Policy
                                        </label> 
                                        <label class="radio-inline" for="q4e-2" style="color:blue;">
                                            <input name="q4e" id="q4e-2" value="3" type="radio" <?php if (isset($data3['q4e'])) {
            if ($data3['q4e'] == '3') {
                echo "checked";
            }
        } ?>>
                                            Separate Policies
                                        </label> 
                                    </div>
                                </center>

                                <div class="col-md-12"> 
                                    <label class="col-md-12 control-label" for="q5a" style="color:blue;">1. Have you smoked in the last 12 months?</label>

                                    <label class="radio-inline" for="q5a-0">
                                        <input name="q5a" id="q5a-0" value="1" type="radio" <?php if (isset($data3['q5a'])) {
            if ($data3['q5a'] == '1') {
                echo "checked";
            }
        } ?>>
                                        You
                                    </label> 
                                    <label class="radio-inline" for="q5a-1">
                                        <input name="q5a" id="q5a-1" value="2" type="radio" <?php if (isset($data3['q5a'])) {
            if ($data3['q5a'] == '2') {
                echo "checked";
            }
        } ?>>
                                        Partner (if applicable)
                                    </label> 
                                </div>

                                <div class="col-md-12"><br></div>

                                <div class="col-md-12"> 
                                    <label class="col-md-12 control-label" for="q6a">2. Do you have or have you ever had any health issues?</label>
                                    <label class="radio-inline" for="q6a-0">
                                        <input name="q6a" id="q6a-0" value="1" type="radio" <?php if (isset($data3['q6a'])) {
            if ($data3['q6a'] == '1') {
                echo "checked";
            }
        } ?>>
                                        You
                                    </label> 
                                    <label class="radio-inline" for="q6a-1">
                                        <input name="q6a" id="q6a-1" value="2" type="radio" <?php if (isset($data3['q6a'])) {
            if ($data3['q6a'] == '2') {
                echo "checked";
            }
        } ?>>
                                        Partner (if applicable)
                                    </label> 

                                    <input type="text" name="q6b" class="form-control input-md" value="<?php if (isset($data3['q6b'])) {
            echo $data3['q6b'];
        } ?>">
                                </div>

                                <div class="col-md-12"><br></div>

                                <div class="form-group">
                                    <label class="col-md-1 control-label" for="q7a">3.</label>
                                    <div class="col-md-4"> 
                                        <label class="radio-inline" for="q7a-0">
                                            <input name="q7a" id="q7a-0" value="1" type="radio" <?php if (isset($data3['q7a'])) {
            if ($data3['q7a'] == '1') {
                echo "checked";
            }
        } ?>>
                                            Reduce Premium
                                        </label> 
                                        <label class="radio-inline" for="q7a-1">
                                            <input name="q7a" id="q7a-1" value="2" type="radio" <?php if (isset($data3['q7a'])) {
            if ($data3['q7a'] == '2') {
                echo "checked";
            }
        } ?>>
                                            Higher Level of Cover
                                        </label> 
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label class="col-md-12 control-label" for="comments">Comments</label>
                                        <input type="text" name="comments" class="form-control input-md" value="<?php if (isset($data3['comments'])) {
            echo $data3['comments'];
        } ?>">
                                    </div> 

                                    <div class="col-md-6">
                                        <label class="col-md-12 control-label" for="callback">Callback time</label>
                                        <input type="text" name="callback" class="form-control input-md" value="<?php if (isset($data3['callback'])) {
            echo $data3['callback'];
        } ?>">
                                    </div>
                                </div>

                            </div>
                        </div>

        <?php
if (in_array($hello_name, $Closer_Access, true) || in_array($hello_name, $Manager, true) || in_array($hello_name, $QA_Access, true)) {
            ?>

                            <div class="panel panel-danger">
                                <div class="panel-heading">CLOSERS USE ONLY</div>
                                <div class="panel-body">

                                    <div class="col-md-6">
                                        <label class="col-md-6 control-label" for="exist_pol">EXISTING POLICY NUMBER</label>
                                        <input type="text" name="exist_pol" class="form-control input-md" placeholder="Existing policy number" value="<?php if (isset($data4['exist_pol'])) {
                echo $data4['exist_pol'];
            } ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <p>
                                            <label for="closer">CLOSER NAME:</label>
                                            <input type='text' id='closer' name='closer' class="form-control" value="<?php if (isset($data2['closer'])) {
                echo $data2['closer'];
            } ?>" readonly>
                                        </p>
                                        <br>
                                    </div>

                                    <div class="col-md-12">
                                        <h4>NEW POLICY 1</h4>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-md-2 control-label" for="pol_1_num">POLICY#</label>
                                        <input type="text" name="pol_1_num" class="form-control input-md" placeholder="New Policy Number"  maxlength="20"value="<?php if (isset($data4['pol_num_1'])) {
                echo $data4['pol_num_1'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_1_pre">PREMIUM</label>
                                        <input type="text" name="pol_1_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_1_pre'])) {
                echo $data4['pol_num_1_pre'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_1_com">COMM</label>
                                        <input type="text" name="pol_1_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_1_com'])) {
                echo $data4['pol_num_1_com'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_1_cov">COVER</label>
                                        <input type="text" name="pol_1_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_1_cov'])) {
                echo $data4['pol_num_1_cov'];
            } ?>">  
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_1_yr">YRS</label>
                                        <input type="text" name="pol_1_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_1_yr'])) {
                echo $data4['pol_num_1_yr'];
            } ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label class="checkbox-inline" for="pol_1_type-0">
                                            <input name="pol_1_type" id="pol_1_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '1') {
                    echo "checked";
                }
            } ?>>
                                            LTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_1_type-1">
                                            <input name="pol_1_type" id="pol_1_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '2') {
                    echo "checked";
                }
            } ?>>
                                            LTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="pol_1_type-2">
                                            <input name="pol_1_type" id="pol_1_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '3') {
                    echo "checked";
                }
            } ?>>>
                                            DTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_1_type-3">
                                            <input name="pol_1_type" id="pol_1_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '4') {
                    echo "checked";
                }
            } ?>>
                                            DTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="checkboxes-4">
                                            <input name="pol_1_type" id="pol_1_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '5') {
                    echo "checked";
                }
            } ?>>
                                            CIC
                                        </label> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label" for="pol_1_soj">S/J 1,2?</label>
                                        <input type="text" name="pol_1_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_2_soj'])) {
                echo $data4['pol_num_2_soj'];
            } ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <h4>NEW POLICY 2</h4>  
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-md-2 control-label" for="pol_2_num">POLICY#</label>
                                        <input type="text" name="pol_2_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_2'])) {
                echo $data4['pol_num_2'];
            } ?>"> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_2_pre">PREMIUM</label>
                                        <input type="text" name="pol_2_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_2_pre'])) {
                echo $data4['pol_num_2_pre'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_2_com">COMM</label>
                                        <input type="text" name="pol_2_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_2_com'])) {
                echo $data4['pol_num_2_com'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_2_cov">COVER</label>
                                        <input type="text" name="pol_2_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_2_cov'])) {
                echo $data4['pol_num_2_cov'];
            } ?>">  
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_2_yr">YRS</label>
                                        <input type="text" name="pol_2_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_2_yr'])) {
                echo $data4['pol_num_2_yr'];
            } ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label class="checkbox-inline" for="pol_2_type-0">
                                            <input name="pol_2_type" id="pol_2_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '1') {
                    echo "checked";
                }
            } ?>>
                                            LTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_2_type-1">
                                            <input name="pol_2_type" id="pol_2_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '2') {
                    echo "checked";
                }
            } ?>>
                                            LTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="pol_2_type-2">
                                            <input name="pol_2_type" id="pol_2_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '3') {
                    echo "checked";
                }
            } ?>>
                                            DTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_2_type-3">
                                            <input name="pol_2_type" id="pol_2_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '4') {
                    echo "checked";
                }
            } ?>>
                                            DTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="checkboxes-4">
                                            <input name="pol_2_type" id="pol_2_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '5') {
                    echo "checked";
                }
            } ?>>
                                            CIC
                                        </label> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label" for="pol_2_soj">S/J 1,2?</label>
                                        <input type="text" name="pol_2_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_3_soj'])) {
                echo $data4['pol_num_3_soj'];
            } ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <h4>NEW POLICY 3</h4>
                                    </div>        

                                    <div class="col-md-2">
                                        <label class="col-md-2 control-label" for="pol_3_num">POLICY#</label>
                                        <input type="text" name="pol_3_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_3'])) {
                echo $data4['pol_num_3'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_3_pre">PREMIUM</label>
                                        <input type="text" name="pol_3_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_3_pre'])) {
                echo $data4['pol_num_3_pre'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_3_com">COMM</label>
                                        <input type="text" name="pol_3_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_3_com'])) {
                echo $data4['pol_num_3_com'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_3_cov">COVER</label>
                                        <input type="text" name="pol_3_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_3_cov'])) {
                echo $data4['pol_num_3_cov'];
            } ?>">  
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_3_yr">YRS</label>
                                        <input type="text" name="pol_3_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_3_yr'])) {
                echo $data4['pol_num_3_yr'];
            } ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label class="checkbox-inline" for="pol_3_type-0">
                                            <input name="pol_3_type" id="pol_3_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == '1') {
                    echo "checked";
                }
            } ?>>
                                            LTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_3_type-1">
                                            <input name="pol_3_type" id="pol_3_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == '2') {
                    echo "checked";
                }
            } ?>>
                                            LTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="pol_3_type-2">
                                            <input name="pol_3_type" id="pol_3_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                if ($data4['pol_num_3_type'] == '3') {
                                    echo "checked";
                                }
                            } ?>>
                                            DTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_3_type-3">
                                            <input name="pol_3_type" id="pol_3_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                if ($data4['pol_num_3_type'] == '4') {
                                    echo "checked";
                                }
                            } ?>>
                                            DTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="checkboxes-4">
                                            <input name="pol_3_type" id="pol_3_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                if ($data4['pol_num_3_type'] == '5') {
                                    echo "checked";
                                }
                            } ?>>
                                            CIC
                                        </label> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label" for="pol_3_soj">S/J 1,2?</label>
                                        <input type="text" name="pol_3_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_3_soj'])) {
                                echo $data4['pol_num_3_soj'];
                            } ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <h4>NEW POLICY 4</h4>
                                    </div>        

                                    <div class="col-md-2">
                                        <label class="col-md-2 control-label" for="pol_4_num">POLICY#</label>
                                        <input type="text" name="pol_4_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_4'])) {
                echo $data4['pol_num_4'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_4_pre">PREMIUM</label>
                                        <input type="text" name="pol_4_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_4_pre'])) {
                echo $data4['pol_num_4_pre'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_4_com">COMM</label>
                                        <input type="text" name="pol_4_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_4_com'])) {
                echo $data4['pol_num_4_com'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_4_cov">COVER</label>
                                        <input type="text" name="pol_4_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_4_cov'])) {
                echo $data4['pol_num_4_cov'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_4_yr">YRS</label>
                                        <input type="text" name="pol_4_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_4_yr'])) {
                echo $data4['pol_num_4_yr'];
            } ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label class="checkbox-inline" for="pol_4_type-0">
                                            <input name="pol_4_type" id="pol_4_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '1') {
                    echo "checked";
                }
            } ?>>
                                            LTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_4_type-1">
                                            <input name="pol_4_type" id="pol_4_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '2') {
                    echo "checked";
                }
            } ?>>
                                            LTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="pol_4_type-2">
                                            <input name="pol_4_type" id="pol_4_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '3') {
                    echo "checked";
                }
            } ?>>
                                            DTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_4_type-3">
                                            <input name="pol_4_type" id="pol_4_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '4') {
                    echo "checked";
                }
            } ?>>
                                            DTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="checkboxes-4">
                                            <input name="pol_4_type" id="pol_4_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                                            if ($data4['pol_num_4_type'] == '5') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            CIC
                                        </label> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label" for="pol_4_soj">S/J 1,2?</label>
                                        <input type="text" name="pol_4_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_4_soj'])) {
                                            echo $data4['pol_num_4_soj'];
                                        } ?>">
                                    </div> 

                                    <div class="col-md-12"><br></div>

                                    <div class="col-md-12"> 
                                        <label class="col-md-4 control-label" for="textinput" style="color:red;">CHECKED ON DEALSHEET</label>
                                        <label class="checkbox-inline" for="checkboxes-0">
                                            <input name="chk_postcode" id="chk_postcode-0" value="1" type="checkbox" <?php if (isset($data4['chk_post'])) {
                                            if ($data4['chk_post'] == '1') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            POST CODE
                                        </label> 
                                        <label class="checkbox-inline" for="chk_dob-1">
                                            <input name="chk_dob" id="chk_dob-1" value="1" type="checkbox" <?php if (isset($data4['chk_dob'])) {
                                            if ($data4['chk_dob'] == '1') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            DOB
                                        </label> 
                                        <label class="checkbox-inline" for="chk_mob-0">
                                            <input name="chk_mob" id="chk_mob-0" value="1" type="checkbox" <?php if (isset($data4['chk_mob'])) {
                                            if ($data4['chk_mob'] == '1') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            MOBILE NO
                                        </label> 
                                        <label class="checkbox-inline" for="chk_home-0">
                                            <input name="chk_home" id="chk_home-0" value="1" type="checkbox" <?php if (isset($data4['chk_home'])) {
                                            if ($data4['chk_home'] == '1') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            HOME NO
                                        </label> 
                                        <label class="checkbox-inline" for="chk_email-0">
                                            <input name="chk_email" id="chk_email-0" value="1" type="checkbox" <?php if (isset($data4['chk_email'])) {
                                            if ($data4['chk_email'] == '1') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            EMAIL
                                        </label> 
                                    </div>

                                    <div class="col-md-12"><br></div>

                                    <div class="col-md-12">
                                        <div class="col-md-2">

                                            <label class="col-md-4 control-label" for="fee">FEE</label>
                                            <input type="text" name="fee" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['fee'])) {
                                            echo $data4['fee'];
                                        } ?>">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-md-4 control-label" for="total">COMMS</label>
                                            <input type="text" name="total" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['total'])) {
                                            echo $data4['total'];
                                        } ?>"> 
                                        </div>

                                        <div class="col-md-1">
                                            <label class="col-md-4 control-label" for="years">YEARS</label>
                                            <input type="text" name="years" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['years'])) {
                                            echo $data4['years'];
                                        } ?>">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="col-md-4 control-label" for="month">MONTHS</label>
                                            <input type="text" name="month" class="form-control input-md" placeholder="Months" value="<?php if (isset($data4['month'])) {
                                            echo $data4['month'];
                                        } ?>">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-md-4 control-label" for="comm_after">COMMSAFTER</label>
                                            <input type="text" name="comm_after" class="form-control input-md" placeholder="" value="<?php if (isset($data4['comm_after'])) {
                                            echo $data4['comm_after'];
                                        } ?>">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="col-md-4 control-label" for="sac">SAC</label>
                                            <input type="text" name="sac" class="form-control input-md" placeholder="%" value="<?php if (isset($data4['sac'])) {
                                            echo $data4['sac'];
                                        } ?>">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-md-4 control-label" for="closer_date">DATE</label>
                                            <input type="text" name="closer_date" class="form-control input-md" placeholder="" value="<?php if (isset($data4['date'])) {
                                                echo $data4['date'];
                                            } ?>"> 
                                        </div>

                                    </div>
    </div>
                    </div>
        
                    <div class="panel panel-danger">
                <div class="panel-heading">Mortgage</div>
                <div class="panel-body">
                        
<div class="row">   
                    <div class="col-md-12">
                        <label for="MORTGAGE_TYPE">Mortgage Type</label>
                        <label class="radio-inline" for="Fixed-0">
                            <input name="MORTGAGE_TYPE" id="Fixed-0" value="Fixed" type="radio" <?php if(isset($data5['type'])) { if($data5['type']=='Fixed') { echo "checked"; } } ?> >
                            Fixed
                        </label> 
                        <label class="radio-inline" for="Variable-1">
                            <input name="MORTGAGE_TYPE" id="Variable-1" value="Variable" type="radio" <?php if(isset($data5['type'])) { if($data5['type']=='Variable') { echo "checked"; } } ?> >
                            Variable
                        </label> 
                        <label class="radio-inline" for="Tracker-2"">
                            <input name="MORTGAGE_TYPE" id="Tracker-2" value="Tracker" type="radio" <?php if(isset($data5['type'])) { if($data5['type']=='Tracker') { echo "checked"; } } ?> >
                            Tracker
                        </label> 
                    </div>
                    
                                        <div class="col-md-12">
                        <label for="MORTGAGE_REASON">Review Reason</label>
                        <label class="radio-inline" for="Fixed-0">
                            <input name="MORTGAGE_REASON" id="Fixed-0" value="Lower Interest Rates" type="radio" <?php if(isset($data5['reason'])) { if($data5['reason']=='Lower Interest Rates') { echo "checked"; } } ?> >
                            Lower Interest Rates
                        </label> 
                        <label class="radio-inline" for="Variable-1">
                            <input name="MORTGAGE_REASON" id="Variable-1" value="Remortgage" type="radio" <?php if(isset($data5['reason'])) { if($data5['reason']=='Remortgage') { echo "checked"; } } ?> >
                            Remortgage
                        </label> 
                        <label class="radio-inline" for="Tracker-2">
                            <input name="MORTGAGE_REASON" id="Tracker-2" value="Save Money" type="radio" <?php if(isset($data5['reason'])) { if($data5['reason']=='Save Money') { echo "checked"; } } ?> >
                            Save Money
                        </label> 
                  
    </div>
                       <div class="col-md-12">
                           <div class="col-md-4">
                            <input type="text" name="MORTGAGE_CB_DATE" class="form-control input-md" placeholder="Callback date" value="<?php if(isset($data5['cb_date'])) { echo $data5['cb_date']; } ?>" > 
                           </div>
    
                    <div class="col-md-4">  
                            <input type="text" name="MORTGAGE_CB_TIME" class="form-control input-md" placeholder="Callback time" value="<?php if(isset($data5['cb_time'])) { echo $data5['cb_time']; } ?>"> 
                    </div>
                       </div>
         
</div>

                    </div>
                </div>
                    </div>

        <?php } ?>

                        <div class="col-md-12"><br></div>

                        <center>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">
                                <select class="form-control" name="closer">
                                                    <?php
                                                    if (isset($data2['closer'])) {
                                                        ?>
                                        <option value="<?php echo $data2['closer']; ?>"><?php echo $data2['closer']; ?></option>
                                                    <?php } else { ?>
                                        <option value="">Closer</option>
                                                    <?php } ?>
                            <option value="James">James Adams</option>
                            <option value="Kyle">Kyle Barnett</option>  
                            <option value="David">David Bebee</option> 
                            <option value="Richard">Richard Michaels</option>
                            <option value="Hayley">Hayley Hutchinson</option> 
                            <option value="Sarah">Sarah Wallace</option>
                            <option value="Gavin">Gavin Fulford</option> 
                            <option value="Mike">Michael Lloyd</option> 
                            <option value="carys">Carys Riley</option>
                            <option value="abbiek">Abbie Kenyon</option>
                            <option value="Nicola">Nicola Griffiths</option>
                            <option value="Keith">Keith Dance</option>
                                </select>
                            </div>

                            <div class="col-md-4"></div>  

                            <div class="col-md-12"><br></div> 

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> SEND TO CLOSER</button>
                            </div>

                        </center>
                        </form>

                    </div> <?php
                                        }

                                        if ($QUERY == 'ViewQADealSheet') {

                                            require_once(__DIR__ . '/../classes/database_class.php');

                                            $deal_id = filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_NUMBER_INT);

                                            $database = new Database();

                                            $database->query("SELECT date_added, agent, closer, title, forename, surname, dob, title2, forename2, surname2, dob2, postcode, mobile, home, email FROM dealsheet_prt1 WHERE deal_id=:deal_id");
                                            $database->bind(':deal_id', $deal_id);
                                            $database->execute();
                                            $data2 = $database->single();

                                            list($dob_year, $dob_month, $dob_day) = explode(" ", $data2['dob']);
                                            list($dob_year2, $dob_month2, $dob_day2) = explode(" ", $data2['dob2']);

                                            $database->query("SELECT q1a, q1b, q1c, q1d, q2a, q3a, q4a, q4b, q4c, q4d, q4e, q5a, q6a, q6b, q7a, comments, callback FROM dealsheet_prt2 WHERE deal_id=:deal_id");
                                            $database->bind(':deal_id', $deal_id);
                                            $database->execute();
                                            $data3 = $database->single();

                                            $database->query("SELECT exist_pol, pol_num_1, pol_num_1_pre, pol_num_1_com, pol_num_1_cov, pol_num_1_yr, pol_num_1_type, pol_num_1_soj, pol_num_2, pol_num_2_pre, pol_num_2_com, pol_num_2_cov, pol_num_2_yr, pol_num_2_type, pol_num_2_soj, pol_num_3, pol_num_3_pre, pol_num_3_com, pol_num_3_cov, pol_num_3_yr, pol_num_3_type, pol_num_3_soj, pol_num_4, pol_num_4_pre, pol_num_4_com, pol_num_4_cov, pol_num_4_yr, pol_num_4_type, pol_num_4_soj, chk_post, chk_dob, chk_mob, chk_home, chk_email, fee, total, years, month, comm_after, sac, date FROM dealsheet_prt3 WHERE deal_id=:deal_id");
                                            $database->bind(':deal_id', $deal_id);
                                            $database->execute();
                                            $data4 = $database->single();
                                            
                                            $database->query("SELECT cb_date, cb_time, type, reason FROM dealsheet_prt4 WHERE deal_id=:deal_id");
                                            $database->bind(':deal_id', $deal_id);
                                            $database->execute();
                                            $data5 = $database->single();  
                                            ?>

                    <div class="container">

                        <form id="Send" class="form" method="POST" action="php/DealSheet.php?dealsheet=QA&REF=<?php echo $deal_id; ?>">
                            <div class="col-md-4">
                                <img height="80" src="/img/RBlogo.png"><br>
                            </div>

                            <div class="col-md-4">
                                <label class="col-md-6 control-label" for="textinput">DATE</label>
                                <input type="text" name="deal_date" class="form-control input-md" placeholder="" value="<?php echo $data2['date_added']; ?>">
                            </div>

                            <div class="col-md-4">
                                <p>
                                    <label class="col-md-6 control-label" for="agent">LEAD AGENT:</label>
                                    <input type='text' id='agent' name='agent' class="form-control input-md" value="<?php echo $data2['agent']; ?>" readonly>
                                </p>
                            </div>

                    </div>   
                    <br>

                    <div class="container">
                        <div class="panel-group">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><i class="fa fa-user"></i> Client Details</div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <center> <h4>Client 1</h4></center>
                                        </div>
                                        <div class="col-md-6">
                                            <center><h4>Client 2</h4></center>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-1 control-label" for="title">Title</label> 
                                            <select class="form-control input-md" name="title">
                                                    <?php
                                                    if (isset($data2['title'])) {
                                                        ?>
                                                    <option value="<?php echo $data2['title']; ?>"><?php echo $data2['title']; ?></option>
                                                    <?php } else { ?>
                                                    <option value="">Title</option>
        <?php } ?>
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Miss">Miss</option>
                                                <option value="Ms">Ms</option>
                                                <option value="Dr">Dr</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-1 control-label" for="title2">Title</label>  
                                            <select class="form-control input-md" name="title2">
        <?php
        if (isset($data2['title2'])) {
            ?>
                                                    <option value="<?php echo $data2['title2']; ?>"><?php echo $data2['title2']; ?></option>
        <?php } else { ?>
                                                    <option value="">Title</option>
        <?php } ?>
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Miss">Miss</option>
                                                <option value="Ms">Ms</option>
                                                <option value="Dr">Dr</option>
                                            </select>  
                                        </div>

                                        <div class="col-md-12"><br></div>

                                        <div class="col-md-6">
                                            <label class="col-md-6 control-label" for="textinput">Forename</label>
                                            <input type="text" name="forename" class="form-control input-md" placeholder="Forename" value="<?php if (isset($data2['forename'])) {
            echo $data2['forename'];
        } ?>">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-6 control-label" for="textinput">Forename</label>
                                            <input type="text" name="forename2" class="form-control input-md" placeholder="Forename" value="<?php if (isset($data2['forename2'])) {
            echo $data2['forename2'];
        } ?>">
                                        </div> 

                                        <div class="col-md-12"><br></div>     

                                        <div class="col-md-6">
                                            <label class="col-md-6 control-label" for="surname">Surname</label>
                                            <input type="text" name="surname" class="form-control input-md" placeholder="Surname" value="<?php if (isset($data2['surname'])) {
            echo $data2['surname'];
        } ?>">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-6 control-label" for="surname2">Surname</label>
                                            <input type="text" name="surname2" class="form-control input-md" placeholder="Surname" value="<?php if (isset($data2['surname2'])) {
            echo $data2['surname2'];
        } ?>">
                                        </div>

                                    </div>

                                    <br>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <select class="form-control input-md" name="dob_day">
        <?php
        if (isset($dob_day)) {
            ?>
                                                        <option value="<?php echo $dob_day; ?>"><?php echo $dob_day; ?></option>
        <?php } else { ?>
                                                        <option value="">Day</option>
        <?php } ?>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>  
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control input-md" name="dob_month">
        <?php
        if (isset($dob_month)) {
            ?>
                                                        <option value="<?php echo $dob_month; ?>"><?php echo $dob_month; ?></option>
        <?php } else { ?>
                                                        <option value="">Month</option>
        <?php } ?>
                                                    <option value="Jan">Jan</option>
                                                    <option value="Feb">Feb</option>
                                                    <option value="Mar">Mar</option>
                                                    <option value="Apr">Apr</option>
                                                    <option value="May">May</option>
                                                    <option value="Jun">Jun</option>
                                                    <option value="Jul">Jul</option>
                                                    <option value="Aug">Aug</option>
                                                    <option value="Sep">Sep</option>
                                                    <option value="Oct">Oct</option>
                                                    <option value="Nov">Nov</option>
                                                    <option value="Dec">Dec</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control input-md" name="dob_year">
        <?php
        if (isset($dob_year)) {
            ?>
                                                        <option value="<?php echo $dob_year; ?>"><?php echo $dob_year; ?></option>
        <?php } else { ?>
                                                        <option value="">Year</option>
        <?php
        }
        $INCyear = date("Y") - 100;

        for ($i = 0; $i <= 100; ++$i) {
            ?>
                                                        <option value="<?php echo $INCyear; ?>"><?php echo $INCyear; ?></option>
            <?php
            ++$INCyear;
        }
        ?>
                                                </select> 
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="col-md-4"> 
                                                <select class="form-control input-md" name="dob_day2">
        <?php
        if (isset($dob_day2)) {
            ?>
                                                        <option value="<?php echo $dob_day2; ?>"><?php echo $dob_day2; ?></option>
        <?php } else { ?>
                                                        <option value="">Day</option>
        <?php } ?>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>  
                                            </div>

                                            <div class="col-md-4"> 
                                                <select class="form-control input-md" name="dob_month2">
        <?php
        if (isset($dob_month2)) {
            ?>
                                                        <option value="<?php echo $dob_month2; ?>"><?php echo $dob_month2; ?></option>
        <?php } else { ?>
                                                        <option value="">Month</option>
        <?php } ?>
                                                    <option value="Jan">Jan</option>
                                                    <option value="Feb">Feb</option>
                                                    <option value="Mar">Mar</option>
                                                    <option value="Apr">Apr</option>
                                                    <option value="May">May</option>
                                                    <option value="Jun">Jun</option>
                                                    <option value="Jul">Jul</option>
                                                    <option value="Aug">Aug</option>
                                                    <option value="Sep">Sep</option>
                                                    <option value="Oct">Oct</option>
                                                    <option value="Nov">Nov</option>
                                                    <option value="Dec">Dec</option>
                                                </select>  
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control input-md" name="dob_year2">
        <?php
        if (isset($dob_year2)) {
            ?>
                                                        <option value="<?php echo $dob_year2; ?>"><?php echo $dob_year2; ?></option>
        <?php } else { ?>
                                                        <option value="">Year</option>
        <?php
        }
        $INCyear = date("Y") - 100;

        for ($i = 0; $i <= 100; ++$i) {
            ?>
                                                        <option value="<?php echo $INCyear; ?>"><?php echo $INCyear; ?></option>
            <?php
            ++$INCyear;
        }
        ?>
                                                </select>  
                                            </div>

                                        </div>

                                        <div class="col-md-12"><br></div>

                                        <div class="col-md-12">

                                            <div class="col-md-3">
                                                <label class="col-md-4 control-label" for="textinput">PostCode</label>
                                                <input type="text" name="postcode" class="form-control input-md" placeholder="Post Code" value="<?php if (isset($data2['postcode'])) {
            echo $data2['postcode'];
        } ?>">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="col-md-4 control-label" for="textinput">Mobile</label>
                                                <input type="text" name="mobile" class="form-control input-md" placeholder="Mobile No" required pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" value="<?php if (isset($data2['mobile'])) {
            echo $data2['mobile'];
        } ?>">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="col-md-4 control-label" for="textinput">Home</label>
                                                <input type="text" name="home" class="form-control input-md" placeholder="Home No" pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" value="<?php if (isset($data2['home'])) {
            echo $data2['home'];
        } ?>">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="col-md-4 control-label" for="textinput">Email</label>
                                                <input type="text" name="email" class="form-control input-md" placeholder="Email" value="<?php if (isset($data2['email'])) {
            echo $data2['email'];
        } ?>">
                                            </div>

                                        </div>

                                        <div class="col-md-12"><br></div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-info">
                            <div class="panel-heading"><i class="fa fa-exclamation-triangle"></i> Qualifying Section</div>
                            <div class="panel-body">

                                <h4 style="color:blue;">1. What was the main reason why you took out the policy in the first place?</h4>

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q1a" style="color:blue;">Family</label>
                                    <input type="text" name="q1a" class="form-control input-md" value="<?php if (isset($data3['q1a'])) {
            echo $data3['q1a'];
        } ?>">
                                </div>

                                <div class="col-md-2">
                                    <label class="col-md-2 control-label" for="q1b" style="color:blue;">Mortgage</label>
                                    <input type="text" name="q1b" class="form-control input-md" placeholder="£" value="<?php if (isset($data3['q1b'])) {
            echo $data3['q1b'];
        } ?>">
                                </div>

                                <div class="col-md-2">
                                    <label class="col-md-2 control-label" for="q1c" style="color:blue;">Years</label>
                                    <input type="text" name="q1c" class="form-control input-md" placeholder="5 years" value="<?php if (isset($data3['q1c'])) {
            echo $data3['q1c'];
        } ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label" for="q1d" style="color:red;">Repayments/Interest Only</label>
                                    <select name="q1d" class="form-control input-md">
        <?php
        if (isset($data3['q1d'])) {
            ?>
                                            <option value="<?php echo $data3['q1d']; ?>"><?php echo $data3['q1d']; ?></option>
        <?php } else { ?>
                                            <option value="">Select</option>
        <?php } ?>
                                        <option value="Repayments">Repayments</option>
                                        <option value="Interest Only">Interest Only</option>
                                    </select> 
                                </div>

                                <div class="col-md-12"><br></div>  

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q2a">2. When was your last review on the policy?</label>
                                    <input type="text" name="q2a" class="form-control input-md" value="<?php if (isset($data3['q2a'])) {
            echo $data3['q2a'];
        } ?>">
                                </div>  

                                <div class="col-md-12"><br></div> 

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q3a">3. How did you take out the policy?</label>
                                    <input type="text" name="q3a" class="form-control input-md" placeholder="Broker, Financial Advisor, etc..." value="<?php if (isset($data3['q3a'])) {
            echo $data3['q3a'];
        } ?>">
                                </div> 

                                <div class="col-md-12"><br></div> 

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q4a">4. Have your circumstances changed since taking out the policy?</label>
                                    <input type="text" name="q4a" class="form-control input-md" placeholder="Married, divored, children, moved home, etc..." value="<?php if (isset($data3['q4a'])) {
            echo $data3['q4a'];
        } ?>">
                                </div>

                                <div class="col-md-12"><br></div>

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q4b" style="color:red;">How much are you paying on a monthly basis?</label>
                                    <input type="text" name="q4b" class="form-control input-md" placeholder="£" value="<?php if (isset($data3['q4b'])) {
            echo $data3['q4b'];
        } ?>">
                                </div>

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q4c" style="color:red;">How much are you covered for?</label>
                                    <input type="text" name="q4c" class="form-control input-md" placeholder="£" value="<?php if (isset($data3['q4c'])) {
            echo $data3['q4c'];
        } ?>">
                                </div>

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q4d" style="color:red;">How long do you have left on the policy?</label>
                                    <input type="text" name="q4d" class="form-control input-md" value="<?php if (isset($data3['q4d'])) {
            echo $data3['q4d'];
        } ?>">
                                </div>

                                <div class="col-md-12"><br></div> 

                                <center>

                                    <div class="col-md-12">
                                        <label class="radio-inline" for="q4e-0" style="color:blue;">
                                            <input name="q4e" id="radios-0" q4e="1" type="radio" <?php if (isset($data3['q4e'])) {
            if ($data3['q4e'] == '1') {
                echo "checked";
            }
        } ?>>
                                            Single Policy
                                        </label> 
                                        <label class="radio-inline" for="q4e-1" style="color:blue;">
                                            <input name="q4e" id="radios-1" q4e="2" type="radio" <?php if (isset($data3['q4e'])) {
            if ($data3['q4e'] == '2') {
                echo "checked";
            }
        } ?>>
                                            Joint Policy
                                        </label> 
                                        <label class="radio-inline" for="q4e-2" style="color:blue;">
                                            <input name="q4e" id="q4e-2" value="3" type="radio" <?php if (isset($data3['q4e'])) {
            if ($data3['q4e'] == '3') {
                echo "checked";
            }
        } ?>>
                                            Separate Policies
                                        </label> 
                                    </div>
                                </center>

                                <div class="col-md-12"> 
                                    <label class="col-md-12 control-label" for="q5a" style="color:blue;">1. Have you smoked in the last 12 months?</label>

                                    <label class="radio-inline" for="q5a-0">
                                        <input name="q5a" id="q5a-0" value="1" type="radio" <?php if (isset($data3['q5a'])) {
            if ($data3['q5a'] == '1') {
                echo "checked";
            }
        } ?>>
                                        You
                                    </label> 
                                    <label class="radio-inline" for="q5a-1">
                                        <input name="q5a" id="q5a-1" value="2" type="radio" <?php if (isset($data3['q5a'])) {
            if ($data3['q5a'] == '2') {
                echo "checked";
            }
        } ?>>
                                        Partner (if applicable)
                                    </label> 
                                </div>

                                <div class="col-md-12"><br></div>

                                <div class="col-md-12"> 
                                    <label class="col-md-12 control-label" for="q6a">2. Do you have or have you ever had any health issues?</label>
                                    <label class="radio-inline" for="q6a-0">
                                        <input name="q6a" id="q6a-0" value="1" type="radio" <?php if (isset($data3['q6a'])) {
            if ($data3['q6a'] == '1') {
                echo "checked";
            }
        } ?>>
                                        You
                                    </label> 
                                    <label class="radio-inline" for="q6a-1">
                                        <input name="q6a" id="q6a-1" value="2" type="radio" <?php if (isset($data3['q6a'])) {
            if ($data3['q6a'] == '2') {
                echo "checked";
            }
        } ?>>
                                        Partner (if applicable)
                                    </label> 

                                    <input type="text" name="q6b" class="form-control input-md" value="<?php if (isset($data3['q6b'])) {
            echo $data3['q6b'];
        } ?>">
                                </div>

                                <div class="col-md-12"><br></div>

                                <div class="form-group">
                                    <label class="col-md-1 control-label" for="q7a">3.</label>
                                    <div class="col-md-4"> 
                                        <label class="radio-inline" for="q7a-0">
                                            <input name="q7a" id="q7a-0" value="1" type="radio" <?php if (isset($data3['q7a'])) {
            if ($data3['q7a'] == '1') {
                echo "checked";
            }
        } ?>>
                                            Reduce Premium
                                        </label> 
                                        <label class="radio-inline" for="q7a-1">
                                            <input name="q7a" id="q7a-1" value="2" type="radio" <?php if (isset($data3['q7a'])) {
            if ($data3['q7a'] == '2') {
                echo "checked";
            }
        } ?>>
                                            Higher Level of Cover
                                        </label> 
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label class="col-md-12 control-label" for="comments">Comments</label>
                                        <input type="text" name="comments" class="form-control input-md" value="<?php if (isset($data3['comments'])) {
            echo $data3['comments'];
        } ?>">
                                    </div> 

                                    <div class="col-md-6">
                                        <label class="col-md-12 control-label" for="callback">Callback time</label>
                                        <input type="text" name="callback" class="form-control input-md" value="<?php if (isset($data3['callback'])) {
            echo $data3['callback'];
        } ?>">
                                    </div>
                                </div>

                            </div>
                        </div>

        <?php
        if (in_array($hello_name, $Closer_Access, true) || in_array($hello_name, $Manager, true) || in_array($hello_name, $QA_Access, true)) {
            ?>

                            <div class="panel panel-danger">
                                <div class="panel-heading">CLOSERS USE ONLY</div>
                                <div class="panel-body">

                                    <div class="col-md-6">
                                        <label class="col-md-6 control-label" for="exist_pol">EXISTING POLICY NUMBER</label>
                                        <input type="text" name="exist_pol" class="form-control input-md" placeholder="Existing policy number" value="<?php if (isset($data4['exist_pol'])) {
                echo $data4['exist_pol'];
            } ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <p>
                                            <label for="closer">CLOSER NAME:</label>
                                            <input type='text' id='closer' name='closer' class="form-control" value="<?php if (isset($data2['closer'])) {
                echo $data2['closer'];
            } ?>" readonly>
                                        </p>
                                        <br>
                                    </div>

                                    <div class="col-md-12">
                                        <h4>NEW POLICY 1</h4>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-md-2 control-label" for="pol_1_num">POLICY#</label>
                                        <input type="text" name="pol_1_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_1'])) {
                                echo $data4['pol_num_1'];
                            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_1_pre">PREMIUM</label>
                                        <input type="text" name="pol_1_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_1_pre'])) {
                                echo $data4['pol_num_1_pre'];
                            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_1_com">COMM</label>
                                        <input type="text" name="pol_1_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_1_com'])) {
                                echo $data4['pol_num_1_com'];
                            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_1_cov">COVER</label>
                                        <input type="text" name="pol_1_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_1_cov'])) {
                                echo $data4['pol_num_1_cov'];
                            } ?>">  
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_1_yr">YRS</label>
                                        <input type="text" name="pol_1_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_1_yr'])) {
                echo $data4['pol_num_1_yr'];
            } ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label class="checkbox-inline" for="pol_1_type-0">
                                            <input name="pol_1_type" id="pol_1_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '1') {
                    echo "checked";
                }
            } ?>>
                                            LTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_1_type-1">
                                            <input name="pol_1_type" id="pol_1_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '2') {
                    echo "checked";
                }
            } ?>>
                                            LTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="pol_1_type-2">
                                            <input name="pol_1_type" id="pol_1_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '3') {
                    echo "checked";
                }
            } ?>>>
                                            DTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_1_type-3">
                                            <input name="pol_1_type" id="pol_1_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '4') {
                    echo "checked";
                }
            } ?>>
                                            DTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="checkboxes-4">
                                            <input name="pol_1_type" id="pol_1_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '5') {
                    echo "checked";
                }
            } ?>>
                                            CIC
                                        </label> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label" for="pol_1_soj">S/J 1,2?</label>
                                        <input type="text" name="pol_1_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_2_soj'])) {
                echo $data4['pol_num_2_soj'];
            } ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <h4>NEW POLICY 2</h4>  
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-md-2 control-label" for="pol_2_num">POLICY#</label>
                                        <input type="text" name="pol_2_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_2'])) {
                echo $data4['pol_num_2'];
            } ?>"> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_2_pre">PREMIUM</label>
                                        <input type="text" name="pol_2_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_2_pre'])) {
                                            echo $data4['pol_num_2_pre'];
                                        } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_2_com">COMM</label>
                                        <input type="text" name="pol_2_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_2_com'])) {
                                            echo $data4['pol_num_2_com'];
                                        } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_2_cov">COVER</label>
                                        <input type="text" name="pol_2_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_2_cov'])) {
                                            echo $data4['pol_num_2_cov'];
                                        } ?>">  
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_2_yr">YRS</label>
                                        <input type="text" name="pol_2_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_2_yr'])) {
                                            echo $data4['pol_num_2_yr'];
                                        } ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label class="checkbox-inline" for="pol_2_type-0">
                                            <input name="pol_2_type" id="pol_2_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                                            if ($data4['pol_num_2_type'] == '1') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            LTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_2_type-1">
                                            <input name="pol_2_type" id="pol_2_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                                            if ($data4['pol_num_2_type'] == '2') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            LTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="pol_2_type-2">
                                            <input name="pol_2_type" id="pol_2_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                                            if ($data4['pol_num_2_type'] == '3') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            DTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_2_type-3">
                                            <input name="pol_2_type" id="pol_2_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                                            if ($data4['pol_num_2_type'] == '4') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            DTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="checkboxes-4">
                                            <input name="pol_2_type" id="pol_2_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                                            if ($data4['pol_num_2_type'] == '5') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            CIC
                                        </label> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label" for="pol_2_soj">S/J 1,2?</label>
                                        <input type="text" name="pol_2_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_3_soj'])) {
                                            echo $data4['pol_num_3_soj'];
                                        } ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <h4>NEW POLICY 3</h4>
                                    </div>        

                                    <div class="col-md-2">
                                        <label class="col-md-2 control-label" for="pol_3_num">POLICY#</label>
                                        <input type="text" name="pol_3_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_3'])) {
                                            echo $data4['pol_num_3'];
                                        } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_3_pre">PREMIUM</label>
                                        <input type="text" name="pol_3_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_3_pre'])) {
                                            echo $data4['pol_num_3_pre'];
                                        } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_3_com">COMM</label>
                                        <input type="text" name="pol_3_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_3_com'])) {
                                            echo $data4['pol_num_3_com'];
                                        } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_3_cov">COVER</label>
                                        <input type="text" name="pol_3_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_3_cov'])) {
                                            echo $data4['pol_num_3_cov'];
                                        } ?>">  
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_3_yr">YRS</label>
                                        <input type="text" name="pol_3_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_3_yr'])) {
                                            echo $data4['pol_num_3_yr'];
                                        } ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label class="checkbox-inline" for="pol_3_type-0">
                                            <input name="pol_3_type" id="pol_3_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                            if ($data4['pol_num_3_type'] == '1') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            LTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_3_type-1">
                                            <input name="pol_3_type" id="pol_3_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                            if ($data4['pol_num_3_type'] == '2') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            LTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="pol_3_type-2">
                                            <input name="pol_3_type" id="pol_3_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                            if ($data4['pol_num_3_type'] == '3') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            DTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_3_type-3">
                                            <input name="pol_3_type" id="pol_3_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                                if ($data4['pol_num_3_type'] == '4') {
                                                    echo "checked";
                                                }
                                            } ?>>
                                            DTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="checkboxes-4">
                                            <input name="pol_3_type" id="pol_3_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                                if ($data4['pol_num_3_type'] == '5') {
                                                    echo "checked";
                                                }
                                            } ?>>
                                            CIC
                                        </label> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label" for="pol_3_soj">S/J 1,2?</label>
                                        <input type="text" name="pol_3_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_3_soj'])) {
                                                echo $data4['pol_num_3_soj'];
                                            } ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <h4>NEW POLICY 4</h4>
                                    </div>        

                                    <div class="col-md-2">
                                        <label class="col-md-2 control-label" for="pol_4_num">POLICY#</label>
                                        <input type="text" name="pol_4_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_4'])) {
                                                echo $data4['pol_num_4'];
                                            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_4_pre">PREMIUM</label>
                                        <input type="text" name="pol_4_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_4_pre'])) {
                                                echo $data4['pol_num_4_pre'];
                                            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_4_com">COMM</label>
                                        <input type="text" name="pol_4_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_4_com'])) {
                                                echo $data4['pol_num_4_com'];
                                            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_4_cov">COVER</label>
                                        <input type="text" name="pol_4_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_4_cov'])) {
                                                echo $data4['pol_num_4_cov'];
                                            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_4_yr">YRS</label>
                                        <input type="text" name="pol_4_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_4_yr'])) {
                                                echo $data4['pol_num_4_yr'];
                                            } ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label class="checkbox-inline" for="pol_4_type-0">
                                            <input name="pol_4_type" id="pol_4_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                                                if ($data4['pol_num_4_type'] == '1') {
                                                    echo "checked";
                                                }
                                            } ?>>
                                            LTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_4_type-1">
                                            <input name="pol_4_type" id="pol_4_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                                                if ($data4['pol_num_4_type'] == '2') {
                                                    echo "checked";
                                                }
                                            } ?>>
                                            LTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="pol_4_type-2">
                                            <input name="pol_4_type" id="pol_4_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                                                if ($data4['pol_num_4_type'] == '3') {
                                                    echo "checked";
                                                }
                                            } ?>>
                                            DTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_4_type-3">
                                            <input name="pol_4_type" id="pol_4_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                                                if ($data4['pol_num_4_type'] == '4') {
                                                    echo "checked";
                                                }
                                            } ?>>
                                            DTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="checkboxes-4">
                                            <input name="pol_4_type" id="pol_4_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                                                if ($data4['pol_num_4_type'] == '5') {
                                                    echo "checked";
                                                }
                                            } ?>>
                                            CIC
                                        </label> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label" for="pol_4_soj">S/J 1,2?</label>
                                        <input type="text" name="pol_4_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_4_soj'])) {
                                                echo $data4['pol_num_4_soj'];
                                            } ?>">
                                    </div> 

                                    <div class="col-md-12"><br></div>

                                    <div class="col-md-12"> 
                                        <label class="col-md-4 control-label" for="textinput" style="color:red;">CHECKED ON DEALSHEET</label>
                                        <label class="checkbox-inline" for="checkboxes-0">
                                            <input name="chk_postcode" id="chk_postcode-0" value="1" type="checkbox" <?php if (isset($data4['chk_post'])) {
                                                if ($data4['chk_post'] == '1') {
                                                    echo "checked";
                                                }
                                            } ?>>
                                            POST CODE
                                        </label> 
                                        <label class="checkbox-inline" for="chk_dob-1">
                                            <input name="chk_dob" id="chk_dob-1" value="1" type="checkbox" <?php if (isset($data4['chk_dob'])) {
                                                if ($data4['chk_dob'] == '1') {
                                                    echo "checked";
                                                }
                                            } ?>>
                                            DOB
                                        </label> 
                                        <label class="checkbox-inline" for="chk_mob-0">
                                            <input name="chk_mob" id="chk_mob-0" value="1" type="checkbox" <?php if (isset($data4['chk_mob'])) {
                                                if ($data4['chk_mob'] == '1') {
                                                    echo "checked";
                                                }
                                            } ?>>
                                            MOBILE NO
                                        </label> 
                                        <label class="checkbox-inline" for="chk_home-0">
                                            <input name="chk_home" id="chk_home-0" value="1" type="checkbox" <?php if (isset($data4['chk_home'])) {
                                                if ($data4['chk_home'] == '1') {
                                                    echo "checked";
                                                }
                                            } ?>>
                                            HOME NO
                                        </label> 
                                        <label class="checkbox-inline" for="chk_email-0">
                                            <input name="chk_email" id="chk_email-0" value="1" type="checkbox" <?php if (isset($data4['chk_email'])) {
                                                if ($data4['chk_email'] == '1') {
                                                    echo "checked";
                                                }
                                            } ?>>
                                            EMAIL
                                        </label> 
                                    </div>

                                    <div class="col-md-12"><br></div>

                                    <div class="col-md-12">
                                        <div class="col-md-2">

                                            <label class="col-md-4 control-label" for="fee">FEE</label>
                                            <input type="text" name="fee" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['fee'])) {
                                    echo $data4['fee'];
                                } ?>">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-md-4 control-label" for="total">COMMS</label>
                                            <input type="text" name="total" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['total'])) {
                                    echo $data4['total'];
                                } ?>"> 
                                        </div>

                                        <div class="col-md-1">
                                            <label class="col-md-4 control-label" for="years">YEARS</label>
                                            <input type="text" name="years" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['years'])) {
                                    echo $data4['years'];
                                } ?>">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="col-md-4 control-label" for="month">MONTHS</label>
                                            <input type="text" name="month" class="form-control input-md" placeholder="Months" value="<?php if (isset($data4['month'])) {
                                    echo $data4['month'];
                                } ?>">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-md-4 control-label" for="comm_after">COMMSAFTER</label>
                                            <input type="text" name="comm_after" class="form-control input-md" placeholder="" value="<?php if (isset($data4['comm_after'])) {
                                    echo $data4['comm_after'];
                                } ?>">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="col-md-4 control-label" for="sac">SAC</label>
                                            <input type="text" name="sac" class="form-control input-md" placeholder="%" value="<?php if (isset($data4['sac'])) {
                                    echo $data4['sac'];
                                } ?>">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-md-4 control-label" for="closer_date">DATE</label>
                                            <input type="text" name="closer_date" class="form-control input-md" placeholder="" value="<?php if (isset($data4['date'])) {
                                    echo $data4['date'];
                                } ?>"> 
                                        </div>

                                    </div>
                                </div>
                            </div>
                        
                   <div class="panel panel-danger">
                <div class="panel-heading">Mortgage</div>
                <div class="panel-body">
                        
<div class="row">   
                    <div class="col-md-12">
                        <label for="MORTGAGE_TYPE">Mortgage Type</label>
                        <label class="radio-inline" for="Fixed-0">
                            <input name="MORTGAGE_TYPE" id="Fixed-0" value="Fixed" type="radio" <?php if(isset($data5['type'])) { if($data5['type']=='Fixed') { echo "checked"; } } ?> >
                            Fixed
                        </label> 
                        <label class="radio-inline" for="Variable-1">
                            <input name="MORTGAGE_TYPE" id="Variable-1" value="Variable" type="radio" <?php if(isset($data5['type'])) { if($data5['type']=='Variable') { echo "checked"; } } ?> >
                            Variable
                        </label> 
                        <label class="radio-inline" for="Tracker-2"">
                            <input name="MORTGAGE_TYPE" id="Tracker-2" value="Tracker" type="radio" <?php if(isset($data5['type'])) { if($data5['type']=='Tracker') { echo "checked"; } } ?> >
                            Tracker
                        </label> 
                    </div>
                    
                                        <div class="col-md-12">
                        <label for="MORTGAGE_REASON">Review Reason</label>
                        <label class="radio-inline" for="Fixed-0">
                            <input name="MORTGAGE_REASON" id="Fixed-0" value="Lower Interest Rates" type="radio" <?php if(isset($data5['reason'])) { if($data5['reason']=='Lower Interest Rates') { echo "checked"; } } ?> >
                            Lower Interest Rates
                        </label> 
                        <label class="radio-inline" for="Variable-1">
                            <input name="MORTGAGE_REASON" id="Variable-1" value="Remortgage" type="radio" <?php if(isset($data5['reason'])) { if($data5['reason']=='Remortgage') { echo "checked"; } } ?> >
                            Remortgage
                        </label> 
                        <label class="radio-inline" for="Tracker-2">
                            <input name="MORTGAGE_REASON" id="Tracker-2" value="Save Money" type="radio" <?php if(isset($data5['reason'])) { if($data5['reason']=='Save Money') { echo "checked"; } } ?> >
                            Save Money
                        </label> 
                  
    </div>
                       <div class="col-md-12">
                           <div class="col-md-4">
                            <input type="text" name="MORTGAGE_CB_DATE" class="form-control input-md" placeholder="Callback date" value="<?php if(isset($data5['cb_date'])) { echo $data5['cb_date']; } ?>" > 
                           </div>
    
                    <div class="col-md-4">  
                            <input type="text" name="MORTGAGE_CB_TIME" class="form-control input-md" placeholder="Callback time" value="<?php if(isset($data5['cb_time'])) { echo $data5['cb_time']; } ?>"> 
                    </div>
                       </div>
         
</div>

                    </div>
                </div>                        

        <?php } ?>

                        <div class="col-md-12"><br></div>

                        <center>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">
                                <select class="form-control" name="closer">
        <?php
        if (isset($data2['closer'])) {
            ?>
                                        <option value="<?php echo $data2['closer']; ?>"><?php echo $data2['closer']; ?></option>
        <?php } else { ?>
                                        <option value="">Closer</option>
        <?php } ?>
                            <option value="James">James Adams</option>
                            <option value="Kyle">Kyle Barnett</option>  
                            <option value="David">David Bebee</option> 
                            <option value="Richard">Richard Michaels</option>
                            <option value="Hayley">Hayley Hutchinson</option> 
                            <option value="Sarah">Sarah Wallace</option>
                            <option value="Gavin">Gavin Fulford</option> 
                            <option value="Mike">Michael Lloyd</option> 
                            <option value="carys">Carys Riley</option>
                            <option value="abbiek">Abbie Kenyon</option>
                            <option value="Nicola">Nicola Griffiths</option>
                            <option value="Keith">Keith Dance</option>
                                </select>
                            </div>

                            <div class="col-md-4"></div>  

                            <div class="col-md-12"><br></div> 

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> MARK AS COMPLETE</button>
                            </div>

                        </center>
                        </form>

                    </div>


    <?php
    }

    if ($QUERY == 'CompletedADL') {

        require_once(__DIR__ . '/../classes/database_class.php');

        $deal_id = filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_NUMBER_INT);

        $database = new Database();

        $database->query("SELECT date_added, agent, closer, title, forename, surname, dob, title2, forename2, surname2, dob2, postcode, mobile, home, email FROM dealsheet_prt1 WHERE deal_id=:deal_id");
        $database->bind(':deal_id', $deal_id);
        $database->execute();
        $data2 = $database->single();

        list($dob_year, $dob_month, $dob_day) = explode(" ", $data2['dob']);
        list($dob_year2, $dob_month2, $dob_day2) = explode(" ", $data2['dob2']);

        $database->query("SELECT q1a, q1b, q1c, q1d, q2a, q3a, q4a, q4b, q4c, q4d, q4e, q5a, q6a, q6b, q7a, comments, callback FROM dealsheet_prt2 WHERE deal_id=:deal_id");
        $database->bind(':deal_id', $deal_id);
        $database->execute();
        $data3 = $database->single();

        $database->query("SELECT exist_pol, pol_num_1, pol_num_1_pre, pol_num_1_com, pol_num_1_cov, pol_num_1_yr, pol_num_1_type, pol_num_1_soj, pol_num_2, pol_num_2_pre, pol_num_2_com, pol_num_2_cov, pol_num_2_yr, pol_num_2_type, pol_num_2_soj, pol_num_3, pol_num_3_pre, pol_num_3_com, pol_num_3_cov, pol_num_3_yr, pol_num_3_type, pol_num_3_soj, pol_num_4, pol_num_4_pre, pol_num_4_com, pol_num_4_cov, pol_num_4_yr, pol_num_4_type, pol_num_4_soj, chk_post, chk_dob, chk_mob, chk_home, chk_email, fee, total, years, month, comm_after, sac, date FROM dealsheet_prt3 WHERE deal_id=:deal_id");
        $database->bind(':deal_id', $deal_id);
        $database->execute();
        $data4 = $database->single();
        ?>

                    <div class="container">

                        <form id="Send" class="form" method="POST" action="php/DealSheet.php?dealsheet=QA&REF=<?php echo $deal_id; ?>">
                            <div class="col-md-4">
                                <img height="80" src="/img/RBlogo.png"><br>
                            </div>

                            <div class="col-md-4">
                                <label class="col-md-6 control-label" for="textinput">DATE</label>
                                <input type="text" name="deal_date" class="form-control input-md" placeholder="" value="<?php echo $data2['date_added']; ?>">
                            </div>

                            <div class="col-md-4">
                                <p>
                                    <label class="col-md-6 control-label" for="agent">LEAD AGENT:</label>
                                    <input type='text' id='agent' name='agent' class="form-control input-md" value="<?php echo $data2['agent']; ?>" readonly>
                                </p>
                            </div>

                    </div>   
                    <br>

                    <div class="container">
                        <div class="panel-group">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><i class="fa fa-user"></i> Client Details</div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <center> <h4>Client 1</h4></center>
                                        </div>
                                        <div class="col-md-6">
                                            <center><h4>Client 2</h4></center>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-1 control-label" for="title">Title</label> 
                                            <select class="form-control input-md" name="title">
        <?php
        if (isset($data2['title'])) {
            ?>
                                                    <option value="<?php echo $data2['title']; ?>"><?php echo $data2['title']; ?></option>
        <?php } else { ?>
                                                    <option value="">Title</option>
        <?php } ?>
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Miss">Miss</option>
                                                <option value="Ms">Ms</option>
                                                <option value="Dr">Dr</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-1 control-label" for="title2">Title</label>  
                                            <select class="form-control input-md" name="title2">
        <?php
        if (isset($data2['title2'])) {
            ?>
                                                    <option value="<?php echo $data2['title2']; ?>"><?php echo $data2['title2']; ?></option>
        <?php } else { ?>
                                                    <option value="">Title</option>
        <?php } ?>
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Miss">Miss</option>
                                                <option value="Ms">Ms</option>
                                                <option value="Dr">Dr</option>
                                            </select>  
                                        </div>

                                        <div class="col-md-12"><br></div>

                                        <div class="col-md-6">
                                            <label class="col-md-6 control-label" for="textinput">Forename</label>
                                            <input type="text" name="forename" class="form-control input-md" placeholder="Forename" value="<?php if (isset($data2['forename'])) {
            echo $data2['forename'];
        } ?>">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-6 control-label" for="textinput">Forename</label>
                                            <input type="text" name="forename2" class="form-control input-md" placeholder="Forename" value="<?php if (isset($data2['forename2'])) {
            echo $data2['forename2'];
        } ?>">
                                        </div> 

                                        <div class="col-md-12"><br></div>     

                                        <div class="col-md-6">
                                            <label class="col-md-6 control-label" for="surname">Surname</label>
                                            <input type="text" name="surname" class="form-control input-md" placeholder="Surname" value="<?php if (isset($data2['surname'])) {
            echo $data2['surname'];
        } ?>">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-6 control-label" for="surname2">Surname</label>
                                            <input type="text" name="surname2" class="form-control input-md" placeholder="Surname" value="<?php if (isset($data2['surname2'])) {
            echo $data2['surname2'];
        } ?>">
                                        </div>

                                    </div>

                                    <br>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <select class="form-control input-md" name="dob_day">
        <?php
        if (isset($dob_day)) {
            ?>
                                                        <option value="<?php echo $dob_day; ?>"><?php echo $dob_day; ?></option>
        <?php } else { ?>
                                                        <option value="">Day</option>
        <?php } ?>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>  
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control input-md" name="dob_month">
        <?php
        if (isset($dob_month)) {
            ?>
                                                        <option value="<?php echo $dob_month; ?>"><?php echo $dob_month; ?></option>
        <?php } else { ?>
                                                        <option value="">Month</option>
        <?php } ?>
                                                    <option value="Jan">Jan</option>
                                                    <option value="Feb">Feb</option>
                                                    <option value="Mar">Mar</option>
                                                    <option value="Apr">Apr</option>
                                                    <option value="May">May</option>
                                                    <option value="Jun">Jun</option>
                                                    <option value="Jul">Jul</option>
                                                    <option value="Aug">Aug</option>
                                                    <option value="Sep">Sep</option>
                                                    <option value="Oct">Oct</option>
                                                    <option value="Nov">Nov</option>
                                                    <option value="Dec">Dec</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control input-md" name="dob_year">
        <?php
        if (isset($dob_year)) {
            ?>
                                                        <option value="<?php echo $dob_year; ?>"><?php echo $dob_year; ?></option>
        <?php } else { ?>
                                                        <option value="">Year</option>
        <?php
        }
        $INCyear = date("Y") - 100;

        for ($i = 0; $i <= 100; ++$i) {
            ?>
                                                        <option value="<?php echo $INCyear; ?>"><?php echo $INCyear; ?></option>
            <?php
            ++$INCyear;
        }
        ?>
                                                </select> 
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="col-md-4"> 
                                                <select class="form-control input-md" name="dob_day2">
        <?php
        if (isset($dob_day2)) {
            ?>
                                                        <option value="<?php echo $dob_day2; ?>"><?php echo $dob_day2; ?></option>
        <?php } else { ?>
                                                        <option value="">Day</option>
        <?php } ?>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>  
                                            </div>

                                            <div class="col-md-4"> 
                                                <select class="form-control input-md" name="dob_month2">
        <?php
        if (isset($dob_month2)) {
            ?>
                                                        <option value="<?php echo $dob_month2; ?>"><?php echo $dob_month2; ?></option>
        <?php } else { ?>
                                                        <option value="">Month</option>
        <?php } ?>
                                                    <option value="Jan">Jan</option>
                                                    <option value="Feb">Feb</option>
                                                    <option value="Mar">Mar</option>
                                                    <option value="Apr">Apr</option>
                                                    <option value="May">May</option>
                                                    <option value="Jun">Jun</option>
                                                    <option value="Jul">Jul</option>
                                                    <option value="Aug">Aug</option>
                                                    <option value="Sep">Sep</option>
                                                    <option value="Oct">Oct</option>
                                                    <option value="Nov">Nov</option>
                                                    <option value="Dec">Dec</option>
                                                </select>  
                                            </div>

                                            <div class="col-md-4">
                                                <select class="form-control input-md" name="dob_year2">
        <?php
        if (isset($dob_year2)) {
            ?>
                                                        <option value="<?php echo $dob_year2; ?>"><?php echo $dob_year2; ?></option>
        <?php } else { ?>
                                                        <option value="">Year</option>
        <?php
        }
        $INCyear = date("Y") - 100;

        for ($i = 0; $i <= 100; ++$i) {
            ?>
                                                        <option value="<?php echo $INCyear; ?>"><?php echo $INCyear; ?></option>
            <?php
            ++$INCyear;
        }
        ?>
                                                </select>  
                                            </div>

                                        </div>

                                        <div class="col-md-12"><br></div>

                                        <div class="col-md-12">

                                            <div class="col-md-3">
                                                <label class="col-md-4 control-label" for="textinput">PostCode</label>
                                                <input type="text" name="postcode" class="form-control input-md" placeholder="Post Code" value="<?php if (isset($data2['postcode'])) {
            echo $data2['postcode'];
        } ?>">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="col-md-4 control-label" for="textinput">Mobile</label>
                                                <input type="text" name="mobile" class="form-control input-md" placeholder="Mobile No" required pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" value="<?php if (isset($data2['mobile'])) {
            echo $data2['mobile'];
        } ?>">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="col-md-4 control-label" for="textinput">Home</label>
                                                <input type="text" name="home" class="form-control input-md" placeholder="Home No" pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" value="<?php if (isset($data2['home'])) {
            echo $data2['home'];
        } ?>">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="col-md-4 control-label" for="textinput">Email</label>
                                                <input type="text" name="email" class="form-control input-md" placeholder="Email" value="<?php if (isset($data2['email'])) {
            echo $data2['email'];
        } ?>">
                                            </div>

                                        </div>

                                        <div class="col-md-12"><br></div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-info">
                            <div class="panel-heading"><i class="fa fa-exclamation-triangle"></i> Qualifying Section</div>
                            <div class="panel-body">

                                <h4 style="color:blue;">1. What was the main reason why you took out the policy in the first place?</h4>

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q1a" style="color:blue;">Family</label>
                                    <input type="text" name="q1a" class="form-control input-md" value="<?php if (isset($data3['q1a'])) {
                                echo $data3['q1a'];
                            } ?>">
                                </div>

                                <div class="col-md-2">
                                    <label class="col-md-2 control-label" for="q1b" style="color:blue;">Mortgage</label>
                                    <input type="text" name="q1b" class="form-control input-md" placeholder="£" value="<?php if (isset($data3['q1b'])) {
                                echo $data3['q1b'];
                            } ?>">
                                </div>

                                <div class="col-md-2">
                                    <label class="col-md-2 control-label" for="q1c" style="color:blue;">Years</label>
                                    <input type="text" name="q1c" class="form-control input-md" placeholder="5 years" value="<?php if (isset($data3['q1c'])) {
                                echo $data3['q1c'];
                            } ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label" for="q1d" style="color:red;">Repayments/Interest Only</label>
                                    <select name="q1d" class="form-control input-md">
                    <?php
                    if (isset($data3['q1d'])) {
                        ?>
                                            <option value="<?php echo $data3['q1d']; ?>"><?php echo $data3['q1d']; ?></option>
                    <?php } else { ?>
                                            <option value="">Select</option>
                    <?php } ?>
                                        <option value="Repayments">Repayments</option>
                                        <option value="Interest Only">Interest Only</option>
                                    </select> 
                                </div>

                                <div class="col-md-12"><br></div>  

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q2a">2. When was your last review on the policy?</label>
                                    <input type="text" name="q2a" class="form-control input-md" value="<?php if (isset($data3['q2a'])) {
                echo $data3['q2a'];
            } ?>">
                                </div>  

                                <div class="col-md-12"><br></div> 

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q3a">3. How did you take out the policy?</label>
                                    <input type="text" name="q3a" class="form-control input-md" placeholder="Broker, Financial Advisor, etc..." value="<?php if (isset($data3['q3a'])) {
                echo $data3['q3a'];
            } ?>">
                                </div> 

                                <div class="col-md-12"><br></div> 

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q4a">4. Have your circumstances changed since taking out the policy?</label>
                                    <input type="text" name="q4a" class="form-control input-md" placeholder="Married, divored, children, moved home, etc..." value="<?php if (isset($data3['q4a'])) {
                        echo $data3['q4a'];
                    } ?>">
                                </div>

                                <div class="col-md-12"><br></div>

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q4b" style="color:red;">How much are you paying on a monthly basis?</label>
                                    <input type="text" name="q4b" class="form-control input-md" placeholder="£" value="<?php if (isset($data3['q4b'])) {
                        echo $data3['q4b'];
                    } ?>">
                                </div>

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q4c" style="color:red;">How much are you covered for?</label>
                                    <input type="text" name="q4c" class="form-control input-md" placeholder="£" value="<?php if (isset($data3['q4c'])) {
                        echo $data3['q4c'];
                    } ?>">
                                </div>

                                <div class="col-md-12">
                                    <label class="col-md-12 control-label" for="q4d" style="color:red;">How long do you have left on the policy?</label>
                                    <input type="text" name="q4d" class="form-control input-md" value="<?php if (isset($data3['q4d'])) {
                        echo $data3['q4d'];
                    } ?>">
                                </div>

                                <div class="col-md-12"><br></div> 

                                <center>

                                    <div class="col-md-12">
                                        <label class="radio-inline" for="q4e-0" style="color:blue;">
                                            <input name="q4e" id="radios-0" q4e="1" type="radio" <?php if (isset($data3['q4e'])) {
                        if ($data3['q4e'] == '1') {
                            echo "checked";
                        }
                    } ?>>
                                            Single Policy
                                        </label> 
                                        <label class="radio-inline" for="q4e-1" style="color:blue;">
                                            <input name="q4e" id="radios-1" q4e="2" type="radio" <?php if (isset($data3['q4e'])) {
                        if ($data3['q4e'] == '2') {
                            echo "checked";
                        }
                    } ?>>
                                            Joint Policy
                                        </label> 
                                        <label class="radio-inline" for="q4e-2" style="color:blue;">
                                            <input name="q4e" id="q4e-2" value="3" type="radio" <?php if (isset($data3['q4e'])) {
                        if ($data3['q4e'] == '3') {
                            echo "checked";
                        }
                    } ?>>
                                            Separate Policies
                                        </label> 
                                    </div>
                                </center>

                                <div class="col-md-12"> 
                                    <label class="col-md-12 control-label" for="q5a" style="color:blue;">1. Have you smoked in the last 12 months?</label>

                                    <label class="radio-inline" for="q5a-0">
                                        <input name="q5a" id="q5a-0" value="1" type="radio" <?php if (isset($data3['q5a'])) {
                        if ($data3['q5a'] == '1') {
                            echo "checked";
                        }
                    } ?>>
                                        You
                                    </label> 
                                    <label class="radio-inline" for="q5a-1">
                                        <input name="q5a" id="q5a-1" value="2" type="radio" <?php if (isset($data3['q5a'])) {
                        if ($data3['q5a'] == '2') {
                            echo "checked";
                        }
                    } ?>>
                                        Partner (if applicable)
                                    </label> 
                                </div>

                                <div class="col-md-12"><br></div>

                                <div class="col-md-12"> 
                                    <label class="col-md-12 control-label" for="q6a">2. Do you have or have you ever had any health issues?</label>
                                    <label class="radio-inline" for="q6a-0">
                                        <input name="q6a" id="q6a-0" value="1" type="radio" <?php if (isset($data3['q6a'])) {
                        if ($data3['q6a'] == '1') {
                            echo "checked";
                        }
                    } ?>>
                                        You
                                    </label> 
                                    <label class="radio-inline" for="q6a-1">
                                        <input name="q6a" id="q6a-1" value="2" type="radio" <?php if (isset($data3['q6a'])) {
                        if ($data3['q6a'] == '2') {
                            echo "checked";
                        }
                    } ?>>
                                        Partner (if applicable)
                                    </label> 

                                    <input type="text" name="q6b" class="form-control input-md" value="<?php if (isset($data3['q6b'])) {
                        echo $data3['q6b'];
                    } ?>">
                                </div>

                                <div class="col-md-12"><br></div>

                                <div class="form-group">
                                    <label class="col-md-1 control-label" for="q7a">3.</label>
                                    <div class="col-md-4"> 
                                        <label class="radio-inline" for="q7a-0">
                                            <input name="q7a" id="q7a-0" value="1" type="radio" <?php if (isset($data3['q7a'])) {
                        if ($data3['q7a'] == '1') {
                            echo "checked";
                        }
                    } ?>>
                                            Reduce Premium
                                        </label> 
                                        <label class="radio-inline" for="q7a-1">
                                            <input name="q7a" id="q7a-1" value="2" type="radio" <?php if (isset($data3['q7a'])) {
                                            if ($data3['q7a'] == '2') {
                                                echo "checked";
                                            }
                                        } ?>>
                                            Higher Level of Cover
                                        </label> 
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label class="col-md-12 control-label" for="comments">Comments</label>
                                        <input type="text" name="comments" class="form-control input-md" value="<?php if (isset($data3['comments'])) {
                                            echo $data3['comments'];
                                        } ?>">
                                    </div> 

                                    <div class="col-md-6">
                                        <label class="col-md-12 control-label" for="callback">Callback time</label>
                                        <input type="text" name="callback" class="form-control input-md" value="<?php if (isset($data3['callback'])) {
                                            echo $data3['callback'];
                                        } ?>">
                                    </div>
                                </div>

                            </div>
                        </div>

        <?php
        if (in_array($hello_name, $Closer_Access, true) || in_array($hello_name, $Manager, true) || in_array($hello_name, $QA_Access, true)) {
            ?>

                            <div class="panel panel-danger">
                                <div class="panel-heading">CLOSERS USE ONLY</div>
                                <div class="panel-body">

                                    <div class="col-md-6">
                                        <label class="col-md-6 control-label" for="exist_pol">EXISTING POLICY NUMBER</label>
                                        <input type="text" name="exist_pol" class="form-control input-md" placeholder="Existing policy number" value="<?php if (isset($data4['exist_pol'])) {
                echo $data4['exist_pol'];
            } ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <p>
                                            <label for="closer">CLOSER NAME:</label>
                                            <input type='text' id='closer' name='closer' class="form-control" value="<?php if (isset($data2['closer'])) {
                echo $data2['closer'];
            } ?>" readonly>
                                        </p>
                                        <br>
                                    </div>

                                    <div class="col-md-12">
                                        <h4>NEW POLICY 1</h4>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-md-2 control-label" for="pol_1_num">POLICY#</label>
                                        <input type="text" name="pol_1_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_1'])) {
                echo $data4['pol_num_1'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_1_pre">PREMIUM</label>
                                        <input type="text" name="pol_1_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_1_pre'])) {
                echo $data4['pol_num_1_pre'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_1_com">COMM</label>
                                        <input type="text" name="pol_1_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_1_com'])) {
                echo $data4['pol_num_1_com'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_1_cov">COVER</label>
                                        <input type="text" name="pol_1_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_1_cov'])) {
                echo $data4['pol_num_1_cov'];
            } ?>">  
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_1_yr">YRS</label>
                                        <input type="text" name="pol_1_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_1_yr'])) {
                echo $data4['pol_num_1_yr'];
            } ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label class="checkbox-inline" for="pol_1_type-0">
                                            <input name="pol_1_type" id="pol_1_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '1') {
                    echo "checked";
                }
            } ?>>
                                            LTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_1_type-1">
                                            <input name="pol_1_type" id="pol_1_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '2') {
                    echo "checked";
                }
            } ?>>
                                            LTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="pol_1_type-2">
                                            <input name="pol_1_type" id="pol_1_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '3') {
                    echo "checked";
                }
            } ?>>>
                                            DTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_1_type-3">
                                            <input name="pol_1_type" id="pol_1_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '4') {
                    echo "checked";
                }
            } ?>>
                                            DTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="checkboxes-4">
                                            <input name="pol_1_type" id="pol_1_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '5') {
                    echo "checked";
                }
            } ?>>
                                            CIC
                                        </label> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label" for="pol_1_soj">S/J 1,2?</label>
                                        <input type="text" name="pol_1_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_2_soj'])) {
                echo $data4['pol_num_2_soj'];
            } ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <h4>NEW POLICY 2</h4>  
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-md-2 control-label" for="pol_2_num">POLICY#</label>
                                        <input type="text" name="pol_2_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_2'])) {
                echo $data4['pol_num_2'];
            } ?>"> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_2_pre">PREMIUM</label>
                                        <input type="text" name="pol_2_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_2_pre'])) {
                echo $data4['pol_num_2_pre'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_2_com">COMM</label>
                                        <input type="text" name="pol_2_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_2_com'])) {
                echo $data4['pol_num_2_com'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_2_cov">COVER</label>
                                        <input type="text" name="pol_2_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_2_cov'])) {
                echo $data4['pol_num_2_cov'];
            } ?>">  
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_2_yr">YRS</label>
                                        <input type="text" name="pol_2_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_2_yr'])) {
                echo $data4['pol_num_2_yr'];
            } ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label class="checkbox-inline" for="pol_2_type-0">
                                            <input name="pol_2_type" id="pol_2_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '1') {
                    echo "checked";
                }
            } ?>>
                                            LTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_2_type-1">
                                            <input name="pol_2_type" id="pol_2_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '2') {
                    echo "checked";
                }
            } ?>>
                                            LTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="pol_2_type-2">
                                            <input name="pol_2_type" id="pol_2_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '3') {
                    echo "checked";
                }
            } ?>>
                                            DTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_2_type-3">
                                            <input name="pol_2_type" id="pol_2_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '4') {
                    echo "checked";
                }
            } ?>>
                                            DTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="checkboxes-4">
                                            <input name="pol_2_type" id="pol_2_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '5') {
                    echo "checked";
                }
            } ?>>
                                            CIC
                                        </label> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label" for="pol_2_soj">S/J 1,2?</label>
                                        <input type="text" name="pol_2_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_3_soj'])) {
                echo $data4['pol_num_3_soj'];
            } ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <h4>NEW POLICY 3</h4>
                                    </div>        

                                    <div class="col-md-2">
                                        <label class="col-md-2 control-label" for="pol_3_num">POLICY#</label>
                                        <input type="text" name="pol_3_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_3'])) {
                echo $data4['pol_num_3'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_3_pre">PREMIUM</label>
                                        <input type="text" name="pol_3_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_3_pre'])) {
                echo $data4['pol_num_3_pre'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_3_com">COMM</label>
                                        <input type="text" name="pol_3_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_3_com'])) {
                echo $data4['pol_num_3_com'];
            } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_3_cov">COVER</label>
                                        <input type="text" name="pol_3_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_3_cov'])) {
                echo $data4['pol_num_3_cov'];
            } ?>">  
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_3_yr">YRS</label>
                                        <input type="text" name="pol_3_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_3_yr'])) {
                echo $data4['pol_num_3_yr'];
            } ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label class="checkbox-inline" for="pol_3_type-0">
                                            <input name="pol_3_type" id="pol_3_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == '1') {
                    echo "checked";
                }
            } ?>>
                                            LTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_3_type-1">
                                            <input name="pol_3_type" id="pol_3_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == '2') {
                    echo "checked";
                }
            } ?>>
                                            LTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="pol_3_type-2">
                                            <input name="pol_3_type" id="pol_3_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == '3') {
                    echo "checked";
                }
            } ?>>
                                            DTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_3_type-3">
                                            <input name="pol_3_type" id="pol_3_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == '4') {
                    echo "checked";
                }
            } ?>>
                                            DTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="checkboxes-4">
                                            <input name="pol_3_type" id="pol_3_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == '5') {
                    echo "checked";
                }
            } ?>>
                                            CIC
                                        </label> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label" for="pol_3_soj">S/J 1,2?</label>
                                        <input type="text" name="pol_3_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_3_soj'])) {
                    echo $data4['pol_num_3_soj'];
                } ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <h4>NEW POLICY 4</h4>
                                    </div>        

                                    <div class="col-md-2">
                                        <label class="col-md-2 control-label" for="pol_4_num">POLICY#</label>
                                        <input type="text" name="pol_4_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_4'])) {
                    echo $data4['pol_num_4'];
                } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_4_pre">PREMIUM</label>
                                        <input type="text" name="pol_4_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_4_pre'])) {
                    echo $data4['pol_num_4_pre'];
                } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_4_com">COMM</label>
                                        <input type="text" name="pol_4_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_4_com'])) {
                    echo $data4['pol_num_4_com'];
                } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_4_cov">COVER</label>
                                        <input type="text" name="pol_4_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_4_cov'])) {
                    echo $data4['pol_num_4_cov'];
                } ?>">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-2 control-label" for="pol_4_yr">YRS</label>
                                        <input type="text" name="pol_4_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_4_yr'])) {
                    echo $data4['pol_num_4_yr'];
                } ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label class="checkbox-inline" for="pol_4_type-0">
                                            <input name="pol_4_type" id="pol_4_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                    if ($data4['pol_num_4_type'] == '1') {
                        echo "checked";
                    }
                } ?>>
                                            LTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_4_type-1">
                                            <input name="pol_4_type" id="pol_4_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                    if ($data4['pol_num_4_type'] == '2') {
                        echo "checked";
                    }
                } ?>>
                                            LTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="pol_4_type-2">
                                            <input name="pol_4_type" id="pol_4_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                    if ($data4['pol_num_4_type'] == '3') {
                        echo "checked";
                    }
                } ?>>
                                            DTA
                                        </label> 
                                        <label class="checkbox-inline" for="pol_4_type-3">
                                            <input name="pol_4_type" id="pol_4_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                    if ($data4['pol_num_4_type'] == '4') {
                        echo "checked";
                    }
                } ?>>
                                            DTA CIC
                                        </label> 
                                        <label class="checkbox-inline" for="checkboxes-4">
                                            <input name="pol_4_type" id="pol_4_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                    if ($data4['pol_num_4_type'] == '5') {
                        echo "checked";
                    }
                } ?>>
                                            CIC
                                        </label> 
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label" for="pol_4_soj">S/J 1,2?</label>
                                        <input type="text" name="pol_4_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_4_soj'])) {
                    echo $data4['pol_num_4_soj'];
                } ?>">
                                    </div> 

                                    <div class="col-md-12"><br></div>

                                    <div class="col-md-12"> 
                                        <label class="col-md-4 control-label" for="textinput" style="color:red;">CHECKED ON DEALSHEET</label>
                                        <label class="checkbox-inline" for="checkboxes-0">
                                            <input name="chk_postcode" id="chk_postcode-0" value="1" type="checkbox" <?php if (isset($data4['chk_post'])) {
                    if ($data4['chk_post'] == '1') {
                        echo "checked";
                    }
                } ?>>
                                            POST CODE
                                        </label> 
                                        <label class="checkbox-inline" for="chk_dob-1">
                                            <input name="chk_dob" id="chk_dob-1" value="1" type="checkbox" <?php if (isset($data4['chk_dob'])) {
                    if ($data4['chk_dob'] == '1') {
                        echo "checked";
                    }
                } ?>>
                                            DOB
                                        </label> 
                                        <label class="checkbox-inline" for="chk_mob-0">
                                            <input name="chk_mob" id="chk_mob-0" value="1" type="checkbox" <?php if (isset($data4['chk_mob'])) {
                    if ($data4['chk_mob'] == '1') {
                        echo "checked";
                    }
                } ?>>
                                            MOBILE NO
                                        </label> 
                                        <label class="checkbox-inline" for="chk_home-0">
                                            <input name="chk_home" id="chk_home-0" value="1" type="checkbox" <?php if (isset($data4['chk_home'])) {
                    if ($data4['chk_home'] == '1') {
                        echo "checked";
                    }
                } ?>>
                                            HOME NO
                                        </label> 
                                        <label class="checkbox-inline" for="chk_email-0">
                                            <input name="chk_email" id="chk_email-0" value="1" type="checkbox" <?php if (isset($data4['chk_email'])) {
                    if ($data4['chk_email'] == '1') {
                        echo "checked";
                    }
                } ?>>
                                            EMAIL
                                        </label> 
                                    </div>

                                    <div class="col-md-12"><br></div>

                                    <div class="col-md-12">
                                        <div class="col-md-2">

                                            <label class="col-md-4 control-label" for="fee">FEE</label>
                                            <input type="text" name="fee" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['fee'])) {
                    echo $data4['fee'];
                } ?>">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-md-4 control-label" for="total">COMMS</label>
                                            <input type="text" name="total" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['total'])) {
                    echo $data4['total'];
                } ?>"> 
                                        </div>

                                        <div class="col-md-1">
                                            <label class="col-md-4 control-label" for="years">YEARS</label>
                                            <input type="text" name="years" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['years'])) {
                    echo $data4['years'];
                } ?>">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="col-md-4 control-label" for="month">MONTHS</label>
                                            <input type="text" name="month" class="form-control input-md" placeholder="Months" value="<?php if (isset($data4['month'])) {
                    echo $data4['month'];
                } ?>">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-md-4 control-label" for="comm_after">COMMSAFTER</label>
                                            <input type="text" name="comm_after" class="form-control input-md" placeholder="" value="<?php if (isset($data4['comm_after'])) {
                    echo $data4['comm_after'];
                } ?>">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="col-md-4 control-label" for="sac">SAC</label>
                                            <input type="text" name="sac" class="form-control input-md" placeholder="%" value="<?php if (isset($data4['sac'])) {
                    echo $data4['sac'];
                } ?>">
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-md-4 control-label" for="closer_date">DATE</label>
                                            <input type="text" name="closer_date" class="form-control input-md" placeholder="" value="<?php if (isset($data4['date'])) {
                    echo $data4['date'];
                } ?>"> 
                                        </div>

                                    </div>
                                </div>
                            </div>

        <?php } ?>

                        <div class="col-md-12"><br></div>

                        <center>
                            <div class="col-md-4"></div>

                            <div class="col-md-4">
                                <select class="form-control" name="closer">
        <?php
        if (isset($data2['closer'])) {
            ?>
                                        <option value="<?php echo $data2['closer']; ?>"><?php echo $data2['closer']; ?></option>
        <?php } else { ?>
                                        <option value="">Closer</option>
        <?php } ?>
                                    <option value="Carys Riley">Carys Riley</option>
                                    <option value="James">James</option>
                                    <option value="Kyle">Kyle</option>  
                                    <option value="David">David</option> 
                                    <option value="Richard">Richard</option>
                                    <option value="Hayley Hutchinson">Hayley Hutchinson</option> 
                                    <option value="Sarah">Sarah</option>
                                    <option value="Gavin">Gavin</option> 
                                    <option value="Assura">Assura</option> 
                                </select>
                            </div>

                            <div class="col-md-4"></div>  

                            <div class="col-md-12"><br></div> 

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> ALREADY SAVED TO ADL</button>
                            </div>

                        </center>
                        </form>

                    </div>


    <?php
    }
    if ($QUERY == 'SendToADL') {

        require_once(__DIR__ . '/../classes/database_class.php');

        $deal_id = filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_NUMBER_INT);

        $database = new Database();

        $database->query("SELECT date_added, agent, closer, title, forename, surname, dob, title2, forename2, surname2, dob2, postcode, mobile, home, email FROM dealsheet_prt1 WHERE deal_id=:deal_id");
        $database->bind(':deal_id', $deal_id);
        $database->execute();
        $data2 = $database->single();

        list($dob_year, $dob_month, $dob_day) = explode(" ", $data2['dob']);
        list($dob_year2, $dob_month2, $dob_day2) = explode(" ", $data2['dob2']);

        $database->query("SELECT q1a, q1b, q1c, q1d, q2a, q3a, q4a, q4b, q4c, q4d, q4e, q5a, q6a, q6b, q7a, comments, callback FROM dealsheet_prt2 WHERE deal_id=:deal_id");
        $database->bind(':deal_id', $deal_id);
        $database->execute();
        $data3 = $database->single();

        $database->query("SELECT exist_pol, pol_num_1, pol_num_1_pre, pol_num_1_com, pol_num_1_cov, pol_num_1_yr, pol_num_1_type, pol_num_1_soj, pol_num_2, pol_num_2_pre, pol_num_2_com, pol_num_2_cov, pol_num_2_yr, pol_num_2_type, pol_num_2_soj, pol_num_3, pol_num_3_pre, pol_num_3_com, pol_num_3_cov, pol_num_3_yr, pol_num_3_type, pol_num_3_soj, pol_num_4, pol_num_4_pre, pol_num_4_com, pol_num_4_cov, pol_num_4_yr, pol_num_4_type, pol_num_4_soj, chk_post, chk_dob, chk_mob, chk_home, chk_email, fee, total, years, month, comm_after, sac, date FROM dealsheet_prt3 WHERE deal_id=:deal_id");
        $database->bind(':deal_id', $deal_id);
        $database->execute();
        $data4 = $database->single();
        ?>

                    <div class="container">
                        <div class="container">
                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading"><i class="fa fa-user-plus"></i> Add Client</div>
                                    <div class="panel-body">

                                        <form class="AddClient" id="AddProduct" action="php/AddClientSubmit.php?add=1" method="POST" autocomplete="off">

                                            <div class="col-md-4">

                                                <h3><span class="label label-info">Client Details (1)</span></h3>
                                                <br>

                                                <p>
                                                <div class="form-group">
                                                    <label for="custtype">Product:</label>
                                                    <select class="form-control" name="custype" id="custype" style="width: 170px" required>
                                                        <option value="The Review Bureau">TRB Life Insurance</option>
                                                        <option value="TRB Vitality">TRB Vitality</option>
                                                        <option value="TRB Home Insurance">TRB Home Insurance</option>
                                                        <option value="Assura">Assura Life Insurance</option>

                                                    </select>
                                                </div>
                                                </p>

                                                <p>
                                                <div class="form-group">
                                                    <label for="title">Title:</label>
                                                    <select class="form-control" name="title" id="title" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                        <option value="Mr" <?php if (isset($data2['title'])) {
            if ($data2['title'] == 'Mr') {
                echo "selected";
            }
        } ?>>Mr</option>       
                                                        <option value="Dr" <?php if (isset($data2['title'])) {
            if ($data2['title'] == 'Dr') {
                echo "selected";
            }
        } ?>>Dr</option>
                                                        <option value="Miss" <?php if (isset($data2['title'])) {
            if ($data2['title'] == 'Miss') {
                echo "selected";
            }
        } ?>>Miss</option>
                                                        <option value="Mrs" <?php if (isset($data2['title'])) {
            if ($data2['title'] == 'Mrs') {
                echo "selected";
            }
        } ?>>Mrs</option>
                                                        <option value="Ms" <?php if (isset($data2['title'])) {
            if ($data2['title'] == 'Ms') {
                echo "selected";
            }
        } ?>>Ms</option>
                                                        <option value="Other" <?php if (isset($data2['title'])) {
            if ($data2['title'] == 'Other') {
                echo "selected";
            }
        } ?>>Other</option>
                                                    </select>
                                                </div>
                                                </p>

                                                <p>
                                                    <label for="first_name">First Name:</label>
                                                    <input type="text" id="first_name" name="first_name" class="form-control" style="width: 170px" required value="<?php if (isset($data2['forename'])) {
            echo $data2['forename'];
        } ?>">
                                                </p>
                                                <p>
                                                    <label for="last_name">Last Name:</label>
                                                    <input type="text" id="last_name" name="last_name" class="form-control" style="width: 170px" required value="<?php if (isset($data2['surname'])) {
            echo $data2['surname'];
        } ?>">
                                                </p>
                                                <p>
                                                    <label for="dob">Date of Birth:</label>
                                                    <input type="text" id="dob" name="dob" class="form-control" style="width: 170px" required value="<?php if (isset($dob_day)) {
            echo "$dob_year-$dob_month-$dob_day";
        } ?>">
                                                </p>
                                                <p>
                                                    <label for="email">Email:</label>
                                                    <input type="email" id="email" class="form-control" style="width: 170px" name="email" value="<?php if (isset($data2['email'])) {
            echo $data2['email'];
        } ?>">
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
                                                        <option value="Mr" <?php if (isset($data2['title2'])) {
            if ($data2['title2'] == 'Mr') {
                echo "selected";
            }
        } ?>>Mr</option>       
                                                        <option value="Dr" <?php if (isset($data2['title2'])) {
                    if ($data2['title2'] == 'Dr') {
                        echo "selected";
                    }
                } ?>>Dr</option>
                                                        <option value="Miss" <?php if (isset($data2['title2'])) {
                    if ($data2['title2'] == 'Miss') {
                        echo "selected";
                    }
                } ?>>Miss</option>
                                                        <option value="Mrs" <?php if (isset($data2['title2'])) {
                    if ($data2['title2'] == 'Mrs') {
                        echo "selected";
                    }
                } ?>>Mrs</option>
                                                        <option value="Ms" <?php if (isset($data2['title2'])) {
                    if ($data2['title2'] == 'Ms') {
                        echo "selected";
                    }
                } ?>>Ms</option>
                                                        <option value="Other" <?php if (isset($data2['title2'])) {
                    if ($data2['title2'] == 'Other') {
                        echo "selected";
                    }
                } ?>>Other</option>
                                                    </select>
                                                </div>
                                                </p>

                                                <p>
                                                    <label for="first_name2">First Name:</label>
                                                    <input type="text" id="first_name2" name="first_name2" class="form-control" style="width: 170px" value="<?php if (isset($data2['forename2'])) {
                    echo $data2['forename2'];
                } ?>">
                                                </p>
                                                <p>
                                                    <label for="last_name2">Last Name:</label>
                                                    <input type="text" id="last_name2" name="last_name2" class="form-control" style="width: 170px" value="<?php if (isset($data2['surname2'])) {
                    echo $data2['surname2'];
                } ?>">
                                                </p>
                                                <p>
                                                    <label for="dob2">Date of Birth:</label>
                                                    <input type="text" id="dob2" name="dob2" class="form-control" style="width: 170px" value="<?php if (isset($dob_day2)) {
                    echo "$dob_year2-$dob_month2-$dob_day2";
                } ?>">
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
                                                    <input type="tel" id="phone_number" name="phone_number" class="form-control" style="width: 170px" required pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" value="<?php if (isset($data2['mobile'])) {
                    echo $data2['mobile'];
                } ?>">
                                                </p>
                                                <p>
                                                    <label for="alt_number">Alt Number:</label>
                                                    <input type="tel" id="alt_number" name="alt_number" class="form-control" style="width: 170px" pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" value="<?php if (isset($data2['home'])) {
                    echo $data2['home'];
                } ?>">
                                                </p>
                                                <br>
        <?php if ($ffpost_code == '1') { ?>
                                                    <div id="lookup_field"></div>
        <?php }

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
                                                    <input type="text" id="address3" name="address3" class="form-control" style="width: 170px">
                                                </p>
                                                <p>
                                                    <label for="town">Post Town:</label>
                                                    <input type="text" id="town" name="town" class="form-control" style="width: 170px">
                                                </p>
                                                <p>
                                                    <label for="post_code">Post Code:</label>
                                                    <input type="text" id="post_code" name="post_code" class="form-control" style="width: 170px" required value="<?php if (isset($data2['postcode'])) {
            echo $data2['postcode'];
        } ?>">
                                                </p>

                                            </div>
                                            <br>
                                            <br>

                                        </form>


                                    </div>
                                </div>
                            </div>



                            <!--- END OF ADD CLIENT -->
                            <form class="AddClient" action="php/DealSheet.php?dealsheet=ADL&REF=<?php echo $deal_id; ?>" method="POST">
                                <div class="panel-group">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Add Product</div>
                                        <div class="panel-body">



                                            <div class="col-md-4">


                                                <input type="hidden" name="addmorepolicy" value="y">

        <?php
        $title = $data2['title'];
        $forname = $data2['forename'];
        $surname = $data2['surname'];
        $title2 = $data2['title2'];
        $forname2 = $data2['forename2'];
        $surname2 = $data2['surname2'];
        ?>

                                                <p>
                                                    <label for='client_name'>Client Name</label>
                                                    <select class='form-control' name='client_name' id='client_name' style='width: 170px' required>
                                                        <option value="<?php echo "$title $forname $surname"; ?>"><?php echo "$title $forname $surname"; ?></option>
                                                        <option value="<?php echo "$title2 $forname2 $surname2"; ?>"><?php echo "$title $forname2 $surname2"; ?></option>
                                                        <option value="<?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?>" <?php if (isset($data4['pol_1_soj'])) {
            if ($data4['pol_1_soj'] == 'J') {
                echo "selected";
            }
        } ?>><?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?></option>
                                                    </select>
                                                </p>   

                                                <p>
                                                <div class="form-group">
                                                    <label for="soj">Single or Joint:</label>
                                                    <select class="form-control" name="soj" id="soj" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                        <option value="Single" <?php if (isset($data4['pol_num_1_soj'])) {
            if ($data4['pol_num_1_soj'] == 'S') {
                echo "selected";
            }
        } ?>>Single</option>
                                                        <option value="Joint" <?php if (isset($data4['pol_num_1_soj'])) {
            if ($data4['pol_num_1_soj'] == 'J') {
                echo "selected";
            }
        } ?>>Joint</option>
                                                    </select>
                                                </div>
                                                </p>

                                                <p>
                                                    <label for="sale_date">Sale Date:</label>
                                                    <input type="text" id="sale_date" name="sale_date" value="<?php echo $date = date('Y-m-d H:i:s'); ?>" placeholder="<?php echo $date = date('Y-m-d H:i:s'); ?>"class="form-control" style="width: 170px" required>
                                                </p>
                                                <br>

                                                <p>
                                                    <label for="application_number">Application Number:</label>
                                                    <input type="text" id="application_number" name="application_number"  class="form-control" style="width: 170px" placeholder="For WOL use One Family" required> 
                                                </p>
                                                <br>

                                                <p>
                                                    <label for="policy_number">Policy Number:</label>
                                                    <input type='text' id='policy_number' name='policy_number' placeholder="For WOL use One Family" class="form-control" autocomplete="off" style="width: 170px" placeholder="TBC" value="<?php if (isset($data4['pol_num_1'])) {
            echo $data4['pol_num_1'];
        } ?>">
                                                </p>

                                                <p>
                                                <div class="form-group">
                                                    <label for="type">Type:</label>
                                                    <select class="form-control" name="type" id="type" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                        <option value="LTA" <?php if (isset($data4['pol_num_1_type'])) {
            if ($data4['pol_num_1_type'] == '1') {
                echo "selected";
            }
        } ?>>LTA</option>
                                                        <option value="LTA SIC" <?php if (isset($data4['pol_num_1_type'])) {
            if ($data4['pol_num_1_type'] == 'LTA SIC') {
                echo "selected";
            }
        } ?>>LTA SIC (Vitality)</option>
                                                        <option value="LTA CIC" <?php if (isset($data4['pol_num_1_type'])) {
            if ($data4['pol_num_1_type'] == '2') {
                echo "selected";
            }
        } ?>>LTA + CIC</option>
                                                        <option value="DTA" <?php if (isset($data4['pol_num_1_type'])) {
            if ($data4['pol_num_1_type'] == '3') {
                echo "selected";
            }
        } ?>>DTA</option>
                                                        <option value="DTA CIC" <?php if (isset($data4['pol_num_1_type'])) {
            if ($data4['pol_num_1_type'] == '4') {
                echo "selected";
            }
        } ?>>DTA + CIC</option>
                                                        <option value="CIC" <?php if (isset($data4['pol_num_1_type'])) {
            if ($data4['pol_num_1_type'] == '5') {
                echo "selected";
            }
        } ?>>CIC</option>
                                                        <option value="FPIP" <?php if (isset($data4['pol_num_1_type'])) {
            if ($data4['pol_num_1_type'] == 'FPIP') {
                echo "selected";
            }
        } ?>>FPIP</option>
                                                        <option value="WOL" <?php if (isset($data4['pol_num_1_type'])) {
            if ($data4['pol_num_1_type'] == 'WOL') {
                echo "selected";
            }
        } ?>>WOL</option>
                                                    </select>
                                                </div>
                                                </p>


                                                <p>
                                                <div class="form-group">
                                                    <label for="insurer">Insurer:</label>
                                                    <select class="form-control" name="insurer" id="insurer" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                        <option value="Legal and General">Legal & General</option>
                                                        <option value="Vitality">Vitality</option>
                                                        <option value="Assura">Assura</option>
                                                        <option value="Bright Grey">Bright Grey</option>
                                                        <option value="One Family">One Family</option>
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
                                                        <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" required value="<?php if (isset($data4['pol_num_1_pre'])) {
            echo $data4['pol_num_1_pre'];
        } ?>"/>
                                                    </div> 
                                                </div>
                                                </p>


                                                <p>
                                                <div class="form-row">
                                                    <label for="commission">Commission</label>
                                                    <div class="input-group"> 
                                                        <span class="input-group-addon">£</span>
                                                        <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required value="<?php if (isset($data4['pol_num_1_com'])) {
            echo $data4['pol_num_1_com'];
        } ?>"/>
                                                    </div> 
                                                </div>
                                                </p>

                                                <p>
                                                <div class="form-row">
                                                    <label for="commission">Cover Amount</label>
                                                    <div class="input-group"> 
                                                        <span class="input-group-addon">£</span>
                                                        <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="covera" required value="<?php if (isset($data4['pol_num_1_cov'])) {
            echo $data4['pol_num_1_cov'];
        } ?>"/>
                                                    </div> 
                                                </div>
                                                </p>

                                                <p>
                                                <div class="form-row">
                                                    <label for="commission">Drip</label>
                                                    <div class="input-group"> 
                                                        <span class="input-group-addon">£</span>
                                                        <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" required/>
                                                    </div> 
                                                </div>
                                                </p>

                                                <p>
                                                <div class="form-row">
                                                    <label for="commission">Policy Term</label>
                                                    <div class="input-group"> 
                                                        <span class="input-group-addon">yrs</span>
                                                        <input style="width: 140px" autocomplete="off" type="text" class="form-control" id="polterm" name="polterm" required value="<?php if (isset($data4['pol_num_1_yr'])) {
                                    echo $data4['pol_num_1_yr'];
                                } ?>"/>
                                                    </div> 
                                                </div>
                                                </p>
                                            </div>
                                            <div class="col-md-4">

                                                <p>
                                                <div class="form-group">
                                                    <label for="CommissionType">Comms:</label>
                                                    <select class="form-control" name="CommissionType" id="CommissionType" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                        <option value="Indemnity">Indemnity</option>
                                                        <option value="Non Idenmity">Non-Idemnity</option>
                                                        <option value="NA">N/A</option>
                                                    </select>
                                                </div>
                                                </p>


                                                <p>
                                                <div class="form-group">
                                                    <label for="comm_term">Clawback Term:</label>
                                                    <select class="form-control" name="comm_term" id="comm_term" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                        <option value="52">52</option>
                                                        <option value="51">51</option>
                                                        <option value="50">50</option>
                                                        <option value="49">49</option>
                                                        <option value="48">48</option>
                                                        <option value="47">47</option>
                                                        <option value="46">46</option>
                                                        <option value="45">45</option>
                                                        <option value="44">44</option>
                                                        <option value="43">43</option>
                                                        <option value="42">42</option>
                                                        <option value="41">41</option>
                                                        <option value="40">40</option>
                                                        <option value="39">39</option>
                                                        <option value="38">38</option>
                                                        <option value="37">37</option>
                                                        <option value="36">36</option>
                                                        <option value="35">35</option>
                                                        <option value="34">34</option>
                                                        <option value="33">33</option>
                                                        <option value="32">32</option>
                                                        <option value="31">31</option>
                                                        <option value="30">30</option>
                                                        <option value="29">29</option>
                                                        <option value="28">28</option>
                                                        <option value="27">27</option>
                                                        <option value="26">26</option>
                                                        <option value="25">25</option>
                                                        <option value="24">24</option>
                                                        <option value="23">23</option>
                                                        <option value="22">22</option>
                                                        <option value="12">12</option>
                                                        <option value="1 year">1 year</option>
                                                        <option value="0">0</option>

                                                    </select>
                                                </div>
                                                </p>


                                                <p>
                                                <div class="form-group">
                                                    <label for="PolicyStatus">Policy Status:</label>
                                                    <select class="form-control" name="PolicyStatus" id="PolicyStatus" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                        <option value="Live">Live</option>
                                                        <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
                                                        <option value="Not Live">Not Live</option>
                                                        <option value="NTU">NTU</option>
                                                        <option value="Declined">Declined</option>
                                                        <option value="Redrawn">Redrawn</option>
                                                    </select>
                                                </div>
                                                </p>


                                                <p>
                                                    <label for="closer">Closer:</label>
                                                    <input type='text' id='closer' name='closer' style="width: 170px" class="form-control" style="width: 170px" required value="<?php if (isset($data2['closer'])) {
                                    echo $data2['closer'];
                                } ?>">
                                                </p>
                                                <script>var options = {
                                                        url: "/JSON/CloserNames.json",
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
                                                    <input type='text' id='lead' name='lead' style="width: 170px" class="form-control" style="width: 170px" required value="<?php if (isset($data2['agent'])) {
                                    echo $data2['agent'];
                                } ?>">
                                                </p>
                                                <script>var options = {
                                                        url: "/JSON/LeadGenNames.json",
                                                        getValue: "full_name",
                                                        list: {
                                                            match: {
                                                                enabled: true
                                                            }
                                                        }
                                                    };

                                                    $("#lead").easyAutocomplete(options);</script>

                                            </div>

                                            <br>

                                        </div>
                                        <br>
                                        <br>

                                    </div>
                                </div>
                        </div>

                        <!-- END OF ADD POLICY 1 --->

        <?php if (isset($data4['pol_num_2'])) { ?>

                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Add Product 2</div>
                                    <div class="panel-body">

                                        <div class="col-md-4">

                                            <p>
                                                <label for='client_name'>Client Name</label>
                                                <select class='form-control' name='client_name' id='client_name' style='width: 170px' required>
                                                    <option value="<?php echo "$title $forname $surname"; ?>"><?php echo "$title $forname $surname"; ?></option>
                                                    <option value="<?php echo "$title2 $forname2 $surname2"; ?>"><?php echo "$title $forname2 $surname2"; ?></option>
                                                    <option value="<?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?>" <?php if (isset($data4['pol_num_2_soj'])) {
                if ($data4['pol_num_2_soj'] == 'J') {
                    echo "selected";
                }
            } ?>><?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?></option>
                                                </select>
                                            </p>   

                                            <p>
                                            <div class="form-group">
                                                <label for="soj">Single or Joint:</label>
                                                <select class="form-control" name="soj" id="soj" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="Single" <?php if (isset($data4['pol_num_2_soj'])) {
                if ($data4['pol_num_2_soj'] == 'S') {
                    echo "selected";
                }
            } ?>>Single</option>
                                                    <option value="Joint" <?php if (isset($data4['pol_num_2_soj'])) {
                if ($data4['pol_num_2_soj'] == 'J') {
                    echo "selected";
                }
            } ?>>Joint</option>
                                                </select>
                                            </div>
                                            </p>

                                            <p>
                                                <label for="application_number">Application Number:</label>
                                                <input type="text" id="application_number" name="application_number"  class="form-control" style="width: 170px" placeholder="For WOL use One Family" required>
                                            </p>
                                            <br>

                                            <p>
                                                <label for="policy_number">Policy Number:</label>
                                                <input type='text' id='policy_number' name='policy_number' class="form-control" placeholder="For WOL use One Family" autocomplete="off" style="width: 170px" placeholder="TBC" value="<?php if (isset($data4['pol_num_2'])) {
                echo $data4['pol_num_2'];
            } ?>">
                                            </p>


                                            <p>
                                            <div class="form-group">
                                                <label for="type">Type:</label>
                                                <select class="form-control" name="type" id="type" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="LTA" <?php if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == '1') {
                                            echo "selected";
                                        }
                                    } ?>>LTA</option>
                                                    <option value="LTA SIC" <?php if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == 'LTA SIC') {
                                            echo "selected";
                                        }
                                    } ?>>LTA SIC (Vitality)</option>
                                                    <option value="LTA CIC" <?php if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == '2') {
                                            echo "selected";
                                        }
                                    } ?>>LTA + CIC</option>
                                                    <option value="DTA" <?php if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == '3') {
                                            echo "selected";
                                        }
                                    } ?>>DTA</option>
                                                    <option value="DTA CIC" <?php if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == '4') {
                                            echo "selected";
                                        }
                                    } ?>>DTA + CIC</option>
                                                    <option value="CIC" <?php if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == '5') {
                                            echo "selected";
                                        }
                                    } ?>>CIC</option>
                                                    <option value="FPIP" <?php if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == 'FPIP') {
                                            echo "selected";
                                        }
                                    } ?>>FPIP</option>
                                                    <option value="WOL" <?php if (isset($data4['pol_num_2_type'])) {
                                        if ($data4['pol_num_2_type'] == 'WOL') {
                                            echo "selected";
                                        }
                                    } ?>>WOL</option>
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
                                                    <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" required value="<?php if (isset($data4['pol_num_2_pre'])) {
                                        echo $data4['pol_num_2_pre'];
                                    } ?>"/>
                                                </div> 
                                            </div>
                                            </p>


                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Commission</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">£</span>
                                                    <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required value="<?php if (isset($data4['pol_num_2_com'])) {
                                        echo $data4['pol_num_2_com'];
                                    } ?>"/>
                                                </div> 
                                            </div>
                                            </p>

                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Cover Amount</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">£</span>
                                                    <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="covera" required value="<?php if (isset($data4['pol_num_2_cov'])) {
                                        echo $data4['pol_num_2_cov'];
                                    } ?>"/>
                                                </div> 
                                            </div>
                                            </p>

                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Drip</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">£</span>
                                                    <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" required/>
                                                </div> 
                                            </div>
                                            </p>

                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Policy Term</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">yrs</span>
                                                    <input style="width: 140px" autocomplete="off" type="text" class="form-control" id="polterm" name="polterm" required value="<?php if (isset($data4['pol_num_2_yr'])) {
                                        echo $data4['pol_num_2_yr'];
                                    } ?>"/>
                                                </div> 
                                            </div>
                                            </p>
                                        </div>
                                        <div class="col-md-4">

                                            <p>
                                            <div class="form-group">
                                                <label for="CommissionType">Comms:</label>
                                                <select class="form-control" name="CommissionType" id="CommissionType" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="Indemnity">Indemnity</option>
                                                    <option value="Non Idenmity">Non-Idemnity</option>
                                                    <option value="NA">N/A</option>
                                                </select>
                                            </div>
                                            </p>


                                            <p>
                                            <div class="form-group">
                                                <label for="comm_term">Clawback Term:</label>
                                                <select class="form-control" name="comm_term" id="comm_term" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="52">52</option>
                                                    <option value="51">51</option>
                                                    <option value="50">50</option>
                                                    <option value="49">49</option>
                                                    <option value="48">48</option>
                                                    <option value="47">47</option>
                                                    <option value="46">46</option>
                                                    <option value="45">45</option>
                                                    <option value="44">44</option>
                                                    <option value="43">43</option>
                                                    <option value="42">42</option>
                                                    <option value="41">41</option>
                                                    <option value="40">40</option>
                                                    <option value="39">39</option>
                                                    <option value="38">38</option>
                                                    <option value="37">37</option>
                                                    <option value="36">36</option>
                                                    <option value="35">35</option>
                                                    <option value="34">34</option>
                                                    <option value="33">33</option>
                                                    <option value="32">32</option>
                                                    <option value="31">31</option>
                                                    <option value="30">30</option>
                                                    <option value="29">29</option>
                                                    <option value="28">28</option>
                                                    <option value="27">27</option>
                                                    <option value="26">26</option>
                                                    <option value="25">25</option>
                                                    <option value="24">24</option>
                                                    <option value="23">23</option>
                                                    <option value="22">22</option>
                                                    <option value="12">12</option>
                                                    <option value="1 year">1 year</option>
                                                    <option value="0">0</option>

                                                </select>
                                            </div>
                                            </p>


                                            <p>
                                            <div class="form-group">
                                                <label for="PolicyStatus">Policy Status:</label>
                                                <select class="form-control" name="PolicyStatus" id="PolicyStatus" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="Live">Live</option>
                                                    <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
                                                    <option value="Not Live">Not Live</option>
                                                    <option value="NTU">NTU</option>
                                                    <option value="Declined">Declined</option>
                                                    <option value="Redrawn">Redrawn</option>
                                                </select>
                                            </div>
                                            </p>

                                        </div>

                                        <br>

                                    </div>

                                </div>
                            </div>  
        <?php } ?> 
                        <!-- END OF ADD POLICY 2 --->

        <?php if (isset($data4['pol_num_3'])) { ?>

                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Add Product 3</div>
                                    <div class="panel-body">

                                        <div class="col-md-4">

                                            <p>
                                                <label for='client_name'>Client Name</label>
                                                <select class='form-control' name='client_name' id='client_name' style='width: 170px' required>
                                                    <option value="<?php echo "$title $forname $surname"; ?>"><?php echo "$title $forname $surname"; ?></option>
                                                    <option value="<?php echo "$title2 $forname2 $surname2"; ?>"><?php echo "$title $forname2 $surname2"; ?></option>
                                                    <option value="<?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?>" <?php if (isset($data4['pol_num_3_soj'])) {
                if ($data4['pol_num_3_soj'] == 'J') {
                    echo "selected";
                }
            } ?>><?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?></option>
                                                </select>
                                            </p>   

                                            <p>
                                            <div class="form-group">
                                                <label for="soj">Single or Joint:</label>
                                                <select class="form-control" name="soj" id="soj" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="Single" <?php if (isset($data4['pol_num_3_soj'])) {
                if ($data4['pol_num_3_soj'] == 'S') {
                    echo "selected";
                }
            } ?>>Single</option>
                                                    <option value="Joint" <?php if (isset($data4['pol_num_3_soj'])) {
                if ($data4['pol_num_3_soj'] == 'J') {
                    echo "selected";
                }
            } ?>>Joint</option>
                                                </select>
                                            </div>
                                            </p>

                                            <p>
                                                <label for="application_number">Application Number:</label>
                                                <input type="text" id="application_number" name="application_number"  class="form-control" style="width: 170px" placeholder="For WOL use One Family" required>
                                            </p>
                                            <br>

                                            <p>
                                                <label for="policy_number">Policy Number:</label>
                                                <input type='text' id='policy_number' name='policy_number' placeholder="For WOL use One Family" class="form-control" autocomplete="off" style="width: 170px" placeholder="TBC" value="<?php if (isset($data4['pol_num_3'])) {
                echo $data4['pol_num_3'];
            } ?>">
                                            </p>

                                            <p>
                                            <div class="form-group">
                                                <label for="type">Type:</label>
                                                <select class="form-control" name="type" id="type" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="LTA" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == '1') {
                    echo "selected";
                }
            } ?>>LTA</option>
                                                    <option value="LTA SIC" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == 'LTA SIC') {
                    echo "selected";
                }
            } ?>>LTA SIC (Vitality)</option>
                                                    <option value="LTA CIC" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == '2') {
                    echo "selected";
                }
            } ?>>LTA + CIC</option>
                                                    <option value="DTA" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == '3') {
                    echo "selected";
                }
            } ?>>DTA</option>
                                                    <option value="DTA CIC" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == '4') {
                    echo "selected";
                }
            } ?>>DTA + CIC</option>
                                                    <option value="CIC" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == '5') {
                    echo "selected";
                }
            } ?>>CIC</option>
                                                    <option value="FPIP" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == 'FPIP') {
                    echo "selected";
                }
            } ?>>FPIP</option>
                                                    <option value="WOL" <?php if (isset($data4['pol_num_3_type'])) {
                if ($data4['pol_num_3_type'] == 'WOL') {
                    echo "selected";
                }
            } ?>>WOL</option>
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
                                                    <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" required value="<?php if (isset($data4['pol_num_3_pre'])) {
                echo $data4['pol_num_3_pre'];
            } ?>"/>
                                                </div> 
                                            </div>
                                            </p>


                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Commission</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">£</span>
                                                    <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required value="<?php if (isset($data4['pol_num_3_com'])) {
                echo $data4['pol_num_3_com'];
            } ?>"/>
                                                </div> 
                                            </div>
                                            </p>

                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Cover Amount</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">£</span>
                                                    <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="covera" required value="<?php if (isset($data4['pol_num_3_cov'])) {
                echo $data4['pol_num_3_cov'];
            } ?>"/>
                                                </div> 
                                            </div>
                                            </p>

                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Drip</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">£</span>
                                                    <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" required/>
                                                </div> 
                                            </div>
                                            </p>

                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Policy Term</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">yrs</span>
                                                    <input style="width: 140px" autocomplete="off" type="text" class="form-control" id="polterm" name="polterm" required value="<?php if (isset($data4['pol_num_3_yr'])) {
                echo $data4['pol_num_3_yr'];
            } ?>"/>
                                                </div> 
                                            </div>
                                            </p>
                                        </div>
                                        <div class="col-md-4">

                                            <p>
                                            <div class="form-group">
                                                <label for="CommissionType">Comms:</label>
                                                <select class="form-control" name="CommissionType" id="CommissionType" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="Indemnity">Indemnity</option>
                                                    <option value="Non Idenmity">Non-Idemnity</option>
                                                    <option value="NA">N/A</option>
                                                </select>
                                            </div>
                                            </p>


                                            <p>
                                            <div class="form-group">
                                                <label for="comm_term">Clawback Term:</label>
                                                <select class="form-control" name="comm_term" id="comm_term" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="52">52</option>
                                                    <option value="51">51</option>
                                                    <option value="50">50</option>
                                                    <option value="49">49</option>
                                                    <option value="48">48</option>
                                                    <option value="47">47</option>
                                                    <option value="46">46</option>
                                                    <option value="45">45</option>
                                                    <option value="44">44</option>
                                                    <option value="43">43</option>
                                                    <option value="42">42</option>
                                                    <option value="41">41</option>
                                                    <option value="40">40</option>
                                                    <option value="39">39</option>
                                                    <option value="38">38</option>
                                                    <option value="37">37</option>
                                                    <option value="36">36</option>
                                                    <option value="35">35</option>
                                                    <option value="34">34</option>
                                                    <option value="33">33</option>
                                                    <option value="32">32</option>
                                                    <option value="31">31</option>
                                                    <option value="30">30</option>
                                                    <option value="29">29</option>
                                                    <option value="28">28</option>
                                                    <option value="27">27</option>
                                                    <option value="26">26</option>
                                                    <option value="25">25</option>
                                                    <option value="24">24</option>
                                                    <option value="23">23</option>
                                                    <option value="22">22</option>
                                                    <option value="12">12</option>
                                                    <option value="1 year">1 year</option>
                                                    <option value="0">0</option>

                                                </select>
                                            </div>
                                            </p>


                                            <p>
                                            <div class="form-group">
                                                <label for="PolicyStatus">Policy Status:</label>
                                                <select class="form-control" name="PolicyStatus" id="PolicyStatus" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="Live">Live</option>
                                                    <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
                                                    <option value="Not Live">Not Live</option>
                                                    <option value="NTU">NTU</option>
                                                    <option value="Declined">Declined</option>
                                                    <option value="Redrawn">Redrawn</option>
                                                </select>
                                            </div>
                                            </p>

                                        </div>

                                        <br>

                                    </div>


                                </div>
                            </div>  
        <?php } ?>      

                        <!-- END OF ADD POLICY 3 --->

        <?php if (isset($data4['pol_num_4'])) { ?>

                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Add Product 4</div>
                                    <div class="panel-body">

                                        <div class="col-md-4">

                                            <p>
                                                <label for='client_name'>Client Name</label>
                                                <select class='form-control' name='client_name' id='client_name' style='width: 170px' required>
                                                    <option value="<?php echo "$title $forname $surname"; ?>"><?php echo "$title $forname $surname"; ?></option>
                                                    <option value="<?php echo "$title2 $forname2 $surname2"; ?>"><?php echo "$title $forname2 $surname2"; ?></option>
                                                    <option value="<?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?>" <?php if (isset($data4['pol_num_4_soj'])) {
                if ($data4['pol_num_4_soj'] == 'J') {
                    echo "selected";
                }
            } ?>><?php echo "$title $forname $lastname and $title2 $forname2 $surname2"; ?></option>
                                                </select>
                                            </p>   

                                            <p>
                                            <div class="form-group">
                                                <label for="soj">Single or Joint:</label>
                                                <select class="form-control" name="soj" id="soj" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="Single" <?php if (isset($data4['pol_num_4_soj'])) {
                if ($data4['pol_num_4_soj'] == 'S') {
                    echo "selected";
                }
            } ?>>Single</option>
                                                    <option value="Joint" <?php if (isset($data4['pol_num_4_soj'])) {
                if ($data4['pol_num_4_soj'] == 'J') {
                    echo "selected";
                }
            } ?>>Joint</option>
                                                </select>
                                            </div>
                                            </p>

                                            <p>
                                                <label for="application_number">Application Number:</label>
                                                <input type="text" id="application_number" name="application_number"  class="form-control" style="width: 170px" placeholder="For WOL use One Family" required>
                                            </p>
                                            <br>

                                            <p>
                                                <label for="policy_number">Policy Number:</label>
                                                <input type='text' id='policy_number' name='policy_number' placeholder="For WOL use One Family" class="form-control" autocomplete="off" style="width: 170px" placeholder="TBC" value="<?php if (isset($data4['pol_num_4'])) {
                echo $data4['pol_num_4'];
            } ?>">
                                            </p>

                                            <p>
                                            <div class="form-group">
                                                <label for="type">Type:</label>
                                                <select class="form-control" name="type" id="type" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="LTA" <?php if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '1') {
                    echo "selected";
                }
            } ?>>LTA</option>
                                                    <option value="LTA SIC" <?php if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == 'LTA SIC') {
                    echo "selected";
                }
            } ?>>LTA SIC (Vitality)</option>
                                                    <option value="LTA CIC" <?php if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '2') {
                    echo "selected";
                }
            } ?>>LTA + CIC</option>
                                                    <option value="DTA" <?php if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '3') {
                    echo "selected";
                }
            } ?>>DTA</option>
                                                    <option value="DTA CIC" <?php if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '4') {
                    echo "selected";
                }
            } ?>>DTA + CIC</option>
                                                    <option value="CIC" <?php if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == '5') {
                    echo "selected";
                }
            } ?>>CIC</option>
                                                    <option value="FPIP" <?php if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == 'FPIP') {
                    echo "selected";
                }
            } ?>>FPIP</option>
                                                    <option value="WOL" <?php if (isset($data4['pol_num_4_type'])) {
                if ($data4['pol_num_4_type'] == 'WOL') {
                    echo "selected";
                }
            } ?>>WOL</option>
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
                                                    <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" required value="<?php if (isset($data4['pol_num_4_pre'])) {
                echo $data4['pol_num_4_pre'];
            } ?>"/>
                                                </div> 
                                            </div>
                                            </p>


                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Commission</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">£</span>
                                                    <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required value="<?php if (isset($data4['pol_num_4_com'])) {
                echo $data4['pol_num_4_com'];
            } ?>"/>
                                                </div> 
                                            </div>
                                            </p>

                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Cover Amount</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">£</span>
                                                    <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="covera" required value="<?php if (isset($data4['pol_num_4_cov'])) {
                echo $data4['pol_num_4_cov'];
            } ?>"/>
                                                </div> 
                                            </div>
                                            </p>

                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Drip</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">£</span>
                                                    <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" required/>
                                                </div> 
                                            </div>
                                            </p>

                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Policy Term</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">yrs</span>
                                                    <input style="width: 140px" autocomplete="off" type="text" class="form-control" id="polterm" name="polterm" required value="<?php if (isset($data4['pol_num_4_yr'])) {
                echo $data4['pol_num_4_yr'];
            } ?>"/>
                                                </div> 
                                            </div>
                                            </p>
                                        </div>
                                        <div class="col-md-4">

                                            <p>
                                            <div class="form-group">
                                                <label for="CommissionType">Comms:</label>
                                                <select class="form-control" name="CommissionType" id="CommissionType" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="Indemnity">Indemnity</option>
                                                    <option value="Non Idenmity">Non-Idemnity</option>
                                                    <option value="NA">N/A</option>
                                                </select>
                                            </div>
                                            </p>


                                            <p>
                                            <div class="form-group">
                                                <label for="comm_term">Clawback Term:</label>
                                                <select class="form-control" name="comm_term" id="comm_term" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="52">52</option>
                                                    <option value="51">51</option>
                                                    <option value="50">50</option>
                                                    <option value="49">49</option>
                                                    <option value="48">48</option>
                                                    <option value="47">47</option>
                                                    <option value="46">46</option>
                                                    <option value="45">45</option>
                                                    <option value="44">44</option>
                                                    <option value="43">43</option>
                                                    <option value="42">42</option>
                                                    <option value="41">41</option>
                                                    <option value="40">40</option>
                                                    <option value="39">39</option>
                                                    <option value="38">38</option>
                                                    <option value="37">37</option>
                                                    <option value="36">36</option>
                                                    <option value="35">35</option>
                                                    <option value="34">34</option>
                                                    <option value="33">33</option>
                                                    <option value="32">32</option>
                                                    <option value="31">31</option>
                                                    <option value="30">30</option>
                                                    <option value="29">29</option>
                                                    <option value="28">28</option>
                                                    <option value="27">27</option>
                                                    <option value="26">26</option>
                                                    <option value="25">25</option>
                                                    <option value="24">24</option>
                                                    <option value="23">23</option>
                                                    <option value="22">22</option>
                                                    <option value="12">12</option>
                                                    <option value="1 year">1 year</option>
                                                    <option value="0">0</option>

                                                </select>
                                            </div>
                                            </p>


                                            <p>
                                            <div class="form-group">
                                                <label for="PolicyStatus">Policy Status:</label>
                                                <select class="form-control" name="PolicyStatus" id="PolicyStatus" style="width: 170px" required>
                                                    <option value="">Select...</option>
                                                    <option value="Live">Live</option>
                                                    <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
                                                    <option value="Not Live">Not Live</option>
                                                    <option value="NTU">NTU</option>
                                                    <option value="Declined">Declined</option>
                                                    <option value="Redrawn">Redrawn</option>
                                                </select>
                                            </div>
                                            </p>

                                        </div>

                                        <br>

                                    </div>


                                </div>
                            </div>  
        <?php } ?>           

                        <!-- END OF ADD POLICY 4 --->
                    </div> 




                    <div class="col-md-12"><br></div>

                    <center>
                        <div class="col-md-4"></div>

                        <div class="col-md-4"></div>  

                        <div class="col-md-12"><br></div> 

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> SEND TO ADL</button>
                        </div>

                    </center>
                </form>

            </div>


                            <?php
                            }

                            if ($QUERY == 'ViewCloserDealSheet') {
                                require_once(__DIR__ . '/../classes/database_class.php');


                                $deal_id = filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_NUMBER_INT);

                                $database = new Database();

                                $database->query("SELECT date_added, agent, closer, title, forename, surname, dob, title2, forename2, surname2, dob2, postcode, mobile, home, email FROM dealsheet_prt1 WHERE deal_id=:deal_id");
                                $database->bind(':deal_id', $deal_id);
                                $database->execute();
                                $data2 = $database->single();

                                list($dob_year, $dob_month, $dob_day) = explode(" ", $data2['dob']);
                                list($dob_year2, $dob_month2, $dob_day2) = explode(" ", $data2['dob2']);

                                $database->query("SELECT q1a, q1b, q1c, q1d, q2a, q3a, q4a, q4b, q4c, q4d, q4e, q5a, q6a, q6b, q7a, comments, callback FROM dealsheet_prt2 WHERE deal_id=:deal_id");
                                $database->bind(':deal_id', $deal_id);
                                $database->execute();
                                $data3 = $database->single();

                                $database->query("SELECT exist_pol, pol_num_1, pol_num_1_pre, pol_num_1_com, pol_num_1_cov, pol_num_1_yr, pol_num_1_type, pol_num_1_soj, pol_num_2, pol_num_2_pre, pol_num_2_com, pol_num_2_cov, pol_num_2_yr, pol_num_2_type, pol_num_2_soj, pol_num_3, pol_num_3_pre, pol_num_3_com, pol_num_3_cov, pol_num_3_yr, pol_num_3_type, pol_num_3_soj, pol_num_4, pol_num_4_pre, pol_num_4_com, pol_num_4_cov, pol_num_4_yr, pol_num_4_type, pol_num_4_soj, chk_post, chk_dob, chk_mob, chk_home, chk_email, fee, total, years, month, comm_after, sac, date FROM dealsheet_prt3 WHERE deal_id=:deal_id");
                                $database->bind(':deal_id', $deal_id);
                                $database->execute();
                                $data4 = $database->single();
                                
                                $database->query("SELECT cb_date, cb_time, type, reason FROM dealsheet_prt4 WHERE deal_id=:deal_id");
                                $database->bind(':deal_id', $deal_id);
                                $database->execute();
                                $data5 = $database->single();  
                                ?>

            <div class="container">

                <form id="Send" class="form" method="POST" action="php/DealSheet.php?dealsheet=CLOSER&REF=<?php echo $deal_id; ?>">
                    <div class="col-md-4">
                        <img height="80" src="/img/RBlogo.png"><br>
                    </div>

                    <div class="col-md-4">
                        <label class="col-md-6 control-label" for="textinput">DATE</label>
                        <input type="text" name="deal_date" class="form-control input-md" placeholder="" value="<?php echo $data2['date_added']; ?>">
                    </div>

                    <div class="col-md-4">
                        <p>
                            <label class="col-md-6 control-label" for="agent">LEAD AGENT:</label>
                            <input type='text' id='agent' name='agent' class="form-control input-md" value="<?php echo $data2['agent']; ?>" readonly>
                        </p>
                    </div>

            </div>   
            <br>

            <div class="container">
                <div class="panel-group">
                    <div class="panel panel-primary">
                        <div class="panel-heading"><i class="fa fa-user"></i> Client Details</div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <center> <h4>Client 1</h4></center>
                                </div>
                                <div class="col-md-6">
                                    <center><h4>Client 2</h4></center>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-1 control-label" for="title">Title</label> 
                                    <select class="form-control input-md" name="title">
                                <?php
                                if (isset($data2['title'])) {
                                    ?>
                                            <option value="<?php echo $data2['title']; ?>"><?php echo $data2['title']; ?></option>
        <?php } else { ?>
                                            <option value="">Title</option>
        <?php } ?>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Miss">Miss</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Dr">Dr</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-1 control-label" for="title2">Title</label>  
                                    <select class="form-control input-md" name="title2">
        <?php
        if (isset($data2['title2'])) {
            ?>
                                            <option value="<?php echo $data2['title2']; ?>"><?php echo $data2['title2']; ?></option>
                                <?php } else { ?>
                                            <option value="">Title</option>
                                <?php } ?>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Miss">Miss</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Dr">Dr</option>
                                    </select>  
                                </div>

                                <div class="col-md-12"><br></div>

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label" for="textinput">Forename</label>
                                    <input type="text" name="forename" class="form-control input-md" placeholder="Forename" value="<?php if (isset($data2['forename'])) {
                                    echo $data2['forename'];
                                } ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label" for="textinput">Forename</label>
                                    <input type="text" name="forename2" class="form-control input-md" placeholder="Forename" value="<?php if (isset($data2['forename2'])) {
                                    echo $data2['forename2'];
                                } ?>">
                                </div> 

                                <div class="col-md-12"><br></div>     

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label" for="surname">Surname</label>
                                    <input type="text" name="surname" class="form-control input-md" placeholder="Surname" value="<?php if (isset($data2['surname'])) {
                                    echo $data2['surname'];
                                } ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-6 control-label" for="surname2">Surname</label>
                                    <input type="text" name="surname2" class="form-control input-md" placeholder="Surname" value="<?php if (isset($data2['surname2'])) {
                echo $data2['surname2'];
            } ?>">
                                </div>

                            </div>

                            <br>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="col-md-4">
                                        <select class="form-control input-md" name="dob_day">
                        <?php
                        if (isset($dob_day)) {
                            ?>
                                                <option value="<?php echo $dob_day; ?>"><?php echo $dob_day; ?></option>
                        <?php } else { ?>
                                                <option value="">Day</option>
                        <?php } ?>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>  
                                    </div>

                                    <div class="col-md-4">
                                        <select class="form-control input-md" name="dob_month">
        <?php
        if (isset($dob_month)) {
            ?>
                                                <option value="<?php echo $dob_month; ?>"><?php echo $dob_month; ?></option>
        <?php } else { ?>
                                                <option value="">Month</option>
        <?php } ?>
                                            <option value="Jan">Jan</option>
                                            <option value="Feb">Feb</option>
                                            <option value="Mar">Mar</option>
                                            <option value="Apr">Apr</option>
                                            <option value="May">May</option>
                                            <option value="Jun">Jun</option>
                                            <option value="Jul">Jul</option>
                                            <option value="Aug">Aug</option>
                                            <option value="Sep">Sep</option>
                                            <option value="Oct">Oct</option>
                                            <option value="Nov">Nov</option>
                                            <option value="Dec">Dec</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <select class="form-control input-md" name="dob_year">
                <?php
                if (isset($dob_year)) {
                    ?>
                                                <option value="<?php echo $dob_year; ?>"><?php echo $dob_year; ?></option>
                <?php } else { ?>
                                                <option value="">Year</option>
                <?php
                }
                $INCyear = date("Y") - 100;

                for ($i = 0; $i <= 100; ++$i) {
                    ?>
                                                <option value="<?php echo $INCyear; ?>"><?php echo $INCyear; ?></option>
                    <?php
                    ++$INCyear;
                }
                ?>
                                        </select> 
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="col-md-4"> 
                                        <select class="form-control input-md" name="dob_day2">
                <?php
                if (isset($dob_day2)) {
                    ?>
                                                <option value="<?php echo $dob_day2; ?>"><?php echo $dob_day2; ?></option>
        <?php } else { ?>
                                                <option value="">Day</option>
        <?php } ?>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>  
                                    </div>

                                    <div class="col-md-4"> 
                                        <select class="form-control input-md" name="dob_month2">
        <?php
        if (isset($dob_month2)) {
            ?>
                                                <option value="<?php echo $dob_month2; ?>"><?php echo $dob_month2; ?></option>
        <?php } else { ?>
                                                <option value="">Month</option>
        <?php } ?>
                                            <option value="Jan">Jan</option>
                                            <option value="Feb">Feb</option>
                                            <option value="Mar">Mar</option>
                                            <option value="Apr">Apr</option>
                                            <option value="May">May</option>
                                            <option value="Jun">Jun</option>
                                            <option value="Jul">Jul</option>
                                            <option value="Aug">Aug</option>
                                            <option value="Sep">Sep</option>
                                            <option value="Oct">Oct</option>
                                            <option value="Nov">Nov</option>
                                            <option value="Dec">Dec</option>
                                        </select>  
                                    </div>

                                    <div class="col-md-4">
                                        <select class="form-control input-md" name="dob_year2">
        <?php
        if (isset($dob_year2)) {
            ?>
                                                <option value="<?php echo $dob_year2; ?>"><?php echo $dob_year2; ?></option>
                    <?php } else { ?>
                                                <option value="">Year</option>
                <?php
                }
                $INCyear = date("Y") - 100;

                for ($i = 0; $i <= 100; ++$i) {
                    ?>
                                                <option value="<?php echo $INCyear; ?>"><?php echo $INCyear; ?></option>
            <?php
            ++$INCyear;
        }
        ?>
                                        </select>  
                                    </div>

                                </div>

                                <div class="col-md-12"><br></div>

                                <div class="col-md-12">

                                    <div class="col-md-3">
                                        <label class="col-md-4 control-label" for="textinput">PostCode</label>
                                        <input type="text" name="postcode" class="form-control input-md" placeholder="Post Code" value="<?php if (isset($data2['postcode'])) {
            echo $data2['postcode'];
        } ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="col-md-4 control-label" for="textinput">Mobile</label>
                                        <input type="text" name="mobile" class="form-control input-md" placeholder="Mobile No" required pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" value="<?php if (isset($data2['mobile'])) {
            echo $data2['mobile'];
        } ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="col-md-4 control-label" for="textinput">Home</label>
                                        <input type="text" name="home" class="form-control input-md" placeholder="Home No" pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" value="<?php if (isset($data2['home'])) {
            echo $data2['home'];
        } ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="col-md-4 control-label" for="textinput">Email</label>
                                        <input type="text" name="email" class="form-control input-md" placeholder="Email" value="<?php if (isset($data2['email'])) {
            echo $data2['email'];
        } ?>">
                                    </div>

                                </div>

                                <div class="col-md-12"><br></div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading"><i class="fa fa-exclamation-triangle"></i> Qualifying Section</div>
                    <div class="panel-body">

                        <h4 style="color:blue;">1. What was the main reason why you took out the policy in the first place?</h4>

                        <div class="col-md-12">
                            <label class="col-md-12 control-label" for="q1a" style="color:blue;">Family</label>
                            <input type="text" name="q1a" class="form-control input-md" value="<?php if (isset($data3['q1a'])) {
            echo $data3['q1a'];
        } ?>">
                        </div>

                        <div class="col-md-2">
                            <label class="col-md-2 control-label" for="q1b" style="color:blue;">Mortgage</label>
                            <input type="text" name="q1b" class="form-control input-md" placeholder="£" value="<?php if (isset($data3['q1b'])) {
                    echo $data3['q1b'];
                } ?>">
                        </div>

                        <div class="col-md-2">
                            <label class="col-md-2 control-label" for="q1c" style="color:blue;">Years</label>
                            <input type="text" name="q1c" class="form-control input-md" placeholder="5 years" value="<?php if (isset($data3['q1c'])) {
                    echo $data3['q1c'];
                } ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-6 control-label" for="q1d" style="color:red;">Repayments/Interest Only</label>
                            <select name="q1d" class="form-control input-md">
        <?php
        if (isset($data3['q1d'])) {
            ?>
                                    <option value="<?php echo $data3['q1d']; ?>"><?php echo $data3['q1d']; ?></option>
        <?php } else { ?>
                                    <option value="">Select</option>
        <?php } ?>
                                <option value="Repayments">Repayments</option>
                                <option value="Interest Only">Interest Only</option>
                            </select> 
                        </div>

                        <div class="col-md-12"><br></div>  

                        <div class="col-md-12">
                            <label class="col-md-12 control-label" for="q2a">2. When was your last review on the policy?</label>
                            <input type="text" name="q2a" class="form-control input-md" value="<?php if (isset($data3['q2a'])) {
            echo $data3['q2a'];
        } ?>">
                        </div>  

                        <div class="col-md-12"><br></div> 

                        <div class="col-md-12">
                            <label class="col-md-12 control-label" for="q3a">3. How did you take out the policy?</label>
                            <input type="text" name="q3a" class="form-control input-md" placeholder="Broker, Financial Advisor, etc..." value="<?php if (isset($data3['q3a'])) {
                    echo $data3['q3a'];
                } ?>">
                        </div> 

                        <div class="col-md-12"><br></div> 

                        <div class="col-md-12">
                            <label class="col-md-12 control-label" for="q4a">4. Have your circumstances changed since taking out the policy?</label>
                            <input type="text" name="q4a" class="form-control input-md" placeholder="Married, divored, children, moved home, etc..." value="<?php if (isset($data3['q4a'])) {
                    echo $data3['q4a'];
                } ?>">
                        </div>

                        <div class="col-md-12"><br></div>

                        <div class="col-md-12">
                            <label class="col-md-12 control-label" for="q4b" style="color:red;">How much are you paying on a monthly basis?</label>
                            <input type="text" name="q4b" class="form-control input-md" placeholder="£" value="<?php if (isset($data3['q4b'])) {
                    echo $data3['q4b'];
                } ?>">
                        </div>

                        <div class="col-md-12">
                            <label class="col-md-12 control-label" for="q4c" style="color:red;">How much are you covered for?</label>
                            <input type="text" name="q4c" class="form-control input-md" placeholder="£" value="<?php if (isset($data3['q4c'])) {
                    echo $data3['q4c'];
                } ?>">
                        </div>

                        <div class="col-md-12">
                            <label class="col-md-12 control-label" for="q4d" style="color:red;">How long do you have left on the policy?</label>
                            <input type="text" name="q4d" class="form-control input-md" value="<?php if (isset($data3['q4d'])) {
            echo $data3['q4d'];
        } ?>">
                        </div>

                        <div class="col-md-12"><br></div> 

                        <center>

                            <div class="col-md-12">
                                <label class="radio-inline" for="q4e-0" style="color:blue;">
                                    <input name="q4e" id="radios-0" q4e="1" type="radio" <?php if (isset($data3['q4e'])) {
            if ($data3['q4e'] == '1') {
                echo "checked";
            }
        } ?>>
                                    Single Policy
                                </label> 
                                <label class="radio-inline" for="q4e-1" style="color:blue;">
                                    <input name="q4e" id="radios-1" q4e="2" type="radio" <?php if (isset($data3['q4e'])) {
            if ($data3['q4e'] == '2') {
                echo "checked";
            }
        } ?>>
                                    Joint Policy
                                </label> 
                                <label class="radio-inline" for="q4e-2" style="color:blue;">
                                    <input name="q4e" id="q4e-2" value="3" type="radio" <?php if (isset($data3['q4e'])) {
                if ($data3['q4e'] == '3') {
                    echo "checked";
                }
            } ?>>
                                    Separate Policies
                                </label> 
                            </div>
                        </center>

                        <div class="col-md-12"> 
                            <label class="col-md-12 control-label" for="q5a" style="color:blue;">1. Have you smoked in the last 12 months?</label>

                            <label class="radio-inline" for="q5a-0">
                                <input name="q5a" id="q5a-0" value="1" type="radio" <?php if (isset($data3['q5a'])) {
                if ($data3['q5a'] == '1') {
                    echo "checked";
                }
            } ?>>
                                You
                            </label> 
                            <label class="radio-inline" for="q5a-1">
                                <input name="q5a" id="q5a-1" value="2" type="radio" <?php if (isset($data3['q5a'])) {
                if ($data3['q5a'] == '2') {
                    echo "checked";
                }
            } ?>>
                                Partner (if applicable)
                            </label> 
                        </div>

                        <div class="col-md-12"><br></div>

                        <div class="col-md-12"> 
                            <label class="col-md-12 control-label" for="q6a">2. Do you have or have you ever had any health issues?</label>
                            <label class="radio-inline" for="q6a-0">
                                <input name="q6a" id="q6a-0" value="1" type="radio" <?php if (isset($data3['q6a'])) {
                if ($data3['q6a'] == '1') {
                    echo "checked";
                }
            } ?>>
                                You
                            </label> 
                            <label class="radio-inline" for="q6a-1">
                                <input name="q6a" id="q6a-1" value="2" type="radio" <?php if (isset($data3['q6a'])) {
                if ($data3['q6a'] == '2') {
                    echo "checked";
                }
            } ?>>
                                Partner (if applicable)
                            </label> 

                            <input type="text" name="q6b" class="form-control input-md" value="<?php if (isset($data3['q6b'])) {
                echo $data3['q6b'];
            } ?>">
                        </div>

                        <div class="col-md-12"><br></div>

                        <div class="form-group">
                            <label class="col-md-1 control-label" for="q7a">3.</label>
                            <div class="col-md-4"> 
                                <label class="radio-inline" for="q7a-0">
                                    <input name="q7a" id="q7a-0" value="1" type="radio" <?php if (isset($data3['q7a'])) {
            if ($data3['q7a'] == '1') {
                echo "checked";
            }
        } ?>>
                                    Reduce Premium
                                </label> 
                                <label class="radio-inline" for="q7a-1">
                                    <input name="q7a" id="q7a-1" value="2" type="radio" <?php if (isset($data3['q7a'])) {
            if ($data3['q7a'] == '2') {
                echo "checked";
            }
        } ?>>
                                    Higher Level of Cover
                                </label> 
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label class="col-md-12 control-label" for="comments">Comments</label>
                                <input type="text" name="comments" class="form-control input-md" value="<?php if (isset($data3['comments'])) {
            echo $data3['comments'];
        } ?>">
                            </div> 

                            <div class="col-md-6">
                                <label class="col-md-12 control-label" for="callback">Callback time</label>
                                <input type="text" name="callback" class="form-control input-md" value="<?php if (isset($data3['callback'])) {
            echo $data3['callback'];
        } ?>">
                            </div>
                        </div>

                    </div>
                </div>

                <?php
               if (in_array($hello_name, $Closer_Access, true) || in_array($hello_name, $Manager, true) || in_array($hello_name, $QA_Access, true)) {
                    ?>

                    <div class="panel panel-danger">
                        <div class="panel-heading">CLOSERS USE ONLY</div>
                        <div class="panel-body">

                            <div class="col-md-6">
                                <label class="col-md-6 control-label" for="exist_pol">EXISTING POLICY NUMBER</label>
                                <input type="text" name="exist_pol" class="form-control input-md" placeholder="Existing policy number" value="<?php if (isset($data4['exist_pol'])) {
                        echo $data4['exist_pol'];
                    } ?>">
                            </div>

                            <div class="col-md-6">
                                <p>
                                    <label for="closer">CLOSER NAME:</label>
                                    <input type='text' id='closer' name='closer' class="form-control" value="<?php if (isset($data2['closer'])) {
                        echo $data2['closer'];
                    } ?>" readonly>
                                </p>
                                <br>
                            </div>

                            <div class="col-md-12">
                                <h4>NEW POLICY 1</h4>
                            </div>

                            <div class="col-md-2">
                                <label class="col-md-2 control-label" for="pol_1_num">POLICY#</label>
                                <input type="text" name="pol_1_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_1'])) {
                        echo $data4['pol_num_1'];
                    } ?>">
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_1_pre">PREMIUM</label>
                                <input type="text" name="pol_1_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_1_pre'])) {
                echo $data4['pol_num_1_pre'];
            } ?>">
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_1_com">COMM</label>
                                <input type="text" name="pol_1_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_1_com'])) {
                echo $data4['pol_num_1_com'];
            } ?>">
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_1_cov">COVER</label>
                                <input type="text" name="pol_1_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_1_cov'])) {
                echo $data4['pol_num_1_cov'];
            } ?>">  
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_1_yr">YRS</label>
                                <input type="text" name="pol_1_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_1_yr'])) {
                echo $data4['pol_num_1_yr'];
            } ?>">
                            </div>

                            <div class="col-md-5">
                                <label class="checkbox-inline" for="pol_1_type-0">
                                    <input name="pol_1_type" id="pol_1_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '1') {
                    echo "checked";
                }
            } ?>>
                                    LTA
                                </label> 
                                <label class="checkbox-inline" for="pol_1_type-1">
                                    <input name="pol_1_type" id="pol_1_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '2') {
                    echo "checked";
                }
            } ?>>
                                    LTA CIC
                                </label> 
                                <label class="checkbox-inline" for="pol_1_type-2">
                                    <input name="pol_1_type" id="pol_1_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '3') {
                    echo "checked";
                }
            } ?>>
                                    DTA
                                </label> 
                                <label class="checkbox-inline" for="pol_1_type-3">
                                    <input name="pol_1_type" id="pol_1_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '4') {
                    echo "checked";
                }
            } ?>>
                                    DTA CIC
                                </label> 
                                <label class="checkbox-inline" for="checkboxes-4">
                                    <input name="pol_1_type" id="pol_1_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_1_type'])) {
                if ($data4['pol_num_1_type'] == '5') {
                    echo "checked";
                }
            } ?>>
                                    CIC
                                </label> 
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-4 control-label" for="pol_1_soj">S/J 1,2?</label>
                                <input type="text" name="pol_1_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_1_soj'])) {
                echo $data4['pol_num_1_soj'];
            } ?>">
                            </div>

                            <div class="col-md-12">
                                <h4>NEW POLICY 2</h4>  
                            </div>

                            <div class="col-md-2">
                                <label class="col-md-2 control-label" for="pol_2_num">POLICY#</label>
                                <input type="text" name="pol_2_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_2'])) {
                echo $data4['pol_num_2'];
            } ?>"> 
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_2_pre">PREMIUM</label>
                                <input type="text" name="pol_2_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_2_pre'])) {
                echo $data4['pol_num_2_pre'];
            } ?>">
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_2_com">COMM</label>
                                <input type="text" name="pol_2_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_2_com'])) {
                echo $data4['pol_num_2_com'];
            } ?>">
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_2_cov">COVER</label>
                                <input type="text" name="pol_2_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_2_cov'])) {
                echo $data4['pol_num_2_cov'];
            } ?>">  
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_2_yr">YRS</label>
                                <input type="text" name="pol_2_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_2_yr'])) {
                echo $data4['pol_num_2_yr'];
            } ?>">
                            </div>

                            <div class="col-md-5">
                                <label class="checkbox-inline" for="pol_2_type-0">
                                    <input name="pol_2_type" id="pol_2_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '1') {
                    echo "checked";
                }
            } ?>>
                                    LTA
                                </label> 
                                <label class="checkbox-inline" for="pol_2_type-1">
                                    <input name="pol_2_type" id="pol_2_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '2') {
                    echo "checked";
                }
            } ?>>
                                    LTA CIC
                                </label> 
                                <label class="checkbox-inline" for="pol_2_type-2">
                                    <input name="pol_2_type" id="pol_2_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '3') {
                    echo "checked";
                }
            } ?>>
                                    DTA
                                </label> 
                                <label class="checkbox-inline" for="pol_2_type-3">
                                    <input name="pol_2_type" id="pol_2_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                if ($data4['pol_num_2_type'] == '4') {
                    echo "checked";
                }
            } ?>>
                                    DTA CIC
                                </label> 
                                <label class="checkbox-inline" for="checkboxes-4">
                                    <input name="pol_2_type" id="pol_2_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_2_type'])) {
                                    if ($data4['pol_num_2_type'] == '5') {
                                        echo "checked";
                                    }
                                } ?>>
                                    CIC
                                </label> 
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-4 control-label" for="pol_2_soj">S/J 1,2?</label>
                                <input type="text" name="pol_2_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_3_soj'])) {
                                    echo $data4['pol_num_3_soj'];
                                } ?>">
                            </div>

                            <div class="col-md-12">
                                <h4>NEW POLICY 3</h4>
                            </div>        

                            <div class="col-md-2">
                                <label class="col-md-2 control-label" for="pol_3_num">POLICY#</label>
                                <input type="text" name="pol_3_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_3'])) {
                                    echo $data4['pol_num_3'];
                                } ?>">
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_3_pre">PREMIUM</label>
                                <input type="text" name="pol_3_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_3_pre'])) {
                                    echo $data4['pol_num_3_pre'];
                                } ?>">
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_3_com">COMM</label>
                                <input type="text" name="pol_3_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_3_com'])) {
                                    echo $data4['pol_num_3_com'];
                                } ?>">
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_3_cov">COVER</label>
                                <input type="text" name="pol_3_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_3_cov'])) {
                                    echo $data4['pol_num_3_cov'];
                                } ?>">  
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_3_yr">YRS</label>
                                <input type="text" name="pol_3_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_3_yr'])) {
                                    echo $data4['pol_num_3_yr'];
                                } ?>">
                            </div>

                            <div class="col-md-5">
                                <label class="checkbox-inline" for="pol_3_type-0">
                                    <input name="pol_3_type" id="pol_3_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                    if ($data4['pol_num_3_type'] == '1') {
                                        echo "checked";
                                    }
                                } ?>>
                                    LTA
                                </label> 
                                <label class="checkbox-inline" for="pol_3_type-1">
                                    <input name="pol_3_type" id="pol_3_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                    if ($data4['pol_num_3_type'] == '2') {
                                        echo "checked";
                                    }
                                } ?>>
                                    LTA CIC
                                </label> 
                                <label class="checkbox-inline" for="pol_3_type-2">
                                    <input name="pol_3_type" id="pol_3_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                    if ($data4['pol_num_3_type'] == '3') {
                                        echo "checked";
                                    }
                                } ?>>
                                    DTA
                                </label> 
                                <label class="checkbox-inline" for="pol_3_type-3">
                                    <input name="pol_3_type" id="pol_3_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                    if ($data4['pol_num_3_type'] == '4') {
                                        echo "checked";
                                    }
                                } ?>>
                                    DTA CIC
                                </label> 
                                <label class="checkbox-inline" for="checkboxes-4">
                                    <input name="pol_3_type" id="pol_3_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_3_type'])) {
                                    if ($data4['pol_num_3_type'] == '5') {
                                        echo "checked";
                                    }
                                } ?>>
                                    CIC
                                </label> 
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-4 control-label" for="pol_3_soj">S/J 1,2?</label>
                                <input type="text" name="pol_3_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_3_soj'])) {
                                    echo $data4['pol_num_3_soj'];
                                } ?>">
                            </div>

                            <div class="col-md-12">
                                <h4>NEW POLICY 4</h4>
                            </div>        

                            <div class="col-md-2">
                                <label class="col-md-2 control-label" for="pol_4_num">POLICY#</label>
                                <input type="text" name="pol_4_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20" value="<?php if (isset($data4['pol_num_4'])) {
                                    echo $data4['pol_num_4'];
                                } ?>">
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_4_pre">PREMIUM</label>
                                <input type="text" name="pol_4_pre" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_4_pre'])) {
                                    echo $data4['pol_num_4_pre'];
                                } ?>">
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_4_com">COMM</label>
                                <input type="text" name="pol_4_com" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['pol_num_4_com'])) {
                                    echo $data4['pol_num_4_com'];
                                } ?>">
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_4_cov">COVER</label>
                                <input type="text" name="pol_4_cov" class="form-control input-md" placeholder="Cover" value="<?php if (isset($data4['pol_num_4_cov'])) {
                                    echo $data4['pol_num_4_cov'];
                                } ?>">
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-2 control-label" for="pol_4_yr">YRS</label>
                                <input type="text" name="pol_4_yr" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['pol_num_4_yr'])) {
                                    echo $data4['pol_num_4_yr'];
                                } ?>">
                            </div>

                            <div class="col-md-5">
                                <label class="checkbox-inline" for="pol_4_type-0">
                                    <input name="pol_4_type" id="pol_4_type-0" value="1" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                                    if ($data4['pol_num_4_type'] == '1') {
                                        echo "checked";
                                    }
                                } ?>>
                                    LTA
                                </label> 
                                <label class="checkbox-inline" for="pol_4_type-1">
                                    <input name="pol_4_type" id="pol_4_type-1" value="2" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                                    if ($data4['pol_num_4_type'] == '2') {
                                        echo "checked";
                                    }
                                } ?>>
                                    LTA CIC
                                </label> 
                                <label class="checkbox-inline" for="pol_4_type-2">
                                    <input name="pol_4_type" id="pol_4_type-2" value="3" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                                    if ($data4['pol_num_4_type'] == '3') {
                                        echo "checked";
                                    }
                                } ?>>
                                    DTA
                                </label> 
                                <label class="checkbox-inline" for="pol_4_type-3">
                                    <input name="pol_4_type" id="pol_4_type-3" value="4" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                                    if ($data4['pol_num_4_type'] == '4') {
                                        echo "checked";
                                    }
                                } ?>>
                                    DTA CIC
                                </label> 
                                <label class="checkbox-inline" for="checkboxes-4">
                                    <input name="pol_4_type" id="pol_4_type-4" value="5" type="checkbox" <?php if (isset($data4['pol_num_4_type'])) {
                                    if ($data4['pol_num_4_type'] == '5') {
                                        echo "checked";
                                    }
                                } ?>>
                                    CIC
                                </label> 
                            </div>

                            <div class="col-md-1">
                                <label class="col-md-4 control-label" for="pol_4_soj">S/J 1,2?</label>
                                <input type="text" name="pol_4_soj" class="form-control input-md" placeholder="" value="<?php if (isset($data4['pol_num_4_soj'])) {
                                    echo $data4['pol_num_4_soj'];
                                } ?>">
                            </div> 

                            <div class="col-md-12"><br></div>

                            <div class="col-md-12"> 
                                <label class="col-md-4 control-label" for="textinput" style="color:red;">CHECKED ON DEALSHEET</label>
                                <label class="checkbox-inline" for="checkboxes-0">
                                    <input name="chk_postcode" id="chk_postcode-0" value="1" type="checkbox" <?php if (isset($data4['chk_post'])) {
                                    if ($data4['chk_post'] == '1') {
                                        echo "checked";
                                    }
                                } ?>>
                                    POST CODE
                                </label> 
                                <label class="checkbox-inline" for="chk_dob-1">
                                    <input name="chk_dob" id="chk_dob-1" value="1" type="checkbox" <?php if (isset($data4['chk_dob'])) {
                                    if ($data4['chk_dob'] == '1') {
                                        echo "checked";
                                    }
                                } ?>>
                                    DOB
                                </label> 
                                <label class="checkbox-inline" for="chk_mob-0">
                                    <input name="chk_mob" id="chk_mob-0" value="1" type="checkbox" <?php if (isset($data4['chk_mob'])) {
                                    if ($data4['chk_mob'] == '1') {
                                        echo "checked";
                                    }
                                } ?>>
                                    MOBILE NO
                                </label> 
                                <label class="checkbox-inline" for="chk_home-0">
                                    <input name="chk_home" id="chk_home-0" value="1" type="checkbox" <?php if (isset($data4['chk_home'])) {
                                    if ($data4['chk_home'] == '1') {
                                        echo "checked";
                                    }
                                } ?>>
                                    HOME NO
                                </label> 
                                <label class="checkbox-inline" for="chk_email-0">
                                    <input name="chk_email" id="chk_email-0" value="1" type="checkbox" <?php if (isset($data4['chk_email'])) {
                                    if ($data4['chk_email'] == '1') {
                                        echo "checked";
                                    }
                                } ?>>
                                    EMAIL
                                </label> 
                            </div>

                            <div class="col-md-12"><br></div>

                            <div class="col-md-12">
                                <div class="col-md-2">

                                    <label class="col-md-4 control-label" for="fee">FEE</label>
                                    <input type="text" name="fee" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['fee'])) {
                                    echo $data4['fee'];
                                } ?>">
                                </div>

                                <div class="col-md-2">
                                    <label class="col-md-4 control-label" for="total">COMMS</label>
                                    <input type="text" name="total" class="form-control input-md" placeholder="£" value="<?php if (isset($data4['total'])) {
                                    echo $data4['total'];
                                } ?>"> 
                                </div>

                                <div class="col-md-1">
                                    <label class="col-md-4 control-label" for="years">YEARS</label>
                                    <input type="text" name="years" class="form-control input-md" placeholder="Years" value="<?php if (isset($data4['years'])) {
                                    echo $data4['years'];
                                } ?>">
                                </div>

                                <div class="col-md-1">
                                    <label class="col-md-4 control-label" for="month">MONTHS</label>
                                    <input type="text" name="month" class="form-control input-md" placeholder="Months" value="<?php if (isset($data4['month'])) {
                                    echo $data4['month'];
                                } ?>">
                                </div>

                                <div class="col-md-2">
                                    <label class="col-md-4 control-label" for="comm_after">COMMSAFTER</label>
                                    <input type="text" name="comm_after" class="form-control input-md" placeholder="" value="<?php if (isset($data4['comm_after'])) {
                echo $data4['comm_after'];
            } ?>">
                                </div>

                                <div class="col-md-1">
                                    <label class="col-md-4 control-label" for="sac">SAC</label>
                                    <input type="text" name="sac" class="form-control input-md" placeholder="%" value="<?php if (isset($data4['sac'])) {
                echo $data4['sac'];
            } ?>">
                                </div>

                                <div class="col-md-2">
                                    <label class="col-md-4 control-label" for="closer_date">DATE</label>
                                    <input type="text" name="closer_date" class="form-control input-md" placeholder="" value="<?php if (isset($data4['date'])) {
                echo $data4['date'];
            } ?>"> 
                                </div>

                            </div>
                        </div>
                    </div>
                
                    <div class="panel panel-danger">
                <div class="panel-heading">Mortgage</div>
                <div class="panel-body">
                        
<div class="row">   
                    <div class="col-md-12">
                        <label for="MORTGAGE_TYPE">Mortgage Type</label>
                        <label class="radio-inline" for="Fixed-0">
                            <input name="MORTGAGE_TYPE" id="Fixed-0" value="Fixed" type="radio" <?php if(isset($data5['type'])) { if($data5['type']=='Fixed') { echo "checked"; } } ?> >
                            Fixed
                        </label> 
                        <label class="radio-inline" for="Variable-1">
                            <input name="MORTGAGE_TYPE" id="Variable-1" value="Variable" type="radio" <?php if(isset($data5['type'])) { if($data5['type']=='Variable') { echo "checked"; } } ?> >
                            Variable
                        </label> 
                        <label class="radio-inline" for="Tracker-2"">
                            <input name="MORTGAGE_TYPE" id="Tracker-2" value="Tracker" type="radio" <?php if(isset($data5['type'])) { if($data5['type']=='Tracker') { echo "checked"; } } ?> >
                            Tracker
                        </label> 
                    </div>
                    
                                        <div class="col-md-12">
                        <label for="MORTGAGE_REASON">Review Reason</label>
                        <label class="radio-inline" for="Fixed-0">
                            <input name="MORTGAGE_REASON" id="Fixed-0" value="Lower Interest Rates" type="radio" <?php if(isset($data5['reason'])) { if($data5['reason']=='Lower Interest Rates') { echo "checked"; } } ?> >
                            Lower Interest Rates
                        </label> 
                        <label class="radio-inline" for="Variable-1">
                            <input name="MORTGAGE_REASON" id="Variable-1" value="Remortgage" type="radio" <?php if(isset($data5['reason'])) { if($data5['reason']=='Remortgage') { echo "checked"; } } ?> >
                            Remortgage
                        </label> 
                        <label class="radio-inline" for="Tracker-2">
                            <input name="MORTGAGE_REASON" id="Tracker-2" value="Save Money" type="radio" <?php if(isset($data5['reason'])) { if($data5['reason']=='Save Money') { echo "checked"; } } ?> >
                            Save Money
                        </label> 
                  
    </div>
                       <div class="col-md-12">
                           <div class="col-md-4">
                            <input type="text" name="MORTGAGE_CB_DATE" class="form-control input-md" placeholder="Callback date" value="<?php if(isset($data5['cb_date'])) { echo $data5['cb_date']; } ?>" > 
                           </div>
    
                    <div class="col-md-4">  
                            <input type="text" name="MORTGAGE_CB_TIME" class="form-control input-md" placeholder="Callback time" value="<?php if(isset($data5['cb_time'])) { echo $data5['cb_time']; } ?>"> 
                    </div>
                       </div>
         
</div>

                    </div>
                </div>                

        <?php } ?>

                <div class="col-md-12"><br></div>

                <center>
                    <div class="col-md-4"></div>

                    <div class="col-md-4">
                        <select class="form-control" name="closer">
        <?php
        if (isset($data2['closer'])) {
            ?>
                                <option value="<?php echo $data2['closer']; ?>"><?php echo $data2['closer']; ?></option>
        <?php } else { ?>
                                <option value="">Closer</option>
        <?php } ?>
                            <option value="CLOSER CALLBACK">SET AS CALLBACK</option>            
                            <option value="James">James Adams</option>
                            <option value="Kyle">Kyle Barnett</option>  
                            <option value="David">David Bebee</option> 
                            <option value="Richard">Richard Michaels</option>
                            <option value="Hayley">Hayley Hutchinson</option> 
                            <option value="Sarah">Sarah Wallace</option>
                            <option value="Gavin">Gavin Fulford</option> 
                            <option value="Mike">Michael Lloyd</option> 
                            <option value="carys">Carys Riley</option>
                            <option value="abbiek">Abbie Kenyon</option>
                            <option value="Nicola">Nicola Griffiths</option>
                            <option value="Keith">Keith Dance</option>
                        </select>
                    </div>

                    <div class="col-md-4"></div>  

                    <div class="col-md-12"><br></div> 

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> SALE SEND TO QA/Set as Callback</button>
                    </div>

                </center>
            </form>

        </div>


    <?php } ?>


    <?php
    if ($QUERY == 'CloserDealSheets') {
        ?>

        <div class="CloserDealSheetsRefresh">

        </div>
        <script>
            function refresh_div() {
                jQuery.ajax({
                    url: 'php/DealSheetRefresh.php?query=CloserDealSheets&name=<?php echo $hello_name; ?>',
                    type: 'POST',
                    success: function (results) {
                        jQuery(".CloserDealSheetsRefresh").html(results);
                    }
                });
            }

            t = setInterval(refresh_div, 1000);
        </script>
    <?php
    }


    if ($QUERY == 'AllCloserDealSheets') {
        ?>

        <div class="AllCloserDealSheets">

        </div>
        <script>
            function refresh_div() {
                jQuery.ajax({
                    url: 'php/DealSheetRefresh.php?query=AllCloserDealSheets',
                    type: 'POST',
                    success: function (results) {
                        jQuery(".AllCloserDealSheets").html(results);
                    }
                });
            }

            t = setInterval(refresh_div, 1000);
        </script>                           
    <?php
    }

    if ($QUERY == 'ListCallbacks') {
        ?>

        <div class="container">

            <div class="col-md-12">

                <div class="col-md-4"></div>
                <div class="col-md-4"></div>

                <div class="col-md-4">

        <?php echo "<h3>$Today_DATES</h3>"; ?>
        <?php echo "<h4>$Today_TIME</h4>"; ?>

                </div>

            </div>

            <div class="list-group">
                <span class="label label-primary"><?php echo $real_name; ?> Dealsheet Callbacks</span>

        <?php
        $CALLBKSQ = $pdo->prepare("SELECT date_updated, deal_id, agent, closer, CONCAT(title, ' ', forename, ' ', surname) AS NAME, CONCAT(title2, ' ', forename2, ' ', surname2) AS NAME2 FROM dealsheet_prt1 WHERE status='CALLBACK' AND agent=:agent ORDER BY date_updated ");
        $CALLBKSQ->bindParam(':agent', $real_name, PDO::PARAM_STR);
        $CALLBKSQ->execute();
        if ($CALLBKSQ->rowCount() > 0) {
            while ($CALLBKSQresult = $CALLBKSQ->fetch(PDO::FETCH_ASSOC)) {

                $CLO_NAME = $CALLBKSQresult['NAME'];
                $CLO_NAME2 = $CALLBKSQresult['NAME2'];
                $CLO_ID = $CALLBKSQresult['deal_id'];
                $CLO_AGENT = $CALLBKSQresult['agent'];
                $CLO_DATE = $CALLBKSQresult['date_updated'];
                ?>

                        <a class="list-group-item" href="LifeDealSheet.php?query=ViewCallBacks&REF=<?php echo $CLO_ID; ?>"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "Date: $CLO_DATE | Lead Gen: $CLO_AGENT | $CLO_NAME - $CLO_NAME2"; ?></a>


                <?php
            }
        }
        ?>

            </div>
        </div>

    <?php
    }

    if ($QUERY == 'CloserTrackers') {
        $TrackerEdit = filter_input(INPUT_GET, 'TrackerEdit', FILTER_SANITIZE_SPECIAL_CHARS);
        ?>

        <div class="container CLOSE_RATE">

            <div class="col-md-12">

                <div class="col-md-4"></div>
                <div class="col-md-4"></div>

                <div class="col-md-4">

        <?php echo "<h3>$Today_DATES</h3>"; ?>
        <?php echo "<h4>$Today_TIME</h4>"; ?>

                </div>

            </div>

            <div class="list-group">
                <span class="label label-primary"><?php echo $real_name; ?> Trackers | Close Rate = <?php if(isset($SINGLE_CLOSER_RATE)) { echo $SINGLE_CLOSER_RATE; } ?></span>
                <form method="post" action="<?php if (isset($TrackerEdit)) {
            echo 'php/Tracker.php?query=edit';
        } else {
            echo 'php/Tracker.php?query=add';
        } ?>">
                    <table id="tracker" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Agent</th>
                                <th>Client</th>
                                <th>Phone</th>
                                <th>Current Premium</th>
                                <th>Our Premium</th>
                                <th>Notes</th>
                                <th>DISPO</th>
                                <th>DEC READ?</th>
                                <th>MTG</th>
                                <th></th>
                            </tr>
                        </thead>

        <?php
        if (isset($TrackerEdit)) {

            $TRACKER_EDIT = $pdo->prepare("SELECT tracker_id, agent, client, phone, current_premium, our_premium, comments, sale, mtg, lead_up FROM closer_trackers WHERE closer=:closer AND tracker_id=:id");
            $TRACKER_EDIT->bindParam(':closer', $real_name, PDO::PARAM_STR);
            $TRACKER_EDIT->bindParam(':id', $TrackerEdit, PDO::PARAM_INT);
            $TRACKER_EDIT->execute();
            if ($TRACKER_EDIT->rowCount() > 0) {
                $TRACKER_EDIT_result = $TRACKER_EDIT->fetch(PDO::FETCH_ASSOC);

                $TRK_EDIT_tracker_id = $TRACKER_EDIT_result['tracker_id'];
                $TRK_EDIT_agent = $TRACKER_EDIT_result['agent'];
                $TRK_EDIT_client = $TRACKER_EDIT_result['client'];
                $TRK_EDIT_phone = $TRACKER_EDIT_result['phone'];
                $TRK_EDIT_current_premium = $TRACKER_EDIT_result['current_premium'];

                $TRK_EDIT_our_premium = $TRACKER_EDIT_result['our_premium'];
                $TRK_EDIT_comments = $TRACKER_EDIT_result['comments'];
                $TRK_EDIT_sale = $TRACKER_EDIT_result['sale'];


                $TRK_EDIT_LEAD_UP = $TRACKER_EDIT_result['lead_up'];
                $TRK_EDIT_MTG = $TRACKER_EDIT_result['mtg'];
                ?>

                                <input type="hidden" value="<?php echo $real_name; ?>" name="closer">
                                <input type="hidden" value="<?php echo $TRK_EDIT_tracker_id; ?>" name="tracker_id">
                                <td><input size="12" class="form-control" type="text" name="agent_name" id="provider-json" value="<?php if (isset($TRK_EDIT_agent)) {
                    echo $TRK_EDIT_agent;
                } ?>"></td>                      
                                <td><input size="12" class="form-control" type="text" name="client" value="<?php if (isset($TRK_EDIT_client)) {
                    echo $TRK_EDIT_client;
                } ?>"></td>
                                <td><input size="12" class="form-control" type="text" name="phone" value="<?php if (isset($TRK_EDIT_phone)) {
                    echo $TRK_EDIT_phone;
                } ?>"></td>
                                <td><input size="7" class="form-control" type="text" name="current_premium" value="<?php if (isset($TRK_EDIT_current_premium)) {
                    echo $TRK_EDIT_current_premium;
                } ?>"></td>
                                <td><input size="7" class="form-control" type="text" name="our_premium" value="<?php if (isset($TRK_EDIT_our_premium)) {
                    echo $TRK_EDIT_our_premium;
                } ?>"></td>
                                <td><input type="text" class="form-control" name="comments" value="<?php if (isset($TRK_EDIT_comments)) {
                    echo $TRK_EDIT_comments;
                } ?>"></td>
                                <td>                            <select name="sale" class="form-control" required>
                                        <option value="">DISPO</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'SALE') {
                        echo "selected";
                    }
                } ?> value="SALE">Sale</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QUN') {
                        echo "selected";
                    }
                } ?> value="QUN">Underwritten</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QQQ') {
                        echo "selected";
                    }
                } ?> value="QQQ">Quoted</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QNQ') {
                        echo "selected";
                    }
                } ?> value="QNQ">No Quote</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QML') {
                        echo "selected";
                    }
                } ?> value="QML">Quote Mortgage Lead</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QDE') {
                        echo "selected";
                    }
                } ?> value="QDE">Decline</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QCBK') {
                        echo "selected";
                    }
                } ?> value="QCBK">Quoted Callback</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'NoCard') {
                        echo "selected";
                    }
                } ?> value="NoCard">No Card</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'DIDNO') {
                        echo "selected";
                    }
                } ?> value="DIDNO">Quote Not Beaten</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'DETRA') {
                        echo "selected";
                    }
                } ?> value="DETRA">Declined but passed to upsale</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'Other') {
                        echo "selected";
                    }
                } ?> value="Other">Other</option>
                                    </select></td>
                                                                                                        <td>
                                    <select name="LEAD_UP">
                                        <option <?php if(isset($TRK_EDIT_LEAD_UP) && $TRK_EDIT_LEAD_UP=='No') { echo "selected"; } ?> value="No">No</option>
                                        <option <?php if(isset($TRK_EDIT_LEAD_UP) && $TRK_EDIT_LEAD_UP=='Yes') { echo "selected"; } ?> value="Yes">Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="MTG">
                                        <option <?php if(isset($TRK_EDIT_MTG) && $TRK_EDIT_MTG=='No') { echo "selected"; } ?> value="No">No</option>
                                        <option <?php if(isset($TRK_EDIT_MTG) && $TRK_EDIT_MTG=='Yes') { echo "selected"; } ?> value="Yes">Yes</option>
                                    </select>
                                </td>
                               
                                <td><button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-save"></i> UPDATE</button></td> 
                                <td><a href="?query=CloserTrackers" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> CANCEL</a></td>

            <?php
            }
        } else {
            ?>
                            <input type="hidden" value="<?php echo $real_name; ?>" name="closer">
                            <td> <select class="form-control" name="agent_name" id="agent_name">
                                                            <option value="">Select Agent...</option>


                                </select></td>                    
                            <td><input size="12" class="form-control" type="text" name="client"></td>
                            <td><input size="12" class="form-control" type="text" name="phone"></td>
                            <td><input size="8" class="form-control" type="text" name="current_premium"></td>
                            <td><input size="8" class="form-control" type="text" name="our_premium"></td>
                            <td><input type="text" class="form-control" name="comments"></td>
                            <td> <select name="sale" class="form-control" required>
                                    <option value="">DISPO</option>
                                    <option value="SALE">Sale</option>
                                    <option value="QUN">Underwritten</option>
                                    <option value="QQQ">Quoted</option>
                                    <option value="QNQ">No Quote</option>
                                    <option value="QML">Quote Mortgage Lead</option>
                                    <option value="QDE">Decline</option>
                                    <option value="QCBK">Quoted Callback</option>
                                    <option value="NoCard">No Card</option>
                                    <option value="DIDNO">Quote Not Beaten</option>
                                    <option value="DETRA">Declined but passed to upsale</option>
                                    <option value="Other">Other</option>
                                </select></td>
                              <td>
                                    <select name="LEAD_UP">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="MTG">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </td>
                            <td><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> SAVE</button></td>
        <?php } ?>

                    </table>
                </form>
        <?php
        $TRACKER = $pdo->prepare("SELECT mtg, lead_up, date_updated, tracker_id, agent, closer, client, phone, current_premium, our_premium, comments, sale, date_updated FROM closer_trackers WHERE closer=:closer AND date_updated >= CURDATE() ORDER BY date_added");
        $TRACKER->bindParam(':closer', $real_name, PDO::PARAM_STR);
        $TRACKER->execute();
        if ($TRACKER->rowCount() > 0) {
            ?>

                    <table id="tracker" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Row</th>
                                <th>Agent</th>
                                <th>Client</th>
                                <th>Phone</th>
                                <th>Current Premium</th>
                                <th>Our Premium</th>
                                <th>Comments</th>
                                <th>DISPO</th>
                                <th>DEC READ?</th>
                                <th>MTG</th>
                                <th></th>
                            </tr>
                        </thead>


            <?php
            $i = 0;
            while ($TRACKERresult = $TRACKER->fetch(PDO::FETCH_ASSOC)) {

                $i++;

                $TRK_tracker_id = $TRACKERresult['tracker_id'];
                $TRK_agent = $TRACKERresult['agent'];
                $TRK_closer = $TRACKERresult['closer'];
                $TRK_client = $TRACKERresult['client'];
                $TRK_phone = $TRACKERresult['phone'];
                $TRK_current_premium = $TRACKERresult['current_premium'];
                $TRK_our_premium = $TRACKERresult['our_premium'];
                $TRK_comments = $TRACKERresult['comments'];
                $TRK_sale = $TRACKERresult['sale'];
                $TRK_LEAD_UP = $TRACKERresult['lead_up'];
                $TRK_MTG = $TRACKERresult['mtg'];
                ?>

                            <tr><td><?php echo $i; ?></td>
                                <td><?php echo $TRK_agent; ?></td>
                                <td><?php echo $TRK_client; ?></td>
                                <td><?php echo $TRK_phone; ?></td>
                                <td><?php echo $TRK_current_premium; ?></td>                                    
                                <td><?php echo $TRK_our_premium; ?></td>
                                <td><?php echo $TRK_comments; ?></td>
                                <td><select name="sale" class="form-control" required>
                                        <option value="">DISPO</option>
                                        <option <?php if (isset($TRK_sale)) {
                    if ($TRK_sale == 'SALE') {
                        echo "selected";
                    }
                } ?> value="SALE">Sale</option>
                                        <option <?php if (isset($TRK_sale)) {
                    if ($TRK_sale == 'QUN') {
                        echo "selected";
                    }
                } ?> value="QUN">Underwritten</option>
                                        <option <?php if (isset($TRK_sale)) {
                    if ($TRK_sale == 'QQQ') {
                        echo "selected";
                    }
                } ?> value="QQQ">Quoted</option>
                                        <option <?php if (isset($TRK_sale)) {
                    if ($TRK_sale == 'QNQ') {
                        echo "selected";
                    }
                } ?> value="QNQ">No Quote</option>
                                        <option <?php if (isset($TRK_sale)) {
                    if ($TRK_sale == 'QML') {
                        echo "selected";
                    }
                } ?> value="QML">Quote Mortgage Lead</option>
                                        <option <?php if (isset($TRK_sale)) {
                    if ($TRK_sale == 'QDE') {
                        echo "selected";
                    }
                } ?> value="QDE">Decline</option>
                                        <option <?php if (isset($TRK_sale)) {
                    if ($TRK_sale == 'QCBK') {
                        echo "selected";
                    }
                } ?> value="QCBK">Quoted Callback</option>
                                        <option <?php if (isset($TRK_sale)) {
                    if ($TRK_sale == 'NoCard') {
                        echo "selected";
                    }
                } ?> value="NoCard">No Card</option>
                                        <option <?php if (isset($TRK_sale)) {
                    if ($TRK_sale == 'DIDNO') {
                        echo "selected";
                    }
                } ?> value="DIDNO">Quote Not Beaten</option>
                                        <option <?php if (isset($TRK_sale)) {
                    if ($TRK_sale == 'DETRA') {
                        echo "selected";
                    }
                } ?> value="DETRA">Declined but passed to upsale</option>
                                        <option <?php if (isset($TRK_sale)) {
                    if ($TRK_sale == 'Other') {
                        echo "selected";
                    }
                } ?> value="Other">Other</option>
                                    </select></td>
                                                                                                                                            <td>
                                    <select name="LEAD_UP">
                                        <option <?php if(isset($TRK_LEAD_UP) && $TRK_LEAD_UP=='No') { echo "selected"; } ?> value="No">No</option>
                                        <option <?php if(isset($TRK_LEAD_UP) && $TRK_LEAD_UP=='Yes') { echo "selected"; } ?> value="Yes">Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="MTG">
                                        <option <?php if(isset($TRK_MTG) && $TRK_MTG=='No') { echo "selected"; } ?> value="No">No</option>
                                        <option <?php if(isset($TRK_MTG) && $TRK_MTG=='Yes') { echo "selected"; } ?> value="Yes">Yes</option>
                                    </select>
                                </td>
                                <td><a href='LifeDealSheet.php?query=CloserTrackers&TrackerEdit=<?php echo $TRK_tracker_id; ?>' class='btn btn-info btn-xs'><i class='fa fa-edit'></i> EDIT</a></td> </tr>
                <?php }
            ?>          
                    </table>

        <?php }
        ?>

            </div>
        </div>

    <?php }


    if ($QUERY == 'CompletedDeals') {
        ?>

        <div class="container">

            <div class="col-md-12">

                <div class="col-md-4"></div>
                <div class="col-md-4"></div>

                <div class="col-md-4">

        <?php echo "<h3>$Today_DATES</h3>"; ?>
        <?php echo "<h4>$Today_TIME</h4>"; ?>

                </div>

            </div>

            <div class="list-group">
                <span class="label label-primary">Completed Dealsheets</span>


        <?php
        $CLOSERDEALS = $pdo->prepare("SELECT date_added, deal_id, agent, closer, CONCAT(title, ' ', forename, ' ', surname) AS NAME, CONCAT(title2, ' ', forename2, ' ', surname2) AS NAME2 FROM dealsheet_prt1 WHERE status='COMPLETE' ORDER BY date_updated ");
        $CLOSERDEALS->execute();
        if ($CLOSERDEALS->rowCount() > 0) {
            while ($CLOSERDEALSresult = $CLOSERDEALS->fetch(PDO::FETCH_ASSOC)) {

                $CLO_NAME = $CLOSERDEALSresult['NAME'];
                $CLO_NAME2 = $CLOSERDEALSresult['NAME2'];
                $CLO_ID = $CLOSERDEALSresult['deal_id'];
                $CLO_AGENT = $CLOSERDEALSresult['agent'];
                $CLO_CLO = $CLOSERDEALSresult['closer'];
                $CLO_DATE = $CLOSERDEALSresult['date_added'];
                ?>

                        <a class="list-group-item" href="AddClientAndPolicy.php?query=SendToADL&REF=<?php echo $CLO_ID; ?>"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "Date: $CLO_DATE | Closer: $CLO_CLO | Lead Gen: $CLO_AGENT <br><i class='fa fa-user fa-fw' aria-hidden='true'></i> $CLO_NAME - $CLO_NAME2"; ?></a>


                <?php
            }
        }
        ?>

            </div>
        </div>            

    <?php }

    if ($QUERY == 'QADealSheets') {
        ?>

        <div class="QADealSheets">

        </div>
        <script>
            function refresh_div() {
                jQuery.ajax({
                    url: 'php/DealSheetRefresh.php?query=QADealSheets',
                    type: 'POST',
                    success: function (results) {
                        jQuery(".QADealSheets").html(results);
                    }
                });
            }

            t = setInterval(refresh_div, 1000);
        </script>


    <?php
    }
} else {
    ?>
    <div class="container">

        <form id="Send" class="form" method="POST" action="php/DealSheet.php?dealsheet=NEW">
            <div class="col-md-4">
                <img height="80" src="/img/RBlogo.png"><br>
            </div>

            <div class="col-md-4">
                <label class="col-md-6 control-label" for="textinput">DATE</label>
                <input type="text" name="deal_date" class="form-control input-md" placeholder="" value="<?php echo $Today_DATE; ?>">
            </div>

            <div class="col-md-4">
                <p>
                    <label class="col-md-6 control-label" for="agent">LEAD AGENT:</label>
                    <input type='text' id='agent' name='agent' class="form-control input-md" value="<?php echo $real_name; ?>" readonly>
                </p>
            </div>

    </div>   
    <br>

    <div class="container">
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-user"></i> Client Details</div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-6">
                            <center> <h4>Client 1</h4></center>
                        </div>
                        <div class="col-md-6">
                            <center><h4>Client 2</h4></center>
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-1 control-label" for="title">Title</label> 
                            <select class="form-control input-md" name="title">
                                <option value="">Title</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Miss">Miss</option>
                                <option value="Ms">Ms</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-1 control-label" for="title2">Title(2)</label>  
                            <select class="form-control input-md" name="title2">
                                <option value="">Title (2)</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Miss">Miss</option>
                                <option value="Ms">Ms</option>
                                <option value="Dr">Dr</option>
                            </select>  
                        </div>

                        <div class="col-md-12"><br></div>

                        <div class="col-md-6">
                            <label class="col-md-6 control-label" for="textinput">Forename</label>
                            <input type="text" name="forename" class="form-control input-md" placeholder="Forename">
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-6 control-label" for="textinput">Forename (2)</label>
                            <input type="text" name="forename2" class="form-control input-md" placeholder="Forename (2)">
                        </div> 

                        <div class="col-md-12"><br></div>     

                        <div class="col-md-6">
                            <label class="col-md-6 control-label" for="surname">Surname</label>
                            <input type="text" name="surname" class="form-control input-md" placeholder="Surname">
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-6 control-label" for="surname2">Surname (2)</label>
                            <input type="text" name="surname2" class="form-control input-md" placeholder="Surname (2)">
                        </div>

                    </div>

                    <br>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="col-md-4">
                                <select class="form-control input-md" name="dob_day">
                                    <option value="">Day</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>  
                            </div>

                            <div class="col-md-4">
                                <select class="form-control input-md" name="dob_month">
                                    <option value="">Month</option>
                                    <option value="Jan">Jan</option>
                                    <option value="Feb">Feb</option>
                                    <option value="Mar">Mar</option>
                                    <option value="Apr">Apr</option>
                                    <option value="May">May</option>
                                    <option value="Jun">Jun</option>
                                    <option value="Jul">Jul</option>
                                    <option value="Aug">Aug</option>
                                    <option value="Sep">Sep</option>
                                    <option value="Oct">Oct</option>
                                    <option value="Nov">Nov</option>
                                    <option value="Dec">Dec</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select class="form-control input-md" name="dob_year">
                                    <option value="">Year</option>
    <?php
    $INCyear = date("Y") - 100;

    for ($i = 0; $i <= 100; ++$i) {
        ?>
                                        <option value="<?php echo $INCyear; ?>"><?php echo $INCyear; ?></option>
        <?php
        ++$INCyear;
    }
    ?>
                                </select> 
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="col-md-4"> 
                                <select class="form-control input-md" name="dob_day2">
                                    <option value="">Day (2)</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>  
                            </div>

                            <div class="col-md-4"> 
                                <select class="form-control input-md" name="dob_month2">
                                    <option value="">Month (2)</option>
                                    <option value="Jan">Jan</option>
                                    <option value="Feb">Feb</option>
                                    <option value="Mar">Mar</option>
                                    <option value="Apr">Apr</option>
                                    <option value="May">May</option>
                                    <option value="Jun">Jun</option>
                                    <option value="Jul">Jul</option>
                                    <option value="Aug">Aug</option>
                                    <option value="Sep">Sep</option>
                                    <option value="Oct">Oct</option>
                                    <option value="Nov">Nov</option>
                                    <option value="Dec">Dec</option>
                                </select>  
                            </div>

                            <div class="col-md-4">
                                <select class="form-control input-md" name="dob_year2">
                                    <option value="">Year (2)</option>
    <?php
    $INCyear = date("Y") - 100;

    for ($i = 0; $i <= 100; ++$i) {
        ?>
                                        <option value="<?php echo $INCyear; ?>"><?php echo $INCyear; ?></option>
        <?php
        ++$INCyear;
    }
    ?>
                                </select>  
                            </div>

                        </div>

                        <div class="col-md-12"><br></div>

                        <div class="col-md-12">

                            <div class="col-md-3">
                                <label class="col-md-4 control-label" for="textinput">PostCode</label>
                                <input type="text" name="postcode" class="form-control input-md" placeholder="Post Code">
                            </div>

                            <div class="col-md-3">
                                <label class="col-md-4 control-label" for="textinput">Mobile</label>
                                <input type="text" name="mobile" class="form-control input-md" placeholder="Mobile No" required pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number">
                            </div>

                            <div class="col-md-3">
                                <label class="col-md-4 control-label" for="textinput">Home</label>
                                <input type="text" name="home" class="form-control input-md" placeholder="Home No" pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number">
                            </div>

                            <div class="col-md-3">
                                <label class="col-md-4 control-label" for="textinput">Email</label>
                                <input type="text" name="email" class="form-control input-md" placeholder="Email">
                            </div>

                        </div>

                        <div class="col-md-12"><br></div>

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading"><i class="fa fa-exclamation-triangle"></i> Qualifying Section</div>
            <div class="panel-body">

                <h4 style="color:blue;">1. What was the main reason why you took out the policy in the first place?</h4>

                <div class="col-md-12">
                    <label class="col-md-12 control-label" for="q1a" style="color:blue;">Family</label>
                    <input type="text" name="q1a" class="form-control input-md">
                </div>

                <div class="col-md-2">
                    <label class="col-md-2 control-label" for="q1b" style="color:blue;">Mortgage</label>
                    <input type="text" name="q1b" class="form-control input-md" placeholder="£">
                </div>

                <div class="col-md-2">
                    <label class="col-md-2 control-label" for="q1c" style="color:blue;">Years</label>
                    <input type="text" name="q1c" class="form-control input-md" placeholder="5 years">
                </div>

                <div class="col-md-6">
                    <label class="col-md-6 control-label" for="q1d" style="color:red;">Repayments/Interest Only</label>
                    <select name="q1d" class="form-control input-md">
                        <option value=""></option>
                        <option value="Repayments">Repayments</option>
                        <option value="Interest Only">Interest Only</option>
                    </select> 
                </div>

                <div class="col-md-12"><br></div>  

                <div class="col-md-12">
                    <label class="col-md-12 control-label" for="q2a">2. When was your last review on the policy?</label>
                    <input type="text" name="q2a" class="form-control input-md">
                </div>  

                <div class="col-md-12"><br></div> 

                <div class="col-md-12">
                    <label class="col-md-12 control-label" for="q3a">3. How did you take out the policy?</label>
                    <input type="text" name="q3a" class="form-control input-md" placeholder="Broker, Financial Advisor, etc...">
                </div> 

                <div class="col-md-12"><br></div> 

                <div class="col-md-12">
                    <label class="col-md-12 control-label" for="q4a">4. Have your circumstances changed since taking out the policy?</label>
                    <input type="text" name="q4a" class="form-control input-md" placeholder="Married, divored, children, moved home, etc...">
                </div>

                <div class="col-md-12"><br></div>

                <div class="col-md-12">
                    <label class="col-md-12 control-label" for="q4b" style="color:red;">How much are you paying on a monthly basis?</label>
                    <input type="text" name="q4b" class="form-control input-md" placeholder="£">
                </div>

                <div class="col-md-12">
                    <label class="col-md-12 control-label" for="q4c" style="color:red;">How much are you covered for?</label>
                    <input type="text" name="q4c" class="form-control input-md" placeholder="£">
                </div>

                <div class="col-md-12">
                    <label class="col-md-12 control-label" for="q4d" style="color:red;">How long do you have left on the policy?</label>
                    <input type="text" name="q4d" class="form-control input-md">
                </div>

                <div class="col-md-12"><br></div> 

                <center>

                    <div class="col-md-12">
                        <label class="radio-inline" for="q4e-0" style="color:blue;">
                            <input name="q4e" id="radios-0" value="1" type="radio">
                            Single Policy
                        </label> 
                        <label class="radio-inline" for="q4e-1" style="color:blue;">
                            <input name="q4e" id="radios-1" value="2" type="radio">
                            Joint Policy
                        </label> 
                        <label class="radio-inline" for="q4e-2" style="color:blue;">
                            <input name="q4e" id="q4e-2" value="3" type="radio">
                            Separate Policies
                        </label> 
                    </div>
                </center>

                <div class="col-md-12"> 
                    <label class="col-md-12 control-label" for="q5a" style="color:blue;">1. Have you smoked in the last 12 months?</label>

                    <label class="radio-inline" for="q5a-0">
                        <input name="q5a" id="radios-0" value="1" type="radio">
                        You
                    </label> 
                    <label class="radio-inline" for="q5a-1">
                        <input name="q5a" id="radios-1" value="2" type="radio">
                        Partner (if applicable)
                    </label> 
                </div>

                <div class="col-md-12"><br></div>

                <div class="col-md-12"> 
                    <label class="col-md-12 control-label" for="q6a">2. Do you have or have you ever had any health issues?</label>
                    <label class="radio-inline" for="q6a-0">
                        <input name="q6a" id="radios-0" value="1" type="radio">
                        You
                    </label> 
                    <label class="radio-inline" for="q6a-1">
                        <input name="q6a" id="radios-1" value="2" type="radio">
                        Partner (if applicable)
                    </label> 

                    <input type="text" name="q6b" class="form-control input-md">
                </div>

                <div class="col-md-12"><br></div>

                <div class="form-group">
                    <label class="col-md-1 control-label" for="q7a">3.</label>
                    <div class="col-md-4"> 
                        <label class="radio-inline" for="q7a-0">
                            <input name="q7a" id="q7a-0" value="1" type="radio">
                            Reduce Premium
                        </label> 
                        <label class="radio-inline" for="q7a-1">
                            <input name="q7a" id="q7a-1" value="2" type="radio">
                            Higher Level of Cover
                        </label> 
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-6">
                        <label class="col-md-12 control-label" for="comments">Comments</label>
                        <input type="text" name="comments" class="form-control input-md">
                    </div> 

                    <div class="col-md-6">
                        <label class="col-md-12 control-label" for="callback">Callback time</label>
                        <input type="text" name="callback" class="form-control input-md">
                    </div>
                </div>

            </div>
        </div>

    <?php
    if (in_array($hello_name, $Closer_Access, true) || in_array($hello_name, $Manager, true) || in_array($hello_name, $QA_Access, true)) {
        ?>

            <div class="panel panel-danger">
                <div class="panel-heading">CLOSERS USE ONLY</div>
                <div class="panel-body">

                    <div class="col-md-6">
                        <label class="col-md-6 control-label" for="exist_pol">EXISTING POLICY NUMBER</label>
                        <input type="text" name="exist_pol" class="form-control input-md" placeholder="Existing policy number">
                    </div>

                    <div class="col-md-6">
                        <p>
                            <label for="closer">CLOSER NAME:</label>
                            <input type='text' id='closer' name='closer' class="form-control">
                        </p>
                        <br>
                    </div>

                    <div class="col-md-12">
                        <h4>NEW POLICY 1</h4>
                    </div>

                    <div class="col-md-2">
                        <label class="col-md-2 control-label" for="pol_1_num">POLICY#</label>
                        <input type="text" name="pol_1_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_1_pre">PREMIUM</label>
                        <input type="text" name="pol_1_pre" class="form-control input-md" placeholder="£">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_1_com">COMM</label>
                        <input type="text" name="pol_1_com" class="form-control input-md" placeholder="£">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_1_cov">COVER</label>
                        <input type="text" name="pol_1_cov" class="form-control input-md" placeholder="Cover">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_1_yr">YRS</label>
                        <input type="text" name="pol_1_yr" class="form-control input-md" placeholder="Years">
                    </div>

                    <div class="col-md-5">
                        <label class="checkbox-inline" for="pol_1_type-0">
                            <input name="pol_1_type" id="pol_1_type-0" value="1" type="checkbox">
                            LTA
                        </label> 
                        <label class="checkbox-inline" for="pol_1_type-1">
                            <input name="pol_1_type" id="pol_1_type-1" value="2" type="checkbox">
                            LTA CIC
                        </label> 
                        <label class="checkbox-inline" for="pol_1_type-2">
                            <input name="pol_1_type" id="pol_1_type-2" value="3" type="checkbox">
                            DTA
                        </label> 
                        <label class="checkbox-inline" for="pol_1_type-3">
                            <input name="pol_1_type" id="pol_1_type-3" value="4" type="checkbox">
                            DTA CIC
                        </label> 
                        <label class="checkbox-inline" for="checkboxes-4">
                            <input name="pol_1_type" id="pol_1_type-4" value="5" type="checkbox">
                            CIC
                        </label> 
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-4 control-label" for="pol_1_soj">S/J 1,2?</label>
                        <input type="text" name="pol_1_soj" class="form-control input-md" placeholder="">
                    </div>

                    <div class="col-md-12">
                        <h4>NEW POLICY 2</h4>  
                    </div>

                    <div class="col-md-2">
                        <label class="col-md-2 control-label" for="pol_2_num">POLICY#</label>
                        <input type="text" name="pol_2_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_2_pre">PREMIUM</label>
                        <input type="text" name="pol_2_pre" class="form-control input-md" placeholder="£">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_2_com">COMM</label>
                        <input type="text" name="pol_2_com" class="form-control input-md" placeholder="£">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_2_cov">COVER</label>
                        <input type="text" name="pol_2_cov" class="form-control input-md" placeholder="Cover">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_2_yr">YRS</label>
                        <input type="text" name="pol_2_yr" class="form-control input-md" placeholder="Years">
                    </div>

                    <div class="col-md-5">
                        <label class="checkbox-inline" for="pol_2_type-0">
                            <input name="pol_2_type" id="pol_2_type-0" value="1" type="checkbox">
                            LTA
                        </label> 
                        <label class="checkbox-inline" for="pol_2_type-1">
                            <input name="pol_2_type" id="pol_2_type-1" value="2" type="checkbox">
                            LTA CIC
                        </label> 
                        <label class="checkbox-inline" for="pol_2_type-2">
                            <input name="pol_2_type" id="pol_2_type-2" value="3" type="checkbox">
                            DTA
                        </label> 
                        <label class="checkbox-inline" for="pol_2_type-3">
                            <input name="pol_2_type" id="pol_2_type-3" value="4" type="checkbox">
                            DTA CIC
                        </label> 
                        <label class="checkbox-inline" for="checkboxes-4">
                            <input name="pol_2_type" id="pol_2_type-4" value="5" type="checkbox">
                            CIC
                        </label> 
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-4 control-label" for="pol_2_soj">S/J 1,2?</label>
                        <input type="text" name="pol_2_soj" class="form-control input-md" placeholder="">
                    </div>

                    <div class="col-md-12">
                        <h4>NEW POLICY 3</h4>
                    </div>        

                    <div class="col-md-2">
                        <label class="col-md-2 control-label" for="pol_3_num">POLICY#</label>
                        <input type="text" name="pol_3_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_3_pre">PREMIUM</label>
                        <input type="text" name="pol_3_pre" class="form-control input-md" placeholder="£">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_3_com">COMM</label>
                        <input type="text" name="pol_3_com" class="form-control input-md" placeholder="£">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_3_cov">COVER</label>
                        <input type="text" name="pol_3_cov" class="form-control input-md" placeholder="Cover">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_3_yr">YRS</label>
                        <input type="text" name="pol_3_yr" class="form-control input-md" placeholder="Years">
                    </div>

                    <div class="col-md-5">
                        <label class="checkbox-inline" for="pol_3_type-0">
                            <input name="pol_3_type" id="pol_3_type-0" value="1" type="checkbox">
                            LTA
                        </label> 
                        <label class="checkbox-inline" for="pol_3_type-1">
                            <input name="pol_3_type" id="pol_3_type-1" value="2" type="checkbox">
                            LTA CIC
                        </label> 
                        <label class="checkbox-inline" for="pol_3_type-2">
                            <input name="pol_3_type" id="pol_3_type-2" value="3" type="checkbox">
                            DTA
                        </label> 
                        <label class="checkbox-inline" for="pol_3_type-3">
                            <input name="pol_3_type" id="pol_3_type-3" value="4" type="checkbox">
                            DTA CIC
                        </label> 
                        <label class="checkbox-inline" for="checkboxes-4">
                            <input name="pol_3_type" id="pol_3_type-4" value="5" type="checkbox">
                            CIC
                        </label> 
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-4 control-label" for="pol_3_soj">S/J 1,2?</label>
                        <input type="text" name="pol_3_soj" class="form-control input-md" placeholder="">
                    </div>

                    <div class="col-md-12">
                        <h4>NEW POLICY 4</h4>
                    </div>        

                    <div class="col-md-2">
                        <label class="col-md-2 control-label" for="pol_4_num">POLICY#</label>
                        <input type="text" name="pol_4_num" class="form-control input-md" placeholder="New Policy Number" maxlength="20">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_4_pre">PREMIUM</label>
                        <input type="text" name="pol_4_pre" class="form-control input-md" placeholder="£">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_4_com">COMM</label>
                        <input type="text" name="pol_4_com" class="form-control input-md" placeholder="£">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_4_cov">COVER</label>
                        <input type="text" name="pol_4_cov" class="form-control input-md" placeholder="Cover">
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-2 control-label" for="pol_4_yr">YRS</label>
                        <input type="text" name="pol_4_yr" class="form-control input-md" placeholder="Years">
                    </div>

                    <div class="col-md-5">
                        <label class="checkbox-inline" for="pol_4_type-0">
                            <input name="pol_4_type" id="pol_4_type-0" value="1" type="checkbox">
                            LTA
                        </label> 
                        <label class="checkbox-inline" for="pol_4_type-1">
                            <input name="pol_4_type" id="pol_4_type-1" value="2" type="checkbox">
                            LTA CIC
                        </label> 
                        <label class="checkbox-inline" for="pol_4_type-2">
                            <input name="pol_4_type" id="pol_4_type-2" value="3" type="checkbox">
                            DTA
                        </label> 
                        <label class="checkbox-inline" for="pol_4_type-3">
                            <input name="pol_4_type" id="pol_4_type-3" value="4" type="checkbox">
                            DTA CIC
                        </label> 
                        <label class="checkbox-inline" for="checkboxes-4">
                            <input name="pol_4_type" id="pol_4_type-4" value="5" type="checkbox">
                            CIC
                        </label> 
                    </div>

                    <div class="col-md-1">
                        <label class="col-md-4 control-label" for="pol_4_soj">S/J 1,2?</label>
                        <input type="text" name="pol_4_soj" class="form-control input-md" placeholder="">
                    </div> 

                    <div class="col-md-12"><br></div>

                    <div class="col-md-12"> 
                        <label class="col-md-4 control-label" for="textinput" style="color:red;">CHECKED ON DEALSHEET</label>
                        <label class="checkbox-inline" for="checkboxes-0">
                            <input name="chk_postcode" id="chk_postcode-0" value="1" type="checkbox">
                            POST CODE
                        </label> 
                        <label class="checkbox-inline" for="chk_dob-1">
                            <input name="chk_dob" id="chk_dob-1" value="2" type="checkbox">
                            DOB
                        </label> 
                        <label class="checkbox-inline" for="chk_mob-0">
                            <input name="chk_mob" id="chk_mob-0" value="1" type="checkbox">
                            MOBILE NO
                        </label> 
                        <label class="checkbox-inline" for="chk_home-0">
                            <input name="chk_home" id="chk_home-0" value="1" type="checkbox">
                            HOME NO
                        </label> 
                        <label class="checkbox-inline" for="chk_email-0">
                            <input name="chk_email" id="chk_email-0" value="1" type="checkbox">
                            EMAIL
                        </label> 
                    </div>

                    <div class="col-md-12"><br></div>

                    <div class="col-md-12">
                        <div class="col-md-2">

                            <label class="col-md-4 control-label" for="fee">FEE</label>
                            <input type="text" name="fee" class="form-control input-md" placeholder="£">
                        </div>

                        <div class="col-md-2">
                            <label class="col-md-4 control-label" for="total">COMMS</label>
                            <input type="text" name="total" class="form-control input-md" placeholder="£">
                        </div>

                        <div class="col-md-1">
                            <label class="col-md-4 control-label" for="years">YEARS</label>
                            <input type="text" name="years" class="form-control input-md" placeholder="Years">
                        </div>

                        <div class="col-md-1">
                            <label class="col-md-4 control-label" for="month">MONTHS</label>
                            <input type="text" name="month" class="form-control input-md" placeholder="Months">
                        </div>

                        <div class="col-md-2">
                            <label class="col-md-4 control-label" for="comm_after">COMMSAFTER</label>
                            <input type="text" name="comm_after" class="form-control input-md" placeholder="">
                        </div>

                        <div class="col-md-1">
                            <label class="col-md-4 control-label" for="sac">SAC</label>
                            <input type="text" name="sac" class="form-control input-md" placeholder="%">
                        </div>

                        <div class="col-md-2">
                            <label class="col-md-4 control-label" for="closer_date">DATE</label>
                            <input type="text" name="closer_date" class="form-control input-md" placeholder=""> 
                        </div>
                    </div>
                    </div></div>
        
                    <div class="panel panel-danger">
                <div class="panel-heading">Mortgage</div>
                <div class="panel-body">
                        
<div class="row">   
                    <div class="col-md-12">
                        <label for="MORTGAGE_TYPE">Mortgage Type</label>
                        <label class="radio-inline" for="Fixed-0">
                            <input name="MORTGAGE_TYPE" id="Fixed-0" value="Fixed" type="radio">
                            Fixed
                        </label> 
                        <label class="radio-inline" for="Variable-1">
                            <input name="MORTGAGE_TYPE" id="Variable-1" value="Variable" type="radio">
                            Variable
                        </label> 
                        <label class="radio-inline" for="Tracker-2"">
                            <input name="MORTGAGE_TYPE" id="Tracker-2" value="Tracker" type="radio">
                            Tracker
                        </label> 
                    </div>
                    
                                        <div class="col-md-12">
                        <label for="MORTGAGE_REASON">Review Reason</label>
                        <label class="radio-inline" for="Fixed-0">
                            <input name="MORTGAGE_REASON" id="Fixed-0" value="Lower Interest Rates" type="radio">
                            Lower Interest Rates
                        </label> 
                        <label class="radio-inline" for="Variable-1">
                            <input name="MORTGAGE_REASON" id="Variable-1" value="Remortgage" type="radio">
                            Remortgage
                        </label> 
                        <label class="radio-inline" for="Tracker-2"">
                            <input name="MORTGAGE_REASON" id="Tracker-2" value="Save Money" type="radio">
                            Save Money
                        </label> 
                  
    </div>
                       <div class="col-md-12">
                           <div class="col-md-4">
                            <input type="text" name="MORTGAGE_CB_DATE" class="form-control input-md" placeholder="Callback date"> 
                           </div>
    
                    <div class="col-md-4">  
                            <input type="text" name="MORTGAGE_CB_TIME" class="form-control input-md" placeholder="Callback time"> 
                    </div>
                       </div>
         
</div>

                    </div>
                </div>
            </div>

    <?php } ?>

        <div class="col-md-12"><br></div>

        <center>
            <div class="col-md-4"></div>

            <div class="col-md-4">
                <select class="form-control" name="closer">
                    <option value="">SEND TO CLOSER OR SET AS CALLBACK</option>
                    <option value="CALLBACK">Set as Callback</option>
                            <option value="James">James Adams</option>
                            <option value="Kyle">Kyle Barnett</option>  
                            <option value="David">David Bebee</option> 
                            <option value="Richard">Richard Michaels</option>
                            <option value="Hayley">Hayley Hutchinson</option> 
                            <option value="Sarah">Sarah Wallace</option>
                            <option value="Gavin">Gavin Fulford</option> 
                            <option value="Mike">Michael Lloyd</option> 
                            <option value="carys">Carys Riley</option>
                            <option value="abbiek">Abbie Kenyon</option>
                            <option value="Nicola">Nicola Griffiths</option>
                            <option value="Keith">Keith Dance</option>
                </select>
            </div>

            <div class="col-md-4"></div>  

            <div class="col-md-12"><br></div> 

            <div class="col-md-12">
                <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> SAVE DEALSHEET</button>
            </div>

        </center>
    </form>

    </div>

<?php } ?>

</div>

<script>
    document.querySelector('#Send').addEventListener('submit', function (e) {
        var form = this;
        e.preventDefault();
        swal({
            title: "Send Dealsheet?",
            text: "Has the dealsheet been checked by a manger?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, send it!',
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        swal({
                            title: 'Sent!',
                            text: 'Dealsheet sent!',
                            type: 'success'
                        }, function () {
                            form.submit();
                        });

                    } else {
                        swal("Cancelled", "Dealsheet not sent", "error");
                    }
                });
    });
</script>
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
<script src="/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 

<script>var options = {
url: "../JSON/LeadGenNames.json",
getValue: "full_name",
list: {
match: {
enabled: true
}
}
};

$("#provider-json").easyAutocomplete(options);</script>
<script>var options = {
        url: "/JSON/CloserNames.json",
        getValue: "full_name",
        list: {
            match: {
                enabled: true
            }
        }
    };

    $("#closer").easyAutocomplete(options);
</script>
<script>var options = {
        url: "/JSON/AllNames.json",
        getValue: "full_name",
        list: {
            match: {
                enabled: true
            }
        }
    };

    $("#lead").easyAutocomplete(options);</script>
<script src="/js/sweet-alert.min.js"></script>

<script type="text/javascript">
     function CALLMANANGER() {


         $.get("php/LifeDealSheetManager.php?query=1");
         return false;

     }
</script>
<script type="text/javascript">
    function CANCELMANAGER() {


        $.get("php/LifeDealSheetManager.php?query=2");
        return false;
    }
</script>
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
<!--<script>
    $(function () {
        $('#CloserSelect').change(function () {
            this.form.submit();
        });
    });
</script>-->

<script src="/js/jquery.postcodes.min.js"></script>
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
</script>
<script>
    webshims.setOptions('forms-ext', {
        replaceUI: 'auto',
        types: 'number'
    });
    webshims.polyfill('forms forms-ext');
</script>
                                    <script type="text/JavaScript">
                                    var $select = $('#agent_name');
                                    $.getJSON('../../JSON/Agents.php?EXECUTE=1', function(data){
                                    $select.html('agent_name');
                                    $.each(data, function(key, val){ 
                                    $select.append('<option value="' + val.full_name + '">' + val.full_name + '</option>');
                                    })
                                    });
                                </script>
</body>
</html>
