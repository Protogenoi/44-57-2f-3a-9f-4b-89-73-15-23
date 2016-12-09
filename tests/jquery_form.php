<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1); 
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

    $Level_2_Access = array("Jade");

if (in_array($hello_name,$Level_2_Access, true)) {
    
    header('Location: ../Life/Financial_Menu.php'); die;

}

 include('../includes/Access_Levels.php');

if (in_array($hello_name,$Agent_Access, true)) {
    
    header('Location: ../Life/LifeDealSheet.php'); die;

}

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: ../index.php?AccessDenied'); die;

}

include('../includes/adlfunctions.php');

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="img/favicon.ico" rel="icon" type="image/x-icon" />

</style>
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>
<body>
    
    <?php 
    include('../includes/navbar.php');
     
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
?>    
<form>    
        <input type="text" name="test">
        <input type="text" name="test2">
        <input type="text" name="test3">
        <button type="submit">Submit</button>
    </form>

    
<script> 
    
        // Attach an event for when the user submits the form
        $('form').on('submit', function(event) {
            
            // Prevent the page from reloading
            event.preventDefault();
            
var test = $(this).find('[name=test]').val();
var test2 = $(this).find('[name=test2]').val();
var test3 = $(this).find('[name=test3]').val();
console.log(test);
console.log(test2);
console.log(test3);

        });
  
    </script>

        
    </div>
    
    <div class="footer navbar-fixed-bottom"><center><?php adl_version();?> </center></div>
    
    
</body>
</html>
