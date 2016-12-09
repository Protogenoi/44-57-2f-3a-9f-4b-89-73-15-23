<!DOCTYPE html>
<html lang="en">
<title>ADL | Sent Key Facts</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	</head>
	<body>
	<?php include('../includes/navbar.php'); 
        
        include('../includes/ADL_PDO_CON.php');
        
                                include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }

$keyfactsr="Key Facts";

        
        $query = $pdo->prepare("select email, emailfrom, emailreply, emailbcc, emailsubject, imap, imapport, displayname, password from email_accounts where emailtype=:emailtypeholder");
        $query->bindParam(':emailtypeholder', $keyfactsr, PDO::PARAM_STR);
$query->execute()or die(print_r($query->errorInfo(), true));
$queryr=$query->fetch(PDO::FETCH_ASSOC);

        $emailfromdb=$queryr['emailfrom'];
        $emailbccdb=$queryr['emailbcc'];
        $emailreplydb=$queryr['emailreply'];
        $emailsubjectdb=$queryr['emailsubject'];
        $emailimapdb=$queryr['imap'];
        $emailimapportdb=$queryr['imapport'];
        $emaildisplaynamedb=$queryr['displayname'];
        $passworddb=$queryr['password'];
        $emaildb=$queryr['email'];
        
        
        
		$formatted = date('d F Y');
		error_reporting(0);
    // Multiple email account
		$emails = array(
			array(
				'no'		=> '1',
				'label' 		=> 'Todays Attempted Key Facts Delivery  ('.$emaildb.')',
				'host' 		=> '{'.$emailimapdb.':'.$emailimapportdb.'/notls}INBOX',
				'username' 	=> $emaildb,
				'password' 	=> $passworddb
			)
			
		);
				
		foreach ($emails as $email) {
			$read = imap_open($email['host'],$email['username'],$email['password']) or die('<div class="alert alert-danger alert-dismissable">Cannot connect to 123-reg.co.uk: ' . imap_last_error().'</div>');
			$array = imap_search($read,'FROM "'.$emaildisplaynamedb.'" ON "'.$formatted.'" SUBJECT "Key Facts Document"');
			if($array) {
				$html = '';
				rsort($array);
				$html.= '
				<div class="container">
				<div class="panel panel-primary">
							<div class="panel-heading">
								'.$email['label'].'
							 <a href="TodayKFsfailed.php"><button type="button" class="btn btn-danger btn-sm pull-right"><span class="glyphicon glyphicon-remove-circle"></span> Check failed</button></a><a href="../KeyFactsEmail.php"><button type="button" class="btn btn-warning btn-sm pull-right"><span class="glyphicon glyphicon-envelope"></span> Send Key Facts</button></a></div>
							<div class="panel-body">
								<div class="panel-group" id="accordion">';
								
				foreach($array as $result) {
					$overview = imap_fetch_overview($read,$result,0);																		
					$message = imap_fetchbody($read,$result,0);																		
					$reply = imap_headerinfo($read,$result,0);
																		
					$html.= '	<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a style="color:black; text-decoration:none"class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$email['no'].$result.'">
												
												<span class="from">To: '.$overview[0]->to.'</span><br>
												<span class="subject">Subject: '.substr(strip_tags($overview[0]->subject),0,50).' </span><br>

												<span class="date">Date: '.$overview[0]->date.'</span><br>
												
												
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


</body>
</html>
