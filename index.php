<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 

$my_access = new Access_user(false);
if (isset($_GET['activate']) && isset($_GET['ident'])) { 
	$my_access->auto_activation = true; 
	$my_access->activate_account($_GET['activate'], $_GET['ident']); 
}
if (isset($_GET['validate']) && isset($_GET['id'])) { 
	$my_access->validate_email($_GET['validate'], $_GET['id']);
}
if (isset($_POST['Submit'])) {
	$my_access->save_login = (isset($_POST['remember'])) ? $_POST['remember'] : "no"; 
	$my_access->count_visit = false; 
	$my_access->login_user($_POST['login'], $_POST['password']); 
} 
$error = $my_access->the_msg; 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ADL CRM | Login</title>
        <link rel="stylesheet" href="/styles/loginpage.css" type="text/css" />
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
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
        
    <?php
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php');
    ?>        
    <!--<script src="/js/jquery.snow.js"></script>
    <script>
    $(document).ready( function(){
        $.fn.snow();
    });
    </script>-->
        <div class="container">          
            
            <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                
                <div class="panel panel-default" >
                    <div class="panel-heading">
                        <div class="panel-title">ADL Developer Login</div>
                    </div>  
                    
                    <div style="padding-top:30px" class="panel-body" >
                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12">
                            
                        </div>
                        <form id="loginform" class="form-horizontal" role="form" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="login-username" type="text" class="form-control" name="login" value="<?php echo (isset($_POST['login'])) ? $_POST['login'] : $my_access->user; ?>" placeholder="username">                                        
                            </div>
                            
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <label for="login-password"></label>
                                <input id="login-password" type="password" class="form-control"  name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" placeholder="password">
                            </div>
                            
                            <div style="margin-top:10px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <center>
                                        <input type="submit" value="Login" id="submit" name="Submit" class="btn btn-success" />
                                    </center>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
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