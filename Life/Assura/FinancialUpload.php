<?php 
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 * 
*/  

include('../../includes/adlfunctions.php'); 

if ($fflife=='0') {
        
        header('Location: ../../CRMmain.php'); die;
    }

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

if($companynamere=='Bluestone Protect') {
if (!in_array($hello_name,$Level_8_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;
}
}
?>
<!DOCTYPE html>
<html lang="en">
<title>Assura Financial Upload</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php

    include('../../includes/navbar.php');
    include('../../includes/ADL_PDO_CON.php');
    include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    } ?>
    
    <div class="container">
        
        <?php
        
             $uploaded= filter_input(INPUT_GET, 'uploaded', FILTER_SANITIZE_SPECIAL_CHARS);
     
     if(isset($uploaded)) {
         if(($uploaded=='1')) {
     
    echo "<div class='notice notice-success' role='alert'><strong><i class='fa fa-upload fa-lg'></i> Success:</strong> Your file has been uploaded</div>";  

         }
         
         if(($uploaded=='0')) {
             
             $Reason= filter_input(INPUT_GET, 'Reason', FILTER_SANITIZE_SPECIAL_CHARS);
             
             echo "<div class='notice notice-danger' role='alert'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Error:</strong> File has not been uploaded</div>";  
                      
                  }
                  
            if(isset($Reason))  { 
               
            echo "<div class='notice notice-warning' role='alert'><strong><i class='fa fa-exclamation-circle fa-lg'></i> Warning:</strong> File type is not supported. <br><br>A number of spreadsheet filetypes are supported, if you keep having trouble upload as a .csv </div>";  

                
            }    
     }
        ?>
        
        <div class="row">
            
            <form id="upload" id="upload" class="form-horizontal" method="post" enctype="multipart/form-data" action="../php/AssuraFinFileUpload.php?life=1">
                <fieldset>
                    <legend>File upload</legend>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="file">Select file..</label>
                        <div class="col-md-4">
                            <input id="file" name="file" class="input-file" type="file">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label" for=""></label>
                        <div class="col-md-4">
                            <button id="" name="" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                        </div>
                    </div>
                
                </fieldset>
            </form>
            
            
        </div>
        
        <div class="row">
            
            <?php
            
            try {
                
                $filesloaded = $pdo->prepare("select file, uploadtype from tbl_uploads where uploadtype='Assura Financial'");
                
                ?>
            
            <span class="label label-primary">Uploads</span>
                    
                    <?php
                    
                    $filesloaded->execute();
                    if ($filesloaded->rowCount()>0) {
                        while ($row=$filesloaded->fetch(PDO::FETCH_ASSOC)){
                            
                            $file=$row['file'];
                            $uploadtype=$row['uploadtype'];
                            
                        ?>
                            
                        <a class="list-group-item" href="../FinUploads/<?php echo $file; ?>" target="_blank"><i class="fa fa-file-excel-o fa-fw fa-2x" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                        <?php
                        
                        }
                        
                        } 
                        
                        else {
                            echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No uploads found</div>";
                            
                        } ?>
                        
                        </table>
                        
                        <?php }
                        
                        catch (PDOException $e) {
                            echo 'Connection failed: ' . $e->getMessage();
                            
                        }
                        
                        ?>
            
        </div>
            
    </div>
    <script>
        document.querySelector('#upload').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Upload File?",
                text: "Confirm to upload file!",
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
                        title: 'Uploading!',
                        text: 'File uploading!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "File was not uploaded", "error");
                }
            });
        });

</script>
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="../../js/sweet-alert.min.js"></script>
</body>
</html>
