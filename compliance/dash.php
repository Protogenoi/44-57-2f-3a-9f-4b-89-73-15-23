<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../classes/database_class.php');
require_once(__DIR__ . '../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$AGENCY = filter_input(INPUT_GET, 'AGENCY', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE) && $AGENCY) {

    switch ($AGENCY) {
        case "TRB":
            $AGENCY_NAME = "The Review Bureau";
            break;
        case "PFP":
            $AGENCY_NAME = "Protect Family Plans";
            break;
        case "PLL":
            $AGENCY_NAME = "Protected Life Ltd";
            break;
        case "WI":
            $AGENCY_NAME = "We Insure";
            break;
        case "TFAC":
            $AGENCY_NAME = "The Financial Assessment Centre";
            break;
        case "APM":
            $AGENCY_NAME = "Assured Protect and Mortgages";
            break;
        default:
            $AGENCY_NAME = "Not Selected";
    }
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
    <title>ADL | Compliance Dash</title>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
        <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
<?php require_once(__DIR__ . '/../includes/NAV.php'); ?> 
        <br>
        <div class="container-fluid">


            <div class="row">
                <!-- Left Column -->
                <div class="col-3">

                    <div id="faq" role="tablist" aria-multiselectable="true">
                        <div class="card-header p-b-0">
                            <h5 class="card-title"><i class="fa fa-random" aria-hidden="true"></i> Overview</h5>
                        </div> 
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action">Statistics</a>
                            <a href="#" class="list-group-item list-group-item-action">Compliance Rating</a>
                            <a href="#" class="list-group-item list-group-item-action">Test Results</a>
                            <a href="#" class="list-group-item list-group-item-action">Uploads</a>
                        </div>    

                        <div class="card-header p-b-0">
                            <h5 class="card-title"><i class="fa fa-random" aria-hidden="true"></i> Agencies</h5>
                        </div>
                         <div class="list-group list-group-flush">
                             <?php if (in_array($hello_name, $TRB_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
                            <a href="?AGENCY=TRB&EXECUTE=1" class="list-group-item list-group-item-action">The Review Bureau</a>
                             <?php } 
                            if (in_array($hello_name, $PFP_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
                            <a href="?AGENCY=PFP&EXECUTE=1" class="list-group-item list-group-item-action">Protect Family Plans</a>
                            <?php } 
                            if (in_array($hello_name, $PLL_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
                            <a href="?AGENCY=PLL&EXECUTE=1" class="list-group-item list-group-item-action">Protected Life Ltd</a>
                            <?php } 
                            if (in_array($hello_name, $WI_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
                            <a href="?AGENCY=WI&EXECUTE=1" class="list-group-item list-group-item-action">We Insure</a>
                            <?php } 
                            if (in_array($hello_name, $TFAC_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
                            <a href="?AGENCY=TFAC&EXECUTE=1" class="list-group-item list-group-item-action">The Financial Assessment Centre</a>
                            <?php } 
                            if (in_array($hello_name, $APM_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
                            <a href="?AGENCY=APM&EXECUTE=1" class="list-group-item list-group-item-action">Assured Protect and Mortgages</a>
                            <?php } ?>
                        </div> 


                    </div>				
                </div><!--/Left Column-->

<?php if (isset($EXECUTE)) { ?>

                    <!-- Center Column -->
                    <div class="col-6">

                        <!-- Alert -->
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <center><strong><?php if(isset($AGENCY)) { echo $AGENCY_NAME; } ?></strong></center><br> This is your dashboard, it can show you what you have done or what needs to be done for this week!
                        </div>		

                        <?php if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
                        <!-- Articles -->
                        <div class="row">
                            <article class="col-12">
                                <h2>Life Insurance</h2>
                                <p>Put your knowledge to the test with this Life insurance test!</p>
                                
                                    <p><a href="tests/Life.php?AGENCY=<?php echo $AGENCY; ?>" class="btn btn-outline-success"><i class="fa fa-graduation-cap"></i> Insurance Test</a>
                                    <a href="Life.php?AGENCY=<?php echo $AGENCY; ?>" class="btn btn-outline-info"><i class="fa fa-search"></i> View Test Results</a></p>
                                
                                <br>
                               
                                <p><a href="tests/Protection.php?AGENCY=<?php echo $AGENCY; ?>" class="btn btn-outline-success"><i class="fa fa-graduation-cap"></i> Protection Test</a>
                                <a href="Protection.php?AGENCY=<?php echo $AGENCY; ?>" class="btn btn-outline-info"><i class="fa fa-search"></i> View Test Results</a></p>
                                
                                <br>
                                <p class="pull-right"><a href="guides/LifeJargon.php?EXECUTE=1&AGENCY=<?php echo $AGENCY; ?>" class="btn btn-outline-info"><i class="fa fa-question-circle"></i> Jargon Buster</a></p>
                              
                            </article>
                        </div>
                        <hr>
                        <div class="row">
                            <article class="col-12">
                                <h2>Data Protection</h2>
                                <p>Brush up on your knowledge for Data Protection.</p>
                                <p><button class="btn btn-outline-primary">Read More</button></p>
                                <p class="pull-right"><span class="tag tag-default">keyword</span> <span class="tag tag-default">tag</span> <span class="tag tag-default">post</span></p>
                              
                            </article>
                        </div>
                        <hr>      
                        <div class="row">
                            <article class="col-12">
                                <h2>Complaints</h2>
                                <p>Learn how to deal with client complaints professionally.</p>
                                <p><button class="btn btn-outline-danger">Read More</button></p>
                                <p class="pull-right"><span class="tag tag-default">keyword</span> <span class="tag tag-default">tag</span> <span class="tag tag-default">post</span></p>
                               
                            </article>
                        </div>
                        
                        <div class="row">
                            <article class="col-12">
                                <h2>Vulnerable Clients</h2>
                                <p>Learn how to deal with vulnerable clients needs/requirements.</p>
                                <p><button class="btn btn-outline-danger">Read More</button></p>
                                <p class="pull-right"><span class="tag tag-default">keyword</span> <span class="tag tag-default">tag</span> <span class="tag tag-default">post</span></p>
                              
                            </article>
                        </div>                        

 <div class="row">
                            <article class="col-12">
                                <h2>Money Laundering</h2>
                                <p>Make cash quick and easy!</p>
                                <p><button class="btn btn-outline-danger">Read More</button></p>
                                <p class="pull-right"><span class="tag tag-default">keyword</span> <span class="tag tag-default">tag</span> <span class="tag tag-default">post</span></p>
                               
                            </article>
                        </div>     

                        
                        <hr>
                    </div><!--/Center Column-->


                    <!-- Right Column -->
                    <div class="col-3">

                        <!-- Text Panel -->
                        <div class="card">
                            <div class="card-header p-b-0">
                                <h5 class="card-title">
                                    <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                    Call Recordings
                                </h5>
                            </div>
                            <div class="card-block">
                                <p class="card-text">Recording compliance grades for this month.</p>
                                 <center><div class="btn-group btn-group" role="group">
                                   
                                    <button type="button" class="btn btn-secondary bg-success">Green (7)</button>
                                    <button type="button" class="btn btn-secondary bg-warning">Amber (1)</button>
                                    <button type="button" class="btn btn-secondary bg-danger">Red (2)</button>
                                   
                                </div> </center>
                            </div>
                        </div>	

                        <!-- Progress Bars -->
                        <div class="card">
                            <div class="card-header p-b-0">
                                <h5 class="card-title">
                                    <i class="fa fa-tachometer" aria-hidden="true"></i> 
                                    Statistics
                                </h5>
                            </div>
                            <div class="card-block">

                                <div class="text-center" id="progress-caption-1">Sales &hellip; 25%</div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="text-center" id="progress-caption-1">Standard Policies &hellip; 50%</div>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="text-center" id="progress-caption-1">CIC Policies &hellip; 75%</div>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="text-center" id="progress-caption-1">CFO/Lapsed &hellip; 100%</div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                                                <div class="text-center" id="progress-caption-1">Cancel Rate &hellip; 75%</div>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                    </div><!--/Right Column -->
<?php } } ?>
            </div>
        </div>
        <!--/container-fluid-->

        <footer>

            <div class="small-print">
                <div class="container">
                    <p><a href="#">Terms &amp; Conditions</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact</a></p>
                    <p>Copyright &copy; ADL CRM 2017 </p>
                </div>
            </div>
        </footer>

        <script src="/js/jquery/jquery-3.0.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>

        <script>
            // Initialize tooltip component
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })

            // Initialize popover component
            $(function () {
                $('[data-toggle="popover"]').popover()
            })
        </script> 

        <!-- Placeholder Images -->
        <script src="js/holder.min.js"></script>

    </body>

</html>
