<?php 
require_once(__DIR__ . '../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '../../includes/user_tracking.php'); 

require_once(__DIR__ . '../../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '../../includes/adl_features.php');
require_once(__DIR__ . '../../includes/Access_Levels.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
} 

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();

        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 10) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Email Inbox</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" language="javascript" src="/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/datatables/css/layoutcrm.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	</head>
	<body>
            
            <?php 
            include('../includes/navbar.php'); ?>

<div class='container'>
     <?php email_sent_catch(); ?>
</div>
		<?php
		error_reporting(1);
    // Multiple email account
		$emails = array(
			array(
				'no'		=> '1',
				'label' 	=> 'Michael  (michael@thereviewbureau.com)',
				'host' 		=> '{imap.123-reg.co.uk:143/notls}INBOX',
				'username' 	=> $M_123_EMAIL,
				'password' 	=> $M_123_PASS
			)
			
		);
				
		foreach ($emails as $email) {
			$read = imap_open($email['host'],$email['username'],$email['password']) or die('<div class="alert alert-danger alert-dismissable">Cannot connect to 123-reg.co.uk: ' . imap_last_error().'</div>');
			$array = imap_search($read,'TO "michael@thereviewbureau.com"');
			if($array) {
				$html = '';
				rsort($array);
				$html.= '
				<div class="container">
                                 
				<div class="panel panel-primary">
							<div class="panel-heading">
								'.$email['label'].'<button type="button" class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#email"><span class="glyphicon glyphicon-envelope"></span> </button>
							</div>
							<div class="panel-body">
								<div class="panel-group" id="accordion">';
								
				foreach($array as $result) {
					$overview = imap_fetch_overview($read,$result,0);																		
					$message = imap_body($read,$result,0);																		
					$reply = imap_headerinfo($read,$result,0);
																		
					$html.= '	<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a style="color:black; text-decoration:none"class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$email['no'].$result.'">
												<span class="subject">Subject: '.substr(strip_tags($overview[0]->subject),0,50).' </span><br>
												<span class="from">From: '.$overview[0]->from.'</span><br>
												<span class="date">Date: '.$overview[0]->date.'</span>
											</a>
										</h4>
									</div>
									<div id="'.$email['no'].$result.'" class="panel-collapse collapse">
										<div class="panel-body">
											<pre>'.$message.'<hr>From: '.$reply->from[0]->mailbox.'@'.$reply->from[0]->host.'</pre>
										</div>
									</div>
								</div>';												
				}
								
				$html.= '</div>
					</div>
					</div>
				</div>';
				echo $html;
			}
			imap_close($read);
						
		}
		?>
<!-- Modal -->
<div id="email" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Email (michael@thereviewbureau.com)</h4>
      </div>
      <div class="modal-body">
      
<form class="form-horizontal" method="post" action="php/SendEmailMichael.php" enctype="multipart/form-data">

<fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>  
  <div class="col-md-4">
  <input id="email" name="email" placeholder="" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="subject">Subject</label>  
  <div class="col-md-4">
  <input id="subject" name="subject" placeholder="" class="form-control input-md" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="recipient">Recipient</label>  
  <div class="col-md-4">
  <input id="recipient" name="recipient" placeholder="" class="form-control input-md" type="text">
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="message">Message</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="message" name="message"></textarea>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload">Add attachment</label>
  <div class="col-md-4">
    <input id="fileToUpload" name="fileToUpload" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload2">Add attachment (2)</label>
  <div class="col-md-4">
    <input id="fileToUpload2" name="fileToUpload2" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload3">Add attachment (3)</label>
  <div class="col-md-4">
    <input id="fileToUpload3" name="fileToUpload3" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload4">Add attachment (4)</label>
  <div class="col-md-4">
    <input id="fileToUpload4" name="fileToUpload4" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload5">Add attachment (5)</label>
  <div class="col-md-4">
    <input id="fileToUpload5" name="fileToUpload5" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload6">Add attachment (6)</label>
  <div class="col-md-4">
    <input id="fileToUpload6" name="fileToUpload6" class="input-file" type="file">
  </div>
</div>

<br>
<br>
 
<div class="form-group">
  <label class="col-md-4 control-label" for="Send Email"></label>
  <div class="col-md-4">
<button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-envelope"></span> Send</button>
  </div>
</div>

</fieldset>
</form> 


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
</div>
</div>
</div>

</body>
</html>
