<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    $custype= filter_input(INPUT_POST, 'custype', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($custype)) {
        
    include('../classes/database_class.php');
    include('../includes/adlfunctions.php');  

        
        if($custype=='PBA') {
            
        $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $first= filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $last= filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
        $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $tel= filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
        $tel2= filter_input(INPUT_POST, 'tel2', FILTER_SANITIZE_SPECIAL_CHARS);
        $tel3= filter_input(INPUT_POST, 'tel3', FILTER_SANITIZE_SPECIAL_CHARS);
        $title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
        $first2= filter_input(INPUT_POST, 'firstname2', FILTER_SANITIZE_SPECIAL_CHARS);
        $last2= filter_input(INPUT_POST, 'lastname2', FILTER_SANITIZE_SPECIAL_CHARS);
        $dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
        $email2= filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_SPECIAL_CHARS);
        $add1= filter_input(INPUT_POST, 'add1', FILTER_SANITIZE_SPECIAL_CHARS);
        $add2= filter_input(INPUT_POST, 'add2', FILTER_SANITIZE_SPECIAL_CHARS);
        $add3= filter_input(INPUT_POST, 'add3', FILTER_SANITIZE_SPECIAL_CHARS);
        $town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
        $post= filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $correct_dob = date("Y-m-d" , strtotime($dob)); 
        $correct_dob2 = date("Y-m-d" , strtotime($dob2));
        
        $database = new Database(); 
            
            $database->query("INSERT into pba_client_details set title=:title, firstname=:first, lastname=:last, dob=:dob, email=:email, tel=:tel, tel2=:tel2, tel3=:tel3, title2=:title2, firstname2=:first2, lastname2=:last2, dob2=:dob2, email2=:email2, add1=:add1, add2=:add2, add3=:add3, town=:town, post_code=:post, submitted_by=:hello");
            $database->bind(':title', $title);
            $database->bind(':first',$first);
            $database->bind(':last',$last);
            $database->bind(':dob',$correct_dob);
            $database->bind(':email',$email);
            $database->bind(':tel',$tel);
            $database->bind(':tel2',$tel2);
            $database->bind(':tel3',$tel3);
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
            $database->execute();  
            $last_id = $database->lastInsertId();
            
            if ($database->rowCount()>=1) {
            
                header('Location: ../PBA/AddNewClient.php?Clientadded=1&id='.$last_id); die;
                
            }
            
            else {
             
                header('Location: ../PBA/AddNewClient.php?Clientadded=0'); die;
                
            }
            
        }
        
        if($custype=='Life' || $custype=='Bluestone Protect' || $custype=='TRB Vitality' || $custype=='TRB WOL' || $custype=='TRB Royal London') {
            
            ?>

<!DOCTYPE html>
<html lang="en">
<title>ADL | Add Client Submit</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="../styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/style/jquery-ui.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
<script src="/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
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
    
    <?php
    
    include('../includes/navbar.php'); 
    
    ?>	
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
        $correct_dob2 = date("Y-m-d" , strtotime($dob2));
        
        $database = new Database(); 
        $database->beginTransaction();
        
        $database->query("Select client_id, first_name, last_name FROM client_details WHERE post_code=:post AND address1 =:add1 AND company=:company");
        $database->bind(':company', $custype);
        $database->bind(':post', $post);
        $database->bind(':add1',$add1);
        $database->execute();
        
        if ($database->rowCount()>=1) {
            $row = $database->single();
            
            $dupeclientid=$row['client_id'];
            
            echo "<div class=\"notice notice-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Error!</strong> Duplicate address details found<br><br>Existing client name: $first $last<br> Address: $add1 $post.<br><br><a href='../Life/ViewClient.php?search=$dupeclientid' class=\"btn btn-default\"><i class='fa fa-eye'> View Client</a></i></div>";
            
        }
        
        else {
            
            $database->query("INSERT into client_details set company=:company, title=:title, first_name=:first, last_name=:last, dob=:dob, email=:email, phone_number=:phone, alt_number=:alt, title2=:title2, first_name2=:first2, last_name2=:last2, dob2=:dob2, email2=:email2, address1=:add1, address2=:add2, address3=:add3, town=:town, post_code=:post, submitted_by=:hello, recent_edit=:hello2");
            $database->bind(':company', $custype);
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
                $custypenamedata= $title ." ". $first ." ". $last;
                $messagedata="Client Uploaded";
                
                $database->query("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                $database->bind(':clientidholder',$lastid);
                $database->bind(':sentbyholder',$hello_name);
                $database->bind(':recipientholder',$custypenamedata);
                $database->bind(':noteholder',$notedata);
                $database->bind(':messageholder',$messagedata);
                $database->execute();
                
                if($custype=='Life' || $custype=='Bluestone Protect') {               
                
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
        
 }
 
                $database->endTransaction();
         
     }
     
     else {
         
         header('Location: ../CRMmain.php?Clientadded=failed'); die;
         }

?>
        
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Add <?php echo $custype; ?> Policy <a href='../Life/ViewClient.php?search=<?php echo "$lastid";?>'><button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-user"></i> Skip Policy and View Client...</button></a></div>
                <div class="panel-body">

<form class="AddClient" action="/php/AddPolicySubmit.php" method="POST">

<div class="col-md-4">

<input type="hidden" name="client_id" value="<?php echo $lastid;?>">

<?php if($custype=='Bluestone Protect' || 'TRB WOL') { ?>
<input type="hidden" id="custtype" name="custtype" value="Life" required>
<?php }
if($custype=='TRB Vitality') { ?>
<input type="hidden" id="custtype" name="custtype" value="TRB Vitality" required>
<?php }
if($custype=='TRB Home Insurance') { ?>
<input type="hidden" id="custtype" name="custtype" value="TRB Home Insurance" required>
<?php } if($custype=='TRB Royal London') { ?>
<input type="hidden" id="custtype" name="custtype" value="TRB Royal London" required>
<?php } ?>


<label for="client_name">Client Name</label>
<select class="form-control"  style="width: 140px"  name="client_name" required>
<option value="<?php echo $title; ?> <?php echo $first; ?> <?php echo $last; ?>">  <?php echo $title; ?> <?php echo $first;?> <?php echo $last;?></option>
<option value="<?php echo $title2; ?> <?php echo $first2; ?> <?php echo $last2; ?>">  <?php echo $title2; ?> <?php echo $first2; ?> <?php echo $last2; ?></option>
<option value=" <?php echo "$title $first $last and $title2 $first2 $last";?>">  <?php echo "$title $first $last and $title2 $first2 $last2";?></option>
</select>
<br>

<label for="soj">Single or Joint:</label>
<select class="form-control"  style="width: 140px" name="soj" required>
<option value="Single">Single</option>
<option value="Joint">Joint</option>
</select>

<br>
<label for="sale_date">Sale Date:</label>
<input class="form-control" type="text" id="sale_date" value="<?php echo $date = date('Y-m-d H:i:s');?>" placeholder="<?php echo $date = date('Y-m-d H:i:s');?>" name="sale_date"  style="width: 140px" required>

<br>

<label for="application_number">Application Number:</label>
<input class="form-control" autocomplete="off" type="text" id="application_number" name="application_number"  style="width: 140px" <?php if(isset($custype)) { if($custype=='TRB WOL') { echo "Value='WOL'"; } if($custype=='TRB Royal London') { echo "Value='Royal London'"; }  } ?> required>
<label for="application_number"></label>
<?php if(isset($custype)) { if($custype=='TRB WOL') { ?> <span class="help-block">For WOL use One Family</span>  <?php } }?>
<?php if(isset($custype)) { if($custype=='TRB WOL') { ?> <span class="help-block">For Royal London use Royal London</span>  <?php } }?>
<br>


<label for="policy_number">Policy Number:</label>
<input class="form-control" autocomplete="off" type='text' id='policy_number' name='policy_number' style="width: 140px" placeholder="TBC">

<br>


<div class="form-row">
  <label for="type">Type:</label>
  <select class="form-control" name="type" id="type" style="width: 140px" required>
  <option value="">Select...</option>
  <option value="LTA">LTA</option>
  <option value="LTA SIC">LTA SIC (Vitality)</option>
  <option value="LTA CIC">LTA + CIC</option>
  <option value="DTA">DTA</option>
  <option value="DTA CIC">DTA + CIC</option>
  <option value="CIC">CIC</option>
  <option value="FPIP">FPIP</option>
  <option value="WOL" <?php if(isset($custype)) { if($custype=='TRB WOL') { echo "selected"; } } ?>>WOL</option>
  </select>
</div>

<br>


<div class="form-row">
  <label for="insurer">Insurer:</label>
  <select class="form-control" name="insurer" id="insurer" style="width: 140px" required>
  <option value="">Select...</option>
  <option value="Legal and General" <?php if(isset($custype)) { if($custype=='Bluestone Protect') { echo "selected"; } } ?>>Legal & General</option>
  <option value="Vitality" <?php if(isset($custype)) { if($custype=='TRB WOL') { echo "selected"; } } ?>>Vitality</option>
  <option value="Bright Grey">Bright Grey</option>
  <option value="Royal London" <?php if(isset($custype)) { if($custype=='TRB Royal London') { echo "selected"; } } ?>>Royal London</option>
  <option value="One Family" <?php if(isset($custype)) { if($custype=='TRB WOL') { echo "selected"; } } ?>>One Family</option>
  </select>
</div>

</div>

<div class="col-md-4">
 <div class="form-row">
        <label for="premium">Premium:</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input autocomplete="off" style="width: 140px" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" required/>
    </div> 
<br>


 <div class="form-row">
        <label for="commission">Commission</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input autocomplete="off" style="width: 140px" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required/>
    </div> 
<br>


 <div class="form-row">
        <label for="commission">Cover Amount</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input autocomplete="off" style="width: 140px" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="covera" required/>
    </div> 
<br>


 <div class="form-row">
        <label for="commission">Policy Term</label>
    <div class="input-group"> 
        <span class="input-group-addon">yrs</span>
        <input autocomplete="off" style="width: 140px" type="text" class="form-control" id="polterm" name="polterm" <?php if(isset($custype)) { if($custype=='TRB WOL') { echo "value='WOL'"; } } ?> required/>
    </div> 
        <br>

<div class="form-row">
  <label for="CommissionType">Comms:</label>
  <select class="form-control" name="CommissionType" id="CommissionType" style="width: 140px" required>
  <option value="">Select...</option>
  <option value="Indemnity">Indemnity</option>
  <option value="Non Idenmity">Non-Idemnity</option>
  <option value="NA <?php if(isset($custype)) { if($custype=='TRB WOL') { echo "selected"; } } ?>">N/A</option>
  </select>
</div>

<br>


<div class="form-row">
  <label for="comm_term">Clawback Term:</label>
  <select class="form-control" name="comm_term" id="comm_term" style="width: 140px" required>
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
<option value="2 year">2 year</option>
<option value="3 year">3 year</option>
<option value="4 year">4 year</option>
<option value="5 year">5 year</option>
<option value="0">0</option>
  </select>
</div>


<br>

 <div class="form-row">
        <label for="commission">Drip</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input autocomplete="off" style="width: 140px" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" required/>
    </div> 


<br>

<div class="form-row">
  <label for="PolicyStatus">Policy Status:</label>
  <select class="form-control" name="PolicyStatus" id="PolicyStatus" style="width: 140px">
  <option value="">Select...</option>  
  <option value="Live">Live</option>
  <option value="Awaiting Policy Number">Awaiting Policy Number (TBC Policies)</option>
  <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
  <option value="NTU">NTU</option>
  <option value="Declined">Declined</option>
    <option value="Redrawn">Redrawn</option>
 </select>
</div>

<br>

<label for="closer">Closer:</label>
<input type='text' id='closer' name='closer' style="width: 140px" required>
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

<label for="lead">Lead Gen:</label>
<input type='text' id='lead' name='lead' style="width: 140px" required>
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
<br>
<br>
<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Policy</button>
</div>
</form>
          
<?php }?>
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
<?php } 

if($custype=='TRB Home Insurance') {
 
    ?>

<!DOCTYPE html>
<html lang="en">
<title>Add Home Insurance Policy</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/style/jquery-ui.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
<script src="/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
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
    
    <?php include('../includes/navbar.php'); 
        
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
        
        if(isset($dob2)) {
            $correct_dob2 = date("Y-m-d" , strtotime($dob2));
            
        }
        
        $database = new Database(); 
        $database->beginTransaction();
        
        $database->query("Select client_id, first_name, last_name FROM client_details WHERE post_code=:post AND address1 =:add1 AND company='TRB Home Insurance'");
        $database->bind(':post', $post);
        $database->bind(':add1',$add1);
        $database->execute();
        
        if ($database->rowCount()>=1) {
            $row = $database->single();
            
            $dupeclientid=$row['client_id'];
            
            echo "<div class=\"notice notice-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Error!</strong> Duplicate address details found<br><br>Existing client name: $first $last<br> Address: $add1 $post.<br><br><a href='../Life/ViewClient.php?search=$dupeclientid' class=\"btn btn-default\"><i class='fa fa-eye'> View Client</a></i></div>";
            
        }
        
        else {
            
            $database->query("INSERT into client_details set company=:company, title=:title, first_name=:first, last_name=:last, dob=:dob, email=:email, phone_number=:phone, alt_number=:alt, title2=:title2, first_name2=:first2, last_name2=:last2, dob2=:dob2, email2=:email2, address1=:add1, address2=:add2, address3=:add3, town=:town, post_code=:post, submitted_by=:hello, recent_edit=:hello2");
            $database->bind(':company', $custype);
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
                $custypenamedata= $title ." ". $first ." ". $last;
                $messagedata="Client Uploaded";
                
                $database->query("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                $database->bind(':clientidholder',$lastid);
                $database->bind(':sentbyholder',$hello_name);
                $database->bind(':recipientholder',$custypenamedata);
                $database->bind(':noteholder',$notedata);
                $database->bind(':messageholder',$messagedata);
                $database->execute();
                
                $database->endTransaction();
         
     }
     
     else {
         
         header('Location: ../CRMmain.php?Clientadded=failed'); die;
         }

?>
           <div class="container">
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Add Policy <a href='../Home/ViewClient.php?CID=<?php echo "$lastid";?>'><button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-user"></i> Skip Policy and View Client...</button></a></div>
                <div class="panel-body">
                    
                    <form class="AddClient" action="AddPolicySubmit.php?query=HomeInsurance&CID=<?php echo $lastid;?>" method="POST">
                        
                        <div class="col-md-4">
                            
                            <label for="client_name">Client Name</label>
                            <select class="form-control"  style="width: 140px"  name="client_name" required>
                                <option value="<?php echo $title;?> <?php echo $first;?> <?php echo $last;?>">  <?php echo $title;?> <?php echo $first;?> <?php echo $last;?></option>
                                <option value="<?php echo $title2;?> <?php echo $first2;?> <?php echo $last2;?>">  <?php echo $title2;?> <?php echo $first2;?> <?php echo $last2;?></option>
                                <option value=" <?php echo "$title $first $last and $title2 $first2 $last";?>">  <?php echo "$title $first $last and $title2 $first2 $last2";?></option>
                            </select>
                            <br>

<br>
<label for="sale_date">Sale Date:</label>
<input class="form-control" type="text" id="sale_date" value="<?php echo $date = date('Y-m-d H:i:s');?>" placeholder="<?php echo $date = date('Y-m-d H:i:s');?>" name="sale_date"  style="width: 140px" required>

<br>
<label for="policy_number">Policy Number:</label>
<input class="form-control" autocomplete="off" type='text' id='policy_number' name='policy_number' style="width: 140px" placeholder="TBC">

<br>
<label for="insurer">Insurer:</label>
<input class="form-control" autocomplete="off" type='text' id='insurer' name='insurer' style="width: 140px" placeholder="Insurer">

<br>
<div class="form-row">
  <label for="type">Type:</label>
  <select class="form-control" name="type" id="type" style="width: 140px" required>
  <option value="">Select...</option>
  <option value="Buildings">Buildings</option>
  <option value="Contents">Contents</option>
  <option value="Buidlings and Contents">Buildings & Contents</option>
  </select>
</div>

<br>

</div>


<div class="col-md-4">
    <div class="form-row">
        
        <label for="premium">Premium:</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input autocomplete="off" style="width: 140px" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" required/>
    </div> 

<br>
 <div class="form-row">
        <label for="commission">Commission</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input autocomplete="off" style="width: 140px" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required/>
    </div> 

<br>
 <div class="form-row">
        <label for="cover">Cover Amount</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input autocomplete="off" style="width: 140px" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="cover" name="covera" required/>
    </div> 

<br>
<div class="form-row">
  <label for="PolicyStatus">Policy Status:</label>
  <select class="form-control" name="status" id="status" style="width: 140px">
  <option value="">Select...</option>
  <option value="Live">Live</option>
  <option value="Awaiting Policy Number">Awaiting Policy Number (TBC Policies)</option>
  <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
  <option value="NTU">NTU</option>
  <option value="Declined">Declined</option>
    <option value="Redrawn">Redrawn</option>
   </select>
</div>

<br>
<label for="closer">Closer:</label>
<input type='text' id='closer' name='closer' style="width: 140px" required>
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

<label for="lead">Lead Gen:</label>
<input type='text' id='lead' name='lead' style="width: 140px" required>
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
<br>
<br>
<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Policy</button>
</div>
</form>
          
<?php }?>
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
<?php } }

else {
header('Location: ../CRMmain.php?Clientadded=failed'); die;
}
?>