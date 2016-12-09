<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
	$test_access_level->log_out();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

$policyID= filter_input(INPUT_GET, 'policyID', FILTER_SANITIZE_NUMBER_INT);
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
}
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Add Fact Find</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#p1q15" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:-0"
        });
  });
  </script>
    <script>
  $(function() {
    $( "#pp1q15" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:-0"
        });
  });
  </script>
  <style>.ui-datepicker { 
  margin-left: 400px;
  z-index: 1000;
}</style>
</head>
<body>
    <?php
    include('includes/navbar.php');
    include('includes/adlfunctions.php');
    
$findnames = $pdo->prepare("SELECT client_id, CONCAT(title, ' ', first_name, ' ',initials, ' ', last_name) AS Name1 , CONCAT(title2, ' ', first_name2, ' ',initials2, ' ', last_name2) AS Name2 FROM pension_clients WHERE client_id =:searchhold;
");
        $findnames->bindParam(':searchhold', $search, PDO::PARAM_INT);
        $findnames->execute();
        $nameresult=$findnames->fetch(PDO::FETCH_ASSOC);
        
            $Name1=$nameresult['Name1'];
            $Name2=$nameresult['Name2'];
            
    $query = $pdo->prepare("SELECT clsr_page1_id, client_id, client_name, p1q1, p1q2, p1q3, p1q4, p1q5, p1q6, p1q6a, p1q7, p1q8, p1q9, p1q10, p1q11, p1q12, p1q13, p1q14, p1q15, p1q16 FROM client_summary_report_page1 WHERE client_id = :search AND client_name=:name");
    $query->bindParam(':search', $search, PDO::PARAM_STR, 12);
    $query->bindParam(':name', $Name1, PDO::PARAM_STR, 12);
    $query->execute();
    $data2=$query->fetch(PDO::FETCH_ASSOC);
    
    $origid=$data2['clsr_page1_id'];
    $p1q1=$data2['p1q1'];
    $p1q2=$data2['p1q2'];
    $p1q3=$data2['p1q3'];
    $p1q4=$data2['p1q4'];
    $p1q5=$data2['p1q5'];
    $p1q6=$data2['p1q6'];
    $p1q6a=$data2['p1q6a'];
    $p1q7=$data2['p1q7'];
    $p1q8=$data2['p1q8'];
    $p1q9=$data2['p1q9'];
    $p1q10=$data2['p1q10'];
    $p1q11=$data2['p1q11'];
    $p1q12=$data2['p1q12'];
    $p1q13=$data2['p1q13'];
    $p1q14=$data2['p1q14'];
    $p1q15=$data2['p1q15'];
    $p1q16=$data2['p1q16'];
    $p1q17=$data2['p1q17'];
            
            ?>

        <div class="container">  
            
            <?php
            
                                    $SummaryReport= filter_input(INPUT_GET, 'SummaryReport', FILTER_SANITIZE_SPECIAL_CHARS);
            
             if(isset($SummaryReport)){
    
      $SummaryReport= filter_input(INPUT_GET, 'SummaryReport', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($SummaryReport =='updated') {

print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-check\"></i> Success:</strong> Client Summary Report Updated!</div>");
    }
    
        if ($SummaryReport =='y') {

print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-check\"></i> Success:</strong> Client Summary Report Added!</div>");
    }
       
            if ($SummaryReport =='fail') {

print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes were made!</div>");
    }
    
            }
            ?>
        
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">Page 1</a></li>
            <li><a data-toggle="pill" href="#menu1">Page 2</a></li>
            <li><a data-toggle="pill" href="#menu2">Partner Page 1</a></li>
            <li><a data-toggle="pill" href="#menu3">Partner Page 2</a></li>
            <li><a data-toggle="modal" data-target="#completestepcheck"><i class="fa fa-question-circle"></i> Stage Complete?</a></li>
            <li><a href="ViewClient.php?search=<?php echo "$search";?>"><i class='fa fa-user'></i> Back to Client</a></li>
        </ul>      
        
        <br>
        
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                
                                <div class="panel panel-primary">
      <div class="panel-heading">Client Summary Report</div>
      <div class="panel-body">
          <form class="form-horizontal" method='POST' action='php/SubmitClientSummaryReport.php?page=1'>
<fieldset>

<!-- Form Name -->
<legend>Client Summary Report</legend>
<input type='hidden' value='<?php echo $search;?>' name='search'>
   <div class="form-group">
  <label class="col-md-4 control-label" for="client_name">Select Client Name</label>
  <div class="col-md-4">
    <select id="client_name" name="client_name" class="form-control">
      <option value="<?php echo $Name1 ?>"><?php echo $Name1 ?></option>
      <option value="<?php echo $Name2 ?>"><?php echo $Name2 ?></option>
    </select>
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q1">Projected Retirement Age</label>  
  <div class="col-md-4">
  <input id="p1q1" name="p1q1" placeholder="" class="form-control input-md" type="text" <?php if (isset($p1q1)) { echo "value='$p1q1'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q2">Product Name</label>  
  <div class="col-md-4">
  <input id="p1q2" name="p1q2" placeholder="" class="form-control input-md" type="text" <?php if (isset($p1q2)) { echo "value='$p1q2'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q3">Fund Valuation Date</label>  
  <div class="col-md-4">
  <input id="p1q3" name="p1q3" placeholder="" class="form-control input-md" type="text" <?php if (isset($p1q3)) { echo "value='$p1q3'";} ?>>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q4">Fund Value</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p1q4" name="p1q4" class="form-control" placeholder="" type="text" <?php if (isset($p1q4)) { echo "value='$p1q4'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q5">Transfer Value</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p1q5" name="p1q5" class="form-control" placeholder="" type="text" <?php if (isset($p1q5)) { echo "value='$p1q5'";} ?>>
    </div>
    
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q6">Regular Contributions</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p1q6-0">
      <input name="p1q6" id="p1q6-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p1q6)) { echo 'checked="checked"'; } elseif ($p1q6=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p1q6-1">
      <input name="p1q6" id="p1q6-1" value="No" type="radio" <?php if(isset($p1q6)) {if ($p1q6=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q6a"></label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p1q6a" name="p1q6a" class="form-control" placeholder="" type="text" <?php if (isset($p1q6a)) { echo "value='$p1q6a'";} ?>>
    </div>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q7">Management Charges</label>  
  <div class="col-md-4">
  <input id="p1q7" name="p1q7" placeholder="" class="form-control input-md" type="text" <?php if (isset($p1q7)) { echo "value='$p1q7'";} ?>>
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q8">Death Benefits</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p1q8" name="p1q8"><?php if (isset($p1q8)) { echo "$p1q8";} ?></textarea>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q9">Projected Monthly Income</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p1q9" name="p1q9" class="form-control" placeholder="" type="text" <?php if (isset($p1q9)) { echo "value='$p1q9'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q10">State Pension Income</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p1q10" name="p1q10" class="form-control" placeholder="" type="text" <?php if (isset($p1q10)) { echo "value='$p1q10'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q11">Monthly Expenses</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p1q11" name="p1q11" class="form-control" placeholder="" type="text" <?php if (isset($p1q11)) { echo "value='$p1q11'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q12">Overall</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p1q12" name="p1q12" class="form-control" placeholder="" type="text" <?php if (isset($p1q12)) { echo "value='$p1q12'";} ?>>
    </div>
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q13">Client Views &amp; Comments</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p1q13" name="p1q13"><?php if (isset($p1q13)) { echo "$p1q13";} ?></textarea>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q14">IFA Call</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p1q14-0">
      <input name="p1q14" id="p1q15-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p1q14)) { echo 'checked="checked"'; } elseif ($p1q14=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p1q14-1">
      <input name="p1q14" id="p1q15-1" value="No" type="radio" <?php if(isset($p1q14)) {if ($p1q14=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q15">Appointment Date</label>  
  <div class="col-md-4">
  <input id="p1q15" name="p1q15" placeholder="YYYY-MM-DD" class="form-control input-md" type="text" <?php if (isset($p1q15)) { echo "value='$p1q15'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p1q16">Appointment Time</label>  
  <div class="col-md-4">
  <input id="p1q16" name="p1q16" placeholder="HH:MM:SS" class="form-control input-md" type="text" <?php if (isset($p1q16)) { echo "value='$p1q16'";} ?>>
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
  </div>
</div>

</fieldset>
</form>

          
      </div>
                                </div>
    
                
            </div>
            
            <?php 
            
                        
    $page2 = $pdo->prepare("SELECT p2q1, p2q2, p2q3, p2q4, p2q5, p2q6, p2q7, p2q8, p2q9, p2q10, p2q11, p2q12, p2q13, p2q13b, p2q14, p2q15, p2q16, p2q17, p2q18, p2q19, p2q20, p2q20a, p2q20b, p2q20c, p2q20d, p2q21, p2q22, p2q22a, p2q22b, p2q22c, p2q22d, p2q22e, p2q22f FROM client_summary_report_page2 WHERE clsr_page1_id=:search");
    $page2->bindParam(':search', $origid, PDO::PARAM_STR, 12);

    $page2->execute();
    $data3=$page2->fetch(PDO::FETCH_ASSOC);
    
    $p2q1=$data3['p2q1'];
    $p2q2=$data3['p2q2'];
    $p2q3=$data3['p2q3'];
    $p2q4=$data3['p2q4'];
    $p2q5=$data3['p2q5'];
    $p2q6=$data3['p2q6'];
    $p2q7=$data3['p2q7'];
    $p2q8=$data3['p2q8'];
    $p2q9=$data3['p2q9'];
    $p2q10=$data3['p2q10'];
    $p2q11=$data3['p2q11'];
    $p2q12=$data3['p2q12'];
    $p2q13=$data3['p2q13'];
    $p2q13b=$data3['p2q13b'];
    $p2q14=$data3['p2q14'];
    $p2q15=$data3['p2q15'];
    $p2q16=$data3['p2q16'];
    $p2q17=$data3['p2q17'];
    $p2q18=$data3['p2q18'];
    $p2q19=$data3['p2q19'];
    $p2q20=$data3['p2q20'];
    
    $p2q20a=$data3['p2q20a'];
    $p2q20b=$data3['p2q20b'];
    $p2q20c=$data3['p2q20c'];
    $p2q20d=$data3['p2q20d'];
    $p2q21=$data3['p2q21'];
    
    $p2q22=$data3['p2q22'];    
    $p2q22a=$data3['p2q22a'];
    $p2q22b=$data3['p2q22b'];
    $p2q22c=$data3['p2q22c'];
    $p2q22d=$data3['p2q22d'];
    $p2q22e=$data3['p2q22e'];
    $p2q22f=$data3['p2q22f'];
            
            
            ?>
            
            <div role="tabpanel" class="tab-pane" id="menu1">
                
                                             <div class="panel panel-primary">
      <div class="panel-heading">Client Summary Report</div>
      <div class="panel-body">
          
          <form class="form-horizontal" method="POST" action="php/SubmitClientSummaryReport.php?page=2">
<fieldset>
<input type='hidden' value='<?php echo $search;?>' name='search'>
<input type='text' value='<?php echo $origid;?>' name='origid'>
<!-- Form Name -->
<legend>Page 2 - Client Summary Report</legend>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q1">1. Why did you take out the policy in the first place and how was it set up?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q1" name="p2q1"><?php if (isset($p2q1)) { echo "$p2q1";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q2">2. Why are you paying into the scheme? If not then why not?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q2" name="p2q2"><?php if (isset($pp2q2)) { echo "$pp2q2";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q3">3. If hold more than 1 pension policy which do you perceive is the best and why?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q3" name="p2q3"><?php if (isset($p2q3)) { echo "$p2q3";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q4">4. Do you know if your pension scheme is actively monitored, if so how?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q4" name="p2q4"><?php if (isset($p2q4)) { echo "$p2q4";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q5">5. Do you receive any correspondence or statements?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q5" name="p2q5"><?php if (isset($p2q5)) { echo "$p2q5";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q6">6. When was the last time you have a full pension review? Were you happy with the results and service received?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q6" name="p2q6"><?php if (isset($p2q6)) { echo "$p2q6";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q7">7. Moving forward how often would you like your pension reviewed?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q7" name="p2q7"><?php if (isset($p2q7)) { echo "$p2q7";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q8">8. Do you know what risk category your fund is currently invested in?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q8" name="p2q8"><?php if (isset($p2q8)) { echo "$p2q8";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q9">9. What concerns do you have when it comes to choosing a pension or the placement of funds?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q9" name="p2q9"><?php if (isset($p2q9)) { echo "$p2q9";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q10">10. Do you know how much you have paid in over the years and what % return you are estimated to get?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q10" name="p2q10"><?php if (isset($p2q10)) { echo "$p2q10";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q11">11. How much income are you expecting to receive from your pension?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q11" name="p2q11"><?php if (isset($p2q11)) { echo "$p2q11";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q12">12. Are you satisfied with the current level of fund performance?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q12" name="p2q12"><?php if (isset($p2q12)) { echo "$p2q12";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q13">13. Would you like guarantee elements of your fund? Or would you prefer that it continues to track the stock market?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q13" name="p2q13"><?php if (isset($p2q13)) { echo "$p2q13";} ?></textarea>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q13b">13b. How much of your fund/s would you like to guarantee?</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q13b" name="p2q13b" class="form-control" placeholder="" type="text" <?php if (isset($p2q13b)) { echo "value='$p2q13b'";} ?>>
    </div>
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q14">14. Would you consider moving your pension fund into a current work scheme to keep separte for flexibility?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q14" name="p2q14"><?php if (isset($p2q14)) { echo "$p2q14";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q15">15. If you have more than 1 pension scheme - have you considered merging all plans into one?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q15" name="p2q15"><?php if (isset($p2q15)) { echo "$p2q15";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q16">16. Do you have any current management charges and how they are charged?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q16" name="p2q16"><?php if (isset($p2q16)) { echo "$p2q16";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q17">17. Do you know what happens to your pension fund in the event of death before and during retirement?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q17" name="p2q17"><?php if (isset($p2q17)) { echo "$p2q17";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q18">18. Do you have any nominated beneficiaries?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q18" name="p2q18"><?php if (isset($p2q18)) { echo "$p2q18";} ?></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q19">19. On a scale of 1 - 10 how satisfied are you with your current pension scheme and its arrangements (1 Low and 10 High)?</label>
  <div class="col-md-4">
    <select id="p2q19" name="p2q19" class="form-control">
      <?php if(isset($p2q19)) { echo "<option value='$p2q19'>$p2q19</option>"; }?>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
    </select>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q20">20. Are you inclined to meet your retirement goals of</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="p2q20-0">
      <input name="p2q20" id="p2q20-0" value="Achieve a sustainable retirement income/lifestyle" type="checkbox" <?php if (isset($p2q20)) { echo "checked";} ?>>
      Achieve a sustainable retirement income/lifestyle
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q20a"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="p2q20a-0">
      <input name="p2q20a" id="p2q20a-0" value="Provide sufficient death benefits to spouse and family" type="checkbox" <?php if (isset($p2q20a)) { echo "checked";} ?>>
      Provide sufficient death benefits to spouse and family
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q20b"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="p2q20b-0">
      <input name="p2q20b" id="p2q20b-0" value="Save for your children" type="checkbox" <?php if (isset($p2q20b)) { echo "checked";} ?>>
      Save for your children
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q20c"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="p2q20c-0">
      <input name="p2q20c" id="p2q20c-0" value="Invest in property" type="checkbox" <?php if (isset($p2q20c)) { echo "checked";} ?>>
      Invest in property
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q20d"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="p2q20d-0">
      <input name="p2q20d" id="p2q20d-0" value="Buy overseas property" type="checkbox" <?php if (isset($p2q20d)) { echo "checked";} ?>>
      Buy overseas property
    </label>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q21">21. Your thoughts on brand VS most suitable product?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p2q21" name="p2q21"><?php if (isset($p2q21)) { echo "$p2q21";} ?></textarea>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q22">22. Other feature preferences</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="p2q22-0">
      <input name="p2q22" id="p2q22-0" value="Flexi Access Drawdown" type="checkbox" <?php if (isset($p2q22)) { echo "checked";} ?>> 
      Flexi Access Drawdown
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q22a"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="p2q22a-0">
      <input name="p2q22a" id="p2q22a-0" value="Payment Holidays" type="checkbox" <?php if (isset($p2q22a)) { echo "checked";} ?>>
      Payment Holidays
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q22b"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="p2q22b-0">
      <input name="p2q22b" id="p2q22b-0" value="Life Style Options 20 cash depositing to lessen exposure" type="checkbox" <?php if (isset($p2q22b)) { echo "checked";} ?>>
      Life Style Options 20% cash depositing to lessen exposure
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q22c"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="p2q22c-0">
      <input name="p2q22c" id="p2q22c-0" value="No Transfer Penalties" type="checkbox" <?php if (isset($p2q22c)) { echo "checked";} ?>>
      No Transfer Penalties
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q22d"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="p2q22d-0">
      <input name="p2q22d" id="p2q22d-0" value="Portfolio Rebalancing" type="checkbox" <?php if (isset($p2q22d)) { echo "checked";} ?>>
      Portfolio Rebalancing
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q22e"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="p2q22e-0">
      <input name="p2q22e" id="p2q22e-0" value="Unlimited Fund Switching" type="checkbox" <?php if (isset($p2q22e)) { echo "checked";} ?>>
      Unlimited Fund Switching
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q22f"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="p2q22f-0">
      <input name="p2q22f" id="p2q22f-0" value="UFPLS" type="checkbox" <?php if (isset($p2q22f)) { echo "checked";} ?>>
      UFPLS
    </label>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
  </div>
</div>

</fieldset>
</form>

          
      </div>
                                </div>   
                
            </div>
            <?php
    $partnerquery = $pdo->prepare("SELECT clsr_page1_id, client_id, client_name, pp1q1, pp1q2, pp1q3, pp1q4, pp1q5, pp1q6, pp1q6a, pp1q7, pp1q8, pp1q9, pp1q10, pp1q11, pp1q12, pp1q13, pp1q14, pp1q15, pp1q16 FROM partner_summary_report_page1 WHERE client_id = :search AND client_name=:name");
    $partnerquery->bindParam(':search', $search, PDO::PARAM_STR, 12);
    $partnerquery->bindParam(':name', $Name2, PDO::PARAM_STR, 12);
    $partnerquery->execute();
    $data4=$partnerquery->fetch(PDO::FETCH_ASSOC);
    
    $origid2=$data4['clsr_page1_id'];
    $pp1q1=$data4['pp1q1'];
    $pp1q2=$data4['pp1q2'];
    $pp1q3=$data4['pp1q3'];
    $pp1q4=$data4['pp1q4'];
    $pp1q5=$data4['pp1q5'];
    $pp1q6=$data4['pp1q6'];
    $pp1q6a=$data4['pp1q6a'];
    $pp1q7=$data4['pp1q7'];
    $pp1q8=$data4['pp1q8'];
    $pp1q9=$data4['pp1q9'];
    $pp1q10=$data4['pp1q10'];
    $pp1q11=$data4['pp1q11'];
    $pp1q12=$data4['pp1q12'];
    $pp1q13=$data4['pp1q13'];
    $pp1q14=$data4['pp1q14'];
    $pp1q15=$data4['pp1q15'];
    $pp1q16=$data4['pp1q16'];
    $pp1q17=$data4['pp1q17'];
            
            ?>
            
                        <div role="tabpanel" class="tab-pane" id="menu2">
                
                                <div class="panel panel-primary">
      <div class="panel-heading">Partner Summary Report</div>
      <div class="panel-body">
          <form class="form-horizontal" method='POST' action='php/SubmitClientSummaryReport.php?page=3'>
<fieldset>
<input type='hidden' value='<?php echo $search;?>' name='search'>
<input type='hidden' value='<?php echo $origid;?>' name='origid'>
<!-- Form Name -->
<legend>Client Summary Report</legend>
<input type='hidden' value='<?php echo $search;?>' name='search'>
   <div class="form-group">
  <label class="col-md-4 control-label" for="client_name">Select Client Name</label>
  <div class="col-md-4">
    <select id="client_name" name="client_name" class="form-control">
      <option value="<?php echo $Name2 ?>"><?php echo $Name2 ?></option>
      <option value="<?php echo $Name1 ?>"><?php echo $Name1 ?></option>
    </select>
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q1">Projected Retirement Age</label>  
  <div class="col-md-4">
  <input id="pp1q1" name="pp1q1" placeholder="" class="form-control input-md" type="text" <?php if (isset($pp1q1)) { echo "value='$pp1q1'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q2">Product Name</label>  
  <div class="col-md-4">
  <input id="pp1q2" name="pp1q2" placeholder="" class="form-control input-md" type="text" <?php if (isset($pp1q2)) { echo "value='$pp1q2'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q3">Fund Valuation Date</label>  
  <div class="col-md-4">
  <input id="pp1q3" name="pp1q3" placeholder="" class="form-control input-md" type="text" <?php if (isset($pp1q3)) { echo "value='$pp1q3'";} ?>>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q4">Fund Value</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="pp1q4" name="pp1q4" class="form-control" placeholder="" type="text" <?php if (isset($pp1q4)) { echo "value='$pp1q4'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q5">Transfer Value</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="pp1q5" name="pp1q5" class="form-control" placeholder="" type="text" <?php if (isset($pp1q5)) { echo "value='$pp1q5'";} ?>>
    </div>
    
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q6">Regular Contributions</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="pp1q6-0">
      <input name="pp1q6" id="pp1q6-0" value="Yes" checked="checked" type="radio" <?php if(!isset($pp1q6)) { echo 'checked="checked"'; } elseif ($pp1q6=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="pp1q6-1">
      <input name="pp1q6" id="pp1q6-1" value="No" type="radio" <?php if(isset($pp1q6)) {if ($pp1q6=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q6a"></label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="pp1q6a" name="pp1q6a" class="form-control" placeholder="" type="text" <?php if (isset($pp1q6a)) { echo "value='$pp1q6a'";} ?>>
    </div>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q7">Management Charges</label>  
  <div class="col-md-4">
  <input id="pp1q7" name="pp1q7" placeholder="" class="form-control input-md" type="text" <?php if (isset($pp1q7)) { echo "value='$pp1q7'";} ?>>
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q8">Death Benefits</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp1q8" name="pp1q8"><?php if (isset($pp1q8)) { echo "$pp1q8";} ?></textarea>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q9">Projected Monthly Income</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="pp1q9" name="pp1q9" class="form-control" placeholder="" type="text" <?php if (isset($pp1q9)) { echo "value='$pp1q9'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q10">State Pension Income</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="pp1q10" name="pp1q10" class="form-control" placeholder="" type="text" <?php if (isset($pp1q10)) { echo "value='$pp1q10'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q11">Monthly Expenses</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="pp1q11" name="pp1q11" class="form-control" placeholder="" type="text" <?php if (isset($pp1q11)) { echo "value='$pp1q11'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q12">Overall</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="pp1q12" name="pp1q12" class="form-control" placeholder="" type="text" <?php if (isset($pp1q12)) { echo "value='$pp1q12'";} ?>>
    </div>
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q13">Client Views &amp; Comments</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp1q13" name="pp1q13"><?php if (isset($pp1q13)) { echo "$pp1q13";} ?></textarea>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q14">IFA Call</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="pp1q14-0">
      <input name="pp1q14" id="pp1q15-0" value="Yes" checked="checked" type="radio" <?php if(!isset($pp1q14)) { echo 'checked="checked"'; } elseif ($pp1q14=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="pp1q14-1">
      <input name="pp1q14" id="pp1q15-1" value="No" type="radio" <?php if(isset($pp1q14)) {if ($pp1q14=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q15">Appointment Date</label>  
  <div class="col-md-4">
  <input id="pp1q15" name="pp1q15" placeholder="YYYY-MM-DD" class="form-control input-md" type="text" <?php if (isset($pp1q15)) { echo "value='$pp1q15'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp1q16">Appointment Time</label>  
  <div class="col-md-4">
  <input id="pp1q16" name="pp1q16" placeholder="HH:MM:SS" class="form-control input-md" type="text" <?php if (isset($pp1q16)) { echo "value='$pp1q16'";} ?>>
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
  </div>
</div>

</fieldset>
</form>

          
      </div>
                                </div>
    
                
            </div>
            <?php 
                $page3 = $pdo->prepare("SELECT pp2q1, pp2q2, pp2q3, pp2q4, pp2q5, pp2q6, pp2q7, pp2q8, pp2q9, pp2q10, pp2q11, pp2q12, pp2q13, pp2q13b, pp2q14, pp2q15, pp2q16, pp2q17, pp2q18, pp2q19, pp2q20, pp2q20a, pp2q20b, pp2q20c, pp2q20d, pp2q21, pp2q22, pp2q22a, pp2q22b, pp2q22c, pp2q22d, pp2q22e, pp2q22f FROM partner_summary_report_page2 WHERE clsr_page1_id=:search");
    $page3->bindParam(':search', $origid2, PDO::PARAM_STR, 12);

    $page3->execute();
    $data4=$page3->fetch(PDO::FETCH_ASSOC);
    
    $pp2q1=$data4['pp2q1'];
    $pp2q2=$data4['pp2q2'];
    $pp2q3=$data4['pp2q3'];
    $pp2q4=$data4['pp2q4'];
    $pp2q5=$data4['pp2q5'];
    $pp2q6=$data4['pp2q6'];
    $pp2q7=$data4['pp2q7'];
    $pp2q8=$data4['pp2q8'];
    $pp2q9=$data4['pp2q9'];
    $pp2q10=$data4['pp2q10'];
    $pp2q11=$data4['pp2q11'];
    $pp2q12=$data4['pp2q12'];
    $pp2q13=$data4['pp2q13'];
    $pp2q13b=$data4['pp2q13b'];
    $pp2q14=$data4['pp2q14'];
    $pp2q15=$data4['pp2q15'];
    $pp2q16=$data4['pp2q16'];
    $pp2q17=$data4['pp2q17'];
    $pp2q18=$data4['pp2q18'];
    $pp2q19=$data4['pp2q19'];
    $pp2q20=$data4['pp2q20'];
    
    $pp2q20a=$data4['pp2q20a'];
    $pp2q20b=$data4['pp2q20b'];
    $pp2q20c=$data4['pp2q20c'];
    $pp2q20d=$data4['pp2q20d'];
    $pp2q21=$data4['pp2q21'];
    
    $pp2q22=$data4['pp2q22'];    
    $pp2q22a=$data4['pp2q22a'];
    $pp2q22b=$data4['pp2q22b'];
    $pp2q22c=$data4['pp2q22c'];
    $pp2q22d=$data4['pp2q22d'];
    $pp2q22e=$data4['pp2q22e'];
    $pp2q22f=$data4['pp2q22f'];
            
            
            ?>
            
                        <div role="tabpanel" class="tab-pane" id="menu3">
                
                                             <div class="panel panel-primary">
      <div class="panel-heading">Partner Summary Report</div>
      <div class="panel-body">
          
          <form class="form-horizontal" method="POST" action="php/SubmitClientSummaryReport.php?page=4">
<fieldset>
<input type='hidden' value='<?php echo $search;?>' name='search'>
<input type='hidden' value='<?php echo $origid;?>' name='origid'>
<!-- Form Name -->
<legend>Page 2 - Client Summary Report</legend>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q1">1. Why did you take out the policy in the first place and how was it set up?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q1" name="pp2q1"><?php if (isset($pp2q1)) { echo "$pp2q1";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q2">2. Why are you paying into the scheme? If not then why not?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q2" name="pp2q2"><?php if (isset($pp2q2)) { echo "$pp2q2";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q3">3. If hold more than 1 pension policy which do you perceive is the best and why?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q3" name="pp2q3"><?php if (isset($pp2q3)) { echo "$pp2q3";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q4">4. Do you know if your pension scheme is actively monitored, if so how?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q4" name="pp2q4"><?php if (isset($pp2q4)) { echo "$pp2q4";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q5">5. Do you receive any correspondence or statements?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q5" name="pp2q5"><?php if (isset($pp2q5)) { echo "$pp2q5";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q6">6. When was the last time you have a full pension review? Were you happy with the results and service received?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q6" name="pp2q6"><?php if (isset($pp2q6)) { echo "$pp2q6";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q7">7. Moving forward how often would you like your pension reviewed?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q7" name="pp2q7"><?php if (isset($pp2q7)) { echo "$pp2q7";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q8">8. Do you know what risk category your fund is currently invested in?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q8" name="pp2q8"><?php if (isset($pp2q8)) { echo "$pp2q8";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q9">9. What concerns do you have when it comes to choosing a pension or the placement of funds?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q9" name="pp2q9"><?php if (isset($pp2q9)) { echo "$pp2q9";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q10">10. Do you know how much you have paid in over the years and what % return you are estimated to get?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q10" name="pp2q10"><?php if (isset($pp2q10)) { echo "$pp2q10";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q11">11. How much income are you expecting to receive from your pension?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q11" name="pp2q11"><?php if (isset($pp2q11)) { echo "$pp2q11";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q12">12. Are you satisfied with the current level of fund performance?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q12" name="pp2q12"><?php if (isset($pp2q12)) { echo "$pp2q12";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q13">13. Would you like guarantee elements of your fund? Or would you prefer that it continues to track the stock market?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q13" name="pp2q13"><?php if (isset($pp2q13)) { echo "$pp2q13";} ?></textarea>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q13b">13b. How much of your fund/s would you like to guarantee?</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="pp2q13b" name="pp2q13b" class="form-control" placeholder="" type="text" <?php if (isset($pp2q13b)) { echo "value='$pp2q13b'";} ?>>
    </div>
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q14">14. Would you consider moving your pension fund into a current work scheme to keep separte for flexibility?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q14" name="pp2q14"><?php if (isset($pp2q14)) { echo "$pp2q14";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q15">15. If you have more than 1 pension scheme - have you considered merging all plans into one?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q15" name="pp2q15"><?php if (isset($pp2q15)) { echo "$pp2q15";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q16">16. Do you have any current management charges and how they are charged?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q16" name="pp2q16"><?php if (isset($pp2q16)) { echo "$pp2q16";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q17">17. Do you know what happens to your pension fund in the event of death before and during retirement?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q17" name="pp2q17"><?php if (isset($pp2q17)) { echo "$pp2q17";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q18">18. Do you have any nominated beneficiaries?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q18" name="pp2q18"><?php if (isset($pp2q18)) { echo "$pp2q18";} ?></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q19">19. On a scale of 1 - 10 how satisfied are you with your current pension scheme and its arrangements (1 Low and 10 High)?</label>
  <div class="col-md-4">
    <select id="pp2q19" name="pp2q19" class="form-control">
      <?php if(isset($pp2q19)) { echo "<option value='$pp2q19'>$pp2q19</option>"; }?>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
    </select>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q20">20. Are you inclined to meet your retirement goals of</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="pp2q20-0">
      <input name="pp2q20" id="pp2q20-0" value="Achieve a sustainable retirement income/lifestyle" type="checkbox" <?php if (isset($pp2q20)) { echo "checked";} ?>>
      Achieve a sustainable retirement income/lifestyle
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q20a"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="pp2q20a-0">
      <input name="pp2q20a" id="pp2q20a-0" value="Provide sufficient death benefits to spouse and family" type="checkbox" <?php if (isset($pp2q20a)) { echo "checked";} ?>>
      Provide sufficient death benefits to spouse and family
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q20b"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="pp2q20b-0">
      <input name="pp2q20b" id="pp2q20b-0" value="Save for your children" type="checkbox" <?php if (isset($pp2q20b)) { echo "checked";} ?>>
      Save for your children
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q20c"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="pp2q20c-0">
      <input name="pp2q20c" id="pp2q20c-0" value="Invest in property" type="checkbox" <?php if (isset($pp2q20c)) { echo "checked";} ?>>
      Invest in property
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q20d"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="pp2q20d-0">
      <input name="pp2q20d" id="pp2q20d-0" value="Buy overseas property" type="checkbox" <?php if (isset($pp2q20d)) { echo "checked";} ?>>
      Buy overseas property
    </label>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q21">21. Your thoughts on brand VS most suitable product?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="pp2q21" name="pp2q21"><?php if (isset($pp2q21)) { echo "$pp2q21";} ?></textarea>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q22">22. Other feature preferences</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="pp2q22-0">
      <input name="pp2q22" id="pp2q22-0" value="Flexi Access Drawdown" type="checkbox" <?php if (isset($pp2q22)) { echo "checked";} ?>> 
      Flexi Access Drawdown
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q22a"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="pp2q22a-0">
      <input name="pp2q22a" id="pp2q22a-0" value="Payment Holidays" type="checkbox" <?php if (isset($pp2q22a)) { echo "checked";} ?>>
      Payment Holidays
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q22b"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="pp2q22b-0">
      <input name="pp2q22b" id="pp2q22b-0" value="Life Style Options 20 cash depositing to lessen exposure" type="checkbox" <?php if (isset($pp2q22b)) { echo "checked";} ?>>
      Life Style Options 20% cash depositing to lessen exposure
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q22c"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="pp2q22c-0">
      <input name="pp2q22c" id="pp2q22c-0" value="No Transfer Penalties" type="checkbox" <?php if (isset($pp2q22c)) { echo "checked";} ?>>
      No Transfer Penalties
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q22d"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="pp2q22d-0">
      <input name="pp2q22d" id="pp2q22d-0" value="Portfolio Rebalancing" type="checkbox" <?php if (isset($pp2q22d)) { echo "checked";} ?>>
      Portfolio Rebalancing
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q22e"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="pp2q22e-0">
      <input name="pp2q22e" id="pp2q22e-0" value="Unlimited Fund Switching" type="checkbox" <?php if (isset($pp2q22e)) { echo "checked";} ?>>
      Unlimited Fund Switching
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="pp2q22f"></label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="pp2q22f-0">
      <input name="pp2q22f" id="pp2q22f-0" value="UFPLS" type="checkbox" <?php if (isset($pp2q22f)) { echo "checked";} ?>>
      UFPLS
    </label>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
  </div>
</div>

</fieldset>
</form>

          
      </div>
                                </div>   
                
            </div>
            
        </div>
        </div>
            <!-- Modal -->
<div id="completestepcheck" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Stage Complete?</h4>
      </div>
      <div class="modal-body">
<?php 


            
            ?>
             <form class="form-horizontal" method='POST' action='php/StageComplete.php?stage=5'>
<fieldset>

<!-- Form Name -->
<legend>Stage 5</legend>       
          
<input type='hidden' name='search' value='<?php echo $search;?>'>
          
<div class="form-group">
  <label class="col-md-4 control-label" for="summarysheet">Stage 5 Complete?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="summarysheet-0">
      <input name="summarysheet" id="summarysheet-0" value="0" checked="checked" type="radio">
      No
    </label> 
    <label class="radio-inline" for="summarysheet-1">
      <input name="summarysheet" id="summarysheet-1" value="1" type="radio">
      Yes
    </label>
  </div>
</div>
          
          <div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
  </div>
</div>

</fieldset>
</form>
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    </body>
</html>
