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

require_once(__DIR__ . '../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '../../includes/adl_features.php');
require_once(__DIR__ . '../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($ffintemails=='0') {
        
        header('Location: ../Emails.php'); die;
    }

?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
<title>ADL | Send Internal Email</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" language="javascript" src="/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
<link rel="stylesheet" href="/resources/lib/summernote-master/dist/summernote.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>
<body>

<?php include('../includes/navbar.php');  ?>
  <div class="container">

      <?php email_sent_catch(); ?>

<div class="panel panel-primary">
  <div class="panel-heading">Send Internal Email</div>
   <div class="panel-body">
<fieldset>
<form method="post" action="php/SendInternal.php" enctype="multipart/form-data" class="form-horizontal">

<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>
  <div class="col-md-4">
<select name="email" class="form-control" required>
<option value="nick@thereviewbureau.com">Nick</option>
<option value="matt@thereviewbureau.com">Matt</option>
<option value="leigh@thereviewbureau.com">Leigh</option>
<option value="michael@thereviewbureau.com">Michael</option>
<option value="carys@thereviewbureau.com">Carys</option>
<option value="info@thereviewbureau.com">Info</option>
<option value="idd@thereviewbureau.com">IDD</option>
<option value="idd@thefinancialbureau.com">Tina</option>
</select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="subject">Subject:</label>  
  <div class="col-md-4">
  <input id="subject" name="subject" id="subject" placeholder="" class="form-control input-md" type="text" required>
  </div>
</div>

<div class="form-group">
  <div class="col-md-12">                     
    <textarea class="form-control summernote" id="message" name="message"></textarea>
  </div>
</div>


<input name="recipient" id="recipient" type="hidden" />

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload">Add attachment</label>
  <div class="col-md-4">
    <input id="fileToUpload" name="fileToUpload" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload2">Add attachment (2)</label>
  <div class="col-md-4">
    <input id="fileToUpload2" name="fileToUpload2" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload3">Add attachment (3)</label>
  <div class="col-md-4">
    <input id="fileToUpload3" name="fileToUpload3" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload4">Add attachment (4)</label>
  <div class="col-md-4">
    <input id="fileToUpload4" name="fileToUpload4" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload5">Add attachment (5)</label>
  <div class="col-md-4">
    <input id="fileToUpload5" name="fileToUpload5" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload6">Add attachment (6)</label>
  <div class="col-md-4">
    <input id="fileToUpload6" name="fileToUpload6" class="input-file" type="file">
  </div>
</div>

<br>
<br>
 
<div class="form-group">
  <label class="col-md-4 control-label" for="Send Email"></label>
  <div class="col-md-4">
<button type="submit" class="btn btn-warning "><span class="glyphicon glyphicon-envelope"></span> Send Email</button>
  </div>
</div>
  
  
  
  
</form>
</fieldset>

</div>
</div>

    </div>


<script type="text/javascript" src="/resources/lib/summernote-master/dist/summernote.js"></script>

  <script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200
      });


    });
  </script>
</body>
</html>
