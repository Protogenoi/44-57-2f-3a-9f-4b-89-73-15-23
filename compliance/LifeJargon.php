<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');

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

$q=1;
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>ADL | Life Insurance Jargon</title>
                <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
        <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
<?php require_once(__DIR__ . '/../includes/NAV.php'); ?> 
        
        <div class="container-fluid"><br>
            
                            <div class="row">
            <?php require_once(__DIR__ . '/includes/LeftSide.html'); ?> 
            
            <div class="col-9">
            
  <div class="card">


    <h4 class="card-header card-info">Legal and General: Life cover jargon buster.</h4>


<!-- Card Block -->
<div class="card-block">
<p class="card-text">Do you know the difference between Decreasing Term Assurance with Waiver of Premium or Level Term Assurance with Critical Illness Cover?<br>
In the table below we've listed a number of life insurance related terms and an explanation for each.</p>
</div>

<!-- List Group -->
<ul class="list-group list-group-flush">
    <li class="list-group-item"><strong>Accidental Death Benefit:</strong> Whilst we process your application we give you free Accidental Death Benefit. It covers you if you die within 90 days following an accident. The pay out will either be the amount you applied for, including all concurrent applications, or £300,000, whichever is lowest.</li>
    <li class="list-group-item"><strong>Cover:</strong> The protection provided by your policy.</li>
    <li class="list-group-item"><strong>Critical Illness Cover (CIC):</strong> CIC pays out your chosen amount of cover if you're diagnosed with one of the 40 conditions we cover. It also pays out if you are terminally ill and you meet our definition, except in the last 12 months of the policy.</li>
    <li class="list-group-item"><strong>Decreasing Term Assurance (DTA):</strong> DTA pays out a lump sum if you die during the policy term. The level of cover reduces over the term, and is typically taken out to help protect a repayment mortgage.</li>
    <li class="list-group-item"><strong>Guaranteed Insurability Option (GIO):</strong> GIO lets you increase the amount of cover you're insured for without the need to provide any further medical evidence. You can do this on certain life events..</li>
    <li class="list-group-item"><strong>Guaranteed Premiums:</strong> This means that your premiums are guaranteed throughout the term of your policy, unless you alter your cover.</li>
    <li class="list-group-item"><strong>Joint Life:</strong> You can take out a plan so it covers you and another person. The policy will pay out only once following a claim and then ends.</li>
    <li class="list-group-item"><strong>Level Term Assurance (LTA):</strong> LTA may also be referred to as life insurance, life cover or term assurance. It pays out a lump sum on your death if you die during the policy term.</li>
    <li class="list-group-item"><strong>Policy Documents:</strong> These are the documents we send to you once your policy has started. This includes the Policy Schedule and Policy Terms and Conditions with details of the cover and premium.</li>
    <li class="list-group-item"><strong>Premium:</strong> The amount that you'll regularly pay us for providing cover. You can pay your premiums monthly or annually. If you pay annually you'll get a 4% discount.</li>
    <li class="list-group-item"><strong>Reviewable Premiums:</strong> If you include CIC you can choose reviewable premiums. This means that your premiums say the same for the first five years and are then reviewed every five years after. Premiums could go up or down following a review.</li>
    <li class="list-group-item"><strong>Terminal Illness Cover:</strong> Terminal Cover is provided at no extra cost and means that your policy could pay out upon diagnosis of a terminal illness.</li>

</ul>

</div>        
          
   </div>
                            </div>
        </div>        
        
            <script src="/js/jquery/jquery-3.0.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>    
    </body>
</html>
