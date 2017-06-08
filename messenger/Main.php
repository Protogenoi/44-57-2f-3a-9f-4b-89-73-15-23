<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$Level_2_Access = array("Jade");

if (in_array($hello_name, $Level_2_Access, true)) {

    header('Location: ../Life/Financial_Menu.php');
    die;
}

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/../classes/database_class.php');


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

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /index.php?AccessDenied');
    die;
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
    <title>ADL | Messenger Centre</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
     <link rel="stylesheet" href="/summernote-master/dist/summernote.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/../includes/navbar.php'); ?> 

    <div class="container">
        
        <div class="col-xs-12 .col-md-8">

            <div class="row">
                <div class="twelve columns">
                    <ul class="ca-menu">

                        <?php if (in_array($hello_name, $Level_3_Access, true)) { ?>
                            <li>
                                <a data-toggle="modal" data-target="#myModal">
                                    <span class="ca-icon"><i class="fa fa-send-o"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Send<br/> Message</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                            
                </div>
            </div>
        </div>

        <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send a message</h4>
      </div>
      <div class="modal-body">
          <p>
              

    <form action="php/msg.php?EXECUTE=1" method="POST">
<div class="form-group">
 <select class="form-control" name="MSG_TO" id="MSG_TO">
     <option value="">Select Agent...</option>
 </select>
</div>

  <div class="form-group">
    <label for="MSG">Message:</label>
    <textarea id="notes" name="MSG" id="message" class="summernote" id="contents" title="Contents" maxlength="2000" required></textarea>
</div>
 
        <?php
        
        if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
        
          <div class="form-group">
    <label for="COMPANY_ENTITY">Company:</label>
    <select class="form-control" name='COMPANY_ENTITY'>
        <option value='The Review Bureau'>The Review Bureau</option>
        <option value='Protect Family Plans'>Protect Family Plans</option>
        <option value='Protected Life Ltd'>Protected Life Ltd</option>
        <option value='We Insure'>We Insure</option>
        <option value='The Financial Assessment Centre'>The Financial Assessment Centre</option>
        <option value='Assured Protect and Mortgages'>Assured Protect and Mortgages</option>
    </select>
  </div>
 
            
      <?php  }
        
        ?>
 
        <button type="submit" class="btn btn-success"><i class="fa fa-send-o"></i> Send</button>
</form>              
              
          </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
        
        <?php
        
        $query = $pdo->prepare("SELECT
            messenger_sent_by,
            messenger_msg,
            messenger_date,
            messenger_id
            FROM
    messenger
    WHERE
    messenger_status='Unread'
    AND messenger_to=:HELLO");
        $query->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
        $query->execute();
                if ($query->rowCount() > 0) { ?> 
                    
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Sender</th>
                                        <th>Message</th>
                                        <th>Dismiss</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Sender</th>
                                        <th>Message</th>
                                        <th>Dismiss</th>
                                    </tr>
                                </tfoot>                    
        
                    <?php
                    while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                        
                        $NOTE=html_entity_decode($result['messenger_msg']);


                        echo "<tr><td>" . $result['messenger_date'] . "</td>";
                        echo "<td>" . $result['messenger_sent_by'] . "</td>";
                        echo "<td>$NOTE</td>";
                        echo "<td><a href='php\msg.php?EXECUTE=2&MID=".$result['messenger_id']."'><i class='fa fa-check-circle-o'></i></a></td>";
                        echo "</tr>";
                    }
            ?> </table>  <?php  } 
         ?>
                               

     
    </div>
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
                      <script type="text/JavaScript">
                                    var $select = $('#MSG_TO');
                                    $.getJSON('/messenger/JSON/Agents.php?EXECUTE=1', function(data){
                                    $select.html('agent_name');
                                    $.each(data, function(key, val){ 
                                    $select.append('<option value="' + val.FULL_NAME + '">' + val.FULL_NAME + '</option>');
                                    })
                                    });
                                </script>
                                      <script type="text/javascript" src="/summernote-master/dist/summernote.js"></script>

        <script type="text/javascript">
            $(function () {
                $('.summernote').summernote({
                    height: 200
                });


            });
        </script>
</body>
</html>
