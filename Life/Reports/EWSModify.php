<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adlfunctions.php');
include('../../includes/Access_Levels.php');
include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
if($ffews=='0') {
    header('Location: ../../CRMmain.php?FEATURE=EWS');
}
    
    
    if (!in_array($hello_name,$Level_8_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;

}
?>
<!DOCTYPE html>
<html lang="en">
    <title>Modify EWS Record</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/styles/sweet-alert.min.css" />
    <link rel="stylesheet" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    <?php
    include('../../includes/navbar.php');
        if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
    ?> 
    
    <div class="container">
        
        <div class="notice notice-danger" role="alert"><strong><i class="fa fa-exclamation-triangle fa-lg"></i> Info:</strong> This should only be used to correct records NOT to update EWS!</div>

        
        <?php
        
        $RecordExists= filter_input(INPUT_GET, 'RecordExists', FILTER_SANITIZE_NUMBER_INT);
        $RecordUpdated= filter_input(INPUT_GET, 'RecordUpdated', FILTER_SANITIZE_NUMBER_INT);
        $ewsid= filter_input(INPUT_GET, 'EWSID', FILTER_SANITIZE_NUMBER_INT);
        
        if(isset($RecordExists)){
            
            if ($RecordExists =='1') {
                print("<div class=\"notice notice-success\" role=\"alert\" id='HIDERECORD'><strong><i class=\"fa fa-check-circle-o fa-lg\"></i> Success:</strong> Record found!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDERECORD'>&times;</a></div>");
                
            }
            
            if ($RecordExists =='0') {
                print("<div class=\"notice notice-danger\" role=\"alert\" id='HIDENORECORD'><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Record not found!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDENORECORD'>&times;</a></div>");
                
            }
            }
        
                    if(isset($RecordUpdated)){
            
            if ($RecordUpdated =='1') {
                print("<div class=\"notice notice-success\" role=\"alert\" id='HIDEUPDATE'><strong><i class=\"fa fa-check-circle-o fa-lg\"></i> Success:</strong> Record updated!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEUPDATE'>&times;</a></div>");
                
            }
            
            if ($RecordUpdated =='0') {
                print("<div class=\"notice notice-danger\" role=\"alert\" id='HIDENOUPDATE'><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Record not updated!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDENOUPDATE'>&times;</a></div>");
                
            }
            }
        
        ?>
        
        
        <div class="row">

    
            <form class="form-vertical" method="POST" action="../php/ModifyEWS.php?Modify=1">
        <fieldset>
            <legend>Modify EWS Record</legend>
            
            <div class="col-xs-2">
                <input id="ewsid" name="ewsid" placeholder="ID of record" class="form-control input-md" required="" type="text" value="<?php if(isset($ewsid)) { echo $ewsid; } ?>">   
            </div>
            
            <div class="col-xs-2">
                <button id="button1id" name="button1id" class="btn btn-success">Submit</button>
                <a href="EWSModify.php" name="" class="btn btn-danger">Reset</a>
            </div>
        
        </fieldset>
    </form>
            
        </div>
    </div>
    <br><br>
    <?php 

    if(isset($RecordExists) || ($RecordUpdated)) {
        if($RecordExists=='1' || $RecordUpdated=='1') {
            
            include('../../includes/ADL_PDO_CON.php');          
         
            
                $select = $pdo->prepare("SELECT master_agent_no, agent_no, policy_number, client_name, dob, address1, address2, address3, address4, post_code, policy_type, warning, last_full_premium_paid, net_premium, premium_os, clawback_due, clawback_date, policy_start_date, off_risk_date, seller_name, frn, reqs, ews_status_status, date_added, processor, ournotes, color_status, updated_date FROM ews_data WHERE id =:id LIMIT 1");
                $select->bindParam(':id', $ewsid, PDO::PARAM_INT);
                $select->execute();
                $row=$select->fetch(PDO::FETCH_ASSOC);
                
                 $master_agent_no=$row['master_agent_no'];   
                 $agent_no=$row['agent_no'];
                 $policy_number=$row['policy_number'];
                 $client_name=$row['client_name'];
                 $dob=$row['dob'];
                 $address1=$row['address1'];
                 $address2=$row['address2'];
                 $address3=$row['address3'];
                 $address4=$row['address4'];
                 $post_code=$row['post_code'];
                 $policy_type=$row['policy_type'];
                 $warning=$row['warning'];
                 $last_full_premium_paid=$row['last_full_premium_paid'];
                 $net_premium=$row['net_premium'];
                 $premium_os=$row['premium_os'];
                 $clawback_due=$row['clawback_due'];
                 $clawback_date=$row['clawback_date'];
                 $policy_start_date=$row['policy_start_date'];
                 $off_risk_date=$row['off_risk_date'];                 
                 $seller_name=$row['seller_name'];
                 $frn=$row['frn'];
                 $reqs=$row['reqs'];
                 $ews_status_status=$row['ews_status_status'];
                 $date_added=$row['date_added'];                 
                 $processor=$row['processor'];
                 $ournotes=$row['ournotes'];
                 $color_status=$row['color_status'];
                 $updated_date=$row['updated_date'];

                 
                 ?>
        <div class="container-lg">
        <div class="row">
    
            <form id="EWSSUBMIT" name="EWSSUBMIT"  class="form-horizontal" method="POST" action="../php/ModifyEWS.php?Modify=2&ewsid=<?php echo $ewsid;?>">
        <fieldset>
            <legend></legend>
            
            <div class="col-md-4">
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Master Agent No</label>  
                <div class="col-md-4">
                    <input id="master_agent_no" name="master_agent_no" placeholder="Master Agent No" class="form-control input-md" required="" type="text" value="<?php if(isset($master_agent_no)) { echo $master_agent_no;  } ?>"> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Agent No</label>  
                <div class="col-md-4">
                    <input id="agent_no" name="agent_no" placeholder="Agent No" class="form-control input-md" required="" type="text" value="<?php if(isset($agent_no)) { echo $agent_no;  } ?>"> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Policy Number</label>  
                <div class="col-md-4">
                    <input id="policy_number" name="policy_number" placeholder="Policy Number" class="form-control input-md" required="" type="text" value="<?php if(isset($policy_number)) { echo $policy_number;  } ?>"> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Client Name</label>  
                <div class="col-md-4">
                    <input id="client_name" name="client_name" placeholder="Client Name" class="form-control input-md" required="" type="text" value="<?php if(isset($client_name)) { echo $client_name;  } ?>"> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="dob">DOB</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input id="dob" name="dob" class="form-control" placeholder="Date of Birth" required="" type="text" value="<?php if(isset($dob)) { echo $dob;  } ?>">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Address 1</label>  
                <div class="col-md-4">
                    <input id="address1" name="address1" placeholder="Address Line 1" class="form-control input-md" required="" type="text" value="<?php if(isset($address1)) { echo $address1;  } ?>"> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Address 2</label>  
                <div class="col-md-4">
                    <input id="address2" name="address2" placeholder="Address Line 2" class="form-control input-md" required="" type="text" value="<?php if(isset($address2)) { echo $address2;  } ?>"> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Address 3</label>  
                <div class="col-md-4">
                    <input id="address3" name="address3" placeholder="Address Line 3" class="form-control input-md" required="" type="text" value="<?php if(isset($address3)) { echo $address3;  } ?>"> 
                </div>
            </div>
                
                <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Address 4</label>  
                <div class="col-md-4">
                    <input id="address4" name="address4" placeholder="Address Line 4" class="form-control input-md" type="text" value="<?php if(isset($address4)) { echo $address4;  } ?>"> 
                </div>
                </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Post Code</label>  
                <div class="col-md-4">
                    <input id="post_code" name="post_code" placeholder="Post Code" class="form-control input-md" required="" type="text" value="<?php if(isset($post_code)) { echo $post_code;  } ?>"> 
                </div>
            </div>
                
            </div>
            
            <div class="col-md-4">
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Policy Type</label>  
                <div class="col-md-4">
                    <input id="policy_type" name="policy_type" placeholder="Policy Type" class="form-control input-md" required="" type="text" value="<?php if(isset($policy_type)) { echo $policy_type;  } ?>"> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput">Warning</label>  
                <div class="col-md-4">
                    <input id="warning" name="warning" placeholder="EWS Warning" class="form-control input-md" required="" type="text" value="<?php if(isset($warning)) { echo $warning;  } ?>"> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="prependedtext">Last Full Premium</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">£</span>
                        <input id="last_full_premium_paid" name="last_full_premium_paid" class="form-control" placeholder="Last Full Premium" required="" type="text" value="<?php if(isset($last_full_premium_paid)) { echo $last_full_premium_paid;  } ?>"> 
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="prependedtext">Net Premium</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">£</span>
                        <input id="net_premium" name="net_premium" class="form-control" placeholder="Net Premium" required="" type="text" value="<?php if(isset($net_premium)) { echo $net_premium;  } ?>"> 
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="premium_os">Premium OS</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">£</span>
                        <input id="premium_os" name="premium_os" class="form-control" placeholder="Premium OS" required="" type="text" value="<?php if(isset($premium_os)) { echo $premium_os;  } ?>"> 
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="clawback_due">Clawback Due</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">£</span>
                        <input id="clawback_due" name="clawback_due" class="form-control" placeholder="Clawback Due" required="" type="text" value="<?php if(isset($clawback_due)) { echo $clawback_due;  } ?>"> 
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="clawback_date">Clawback Date</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input id="clawback_date" name="clawback_date" class="form-control" placeholder="Clawback Date" required="" type="text" value="<?php if(isset($clawback_date)) { echo $clawback_date;  } ?>">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="policy_start_date">Policy Start Date</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input id="policy_start_date" name="policy_start_date" class="form-control" placeholder="Policy Start Date" required="" type="text" value="<?php if(isset($policy_start_date)) { echo $policy_start_date;  } ?>">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="off_risk_date">Off Risk Date</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input id="off_risk_date" name="off_risk_date" class="form-control" placeholder="Off Risk Date" required="" type="text" value="<?php if(isset($off_risk_date)) { echo $off_risk_date;  } ?>">
                    </div>
                </div>
            </div>
            
            </div>
            
            <div class="col-md-4">
                
            <div class="form-group">
                <label class="col-md-4 control-label" for="seller_name">Seller Name</label>  
                <div class="col-md-4">
                    <input id="seller_name" name="seller_name" placeholder="Seller Name" class="form-control input-md" required="" type="text" value="<?php if(isset($seller_name)) { echo $seller_name;  } ?>"> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="frn">FRN</label>  
                <div class="col-md-4">
                    <input id="frn" name="frn" placeholder="FRN" class="form-control input-md" required="" type="text" value="<?php if(isset($frn)) { echo $frn;  } ?>"> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="reqs">Reqs</label>  
                <div class="col-md-4">
                    <input id="reqs" name="reqs" placeholder="Reqs" class="form-control input-md" required="" type="text" value="<?php if(isset($reqs)) { echo $reqs;  } ?>"> 
                </div>
            </div> 
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="ews_status_status">EWS Old Status</label>  
                <div class="col-md-4">
                    <input id="ews_status_status" name="ews_status_status" placeholder="EWS Old Status" class="form-control input-md" required="" type="text" value="<?php if(isset($ews_status_status)) { echo $ews_status_status;  } ?>"> 
                </div>
            </div>                
           
            <div class="form-group">
                <label class="col-md-4 control-label" for="ournotes">Our Notes</label>  
                <div class="col-md-4">
                    <input id="ournotes" name="ournotes" placeholder="Our Notes" class="form-control input-md" type="text" value="<?php if(isset($ournotes)) { echo $ournotes;  } ?>"> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="color_status">Colour Status</label>  
                <div class="col-md-4">
                    <input id="color_status" name="color_status" placeholder="Colour Status" class="form-control input-md" required="" type="text" value="<?php if(isset($color_status)) { echo $color_status;  } ?>"> 
                </div>
            </div>
                
                <div class="form-group">
                <label class="col-md-4 control-label" for="ews_status_status">Processor</label>  
                <div class="col-md-4">
                    <input id="processor" name="processor" placeholder="Processor" class="form-control input-md" disabled type="text" value="<?php if(isset($processor)) { echo $processor;  } ?>"> 
                </div>
            </div>
                
                <div class="form-group">
                <label class="col-md-4 control-label" for="date_added">Date Added</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input id="date_added" name="date_added" class="form-control" placeholder="Date Added" required="" type="text" value="<?php if(isset($date_added)) { echo $date_added;  } ?>">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="updated_date">Updated Date</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input id="updated_date" name="updated_date" class="form-control" placeholder="Updated Date" disabled type="text" value="<?php if(isset($updated_date)) { echo $updated_date;  } ?>">
                    </div>
                </div>
            </div>
                
            </div>
            
            </div>
            
            <div class="row">
                <br>
                <center><button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Submit Changes</button></center>
            
</fieldset>
</form>
    
    
    <?php

    
        }
    }
    
    
    ?>
            
        </div>
    </div>

    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
            <script src="/js/sweet-alert.min.js"></script>
    <script>
        document.querySelector('#EWSSUBMIT').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Update EWS Record?",
                text: "Confirm to Update Record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Updated!',
                        text: 'EWS Record Updated!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No changes were made", "error");
                }
            });
        });

</script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script>
$( "#CLICKTOHIDERECORD" ).click(function() {
  $( "#HIDERECORD" ).fadeOut( "slow", function() {

  });
});

$( "#CLICKTOHIDENORECORD" ).click(function() {
  $( "#HIDENORECORD" ).fadeOut( "slow", function() {

  });
});

$( "#CLICKTOHIDEUPDATE" ).click(function() {
  $( "#HIDEUPDATE" ).fadeOut( "slow", function() {

  });
});

$( "#CLICKTOHIDENOUPDATE" ).click(function() {
  $( "#HIDENOUPDATE" ).fadeOut( "slow", function() {

  });
});


  $(function() {
    $( "#date_added" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true
        });
  });

  $(function() {
    $( "#off_risk_date" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true
        });
  });
  
    $(function() {
    $( "#policy_start_date" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true
        });
  });
  
      $(function() {
    $( "#clawback_date" ).datepicker({
        dateFormat: 'M-y',
            changeMonth: true
        });
  });
  
      $(function() {
    $( "#dob" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true
        });
  });

    </script>    
</body>
</html>