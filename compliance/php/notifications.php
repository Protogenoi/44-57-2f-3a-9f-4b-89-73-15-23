<?php

$RETURN = filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($RETURN)) {
    if($RETURN=='ADDED') {

$MARK = filter_input(INPUT_GET, 'MARK', FILTER_SANITIZE_SPECIAL_CHARS);
$GRADE = filter_input(INPUT_GET, 'GRADE', FILTER_SANITIZE_SPECIAL_CHARS);
$TEST = filter_input(INPUT_GET, 'TEST', FILTER_SANITIZE_SPECIAL_CHARS);

 switch ($GRADE) {
    case "Red":
        $NOTICE_COLOR="danger";
        break;
    case "Amber":
        $NOTICE_COLOR="warning";
        break;
    case "Green":
        $NOTICE_COLOR="success";
        break;
    default:
        $NOTICE_COLOR="info";
       
}   ?>

    <div class="notice notice-<?php echo $NOTICE_COLOR; ?>">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Grade:</strong> <?php echo $GRADE; ?> | Total answered correctly: <?php echo "$MARK/14";?>.
    </div>


<?php
}
if($RETURN=='UPLOAD') { ?>
    <div class="notice notice-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Upload:</strong> Call recording has been uploaded.
    </div>
 <?php   
}
if($RETURN=='DOCUPLOAD') { ?>
    <div class="notice notice-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Upload:</strong> File has been uploaded.
    </div>
 <?php   
}
if($RETURN=='RECUPDATED') { ?>
    <div class="notice notice-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Updated:</strong> Call audit updated!
    </div>
 <?php   
}
if($RETURN=='STATSUPDATED') { ?>
    <div class="notice notice-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Update:</strong> Agent stats have been updated!
    </div>
 <?php   
}
if($RETURN=='STATS') { ?>
    <div class="notice notice-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Added:</strong> Agent stats have been added!
    </div>
 <?php   
}
if($RETURN=='STATSDUPE') { ?>
    <div class="notice notice-warning">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Dupe:</strong> This agent has already been added for this quarter!
    </div>
 <?php   
}
}
?>

