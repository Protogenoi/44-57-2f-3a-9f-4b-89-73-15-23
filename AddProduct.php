<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;
}

$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);

?>
<!DOCTYPE html>
<html lang="en">
<title>Add Product</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link  rel="stylesheet" href="/styles/sweet-alert.min.css" />
<link rel="stylesheet" href="/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
  <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
<script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
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

<?php include('includes/navbar.php'); 
include('includes/ADL_PDO_CON.php'); 
    include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }

$AddLife= filter_input(INPUT_GET, 'Life', FILTER_SANITIZE_NUMBER_INT);
$AddPension= filter_input(INPUT_GET, 'Pension', FILTER_SANITIZE_NUMBER_INT);
$AddHome= filter_input(INPUT_GET, 'Home', FILTER_SANITIZE_NUMBER_INT);

?>

<br>

<div class="container">

 <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Add Product</div>
      <div class="panel-body">
          
          <?php 
          
          if(isset($AddLife)){
    
      $LifePOST= filter_input(INPUT_GET, 'Life', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($LifePOST =='y') {
          
          ?>
      
<form class="AddClient" action="/php/AddPolicySubmit.php" method="POST">

<div class="col-md-4">


    <input type="hidden" name="addmorepolicy" value="y">
    <input type="hidden" name="client_id" value="<?php echo $search?>">

<?php

$query = $pdo->prepare("SELECT client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name , CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2 from client_details where client_id = :search");
$query->bindParam(':search', $search, PDO::PARAM_INT);
$query->execute();

echo "<p>";
echo "<label for='client_name'>Client Name</label>";
echo "<select class='form-control' name='client_name' id='client_name' style='width: 170px' required>";
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
echo "<option value='" . $result['Name'] . "'>" . $result['Name'] . "</option>";
echo "<option value='" . $result['Name2'] . "'>" . $result['Name2'] . "</option>";
echo "<option value='" . $result['Name'] . " and " . $result['Name2'] . "'>" . $result['Name'] . " and " . $result['Name2'] . "</option>";
}
echo "</select>";
echo"</p>";
?>

<p>
<div class="form-group">
  <label for="soj">Single or Joint:</label>
  <select class="form-control" name="soj" id="soj" style="width: 170px" required>
<option value="Single">Single</option>
<option value="Joint">Joint</option>
  </select>
</div>
</p>

<p>
<label for="sale_date">Sale Date:</label>
<input type="text" id="sale_date" name="sale_date" value="<?php echo $date = date('Y-m-d H:i:s');?>" placeholder="<?php echo $date = date('Y-m-d H:i:s');?>"class="form-control" style="width: 170px" required>
</p>
<br>

<p>
<label for="application_number">Application Number:</label>
<input type="text" id="application_number" name="application_number"  class="form-control" style="width: 170px" required>
<label for="application_number"></label>
<span class="help-block">For WOL use One Family</span>  
</p>
<br>

<p>
<label for="policy_number">Policy Number:</label>
<input type='text' id='policy_number' name='policy_number' class="form-control" autocomplete="off" style="width: 170px" placeholder="TBC">
<span class="help-block">For WOL use One Family</span>  
</p>
<br>

<p>
<div class="form-group">
  <label for="type">Type:</label>
  <select class="form-control" name="type" id="type" style="width: 170px" required>
  <option value="">Select...</option>
  <option value="LTA">LTA</option>
  <option value="LTA SIC">LTA SIC (Vitality)</option>
  <option value="LTA CIC">LTA + CIC</option>
  <option value="DTA">DTA</option>
  <option value="DTA CIC">DTA + CIC</option>
  <option value="CIC">CIC</option>
  <option value="FPIP">FPIP</option>
  <option value="WOL">WOL</option>
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

<input type="text" name="submitted_by" value="<?php echo $hello_name ?>" hidden>

<p>
 <div class="form-row">
        <label for="premium">Premium:</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" id="premium" name="premium" required/>
    </div> 
</p>
<?php $cal=2400.00/100; ?>

<p>
 <!--<div class="form-row">
     <div class="notice notice-info" role="alert"><strong><i class="fa fa-exclamation-triangle"></i> Commission calculates at 24%. Check OLP for correct amount, as it will differ by .0% </strong></div>
     -->
     
        <label for="commission">Commission</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required/>
    </div> 
</p>
<!--
<script>$(document).ready(function(){
    $(".premium").keyup(function(){
          var val1 = +$(".value1").val();
          var val2 = +$(".value2").val();
          $("#commission").val(<?php echo $cal;?>*val1);
   });
});</script>

-->
<p>
 <div class="form-row">
        <label for="commission">Cover Amount</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="covera" required/>
    </div> 
</p>

<p>
 <div class="form-row">
        <label for="commission">Policy Term</label>
    <div class="input-group"> 
        <span class="input-group-addon">yrs</span>
        <input style="width: 140px" autocomplete="off" type="text" class="form-control" id="polterm" name="polterm" required/>
    </div> 
</p>


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
 <div class="form-row">
        <label for="commission">Drip</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" required/>
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
  <?php if(isset($companynamere)) { if($companynamere=='Assura') { echo "<option value='Underwritten'>Underwritten</option>";} } ?>
      <?php if(isset($companynamere)) { if($companynamere=='Assura') { echo "<option value='Awaiting Policy Cancellation Authority'>Awaiting Policy Cancellation Authority</option>";} } ?>

  </select>
</div>
</p>


<p>
<label for="closer">Closer:</label>
<input type='text' id='closer' name='closer' style="width: 170px" class="form-control" style="width: 170px" required>
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
<input type='text' id='lead' name='lead' style="width: 170px" class="form-control" style="width: 170px" required>
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
<button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
</div>
</form>
<br>
<br>
<form class="AddClient" method="GET" action="/Life/ViewClient.php?search=<?php echo $search?>">
<input type="hidden" name="search" value="<?php echo $_GET["search"]?>" readonly>


<button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> Back</button>

</form>

<?php

}
}

if(isset($AddPension)){
    
      $PensionPOST= filter_input(INPUT_GET, 'Pension', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($PensionPOST =='y') {
        
        $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
         

?>

<form class="AddClient" action="/php/AddPolicySubmit.php?AddPension=y" method="POST">
    <div class="col-md-4">
        
        <input type="hidden" name="client_id" value="<?php echo $search?>">
            
            <?php
            
            $query = $pdo->prepare("SELECT client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name , CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2 from pension_clients where client_id = :search");
            $query->bindParam(':search', $search, PDO::PARAM_INT);
            $query->execute();
            
            echo "<p>";
            echo "<label for='client_name'>Client Name</label>";
            echo "<select class='form-control' name='client_name' id='client_name' style='width: 170px' required>";
            while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                echo "<option value='" . $result['Name'] . "'>" . $result['Name'] . "</option>";
                echo "<option value='" . $result['Name2'] . "'>" . $result['Name2'] . "</option>";
                
            }
            echo "</select>";
            echo"</p>";
            
            ?>
        
<!--
        <div class="form-group">
            <label for="provider">Provider:</label>
            <select class="form-control" name="provider" id="Provider" style="width: 170px" required>
                <option value="L&G">Legal and General</option>
            </select>
        </div>
-->        
                <p>
            <label for="provider">Provider:</label>
            <input type='text' id='provider' name='provider' class="form-control" autocomplete="off" style="width: 170px" required>
        </p>
        
                        <p>
            <label for="policy_number">Policy Number:</label>
            <input type='text' id='policy_number' name='policy_number' class="form-control" autocomplete="off" style="width: 170px" required>
        </p>
        
                <div class="form-group">
            <label for="type">Type:</label>
            <select class="form-control" name="type" id="type" style="width: 170px" required>
                <option value="">Select...</option>
                <option value="Private">Private</option>
                <option value="Former Work">Former Work</option>
            </select>
        </div>
        
                                <div class="form-group">
            <label for="drawing">Drawing Down:</label>
            <select class="form-control" name="drawing" id="drawing" style="width: 170px" required>
                <option value="">Select...</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>  

    </div>
        <div class="col-md-4">
           
            
        <p>
            <label for="duration">Plan Duration:</label>
            <input type='text' id='duration' name='duration' class="form-control" autocomplete="off" style="width: 170px" required>
        </p>    
            
                <div class="form-group">
            <label for="statements">Statements Available:</label>
            <select class="form-control" name="statements" id="statements" style="width: 170px" required>
                <option value="">Select...</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>  
        

        
        </div>
    
    <div class="col-md-4">
           
            
        <div class="form-row">
            <label for="contribution">Contribution:</label>
            <div class="input-group"> 
                <span class="input-group-addon">£</span>
                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="contribution" name="contribution" required/>
            </div> 
        </div>
            <br>  
                    <div class="form-row">
            <label for="value">Pot Value:</label>
            <div class="input-group"> 
                <span class="input-group-addon">£</span>
                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="value" name="value" required/>
            </div> 
        </div>
        <br>
                
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" name="status" id="status" style="width: 170px" required>
                <option value="">Select...</option>
                <option value="Active">Active</option>
                <option value="Frozen">Frozen</option>
                <option value="New">New</option>
            </select>
        </div>
    </div>
        
    <div class="col-md-4">
            <div class="btn-group">
                <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
            </div>
    </div>
            </form>


<?php } }

if(isset($AddHome)){ 
    $HomePOST= filter_input(INPUT_GET, 'Home', FILTER_SANITIZE_SPECIAL_CHARS);
    if ($HomePOST =='y') {  
        $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);
        $query = $pdo->prepare("SELECT client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name , CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2 from client_details where client_id = :search");
        $query->bindParam(':search', $CID, PDO::PARAM_INT);
        $query->execute();
        $result=$query->fetch(PDO::FETCH_ASSOC);
        
        $NAME=$result['Name'];
        $NAME2=$result['Name2'];
        ?>

<form class="AddClient" action="/Home/php/AddPolicySubmit.php?query=HomeInsurance&CID=<?php echo $CID; ?>" method="POST">
    <div class="col-md-4">
        
        <label for='client_name'>Client Name</label>
        <select class='form-control' name='client_name' id='client_name' style='width: 170px' required>
            <option value='<?php if(isset($NAME)) { echo $NAME; } ?>'><?php if(isset($NAME)) { echo $NAME; } ?></option>
                <?php if(isset($NAME2)) { ?>
            <option value='<?php if(isset($NAME2)) { echo $NAME2; } ?>'><?php if(isset($NAME2)) { echo $NAME2; } ?></option>
                <?php } ?>
                    <?php if(isset($NAME2)) { ?>
            <option value='<?php if(isset($NAME2)) { echo "$NAME and $NAME2"; } ?>'><?php if(isset($NAME2)) { echo "$NAME and $NAME2"; } ?></option>
                <?php } ?>
        </select>
        
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
                <option value="Buidlings & Contents">Buildings & Contents</option>
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
                    <label for="cover">Cover Amount</label>
                    <div class="input-group"> 
                        <span class="input-group-addon">£</span>
                        <input autocomplete="off" style="width: 140px" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="cover" name="cover" required/>
                    </div>
                    
                    <br>
                    <div class="form-row">
                        <label for="PolicyStatus">Policy Status:</label>
                        <select class="form-control" name="status" id="status" style="width: 140px">
                            <option value="">Select...</option>
                            <option value="Live">Live</option>
                            <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
                            <option value="NTU">NTU</option>
                            <option value="Declined">Declined</option>
                            <option value="Redrawn">Redrawn</option>
                        </select>
                    </div>
                    
                    <br>
                    <label for="closer">Closer:</label>
                    <input type='text' id='closer' name='closer' style="width: 140px" required>
                    <script>
                var options = {
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
                </div>
                
                <div class="btn-group">
                    <a href="Home/ViewClient.php?CID=<?php echo $CID; ?>" class="btn btn-warning "><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
                </div>
                </form>
</div>
    
    <?php } } ?>

<div class="col-md-4">
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
