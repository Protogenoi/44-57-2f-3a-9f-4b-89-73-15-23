<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');
include('../../includes/Access_Levels.php');

if (in_array($hello_name, $Level_3_Access, true) || in_array($hello_name, $COM_MANAGER_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 


if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    $INSURER= filter_input(INPUT_POST, 'custype', FILTER_SANITIZE_SPECIAL_CHARS);
    

        
    include('../../classes/database_class.php');
    include('../../includes/adlfunctions.php');

$INSURER_ARRAY_ONE=array("Bluestone Protect","The Review Bureau","TRB Archive","TRB Vitality","Vitality","TRB Aviva","Aviva","TRB WOL","One Family","TRB Royal London","Royal London");
    

            
    ?>

<!DOCTYPE html>
<html lang="en">
<title>ADL | Add Client Submit</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/style/jquery-ui.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
<script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
<script>
  $(function() {
    $( "#sale_date" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
</script>
<script>
  $(function() {
    $( "#submitted_date" ).datepicker({
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
    
    <?php include('../../includes/navbar.php');  ?>	
    <div class="container">
        
        <?php
        
        $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $first= filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $last= filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
        $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $phone= filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $alt= filter_input(INPUT_POST, 'alt_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
        $first2= filter_input(INPUT_POST, 'first_name2', FILTER_SANITIZE_SPECIAL_CHARS);
        $last2= filter_input(INPUT_POST, 'last_name2', FILTER_SANITIZE_SPECIAL_CHARS);
        $dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
        $email2= filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_SPECIAL_CHARS);
        $add1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
        $add2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
        $add3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
        $town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
        $post= filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $correct_dob = date("Y-m-d" , strtotime($dob)); 
        if(!empty($dob2)) {
        $correct_dob2 = date("Y-m-d" , strtotime($dob2));
        }
        else {
          $correct_dob2="NA";  
        }
        $database = new Database(); 
        $database->beginTransaction();
        
        $database->query("Select client_id, first_name, last_name FROM client_details WHERE post_code=:post AND address1 =:add1 AND company=:company AND owner=:OWNER");
        $database->bind(':OWNER', $COMPANY_ENTITY);
        $database->bind(':company', $INSURER);
        $database->bind(':post', $post);
        $database->bind(':add1',$add1);
        $database->execute();
        
        if ($database->rowCount()>=1) {
            $row = $database->single();
            
            $dupeclientid=$row['client_id'];
            
            echo "<div class=\"notice notice-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Error!</strong> Duplicate address details found<br><br>Existing client name: $first $last<br> Address: $add1 $post.<br><br><a href='../../Life/ViewClient.php?search=$dupeclientid' class=\"btn btn-default\"><i class='fa fa-eye'> View Client</a></i></div>";
            
        }
        
        else {
            
            $database->query("INSERT into client_details set owner=:OWNER, company=:company, title=:title, first_name=:first, last_name=:last, dob=:dob, email=:email, phone_number=:phone, alt_number=:alt, title2=:title2, first_name2=:first2, last_name2=:last2, dob2=:dob2, email2=:email2, address1=:add1, address2=:add2, address3=:add3, town=:town, post_code=:post, submitted_by=:hello, recent_edit=:hello2");
            $database->bind(':OWNER', $COMPANY_ENTITY);
            $database->bind(':company', $INSURER);
            $database->bind(':title', $title);
            $database->bind(':first',$first);
            $database->bind(':last',$last);
            $database->bind(':dob',$correct_dob);
            $database->bind(':email',$email);
            $database->bind(':phone',$phone);
            $database->bind(':alt',$alt);
            $database->bind(':title2', $title2);
            $database->bind(':first2',$first2);
            $database->bind(':last2',$last2);
            $database->bind(':dob2',$correct_dob2);
            $database->bind(':email2',$email2);
            $database->bind(':add1',$add1);
            $database->bind(':add2',$add2);
            $database->bind(':add3',$add3);
            $database->bind(':town',$town);
            $database->bind(':post',$post);
            $database->bind(':hello',$hello_name);
            $database->bind(':hello2',$hello_name);
            $database->execute();
            $lastid =  $database->lastInsertId();
            
            if ($database->rowCount()>=0) { 
                
                $notedata= "Client Added";
                $INSURERnamedata= $title ." ". $first ." ". $last;
                $messagedata="Client Uploaded";
                
                $database->query("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                $database->bind(':clientidholder',$lastid);
                $database->bind(':sentbyholder',$hello_name);
                $database->bind(':recipientholder',$INSURERnamedata);
                $database->bind(':noteholder',$notedata);
                $database->bind(':messageholder',$messagedata);
                $database->execute();                       
                
                $weekarray=array('Mon','Tue','Wed','Thu','Fri');
                $today=date("D"); // check Day Mon - Sun
                $date=date("Y-m-d",strtotime($today)); // Convert day to date
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='CYD'");
                $database->execute();
                $assignCYDd=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='24 48'");
                $database->execute();
                $assign24d=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='5 day'");
                $database->execute();
                $assign5d=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='18 day'");
                $database->execute();
                $assign18d=$database->single();
                
                $assignCYD=$assignCYDd['Assigned'];
                $assign24=$assign24d['Assigned'];
                $assign5=$assign5d['Assigned'];
                $assign18=$assign18d['Assigned'];
                
                $taskCYD="CYD";
                $next = date("D", strtotime("+91 day")); // Add 2 to Day
                
                if($next =="Sat") { //Check if Weekend
                $SkipWeekEndDayCYD = date("Y-m-d", strtotime("+93 day")); //Add extra 2 Days if Sat Weekend
                $deadlineCYD=$SkipWeekEndDayCYD;
                
                }
                
                if($next=="Sun") {
                    $SkipWeekEndDayCYD = date("Y-m-d", strtotime("+92 day"));
                    $deadlineCYD=$SkipWeekEndDayCYD;
                    
                }
                
                if (in_array($next,$weekarray,true)){
                    $WeekDayCYD = date("Y-m-d", strtotime("+91 day"));
                    $deadlineCYD=$WeekDayCYD;
                    
                } 
                
                $date_added= date("Y-m-d H:i:s");
                $task24="24 48";
                
                $next24 = date("D", strtotime("+2 day")); 
                if($next24 =="Sat") { 
                    $SkipWeekEndDay24 = date("Y-m-d", strtotime("+4 day")); 
                    $deadline24=$SkipWeekEndDay24;
                    
                }

if($next24=="Sun") { 

    $SkipWeekEndDay24 = date("Y-m-d", strtotime("+3 day")); 

    $deadline24=$SkipWeekEndDay24;

}


if (in_array($next24,$weekarray,true)){

$WeekDay24 = date("Y-m-d", strtotime("+2 day"));

    $deadline24=$WeekDay24;

} 

$task5="5 day";
$next5 = date("D", strtotime("+5 day")); // Add 2 to Day

if($next5 =="Sat") { //Check if Weekend

    $SkipWeekEndDay5 = date("Y-m-d", strtotime("+7 day")); //Add extra 2 Days if Sat Weekend

    $deadline5=$SkipWeekEndDay5;

}

if($next5=="Sun") { //Check if Weekend

    $SkipWeekEndDay5 = date("Y-m-d", strtotime("+6 day")); //Add extra 1 day if Sunday

    $deadline5=$SkipWeekEndDay5;

}


if (in_array($next5,$weekarray,true)){

$WeekDay5 = date("Y-m-d", strtotime("+5 day"));

    $deadline5=$WeekDay5;

} 


$task18="18 day";
$next18 = date("D", strtotime("+18 day")); // Add 2 to Day

if($next18 =="Sat") { //Check if Weekend

    $SkipWeekEndDay18 = date("Y-m-d", strtotime("+20 day")); //Add extra 2 Days if Sat Weekend

    $deadline18=$SkipWeekEndDay18;

}

if($next18=="Sun") { //Check if Weekend

    $SkipWeekEndDay18 = date("Y-m-d", strtotime("+19 day")); //Add extra 1 day if Sunday

    $deadline18=$SkipWeekEndDay18;

}


if (in_array($next18,$weekarray,true)){

$WeekDay18 = date("Y-m-d", strtotime("+18 day"));

    $deadline18=$WeekDay18;

}

$INSURER_ARRAY_TWO=array("Bluestone Protect","The Review Bureau","Legal and General");

if(in_array($INSURER,$INSURER_ARRAY_TWO)) {

        $database->query("INSERT INTO Client_Tasks set client_id=:cid, Assigned=:assign, task=:task, date_added=:added, deadline=:deadline");
        $database->bind(':assign', $assignCYD, PDO::PARAM_STR);
        $database->bind(':task', $taskCYD, PDO::PARAM_STR);
        $database->bind(':added', $date_added, PDO::PARAM_STR);
        $database->bind(':deadline', $deadlineCYD, PDO::PARAM_STR); 
        $database->bind(':cid', $lastid); 
        $database->execute();
        
        $database->query("INSERT INTO Client_Tasks set client_id=:cid, Assigned=:assign, task=:task, date_added=:added, deadline=:deadline");
        $database->bind(':assign', $assign24, PDO::PARAM_STR);
        $database->bind(':task', $task24, PDO::PARAM_STR);
        $database->bind(':added', $date_added, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline24, PDO::PARAM_STR); 
        $database->bind(':cid', $lastid); 
        $database->execute();
        
}
        
        $database->query("INSERT INTO Client_Tasks set client_id=:cid, Assigned=:assign, task=:task, date_added=:added, deadline=:deadline");
        $database->bind(':assign', $assign5, PDO::PARAM_STR);
        $database->bind(':task', $task5, PDO::PARAM_STR);
        $database->bind(':added', $date_added, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline5, PDO::PARAM_STR); 
        $database->bind(':cid', $lastid); 
        $database->execute();
        
        $database->query("INSERT INTO Client_Tasks set client_id=:cid, Assigned=:assign, task=:task, date_added=:added, deadline=:deadline");
        $database->bind(':assign', $assign18, PDO::PARAM_STR);
        $database->bind(':task', $task18, PDO::PARAM_STR);
        $database->bind(':added', $date_added, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline18, PDO::PARAM_STR); 
        $database->bind(':cid', $lastid); 
        $database->execute();
        
        $database->endTransaction();

     }
     
     else {
         
        # header('Location: ../../CRMmain.php?Clientadded=failed'); die;
         }

?>
        
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Add <?php echo $INSURER; ?> Policy <a href='/Life/ViewClient.php?search=<?php echo "$lastid";?>'><button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-user"></i> Skip Policy and View Client...</button></a></div>
                <div class="panel-body">
                    
                    <form class="AddClient" action="AddPolicy.php?EXECUTE=1&CID=<?php echo $lastid;?>" method="POST">
                        <div class="col-md-4">


 <div class="alert alert-info"><strong>Client Name:</strong> 
                                    Naming one person will create a single policy. Naming two person's will create a joint policy. <br><br>
                                    <select class='form-control' name='client_name' id='client_name' style='width: 170px' required>
                                            <option value="<?php echo $title; ?> <?php echo $first; ?> <?php echo $last; ?>"><?php echo $title; ?> <?php echo $first; ?> <?php echo $last; ?></option>
                                            <?php if (!empty($title2)) { ?>
                                            <option value="<?php echo $title2; ?> <?php echo $first2; ?> <?php echo $last2; ?>"><?php echo $title2; ?> <?php echo $first2; ?> <?php echo $last2; ?></option>
                                            <option value="<?php echo "$title $first $last and $title2 $first2 $last2"; ?>"><?php echo "$title $first $last and $title2 $first2 $last2"; ?></option>
                                            <?php } ?>    
                                    </select>
                                       </div>  
                            
                                    <p>
                                        <label for="application_number">Application Number:</label>
                                        <?php if (isset($INSURER)) { ?>

                                            <input type="text" id="application_number" name="application_number"  class="form-control" style="width: 170px" value="<?php
                                            if ($INSURER == 'One Family' || $INSURER =="TRB WOL") {
                                                echo "WOL";
                                            } if ($INSURER == 'Royal London' || $INSURER =='TRB Royal London') {
                                                echo "Royal London";
                                            }
                                            ?>" required>
                                               <?php } ?>
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
                                            <option value="TRB Archive" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'TRB Archive') {
                                                    echo "selected";
                                                }
                                            }
                                            ?> >TRB Archive</option>
                                                    <?php
                                                    if (isset($INSURER)) {
                                                        if ($INSURER == 'Vitality' || $INSURER=='TRB Vitality') {
                                                            ?>
                                                    <option value="LTA SIC">LTA SIC (Vitality)</option>
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
                                                if ($INSURER == 'Aviva' || $INSURER =="TRB Aviva") {
                                                    ?> 
                                                    <option value="Income Protection">Income Protection</option>
                                                <?php }
                                            }
                                            if(isset($INSURER) && $INSURER =='TRB WOL' || $INSURER=='One Family') { ?>
                                                    
                                            <option value="WOL" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'TRB WOL' || $INSURER=="One Family"){
                                                    echo "selected";
                                                }
                                            }
                                            ?> >WOL</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-group">
                                        <label for="insurer">Insurer:</label>
                                        <select class="form-control" name="insurer" id="insurer" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="Legal and General" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'Legal and General' || $INSURER=="Bluestone Protect" || $INSURER=="The Review Bureau" || $INSURER=="TRB Archive") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Legal & General</option>
                                            
                                            <option value="Vitality" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'Vitality' || $INSURER=="TRB Vitality") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Vitality</option>
                                            <option value="Bright Grey">Bright Grey</option>
                                            <option value="Royal London" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'Royal London' || $INSURER=="TRB Royal London") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Royal London</option>
                                            <option value="One Family" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'TRB WOL' || $INSURER=="One Family") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>One Family</option>
                                            <option value="Aviva" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'Aviva' || $INSURER =="TRB Aviva") {
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
                                            if ($INSURER == 'TRB Archive') {
                                                echo "value='0'";
                                            }
                                            ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" id="premium" name="premium" required/>
                                        </div> 
                                        </p>

                                        <p>

                                            <label for="commission">Commission</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input <?php
                                            if ($INSURER == 'TRB Archive') {
                                                echo "value='0'";
                                            }
                                            ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required/>
                                        </div> 
                                        </p>

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Cover Amount</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input <?php
                                                if ($INSURER == 'TRB Archive') {
                                                    echo "value='0'";
                                                }
                                                ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="covera" required/>
                                            </div> 
                                            </p>


                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Policy Term</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">yrs</span>
                                                    <input <?php
                                                    if ($INSURER == 'TRB Archive') {
                                                        echo "value='0'";
                                                    }
                                                    ?> style="width: 140px" autocomplete="off" type="text" class="form-control" id="polterm" name="polterm" <?php
                                                        if (isset($INSURER)) {
                                                            if ($INSURER == 'One Family' || $INSURER=='TRB WOL') {
                                                                echo "value='WOL'";
                                                            }
                                                        }
                                                        ?> required/>
                                                </div> 
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
                                                            if ($INSURER == 'One Family' || $INSURER=='TRB WOL') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?>>N/A</option>
                                                    </select>
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
                                                            if ($INSURER == 'One Family' || $INSURER=='TRB WOL' || $INSURER == 'TRB Archive') {
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
                                                        if ($INSURER == 'TRB Archive') {
                                                            echo "value='0'";
                                                        }
                                                        ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" required/>
                                                    </div> 
                                                </div>
                                                    </p>
                                                    
   <p>
                                                        <label for="closer">Closer:</label>
                                                        <input type='text' id='closer' name='closer' style="width: 170px" class="form-control" style="width: 170px" required>
                                                    </p>
                                                    <script>var options = {
                                                            url: "../../JSON/CloserNames.json",
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
                                                            url: "../../JSON/Agents.php?EXECUTE=1",
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
                                        </div>
                               
                        <div class="col-md-4">

                            <div class="alert alert-info"><strong>Sale Date:</strong> 
                                This is the sale date on the dealsheet. <br><br> <input type="text" id="submitted_date" name="submitted_date" value="<?php
                                if ($INSURER == 'TRB Archive') {
                                    echo "2013";
                                } else {
                                    echo date('Y-m-d H:i:s');
                                }
                                ?>" placeholder="<?php echo date('Y-m-d H:i:s'); ?>"class="form-control" style="width: 170px" required>

                            </div>   


                            <div class="alert alert-info"><strong>Submitted Date:</strong> 
                                This is the policy live date on the insurers portal. <br> <br><input type="text" id="sale_date" name="sale_date" value="<?php
                                if ($INSURER == 'TRB Archive') {
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
                                    </select>
                                </div>

                            </div>  
                            
<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Policy</button>
</div>
</form>
              
<?php } }?>
</div>
</div>
</div>
</div>
      </div>
    </div>
          </div>
</div>
    </div>
    
</body>
</html>