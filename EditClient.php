<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('includes/Access_Levels.php');
include('includes/adl_features.php');

      if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;
}          
            if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Edit Client</title>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles/layoutcrm.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link  rel="stylesheet" href="styles/sweet-alert.min.css" />
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/sweet-alert.min.js"></script>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <script>
  $(function() {
    $( "#dob" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:-0"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#dob2" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:-0"
        });
  });
  </script>
<script>
    $("readonly").keydown(function(e){
        e.preventDefault();
    });
</script>
<style type="text/css">
	.editclient{
		margin: 20px;
	}

</style>

<?php if($ffpost_code=='1') { 
    
            include('includes/ADL_PDO_CON.php');     
                
            $PostcodeQuery = $pdo->prepare("select api_key from api_keys WHERE type ='PostCode' limit 1");
            $PostcodeQuery->execute()or die(print_r($query->errorInfo(), true));
            $PDre=$PostcodeQuery->fetch(PDO::FETCH_ASSOC);
            $PostCodeKey=$PDre['api_key'];       
    
    
    ?>

<script src="js/jquery.postcodes.min.js"></script>

<?php } ?>
</head>

<body>
    <?php include('includes/navbar.php');


     include($_SERVER['DOCUMENT_ROOT']."/includes/adlfunctions.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    include('includes/ADL_PDO_CON.php');
    
    $search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
    $life= filter_input(INPUT_GET, 'life', FILTER_SANITIZE_SPECIAL_CHARS);
    $pension= filter_input(INPUT_GET, 'pension', FILTER_SANITIZE_SPECIAL_CHARS);
    $legacy= filter_input(INPUT_GET, 'legacy', FILTER_SANITIZE_SPECIAL_CHARS);
    $PBA= filter_input(INPUT_GET, 'pba', FILTER_SANITIZE_SPECIAL_CHARS);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);

}

if(isset($PBA)) {
    
    $query = $pdo->prepare("SELECT client_id, title, firstname, lastname, dob, email, tel, tel2, tel3, title2, firstname2, lastname2, dob2, email2, add1, add2, add3, town, post_code FROM pba_client_details WHERE client_id = :searchplaceholder");
    $query->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
    $query->execute();
    $data2=$query->fetch(PDO::FETCH_ASSOC);

?>


<div class="container">

<div class="editclient">
    <div class="notice notice-warning">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Warning!</strong> You are now editing <?php echo $data2['title']?> <?php echo $data2['firstname']?> <?php echo $data2['lastname']?> / <?php echo $data2['title2']?> <?php echo $data2['firstname2']?> <?php echo $data2['lastname2']?> details.
    </div>

	  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading"><i class="fa fa-edit"></i> Edit Client</div>
      <div class="panel-body">
    <form id="from1" class="AddClient" action="/php/EditClientSubmit.php?pba=y" method="POST" autocomplete="off">
    <input  class="form-control" type="hidden" name="keyfield" value="<?php echo $search?>">


<div class="col-md-4">
<h3><span class="label label-info">Client Details (1)</span></h3>
<br>

<p>
<div class="form-group">
  <label for="title">Title:</label>
  <select class="form-control" name="title" id="title" style="width: 170px" required>
                    <option value="<?php echo $data2[title]?>"><?php echo $data2[title]?></option>
                    <option value="Mr">Mr</option>
                    <option value="Dr">Dr</option>
                    <option value="Miss">Miss</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Other">Other</option>
  </select>
</div>
</p>


<p>
<label for="firstname">First Name:</label>
<input  class="form-control" type="text" id="firstname" name="firstname" value="<?php echo $data2[firstname]?>" class="form-control" style="width: 170px" required>
</p>


<p>
<label for="lastname">Last Name:</label>
<input  class="form-control" type="text" id="lastname" name="lastname" value="<?php echo $data2[lastname]?>" class="form-control" style="width: 170px" required>
</p>


<p>
<label for="dob">Date of Birth:</label>
<input  class="form-control" type="text" id="dob" name="dob" value="<?php echo $data2[dob]?>" class="form-control" style="width: 170px" required>
</p>


<p>
<label for="email">Email:</label>
<input  class="form-control" type="email" id="email" name="email" value="<?php echo $data2[email]?>" class="form-control" style="width: 170px">
</p>

</p>


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
                    <option value="<?php echo $data2[title2]?>"><?php echo $data2[title2]?></option>
                    <option value="Mr">Mr</option>
                    <option value="Dr">Dr</option>
                    <option value="Miss">Miss</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Other">Other</option>
  </select>
</div>

</p>

<p>
<label for="firstname2">First Name:</label>
<input  class="form-control" type="text" id="firstname2" name="firstname2" value="<?php echo $data2[firstname2]?>" class="form-control" style="width: 170px">
</p>
<p>
<label for="lastname2">Last Name:</label>
<input  class="form-control" type="text" id="lastname2" name="lastname2" value="<?php echo $data2[lastname2]?>" class="form-control" style="width: 170px">
</p>

<p>
<label for="dob2">Date of Birth:</label>
<input  class="form-control" type="text" id="dob2" name="dob2" value="<?php echo $data2[dob2]?>" class="form-control" style="width: 170px">
</p>

<p>
<label for="email2">Email:</label>
<input  class="form-control" type="email2" id="email2" name="email2" value="<?php echo $data2[email2]?>" class="form-control" style="width: 170px">

</div>

<div class="col-md-4">
<p>
<h3><span class="label label-info">Contact Details</span></h3>
<br>
</p>

<p>
<label for="phone_number">Contact Number:</label>
<input  class="form-control" type="tel" id="tel1" name="tel" value="<?php echo $data2[tel]?>" class="form-control" style="width: 170px">
</p>


<p>
<label for="alt_number">Alt Number:</label>
<input  class="form-control" type="tel" id="tel2" name="tel2" value="<?php echo $data2[tel2]?>" class="form-control" style="width: 170px">
</p>

<p>
<label for="alt_number">Alt Number:</label>
<input  class="form-control" type="tel" id="tel3" name="tel3" value="<?php echo $data2[tel3]?>" class="form-control" style="width: 170px">
</p>


<p>
<label for="address1">Address Line 1:</label>
<input  class="form-control" type="text" id="add1" name="add1" value="<?php echo $data2[add1]?>" class="form-control" style="width: 170px" required>
</p>

<p>
<label for="address2">Address Line 2:</label>
<input  class="form-control" type="text" id="add2" name="add2" value="<?php echo $data2[add2]?>" class="form-control" style="width: 170px" >
</p>

<p>
<label for="address3">Address Line 3:</label>
<input  class="form-control" type="text" id="add3" name="add3" value="<?php echo $data2[add3]?>"class="form-control" style="width: 170px">
</p>

<p>
<label for="town">Post Town:</label>
<input  class="form-control" type="text" id="town" name="town" value="<?php echo $data2[town]?>" class="form-control" style="width: 170px" >
</p>

<p>
<label for="post_code">Post Code:</label>
<input  class="form-control" type="text" id="post_code" name="post_code" value="<?php echo $data2[post_code]?>" class="form-control" style="width: 170px" required>
</p>



<br>
<button class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
       
    </form>

</div>
</div>
</div>
</div>
</div>
</div>
    
    <?php } 



if(isset($life)) {
    
    $query = $pdo->prepare("SELECT leadauditid, leadauditid2, client_id, title, first_name, last_name, dob, email, phone_number, alt_number, title2, first_name2, last_name2, dob2, email2, address1, address2, address3, town, post_code, date_added, submitted_by, leadid1, leadid2, leadid3, leadid12, leadid22, leadid32, callauditid, callauditid2 FROM client_details WHERE client_id = :searchplaceholder");
    $query->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
    $query->execute();
    $data2=$query->fetch(PDO::FETCH_ASSOC);

?>


<div class="container">

<div class="editclient">
    <div class="notice notice-warning">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Warning!</strong> You are now editing <?php echo $data2['title']?> <?php echo $data2['first_name']?> <?php echo $data2['last_name']?> / <?php echo $data2['title2']?> <?php echo $data2['first_name2']?> <?php echo $data2['last_name2']?> details.
    </div>

	  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading"><i class="fa fa-edit"></i> Edit Client</div>
      <div class="panel-body">
    <form id="from1" class="AddClient" action="/php/EditClientSubmit.php?life=y" method="POST" autocomplete="off">
    <input  class="form-control" type="hidden" name="keyfield" value="<?php echo $search?>">
<input  class="form-control" type="hidden" name="edited" value="<?php echo $hello_name ?>">  


<div class="col-md-4">
<h3><span class="label label-info">Client Details (1)</span></h3>
<br>

<p>
<div class="form-group">
  <label for="title">Title:</label>
  <select class="form-control" name="title" id="title" style="width: 170px" required>
                    <option value="<?php echo $data2[title]?>"><?php echo $data2[title]?></option>
                    <option value="Mr">Mr</option>
                    <option value="Dr">Dr</option>
                    <option value="Miss">Miss</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Other">Other</option>
  </select>
</div>
</p>


<p>
<label for="first_name">First Name:</label>
<input  class="form-control" type="text" id="first_name" name="first_name" value="<?php echo $data2[first_name]?>" class="form-control" style="width: 170px" required>
</p>


<p>
<label for="last_name">Last Name:</label>
<input  class="form-control" type="text" id="last_name" name="last_name" value="<?php echo $data2[last_name]?>" class="form-control" style="width: 170px" required>
</p>


<p>
<label for="dob">Date of Birth:</label>
<input  class="form-control" type="text" id="dob" name="dob" value="<?php echo $data2[dob]?>" class="form-control" style="width: 170px" required>
</p>


<p>
<label for="email">Email:</label>
<input  class="form-control" type="email" id="email" name="email" value="<?php echo $data2[email]?>" class="form-control" style="width: 170px">
</p>

</p>
<h3><span class="label label-info">System Info (1)</span></h3>
<br>
</p>

<p>
<label for="callauditid">Closer Call Audit ID</label>
<input  class="form-control" type="text" id="callauditid" name="callauditid" value="<?php echo $data2[callauditid]?>" class="form-control" style="width: 170px">
</p>

<p>
<label for="leadauditid">Lead Call Audit ID</label>
<input  class="form-control" type="text" id="leadauditid" name="leadauditid" value="<?php echo $data2[leadauditid]?>" class="form-control" style="width: 170px">
</p>

<p>
<label for="leadid1">Lead ID 1</label>
<input  class="form-control" type="text" id="leadid1" name="leadid1" value="<?php echo $data2[leadid1]?>"class="form-control" style="width: 170px" >
</p>

<p>
<label for="leadid2">Lead ID 2</label>
<input  class="form-control" type="text" id="leadid2" name="leadid2" value="<?php echo $data2[leadid2]?>" class="form-control" style="width: 170px">
</p>

<p>
<label for="leadid3">Lead ID 3</label>
<input  class="form-control" type="text" id="leadid3" name="leadid3" value="<?php echo $data2[leadid3]?>" class="form-control" style="width: 170px">
</p>

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
                    <option value="<?php echo $data2[title2]?>"><?php echo $data2[title2]?></option>
                    <option value="Mr">Mr</option>
                    <option value="Dr">Dr</option>
                    <option value="Miss">Miss</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Other">Other</option>
  </select>
</div>

</p>

<p>
<label for="first_name2">First Name:</label>
<input  class="form-control" type="text" id="first_name2" name="first_name2" value="<?php echo $data2[first_name2]?>" class="form-control" style="width: 170px">
</p>
<p>
<label for="last_name2">Last Name:</label>
<input  class="form-control" type="text" id="last_name2" name="last_name2" value="<?php echo $data2[last_name2]?>" class="form-control" style="width: 170px">
</p>

<p>
<label for="dob2">Date of Birth:</label>
<input  class="form-control" type="text" id="dob2" name="dob2" value="<?php echo $data2[dob2]?>" class="form-control" style="width: 170px">
</p>

<p>
<label for="email2">Email:</label>
<input  class="form-control" type="email2" id="email2" name="email2" value="<?php echo $data2[email2]?>" class="form-control" style="width: 170px">

<p>
<h3><span class="label label-info">System Info (2)</span></h3>
<br>
</p>


<p>
<label for="callauditid2">Closer Call Audit ID</label>
<input  class="form-control" type="text" id="callauditid2" name="callauditid2" value="<?php echo $data2[callauditid2]?>" class="form-control" style="width: 170px" disabled>
</p>

<p>
<label for="leadauditid2">Lead Call Audit ID</label>
<input  class="form-control" type="text" id="leadauditid2" name="leadauditid2" value="<?php echo $data2[leadauditid2]?>" class="form-control" style="width: 170px" disabled>
</p>

<p>
<label for="leadid12">Lead ID 1</label>
<input  class="form-control" type="text" id="leadid12" name="leadid12" value="<?php echo $data2[leadid12]?>" class="form-control" style="width: 170px" disabled>
</p>

<p>
<label for="leadid22">Lead ID 2</label>
<input  class="form-control" type="text" id="leadid22" name="leadid22" value="<?php echo $data2[leadid22]?>" class="form-control" style="width: 170px" disabled>
</p>

<p>
<label for="leadid32">Lead ID 3</label>
<input  class="form-control" type="text" id="leadid32" name="leadid32" value="<?php echo $data2[leadid32]?>" class="form-control" style="width: 170px" disabled>
</p>

</div>

<div class="col-md-4">
<p>
<h3><span class="label label-info">Contact Details</span></h3>
<br>
</p>

<p>
<label for="phone_number">Contact Number:</label>
<input  class="form-control" type="tel" id="phone_number" name="phone_number" value="<?php echo $data2[phone_number]?>" class="form-control" style="width: 170px" required>
</p>


<p>
<label for="alt_number">Alt Number:</label>
<input  class="form-control" type="tel" id="alt_number" name="alt_number" value="<?php echo $data2[alt_number]?>" class="form-control" style="width: 170px">
</p>

<br>
<?php if($ffpost_code=='1') { ?>
<div id="lookup_field"></div>
<?php } 
            
            if($ffpost_code=='0') { ?>
            
            <div class="alert alert-info"><strong>Info!</strong> Post code lookup feature not enabled.</div>
            
            <?php } ?>
<br>

<p>
<label for="address1">Address Line 1:</label>
<input  class="form-control" type="text" id="address1" name="address1" value="<?php echo $data2[address1]?>" class="form-control" style="width: 170px" required>
</p>

<p>
<label for="address2">Address Line 2:</label>
<input  class="form-control" type="text" id="address2" name="address2" value="<?php echo $data2[address2]?>" class="form-control" style="width: 170px" >
</p>

<p>
<label for="address3">Address Line 3:</label>
<input  class="form-control" type="text" id="address3" name="address3" value="<?php echo $data2[address3]?>"class="form-control" style="width: 170px">
</p>

<p>
<label for="town">Post Town:</label>
<input  class="form-control" type="text" id="town" name="town" value="<?php echo $data2[town]?>" class="form-control" style="width: 170px" required >
</p>

<p>
<label for="post_code">Post Code:</label>
<input  class="form-control" type="text" id="post_code" name="post_code" value="<?php echo $data2[post_code]?>" class="form-control" style="width: 170px" required>
</p>
 <?php if($ffpost_code=='1') { ?>
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
<br>
<select class="form-control" name="changereason" required>
    <option value="">Select update reason...</option>
    <option value="Incorrect Client Name">Incorrect client name (1)</option>
    <option value="Incorrect DOB">Incorrect DOB (1)</option>
    <option value="Incorrect email">Incorrect email address (1)</option>
    <option value="Incorrect Client Name 2">Incorrect client name (2)</option>
    <option value="Incorrect DOB 2">Incorrect DOB (2)</option>
    <option value="Incorrect email 2">Incorrect email address (2)</option>
    <option value="Incorrect Contact number">Incorrect phone number(s)</option>
    <option value="Incorrect Contact address">Incorrect address</option>
    <option value="Moved address">Moved address</option>
    <option value="New contact number">New contact number</option>
    <option value="Added Call Recording Lead ID">Added Call Recording Lead ID</option>
    <option value="Added Closer Audit ID">Added Closer Audit ID</option>
    <option value="Added Lead Audit ID">Added Lead Audit ID</option>
    <option value="Added Client Two">Added Client Two</option>
</select>

<br>
<button class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
       
    </form>
          <a href="/Life/ViewClient.php?search=<?php echo $search?>" class="btn btn-warning"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
</div>
</div>
</div>
</div>
</div>
</div>
    
    <?php } if(isset($pension)) {
    
    $gpenc = $pdo->prepare("SELECT active, marital, residence, ni_num, ni_num2, title, first_name, initials, last_name, dob, title2, first_name2, initials2, last_name2, dob2, address1, address2, address3, town, post_code, number1, number2, number3, email FROM pension_clients WHERE client_id = :searchplaceholder");
    $gpenc->bindParam(':searchplaceholder', $search, PDO::PARAM_INT);
    $gpenc->execute();
    $gppenresult=$gpenc->fetch(PDO::FETCH_ASSOC);
    
    $penresidence=$gppenresult['residence'];
    $penmarital=$gppenresult['marital'];
    $pentitle=$gppenresult['title'];
    $penfirst=$gppenresult['first_name'];
    $penint=$gppenresult['initials'];
    $penlast=$gppenresult['last_name'];
    $pendob=$gppenresult['dob'];
    $penadd1=$gppenresult['address1'];
    $penadd2=$gppenresult['address2'];
    $penadd3=$gppenresult['address3'];
    $pentown=$gppenresult['town'];
    $penpost=$gppenresult['post_code'];
    $penemail=$gppenresult['email'];
    $pennum1=$gppenresult['number1'];
    $pennum2=$gppenresult['number2'];
    $pennum3=$gppenresult['number3'];
    $pentitle2=$gppenresult['title2'];
    $penfirst2=$gppenresult['first_name2'];
    $penint2=$gppenresult['initials2'];
    $penlast2=$gppenresult['last_name2'];
    $pendob2=$gppenresult['dob2'];
    $penni=$gppenresult['ni_num'];
    $penni2=$gppenresult['ni_num2'];
    $penactive=$gppenresult['active'];

        
        ?> 
    
    <div class="container">
        <div class="panel-group">
   <div class="panel panel-primary">
      <div class="panel-heading"><i class="fa fa-edit"></i> Edit Client</div>
      <div class="panel-body">

    
   <form class="AddClient" id="from1" action="/Pensions/php/EditClientSubmit.php?pension=y" method="POST" autocomplete="off">

        <div class="col-md-4">
            <input type="hidden" name="searchid" value="<?php echo $search?>">
            
<h3><span class="label label-info">Add Client</span></h3>
<br>

<?php if (in_array($hello_name,$Level_8_Access, true)) { ?>
                  <div class="form-group">
                      <label for="active">Active Client?</label>
                      <select class="form-control" name="active" id="active" style="width: 170px">
                          <?php 
                          
                          if(isset($penactive)) { 
                              if($penactive=='1') { 
                                  echo "<option value='1'>Yes</option>"; } 
                                  if($penactive=='0') { 
                                      echo "<option value='0'>No</option>"; } 
                                      
                                  } 
                                  
                                  }
                                  
                                  ?>
                          <option value="1">Yes</option>       
                          <option value="0">No</option>

                      </select>
                  </div>


<div class="form-group">
    <label for="title">Title:</label>
    <select class="form-control" name="title" id="title" style="width: 170px" required>
        <?php if(isset($pentitle)) { echo "<option value='$pentitle'>$pentitle</option>"; }?>
        <option value="Mr">Mr</option>       
        <option value="Dr">Dr</option>
        <option value="Miss">Miss</option>
        <option value="Mrs">Mrs</option>
        <option value="Ms">Ms</option>
        <option value="Other">Other</option>
    </select>
</div>
              </p>

            <p>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" style="width: 170px" required <?php if (isset($penfirst)) { echo "value='$penfirst'";} ?>> 
            </p>
            <p>
                <label for="initials">Initials:</label>
                <input type="text" id="initials" name="initials" class="form-control" style="width: 170px" required <?php if (isset($penint)) { echo "value='$penint'";} ?>>
            </p>
            <p>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" style="width: 170px" required <?php if (isset($penlast)) { echo "value='$penlast'";} ?>>
            </p>
            <p>
                <label for="dob">Date of Birth:</label>
                <input type="text" id="dob" name="dob" class="form-control" style="width: 170px" <?php if (isset($pendob)) { echo "value='$pendob'";} ?> required>
            </p>
            
                        <p>
                <label for="marital">Martial Status:</label>
                <input type="text" id="marital" name="marital" class="form-control" style="width: 170px" <?php if (isset($penmarital)) { echo "value='$penmarital'";} ?>>
            </p>
            
            <p>
                <label for="ni_num">NI:</label>
                <input type="text" id="ni_num" name="ni_num" class="form-control" style="width: 170px" <?php if (isset($penni)) { echo "value='$penni'";} ?>>
            </p>
            <br>
              
              </div>
              
              <div class="col-md-4">
                  <h3><span class="label label-info">Client 2</span></h3>
                  <br>                
                  
                  <div class="form-group">
                      <label for="title2">Title:</label>
                      <select class="form-control" name="title2" id="title2" style="width: 170px">
                          <?php if(isset($pentitle2)) { echo "<option value='$pentitle2'>$pentitle2</option>"; }?>
                          <option value="Mr">Mr</option>       
                          <option value="Dr">Dr</option>
                          <option value="Miss">Miss</option>
                          <option value="Mrs">Mrs</option>
                          <option value="Ms">Ms</option>
                          <option value="Other">Other</option>
                      </select>
                  </div>
              </p>

            <p>
                <label for="first_name2">First Name:</label>
                <input type="text" id="first_name2" name="first_name2" class="form-control" style="width: 170px" <?php if (isset($penfirst2)) { echo "value='$penfirst2'";} ?>>
            </p>
            <p>
                <label for="initials2">Initials:</label>
                <input type="text" id="initials2" name="initials2" class="form-control" style="width: 170px" <?php if (isset($penint2)) { echo "value='$penint2'";} ?>>
            </p>
            <p>
                <label for="last_name2">Last Name:</label>
                <input type="text" id="last_name2" name="last_name2" class="form-control" style="width: 170px" <?php if (isset($penlast2)) { echo "value='$penlast2'";} ?>>
            </p>
            <p>
                <label for="dob2">Date of Birth:</label>
                <input type="text" id="dob2" name="dob2" class="form-control" style="width: 170px" <?php if (isset($pendob2)) { echo "value='$pendob2'";} ?>>
            </p>
            <p>
                <label for="ni_num2">NI:</label>
                <input type="text" id="ni_num2" name="ni_num2" class="form-control" style="width: 170px"  <?php if (isset($penni2)) { echo "value='$penni2'";} ?>>
            </p>

                  
              </div>
              
              
              <div class="col-md-4">
            <p>
                
<h3><span class="label label-info">Contact Details</span></h3>
<br>
            </p>
            <p>
                <label for="phone_number">Mobile:</label>
                <input type="tel" id="phone_number" name="number1" class="form-control" style="width: 170px" required pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" <?php if (isset($pennum1)) { echo "value='$pennum1'";} ?> >
            </p>
            <p>
                <label for="alt_number">Landline:</label>
                <input type="tel" id="alt_number" name="number2" class="form-control" style="width: 170px" pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" <?php if (isset($pennum2)) { echo "value='$pennum2'";} ?>>
            </p>
            <p>
                <label for="alt_number">Work:</label>
                <input type="tel" id="alt_number" name="number3" class="form-control" style="width: 170px" pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number" <?php if (isset($pennum3)) { echo "value='$pennum3'";} ?>>
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="email" id="email" class="form-control" style="width: 170px" name="email" <?php if (isset($penemail)) { echo "value='$penemail'";} ?>>
            </p>
             
              
               
            <br>
            <?php if($ffpost_code=='1') { ?>
            <div id="lookup_fieldp"></div>
            <?php } 
            
            if($ffpost_code=='0') { ?>
            
            <div class="alert alert-info"><strong>Info!</strong> Post code lookup feature not enabled.</div>
            
            <?php } ?>
            <br>
                                    <p>
                <label for="residence">Time at residence:</label>
                <input type="text" id="residence" name="residence" class="form-control" style="width: 170px" <?php if (isset($penresidence)) { echo "value='$penresidence'";} ?>>
            </p>
            <p>
                <label for="address1">Address Line 1:</label>
                <input type="text" id="address1" name="address1" class="form-control" style="width: 170px" required <?php if (isset($penadd1)) { echo "value='$penadd1'";} ?>>
            </p>
            <p>
                <label for="address2">Address Line 2:</label>
                <input type="text" id="address2" name="address2" class="form-control" style="width: 170px" <?php if (isset($penadd2)) { echo "value='$penadd2'";} ?>>
            </p>
            <p>
                <label for="address3">Address Line 3:</label>
                <input type="text" id="address3" name="address3" class="form-control" style="width: 170px" <?php if (isset($penadd3)) { echo "value='$penadd3'";} ?>>
            </p>
            <p>
                <label for="town">Post Town:</label>
                <input type="text" id="town" name="town" class="form-control" style="width: 170px" <?php if (isset($pentown)) { echo "value='$pentown'";} ?>>
            </p>
            <p>
                <label for="post_code">Post Code:</label>
                <input type="text" id="post_code" name="post_code" class="form-control" style="width: 170px" required <?php if (isset($penpost)) { echo "value='$penpost'";} ?>>
            </p>
            <?php if($ffpost_code=='1') { ?>
<script>
$('#lookup_fieldp').setupPostcodeLookup({
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
    <br>
<select class="form-control" name="changereason" required style="width: 375">
    <option value="">Select update reason...</option>
    <?php if (in_array($hello_name,$Level_8_Access, true)) { ?>
    <option value="Client Cancelled">Client Cancelled</option>
    <?php } ?>
    <option value="Incorrect marital status">Incorrect marital status</option>
    <option value="Incorrect time at residence">Incorrect time at residence</option>
    <option value="Incorrect Client Name">Incorrect client name (1)</option>
    <option value="Incorrect DOB">Incorrect DOB (1)</option>
    <option value="Incorrect email">Incorrect email address (1)</option>
    <option value="Incorrect Client Name 2">Incorrect client name (2)</option>
    <option value="Incorrect DOB 2">Incorrect DOB (2)</option>
    <option value="Incorrect email 2">Incorrect email address (2)</option>
    <option value="Incorrect Contact number">Incorrect phone number(s)</option>
    <option value="Incorrect Contact address">Incorrect address</option>
    <option value="Moved address">Moved address</option>
    <option value="New contact number">New contact number</option>
    <option value="Added Call Recording Lead ID">Added Call Recording Lead ID</option>
    <option value="Added Closer Audit ID">Added Closer Audit ID</option>
    <option value="Added Lead Audit ID">Added Lead Audit ID</option>
    <option value="Added Client Two">Added Client Two</option>
</select>
    <br>
              </div>


    <center>
<button class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
</form>
      </div>
  </div>
  </div>
</div>
    

    <?php } 
    
    
    if(isset($legacy)) {
    
    
$clientone = $pdo->prepare("select date_created, title, firstname, middlename, surname, DaytimeTel, EveningTel, MobileTel, Client_telephone, home_email, office_email, address1, address2, address3, address4, postcode, dob, branch_client_ref, employment_status, status, partner_id, Introducing_branch, smoker, most_recent_lender, next_contact_date FROM assura_client_details WHERE client_id = :searchplaceholder");
$clientone->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
$clientone->execute();
$data2=$clientone->fetch(PDO::FETCH_ASSOC);

$clientonefull=$data2['firstname'] ." ". $data2['surname'];
$partnersearch=$data2['partner_id'];

$clienttwo = $pdo->prepare("select date_created, title, firstname, middlename, surname, DaytimeTel, EveningTel, MobileTel, Client_telephone, home_email, office_email, address1, address2, address3, address4, postcode, dob, branch_client_ref, employment_status, status, Introducing_branch, smoker, most_recent_lender, next_contact_date FROM assura_client_details WHERE client_id = :partner");
$clienttwo->bindParam(':partner', $partnersearch, PDO::PARAM_STR, 12);
$clienttwo->execute();
$tworesult=$clienttwo->fetch(PDO::FETCH_ASSOC);
    ?>
        <div class="container">
        <div class="panel-group">
   <div class="panel panel-primary">
       <div class="panel-heading"><i class="fa fa-edit"></i> Edit Client</div>
      <div class="panel-body">
          
          <form class="AddClient" method="POST" action="php/EditClientSubmit.php?legacy=y">


<div class="col-md-4">

<h3><span class="label label-primary">Client Details (1)</span></h3>
<br>
<input type="hidden" value="<?php echo $search;?>" name="clientid">
<p>
<div class="input-group">
   <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $data2[title]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Policy Info"><button type="button" data-toggle="modal" data-target="#clientpol1" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span></button></a>
   </span>
</div>
</p>
<p>
<div class="input-group">
   <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" value="<?php echo $data2[firstname]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Policy Info"><button type="button" data-toggle="modal" data-target="#clientpol1" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span></button></a>
   </span>
</div>
</p>
<p>
<div class="input-group">
   <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name" value="<?php echo $data2[middlename]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Policy Info"><button type="button" data-toggle="modal" data-target="#clientpol1" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span></button></a>
   </span>
</div>
</p>
<p>
<div class="input-group">
   <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname" value="<?php echo $data2[surname]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Policy Info"><button type="button" data-toggle="modal" data-target="#clientpol1" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input type="text" class="form-control" id="dob" name="dob" value="<?php echo $data2[dob]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" placeholder="Date of Birth" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input type="text" class="form-control" id="smoker" name="smoker" placeholder="Smoker?" value="<?php echo "Smoker? $data2[smoker]"?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Smoker"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="email" id="home_email" name="home_email" placeholder="Home Email" value="<?php echo $data2[home_email]?>"   >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email1pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="email" id="office_email" name="office_email" placeholder="Office Email" value="<?php echo $data2[office_email]?>"   >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email1pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="tel" id="DaytimeTel" name="DaytimeTel" placeholder="Daytime Tel" value="<?php echo $data2[DaytimeTel]?>"  >
   <span class="input-group-btn">
       <button type="button" data-toggle="modal" data-target="#smsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="tel" id="EveningTel" name="EveningTel" placeholder="Evening Tel"value="<?php echo $data2[EveningTel]?>"  >
   <span class="input-group-btn">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModalalt"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="tel" id="MobileTel" name="MobileTel" placeholder="Mobile Tel" value="<?php echo $data2[MobileTel]?>"  >
   <span class="input-group-btn">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModalalt"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="tel" id="Client_telephone" name="Client_telephone" placeholder="Client Telephone" value="<?php echo $data2[Client_telephone]?>"  >
   <span class="input-group-btn">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModalalt"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>
   </span>
</div>
</p>


<br>
<br>
<br>
<br>
<br>

<br>
</div>

<div class="col-md-4">
<?php if (empty($tworesult['firstname'])) { } else{ ?>
<h3><span class="label label-primary">Client Details (2)</span></h3>
<br>
<input type="text" value="<?php echo $partnersearch;?>" name="clientid2">
<p>
<div class="input-group">
   <input type="text" class="form-control" id="title2" name="title2" placeholder="Title" value="<?php echo $tworesult[title]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Policy Info"><button type="button" data-toggle="modal" data-target="#clientpol1" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span></button></a>
   </span>
</div>
</p>
<p>
<div class="input-group">
   <input type="text" class="form-control" id="firstname2" name="firstname2" placeholder="First Name" value="<?php echo $tworesult[firstname]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Policy Info"><button type="button" data-toggle="modal" data-target="#clientpol1" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span></button></a>
   </span>
</div>
</p>
<p>
<div class="input-group">
   <input type="text" class="form-control" id="middlename2" name="middlename2" placeholder="Middle Name" value="<?php echo $tworesult[middlename]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Policy Info"><button type="button" data-toggle="modal" data-target="#clientpol1" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span></button></a>
   </span>
</div>
</p>
<p>
<div class="input-group">
   <input type="text" class="form-control" id="surname2" name="surname2" placeholder="Surname" value="<?php echo $tworesult[surname]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Policy Info"><button type="button" data-toggle="modal" data-target="#clientpol1" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input type="text" class="form-control" id="dob2" name="dob2" placeholder="Date of Birth" value="<?php echo $tworesult[dob]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input type="text" class="form-control" id="dob" name="smoker2" placeholder="Smoker" value="<?php echo "Smoker? $tworesult[smoker]"?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Smoker"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="email" id="home_email2" name="home_email2" placeholder="Home Email" value="<?php echo $tworesult[home_email]?>"   >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email2pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="email" id="office_email2" name="office_email2" placeholder="Work Email" value="<?php echo $tworesult[office_email]?>"   >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email2pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="tel" id="phonenumber" name="DaytimeTel2" placeholder="Daytime Tel" value="<?php echo $tworesult[DaytimeTel]?>"  >
   <span class="input-group-btn">
       <button type="button" data-toggle="modal" data-target="#smsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="tel" id="altnumber" name="EveningTel2" placeholder="Evening Tel" value="<?php echo $tworesult[EveningTel]?>"  >
   <span class="input-group-btn">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModalalt"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="tel" id="altnumber" name="MobileTel2" placeholder="Mobile Tel" value="<?php echo $tworesult[MobileTel]?>"  >
   <span class="input-group-btn">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModalalt"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="tel" id="altnumber" name="Client_telephone2" placeholder="Client Tel" value="<?php echo $tworesult[Client_telephone]?>"  >
   <span class="input-group-btn">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModalalt"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>
   </span>
</div>
</p>


<?php }?>
	</div>

	<div class="col-md-4">


<h3><span class="label label-primary">Contact Details</span></h3>
<br>

<div class="input-group">
   <input class="form-control" type="text" id="address1" name="address1" placeholder="Address 1" value="<?php echo $data2[address1]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 1"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-home"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="text" id="address2" name="address2" placeholder="Address 2" value="<?php echo $data2[address2]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 2"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="text" id="address3" name="address3" placeholder="Address 3" value="<?php echo $data2[address3]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 3"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="text" id="address4" name="address4" placeholder="Address 4" value="<?php echo $data2[address4]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 4"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
   </span>
</div>
</p>

<p>
<div class="input-group">
   <input class="form-control" type="text" id="postcode" name="postcode" placeholder="Post Code" value="<?php echo $data2[postcode]?>"  >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Post Code"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
   </span>
</div>
</p>

<br>
<select class="form-control" name="changereason" required>
    <option value="">Select update reason...</option>
    <option value="Incorrect Client Name">Incorrect client name (1)</option>
    <option value="Incorrect DOB">Incorrect DOB (1)</option>
    <option value="Incorrect email">Incorrect email address (1)</option>
    <option value="Incorrect Client Name 2">Incorrect client name (2)</option>
    <option value="Incorrect DOB 2">Incorrect DOB (2)</option>
    <option value="Incorrect email 2">Incorrect email address (2)</option>
    <option value="Incorrect Contact number">Incorrect phone number(s)</option>
    <option value="Incorrect Contact address">Incorrect address</option>
    <option value="Moved address">Moved address</option>
    <option value="New contact number">New contact number</option>
    <option value="Added Call Recording Lead ID">Added Call Recording Lead ID</option>
    <option value="Added Closer Audit ID">Added Closer Audit ID</option>
    <option value="Added Lead Audit ID">Added Lead Audit ID</option>
    <option value="Added Client Two">Added Client Two</option>
</select>
<br>
<center>
<button class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
</center>
</form>
          
          </div>
   </div>
        </div>
        </div>    
    <?php }
    ?>
      <script>
        document.querySelector('#from1').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Save changes?",
                text: "You will not be able to recover any overwritten data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Complete!',
                        text: 'Client details updated!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No Changes have been submitted", "error");
                }
            });
        });

    </script>
</body>
</html>
