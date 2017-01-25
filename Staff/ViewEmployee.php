<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$REF= filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_SPECIAL_CHARS);

include('../classes/database_class.php');
include('../includes/Access_Levels.php');


if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: /index.php?AccessDenied'); die;

}

include('../includes/adlfunctions.php');

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | View Employee</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/cosmo/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/cosmo/bootstrap.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/styles/sweet-alert.min.css" />
<link rel="stylesheet" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
<link rel="stylesheet" href="/styles/Notices.css" />
<link rel="stylesheet" type="text/css" href="/clockpicker-gh-pages/dist/jquery-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="/clockpicker-gh-pages/assets/css/github.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

<style>
    .label {
   display: block; width: 100px; 
}
.appbox {
    background:#48B0F7; 
}
.noshows {
    background:#F55753; 
}
.totalbox {
    background:#10CFBD;
}
.outbox {
    background:#F8D053;
}
.clockpicker-popover {
    z-index: 999999;
}
.clickable-row {
	cursor:pointer
}
.clickable-row:hover {
	background:#cff5f1 !important
}
</style>

<script type="text/javascript" src="/clockpicker-gh-pages/assets/js/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
</head>
<body>
    
    <?php 
    include('../includes/navbar.php');
     
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
     $database = new Database(); 
 
                $database->query("SELECT ni_num, id_provided, id_details, dob, title, firstname, end_date, lastname, CONCAT(title, ' ', firstname, ' ', lastname) AS NAME, position, start_date, added_date, added_by, updated_date, updated_by FROM employee_details WHERE employee_id=:REF");
                $database->bind(':REF', $REF);
                $database->execute();
                $data2=$database->single();
                
                $database->query("SELECT mob, tel, email, add1, add2, add3, town, postal FROM employee_contact WHERE employee_id=:REF");
                $database->bind(':REF', $REF);
                $database->execute();
                $data3=$database->single();
                
                $database->query("SELECT contact_name, contact_num, contact_relationship, contact_address, medical FROM employee_emergency WHERE employee_id=:REF");
                $database->bind(':REF', $REF);
                $database->execute();
                $data4=$database->single();
                
                $CON_NAME=$data4['contact_name'];
                $CON_NUM=$data4['contact_num'];
                $CON_REL=$data4['contact_relationship'];
                $CON_ADD=$data4['contact_address'];
                $MEDICAL=$data4['medical'];
                
                
                
                $EMAIL=$data3['email'];
                $MOB=$data3['mob'];
                $TEL=$data3['tel'];
                $ADD1=$data3['add1'];
                $ADD2=$data3['add2'];
                $ADD3=$data3['add3'];
                $TOWN=$data3['town'];
                $POSTAL=$data3['postal'];
                
                $POSITION=$data2['position'];
                $START_DATE=$data2['start_date'];
                $END_DATE=$data2['end_date'];
                $ADDED_DATE=$data2['added_date'];
                $UPDATED_DATE=$data2['updated_date'];
                $ADDED_BY=$data2['added_by'];
                $UPDATED_BY=$data2['updated_by'];
                $NI_NUM=$data2['ni_num'];
                $ID_PROVIDED=$data2['id_provided'];
                $ID_DETAILS=$data2['id_details'];
                $NAME="$data2[title] $data2[firstname] $data2[lastname]";
                $FIRSTNAME=$data2['firstname'];
                $LASTNAME=$data2['lastname'];
                $TITLE=$data2['title'];
                $ORIGDOB=$data2['dob'];

                
                $DOB=date("l jS \of F Y",strtotime($ORIGDOB));
    ?>

    <div class="content full-height">
        <div class="container-fluid full-height"> 
            <div class="row fixed-toolbar">
                <div class="col-xs-5">
                    <a href="Search.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <div class="col-xs-7">
                    <div class="text-right">
            
                        <a class="btn btn-info" data-toggle="modal" data-target="#BookModal" data-backdrop="static" data-keyboard="false"><i class="fa fa-calendar-check-o"></i> Add Holidays</a>                        
                                           
                       
                        <a class="btn btn-warning" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false"><i class="fa fa-edit"></i> Edit</a>                        
                     
                      
                        <a class="btn btn-danger" href="#"><i class="fa fa-trash"></i> Delete</a>
                      
                    </div>
                </div>
            </div>
            
            <div class="container">
                <div class="row">
                <?php include('php/Notifications.php'); ?>
                </div>
                <div class="row">
                    <h1><?php echo $NAME;?><?php if(isset($POSITION)) { echo " - $POSITION"; } ?></h1>
                                        <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#Menu1">Summary</a></li>
                        <li><a data-toggle="pill" href="#Menu2">Emergency Details</a></li>
                        <li><a data-toggle="pill" href="#Menu3">Files & Uploads</a></li>
                    </ul>
                </div>
                
                <div class="row">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="Menu1" class="tab-pane fade in active"> 
                                    <div class='row'>
                                        
                                        <?php
                                        
                                       # $APP_COUNT = $pdo->prepare("select count(id) AS count from appointments WHERE client_id=:REF AND status NOT IN ('Complete','No Show')");
                                        #$APP_COUNT->bindParam(':REF', $REF, PDO::PARAM_INT);
                                        #$APP_COUNT->execute()or die(print_r($APP_COUNT->errorInfo(), true));
                                        #$result=$APP_COUNT->fetch(PDO::FETCH_ASSOC);
                                        #$APP_COUNT_RESULT=$result['count'];
                                        
                                        ?>
                                        
                                        <div class='col-xs-6 col-sm-3 p-r-5 sm-p-l-15'>
                                            <div class='panel panel-default m-b-10 b-regular sm-m-'>
                                                <div class='panel-body p-b-10 p-t-10 appbox'>
                                                    <div class='text-center'>
                                                        <h3 class='bold text-white no-margin'><?php if(isset($APP_COUNT_RESULT)) { echo $APP_COUNT_RESULT; } ?></h3>
                                                        <div class='m-t-10 text-white sm-m-b-5'>Appointments</div>
                                                            
                                                    </div>
                                                        
                                                </div>
                                                    
                                            </div>
                                                
                                        </div>
                                        
                                        <?php
                                        
                                        #$APP_COUNT_STATUS = $pdo->prepare("select count(id) AS count from appointments WHERE client_id=:REF AND status='No Show'");
                                        #$APP_COUNT_STATUS->bindParam(':REF', $REF, PDO::PARAM_INT);
                                        #$APP_COUNT_STATUS->execute()or die(print_r($APP_COUNT_STATUS->errorInfo(), true));
                                        #$result_APP_COUNT_STATUS=$APP_COUNT_STATUS->fetch(PDO::FETCH_ASSOC);
                                        #$APP_COUNT__STATUS_RESULT=$result_APP_COUNT_STATUS['count'];
                                        
                                        ?>
                                        
                                        <div class='col-xs-6 col-sm-3 p-l-5 p-r-5 sm-p-r-15'>
                                            <div class='panel panel-default m-b-10 b-regular'>
                                                <div class='panel-body p-b-10 p-t-10 noshows'>
                                                    <div class='text-center'>
                                                        <h3 class='bold text-white no-margin'><?php if(isset($APP_COUNT__STATUS_RESULT)) { echo $APP_COUNT__STATUS_RESULT; } ?></h3>
                                                        <div class='m-t-10 text-white sm-m-b-5'>No-shows</div></div>
                                                            
                                                </div>
                                                    
                                            </div>
                                                
                                        </div>
                                        
                                        <?php
                                        
                                        #$APP_COUNT_PRICE = $pdo->prepare("select SUM(price) AS price from appointments WHERE client_id=:REF AND status='Complete'");
                                        #$APP_COUNT_PRICE->bindParam(':REF', $REF, PDO::PARAM_INT);
                                       # $APP_COUNT_PRICE->execute()or die(print_r($APP_COUNT_PRICE->errorInfo(), true));
                                        #$result_APP_COUNT_PRICE=$APP_COUNT_PRICE->fetch(PDO::FETCH_ASSOC);
                                        #$APP_COUNT_PRICE_RESULT=$result_APP_COUNT_PRICE['price'];
                                        
                                       # $APP_FORMATTED_PRICE = number_format($APP_COUNT_PRICE_RESULT, 2);
                                        
                                        ?>                                        
                                        
                                        <div class='col-xs-6 col-sm-3 p-r-5 p-l-5 sm-p-l-15'>
                                            <div class='panel panel-default m-b-10 b-regular'>
                                                <div class='panel-body p-b-10 p-t-10 totalbox'>
                                                    <div class='text-center'>
                                                        <h3 class='bold text-white no-margin'><?php if(!empty($APP_COUNT_PRICE_RESULT)) { echo "£$APP_FORMATTED_PRICE";  } else { echo "£0.00"; }?></h3>
                                                        <div class='m-t-10 text-white'>Total Sales</div>                                                            
                                                    </div>                                                        
                                                </div>                                                    
                                            </div>
                                                
                                        </div>
                                        
                                        <?php
                                        
                                        #$APP_COUNT_OUTSTAN = $pdo->prepare("select SUM(price) AS price from appointments WHERE client_id=:REF AND status NOT IN ('Complete','No Show')");
                                        #$APP_COUNT_OUTSTAN->bindParam(':REF', $REF, PDO::PARAM_INT);
                                        #$APP_COUNT_OUTSTAN->execute()or die(print_r($query->errorInfo(), true));
                                        #$result_APP_COUNT_OUTSTAN=$APP_COUNT_OUTSTAN->fetch(PDO::FETCH_ASSOC);
                                        #$APP_COUNT_OUTSTAN_RESULT=$result_APP_COUNT_OUTSTAN['price'];
                                        
                                        #$APP_FORMATTED_OUTSTAN = number_format($APP_COUNT_OUTSTAN_RESULT, 2);
                                        
                                        ?>                                          
                                        
                                        <div class='col-xs-6 col-sm-3 p-l-5 sm-p-r-15'>
                                            <div class='panel panel-default m-b-10 b-regular'>
                                                <div class='panel-body p-b-10 p-t-10 outbox'>
                                                    <div class='text-center'>
                                                        <h3 class='bold text-white no-margin'><?php if(!empty($APP_COUNT_OUTSTAN_RESULT)) { echo "£$APP_FORMATTED_OUTSTAN";  } else { echo "£0.00"; }?></h3>
                                                        <div class='m-t-10 text-white'>Outstanding</div>
                                                            
                                                    </div>
                                                        
                                                </div>
                                                    
                                            </div>
                                                
                                        </div>
                                    </div>
                                    <div class='col-sm-6 sm-p-r-15 sm-p-l-15 p-r-5'>
                                        <table class='table table-condensed bg-white no-margin'>
                                            <tbody>
                                                <tr>
                                                    <td class='hint-text col-xs-5 col-sm-4'><i class="fa fa-mobile"></i> Mobile</td>
                                                    <td class='font-bold'><?php if(isset($MOB)) { echo $MOB;} ?></td>
                                                </tr>
                                                <tr>
                                                    <td class='hint-text col-xs-5 col-sm-4'><i class="fa fa-phone"></i> Telephone</td>
                                                    <td class='font-bold'><?php if(isset($TEL)) { echo $TEL;} ?></td>
                                                </tr>
                                                <tr>
                                                    <td class='hint-text col-xs-5 col-sm-4'><i  class="fa fa-envelope"></i> Email</td>
                                                    <td class='font-bold'><?php if(isset($EMAIL)) { echo $EMAIL;} ?></td>
                                                </tr>
                                                                                                <tr>
                                                    <td class='hint-text col-xs-5 col-sm-4'><i  class="fa fa-clipboard"></i> ID Provided</td>
                                                    <td class='font-bold'><?php if(isset($ID_PROVIDED)) { 
                                                        
                                                   switch ($ID_PROVIDED) { 
                                                       case "1":
                                                           $ID_PROVIDED="Passport Number";
                                                           break;
                                                       case "2":
                                                           $ID_PROVIDED="Driving License";
                                                           break;
                                                       case "3":
                                                           $ID_PROVIDED="Bank Card Check";
                                                           break;
                                                       case "4":  
                                                           $ID_PROVIDED="None";
                                                           break;
                                                       default:
                                                           $ID_PROVIDED="None provided";
                                                           
                                                   } 
                                                   echo $ID_PROVIDED;} ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class='col-sm-6 sm-p-r-15 sm-p-l-15 p-l-5'>
                                        <table class='table table-condensed bg-white no-margin'>
                                            <tbody>
                                                <tr>
                                                    <td class='hint-text col-xs-5 col-sm-4'><i class="fa fa-birthday-cake"></i> Birthday</td>
                                                    <td class='font-bold'><?php if(isset($DOB)) { echo $DOB;} ?></td>
                                                </tr>
                                        
                                                 <tr><td class='hint-text col-xs-5 col-sm-4'><i class="fa fa-drivers-license"></i> NI Number</td>
                                                    <td class='font-bold'><?php if(isset($NI_NUM)) { echo $NI_NUM;} ?></td>
                                                </tr>
                                                <tr>
                                                    <td class='hint-text col-xs-5 col-sm-4'><i class="fa fa-calendar-check-o"></i> Employment Dates</td>
                                                    <td class='font-bold'><?php if(isset($START_DATE)) { echo $START_DATE; }?></td>
                                                </tr>
                                                
                                                    <tr>
                                                    <td class='hint-text col-xs-5 col-sm-4'><i class="fa fa-check-circle"></i> ID Details</td>
                                                    <td class='font-bold'><?php if(isset($ID_DETAILS)) { echo $ID_DETAILS; }?></td>
                                                </tr>
                                               
                                            </tbody>
                                        </table>
                                    </div> 
                                    
                                    <div class='row'>
                                        <div class='col-lg-12'>
                                            <table class='table table-condensed bg-white no-margin'>
                                                <tbody>
                                                    <tr>
                                                        <td class='no-border col-sm-2 col-xs-5 hint-text'><i class="fa fa-medkit"></i> Medical Conditions</td>
                                                        <td class='no-border p-l-15'>
                                                            <div class='text-italic'><p><?php if(isset($MEDICAL)) { echo $MEDICAL;} ?></p></div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
  <style>
            .fa-edit {
                color: #FEAF20;
            }
            .fa-exclamation {
                color: #FEAF20;
            }
            .fa-exclamation-triangle {
                color: red;
            }
            .fa-upload {
                color: #5BC0DE;
            }
            .fa-phone {
                color: #2A6598;
            }
            .fa-gbp {
                color: red;
            }
             .fa-check {
                color: green;
            }
        </style>
        <br><br>
<?php
       
try {

$clientnote = $pdo->prepare("select note_type, message, added_by, added_date from employee_timeline where employee_id =:REF ORDER BY added_date DESC");
$clientnote->bindParam(':REF', $REF, PDO::PARAM_STR, 12);

$clientnote->execute();
if ($clientnote->rowCount()>0) {
while ($result=$clientnote->fetch(PDO::FETCH_ASSOC)){
    
    $TLdate=$result['added_date'];
    $TLwho=$result['added_by'];
    $TLmessage=$result['message'];
    $TLnotetype=$result['note_type'];
    
    $TLdate= date("d M y - G:i:s");
    
    switch ($TLnotetype) {
    
        case "Employee Added":
            $TMicon="fa-user-plus";
            break;
        case "Policy Deleted":
            $TMicon="fa-exclamation";
            break;
        case "CRM Alert":
            case "Policy Added":
            $TMicon="fa-check";
            break;
        case "EWS Status update":  
            case"EWS Uploaded";
                $TMicon="fa-exclamation-triangle";
                break;
            case "Financial Uploaded":
                $TMicon="fa-gbp";
                break;
            case "Dealsheet":
                case"LGpolicy";
                    case"LGkeyfacts";
                        case"Recording";
                $TMicon="fa-upload";
                break;
            case stristr($TLnotetype,"Tasks"):
                $TMicon="fa-tasks";
                break;
            case "Client Note":
                $TMicon="fa-pencil";
                break;
            case stristr($TLnotetype,"Callback"):
                $TMicon="fa-calendar-check-o";
                break;
            case "Email Sent":
                $TMicon="fa-envelope-o";
                break;
            case "Client Details Updated":
                case "Policy Details Updated":
                    case"Policy Number Updated":
                $TMicon="fa-edit";
                break;
            case "Sent SMS":
                $TMicon="fa-phone";
                break;
            default:
                $TMicon="fa-bomb";

    } 
    
    ?>        
            <div class="qa-message-list" id="wallmessages">
    				<div class="message-item" id="m16">
						<div class="message-inner">
							<div class="message-head clearfix">
                                                            <div class="avatar pull-left"><i id="iconid" class="fa <?php echo "$TMicon";?> fa-3x"></i></div>
								<div class="user-detail">
									<h5 class="handle"><?php echo "Note Type: <strong>$TLnotetype</strong>"; ?></h5>
									<div class="post-meta">
										<div class="asker-meta">
											<span class="qa-message-what"></span>
											<span class="qa-message-when">
												<span class="qa-message-when-data"><?php echo "Date: $TLdate"; ?></span>
											</span>
											<span class="qa-message-who">
												<span class="qa-message-who-pad"><?php echo " Added by: $TLwho"; ?> </span>
												<span class="qa-message-who-data"><a href="./index.php?qa=user&qa_1=Oleg+Kolesnichenko"></a></span>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="qa-message-content">
								<?php
                                                                if (in_array($hello_name,$Level_3_Access, true)) {
                                                                
                                                                echo "<strong>$TLmessage</strong>"; }
                                                                
                                                                else { echo "$TLmessage"; }
                                                                
                                                                ?>
							</div>
					</div></div>
        
        
        <?php
}
} 
  }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                } ?>
                                
                                </div>
                                        
                                </div>
                                
                                <div id="Menu2" class="tab-pane fade">
                                    
                                    <div class='col-sm-6 sm-p-r-15 sm-p-l-15 p-r-5'>
                                        <table class='table table-condensed bg-white no-margin'>
                                            <tbody>
                                                <tr>
                                                    <td class='hint-text col-xs-5 col-sm-4'><i class="fa fa-mobile"></i> Contact Name</td>
                                                    <td class='font-bold'><?php if(isset($CON_NAME)) { echo $CON_NAME;} ?></td>
                                                </tr>
                                          
                                                <tr>
                                                    <td class='hint-text col-xs-5 col-sm-4'><i  class="fa fa-envelope"></i> Relationship</td>
                                                    <td class='font-bold'><?php if(isset($CON_REL)) { echo $CON_REL;} ?></td>
                                                </tr>
                           
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                                                        <div class='col-sm-6 sm-p-r-15 sm-p-l-15 p-r-5'>
                                        <table class='table table-condensed bg-white no-margin'>
                                            <tbody>
                                          
                                                <tr>
                                                    <td class='hint-text col-xs-5 col-sm-4'><i class="fa fa-phone"></i> Telephone</td>
                                                    <td class='font-bold'><?php if(isset($CON_NUM)) { echo $CON_NUM;} ?></td>
                                                </tr>
                                                
                                                 <tr>
                                                    <td class='hint-text col-xs-5 col-sm-4'><i class="fa fa-phone"></i> Address</td>
                                                    <td class='font-bold'><?php if(isset($CON_ADD)) { echo $CON_ADD;} ?></td>
                                                </tr>
                                            
                           
                                            </tbody>
                                        </table>
                                    </div>                               
                                    
          
                                </div>
                                
                                <div id="Menu3" class="tab-pane fade"> 
                                    
                                          
                                    
                                </div>
                                    
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </div>
    </div>
        <?php if (in_array($hello_name,$Level_2_Access, true)) { ?>
<div class="modal fade" id="BookModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Book an appointment for <?php echo $NAME;?></h4>
        </div>
        <div class="modal-body">

                <div class="row">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#Book1">Appointment</a></li>
                        <li><a data-toggle="pill" href="#Book2">Book Time</a></li>
                    </ul>
                </div>
            
            <div class="panel">
                        <div class="panel-body">
                            <form class="form" action="php/Appointment.php?TYPE=1&REF=<?php echo $REF; ?>" method="POST" id="bookform">
                              
	
                            <div class="tab-content">
                                <div id="Book1" class="tab-pane fade in active"> 
            
            <div class="col-lg-12 col-md-12">
                
                <div class="row">                    
                  <div class="col-md-6">
                  
                        <div class="form-group">
                            <label class="control-label">Client</label>
                            <input type="text" name="name" class="form-control" value="<?php if(isset($NAME)) { echo $NAME; } ?>">              
                    </div>
                      
                                        
                            <div class="form-group">
                                <label class="control-label">Client Note</label>
                                <textarea name="notes" class="form-control" rows="5"></textarea>
                            </div> 
                      
                    <div class="form-group">
                            <label class="control-label">Service</label>
                            <input type="text" name="service" class="form-control">              
                    </div>
                      
                                               <div class="form-group">
                            <label class="control-label">Service (For Invoice)</label>
                            <select multiple="multiple" name="services[]" class="form-control" required>
                                <option value="Hair Cut">Hair Cut</option>
                                <option value="Blow Dry">Blow Dry</option>
                                <option value="Straight Cut">Straight Cut</option>
                                <option value="Re-style">Re-style</option>
                                <option value="Highlights">Highlights</option>
                            
                            </select>
                        </div>

                      
                      <div class="col-xs-6">
                      
                        <div class="form-group">
                            <label class="control-label">Price</label>
                            <select name="price" class="form-control" required>
                                <option value=""></option>
                                <option value="Override">Override</option>
                                <option value="2.00">£2</option>
                                <option value="2.50">£2.50</option>
                                <option value="5.00">£5</option>
                                <option value="10.00">£10</option>                          
                            </select>
                        </div>
                      </div> 
                      
                     <div class="col-xs-6">                   
                      
                        <div class="form-group">
                            <label class="control-label">Override Price</label>
                            <input type="text" name="override" class="form-control">              
                    </div>
                          
                     </div>
                                                    
                  </div>
                    
                    <div class="col-md-6">
                        
                        
                        <div class="form-group">
                            <label class="control-label">Staff</label>
                            <select name="staff" class="form-control" required>
                                <option value=""></option>
                                <option value="Michael">Michael</option>
                                <option value="Joe">Joe</option>
                                <option value="Betty">Betty</option>                            
                            </select>
                        </div>
                        
                                          
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <input type="text" name="date" id="datepickerBookModal<?php echo $i; ?>" class="form-control" required>                                                                       
                    </div>
                        
                                                <script>
        $( function() {
    $( "#datepickerBookModal<?php echo $i; ?>" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true
        });
  } );
  </script>                                 
                        
                        <div class="form-group">
                                        <label class="control-label">Time</label>
                                        <div class='input-group date clockpicker'>
                                            <input type='text' class="form-control" id="clockpicker" name="time" required  />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                        
                        <div class="form-group">
                          <label class="control-label">Duration</label>
                          <select name="duration" class="form-control" required>
                              <option value=""></option>
                              <option value="5mins">5mins</option>
                              <option value="10mins">10mins</option>
                              <option value="15mins">15mins</option>
                              <option value="20mins">20mins</option>
                              <option value="25mins">25mins</option>
                              <option value="30mins">30mins</option>
                              <option value="35mins">35mins</option>
                              <option value="45min">45mins</option>
                              <option value="50mins">50mins</option>
                              <option value="55mins">55mins</option>
                              <option value="1hr">1hr</option>
                              <option value="1hr 5mins">1hr 5mins</option>
                              <option value="1hr 10min">1hr 10min</option>
                              <option value="1hr 15mins">1hr 15mins</option>
                              <option value="1hr 20mins">1hr 20mins</option>
                              <option value="1hr 25mins">1hr 25mins</option>
                              <option value="1hr 30min">1hr 30min</option>
                              <option value="1hr 35mins">1hr 35mins</option>
                              <option value="1hr 40min">1hr 40min</option>
                          </select>
                      </div>


                    </div>
                </div>

            
            </div>
                                </div>
                                
                                <div id="Book2" class="tab-pane fade">
                                
                                </div>
                            
                            </div>

                        </div>
            </div>
        </div>
          
          <div class="modal-footer">
              <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Save</button>
<script>
        document.querySelector('#bookform').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Add appointment?",
                text: "Confirm new appointment!",
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
                        title: 'Booked!',
                        text: 'Appointment added!',
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
          </form>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
          </div>
      </div>
    </div>
</div>
    <?php }
    if (in_array($hello_name,$Level_3_Access, true)) { ?>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">You are now editing <?php echo $NAME;?></h4>
        </div>
        <div class="modal-body">

                <div class="row">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#Modal1">Client</a></li>
                        <li><a data-toggle="pill" href="#Modal2">Address</a></li>
                    </ul>
                </div>
            
            <div class="panel">
                        <div class="panel-body">
                            <form class="form" action="php/Edit.php?EDIT=1&REF=<?php echo $REF; ?>" method="POST" id="editform">
                            <div class="tab-content">
                                <div id="Modal1" class="tab-pane fade in active"> 
            
            <div class="col-lg-12 col-md-12">
                
                <div class="row">
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <select name="title" class="form-control">
                                <option value="<?php if(isset($TITLE)) { echo $TITLE; } ?>"><?php if(isset($TITLE)) { echo $TITLE; } ?></option>
                                <option value="Mr">Mr</option>
                                <option value="Master">Master</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Ms">Ms</option>
                                <option value="Miss">Miss</option>
                            
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">First Name</label>
                            <input type="text" name="firstname" class="form-control" value="<?php if(isset($FIRSTNAME)) { echo $FIRSTNAME; } ?>">
                        </div>
                    </div>
                    
                     <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control" value="<?php if(isset($LASTNAME)) { echo $LASTNAME; } ?>">
                        </div>
                    </div>                    
                 
                    
                </div>
                
                <div class="row">
                    
                     <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">DOB</label>
                            <input type="text" name="dob" class="form-control" id="datepickerEdit" value="<?php if(isset($ORIGDOB)) { echo $ORIGDOB; } ?>">
                        </div>
                    </div>                       
                    </div>
                
                                                <script>
        $( function() {
    $( "#datepickerEdit" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true
        });
  } );
  </script>                  
                    
                    <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Mobile</label>
                            <input type="text" name="mob" class="form-control" value="<?php if(isset($MOB)) { echo $MOB; } ?>">
                        </div> 
                    </div> 
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Tel</label>
                            <input type="text" name="tel" class="form-control" value="<?php if(isset($TEL)) { echo $TEL; } ?>">
                        </div> 
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="text" name="email" class="form-control" value="<?php if(isset($EMAIL)) { echo $EMAIL; } ?>">
                        </div> 
                    </div>
                   
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Gender</label>
                            <select name="gender" class="form-control">
                                <?php if(isset($GENDER)) { ?>
                                <option value="<?php echo $GENDER; ?>"><?php echo $GENDER;?></option>
                                <?php } ?>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Notifications</label>
                            <select name="notifications" class="form-control">
                                <?php if(isset($NOTIF)) { ?>
                                <option value="<?php echo $NOTIF; ?>"><?php echo $NOTIF;?></option>
                                <?php } ?>
                                <option value="Email">Email</option>
                                <option value="SMS">SMS</option>
                                <option value="Email and SMS">Email and SMS</option>
                                <option value="None">Don't send notifications</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Client Note</label>
                                <textarea name="notes" class="form-control" rows="5"><?php if(isset($NOTES)) { echo $NOTES; } ?></textarea>
                            </div> 
                        </div>
                    </div>
            
            </div>
                                </div>
                                
                                <div id="Modal2" class="tab-pane fade">
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Address Line 1</label>
                                                <input type="text" name="add1" class="form-control" value="<?php if(isset($ADD1)) { echo $ADD1; } ?>">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Address Line 2</label>
                                                <input type="text" name="add2" class="form-control" value="<?php if(isset($ADD2)) { echo $ADD2; } ?>">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Address Line 3</label>
                                                <input type="text" name="add3" class="form-control" value="<?php if(isset($ADD3)) { echo $ADD3; } ?>">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Town</label>
                                                <input type="text" name="town" class="form-control" value="<?php if(isset($TOWN)) { echo $TOWN; } ?>">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Post Code</label>
                                                <input type="text" name="postal" class="form-control" value="<?php if(isset($POSTAL)) { echo $POSTAL; } ?>">
                                            </div> 
                                        </div> 
                                    </div>
                                
                                </div>
                            
                            </div>

                        </div>
            </div>
        </div>
          
          <div class="modal-footer">
              <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Save</button>
<script>
        document.querySelector('#editform').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Edit Client?",
                text: "Confirm to update client details!",
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
                        text: 'Client updated!',
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
          </form>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
          </div>
      </div>
    </div>
</div>
    
    <?php } ?>
    
    <?php
    
    $CHECKOUT= filter_input(INPUT_GET, 'CHECKOUT', FILTER_SANITIZE_NUMBER_INT);
    
    if(isset($CHECKOUT)) {
        $APP_CHECK_APPID= filter_input(INPUT_GET, 'CHECKOUTAPPID', FILTER_SANITIZE_NUMBER_INT);
        if($CHECKOUT=='1') { ?>
    <script>
    $(document).ready(function () {

    $('#CHECKOUTModal').modal('show');

});
</script>
    <div class="modal fade" id="CHECKOUTModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Invoice for <?php echo $NAME;?></h4>
        </div>
        <div class="modal-body">
            <div class="panel">
                <div class="panel-body">
                    <div class="col-lg-12 col-md-12">
                        <div class="row"> 
                            <div class="col-md-6">
                                
 <?php
                                        $APP_COUNT = $pdo->prepare("SELECT assigned, duration, client, status, service, price, override, id, note FROM appointments where id=:APPID");
                                        $APP_COUNT->bindParam(':APPID', $APP_CHECK_APPID, PDO::PARAM_INT);
                                        $APP_COUNT->execute()or die(print_r($APP_COUNT->errorInfo(), true));
                                        $result_CHECK=$APP_COUNT->fetch(PDO::FETCH_ASSOC);
                                        
                                        $APP_CHECK_SERVICE=$result_CHECK['service'];
                                        $APP_CHECK_ASSIGNED=$result_CHECK['assigned'];
                                        $APP_CHECK_DURATION=$result_CHECK['duration'];
                                        $APP_CHECK_STATUS=$result_CHECK['status'];
                                        $APP_CHECK_NOTE=$result_CHECK['note'];
                                        $APP_CHECK_PRICE=$result_CHECK['price'];
                                        $APP_CHECK_OVERRIDE=$result_CHECK['override'];
                                        
                                        $INVOICE_DATE_TODAY=date("l jS M Y");
                                        
                                          if($APP_CHECK_PRICE=='Override') {
                                                        
                                                        $APP_CHECK_AMOUNT=$APP_CHECK_OVERRIDE;
                                                    }
                                                    
                                                    else {
                                                        
                                                        $APP_CHECK_AMOUNT=$APP_CHECK_PRICE;
                                                    }
                                                    

                                
                                ?>  
                                
                      <p><strong>SERVICE</strong> - <?php if(isset($APP_CHECK_SERVICE)) { echo $APP_CHECK_SERVICE; } ?></p>
                      <p><strong>PRICE</strong>  - <?php if(isset($APP_CHECK_AMOUNT)) { echo $APP_CHECK_AMOUNT; } ?></p>
                      <p><strong>STAFF</strong>  - <?php if(isset($APP_CHECK_ASSIGNED)) { echo $APP_CHECK_ASSIGNED; } ?></p>
                      <p><strong>NOTES</strong>  - <?php if(isset($APP_CHECK_NOTE)) { echo $APP_CHECK_NOTE; } ?></p>
                      
                    
                      
                  </div>
                            
                            <div class="col-md-6">
                                <?php if (in_array($hello_name,$Level_10_Access, true)) { ?>
                    <form class="form-inline" action="php/Checkout.php?TYPE=1&REF=<?php echo $REF; ?>&CHECKOUTAPPID=<?php echo $APP_CHECK_APPID; ?>" method="POST" id="checkoutform">  
                                <?php } ?>

<fieldset>
    
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label">Invoice Date</label>
                <input type="text" name="invoicedate" class="form-control" value="<?php echo $INVOICE_DATE_TODAY; ?>" readonly>
            </div> 
        </div> 
    </div>
    
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label">Invoice Due</label>
                <input type="text" name="invoicedue" id="datepickerinvoice" class="form-control">
            </div> 
        </div> 
    </div>
    
                                                <script>
        $( function() {
    $( "#datepickerinvoice" ).datepicker({
        dateFormat: 'D dd M yy',
            changeMonth: true
        });
  } );
  </script>       
    
    
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label">Price</label>
                <input type="number" name="invoiceprice" class="form-control" step="0.01" value="<?php echo $APP_CHECK_AMOUNT; ?>">
            </div> 
        </div> 
    </div>

</fieldset>
                        
                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check-circle-o"></i> Create Invoice</button>
                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          <div class="modal-footer">
 <script>
        document.querySelector('#checkoutform').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Update appointment status?",
                text: "Confirm to update!",
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
                        text: 'Appointment status updated!',
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

<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
          </div>
      </div>
    </div>
</div>  
    
    <?php } } ?>

<script type="text/javascript" src="clockpicker-gh-pages/dist/jquery-clockpicker.min.js"></script>  
<script type="text/javascript">
$('.clockpicker').clockpicker({
	placement: 'top',
	align: 'left',
	donetext: 'Done'
})
	.find('input').change(function(){
		console.log(this.value);
	});
</script>
<script type="text/javascript" src="clockpicker-gh-pages/assets/js/highlight.min.js"></script>
<script src="js/sweet-alert.min.js"></script> 
<script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>    
    
<script>
$(document).ready(function() {
   if(window.location.href.split('#').length > 1 )
      {
      $tab_to_nav_to=window.location.href.split('#')[1];
      if ($(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']").length)
         {
         $(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']")[0].click();
         }
      }
});

</script>
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
