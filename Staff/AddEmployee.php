<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');
include('../includes/Access_Levels.php');
include('../includes/adlfunctions.php');

if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: ../index.php?AccessDenied'); die;

}

    if($ffanalytics=='1') {
    
    include('../php/analyticstracking.php'); 
    
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Add Employee</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/styles/PostCode.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script>
  $(function() {
    $( "#dob" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:-0"
        });
  });
    $(function() {
    $( "#start" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:-0"
        });
  });
  </script> <?php
  if($ffpost_code=='1') { 
                include('../includes/ADL_PDO_CON.php');     
                
            $PostcodeQuery = $pdo->prepare("select api_key from api_keys WHERE type ='PostCode' limit 1");
            $PostcodeQuery->execute()or die(print_r($query->errorInfo(), true));
            $PDre=$PostcodeQuery->fetch(PDO::FETCH_ASSOC);
            $PostCodeKey=$PDre['api_key'];       
    
    
    ?>

<script src="/js/jquery.postcodes.min.js"></script>

<?php }  ?>
</head>
<body>
    
    <?php 
    include('../includes/navbar.php');
     
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
?> 
    <br>
    <div class="container">
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-user-plus"></i> Add Employee</div>
                <div class="panel-body">
          
          <form class="AddClient" id="AddProduct" action="php/AddEmployeeSubmit.php?add=1" method="POST" autocomplete="off">
 
        <div class="col-md-4">
            
<h3><span class="label label-info">Employee Details</span></h3>
<br>
  
            <p>
                <label for="start">Start Date:</label>
                <input type="text" id="start" name="start" class="form-control" style="width: 170px" value="<?php echo $date = date('Y-m-d');?>" required>
            </p>

            <p>
<div class="form-group">
  <label for="title">Title:</label>
  <select class="form-control" name="title" id="title" style="width: 170px" required>
 <option value="">Select...</option>
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
                <input type="text" id="first_name" name="first_name" class="form-control" style="width: 170px" required>
            </p>
            <p>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" style="width: 170px" required>
            </p>
            <p>
                <label for="dob">Date of Birth:</label>
                <input type="text" id="dob" name="dob" class="form-control" style="width: 170px" required>
            </p>
            
            <p>
                <label for="ni_num">NI:</label>
                <input type="text" id="ni_num" name="ni_num" class="form-control" style="width: 170px" pattern="[A-Za-z0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[a-zA-Z]{1}" title="Correct format JH-55-55-55-X" placeholder="JH-55-55-55-X">
            </p>
            
                        <p>
                <label for="position">Position:</label>
                <input type="text" id="position" name="position" class="form-control" style="width: 170px">
            </p>
            
            <p>
<div class="form-group">
  <label for="id">ID Provided:</label>
  <select class="form-control" name="id" id="id" style="width: 170px">
 <option value="">Select...</option>
                    <option value="1">Passport Number</option>
                    <option value="2">Driving Licence Number</option>
                    <option value="3">Bank Card Check</option>
  </select>
</div>
            </p>         
                        <p>
                <label for="id_details">ID Details:</label>
                <input type="text" id="id_details" name="id_details" class="form-control" style="width: 170px">
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
                <input type="tel" id="phone_number" name="phone_number" class="form-control" style="width: 170px" required pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number">
            </p>
            <p>
                <label for="alt_number">Alt Number:</label>
                <input type="tel" id="alt_number" name="alt_number" class="form-control" style="width: 170px" pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number">
            </p>
            
                        <p>
                <label for="email">Email:</label>
                <input type="email" id="email" class="form-control" style="width: 170px" name="email">
            </p>
<br>
            <?php if($ffpost_code=='1') { ?>
            <div id="lookup_field"></div>
            <?php } 
            
            if($ffpost_code=='0') { ?>
            
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
                <input type="text" id="address3" name="address3 class="form-control" style="width: 170px"">
            </p>
            <p>
                <label for="town">Post Town:</label>
                <input type="text" id="town" name="town" class="form-control" style="width: 170px">
            </p>
            <p>
                <label for="post_code">Post Code:</label>
                <input type="text" id="post_code" name="post_code" class="form-control" style="width: 170px" required>
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
</div>
              
         <div class="col-md-4">
              <p>
                
<h3><span class="label label-info">Emergency Details</span></h3>
<br>
            </p>  
            
                <p>
                <label for="full_name">Contact Name:</label>
                <input type="text" id="full_name" name="full_name" class="form-control" style="width: 170px" required>
            </p>    
            
            <p>
                <label for="tel">Contact Number:</label>
                <input type="tel" id="tel" name="tel" class="form-control" style="width: 170px" required pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number">
            </p>
            
                            <p>
                <label for="relationship">Relationship:</label>
                <input type="text" id="first_name" name="relationship" class="form-control" style="width: 170px" required>
            </p> 

  <label for="Address">Address</label>
                   
    <textarea class="form-control" id="Address" name="Address"></textarea>            
     
  <label for="medical">Medical Conditions</label>
                   
  <textarea class="form-control" id="medical" name="medical" placeholder="Any conditions if so, what? And any treatment/medication required? Including any allergies"></textarea>

    <br>
                      
        </div>             
              
    <br>
    <br>
    <center>
        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Employee</button></center>
</form>

          
      </div>
    </div>
          </div>
    </div>
    

</body>
</html>
