<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {

$search = $_GET['search'];

}

$search = '0';
if(isset($_GET["search"])) $search = $_GET["search"];

?>


<!DOCTYPE html>
<html lang="en">
<title>ADL | Add Policy</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/style/jquery-ui.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>


<script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
  <script src="/js/jquery-1.10.2.js"></script>
  <script src="/js/jquery-ui.js"></script>
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

<?php include('includes/navbar.php'); ?>
<?php include('includes/ADL_PDO_CON.php'); 
    include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    ?>

<br>

<div class="container">

 <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Add Policy</div>
      <div class="panel-body">
      
<form class="AddClient" action="/php/AddPolicySubmit.php" method="POST">

<div class="col-md-4">


    <input type="hidden" name="addmorepolicy" value="y">
    <input type="hidden" name="client_id" value="<?php echo $search?>">



<?php

$query = $pdo->prepare("SELECT client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name , CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2 from client_details where client_id = :searchplaceholder");
$query->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
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
<input type="text" id="application_number" name="application_number" class="form-control" style="width: 170px" required>
</p>
<br>

<p>
<label for="policy_number">Policy Number:</label>
<input type='text' id='policy_number' name='policy_number' class="form-control" autocomplete="off" style="width: 170px" required>
</p>
<br>

<p>
<div class="form-group">
  <label for="type">Type:</label>
  <select class="form-control" name="type" id="type" style="width: 170px" required>
  <option value="">Select...</option>
  <option value="LTA">LTA</option>
  <option value="LTA CIC">LTA + CIC</option>
  <option value="DTA">DTA</option>
  <option value="DTA CIC">DTA + CIC</option>
  <option value="CIC">CIC</option>
  <option value="FPIP">FPIP</option>
  </select>
</div>
</p>


<p>
<div class="form-group">
  <label for="insurer">Insurer:</label>
  <select class="form-control" name="insurer" id="insurer" style="width: 170px" required>
  <option value="">Select...</option>
  <option value="Legal & General">Legal & General</option>
  <option value="Vitality">Vitality</option>
  <option value="Bright Grey">Bright Grey</option>
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
        <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" required/>
    </div> 
</p>


<p>
 <div class="form-row">
        <label for="commission">Commission</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required/>
    </div> 
</p>

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
<br>



<p>
<label for="lead">Lead Gen:</label>
<input type='text' id='lead' name='lead' style="width: 170px" class="form-control" style="width: 170px" required>
</p>


</div>

<br>
<button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
</div>
</form>
<br>
<br>
<form class="AddClient" method="GET" action="Life/ViewClient.php?search=<?php echo $search?>" enctype="multipart/form-data">
<input type="hidden" name="search" value="<?php echo $_GET["search"]?>" readonly>


<button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> Back</button>

</form>
<div class="col-md-4">
</div>
</div>
</div>
</div>

</body>
</html>
