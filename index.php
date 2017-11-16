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

require_once(__DIR__ . '/classes/access_user/access_user_class.php');

$LOGIN_ACTIVATE = filter_input(INPUT_GET, 'activate', FILTER_SANITIZE_SPECIAL_CHARS);
$LOGIN_IDENT = filter_input(INPUT_GET, 'ident', FILTER_SANITIZE_SPECIAL_CHARS);
$LOGIN_VALIDATE = filter_input(INPUT_GET, 'validate', FILTER_SANITIZE_SPECIAL_CHARS);

$LOGIN_ID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

$LOGIN_REMEMBER = filter_input(INPUT_POST, 'remember', FILTER_SANITIZE_SPECIAL_CHARS);
$LOGIN_LOGIN = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
$LOGIN_SUBMIT = filter_input(INPUT_POST, 'Submit', FILTER_SANITIZE_SPECIAL_CHARS);
$LOGIN_PASSWORD = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

$my_access = new Access_user(false);
if (isset($LOGIN_ACTIVATE) && isset($LOGIN_IDENT)) { 
	$my_access->auto_activation = true; 
	$my_access->activate_account($LOGIN_ACTIVATE, $LOGIN_IDENT); 
}
if (isset($LOGIN_VALIDATE) && isset($LOGIN_ID)) { 
	$my_access->validate_email($LOGIN_VALIDATE, $LOGIN_ID);
}
if (isset($LOGIN_SUBMIT)) {
	$my_access->save_login = (isset($LOGIN_REMEMBER)) ? $LOGIN_REMEMBER : "no"; 
	$my_access->count_visit = false; 
	$my_access->login_user($LOGIN_LOGIN, $LOGIN_PASSWORD); 
} 
$error = $my_access->the_msg; 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ADL CRM | Login</title>
        <link rel="stylesheet" href="/resources/templates/ADL/loginpage.css" type="text/css" />
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
        <style>
#submit.disabled:hover {
    background-color: #999;
    text-shadow: none;
    box-shadow: none;
    cursor: not-allowed;
}
        </style>
    </head>
    <body>
        
    <?php require_once(__DIR__ . '/php/analyticstracking.php'); ?>        
        <div class="container">          
            
            <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                
                <div class="panel panel-default" >
                    <div class="panel-heading">
                        <div class="panel-title">ADL Developer Login</div>
                    </div>  
                    
                    <div style="padding-top:30px" class="panel-body" >
                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12">
                            
                        </div>
                        <form id="loginform" class="form-horizontal" role="form" name="form1" method="post" action="<?php echo filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS); ?>">
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="login-username" type="text" class="form-control" name="login" value="<?php echo (isset($LOGIN_LOGIN)) ? $LOGIN_LOGIN : $my_access->user; ?>" placeholder="username">                                        
                            </div>
                            
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <label for="login-password"></label>
                                <input id="login-password" type="password" class="form-control"  name="password" value="<?php if (isset($LOGIN_PASSWORD)) echo $LOGIN_PASSWORD; ?>" placeholder="password">
                            </div>
                            
                            <div style="margin-top:10px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <center>
                                        <input type="submit" value="Login" id="submit" name="Submit" class="btn btn-success" />
                                    </center>
                                </div>
                            </div>
                        </form>
                                             
                        
                    </div>
                    </div>
                </div>
            </div>
            <div class="footer navbar-fixed-bottom"><center>
                  <a class="btn btn-success btn-sm" href="https://www10.landg.com/SAuthGateWeb/login.html?domain=olpc&ut=z&entryPoint=https%3A%2F%2Fwww10.landg.com%2FProtectionPortal%2Fsecure%2FHome" target="_blank">Legal and General</a>
                    <a class="btn btn-success btn-sm" href="https://protection.royallondon.com/extranet/do/rlLogin" target="_blank">Royal London</a> 
                    <a class="btn btn-success btn-sm" href="https://portal.onefamilyadviser.com/Intermediaries/Portal/WebLogin.aspx" target="_blank">One Family</a> 
                    <a class="btn btn-success btn-sm" href="https://www.aviva-for-advisers.co.uk" target="_blank">Aviva</a> 
                    <a class="btn btn-success btn-sm" href="https://login.vitality.co.uk/medical/" target="_blank">Vitality</a>
                    <a class="btn btn-success btn-sm" href="mailto:michael@adl-crm.uk?Subject=ADL"> <strong>ADL Email Support</strong> </a>
                </center></div>            
            
        </div>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
        <script src="js/utilities.js"></script>
        <script src="js/index-disable-submit.js"></script>
        
<!-- Begin Cookie Consent plugin by Silktide - //silktide.com/cookieconsent -->
<script type="text/javascript">
    window.cookieconsent_options = {"message":"This website uses cookies to ensure you get the best experience on our website","dismiss":"Got it!","learnMore":"More info","link":null,"theme":"dark-bottom"};
</script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>
<!-- End Cookie Consent plugin -->
    </body>
</html>                                		