<?php
$fferror=0;
if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$ACTION = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);

$FACTION = filter_input(INPUT_GET, 'FACTION', FILTER_SANITIZE_SPECIAL_CHARS);
$ENEMY_FACTION = filter_input(INPUT_GET, 'ENEMY_FACTION', FILTER_SANITIZE_SPECIAL_CHARS);

if(empty($FACTION)) {
    $FACTION = filter_input(INPUT_POST, 'FACTION', FILTER_SANITIZE_SPECIAL_CHARS);

    
}
if(empty($ENEMY_FACTION)) {
    $ENEMY_FACTION = filter_input(INPUT_POST, 'ENEMY_FACTION', FILTER_SANITIZE_SPECIAL_CHARS);

    
}

$UNIT = filter_input(INPUT_POST, 'UNIT', FILTER_SANITIZE_SPECIAL_CHARS);
$MODELS_TO_FIRE = filter_input(INPUT_POST, 'MODELS_TO_FIRE', FILTER_SANITIZE_SPECIAL_CHARS);
$UNIT_WEAPON = filter_input(INPUT_POST, 'UNIT_WEAPON', FILTER_SANITIZE_SPECIAL_CHARS);
$MOVEMENT = filter_input(INPUT_POST, 'MOVEMENT', FILTER_SANITIZE_SPECIAL_CHARS);
$RANGE_BONUS = filter_input(INPUT_POST, 'RANGE_BONUS', FILTER_SANITIZE_SPECIAL_CHARS);
$TARGET_UNIT = filter_input(INPUT_POST, 'TARGET_UNIT', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL CRM</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/styles/Notices.css" type="text/css" />
    <link href="/img/favicon.ico" rel="icon" type="/image/x-icon" />
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container">
        
        <?php

        if(isset($FACTION) && $ENEMY_FACTION) { ?>
        
        <div class="notice notice-info fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><center><strong>Factions:</strong> <?php echo "$FACTION vs $ENEMY_FACTION" ?>.</center></div>
<?php
        }
        ?>

        <form method="POST" action="Ranged.php?action=1">    
            
            <input type="hidden" name="FACTION" value="<?php echo $FACTION; ?>">
            <input type="hidden" name="ENEMY_FACTION" value="<?php echo $ENEMY_FACTION; ?>">
<?php 

if(isset($FACTION) && $FACTION=='Ultramarines') {
    require_once(__DIR__ . '/views/factions/ultramarines-view.php');
}

elseif(isset($FACTION) && $FACTION=='Chaos Space Marines') {
    require_once(__DIR__ . '/views/factions/csm-view.php');
}


?>
   <div class="col-xs-4">
<?php 

if(isset($ACTION) && $ACTION=='1') {
    require_once(__DIR__ . '/views/results/results-view.php');
}

?>   
   </div>
            
<?php 

if(isset($ENEMY_FACTION) && $ENEMY_FACTION=='Deathguard') {
    require_once(__DIR__ . '/views/enemy_factions/deathguard-view.php');
}

if(isset($ENEMY_FACTION) && $ENEMY_FACTION=='Chaos Space Marines') {
    require_once(__DIR__ . '/views/enemy_factions/chaos_space_marines-view.php');
}

if(isset($ENEMY_FACTION) && $ENEMY_FACTION=='Eldar') {
    require_once(__DIR__ . '/views/enemy_factions/eldar-view.php');
}

if(isset($ENEMY_FACTION) && $ENEMY_FACTION=='Ultramarines') {
    require_once(__DIR__ . '/views/enemy_factions/ultramarines-view.php');
}
?>          
        
           <?php if(isset($FACTION) && $ENEMY_FACTION) { ?>   
        <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-exclamation"></i> Fire!</button>
      <?php } ?>   
    </form>
        
    </div>


</body>
</html>