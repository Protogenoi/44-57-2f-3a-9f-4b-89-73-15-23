<?php
if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$FACTION = filter_input(INPUT_GET, 'FACTION', FILTER_SANITIZE_SPECIAL_CHARS);
$ENEMY_FACTION = filter_input(INPUT_GET, 'ENEMY_FACTION', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>Main</title>
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
        
<div class="col-md-12">
    <div class="row">
                
        <form method="GET" action="">
            
            <div class="form-group">
                <label class="col-sm-1 control-label" style="text-align:left;" for="FACTION">Your Faction:</label>
                <div class="col-sm-3">
                    <select class="form-control" name="FACTION" id="FACTION" style="width: 170px" required">
                        <option value="Ultramarines" <?php if(isset($FACTION) && $FACTION=='Ultramarines') { echo "selected"; } ?> >Ultramarines</option>
                        <option value="Chaos Space Marines" <?php if(isset($FACTION) && $FACTION=='Chaos Space Marines') { echo "selected"; } ?> >Chaos Space Marines</option>
                    </select>
                </div>     
            </div>
            
            <div class="form-group">
                <label class="col-sm-1 control-label" style="text-align:left;" for="ENEMY_FACTION">Enemy Faction:</label>
                <div class="col-sm-3">
                    <select class="form-control" name="ENEMY_FACTION" id="ENEMY_FACTION" style="width: 170px" required>
                        <option value="Deathguard" <?php if(isset($ENEMY_FACTION) && $ENEMY_FACTION=='Deathguard') { echo "selected"; } ?> >Deathguard</option>
                        <option value="Chaos Space Marines" <?php if(isset($ENEMY_FACTION) && $ENEMY_FACTION=='Chaos Space Marines') { echo "selected"; } ?> >Chaos Space Marines</option>
                        <option value="Eldar" <?php if(isset($ENEMY_FACTION) && $ENEMY_FACTION=='Eldar') { echo "selected"; } ?> >Eldar</option>
                        <option value="Ultramarines" <?php if(isset($ENEMY_FACTION) && $ENEMY_FACTION=='Ultramarines') { echo "selected"; } ?> >Ultramarines</option>

                    </select>
                </div>     
            </div>
            
            <div class="form-group">                
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Go!</button>
                </div>
            </div>            
            
        </form>
            </div>
             
        
        <div class="col-md-12">
            <div class="row">
            <div class="col-md-2"><a href="#" class="btn btn-default btn-lg"><i class="fa fa-arrow-right"></i> Movement</a></div>
            <div class="col-md-2"><a href="#" class="btn btn-default btn-lg"><i class="fa fa-magic"></i> Psychic</a></div>
            <div class="col-md-2"><a href="Ranged.php<?php if(isset($FACTION)) { echo "?FACTION=$FACTION"; } ?><?php if(isset($FACTION)) { echo "&ENEMY_FACTION=$ENEMY_FACTION"; } ?>" target="_blank" class="btn btn-default btn-lg"><i class="fa fa-crosshairs"></i> Shooting</a></div>
            <div class="col-md-2"><a href="#" class="btn btn-default btn-lg"><i class="fa fa-fast-forward"></i> Charge</a></div>
            </div>
        </div>
    </div>
 </div>  

</body>
</html>
