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

    
    
    $query = $pdo->prepare("SELECT factfind_id, client_id, client_name, p1q1, p1q2, p1q3, p1q4, p1q5, p1q6, p1q7, p1q8, p1q9, p1q10, p1q11, p1q12, p1q13, p1q14, p1q15, p1q16, p1q17 FROM factfind_page1 WHERE client_id = :search AND client_name=:name");
    $query->bindParam(':search', $search, PDO::PARAM_STR, 12);
    $query->bindParam(':name', $Name1, PDO::PARAM_STR, 12);
    $query->execute();
    $data2=$query->fetch(PDO::FETCH_ASSOC);
    
    $factfindorg=$data2['factfind_id'];
    $p1q1=$data2['p1q1'];
    $p1q2=$data2['p1q2'];
    $p1q3=$data2['p1q3'];
    $p1q4=$data2['p1q4'];
    $p1q5=$data2['p1q5'];
    $p1q6=$data2['p1q6'];
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
        
        $FactFind= filter_input(INPUT_GET, 'FactFind', FILTER_SANITIZE_SPECIAL_CHARS);
            
             if(isset($FactFind)){
    
      $FactFind= filter_input(INPUT_GET, 'FactFind', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($FactFind =='updated') {

print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-check\"></i> Success:</strong> Fact Find Updated!</div>");
    }
    
        if ($FactFind =='y') {

print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-check\"></i> Success:</strong> Fact Find Added!</div>");
    }
       
            if ($FactFind =='fail') {

print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes were made!</div>");
    }
    
            }
        
        ?>
        
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">Confidential Fact Find</a></li>
            <li><a data-toggle="pill" href="#menu1">Income, Expenditure Financial Dependents</a></li>
            <li><a data-toggle="pill" href="#menu2">Mortgage, Insurance, Saving & Pension Information</a></li>
            <li><a data-toggle="pill" href="#menu3">Pension Policies & Retirement Goals</a></li>
            <li><a data-toggle="pill" href="#menu4">More Pension Policies</a></li>
            <li><a data-toggle='modal' data-target='#uploadmodal'>Risk Profile</a></li>
            <li><a href="ViewClient.php?search=<?php echo "$search";?>"><i class='fa fa-user'></i> Back to Client</a></li>
        </ul>      
        
        <br>
        
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
        
                <div class="panel panel-primary">
      <div class="panel-heading">Fact Find - Confidential</div>
      <div class="panel-body">
        
          <form class="form-horizontal" method="POST" action="php/AddFactFindSubmit.php?factfind=y">
        <fieldset>
            <legend>Confidential</legend>
            <input type="hidden" value="<?php echo $search ?>" name="search">
            <input type="hidden" value="<?php echo $search ?>" name="client_id">
  
            <div class="form-group">
  <label class="col-md-4 control-label" for="client_name">Select Basic</label>
  <div class="col-md-4">
    <select id="client_name" name="client_name" class="form-control">
      <option value="<?php echo $Name1 ?>"><?php echo $Name1 ?></option>
      <option value="<?php echo $Name2 ?>"><?php echo $Name2 ?></option>
    </select>
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="p1q1">Marital Status</label>
  <div class="col-md-4">
    <select id="p1q1" name="p1q1" class="form-control">
                        <?php if(isset($p1q1)){ ?>
        <option value="<?php echo $p1q1;?>"><?php echo $p1q1;?></option>
            
        <?php } ?>
      <option value="Single">Single</option>
      <option value="Married">Married</option>
      <option value="Partnered">Partnered</option>
      <option value="Divorced">Divorced</option>
      <option value="Widowed">Widowed</option>
      <option value="Civil Partner">Civil Partner</option>

    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q2">Residential Status</label>
  <div class="col-md-4">
    <select id="p1q2" name="p1q2" class="form-control">
                        <?php if(isset($p1q2)){ ?>
        <option value="<?php echo $p1q2;?>"><?php echo $p1q2;?></option>
            
        <?php } ?>
      <option value="Owned">Owned</option>
      <option value="Mortgaged">Mortgaged</option>
      <option value="Rented">Rented</option>
      <option value="Living with parents">Living with parents</option>
      <option value="Cohabiting">Cohabiting</option>
      <option value="Other">Other</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q3">Length of Residency (yrs)</label>  
  <div class="col-md-4">
  <input id="p1q3" name="p1q3" placeholder="" class="form-control input-md" type="text" <?php if (isset($p1q3)) { echo "value='$p1q3'";} ?>>
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q4">Best Contact Time</label>  
  <div class="col-md-4">
  <input id="p1q4" name="p1q4" placeholder="HH:MM:SS" class="form-control input-md" type="text" <?php if (isset($p1q4)) { echo "value='$p1q4'";} ?>>
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q5">Nationality &amp; Domicile</label>  
  <div class="col-md-4">
  <input id="p1q5" name="p1q5" placeholder="" class="form-control input-md" type="text" <?php if (isset($p1q5)) { echo "value='$p1q5'";} ?>>
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q6">Health Description</label>
  <div class="col-md-4">
    <select id="p1q6" name="p1q6" class="form-control">
                        <?php if(isset($p1q6)){ ?>
        <option value="<?php echo $p1q6;?>"><?php echo $p1q6;?></option>
            
        <?php } ?>
      <option value="Good">Good</option>
      <option value="Average">Average</option>
      <option value="Poor">Poor</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q7">Any Disabilities or Conditions?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p1q7-0">
      <input name="p1q7" id="p1q7-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p1q7)) { echo 'checked="checked"'; } elseif ($p1q7=='Yes'){ echo 'checked="checked"';}?> >
      Yes
    </label> 
    <label class="radio-inline" for="p1q7-1">
      <input name="p1q7" id="p1q7-1" value="No" type="radio" <?php if(isset($p1q7)) {if ($p1q7=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q8"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p1q8" name="p1q8"><?php if (isset($p1q8)) { echo "$p1q8";} ?></textarea>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q9">Smoker?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p1q9-0">
      <input name="p1q9" id="p1q9-0" value="Yes" type="radio" <?php if(!isset($p1q9)) { echo 'checked="checked"'; } elseif ($p1q9=='Yes'){ echo 'checked="checked"';}?> >
      Yes
    </label> 
    <label class="radio-inline" for="p1q9-1">
      <input name="p1q9" id="p1q9-1" value="No" type="radio" <?php if(isset($p1q9)) {if ($p1q9=='No'){ echo 'checked="checked"';}}?> >
      No
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q10"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p1q10" name="p1q10"><?php if (isset($p1q10)) { echo "$p1q10";} ?></textarea>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q11">Employment Status</label>
  <div class="col-md-4">
    <select id="p1q11" name="p1q11" class="form-control">
                        <?php if(isset($p1q11)){ ?>
        <option value="<?php echo $p1q11;?>"><?php echo $p1q11;?></option>
            
        <?php } ?>
      <option value="Employed">Employed</option>
      <option value="Self Employed">Self Employed</option>
      <option value="Part Time">Part Time</option>
      <option value="Retired">Retired</option>
      <option value="Semi Retired">Semi Retired</option>
      <option value="Voluntary">Voluntary</option>
      <option value="Other">Other</option>

    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q12">Taxpayer Status</label>
  <div class="col-md-4">
    <select id="p1q12" name="p1q12" class="form-control">
                <?php if(isset($p1q12)){ ?>
        <option value="<?php echo $p1q12;?>"><?php echo $p1q12;?></option>
            
        <?php } ?>
      <option value="Basic Rate">Basic Rate</option>
      <option value="Higher Rate">Higher Rate</option>
      <option value="Non Payer">Non Payer</option>
      <option value="Additional Rate">Additional Rate</option>
      <option value="Non UK Payer">Non UK Payer</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q13">Occupational Description</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p1q13" name="p1q13"><?php if (isset($p1q13)) { echo "$p1q13";} ?></textarea>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q14">Time in Employment</label>  
  <div class="col-md-4">
  <input id="p1q14" name="p1q14" placeholder="12yrs 3mths" class="form-control input-md" type="text" <?php if (isset($p1q14)) { echo "value='$p1q14'";} ?>>
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q15">Monthly Gross Income</label>  
  <div class="col-md-4">
  <input id="p1q15" name="p1q15" placeholder="" class="form-control input-md" type="text" <?php if (isset($p1q15)) { echo "value='$p1q15'";} ?>>
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q16">Monthly Net Income</label>  
  <div class="col-md-4">
  <input id="p1q16" name="p1q16" placeholder="" class="form-control input-md" type="text" <?php if (isset($p1q16)) { echo "value='$p1q16'";} ?>>
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="p1q17">Monthly Expenditure</label>  
  <div class="col-md-4">
  <input id="p1q17" name="p1q17" placeholder="" class="form-control input-md" type="text" <?php if (isset($p1q17)) { echo "value='$p1q17'";} ?>>
    
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
            
    $page2 = $pdo->prepare("SELECT p2q1, p2q2, p2q3, p2q4, p2q5, p2q6, p2q7, p2q8, p2q9, p2q10, p2q11, p2q12, p2q13, p2q14, p2q15, p2q16, p2q17, p2q18, p2q19, p2q20, p2q21, p2q22, p2q23, p2q24, p2q25, p2q26, p2q27, p2q28, p2q29 FROM factfind_page2 WHERE factfind_id=:factfindor");
    $page2->bindParam(':factfindor', $factfindorg, PDO::PARAM_STR, 12);
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
    $p2q14=$data3['p2q14'];
    $p2q15=$data3['p2q15'];
    $p2q16=$data3['p2q16'];
    $p2q17=$data3['p2q17'];
    $p2q18=$data3['p2q18'];
    $p2q19=$data3['p2q19'];
    $p2q20=$data3['p2q20'];
    $p2q21=$data3['p2q21'];
    $p2q22=$data3['p2q22'];
    $p2q23=$data3['p2q23'];
    $p2q24=$data3['p2q24'];
    $p2q25=$data3['p2q25'];
    $p2q26=$data3['p2q26'];
    $p2q27=$data3['p2q27'];
    $p2q28=$data3['p2q28'];
    $p2q29=$data3['p2q29'];
            
    
    
            
            ?>
            
            <div role="tabpanel" class="tab-pane" id="menu1">
                                <div class="panel panel-primary">
      <div class="panel-heading">Fact Find - Income, Expenditure, Financial Dependents</div>
      <div class="panel-body">
          <form class="form-horizontal" method="POST" action="php/AddFactFindSubmit.php?page2=y">
                    <fieldset>
                        <input type="hidden" value="<?php echo $search ?>" name="search">
                        <input type="hidden" value="<?php echo $factfindorg?>" name="factfindid">
<!-- Form Name -->
<legend>Income & Expenditure</legend>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q1">Mortgage Repayment</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q1" name="p2q1" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q1)) { echo "value='$p2q1'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q2">Life Insurance</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q2" name="p2q2" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q2)) { echo "value='$p2q2'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q3">Pension Contribution</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q3" name="p2q3" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q3)) { echo "value='$p2q3'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q4">Savings</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q4" name="p2q4" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q4)) { echo "value='$p2q4'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q5">Buidling &amp; Contents</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q5" name="p2q5" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q5)) { echo "value='$p2q5'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q6">Motor Insurance</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q6" name="p2q6" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q6)) { echo "value='$p2q6'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q7">Utility Bills</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q7" name="p2q7" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q7)) { echo "value='$p2q7'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q8">Council Tax</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q8" name="p2q8" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q8)) { echo "value='$p2q8'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q9">Child Benefits</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q9" name="p2q9" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q9)) { echo "value='$p2q9'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q10">Telephone and Internet</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q10" name="p2q10" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q10)) { echo "value='$p2q10'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q11">Food Budget</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q11" name="p2q11" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q11)) { echo "value='$p2q11'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q12">Clothing</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q12" name="p2q12" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q12)) { echo "value='$p2q12'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q13">Pets</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q13" name="p2q13" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q13)) { echo "value='$p2q13'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q14">Other Household</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q14" name="p2q14" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q14)) { echo "value='$p2q14'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q15">Social Expensives</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q15" name="p2q15" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q15)) { echo "value='$p2q15'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q16">Other Expensives</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q16" name="p2q16" class="form-control" placeholder="Monthly" type="text" <?php if (isset($p2q16)) { echo "value='$p2q16'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q17">Total</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p2q17" name="p2q17" class="form-control" placeholder="" type="text" <?php if (isset($p2q17)) { echo "value='$p2q17'";} ?>>
    </div>
    
  </div>
</div>

<legend>Financial Dependents</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q18">Name 1</label>  
  <div class="col-md-4">
  <input id="p2q18" name="p2q18" placeholder="" class="form-control input-md" type="text" <?php if (isset($p2q18)) { echo "value='$p2q18'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q19">Realationship</label>  
  <div class="col-md-4">
  <input id="p2q19" name="p2q19" placeholder="" class="form-control input-md" type="text" <?php if (isset($p2q19)) { echo "value='$p2q19'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q20">DOB</label>  
  <div class="col-md-4">
  <input id="p2q20" name="p2q20" placeholder="" class="form-control input-md" type="text" <?php if (isset($p2q20)) { echo "value='$p2q20'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q21">Dependent Till</label>  
  <div class="col-md-4">
  <input id="p2q21" name="p2q21" placeholder="" class="form-control input-md" type="text" <?php if (isset($p2q21)) { echo "value='$p2q21'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q22">Name 2</label>  
  <div class="col-md-4">
  <input id="p2q22" name="p2q22" placeholder="" class="form-control input-md" type="text" <?php if (isset($p2q22)) { echo "value='$p2q22'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q23">Realationship</label>  
  <div class="col-md-4">
  <input id="p2q23" name="p2q23" placeholder="" class="form-control input-md" type="text" <?php if (isset($p2q23)) { echo "value='$p2q23'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q24">DOB</label>  
  <div class="col-md-4">
  <input id="p2q24" name="p2q24" placeholder="" class="form-control input-md" type="text" <?php if (isset($p2q24)) { echo "value='$p2q24'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q25">Dependent Till</label>  
  <div class="col-md-4">
  <input id="p2q25" name="p2q25" placeholder="" class="form-control input-md" type="text" <?php if (isset($p2q25)) { echo "value='$p2q25'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q26">Name 3</label>  
  <div class="col-md-4">
  <input id="p2q26" name="p2q26" placeholder="" class="form-control input-md" type="text" <?php if (isset($p2q26)) { echo "value='$p2q26'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q27">Realationship</label>  
  <div class="col-md-4">
  <input id="p2q27" name="p2q27" placeholder="" class="form-control input-md" type="text" <?php if (isset($p2q27)) { echo "value='$p2q27'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q28">DOB</label>  
  <div class="col-md-4">
  <input id="p2q28" name="p2q28" placeholder="" class="form-control input-md" type="text" <?php if (isset($p2q28)) { echo "value='$p2q28'";} ?>>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p2q29">Dependent Till</label>  
  <div class="col-md-4">
  <input id="p2q29" name="p2q29" placeholder="" class="form-control input-md" type="text" <?php if (isset($p2q29)) { echo "value='$p2q29'";} ?>>
    
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
  </div>
</div>
</fieldset>
</form>
</fieldset>
</form>
      </div>
                                </div>
                

            </div>
            
                        <?php
            
    $page3 = $pdo->prepare("SELECT p3q1, p3q2, p3q3, p3q4, p3q5, p3q6, p3q7, p3q8, p3q9, p3q10, p3q11, p3q12, p3q13, p3q14, p3q15, p3q16, p3q17, p3q18, p3q19, p3q20, p3q21, p3q22, p3q23, p3q24, p3q25, p3q26, p3q27 FROM factfind_page3 WHERE factfind_id=:factfindor");
    $page3->bindParam(':factfindor', $factfindorg, PDO::PARAM_STR, 12);
    $page3->execute();
    $data4=$page3->fetch(PDO::FETCH_ASSOC);
    
    $p3q1=$data4['p3q1'];
    $p3q2=$data4['p3q2'];
    $p3q3=$data4['p3q3'];
    $p3q4=$data4['p3q4'];
    $p3q5=$data4['p3q5'];
    $p3q6=$data4['p3q6'];
    $p3q7=$data4['p3q7'];
    $p3q8=$data4['p3q8'];
    $p3q9=$data4['p3q9'];
    $p3q10=$data4['p3q10'];
    $p3q11=$data4['p3q11'];
    $p3q12=$data4['p3q12'];
    $p3q13=$data4['p3q13'];
    $p3q14=$data4['p3q14'];
    $p3q15=$data4['p3q15'];
    $p3q16=$data4['p3q16'];
    $p3q17=$data4['p3q17'];
    $p3q18=$data4['p3q18'];
    $p3q19=$data4['p3q19'];
    $p3q20=$data4['p3q20'];
    $p3q21=$data4['p3q21'];
    $p3q22=$data4['p3q22'];
    $p3q23=$data4['p3q23'];
    $p3q24=$data4['p3q24'];
    $p3q25=$data4['p3q25'];
    $p3q26=$data4['p3q26'];
    $p3q27=$data4['p3q27'];

            ?>
            
            
                        <div role="tabpanel" class="tab-pane" id="menu2">
                                <div class="panel panel-primary">
      <div class="panel-heading">Fact Find - Mortgage, Insurance, Saving & Pension Information</div>
      <div class="panel-body">
          
          <form class="form-horizontal" method="POST" action="php/AddFactFindSubmit.php?page3=y">
<fieldset>
<input type="hidden" value="<?php echo $factfindorg ?>" name="factfindid">
<input type="hidden" value="<?php echo $search ?>" name="search">
<!-- Form Name -->
<legend>Home Mortgage</legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q1">Home Mortgage</label>
  <div class="col-md-4">
    <select id="selectbasic" name="p3q1" class="form-control">
                        <?php if(isset($p3q1)){ ?>
        <option value="<?php echo $p3q1;?>"><?php echo $p3q1;?></option>
            
        <?php } ?>
      <option value="Capital Repayment">Capital Repayment</option>
      <option value="Interest Only">Interest Only</option>
      <option value="Buy to Let">Buy to Let</option>
      <option value="Equity Release">Equity Release</option>
      <option value="Shared Equity/Partnership">Shared Equity/Partnership</option>
      <option value="Other">Other</option>
    </select>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q2">If Other</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p3q2" name="p3q2"><?php if (isset($p3q2)) { echo "$p3q2";} ?></textarea>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q3">Remaining term if known (yrs)</label>  
  <div class="col-md-4">
  <input id="p3q3" name="p3q3" placeholder="" class="form-control input-md" type="text"<?php if (isset($p3q3)) { echo "value='$p3q3'";} ?>>
    
  </div>
</div>

<legend>Buidlings &amp; Contents Insurance</legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q4">Which property</label>
  <div class="col-md-4">
    <select id="p3q4" name="p3q4" class="form-control">
                                <?php if(isset($p3q4)){ ?>
        <option value="<?php echo $p3q4;?>"><?php echo $p3q4;?></option>
            
        <?php } ?>
      <option value="Home">Home</option>
      <option value="Rental Property">Rental Property</option>
      <option value="Business Premises">Business Premises</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q5">Type of Cover</label>
  <div class="col-md-4">
    <select id="p3q5" name="p3q5" class="form-control">
                                <?php if(isset($p3q5)){ ?>
        <option value="<?php echo $p3q5;?>"><?php echo $p3q5;?></option>
            
        <?php } ?>
      <option value="Building Only">Building Only</option>
      <option value="Buildings and Contents">Buildings & Contents</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q6">Payment Frequency</label>
  <div class="col-md-4">
    <select id="p3q6" name="p3q6" class="form-control">
                                <?php if(isset($p3q6)){ ?>
        <option value="<?php echo $p3q6;?>"><?php echo $p3q6;?></option>
            
        <?php } ?>
      <option value="Monthly">Monthly</option>
      <option value="Annually">Annually</option>
    </select>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q7">Premium</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p3q7" name="p3q7" class="form-control" placeholder="" type="text" <?php if (isset($p3q7)) { echo "value='$p3q7'";} ?>>
    </div>
    
  </div>
</div>
       
                            

<legend>Life Assurance</legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q8">Life Insurance</label>
  <div class="col-md-4">
    <select id="p3q8" name="p3q8" class="form-control">
                                <?php if(isset($p3q8)){ ?>
        <option value="<?php echo $p3q8;?>"><?php echo $p3q8;?></option>
            
        <?php } ?>
      <option value="Just Me">Just Me</option>
      <option value="Joint/Spouse">Joint/Spouse</option>
      <option value="Family">Family</option>
    </select>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q9">If Family, no of lives</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p3q9" name="p3q9"><?php if (isset($p3q9)) { echo "$p3q9";} ?></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q10">Policy Type</label>
  <div class="col-md-4">
    <select id="p3q10" name="p3q10" class="form-control">
                                <?php if(isset($p3q10)){ ?>
        <option value="<?php echo $p3q10;?>"><?php echo $p3q10;?></option>
            
        <?php } ?>
      <option value="Mortgage Cover">Mortgage Cover</option>
      <option value="Family Cover">Family Cover</option>
      <option value="Both">Both</option>
    </select>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q11">Premium</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p3q11" name="p3q11" class="form-control" placeholder="" type="text" <?php if (isset($p3q11)) { echo "value='$p3q11'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q12">Amount of Cover</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p3q12" name="p3q12" class="form-control" placeholder="" type="text" <?php if (isset($p3q12)) { echo "value='$p3q12'";} ?>>
    </div>
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q13">Other Known Benefits</label>
  <div class="col-md-4">
    <select id="p3q13" name="p3q13" class="form-control">
                                <?php if(isset($p3q13)){ ?>
        <option value="<?php echo $p3q13;?>"><?php echo $p3q13;?></option>
            
        <?php } ?>
      <option value="Critical Illness">Critical Illness</option>
      <option value="Income Protection">Income Protection</option>
      <option value="ASU">ASU</option>
    </select>
  </div>
</div>
                 


<!-- Form Name -->
<legend>ISA Account &amp; Personal Savings</legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q14">Holder</label>
  <div class="col-md-4">
    <select id="p3q14" name="p3q14" class="form-control">
                                <?php if(isset($p3q14)){ ?>
        <option value="<?php echo $p3q14;?>"><?php echo $p3q14;?></option>
            
        <?php } ?>
      <option value="Just Me">Just Me</option>
      <option value="Joint/Spouse">Joint/Spouse</option>
      <option value="Child Fund">Child Fund</option>
    </select>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q15">Current Pot Amount</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p3q15" name="p3q15" class="form-control" placeholder="" type="text" <?php if (isset($p3q15)) { echo "value='$p3q15'";} ?>>
    </div>
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q16">How Often Do You Contribute</label>
  <div class="col-md-4">
    <select id="p3q16" name="p3q16" class="form-control">
                                <?php if(isset($p3q16)){ ?>
        <option value="<?php echo $p3q16;?>"><?php echo $p3q16;?></option>
            
        <?php } ?>
      <option value="Weekly">Weekly</option>
      <option value="Monthly">Monthly</option>
      <option value="Quarterly">Quarterly</option>
      <option value="Annually">Annually</option>
      <option value="When You Can">When You Can</option>
    </select>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q17">How Much</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p3q17" name="p3q17" class="form-control" placeholder="" type="text" <?php if (isset($p3q17)) { echo "value='$p3q17'";} ?>> 
    </div>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q18">How Long Have You Saved Into This Account?</label>  
  <div class="col-md-4">
  <input id="p3q18" name="p3q18" placeholder="" class="form-control input-md" type="text" <?php if (isset($p3q18)) { echo "value='$p3q18'";} ?>>
    
  </div>
</div>

                            

<!-- Form Name -->
<legend>About You &amp; Your Pension</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q19">Intended Retirement Age</label>  
  <div class="col-md-4">
  <input id="p3q19" name="p3q19" placeholder="" class="form-control input-md" type="text" <?php if (isset($p3q19)) { echo "value='$p3q19'";} ?>>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q20">Monthly Income Required</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p3q20" name="p3q20" class="form-control" placeholder="" type="text" <?php if (isset($p3q20)) { echo "value='$p3q20'";} ?>>
    </div>
    
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q21">Do You Want a Lump Sum?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p3q21-0">
      <input name="p3q21" id="radios-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p3q21)) { echo 'checked="checked"'; } elseif ($p3q21=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p3q21-1">
      <input name="p3q21" id="radios-1" value="No" type="radio" <?php if(isset($p3q21)) {if ($p3q21=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q22">If Yes, How Much</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p3q22" name="p3q22" class="form-control" placeholder="" type="text" <?php if (isset($p3q22)) { echo "value='$p3q22'";} ?>>
    </div>
    
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q23">Would you like us to report on yur current death benefits</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p3q23-0">
      <input name="p3q23" id="p3q23-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p3q23)) { echo 'checked="checked"'; } elseif ($p3q23=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p3q23-1">
      <input name="p3q23" id="p3q23-1" value="No" type="radio" <?php if(isset($p3q23)) {if ($p3q23=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q24">Would you like us to report on your management charges</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p3q24-0">
      <input name="p3q24" id="p3q24-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p3q24)) { echo 'checked="checked"'; } elseif ($p3q24=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p3q24-1">
      <input name="p3q24" id="p3q24-1" value="No" type="radio" <?php if(isset($p3q24)) {if ($p3q24=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q25">Does your employer operate an Occupational Pension Scheme</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p3q25-0">
      <input name="p3q25" id="p3q25-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p3q25)) { echo 'checked="checked"'; } elseif ($p3q25=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p3q25-1">
      <input name="p3q25" id="p3q25-1" value="No" type="radio"<?php if(isset($p3q25)) {if ($p3q25=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q26">Are you now or you will become eligible</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p3q26-0">
      <input name="p3q26" id="p3q26-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p3q26)) { echo 'checked="checked"'; } elseif ($p3q26=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="radios-1">
      <input name="p3q26" id="p3q26-1" value="No" type="radio" <?php if(isset($p3q26)) {if ($p3q26=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p3q27">Do you intend to join</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p3q27-0">
      <input name="p3q27" id="p3q27-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p3q27)) { echo 'checked="checked"'; } elseif ($p3q27=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p3q27-1">
      <input name="p3q27" id="p3q27-1" value="No" type="radio" <?php if(isset($p3q27)) {if ($p3q27=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>
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
            
            
    $page4 = $pdo->prepare("SELECT p4q1, p4q2, p4q3, p4q4, p4q5, p4q6, p4q7, p4q8, p4q9, p4q10, p4q11, p4q12, p4q13, p4q14, p4q15, p4q16, p4q17, p4q18 FROM factfind_page4 WHERE factfind_id=:factfindor");

    $page4->bindParam(':factfindor', $factfindorg, PDO::PARAM_STR, 12);
    $page4->execute();
    $data5=$page4->fetch(PDO::FETCH_ASSOC);
    
    $p4q1=$data5['p4q1'];
    $p4q2=$data5['p4q2'];
    $p4q3=$data5['p4q3'];
    $p4q4=$data5['p4q4'];
    $p4q5=$data5['p4q5'];
    $p4q6=$data5['p4q6'];
    $p4q7=$data5['p4q7'];
    $p4q8=$data5['p4q8'];
    $p4q9=$data5['p4q9'];
    $p4q10=$data5['p4q10'];
    $p4q11=$data5['p4q11'];
    $p4q12=$data5['p4q12'];
    $p4q13=$data5['p4q13'];
    $p4q14=$data5['p4q14'];
    $p4q15=$data5['p4q15'];
    $p4q16=$data5['p4q16'];
    $p4q17=$data5['p4q17'];
    $p4q18=$data5['p4q18'];

            ?>
            
            
                                    <div role="tabpanel" class="tab-pane" id="menu3">
                                <div class="panel panel-primary">
      <div class="panel-heading">Fact Find - Pension Policies & Retirement Goals</div>
      <div class="panel-body">
          
          <form class="form-horizontal" method="POST" action="php/AddFactFindSubmit.php?page4=y">
             <input type="hidden" value="<?php echo $factfindorg ?>" name="factfindid">
<input type="hidden" value="<?php echo $search ?>" name="search">
<fieldset>

<!-- Form Name -->
<legend>Pension Policy (1)</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q1">Provider Name</label>  
  <div class="col-md-4">
  <input id="p4q1" name="p4q1" placeholder="" class="form-control input-md" type="text" <?php if (isset($p4q1)) { echo "value='$p4q1'";} ?>>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q2">Policy</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">#</span>
      <input id="p4q2" name="p4q2" class="form-control" placeholder="" type="text" <?php if (isset($p4q2)) { echo "value='$p4q2'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q3">Pot Value (approx)</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p4q3" name="p4q3" class="form-control" placeholder="" type="text" <?php if (isset($p4q3)) { echo "value='$p4q3'";} ?>>
    </div>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q4">Scheduled Retirement Age</label>  
  <div class="col-md-4">
  <input id="p4q4" name="p4q4" placeholder="" class="form-control input-md" type="text" <?php if (isset($p4q4)) { echo "value='$p4q4'";} ?>>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q5">Monthly Premium</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p4q5" name="p4q5" class="form-control" placeholder="" type="text" <?php if (isset($p4q5)) { echo "value='$p4q5'";} ?>>
    </div>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q6">Date Started</label>  
  <div class="col-md-4">
  <input id="p4q6" name="p4q6" placeholder="" class="form-control input-md" type="text" <?php if (isset($p4q6)) { echo "value='$p4q6'";} ?>>
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q7">Status</label>
  <div class="col-md-4">
    <select id="p4q7" name="p4q7" class="form-control">
                                <?php if(isset($p4q7)){ ?>
        <option value="<?php echo $p4q7;?>"><?php echo $p4q7;?></option>
            
        <?php }?>
      <option value="Active">Active</option>
      <option value="Frozen">Frozen</option>
    </select>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q8">Does your family receive a pension death benefit</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p4q8-0">
      <input name="p4q8" id="p4q8-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p4q8)) { echo 'checked="checked"'; } elseif ($p4q8=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p4q8-1">
      <input name="p4q8" id="p4q8-1" value="No" type="radio" <?php if(isset($p4q8)) {if ($p4q8=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q9">If so, how much</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p4q9" name="p4q9" class="form-control" placeholder="" type="text" <?php if (isset($p4q9)) { echo "value='$p4q9'";} ?>>
    </div>
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q10">Why choose this provider &amp; product</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p4q10" name="p4q10"><?php if (isset($p4q10)) { echo "$p4q10";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q11">Have you been satisfied with this current provider and why?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p4q11" name="p4q11"><?php if (isset($p4q11)) { echo "$p4q11";} ?></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q12">When was the last time you have contact or had a pension review?</label>
  <div class="col-md-4">
    <select id="p4q12" name="p4q12" class="form-control">
        <?php if(isset($p4q12)){ ?>
        <option value="<?php echo $p4q12;?>"><?php echo $p4q12;?></option>
            
        <?php } ?>
      <option value="Within last 3 months">Within last 3 months</option>
      <option value="Within last 12 months">Within last 12 months</option>
      <option value="12 months plus">12 months plus</option>
      <option value="Never">Never</option>
    </select>
  </div>
</div>

<legend>Financial Goals</legend>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q13">To achieve a sustainable retirement income/lifestyle</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p4q13-0">
      <input name="p4q13" id="p4q13-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p4q13)) { echo 'checked="checked"'; } elseif ($p4q13=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p4q13-1">
      <input name="p4q13" id="p4q13-1" value="No" type="radio" <?php if(isset($p4q13)) {if ($p4q13=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q14">Sufficient death benefits to leave spouse/family</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p4q14-0">
      <input name="p4q14" id="p4q14-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p4q14)) { echo 'checked="checked"'; } elseif ($p4q14=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p4q14-1">
      <input name="p4q14" id="p4q14-1" value="No" type="radio" <?php if(isset($p4q14)) {if ($p4q14=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q15">Savings for your children</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p4q15-0">
      <input name="p4q15" id="p4q15-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p4q15)) { echo 'checked="checked"'; } elseif ($p4q15=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p4q15-1">
      <input name="p4q15" id="p4q15-1" value="No" type="radio" <?php if(isset($p4q15)) {if ($p4q15=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q16">To invest in property</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p4q16-0">
      <input name="p4q16" id="p4q16-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p4q16)) { echo 'checked="checked"'; } elseif ($p4q16=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p4q16-1">
      <input name="p4q16" id="p4q16-1" value="No" type="radio" <?php if(isset($p4q16)) {if ($p4q16=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q17">Buy a holiday home</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p4q17-0">
      <input name="p4q17" id="p4q17-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p4q17)) { echo 'checked="checked"'; } elseif ($p4q17=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p4q17-1">
      <input name="p4q17" id="p4q17-1" value="No" type="radio" <?php if(isset($p4q17)) {if ($p4q17=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p4q18">Other</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p4q18" name="p4q18"><?php if (isset($p4q18)) { echo "$p4q18";} ?></textarea>
  </div>
</div>
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

    $page5 = $pdo->prepare("SELECT p5q1, p5q2, p5q3, p5q4, p5q5, p5q6, p5q7, p5q8, p5q9, p5q10, p5q11, p5q12, p5q13, p5q14, p5q15, p5q16, p5q17, p5q18, p5q19, p5q20, p5q21, p5q22, p5q23, p5q24, p5q25, p5q26, p5q27, p5q28, p5q29, p5q30, p5q31, p5q32, p5q33, p5q34, p5q35, p5q36 FROM factfind_page5 WHERE factfind_id=:factfindor");

    $page5->bindParam(':factfindor', $factfindorg, PDO::PARAM_STR, 12);
    $page5->execute();
    $data6=$page5->fetch(PDO::FETCH_ASSOC);
    
    $p5q1=$data6['p5q1'];
    $p5q2=$data6['p5q2'];
    $p5q3=$data6['p5q3'];
    $p5q4=$data6['p5q4'];
    $p5q5=$data6['p5q5'];
    $p5q6=$data6['p5q6'];
    $p5q7=$data6['p5q7'];
    $p5q8=$data6['p5q8'];
    $p5q9=$data6['p5q9'];
    $p5q10=$data6['p5q10'];
    $p5q11=$data6['p5q11'];
    $p5q12=$data6['p5q12'];
    $p5q13=$data6['p5q13'];
    $p5q14=$data6['p5q14'];
    $p5q15=$data6['p5q15'];
    $p5q16=$data6['p5q16'];
    $p5q17=$data6['p5q17'];
    $p5q18=$data6['p5q18'];
    $p5q19=$data6['p5q19'];
    $p5q20=$data6['p5q20'];
    $p5q21=$data6['p5q21'];
    $p5q22=$data6['p5q22'];
    $p5q23=$data6['p5q23'];
    $p5q24=$data6['p5q24'];
    $p5q25=$data6['p5q25'];
    $p5q26=$data6['p5q26'];
    $p5q27=$data6['p5q27'];
    $p5q28=$data6['p5q28'];
    $p5q29=$data6['p5q29'];
    $p5q30=$data6['p5q30'];
    $p5q31=$data6['p5q31'];
    $p5q32=$data6['p5q32'];
    $p5q33=$data6['p5q33'];
    $p5q34=$data6['p5q34'];
    $p5q35=$data6['p5q35'];
    $p5q36=$data6['p5q36'];

            ?>
            
            
            
            
 <div role="tabpanel" class="tab-pane" id="menu4">
                                <div class="panel panel-primary">
      <div class="panel-heading">Fact Find - More Pension Policies</div>
      <div class="panel-body">
          
                   <form class="form-horizontal" method="POST" action="php/AddFactFindSubmit.php?page5=y">
             <input type="hidden" value="<?php echo $factfindorg ?>" name="factfindid">
<input type="hidden" value="<?php echo $search ?>" name="search">
<fieldset>


<legend>Pension Policy (2)</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q1">Provider Name</label>  
  <div class="col-md-4">
  <input id="p5q1" name="p5q1" placeholder="" class="form-control input-md" type="text" <?php if (isset($p5q1)) { echo "value='$p5q1'";} ?>>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q2">Policy</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">#</span>
      <input id="p5q2" name="p5q2" class="form-control" placeholder="" type="text" <?php if (isset($p5q2)) { echo "value='$p5q2'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q3">Pot Value (approx)</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p5q3" name="p5q3" class="form-control" placeholder="" type="text" <?php if (isset($p5q3)) { echo "value='$p5q3'";} ?>>
    </div>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q4">Scheduled Retirement Age</label>  
  <div class="col-md-4">
  <input id="p5q4" name="p5q4" placeholder="" class="form-control input-md" type="text" <?php if (isset($p5q4)) { echo "value='$p5q4'";} ?>>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q5">Monthly Premium</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p5q5" name="p5q5" class="form-control" placeholder="" type="text" <?php if (isset($p5q5)) { echo "value='$p5q5'";} ?>>
    </div>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q6">Date Started</label>  
  <div class="col-md-4">
  <input id="p5q6" name="p5q6" placeholder="" class="form-control input-md" type="text" <?php if (isset($p5q6)) { echo "value='$p5q6'";} ?>>
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q7">Status</label>
  <div class="col-md-4">
    <select id="p5q7" name="p5q7" class="form-control">
                <?php if(isset($p5q7)){ ?>
        <option value="<?php echo $p5q7;?>"><?php echo $p5q7;?></option>
            
        <?php } ?>
      <option value="Active">Active</option>
      <option value="Frozen">Frozen</option>
    </select>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q8">Does your family receive a pension death benefit</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p5q8-0">
      <input name="p5q8" id="p5q8-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p5q8)) { echo 'checked="checked"'; } elseif ($p5q8=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="c-1">
      <input name="p5q8" id="p5q8-1" value="No" type="radio" <?php if(isset($p5q8)) {if ($p5q8=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q9">If so, how much</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p5q9" name="p5q9" class="form-control" placeholder="" type="text" <?php if (isset($p5q9)) { echo "value='$p5q9'";} ?>>
    </div>
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q10">Why choose this provider &amp; product</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p5q10" name="p5q10"><?php if (isset($p5q10)) { echo "$p5q10";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q11">Have you been satisfied with this current provider and why?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p5q11" name="p5q11"><?php if (isset($p5q11)) { echo "$p5q11";} ?></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q12">When was the last time you have contact or had a pension review?</label>
  <div class="col-md-4">
    <select id="p5q12" name="p5q12" class="form-control">
                        <?php if(isset($p5q12)){ ?>
        <option value="<?php echo $p5q12;?>"><?php echo $p5q12;?></option>
            
        <?php } ?>
      <option value="Within last 3 months">Within last 3 months</option>
      <option value="Within last 12 months">Within last 12 months</option>
      <option value="12 months plus">12 months plus</option>
      <option value="Never">Never</option>
    </select>
  </div>
</div>


<legend>Pension Policy (3)</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q13">Provider Name</label>  
  <div class="col-md-4">
  <input id="p5q13" name="p5q13" placeholder="" class="form-control input-md" type="text" <?php if (isset($p5q13)) { echo "value='$p5q13'";} ?>>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q14">Policy</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">#</span>
      <input id="p5q14" name="p5q14" class="form-control" placeholder="" type="text" <?php if (isset($p5q14)) { echo "value='$p5q14'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q15">Pot Value (approx)</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p5q15" name="p5q15" class="form-control" placeholder="" type="text" <?php if (isset($p5q15)) { echo "value='$p5q15'";} ?>>
    </div>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q16">Scheduled Retirement Age</label>  
  <div class="col-md-4">
  <input id="p5q16" name="p5q16" placeholder="" class="form-control input-md" type="text" <?php if (isset($p5q16)) { echo "value='$p5q16'";} ?>>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q17">Monthly Premium</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p5q17" name="p5q17" class="form-control" placeholder="" type="text" <?php if (isset($p5q17)) { echo "value='$p5q17'";} ?>>
    </div>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q18">Date Started</label>  
  <div class="col-md-4">
  <input id="p5q18" name="p5q18" placeholder="" class="form-control input-md" type="text" <?php if (isset($p5q18)) { echo "value='$p5q18'";} ?>>
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q19">Status</label>
  <div class="col-md-4">
    <select id="p5q19" name="p5q19" class="form-control">
                                <?php if(isset($p5q19)){ ?>
        <option value="<?php echo $p5q19;?>"><?php echo $p5q19;?></option>
            
        <?php } ?>
      <option value="Active">Active</option>
      <option value="Frozen">Frozen</option>
    </select>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q20">Does your family receive a pension death benefit</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p5q20-0">
      <input name="p5q20" id="p5q20-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p5q20)) { echo 'checked="checked"'; } elseif ($p5q20=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p5q20-1">
      <input name="p5q20" id="p5q20-1" value="No" type="radio" <?php if(isset($p5q20)) {if ($p5q20=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q21">If so, how much</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p5q21" name="p5q21" class="form-control" placeholder="" type="text" <?php if (isset($p5q21)) { echo "value='$p5q21'";} ?>>
    </div>
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q22">Why choose this provider &amp; product</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p5q22" name="p5q22"><?php if (isset($p5q22)) { echo "$p5q22";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q23">Have you been satisfied with this current provider and why?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p5q23" name="p5q23"><?php if (isset($p5q23)) { echo "$p5q23";} ?></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q24">When was the last time you have contact or had a pension review?</label>
  <div class="col-md-4">
    <select id="p5q24" name="p5q24" class="form-control">
                                        <?php if(isset($p5q24)){ ?>
        <option value="<?php echo $p5q24;?>"><?php echo $p5q24;?></option>
            
        <?php } ?>
      <option value="Within last 3 months">Within last 3 months</option>
      <option value="Within last 12 months">Within last 12 months</option>
      <option value="12 months plus">12 months plus</option>
      <option value="Never">Never</option>
    </select>
  </div>
</div>


<legend>Pension Policy (4)</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q25">Provider Name</label>  
  <div class="col-md-4">
  <input id="p5q25" name="p5q25" placeholder="" class="form-control input-md" type="text" <?php if (isset($p5q25)) { echo "value='$p5q25'";} ?>>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q26">Policy</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">#</span>
      <input id="p5q26" name="p5q26" class="form-control" placeholder="" type="text" <?php if (isset($p5q26)) { echo "value='$p5q26'";} ?>>
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q27">Pot Value (approx)</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p5q27" name="p5q27" class="form-control" placeholder="" type="text" <?php if (isset($p5q27)) { echo "value='$p5q27'";} ?>>
    </div>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q28">Scheduled Retirement Age</label>  
  <div class="col-md-4">
  <input id="p5q28" name="p5q28" placeholder="" class="form-control input-md" type="text" <?php if (isset($p5q28)) { echo "value='$p5q28'";} ?>>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q29">Monthly Premium</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p5q29" name="p5q29" class="form-control" placeholder="" type="text" <?php if (isset($p5q29)) { echo "value='$p5q29'";} ?>>
    </div>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q30">Date Started</label>  
  <div class="col-md-4">
  <input id="p5q30" name="p5q30" placeholder="" class="form-control input-md" type="text" <?php if (isset($p5q30)) { echo "value='$p5q30'";} ?>>
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q31">Status</label>
  <div class="col-md-4">
    <select id="p5q31" name="p5q31" class="form-control">
         <?php if(isset($p5q31)){ ?>
        <option value="<?php echo $p5q31;?>"><?php echo $p5q31;?></option>
            
        <?php } ?>
      <option value="Active">Active</option>
      <option value="Frozen">Frozen</option>
    </select>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q32">Does your family receive a pension death benefit</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="p5q32-0">
      <input name="p5q32" id="p5q32-0" value="Yes" checked="checked" type="radio" <?php if(!isset($p5q32)) { echo 'checked="checked"'; } elseif ($p5q32=='Yes'){ echo 'checked="checked"';}?>>
      Yes
    </label> 
    <label class="radio-inline" for="p5q32-1">
      <input name="p5q32" id="p5q32-1" value="No" type="radio" <?php if(isset($p5q32)) {if ($p5q32=='No'){ echo 'checked="checked"';}}?>>
      No
    </label>
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q33">If so, how much</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">£</span>
      <input id="p5q33" name="p5q33" class="form-control" placeholder="" type="text" <?php if (isset($p5q33)) { echo "value='$p5q33'";} ?>>
    </div>
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q34">Why choose this provider &amp; product</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p5q34" name="p5q34"><?php if (isset($p5q34)) { echo "$p5q34";} ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q35">Have you been satisfied with this current provider and why?</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="p5q35" name="p5q35"><?php if (isset($p5q35)) { echo "$p5q35";} ?></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="p5q36">When was the last time you have contact or had a pension review?</label>
  <div class="col-md-4">
    <select id="p5q36" name="p5q36" class="form-control">
                 <?php if(isset($p5q36)){ ?>
        <option value="<?php echo $p5q36;?>"><?php echo $p5q36;?></option>
            
        <?php } ?>
      <option value="Within last 3 months">Within last 3 months</option>
      <option value="Within last 12 months">Within last 12 months</option>
      <option value="12 months plus">12 months plus</option>
      <option value="Never">Never</option>
    </select>
  </div>
</div>
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
            
            
            <div role="tabpanel" class="tab-pane" id="menu5">
                
                
            </div>
                       
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
    </div>
    </div>

<!--MODAL -->
        <div id="uploadmodal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Files</h4>
      </div>
      <div class="modal-body">
          
          <?php        
          
          $stagetask="Risk Profile";
          
          $getstage = $pdo->prepare("select stage_id from pension_stages where task=:task and client_id=:search");
          $getstage->bindParam(':search', $search, PDO::PARAM_STR, 12);
          $getstage->bindParam(':task', $stagetask, PDO::PARAM_STR, 12);
          $getstage->execute();
          $getstager=$getstage->fetch(PDO::FETCH_ASSOC);

          
          $newlocationvar = "$search-%";
          
          $pcrs = $pdo->prepare("SELECT uploadtype, file FROM tbl_uploads WHERE file like :lgsearchplaceholder and uploadtype ='Stage 2 Risk Profile'");
                            $pcrs->bindParam(':lgsearchplaceholder', $newlocationvar, PDO::PARAM_STR, 12);
                            $pcrs->execute();
                            while ($result11=$pcrs->fetch(PDO::FETCH_ASSOC)){
                                
                                $pensionfiless11=$result11['uploadtype'];
                                
                            }
                                
                                if(!isset($pensionfiless11)) { echo "<form action='uploadsubmit.php?stage=2' method='post' enctype='multipart/form-data'>
<label>Upload Risk Profile<input type='file' name='file' /></label>
<input type='hidden' name='task'  value='Stage 2 Risk Profile'>
<input type='hidden' name='search' value='$search'>
<input type='hidden' value='$stageid' name='stageid'>
<button type='submit' class='btn btn-success' name='btn-upload'><span class='glyphicon glyphicon-arrow-up'> </span></button>
                                </form>";}  if(isset($pensionfiless11)) { }

                                ?>        
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
        <!--END MODAL -->

    
    <script src="/js/jquery.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>