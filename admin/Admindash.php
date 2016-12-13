<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include ($_SERVER['DOCUMENT_ROOT']."/includes/ADL_PDO_CON.php");

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
                            $cnquery->execute()or die(print_r($query->errorInfo(), true));
                            $companydetailsq=$cnquery->fetch(PDO::FETCH_ASSOC);
                            
                            $companynamere=$companydetailsq['company_name'];
?>
<!DOCTYPE html>
<html lang="en">
<title>Admin Dashboard</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../style/admindash.css">
<link  rel="stylesheet" href="../styles/sweet-alert.min.css" />
<link rel="stylesheet" href="../styles/layoutcrm.css" type="text/css" />
<link  rel="stylesheet" href="../styles/sweet-alert.min.css" />
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
<?php include('../includes/ADL_PDO_CON.php'); ?>
   <div id="wrapper">

        <div id="sidebar-wrapper">
            <h2>&nbsp; &nbsp; &nbsp;ADL CRM</h2>
            <div class="list-group"><br><br>
       
                    <a class="list-group-item" href="../CRMmain.php"><i class="fa fa-home fa-fw"></i>&nbsp; CRM Home</a>
                
                    <a class="list-group-item" href="Admindash.php?admindash=y"><i class="fa fa-cog fa-fw"></i>&nbsp; Admin Dashboard</a>
                    
                    <a class="list-group-item" href="?company=y"><i class="fa fa-info-circle fa-fw"></i>&nbsp; Company Info</a>
               
                    <a class="list-group-item" href="?users=y"><i class="fa fa-user fa-fw"></i>&nbsp; User configuration</a>
               
                    <a class="list-group-item" href="?Emails=y"><i class="fa fa-envelope-o fa-fw"></i>&nbsp; Emails</a>
              
                    <a class="list-group-item" href="?SMS=y"><i class="fa fa-commenting-o fa-fw"></i>&nbsp; SMS</a>
                
                    <a class="list-group-item" href="?AssignTasks=y"><i class="fa fa-tasks fa-fw"></i>&nbsp; Task Assignment</a>
               
                    <a class="list-group-item" href="?Firewall=y"><i class="fa fa-fire fa-fw"></i>&nbsp; Firewall</a>
                
                    <a class="list-group-item" href="?Vicidial=y"><i class="fa fa-headphones fa-fw"></i>&nbsp; Vicidial Integration</a>
               
                    <a class="list-group-item" href="?Settings=y"><i class="fa fa-desktop fa-fw"></i>&nbsp; Enable features</a>
                    
                    <a class="list-group-item" href="?Google=y"><i class="fa fa-google fa-fw"></i>&nbsp; Google Developer</a>
                    
                    <a class="list-group-item" href="?PostCode=y"><i class="fa fa-search fa-fw"></i>&nbsp; Post Code Lookup</a>
                
                </div>
            
        </div>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        
                       
                                                                          
                        <?php
                        
                        $SMSselect= filter_input(INPUT_GET, 'SMS', FILTER_SANITIZE_SPECIAL_CHARS);
                        $Emailselect= filter_input(INPUT_GET, 'Emails', FILTER_SANITIZE_SPECIAL_CHARS);
                        $AssignTasksselect= filter_input(INPUT_GET, 'AssignTasks', FILTER_SANITIZE_SPECIAL_CHARS);
                        $usersselect= filter_input(INPUT_GET, 'users', FILTER_SANITIZE_SPECIAL_CHARS);
                        $adminselect= filter_input(INPUT_GET, 'admindash', FILTER_SANITIZE_SPECIAL_CHARS);
                        $fireselect= filter_input(INPUT_GET, 'Firewall', FILTER_SANITIZE_SPECIAL_CHARS);
                        $vicidialselect= filter_input(INPUT_GET, 'Vicidial', FILTER_SANITIZE_SPECIAL_CHARS);
                        $settingsselect= filter_input(INPUT_GET, 'Settings', FILTER_SANITIZE_SPECIAL_CHARS);
                        $companyselect= filter_input(INPUT_GET, 'company', FILTER_SANITIZE_SPECIAL_CHARS);
                        $Googleselect= filter_input(INPUT_GET, 'Google', FILTER_SANITIZE_SPECIAL_CHARS);
                        $PostCodeselect= filter_input(INPUT_GET, 'PostCode', FILTER_SANITIZE_SPECIAL_CHARS);
                        
                         if($companyselect=='y') { 
                             
                                                         
                            $cdquery = $pdo->prepare("select company_name, contact_person, ip_address, contact_number from company_details limit 1");
                            $cdquery->execute()or die(print_r($query->errorInfo(), true));
                            $companydetailsq=$cdquery->fetch(PDO::FETCH_ASSOC);
                            
                            $cdname=$companydetailsq['company_name'];
                            $cdcp=$companydetailsq['contact_person'];
                            $cdip=$companydetailsq['ip_address'];
                            $cdcn=$companydetailsq['contact_number'];
                             
                             ?>
                        <h1><i class="fa fa-info-circle"></i> Company Settings</h1>
                        
                                               <?php
                        
                        $companydetails= filter_input(INPUT_GET, 'companydetails', FILTER_SANITIZE_SPECIAL_CHARS);
                        
                        if(isset($companydetails)){
    
      $companydetails= filter_input(INPUT_GET, 'companydetails', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($companydetails =='y') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Company details updated!</div><br>");
    }

            if ($companydetails =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}      

                        $companylogo= filter_input(INPUT_GET, 'companylogo', FILTER_SANITIZE_SPECIAL_CHARS);
                        
                        if(isset($companylogo)){
    
      $companylogo= filter_input(INPUT_GET, 'companylogo', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($companylogo =='y') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Company logo updated!</div><br>");
    }
    
     if ($companylogo =='deleted') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Deleted:</strong> Image deleted!</div><br>");
    }

            if ($companylogo =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}      
                        
    ?>   
                        
                        <p>Configuring these settings will dynamically update your CRM</p>
                        <br>
                        
                        <ul class="nav nav-pills">
                            <li class="active"><a data-toggle="pill" href="#"><i class="fa  fa-info-circle"></i></a></li>
                            <li><a data-toggle="pill" href="#ComInfo">Company Info</a></li>
                            <li><a data-toggle="pill" href="#ComLogo">Add Logo</a></li>
                        </ul>
                        <br>
                        
                        <div class="tab-content">
                            <div id="ComInfo" class="tab-pane fade">
                        
                        <br>           
                        
                        <form class="form-horizontal" method="POST" action="../php/AddCompanyDetails.php?company">
                            <fieldset>
                                <legend>Settings</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="companyname">Company Name</label>
                                    <div class="col-md-4">
                         <input id="companyname" name="companyname" placeholder="" class="form-control input-md" required="" <?php if(isset($cdname)){ echo "value='$cdname'";}?> type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="contactname">Contact Name</label>
                                    <div class="col-md-4">
                                        <input id="contactname" name="contactname" placeholder="" class="form-control input-md" <?php if(isset($cdname)){ echo "value='$cdcp'";}?>  type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="companynum">Contact #</label>
                                    <div class="col-md-4">
                                        <input id="companynum" name="companynum" placeholder="" class="form-control input-md" required="" <?php if(isset($cdname)){ echo "value='$cdcn'";}?>  type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="companyip">Company Public IP</label>
                                    <div class="col-md-4">
                                        <input id="companyip" name="companyip" placeholder="192.169.1.1" class="form-control input-md" required="" <?php if(isset($cdname)){ echo "value='$cdip'";}?>  type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="singlebutton"></label>
                                    <div class="col-md-4">
                                        <button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                                
                            </fieldset>
                        </form>   
                        
                            </div>
                            
                            <div id="ComLogo" class="tab-pane fade">
                                
                                <form action="../php/CompanyImageUpload.php?CompImage" method="post" enctype="multipart/form-data">
                                    <label for="file">Select file...
                                        <input type="file" name="file" />
                                    </label>
                                    <label for="uploadtype">
                                        <div class="form-group">
                                            <select style="width: 170px" class="form-control" name="uploadtype" required>
                                                <option value="">Select...</option>
                                                <option value="Login Logo">Login Logo</option>
                                                <option value="Email Account 1">Email Account 1</option>
                                                <option value="Email Account 2">Email Account 2</option>
                                                <option value="Email Account 3">Email Account 3</option>
                                                <option value="Email Account 4">Email Account 4</option>
                                            </select>
                                        </div>
                                    </label>
                                    <button type="submit" class="btn btn-success" name="submit"><span class="glyphicon glyphicon-arrow-up"> </span></button>
                                </form>
                                
                                <?php
                                
                                $cimages = $pdo->prepare("SELECT id, file from tbl_uploads where uploadtype = 'Login Logo' OR uploadtype like 'Email Account %'");
                                $cimages->execute();
                                $imgcomformid=0;
                                
                                echo "<table class=\"table table-hover\">";
                                echo 
                                "<thead>
                                    <tr>
                                    <th colspan='3'><h3><span class=\"label label-info\">Uploaded Images</span></h3></th>
                                    </tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th></th>
                                    </tr>
                                    </thead>";
                                
                                if ($cimages->rowCount()>0) {
                                    while ($comimages=$cimages->fetch(PDO::FETCH_ASSOC)){
                                        $imgcomformid++;
                                        
                                        echo '<tr>';
                                        echo "<td>".$comimages['id']."</td>";
                                        echo "<td>".$comimages['file']."</td>";
                                        	echo "<form id='comimgdelete$imgcomformid' action='../php/DeleteCompanyImage.php?deleteimage=y' method='POST'>";
                                                echo "<input type='hidden' name='uploadid' value='".$comimages['id']."'>";
                                                echo "<input type='hidden' name='uploadfile' value='".$comimages['file']."'>";
                                                echo "<td><button type=\"submit\" name=\"deletenotessubmit\" class=\"btn btn-danger btn-xs\"><span class=\"glyphicon glyphicon-remove\"></span></button></td>";
                                                echo "</form>";
                                                echo "</tr>";
                                                echo "\n";
                                           ?>
                                <script>
        document.querySelector('#comimgdelete<?php echo $imgcomformid?>').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Delete task?",
                text: "Are you sure you want to delete this task?",
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
                        title: 'Deleted!',
                        text: 'task deleted!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "Task deleted", "error");
                }
            });
        });

</script>
   <?php

    }
} else {
    echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}
echo "</table>";
?>        
                            </div> 
                        </div>
                        
                        <?php }
                        
                        if($Googleselect=='y') { 
                            
                            $gdquery = $pdo->prepare("select tracking_id, api from google_dev limit 1");
                            $gdquery->execute()or die(print_r($query->errorInfo(), true));
                            $gdre=$gdquery->fetch(PDO::FETCH_ASSOC);
                            
                            $gdtracking=$gdre['tracking_id'];
                            $gdapi=$gdre['api'];

                            
                            ?>
                        
                        <h1><i class="fa fa-google"></i> Developer Settings</h1> 
                        <?php
                        
                                                $google= filter_input(INPUT_GET, 'google', FILTER_SANITIZE_SPECIAL_CHARS);
                        
                        if(isset($google)){
    

    if ($google =='updated') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Google settings updated!</div><br>");
    }
    
     if ($google =='y') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Google settings added!</div><br>");
    }

            if ($google =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}      
                        
                        ?>
                        <form class="form-horizontal" method="POST" action="../php/AddGoogleDeveloper.php?add=y">
                            <fieldset>
                                <legend>Web/Android/iOS Development</legend>   
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="googletrackingid">Tracking ID</label>  
                                    <div class="col-md-4">
                                        <input id="googletrackingid" name="googletrackingid" placeholder="" <?php if(isset($gdtracking)) { echo "value='$gdtracking'";}?> class="form-control input-md" type="text">
                                        <span class="help-block">developers.google.com</span> 
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="googleapi">API</label> 
                                    <div class="col-md-4">
                                        <input id="googleapi" name="googleapi" placeholder="" <?php if(isset($gdapi)) { echo "value='$gdapi'";}?> class="form-control input-md" type="text">
                                        <span class="help-block">developers.google.com</span>  
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="submit"></label>
                                    <div class="col-md-4">
                                        <button id="submit" name="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            
                            </fieldset>
                        </form>
                        
                        <?php
                        } 
                        
                        
                        if($PostCodeselect=='y') {
                            
                            $PostcodeQuery = $pdo->prepare("select api_key from api_keys WHERE type ='PostCode' limit 1");
                            $PostcodeQuery->execute()or die(print_r($query->errorInfo(), true));
                            $PDre=$PostcodeQuery->fetch(PDO::FETCH_ASSOC);
                            
                            $PostCodeKey=$PDre['api_key'];
                            
                            ?>
                        
                        <h1><i class="fa fa-search"></i> Post Code Lookup API Key</h1>
                        
                        <?php
                        if($PostCodeselect=='y') {
                            
                            $PostCodeMSG= filter_input(INPUT_GET, 'PostCodeMSG', FILTER_SANITIZE_NUMBER_INT);
                            
                            if ($PostCodeMSG =='1') {

echo "<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> API Key updated!</div><br>";
    }
    
     if ($PostCodeMSG =='2') {

echo "<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> API Keey added!</div><br>";
    }

            if ($PostCodeMSG =='3') {

echo "<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>";
    }
                        }             
                        
                        ?>
                        
                        <form class="form-horizontal" method="POST" action="php/AddAPIKey.php?AddType=PostCode">
                            <fieldset>
                                <legend>Ideal Post Code API Key</legend>   
                                                               
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="PostCodeAPI">API</label> 
                                    <div class="col-md-4">
                                        <input id="PostCodeAPI" name="PostCodeAPI" placeholder="" <?php if(isset($PostCodeKey)) { echo "value='$PostCodeKey'";}?> class="form-control input-md" type="text">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="submit"></label>
                                    <div class="col-md-4">
                                        <button id="submit" name="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            
                            </fieldset>
                        </form>
                                                  
                            
                        <?php }
                        
                        
                        if($SMSselect=='y') {
                            
                            $smsquery = $pdo->prepare("select smsprovider, smsusername, smspassword from sms_accounts limit 1");
                            $smsquery->execute()or die(print_r($query->errorInfo(), true));
                            $smsaccount=$smsquery->fetch(PDO::FETCH_ASSOC);
                            
                            $smsuser=$smsaccount['smsusername'];
                            $smspass=$smsaccount['smspassword'];
                            $smspro=$smsaccount['smsprovider'];
                            ?>
                        
                        
                            
                        <h1><i class="fa fa-commenting-o"></i> SMS Configuration</h1>
                        <br>                            
                        <?php $getsmsbal = file_get_contents("https://www.bulksms.co.uk/eapi/user/get_credits/1/1.1?username=$smsuser&password=$smspass");
                                
                                $str = substr($getsmsbal, 2); ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th>Provider</th>
                                <th>Balance</th>
                                </tr>
                            </thead>
                            <tr>
                            <td><?php echo $smspro;?></td>
                            <td <?php if($str>='1') { echo 'bgcolor="#85E085"';} else { echo 'bgcolor="#FF4D4D"'; } ?>>
                                <?php
                                
                                if($str>='1') {
                                    echo $str;
                                }
                                    
                                ?>
                            </td>
                            </tr>
                        </table>
                            
                            <?php
                        
                        $smsaccount= filter_input(INPUT_GET, 'smsaccount', FILTER_SANITIZE_SPECIAL_CHARS);


if(isset($smsaccount)){
    
      $smsaccount= filter_input(INPUT_GET, 'smsaccount', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($smsaccount =='y') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> SMS account updated!</div><br>");
    }
    
        if ($smsaccount =='messadded') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> SMS message added updated!</div><br>");
    }
            if ($smsaccount =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}    

$SMSupdated= filter_input(INPUT_GET, 'SMSupdated', FILTER_SANITIZE_SPECIAL_CHARS);        

        if(isset($SMSupdated)){
    
      $SMSupdated= filter_input(INPUT_GET, 'SMSupdated', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($SMSupdated =='y') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> SMS template updated!</div><br>");
    }
    

            if ($SMSupdated =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}    
                            

                            
                            ?>
                        
                                                    <ul class="nav nav-pills">
        <li class="active"><a data-toggle="pill" href="#"><i class="fa  fa-envelope-o"></i></a></li>
        <li><a data-toggle="pill" href="#SMSTemplates">SMS Templates</a></li>
        <li><a data-toggle="pill" href="#SMSAddmessage">Add message</a></li>
        <li><a data-toggle="pill" href="#SMSSettings">SMS Settings</a></li>

                            </ul>
                        <br>
                        
                        <div class="tab-content">
                            
                            <div id="SMSTemplates" class="tab-pane fade">
                                
                                                            <?php

$query = $pdo->prepare("SELECT id, title, message from sms_templates");

echo "<table class=\"table table-hover\">";

echo "  <thead>
	<tr>
	<th colspan='4'>SMS Templates</th>
	</tr>
    	<tr>
	<th>ID</th>
	<th>Title</th>
	<th>Message</th>
	<th></th>
	</tr>
	</thead>";

$query->execute();
$i=0;
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
$i++;
	echo '<tr>';
	echo "<td>".$result['id']."</td>";
	echo "<td>".$result['title']."</td>";
 	echo "<td>".$result['message']."</td>";
   echo "<td>
<button data-toggle='modal' data-target='#editsms$i' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> </button>


<div id=\"editsms$i\" class=\"modal fade\" role=\"dialog\">
  <div class=\"modal-dialog\">

    <div class=\"modal-content\">
      <div class=\"modal-header\">
      <h4 class='modal-title'>SMS Template</h4>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
      </div>
      <div class=\"modal-body\">
        <form action=\"../php/SMSupdate.php?updatesms=y\" name=\"updatesms\" class=\"form-horizontal\" method=\"POST\">
                
<fieldset>

<legend>SMS Edit</legend>

<input type=\"hidden\" name=\"id\" value='".$result['id']."'>

<div class='form-group'>
  <label class='col-sm-2 control-label' for='title'></label>  
  <div class='col-sm-10'>
  <input id='title' name='title' placeholder='' value='".$result['title']."' class='form-control input-md' required='' type='readonly'>
    
  </div>
</div>

<div class='form-group'>
  <label class='col-sm-2 control-label' for='message'></label>
  <div class='col-sm-10'>                     
    <textarea class='form-control' style='min-width: 100%' id='message' name='message'>".$result['message']."</textarea>
  </div>
</div>

<div class='form-group'>
  <label class='col-sm-2 control-label' for='singlebutton'></label>
  <div class='col-sm-10'>
    <button id='singlebutton' name='singlebutton' class='btn btn-primary'>Submit changes</button>
  </div>
</div>

</fieldset>


        </form>
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-warning\" data-dismiss=\"modal\">Close</button>
      </div>
    </div>

  </div>
</div>   
   </td>";
	echo "</tr>";
	echo "\n";
	}
} else {
   echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}
echo "</table>";

?>
                                
                            </div>
                            

                            
                            
                            <div id="SMSAddmessage" class="tab-pane fade">
                                
                                <p>Add new SMS message(s).</p>
                                
                                <form class="form-horizontal" method="POST" action="../php/Addsmsaccounts.php?newsmsmessage=y">
<fieldset>

<legend>New SMS</legend>


<div class="form-group">
  <label class="col-md-4 control-label" for="title">Title</label>  
  <div class="col-md-4">
  <input id="title" name="smstitle" placeholder="" class="form-control input-md" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="message">Message</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="smsmessage" name="smsmessage"></textarea>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
  </div>
</div>

</fieldset>
</form>

                                
                                
                            </div>
                            
 <div id="SMSSettings" class="tab-pane fade">
     
     <p>Enter you SMS provider/gateway settings here.</p>
                        
                        <form class="form-horizontal" method="POST" action="../php/Addsmsaccounts.php?addsms">
                            <fieldset>
                                <legend>SMS Settings</legend>

<div class="form-group">
  <label class="col-md-4 control-label" for="smsprovider">Provider</label>
  <div class="col-md-4">
    <select id="smsprovider" name="smsprovider" class="form-control" required>
                <?php if(isset($smspro)){ ?>
        <option value="<?php echo $smspro;?>"><?php echo $smspro;?></option>
        <?php } else {?>
        <option value="">Select...</option><?php }?>
      <option value="Bulk SMS">Bulk SMS</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="smsusername">Username</label>  
  <div class="col-md-4">
  <input id="smsusername" name="smsusername" placeholder="" class="form-control input-md" value="<?php echo $smsuser;?>" required="" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="smspassword">Password</label>
  <div class="col-md-4">
    <input id="smspassword" name="smspassword" placeholder="" class="form-control input-md" value="<?php echo $smspass;?>" required="" type="password">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="submitsms" name="submitsms" class="btn btn-success">Submit</button>
  </div>
</div>

</fieldset>
</form>

 </div>
                            
                        </div>
                        
                        <?php }
                                                
                        if($Emailselect=='y') { ?>
                       
                        <h1><i class="fa fa-envelope-o"></i> Email Configuration</h1>
                        
                                                <?php
                        
                        $emailaccount= filter_input(INPUT_GET, 'emailaccount', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($emailaccount)){
    
      $emailaccount= filter_input(INPUT_GET, 'emailaccount', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($emailaccount =='account1') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Settings for email account 1 updated!</div><br>");
    }
    
        if ($emailaccount =='account2') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Settings for email account 2 updated!</div><br>");
    }
    
            if ($emailaccount =='account3') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Settings for email account 3 updated!</div><br>");
    }
    
            if ($emailaccount =='account4') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Settings for email account 4 updated!</div><br>");
    }
            if ($emailaccount =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}                
                        ?>
                        
                        <p>Email account settings can be found on your email providers web page. Too add an account click one of the options below.</p>
                        
                            <ul class="nav nav-pills">
        <li class="active"><a data-toggle="pill" href="#"><i class="fa  fa-cogs"></i></a></li>
        <li><a data-toggle="pill" href="#account1">Account 1</a></li>
        <li><a data-toggle="pill" href="#account2">Account 2</a></li>
        <li><a data-toggle="pill" href="#account3">Account 3</a></li>
        <li><a data-toggle="pill" href="#account4">Account 4</a></li>
        <li><a data-toggle="pill" href="#emailsig">Signatures</a></li>
                            </ul>
                        <br>
                        
                        <div class="tab-content">
 <div id="account1" class="tab-pane fade">
     <?php
     
$emailaccid="account1";
        
        $query = $pdo->prepare("select imap, imapport, popport, pop, emailtype, email, emailfrom, emailreply, emailbcc, emailsubject, smtp, smtpport, displayname, password from email_accounts where emailaccount=:emailaccidholder");
        $query->bindParam(':emailaccidholder', $emailaccid, PDO::PARAM_STR);
$query->execute()or die(print_r($query->errorInfo(), true));
$emailacc1=$query->fetch(PDO::FETCH_ASSOC);

        $emailfromdb=$emailacc1['emailfrom'];
        $emailbccdb=$emailacc1['emailbcc'];
        $emailreplydb=$emailacc1['emailreply'];
        $emailsubjectdb=$emailacc1['emailsubject'];
        $emailsmtpdb=$emailacc1['smtp'];
        $emailsmtpportdb=$emailacc1['smtpport'];
        $emaildisplaynamedb=$emailacc1['displayname'];
        $passworddb=$emailacc1['password'];
        $emaildb=$emailacc1['email'];
        $emailtype=$emailacc1['emailtype'];
        $pop=$emailacc1['pop'];
        $popport=$emailacc1['popport'];
        $imap=$emailacc1['imap'];
        $imapport=$emailacc1['imapport'];
                        ?>
                        <form class="form-horizontal" method="POST" action="../php/AddEmailAccounts.php?add=y">
                            <fieldset>

<legend>Email Settings (Account 1)</legend>

<input type="hidden" value="account1" name="emailaccount">

<div class="form-group">
  <label class="col-md-4 control-label" for="displayname">Display Name</label>  
  <div class="col-md-4">
  <input id="displayname" name="displayname" placeholder="Company name" value="<?php echo $emaildisplaynamedb;?>" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailfrom">From:</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailfrom" class="form-control input-md" required="" value="<?php echo $emailfromdb;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailreply">Reply to:</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailreply" class="form-control input-md" required="" value="<?php echo $emailreplydb;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailbcc">Bcc (optional):</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailbcc" class="form-control input-md" value="<?php echo $emailbccdb;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailsubject">Email Subject</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailsubject" placeholder="Keyfacts Document" class="form-control input-md" required="" value="<?php echo $emailsubjectdb;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Type</label>
  <div class="col-md-4">
    <select id="emailtype" name="emailtype" class="form-control" required>
        <?php if(isset($emailsubjectdb)){ ?>
        <option value="<?php echo $emailtype;?>"><?php echo $emailtype;?></option>
            
        <?php } else {?>
        <option value="">Select...</option><?php }?>
      <option value="Customer-facing">Customer-facing (Outbound emails)</option>
      <option value="Main Email">Main Email (Incoming emails)</option>
      <option value="Catch All">Catch All (All emails)</option>
      <option value="Key Facts">Key Facts</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="pop">Incoming mail server (POP)</label>  
  <div class="col-md-4">
  <input id="pop" name="pop" placeholder="pop.123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $pop;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="popport">POP Port</label>  
  <div class="col-md-4">
  <input id="popport" name="popport" placeholder=" 995" class="form-control input-md" required="" value="<?php echo $popport;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="imap">Incoming mail server (IMAP)</label>  
  <div class="col-md-4">
  <input id="imap" name="imap" placeholder="imap.123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $imap;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="imapport">IMAP Port</label>  
  <div class="col-md-4">
  <input id="imapport" name="imapport" placeholder="993" class="form-control input-md" required="" value="<?php echo $imapport;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="smtp">Outgoing mail server (SMTP)</label>  
  <div class="col-md-4">
  <input id="smtp" name="smtp" placeholder="smtp.123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $emailsmtpdb;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="smtpport">SMTP Port</label>  
  <div class="col-md-4">
  <input id="smtpport" name="smtpport" placeholder="465" class="form-control input-md" required="" value="<?php echo $emailsmtpportdb;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>  
  <div class="col-md-4">
  <input id="email" name="email" placeholder="bobross@123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $emaildb;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="password">Password:</label>
  <div class="col-md-4">
      <input id="password" name="password" placeholder="******************" class="form-control input-md" required="" value="<?php echo $passworddb;?>" type="password">
    
  </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <button id="submitemailsettings" name="submitemailsettings" class="btn btn-success">Submit</button>
  </div>
</div>

</fieldset>
</form>
</div>
                            
                            <div id="account2" class="tab-pane fade">
                                <?php
                                $emailaccid2="account2";        

$query = $pdo->prepare("select imap, imapport, popport, pop, emailtype, email, emailfrom, emailreply, emailbcc, emailsubject, smtp, smtpport, displayname, password from email_accounts where emailaccount=:emailaccid2holder");
        $query->bindParam(':emailaccid2holder', $emailaccid2, PDO::PARAM_STR);
$query->execute()or die(print_r($query->errorInfo(), true));
$emailacc2=$query->fetch(PDO::FETCH_ASSOC);

        $emailfromdb2=$emailacc2['emailfrom'];
        $emailbccdb2=$emailacc2['emailbcc'];
        $emailreplydb2=$emailacc2['emailreply'];
        $emailsubjectdb2=$emailacc2['emailsubject'];
        $emailsmtpdb2=$emailacc2['smtp'];
        $emailsmtpportdb2=$emailacc2['smtpport'];
        $emaildisplaynamedb2=$emailacc2['displayname'];
        $passworddb2=$emailacc2['password'];
        $emaildb2=$emailacc2['email'];
        $emailtype2=$emailacc2['emailtype'];
        $pop2=$emailacc2['pop'];
        $popport2=$emailacc2['popport'];
        $imap2=$emailacc2['imap'];
        $imapport2=$emailacc2['imapport'];
        
        ?>
                                
                                 <form class="form-horizontal" method="POST" action="../php/AddEmailAccounts.php?add=y">
                            <fieldset>

<legend>Email Settings (Account 2)</legend>

<input type="hidden" value="account2" name="emailaccount">

<div class="form-group">
  <label class="col-md-4 control-label" for="displayname">Display Name</label>  
  <div class="col-md-4">
  <input id="displayname" name="displayname" placeholder="Company name" value="<?php echo $emaildisplaynamedb2;?>" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailfrom">From:</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailfrom" class="form-control input-md" required="" value="<?php echo $emailfromdb2;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailreply">Reply to:</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailreply" class="form-control input-md" required="" value="<?php echo $emailreplydb2;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailbcc">Bcc (optional):</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailbcc" class="form-control input-md" value="<?php echo $emailbccdb2;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailsubject">Email Subject</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailsubject" placeholder="Keyfacts Document" class="form-control input-md" required="" value="<?php echo $emailsubjectdb2;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Type</label>
  <div class="col-md-4">
    <select id="emailtype" name="emailtype" class="form-control" required>
        <?php if(isset($emailsubjectdb2)){ ?>
        <option value="<?php echo $emailtype2;?>"><?php echo $emailtype2;?></option>
            
        <?php } else {?>
        <option value="">Select...</option><?php }?>
      <option value="Customer-facing">Customer-facing (Outbound emails)</option>
      <option value="Main Email">Main Email (Incoming emails)</option>
      <option value="Catch All">Catch All (All emails)</option>
      <option value="Key Facts">Key Facts</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="pop">Incoming mail server (POP)</label>  
  <div class="col-md-4">
  <input id="pop" name="pop" placeholder="pop.123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $pop2;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="popport">POP Port</label>  
  <div class="col-md-4">
  <input id="popport" name="popport" placeholder=" 995" class="form-control input-md" required="" value="<?php echo $popport2;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="imap">Incoming mail server (IMAP)</label>  
  <div class="col-md-4">
  <input id="imap" name="imap" placeholder="imap.123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $imap2;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="imapport">IMAP Port</label>  
  <div class="col-md-4">
  <input id="imapport" name="imapport" placeholder="993" class="form-control input-md" required="" value="<?php echo $imapport2;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="smtp">Outgoing mail server (SMTP)</label>  
  <div class="col-md-4">
  <input id="smtp" name="smtp" placeholder="smtp.123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $emailsmtpdb2;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="smtpport">SMTP Port</label>  
  <div class="col-md-4">
  <input id="smtpport" name="smtpport" placeholder="465" class="form-control input-md" required="" value="<?php echo $emailsmtpportdb2;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>  
  <div class="col-md-4">
  <input id="email" name="email" placeholder="bobross@123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $emaildb2;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="password">Password:</label>
  <div class="col-md-4">
      <input id="password" name="password" placeholder="******************" class="form-control input-md" required="" value="<?php echo $passworddb2;?>" type="password">
    
  </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <button id="submitemailsettings" name="submitemailsettings" class="btn btn-success">Submit</button>
  </div>
</div>

</fieldset>
</form>
                                
                            </div>
                            <div id="account3" class="tab-pane fade">
                                <?php 
                                
                                $emailaccid3="account3";        

$query = $pdo->prepare("select imap, imapport, popport, pop, emailtype, email, emailfrom, emailreply, emailbcc, emailsubject, smtp, smtpport, displayname, password from email_accounts where emailaccount=:emailaccid3holder");
        $query->bindParam(':emailaccid3holder', $emailaccid3, PDO::PARAM_STR);
$query->execute()or die(print_r($query->errorInfo(), true));
$emailacc3=$query->fetch(PDO::FETCH_ASSOC);

        $emailfromdb3=$emailacc3['emailfrom'];
        $emailbccdb3=$emailacc3['emailbcc'];
        $emailreplydb3=$emailacc3['emailreply'];
        $emailsubjectdb3=$emailacc3['emailsubject'];
        $emailsmtpdb3=$emailacc3['smtp'];
        $emailsmtpportdb3=$emailacc3['smtpport'];
        $emaildisplaynamedb3=$emailacc3['displayname'];
        $passworddb3=$emailacc3['password'];
        $emaildb3=$emailacc3['email'];
        $emailtype3=$emailacc3['emailtype'];
        $pop3=$emailacc3['pop'];
        $popport3=$emailacc3['popport'];
        $imap3=$emailacc3['imap'];
        $imapport3=$emailacc3['imapport'];
                                
                                ?>
                                 <form class="form-horizontal" method="POST" action="../php/AddEmailAccounts.php?add=y">
                            <fieldset>

<legend>Email Settings (Account 3)</legend>

<input type="hidden" value="account3" name="emailaccount">

<div class="form-group">
  <label class="col-md-4 control-label" for="displayname">Display Name</label>  
  <div class="col-md-4">
  <input id="displayname" name="displayname" placeholder="Company name" value="<?php echo $emaildisplaynamedb3;?>" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailfrom">From:</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailfrom" class="form-control input-md" required="" value="<?php echo $emailfromdb3;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailreply">Reply to:</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailreply" class="form-control input-md" required="" value="<?php echo $emailreplydb3;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailbcc">Bcc (optional):</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailbcc" class="form-control input-md" value="<?php echo $emailbccdb3;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailsubject">Email Subject</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailsubject" placeholder="Keyfacts Document" class="form-control input-md" required="" value="<?php echo $emailsubjectdb3;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Type</label>
  <div class="col-md-4">
    <select id="emailtype" name="emailtype" class="form-control" required>
        <?php if(isset($emailsubjectdb3)){ ?>
        <option value="<?php echo $emailtype3;?>"><?php echo $emailtype3;?></option>
            
        <?php } else {?>
        <option value="">Select...</option><?php }?>
      <option value="Customer-facing">Customer-facing (Outbound emails)</option>
      <option value="Main Email">Main Email (Incoming emails)</option>
      <option value="Catch All">Catch All (All emails)</option>
      <option value="Key Facts">Key Facts</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="pop">Incoming mail server (POP)</label>  
  <div class="col-md-4">
  <input id="pop" name="pop" placeholder="pop.123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $pop3;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="popport">POP Port</label>  
  <div class="col-md-4">
  <input id="popport" name="popport" placeholder=" 995" class="form-control input-md" required="" value="<?php echo $popport3;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="imap">Incoming mail server (IMAP)</label>  
  <div class="col-md-4">
  <input id="imap" name="imap" placeholder="imap.123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $imap3;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="imapport">IMAP Port</label>  
  <div class="col-md-4">
  <input id="imapport" name="imapport" placeholder="993" class="form-control input-md" required="" value="<?php echo $imapport3;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="smtp">Outgoing mail server (SMTP)</label>  
  <div class="col-md-4">
  <input id="smtp" name="smtp" placeholder="smtp.123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $emailsmtpdb3;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="smtpport">SMTP Port</label>  
  <div class="col-md-4">
  <input id="smtpport" name="smtpport" placeholder="465" class="form-control input-md" required="" value="<?php echo $emailsmtpportdb3;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>  
  <div class="col-md-4">
  <input id="email" name="email" placeholder="bobross@123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $emaildb3;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="password">Password:</label>
  <div class="col-md-4">
      <input id="password" name="password" placeholder="******************" class="form-control input-md" required="" value="<?php echo $passworddb3;?>" type="password">
    
  </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <button id="submitemailsettings" name="submitemailsettings" class="btn btn-success">Submit</button>
  </div>
</div>

</fieldset>
</form>
                                
                            </div>
                            <div id="account4" class="tab-pane fade">
                                
                                <?php
                                
                                $emailaccid4="account4";        

$query = $pdo->prepare("select imap, imapport, popport, pop, emailtype, email, emailfrom, emailreply, emailbcc, emailsubject, smtp, smtpport, displayname, password from email_accounts where emailaccount=:emailaccid4holder");
        $query->bindParam(':emailaccid4holder', $emailaccid4, PDO::PARAM_STR);
$query->execute()or die(print_r($query->errorInfo(), true));
$emailacc4=$query->fetch(PDO::FETCH_ASSOC);

        $emailfromdb4=$emailacc4['emailfrom'];
        $emailbccdb4=$emailacc4['emailbcc'];
        $emailreplydb4=$emailacc4['emailreply'];
        $emailsubjectdb4=$emailacc4['emailsubject'];
        $emailsmtpdb4=$emailacc4['smtp'];
        $emailsmtpportdb4=$emailacc4['smtpport'];
        $emaildisplaynamedb4=$emailacc4['displayname'];
        $passworddb4=$emailacc4['password'];
        $emaildb4=$emailacc4['email'];
        $emailtype4=$emailacc4['emailtype'];
        $pop4=$emailacc4['pop'];
        $popport4=$emailacc4['popport'];
        $imap4=$emailacc4['imap'];
        $imapport4=$emailacc4['imapport'];
                                
                                ?>
                                
                                 <form class="form-horizontal" method="POST" action="../php/AddEmailAccounts.php?add=y">
                            <fieldset>

<legend>Email Settings (Account 4)</legend>

<input type="hidden" value="account4" name="emailaccount">

<div class="form-group">
  <label class="col-md-4 control-label" for="displayname">Display Name</label>  
  <div class="col-md-4">
  <input id="displayname" name="displayname" placeholder="Company name" value="<?php echo $emaildisplaynamedb4;?>" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailfrom">From:</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailfrom" class="form-control input-md" required="" value="<?php echo $emailfromdb4;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailreply">Reply to:</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailreply" class="form-control input-md" required="" value="<?php echo $emailreplydb4;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailbcc">Bcc (optional):</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailbcc" class="form-control input-md" value="<?php echo $emailbccdb4;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="emailsubject">Email Subject</label>  
  <div class="col-md-4">
  <input id="displayname" name="emailsubject" placeholder="Keyfacts Document" class="form-control input-md" required="" value="<?php echo $emailsubjectdb4;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Type</label>
  <div class="col-md-4">
    <select id="emailtype" name="emailtype" class="form-control" required>
        <?php if(isset($emailsubjectdb3)){ ?>
        <option value="<?php echo $emailtype4;?>"><?php echo $emailtype4;?></option>
            
        <?php } else {?>
        <option value="">Select...</option><?php }?>
      <option value="Customer-facing">Customer-facing (Outbound emails)</option>
      <option value="Main Email">Main Email (Incoming emails)</option>
      <option value="Catch All">Catch All (All emails)</option>
      <option value="Key Facts">Key Facts</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="pop">Incoming mail server (POP)</label>  
  <div class="col-md-4">
  <input id="pop" name="pop" placeholder="pop.123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $pop4;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="popport">POP Port</label>  
  <div class="col-md-4">
  <input id="popport" name="popport" placeholder=" 995" class="form-control input-md" required="" value="<?php echo $popport4;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="imap">Incoming mail server (IMAP)</label>  
  <div class="col-md-4">
  <input id="imap" name="imap" placeholder="imap.123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $imap4;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="imapport">IMAP Port</label>  
  <div class="col-md-4">
  <input id="imapport" name="imapport" placeholder="993" class="form-control input-md" required="" value="<?php echo $imapport4;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="smtp">Outgoing mail server (SMTP)</label>  
  <div class="col-md-4">
  <input id="smtp" name="smtp" placeholder="smtp.123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $emailsmtpdb4;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="smtpport">SMTP Port</label>  
  <div class="col-md-4">
  <input id="smtpport" name="smtpport" placeholder="465" class="form-control input-md" required="" value="<?php echo $emailsmtpportdb4;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>  
  <div class="col-md-4">
  <input id="email" name="email" placeholder="bobross@123-reg.co.uk" class="form-control input-md" required="" value="<?php echo $emaildb4;?>" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="password">Password:</label>
  <div class="col-md-4">
      <input id="password" name="password" placeholder="******************" class="form-control input-md" required="" value="<?php echo $passworddb4;?>" type="password">
    
  </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <button id="submitemailsettings" name="submitemailsettings" class="btn btn-success">Submit</button>
  </div>
</div>

</fieldset>
</form>
                                
                            </div>
                            
                            <div id="emailsig" class="tab-pane fade">
                                
                                <iframe src="../bootstrap-wysiwyg-master/Notestest.php"  width="100%" height="500px" frameBorder="0"></iframe> 
                                
                                <?php
                                
                        $query = $pdo->prepare("select sig from email_signatures");
                        $query->execute();                                
                        if ($query->rowCount()>0) {
                            while ($pullsigs=$query->fetch(PDO::FETCH_ASSOC)){
                                
                                echo"<p>".$pullsigs['sig']."</p>";
                                
                            }
                            }
                                ?>
                                
                                
                            </div>
                            
                           
                            
                        </div>
                            
                        
                        <?php }
                                                
                        if($AssignTasksselect=='y') { 
                            
                            
               
                        
                        $TaskAssigned= filter_input(INPUT_GET, 'TaskAssigned', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($TaskAssigned)){
    
    $TaskAssignedTo= filter_input(INPUT_GET, 'TaskAssignedTo', FILTER_SANITIZE_SPECIAL_CHARS);
    $TASKUPDATED= filter_input(INPUT_GET, 'TASKUPDATED', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if ($TaskAssigned =='y') {

echo"<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Task $TASKUPDATED has been updated and assigned to $TaskAssignedTo!</div><br>";
    }
    
            if ($TaskAssigned =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}                
                        ?>
                            
                        <h1><i class="fa fa-tasks"></i> Assign Tasks</h1>
                        
                        
                        <legend>Tasks currently set</legend>
                        
                        <?php 
                        
                        $query = $pdo->prepare("SELECT assigned, task from Set_Client_Tasks");
                        
                        ?>
                        
                        <table id="Already Assigned" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Assigned</th>                                
                            </tr>
                        </thead>
                            
                            <?php
                            
                            $query->execute();
                            if ($query->rowCount()>0) {
                                while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                                    
                                    echo '<tr>';
                                    echo "<td>".$result['task']."</td>";
                                    echo "<td>".$result['assigned']."</td>";
                                    echo '</tr>';
                                }
                                }
                                
                                else { ?>
                        
                        <div class="notice notice-info" role="alert"><strong><i class="fa fa-exclamation-triangle fa-lg"></i> Info:</strong> No Tasks have been assigned yet!</div><br>

                        
                                <?php } ?>
                        </table>
                        <legend>Update who get assigned</legend>
                        <?php
                                
                        $TaskArray=array("CYD","24 48","5 day","18 day");
                        $arrlength=count($TaskArray);

                                        ?>
                        
                        <form class="form-inline" id="assinform" name="assinform" action="php/AssignTask.php?AssignTasks=1" method='POST'>
<fieldset>
    
    <div class="form-group">
  <label class="control-label" for="tasknames">Task</label>  

   
  <select name="tasknames" id="tasknames">
   <?php      for($x=0;$x<$arrlength;$x++)
  { ?><option value="<?php if (isset($TaskArray)) { echo $TaskArray[$x]; }?>"><?php if (isset($TaskArray)) { echo $TaskArray[$x]; }?></option>
      
     <?php } ?>   
  </select>

<div class="form-group">
  <label class="control-label" for="taskuser">Assign To</label>
    <select id="taskuser" name="taskuser" class="form-control">
        
        <?php if($companynamere=='The Review Bureau') { ?>
        
        <option value="Abbiek">Abbie</option>
        <option value="Jakob">Jakob</option>
        <option value="carys">Carys</option>
        <option value="Nicola">Nicola</option>
        
        <?php } if($companynamere=='Assura') {  ?>
        
        <option value="Tina">Tina</option>
        <option value="Nathan">Nathan</option>
        <?php } ?>

    </select>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="submittask"></label>
  <div class="col-md-4">
    <button class="btn btn-success"><i class="fa  fa-check-circle-o"></i></button>
  </div>
</div>

</fieldset>
</form>                        
<script>
        document.querySelector('#assinform').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Assign Task?",
                text: "Are you sure you want to assign this task?",
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
                        title: 'Assigned!',
                        text: 'Task assigned!',
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
   <?php

  }
                                                
                        if($usersselect=='y') { 
                            ?>
                            
                        <h1><i class="fa fa-user"></i> User configuration</h1>

                        <?php
                        
                                                 
                            
                                        $adduser= filter_input(INPUT_GET, 'adduser', FILTER_SANITIZE_NUMBER_INT);
                 
                  if(isset($adduser)){   
                
                if ($adduser =='1') {
                    
                    $user= filter_input(INPUT_GET, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    
                    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> User account for $user has been created!</div>";
                    
                }
                
                if ($adduser =='0') {
                    
                    $message= filter_input(INPUT_GET, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    
                    echo "<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa-exclamation-triangle fa-lg\"></i> Warning:</strong> User account not created. The following was not matched! $message</div>";
                    
                    
                }
                 
                }
                        
                        ?>
                        
                                                    <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#adduser">Add user</a></li>
        <li><a data-toggle="pill" href="#modifyuser">Modify Users</a></li>
                            </ul>
                        <br>
                        
                        <div class="tab-content">
 <div id="adduser" class="tab-pane fade in active">
     <form class="form-horizontal" name="form1" method="post" action="php/AddNewUser.php?adduser=1" autocomplete="off">
         <fieldset>
             <legend>Add new user</legend>

             <div class="form-group">
  <label class="col-md-4 control-label" for="login">Login:</label>
  <div class="col-md-4">
  <input class="form-control" style="width: 170px" type="text" name="login"  placeholder="(min, 4 chars)" required>
  </div>
             </div>
  
  <div class="form-group">
  <label class="col-md-4 control-label" for="password">Password:</label>
  <div class="col-md-4">
  <input class="form-control" style="width: 170px" type="password" name="password" placeholder="(min. 4 chars)" required>
  </div>
  </div>
  
  <div class="form-group">
  <label class="col-md-4 control-label" for="confirm">Confirm password:</label>
  <div class="col-md-4">
  <input  class="form-control" style="width: 170px" type="password" name="confirm"required>
  </div>
  </div>
  
  <div class="form-group">
  <label class="col-md-4 control-label" for="name">Real name:</label>
  <div class="col-md-4">
  <input class="form-control" style="width: 170px" type="text" name="name" required>
  </div>
  </div>

  <div class="form-group">
  <label class="col-md-4 control-label" for="email">E-mail:</label>
  <div class="col-md-4">
  <input class="form-control" style="width: 170px" type="text" name="email" required>
  </div>
  </div>

  <div class="form-group">
  <label class="col-md-4 control-label" for="info">Role:</label>
  <div class="col-md-4">
  <input class="form-control" style="width: 170px" type="text" name="info" required>
  </div>
  </div>
             
             <div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
<button id="singlebutton" type="submit" name="UserSubmit" value="Submit" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Add User</button>
  </div>
</div>
         </fieldset>
     </form>

     
     </div>
                            
                            <div id="modifyuser" class="tab-pane fade"></div>
                            
                            </div>
                        
                        <?php }
                        
                        if($adminselect=='y') { ?>
                            
                        <h1><i class="fa fa-cog"></i> Admin Dashboard</h1>
                        <p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>
                        <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>
                        
                        <?php } 
                        
                        if($fireselect=='y') { ?>
                            
                        <h1><i class="fa fa-fire"></i> Firewall Configuration</h1>
                        <p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>
                        <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>
                        
                        <div class="panel panel-primary">
  <div class="panel-heading">Add IP to whitelist</div>
  <div class="panel-body">

<?php
if($_GET["ip"])
{
        $thisip = $_GET["ip"];
        if(preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $thisip))
        {
                $old_path = getcwd();
                $output =shell_exec("bash addip.sh $thisip");
                echo "<pre>$output $thisip added</pre><br><a href='Admindash.php'>Add another</a>";
        }
        else
        {
                die("Enter a valid IP Address");
        }
}
else
{
        echo '<form autocomplete="off" id="from1" class="form-horizontal"  name="input" action="Admindash.php" method="get">';
        echo '<div class="form-group"><label class="col-md-4 control-label" for="enter">IP address:</label>  <div class="col-md-4"> <input class="form-control input-md" placeholder="94.23.217.206" type="text" name="ip"></div</div>';
        echo '<br>    <div class="form-group">
      <div class="col-xs-2"><button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Submit</button></div></div>';
        echo '<input type="hidden" value="y" name="Firewall"></form>';
}
?>
<script>
        document.querySelector('#from1').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Add IP?",
                text: "Submit IP address to firewall?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Complete!',
                        text: 'Firewall rules updated!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No Changes have been made", "error");
                }
            });
        });

    </script>
</div>
</div>
                        
                        <?php } 
                        
                        if($vicidialselect=='y') { ?>
                            
                        <h1><i class="fa fa-headphones"></i> Vicidial Integration</h1>
                        
                        <?php
                        
                        $vicidialaccount= filter_input(INPUT_GET, 'vicidialaccount', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($vicidialaccount)){
    
      $vicidialaccount= filter_input(INPUT_GET, 'vicidialaccount', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($vicidialaccount =='database') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Dialler settings for the database server have been updated!</div><br>");
    }
    
        if ($vicidialaccount =='telephony') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Dialler settings for the telephony server have been updated!</div><br>");
    }
            if ($vicidialaccount =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}                
                        ?>
                                               
                        <p>To pull information from your Vicidial system you will need to enter some settings.</p>
                        
                        <ul class="nav nav-pills">
        <li class="active"><a data-toggle="pill" href="#"><i class="fa fa-database"></i></a></li>
        <li><a data-toggle="pill" href="#dbserverset">Database Server</a></li>
        <li><a data-toggle="pill" href="#telserverset">Telephony Server</a></li>
                            </ul>
                        <br>
                        
                        <div class="tab-content">
                            
                            <div id="dbserverset" class="tab-pane fade">
                                
                                                                <?php
$servertype="Database";
    
    $query = $pdo->prepare("SELECT url, username, password, sqlpass, sqluser FROM vicidial_accounts where servertype=:typeholder");

        $query->bindParam(':typeholder', $servertype, PDO::PARAM_STR, 500);
        $query->execute()or die(print_r($query->errorInfo(), true));
$dataacc=$query->fetch(PDO::FETCH_ASSOC);

        $dataacurl=$dataacc['url'];
        $dataacusername=$dataacc['username'];
        $dataacpassword=$dataacc['password'];
        $dataacsqlpass=$dataacc['sqlpass'];
        $dataacuser=$dataacc['sqluser'];
                                
                                ?>
                                
                                <form class="form-horizontal" method="POST" action="../php/AddDiallerSettings.php?data=y">
<fieldset>

<legend>Database server</legend>

<div class="form-group">
  <label class="col-md-4 control-label" for="dbserverurl">URL/FQDN</label>  
  <div class="col-md-4">
  <input id="dbserverurl" name="dbserverurl" placeholder="dial132.bluetelecoms.com" value="<?php echo $dataacurl;?>" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="dbserveruser">Dialer username</label>  
  <div class="col-md-4">
  <input id="dbserveruser" name="dbserveruser" placeholder="9999" class="form-control input-md" value="<?php echo $dataacusername;?>" required="" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="dbserverpass">Dialer password</label>
  <div class="col-md-4">
    <input id="dbserverpass" name="dbserverpass" placeholder="***********" class="form-control input-md" value="<?php echo $dataacpassword;?>" required="" type="password">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="dbsqluser">SQL user</label>  
  <div class="col-md-4">
  <input id="dbsqluser" name="dbsqluser" placeholder="Only if the default has been changed" class="form-control input-md" value="<?php echo $dataacuser;?>" type="text">
  <span class="help-block">(optional)</span>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="dbsqlpass">SQL pass</label>
  <div class="col-md-4">
    <input id="dbsqlpass" name="dbsqlpass" placeholder="Only if the default has been changed" class="form-control input-md" value="<?php echo $dataacsqlpass;?>" type="password">
    <span class="help-block">(optional)</span>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="dbserversubmit"></label>
  <div class="col-md-4">
    <button id="dbserversubmit" name="dbserversubmit" class="btn btn-success">Submit</button>
  </div>
</div>

</fieldset>
</form>

                                
                                
                            </div>
                            
                            
                            <div id="telserverset" class="tab-pane fade">
                                
                                                                                                <?php
$servertype2="Telephony";
    
    $query = $pdo->prepare("SELECT url, username, password FROM vicidial_accounts where servertype=:typeholder");

        $query->bindParam(':typeholder', $servertype2, PDO::PARAM_STR, 500);
        $query->execute()or die(print_r($query->errorInfo(), true));
$telacc=$query->fetch(PDO::FETCH_ASSOC);

        $telaccurl=$telacc['url'];
        $telaccusername=$telacc['username'];
        $telaccpassword=$telacc['password'];
 
                                ?>
                                
                                
                                <form class="form-horizontal" method="POST" action="../php/AddDiallerSettings.php?tel=y">
<fieldset>

<legend>Telephony server</legend>

<div class="form-group">
  <label class="col-md-4 control-label" for="telserverurl">URL/FQDN</label>  
  <div class="col-md-4">
  <input id="telserverurl" name="telserverurl" placeholder="dial132.bluetelecoms.com" value="<?php echo $telaccurl;?>" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="telserveruser">Dialer username</label>  
  <div class="col-md-4">
  <input id="telserveruser" name="telserveruser" placeholder="9999" class="form-control input-md" value="<?php echo $telaccusername;?>" required="" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="telserverpass">Dialer password</label>
  <div class="col-md-4">
    <input id="telserverpass" name="telserverpass" placeholder="***********" class="form-control input-md" value="<?php echo $telaccpassword;?>" required="" type="password">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="telserversubmit"></label>
  <div class="col-md-4">
    <button id="telserversubmit" name="telserversubmit" class="btn btn-success">Submit</button>
  </div>
</div>

</fieldset>
</form>

                                
                            </div>
                            
                        </div>
                        
                        
                        
                        <?php } 
                        
                        if($settingsselect=='y') { ?>
                            
                        <h1><i class="fa fa-desktop"></i> CRM Features</h1>
                        <?php
                        
                        $featuresupdated= filter_input(INPUT_GET, 'featuresupdated', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($featuresupdated)){
    
      $featuresupdated= filter_input(INPUT_GET, 'featuresupdated', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($featuresupdated =='ydatabase') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> CRM features updated!</div><br>");
    }
            if ($featuresupdated =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}   
      ?>                                   
                        
                        <p>Enable or disable CRM features</p>
                        <br> 
                        <?php
                            $query = $pdo->prepare("SELECT post_code, pba, error, twitter, gmaps, analytics, callbacks, dialler, intemails, clientemails, keyfactsemail, genemail, recemail, sms, calendar, audits, life, home, pension FROM adl_features LIMIT 1");
                            $query->execute()or die(print_r($query->errorInfo(), true));
                            $queryfeatures=$query->fetch(PDO::FETCH_ASSOC);
                            
                            $fcallbacks=$queryfeatures['callbacks'];
                            $fdialler=$queryfeatures['dialler'];
                            $fintemails=$queryfeatures['intemails'];
                            $fclientemails=$queryfeatures['clientemails'];
                            $fkeyfactsemail=$queryfeatures['keyfactsemail'];
                            $fgenemail=$queryfeatures['genemail'];
                            $frecemail=$queryfeatures['recemail'];
                            $fsms=$queryfeatures['sms'];
                            $fcalendar=$queryfeatures['calendar'];
                            $faudits=$queryfeatures['audits'];
                            $flife=$queryfeatures['life'];
                            $fhome=$queryfeatures['home'];
                            $fpensions=$queryfeatures['pension'];
                            $fanalytics=$queryfeatures['analytics'];
                            $ftwitter=$queryfeatures['twitter'];
                            $fgmaps=$queryfeatures['gmaps'];
                            $ferror=$queryfeatures['error'];
                            $fpba=$queryfeatures['pba'];
                            $fpost_code=$queryfeatures['post_code'];
                            ?>
        
        
                        
                        <form class="form-horizontal" method="POST" action="../php/AddFeatures.php?add=y">
<fieldset>

<legend>Features</legend>

<div class="form-group">
  <label class="col-md-4 control-label" for="featuredialler">Dialler Integration</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featuredialler-0">
      <input name="featuredialler" id="featuredialler-0" value="0" <?php if(!isset($fdialler)) { echo 'checked="checked"'; } elseif ($fdialler=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featuredialler-1">
      <input name="featuredialler" id="featuredialler-1" value="1" <?php if ($fdialler=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featureanalytics">Google Analytics</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featureanalytics-0">
      <input name="featureanalytics" id="featureanalytics-0" value="0" <?php if(!isset($fanalytics)) { echo 'checked="checked"'; } elseif ($fanalytics=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="fanalytics-1">
      <input name="featureanalytics" id="featureanalytics-1" value="1" <?php if ($fanalytics=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featuregmaps">Google Maps</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featuregmaps-0">
      <input name="featuregmaps" id="featuregmaps-0" value="0" <?php if(!isset($fgmaps)) { echo 'checked="checked"'; } elseif ($fgmaps=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featuregmaps-1">
      <input name="featuregmaps" id="featuregmaps-1" value="1" <?php if ($fgmaps=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featuretwitter">Twitter</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featuretwitter-0">
      <input name="featuretwitter" id="featuretwitter-0" value="0" <?php if(!isset($ftwitter)) { echo 'checked="checked"'; } elseif ($ftwitter=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featuregmaps-1">
      <input name="featuretwitter" id="featuretwitter-1" value="1" <?php if ($ftwitter=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featurecallbacks">Callbacks</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="callbacks-0">
      <input name="featurecallbacks" id="featurecallbacks-0" value="0" <?php if(!isset($fcallbacks)) { echo 'checked="checked"'; } elseif ($fcallbacks=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featurecallbacks-1">
      <input name="featurecallbacks" id="featurecallbacks-1" value="1" <?php if ($fcallbacks=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featurepost_code">Post Code Lookups</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="callbacks-0">
      <input name="featurepost_code" id="featurepost_code-0" value="0" <?php if(!isset($fpost_code)) { echo 'checked="checked"'; } elseif ($fpost_code=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featurepost_code-1">
      <input name="featurepost_code" id="featurepost_code-1" value="1" <?php if ($fpost_code=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featuresintemail">Internal Emails</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featuresintemail-0">
      <input name="featuresintemail" id="featuresintemail-0" value="0" <?php if(!isset($fintemails)) { echo 'checked="checked"'; } elseif  ($fintemails=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featuresintemail-1">
      <input name="featuresintemail" id="featuresintemail-1" value="1" <?php if ($fintemails=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featureclientemails">Client Emails</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featureclientemails-0">
      <input name="featureclientemails" id="featureclientemails-0" value="0" <?php if(!isset($fclientemails)) { echo 'checked="checked"'; } elseif ($fclientemails=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featureclientemails-1">
      <input name="featureclientemails" id="featureclientemails-1" value="1" <?php if ($fclientemails=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featurekeyfacts">Keyfacts Email</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featurekeyfacts-0">
      <input name="featurekeyfacts" id="featurekeyfacts-0" value="0" <?php if(!isset($fkeyfactsemail)) { echo 'checked="checked"'; } elseif ($fkeyfactsemail=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featurekeyfacts-1">
      <input name="featurekeyfacts" id="featurekeyfacts-1" value="1" <?php if ($fkeyfactsemail=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featuregenemail">Generic Emails</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featuregenemail-0">
      <input name="featuregenemail" id="featuregenemail-0" value="0" <?php if(!isset($fgenemail)) { echo 'checked="checked"'; } elseif ($fgenemail=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featuregenemail-1">
      <input name="featuregenemail" id="featuregenemail-1" value="1" <?php if ($fgenemail=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featuresreemails">Receive Emails</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featuresreemails-0">
      <input name="featuresreemails" id="featuresreemails-0" value="0" <?php if(!isset($frecemail)) { echo 'checked="checked"'; } elseif ($frecemail=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featuresreemails-1">
      <input name="featuresreemails" id="featuresreemails-1" value="1" <?php if ($frecemail=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featuresms">Send SMS</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featuresms-0">
      <input name="featuresms" id="featuresms-0" value="0" <?php if(!isset($fsms)) { echo 'checked="checked"'; } elseif ($fsms=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featuresms-1">
      <input name="featuresms" id="featuresms-1" value="1" <?php if ($fsms=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featurescal">Calendar</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featurescal-0">
      <input name="featurescal" id="featurescal-0" value="0" <?php if(!isset($fcalendar)) { echo 'checked="checked"'; } elseif ($fcalendar=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featurescal-1">
      <input name="featurescal" id="featurescal-1" value="1" <?php if ($fcalendar=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featureaudits">Call Audits</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featureaudits-0">
      <input name="featureaudits" id="featureaudits-0" value="0" <?php if(!isset($faudits)) { echo 'checked="checked"'; } elseif ($faudits=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featureaudits-1">
      <input name="featureaudits" id="featureaudits-1" value="1" <?php if ($faudits=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featurelife">Life Insurnace</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featurelife-0">
      <input name="featurelife" id="featurelife-0" value="0" <?php if(!isset($flife)) { echo 'checked="checked"'; } elseif ($flife=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featurelife-1">
      <input name="featurelife" id="featurelife-1" value="1" <?php if ($flife=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featurepba">PBA</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featurepba-0">
      <input name="featurepba" id="featurepba-0" value="0" <?php if(!isset($fpba)) { echo 'checked="checked"'; } elseif ($fpba=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featurepba-1">
      <input name="featurepba" id="featurepba-1" value="1" <?php if ($fpba=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featurepensions">Pensions</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featurepensions-0">
      <input name="featurepensions" id="featurepensions-0" value="0" <?php if(!isset($fpensions)) { echo 'checked="checked"'; } elseif ($fpensions=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featurepensions-1">
      <input name="featurepensions" id="featurepensions-1" value="1" <?php if ($fpensions=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featurehome">Home Insurance</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featurehome-0">
      <input name="featurehome" id="featurehome-0" value="0" <?php if(!isset($fhome)) { echo 'checked="checked"'; } elseif ($fhome=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featurehome-1">
      <input name="featurehome" id="featurehome-1" value="1" <?php if ($fhome=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featureerror">Enable Error Checking</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="featureerror-0">
      <input name="featureerror" id="featureerror-0" value="0" <?php if(!isset($ferror)) { echo 'checked="checked"'; } elseif ($ferror=='0'){ echo 'checked="checked"';}?> type="radio">
      0
    </label> 
    <label class="radio-inline" for="featureerror-1">
      <input name="featureerror" id="featureerror-1" value="1" <?php if ($ferror=='1'){ echo 'checked="checked"';}?> type="radio">
      1
    </label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="featuressubmit"></label>
  <div class="col-md-4">
    <button id="featuressubmit" name="featuressubmit" class="btn btn-success">Submit</button>
  </div>
</div>

</fieldset>
</form>

                        
                        <?php } ?>
                        <br>
                        <br>
                        <br>
                        
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
<script src="..js/sweet-alert.min.js"></script>
<script src="../js/jquery-2.1.4.min.js"></script>
<script src="../js/sweet-alert.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>

</html>
