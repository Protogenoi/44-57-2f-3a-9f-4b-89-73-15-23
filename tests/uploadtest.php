<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1); 
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
	$test_access_level->log_out(); 
}
?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_FILES['upload'])) {

$allowed = array ('image/pjpeg','image/jpeg', 'image/JPG','image/X-PNG', 'image/PNG','image/png', 'image/x-png');
if (in_array($_FILES['upload']['type'], $allowed)) {

if (move_uploaded_file ($_FILES['upload']['tmp_name'],"../uploads/{$_FILES['upload']['name']}")) {
echo '<p><em>The file has been uploaded</em></p>';
}

}

else 	{ 
	echo '<p class="error">Please upload a JPEG or PNG image.</p>';
	}
}

if ($_FILES['uploads']['error'] > 0){

	echo '<p class="uploaderror">The file could not be uploaded because: <strong>';

switch ($_FILES['upload']['error']) 
	{
case 1:
	print 'The file exceeds the upload_max_filesize setting in php.ini.';
	break;
case 2:
	print 'The files exceeds the MAX_FILE_SIZE setting in the HTML form.';
	break;
case 3:
	print 'The file was only partially uploaded.';
	break;
case 4:
	print 'No file was uploaded.';
	break;
case 6;
	print 'No temporary folder was available.';
	break;
case 7:
	print 'Unable to write to the disk.';
	break;
case 8:
	print 'File upload stopped.';
	break;
default;
	print 'A system error occured.';
	break;
	}
	print '</strong></p>';}
	
if (file_exists ($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name']) ) 
{
unlink ($_FILES['upload']['tmp_name']);
}
}


?>

<!DOCTYPE html>
<html lang="en">
<title>ADL | Upload</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<style>
.uploaderror {
	font-weight: bold;
	color: #C00;
}
.btn-file {
  position: relative;
  overflow: hidden;
}
.btn-file input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  background: red;
  cursor: inherit;
  display: block;
}
input[readonly] {
  background-color: white !important;
  cursor: text !important;
}
</style>
</head>
<body>

<div class="container" style="margin-top: 20px;">

<form enctype="multipart/form-data" class="form-horizontal" action="" method="POST">

<input type="hidden" name="MAX_FILE_SIZE" value="524288"/>

<fieldset>
<legend>Select a JPEG or PNG image of 512KB or smaller to be uploaded:</legend>

<div class="form-group">
<div class="col-md-4">
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        Browse&hellip; <input name="upload" class="input-file" type="file">
                    </span>
                </span>
                <input type="text" class="form-control" readonly>
            </div>
            <span class="help-block">
                Allowed file types PNG and JPEG.
            </span>
        </div>
        </div>
        
<div class="form-group">
  <div class="col-md-4">
<div class="input-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>

    <button id="singlebutton" name="singlebutton" value="submit" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-up"></span>Upload</button>
  </div>
  </div>
  
</div>



</fieldset>
</form>

</div>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
$(document).on('change', '.btn-file :file', function() {
  var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
        
    });
});
</script>
<script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
