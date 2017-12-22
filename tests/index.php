<?php
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
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
        <style>
            body, html {
                height: 100%;
                background-repeat: no-repeat;
                //background-image: url("/img/xmas1.jpg");
            }

            .card-container.card {
                max-width: 350px;
                padding: 40px 40px;
            }

            .btn {
                font-weight: 700;
                height: 36px;
                -moz-user-select: none;
                -webkit-user-select: none;
                user-select: none;
                cursor: default;
            }

            .card {
                background-color: #F7F7F7;
                padding: 20px 25px 30px;
                margin: 0 auto 25px;
                margin-top: 50px;
                -moz-border-radius: 2px;
                -webkit-border-radius: 2px;
                border-radius: 2px;
                -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            }

            .profile-img-card {
                width: 96px;
                height: 96px;
                margin: 0 auto 10px;
                display: block;
                -moz-border-radius: 50%;
                -webkit-border-radius: 50%;
                border-radius: 50%;
            }

            .profile-name-card {
                font-size: 16px;
                font-weight: bold;
                text-align: center;
                margin: 10px 0 0;
                min-height: 1em;
            }

            .form-signin .form-control:focus {
                border-color: rgb(104, 145, 162);
                outline: 0;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
            }

            .btn.btn-signin {
                background-color: rgb(104, 145, 162);
                padding: 0px;
                font-weight: 700;
                font-size: 14px;
                height: 36px;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 3px;
                border: none;
                -o-transition: all 0.218s;
                -moz-transition: all 0.218s;
                -webkit-transition: all 0.218s;
                transition: all 0.218s;
            }

            .btn.btn-signin:hover,
            .btn.btn-signin:active,
            .btn.btn-signin:focus {
                background-color: rgb(12, 97, 33);
            }
        </style>
    </head>
    <body>

        <div class="container">
            <div class="card card-container">
                <center><img src="img/bluestone_protect_logo.png" width="250"/></center>
                <p id="profile-name" class="profile-name-card"></p>
                <form class="form-signin" name="form1" method="post" action="<?php echo filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS); ?>">
                    <span id="reauth-email" class="reauth-email"></span>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="login-username" type="text" class="form-control" name="login" value="<?php echo (isset($LOGIN_LOGIN)) ? $LOGIN_LOGIN : $my_access->user; ?>" placeholder="username">                                        
                    </div>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <label for="login-password"></label>
                        <input id="login-password" type="password" class="form-control"  name="password" value="<?php if (isset($LOGIN_PASSWORD)) {
    echo $LOGIN_PASSWORD;
} ?>" placeholder="password">
                    </div>
                    <button class="btn btn-lg btn-primary btn-block btn-signin" name="Submit" type="submit">Sign in</button>
                </form>
                
                
            </div>
            
            <?php
            
            function getRealIpAddr()
{
    if (!empty(filter_input(INPUT_SERVER,'HTTP_CLIENT_IP', FILTER_SANITIZE_SPECIAL_CHARS)))   
    {
      $ip=filter_input(INPUT_SERVER,'HTTP_CLIENT_IP', FILTER_SANITIZE_SPECIAL_CHARS);
    } 
    elseif (!empty(filter_input(INPUT_SERVER,'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_SPECIAL_CHARS)))
    {
      $ip=filter_input(INPUT_SERVER,'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    else
    { 
      $ip=filter_input(INPUT_SERVER,'REMOTE_ADDR', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    return $ip;
}
?>
                <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    
    <?php
getRealIpAddr();
$TRACKED_IP= getRealIpAddr();
if($TRACKED_IP=='81.145.167.66') {
?>
            
            <div class="footer navbar-fixed-bottom">
                <center>         
                    <a class="btn btn-success btn-sm" href="https://www10.landg.com/SAuthGateWeb/login.html?domain=olpc&ut=z&entryPoint=https%3A%2F%2Fwww10.landg.com%2FProtectionPortal%2Fsecure%2FHome" target="_blank">Legal and General</a>
                    <a class="btn btn-success btn-sm" href="https://protection.royallondon.com/extranet/do/rlLogin" target="_blank">Royal London</a> 
                    <a class="btn btn-success btn-sm" href="https://portal.onefamilyadviser.com/Intermediaries/Portal/WebLogin.aspx" target="_blank">One Family</a> 
                    <a class="btn btn-success btn-sm" href="https://www.aviva-for-advisers.co.uk" target="_blank">Aviva</a> 
                    <a class="btn btn-success btn-sm" href="https://login.vitality.co.uk/medical/" target="_blank">Vitality</a>
                    <a class="btn btn-success btn-sm" href="mailto:michael@adl-crm.uk?Subject=ADL"> <strong>ADL Email Support</strong> </a>
                </center>
            </div>            
<?php } ?>
        </div>

        <script type="text/javascript">
            window.cookieconsent_options = {"message": "This website uses cookies to ensure you get the best experience on our website", "dismiss": "Got it!", "learnMore": "More info", "link": null, "theme": "dark-bottom"};
        </script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>

<?php require_once(__DIR__ . '/app/Holidays.php'); ?>
</html>                                		
