<?php

$QUERY= filter_input(INPUT_GET, 'QUERY', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($QUERY)) {
    if($QUERY=='ClientEdit') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Client details updated!</div>";
        
    }
    if($QUERY=='ClientAdded') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-user-plus fa-lg\"></i> Success:</strong> Client added!</div>";
        
    }
    if($QUERY=='AppAdded') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-calendar-check-o fa-lg\"></i> Success:</strong> Appointment booked!</div>";
        
    }
    if($QUERY=='AppEdited') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-calendar-check-o fa-lg\"></i> Success:</strong> Appointment has been re-booked!</div>";
        
    }    
    if($QUERY=='AppStatus') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o  fa-lg\"></i> Success:</strong> Appointment status has been updated!</div>";
        
    }        
}