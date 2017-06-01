<?php

$RETURN = filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($RETURN)) {

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

?>

