<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

$policyID= filter_input(INPUT_GET, 'policyID', FILTER_SANITIZE_NUMBER_INT);
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
}
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
include('../includes/adlfunctions.php');
include('../classes/database_class.php');

    if($ffpba=='0') {
        
        header('Location: /CRMmain.php'); die;
        
    }

if($companynamere=='Bluestone Protect') {

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;
}
}

if(empty($search)) {
    
    header('Location: ../CRMmain.php'); die;
    
}

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    $aid= filter_input(INPUT_GET, 'aid', FILTER_SANITIZE_NUMBER_INT);
    $pid= filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_NUMBER_INT);

?>
<!DOCTYPE html>
<html lang="en">
    <title>View Client</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css">
    <link rel="stylesheet" href="/styles/Timeline.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

<body>
    <?php
    include('../includes/navbar.php');
        if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }


 $database = new Database(); 
 
                $database->query("SELECT client_id, title, firstname, lastname, dob, email, tel, tel2, tel3, title2, firstname2, lastname2, dob2, email2, add1, add2, add3, town, post_code FROM pba_client_details WHERE client_id = :searchplaceholder");
                $database->bind(':searchplaceholder', $search);
                $database->execute();
                $data2=$database->single();
                
                $clientonemail=$data2['email'];
                $clientonefull=$data2['firstname'] ." ". $data2['lastname'];
                $clienttwofull=$data2['firstname2'] . " " . $data2['lastname2'];
                
                ?>
    
       <div class="container">
            <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">Client</a></li>
            
            <li><a href="php/View_Client.php?cid=<?php echo $search;?>" target="_blank" >View Client</a></li>
            <li><a <?php if(isset($aid)) { ?> href="php/View_Account.php?aid=<?php echo $aid;?>" target="_blank" <?php } ?> >View Account</a></li>
            <li><a <?php if(isset($pid)) { ?>href="php/View_PBA.php?pid=<?php echo $pid;?>" target="_blank" <?php } ?> >View PBA</a></li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <div class="list-group">
                        <?php 
                        
                        if($companynamere=='Bluestone Protect') {
                        if (in_array($hello_name,$Level_10_Access, true)) { ?>
                        <li><a class="list-group-item" href="/EditClient.php?search=<?php echo $search?>&pba"><i class="fa fa-pencil-square-o fa-fw"></i>&nbsp; Edit Client</a></li>
                        <?php } } ?>
                        
                                                <?php 
                        if($companynamere!=='Bluestone Protect') {
                         ?>
                        <li><a class="list-group-item" href="/EditClient.php?search=<?php echo $search?>&pba"><i class="fa fa-pencil-square-o fa-fw"></i>&nbsp; Edit Client</a></li>                  
                        <?php }  ?>
                    </div>
                </ul>
            </li>
            
        </ul>

        <br>    
        
 
   
        <div class="tab-content">
            
            <div id="home" class="tab-pane fade in active">
                <div class="container">                    
                        <div class="col-md-4">
                            <form class="AddClient">
                                <h3><span class="label label-primary">Client Details</span></h3>
                        
            <p>
            <div class="input-group">
                <input type="text" class="form-control" id="FullName" name="FullName" value="<?php echo $data2['title']?> <?php echo $data2['firstname']?> <?php echo $data2['lastname']?>" readonly >
                                <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Client Name"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span></button></a> </span>
                            </div>
                        </p>

            <p>
            <div class="input-group">
                <input type="text" class="form-control" id="dob" name="dob" value="<?php echo $data2['dob'];?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
                        
                </span>
            </div>
            </p>
            <?php if(!empty($data2['email'])) { ?>
         
            <p>
            <div class="input-group">
                <input class="form-control" type="email" id="email" name="email" value="<?php echo $data2['email']?>"  readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email1pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
                        
                </span>
            </div>
            </p>
 
            <?php } ?>                           
             
            </div>
            
            <div class="col-md-4">
                
                <?php if (empty($data2['firstname2'])) { } else{ ?>
                
                <h3><span class="label label-primary">Client Details (2)</span></h3>
                <br>
                
                <p>
                <div class="input-group">
                    <input type="text" class="form-control" id="FullName2" name="FullName2" value="<?php echo $data2['title2']?> <?php echo $data2['firstname2']?> <?php echo $data2['lastname2']?>"  readonly >
                    <span class="input-group-btn">
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Client Name"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span></button></a>
                            
                    </span>
                </div>
            </p>
            
            <p>
            <div class="input-group">
                <input type="text" class="form-control" id="dob2" name="dob2" value="<?php echo $data2['dob2']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
                        
                </span>
            </div>
            </p>
             <?php if(!empty($data2['email2'])) { ?>
            <p>
            <div class="input-group">
                <input class="form-control" type="email" id="email2" name="email2" value="<?php echo $data2['email2']?>"  readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email2pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
                        
                </span>
            </div>
            </p>
            
             <?php } }?>
            
            </div>
            
            <div class="col-md-4">
                <h3><span class="label label-primary">Contact Details</span></h3>
              <?php if(!empty($data2['tel'])) { ?>
                <p>
                <div class="input-group">
                    <input class="form-control" type="tel" id="phone_number" name="phone_number" value="<?php echo $data2['tel']?>" readonly >
                    <span class="input-group-btn">
                        <button type="button" data-toggle="modal" data-target="#smsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button>
                            
                    </span>
                </div>
            </p>
                
              <?php }
                                
                if(empty($data2['tel2'])) { } else { ?>
            
            <p>
            <div class="input-group">
                <input class="form-control" type="tel" id="alt_number" name="alt_number" value="<?php echo $data2['tel2']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModalalt"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>

                </span>
            </div>
            </p>
                
                <?php }
                
                if(empty($data2['tel3'])) { } else { ?>
            
            <p>
            <div class="input-group">
                <input class="form-control" type="tel" id="alt_number" name="alt_number" value="<?php echo $data2['tel3']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModalalt"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>

                </span>
            </div>
            </p>
                
                <?php } ?>
            
            <div class="input-group">
                <input class="form-control" type="text" id="address1" name="address1" value="<?php echo $data2['add1']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 1"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-home"></span></button></a>
                        
                </span>
            </div>
            </p>
                
                <?php
                if(empty($data2['add2'])) { } else {?>
            
            <p>
            <div class="input-group">
                <input class="form-control" type="text" id="address2" name="address2" value="<?php echo $data2['add2']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 2"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
                        
                </span>
            </div>
            </p>
                
                <?php }
                if(empty($data2['add3'])) { } else {?>
            
            <p>
            <div class="input-group">
                <input class="form-control" type="text" id="address3" name="address3" value="<?php echo $data2['add3']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 3"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
                        
                </span>
            </div>
            </p>
                
                <?php } ?>
            
            <p>
            <div class="input-group">
                <input class="form-control" type="text" id="town" name="town" value="<?php echo $data2['town']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Postal Town"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>

                </span>
            </div>
            </p>
            
            <p>
            <div class="input-group">
                <input class="form-control" type="text" id="post_code" name="post_code" value="<?php echo $data2['post_code']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Post Code"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
                        
                </span>
            </div>
            </p>
            </form>
                        
                        </div>
                    
                         <form class="form-horizontal" method="GET">
<fieldset>


<legend>Set Account ID and Form ID</legend>

<input type="hidden" value="<?php echo $search;?>" name="search">




<div class="form-group">
  <label class="col-md-4 control-label" for="aid">Account ID</label>  
  <div class="col-md-4">
  <input id="aid" name="aid" placeholder="" class="form-control input-md" type="text" value="<?php if(isset($aid)) { echo $aid;} ?>">
     <span class="help-block">Click the View Client Tab and look for the ID(s), under the client details</span>   
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="pid">Questionaire ID</label>  
  <div class="col-md-4">
  <input id="pid" name="pid" placeholder="ID can only be found once the account ID has been submitted" class="form-control input-md" type="text" value="<?php if(isset($pid)) { echo $pid;} ?>">
    <span class="help-block">Click the View Account Tab and look for the ID(s), under PBA specific</span>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="">Submit</label>
  <div class="col-md-4">
    <button id="" name="" class="btn btn-primary">Button</button>
  </div>
</div>

</fieldset>
</form>       
                    
                    
                </div>
            </div>
        </div> 
</div>


    
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
    </body>
</html>
