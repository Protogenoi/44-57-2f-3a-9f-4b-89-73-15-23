<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Email Signature</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="apple-touch-icon" href="//mindmup.s3.amazonaws.com/lib/img/apple-touch-icon.png" />

    <link href="external/google-code-prettify/prettify.css" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.css">
  
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    <script src="../js/jquery.min.js"></script>
    <script src="external/jquery.hotkeys.js"></script>
    <script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="external/google-code-prettify/prettify.js"></script>
    <link href="index.css" rel="stylesheet">
    <script src="bootstrap-wysiwyg.js"></script>
    <link rel="stylesheet" href="../styles/layoutcrm.css" type="text/css" />
  </head>
  <body>

<div class="container">
    
    <?php
                            $signature= filter_input(INPUT_GET, 'signature', FILTER_SANITIZE_SPECIAL_CHARS);
                        
                        if(isset($signature)){
    
      $signature= filter_input(INPUT_GET, 'signature', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($signature =='y' || $signature =='updated') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Email Signature Updated!</div><br>");
    }

            if ($signature =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}  
    
  ?>  
    
  <div class="hero-unit">

	<div id="alerts"></div>
    <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
        
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
          </ul>
        </div>
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
          <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
          <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
          <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
          </ul>
      </div>
      <div class="btn-group">
        <a class="btn btn-default btn-sm" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
        <a class="btn btn-default btn-sm" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
        <a class="btn btn-default btn-sm" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
        <a class="btn btn-default btn-sm" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn btn-default btn-sm" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
        <a class="btn btn-default btn-sm" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
        <a class="btn btn-default btn-sm" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-indent"></i></a>
        <a class="btn btn-default btn-sm" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn btn-default btn-sm" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
        <a class="btn btn-default btn-sm" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
        <a class="btn btn-default btn-sm" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
        <a class="btn btn-default btn-sm" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
      </div>
      <div class="btn-group">
		  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
		    <div class="dropdown-menu input-append">
			    <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
			    <button class="btn btn-default btn-sm" type="button">Add</button>
        </div>
        <a class="btn btn-default btn-sm" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>

      </div>
      
      <div class="btn-group">
        <a class="btn btn-default btn-sm" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-photo"></i></a>
        <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
      </div>
      <div class="btn-group">
        <a class="btn btn-default btn-sm" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
        <a class="btn btn-default btn-sm" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
      </div>
      <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
    </div>
    <form class="form-horizontal" name="my_form" method="post" onSubmit="document.my_form.editor_contents.value = $('#editor').html()" action="../php/AddEmailSignature.php?emailsignature=y">
<textarea name="editor_contents" style="display:none;"></textarea> 
    <div id="editor">
      Go ahead&hellip;
    </div>
  </div>


    
    
<div class="form-group">
  <label class="col-md-4 control-label" for="emailid">Link To Account</label>
  <div class="col-md-4">
    <select id="emailid" name="emailid" class="form-control">
        <option value="">Select...</option>
            <?php 
    
    include('../includes/PDOcon.php');
    
    $linkacc = $pdo->prepare("SELECT emailtype, id from email_accounts");
    $linkacc->execute();

    if ($linkacc->rowCount()>0) {
        while ($linkacvar=$linkacc->fetch(PDO::FETCH_ASSOC)){
  
            $lkid=$linkacvar['id'];
            $lkve=$linkacvar['emailtype'];

 echo "<option value='$lkid'>$lkve</option>";
      
    }
    }
      ?>
    </select>
  </div>
</div>
<br>
<br>



<br>
<div class="form-group">
  <label class="col-md-4 control-label" for="logo">Logo</label>
  <div class="col-md-4">
    <select id="logo" name="logo" class="form-control">
      <option value="">Select...</option>
          <?php 
    

    
    $cimages = $pdo->prepare("SELECT file from tbl_uploads where uploadtype like 'Email Account %'");
    $cimages->execute();

    if ($cimages->rowCount()>0) {
        while ($comimages=$cimages->fetch(PDO::FETCH_ASSOC)){
  
            $logofile=$comimages['file'];
 echo "<option value='$logofile'>$logofile</option>";
      
    }
    }
      ?>
    </select>
  </div>
</div>

<br>
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="btn_submit" class="btn btn-primary">Submit</button>
  </div>
</div>
    
    </form>
</div>
<script>
  $(function(){
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
	$('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
    window.prettyPrint && prettyPrint();
  });
</script>




</html>
