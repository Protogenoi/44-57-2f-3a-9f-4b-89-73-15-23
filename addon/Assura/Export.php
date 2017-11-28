<?php 
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 * 
*/  

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/Access_Levels.php');
include('../../includes/adl_features.php');

      if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;
} 
?>

<!DOCTYPE html>
<html lang="en">
<title>Assura Export Data</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
        
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

<script>
  $(function() {
    $( "#datefrom" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#dateto" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#datefrom3" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>

	</head>
	<body>
            
            <?php include('../../includes/navbar.php'); 
                    include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/app/analyticstracking.php'); 
    
    }
            ?>

<div class="container">

<div class="column-left">

<form class="AddClient" action="/export/Assuraexportclientpolicies.php" method="post">
<h3>Export Business Register</h3>

<p>
<label for="Select" required>Select Policies that</label>
<select name="Select">
<option value="submitted_date">Were Added</option>
<option value="sale_date">Were Sold</option>
</select>
</p>
<br>

<p>
<label for="datefrom">From:</label>
<input type="text" id="datefrom" name="datefrom" value="<?php if(isset($datefrom)) { echo $datefrom; } ?>" required>
</p>

<p>
<label for="dateto">To:</label>
<input type="text" id="dateto" name="dateto" value="<?php if(isset($dateto)) { echo $dateto; } ?>" required>
</p>

<p>
<button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-save"></span> Export</button>
</p>
</form>

</div>


</div>
</body>

</html>
