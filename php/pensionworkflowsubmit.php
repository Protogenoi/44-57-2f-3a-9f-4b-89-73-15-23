<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/PDOcon.php');

$comments = mysqli_real_escape_string($conn, $_POST['comments']);
$complete = mysqli_real_escape_string($conn, $_POST['complete']);
$submitter = mysqli_real_escape_string($conn, $_POST['submitter']);
$client_id = mysqli_real_escape_string($conn, $_POST['search']);
$penid = mysqli_real_escape_string($conn, $_POST['penid']);
$step = mysqli_real_escape_string($conn, $_POST['step']);

if ($complete =='n') {

$set1 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set1)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set1 . "<br>" . mysqli_error($conn);
}

}

//DAY 1

elseif ($complete=='y' && $step=='Set 1 Day 0') {
    
    $set2 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set2)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set2 . "<br>" . mysqli_error($conn);
}

$set3 = "INSERT INTO pension_workflow SET
client_id='$client_id'
, step='Set 1 Day 1'
, task='Call to remind appointment', comments=' ', edited=' '";

if (mysqli_query($conn, $set3)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Set 1 Day 1 added.
    </div>";
} else {
    echo "Error: " . $set3 . "<br>" . mysqli_error($conn);
}
    
}
//DAY 2 CHECK UPLOADS
elseif ($complete=='y' && $step=='Set 1 Day 1') {
    
    $set4 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set4)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set4 . "<br>" . mysqli_error($conn);
}

$set5 = "INSERT INTO pension_workflow SET
client_id='$client_id'
, step='Set 1 Day 2'
, task='Check uploads', comments=' ', edited=' '";

if (mysqli_query($conn, $set5)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Set 1 Day 2 added.
    </div>";
} else {
    echo "Error: " . $set5 . "<br>" . mysqli_error($conn);
}
    
}

//DAY 3 -4
elseif ($complete=='y' && $step=='Set 1 Day 2') {
    
    $set6 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set6)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set6 . "<br>" . mysqli_error($conn);
}

$set7 = "INSERT INTO pension_workflow SET
client_id='$client_id'
, step='Set 1 Day 3-4'
, task='Fact find through post- a) Call to confirm receipt/questions/life and home b) Send off LOAs', comments=' ', edited=' '";

if (mysqli_query($conn, $set7)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Set 1 Day 3-4 added.
    </div>";
} else {
    echo "Error: " . $set7 . "<br>" . mysqli_error($conn);
}
    
}

//DAY 6 - 8
elseif ($complete=='y' && $step=='Set 1 Day 3-4') {
    
    $set8 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set8)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set8 . "<br>" . mysqli_error($conn);
}

$set9 = "INSERT INTO pension_workflow SET
client_id='$client_id'
, step='Set 1 Day 6-8'
, task='Chase LOAs', comments=' ', edited=' '";

if (mysqli_query($conn, $set9)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Set 1 Day 6-8 added.
    </div>";
} else {
    echo "Error: " . $set9 . "<br>" . mysqli_error($conn);
}
    
}

//DAY 10
elseif ($complete=='y' && $step=='Set 1 Day 6-8') {
    
    $set10 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set10)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set10 . "<br>" . mysqli_error($conn);
}

$set11 = "INSERT INTO pension_workflow SET
client_id='$client_id'
, step='Set 1 Day 10'
, task='a) Process home/life b) Chase LOAs (continue every 48hrs)', comments=' ', edited=' '";

if (mysqli_query($conn, $set11)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Set 1 Day 10 added.
    </div>";
} else {
    echo "Error: " . $set11 . "<br>" . mysqli_error($conn);
}
    
}

//SET 2

elseif ($complete=='y' && $step=='Set 1 Day 10') {
    
    $set12 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set12)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set12 . "<br>" . mysqli_error($conn);
}

$set13 = "INSERT INTO pension_workflow SET
client_id='$client_id'
, step='Set 2 Day 0'
, task='a) Run comparison b) call to go through soft fact find and report c) Book appointment for IFA', comments=' ', edited=' '";

if (mysqli_query($conn, $set13)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Set 2 Day 0 added.
    </div>";
} else {
    echo "Error: " . $set13 . "<br>" . mysqli_error($conn);
}
    
}

// SET 3

elseif ($complete=='y' && $step=='Set 2 Day 0') {
    
    $set14 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set14)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set14 . "<br>" . mysqli_error($conn);
}

$set15 = "INSERT INTO pension_workflow SET
client_id='$client_id'
, step='Set 3 Day 0'
, task='IFA call and close', comments=' ', edited=' '";

if (mysqli_query($conn, $set15)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Set 3 Day 0 added.
    </div>";
} else {
    echo "Error: " . $set15 . "<br>" . mysqli_error($conn);
}
    
}

// DAY 1

elseif ($complete=='y' && $step=='Set 3 Day 0') {
    
    $set16 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set16)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set16 . "<br>" . mysqli_error($conn);
}

$set17 = "INSERT INTO pension_workflow SET
client_id='$client_id'
, step='Set 3 Day 1'
, task='a) Build suitability report b) Call book 2nd document collection', comments=' ', edited=' '";

if (mysqli_query($conn, $set17)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Set 3 Day 1 added.
    </div>";
} else {
    echo "Error: " . $set17 . "<br>" . mysqli_error($conn);
}
    
}

//DAY of appointment

elseif ($complete=='y' && $step=='Set 3 Day 1') {
    
    $set18 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set18)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set18 . "<br>" . mysqli_error($conn);
}

$set19 = "INSERT INTO pension_workflow SET
client_id='$client_id'
, step='Set 3 Appointment'
, task='a) Call to remind b) Appointment', comments=' ', edited=' '";

if (mysqli_query($conn, $set19)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Set 3 Day of appointment added.
    </div>";
} else {
    echo "Error: " . $set19 . "<br>" . mysqli_error($conn);
}
    
}

// DAY after appointment

elseif ($complete=='y' && $step=='Set 3 Appointment') {
    
    $set20 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set20)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set20 . "<br>" . mysqli_error($conn);
}

$set21 = "INSERT INTO pension_workflow SET
client_id='$client_id'
, step='Set 3 Day after appointment'
, task='a) Call to confirm receipt of docs b) INNITIATE TRANSFER', comments=' ', edited=' '";

if (mysqli_query($conn, $set21)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Set 3 Day after appointment added.
    </div>";
} else {
    echo "Error: " . $set21 . "<br>" . mysqli_error($conn);
}
    
}

//SET 4

elseif ($complete=='y' && $step=='Set 3 Day after appointment') {
    
    $set22 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set22)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set22 . "<br>" . mysqli_error($conn);
}

$set23 = "INSERT INTO pension_workflow SET
client_id='$client_id'
, step='Set 4 Day 1'
, task='a) Satisfaction report b) upsell c) get referral', comments=' ', edited=' '";

if (mysqli_query($conn, $set23)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Set 4 day 1 added.
    </div>";
} else {
    echo "Error: " . $set23 . "<br>" . mysqli_error($conn);
}
    
}

//Day 2

elseif ($complete=='y' && $step=='Set 4 Day 1') {
    
    $set24 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set24)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set24 . "<br>" . mysqli_error($conn);
}

$set25 = "INSERT INTO pension_workflow SET
client_id='$client_id'
, step='Set 4 Day 2'
, task='Overall audit', comments=' ', edited=' '";

if (mysqli_query($conn, $set25)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Set 4 day 2 added.
    </div>";
} else {
    echo "Error: " . $set25 . "<br>" . mysqli_error($conn);
}
    
}

//COMPLETE

elseif ($complete=='y' && $step=='Set 4 Day 2') {
    
    $set24 = "UPDATE pension_workflow SET comments='$comments', complete='$complete', submitted_by='$submitter' WHERE id = '$penid'";

if (mysqli_query($conn, $set24)) {
    $last_id = mysqli_insert_id($conn);
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Workflow submitted.
    </div>";
} else {
    echo "Error: " . $set24 . "<br>" . mysqli_error($conn);
}
    
}

$search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
$stepheader= filter_input(INPUT_POST, 'step', FILTER_SANITIZE_SPECIAL_CHARS);

header('Location: ../ViewClient.php?search=".$search."&workflow=".$stepheader."'); die;
       
?>
