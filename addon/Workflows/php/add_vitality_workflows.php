<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
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
            
                $TASK_ARRAY = ['Happy with policy','Had email from us','Had post from insurer','Cancelled old DD','Confirmed 1st DD','TPS','Trust','Logged into memberzone','Booked health check'];    
            
                $today=date("D");
                $date=date("Y-m-d",strtotime($today)); 
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='48'");
                $database->execute();
                $assign48d=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='7 day'");
                $database->execute();
                $assign5d=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='18 day'");
                $database->execute();
                $assign18d=$database->single();
                
                $database->query("SELECT Task, Assigned FROM Set_Client_Tasks WHERE Task='21 day'");
                $database->execute();
                $assign21d=$database->single();                
                
                $assign48=$assign48d['Assigned'];
                $assign5=$assign5d['Assigned'];
                $assign18=$assign18d['Assigned'];
                $assign21=$assign21d['Assigned'];
                
                $task48="48 hour";
                $WeekDay48 = date("Y-m-d", strtotime("+2 weekdays"));
                $deadline48=$WeekDay48;
                
                $task5="7 day";
                $WeekDay5 = date("Y-m-d", strtotime("+7 weekdays"));
                $deadline5=$WeekDay5;
                
                $task18="18 day";
                $WeekDay18 = date("Y-m-d", strtotime("+18 weekdays"));
                $deadline18=$WeekDay18;
                
                $task21="21 day";
                $WeekDay21 = date("Y-m-d", strtotime("+21 weekdays"));
                $deadline21=$WeekDay21;
                
        if($TYPE !='VITALITY WOL') {                
 
        $database->query("INSERT INTO adl_workflows SET adl_workflows_client_id_fk=:CID, adl_workflows_assigned=:assign, adl_workflows_name=:task, adl_workflows_deadline=:deadline");
        $database->bind(':assign', $assign48, PDO::PARAM_STR);
        $database->bind(':task', $task48, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline48, PDO::PARAM_STR); 
        $database->bind(':CID', $CID); 
        $database->execute();
        
        $database->query("SELECT adl_workflows_id FROM adl_workflows WHERE adl_workflows_client_id_fk=:CID AND adl_workflows_name='48 hour'");
        $database->bind(':CID', $CID);
        $FOURTY_EIGHT_row = $database->single();
        
        if(isset($FOURTY_EIGHT_row['adl_workflows_id'])) {
        
        $FOURTY_EIGHT_HOUR_ID=$FOURTY_EIGHT_row['adl_workflows_id'];
        $TASK_ONE='Happy with policy';
        
        
        foreach ($TASK_ARRAY as $TASK_NAME) {
        
        $database->query("INSERT INTO adl_tasks SET adl_tasks_id_fk=:FK, adl_tasks_title=:TASK");
        $database->bind(':FK', $FOURTY_EIGHT_HOUR_ID, PDO::PARAM_INT);
        $database->bind(':TASK', $TASK_NAME, PDO::PARAM_STR);
        $database->execute();   
        
        }
        
        }  
        
        }
        
        $database->query("INSERT INTO adl_workflows SET adl_workflows_client_id_fk=:CID, adl_workflows_assigned=:assign, adl_workflows_name=:task, adl_workflows_deadline=:deadline");
        $database->bind(':assign', $assign5, PDO::PARAM_STR);
        $database->bind(':task', $task5, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline5, PDO::PARAM_STR); 
        $database->bind(':CID', $CID); 
        $database->execute();
        
        $database->query("SELECT adl_workflows_id FROM adl_workflows WHERE adl_workflows_client_id_fk=:CID AND adl_workflows_name='7 day'");
        $database->bind(':CID', $CID);
        $SEVEN_DAY_row = $database->single();
        
        if(isset($SEVEN_DAY_row['adl_workflows_id'])) {
        
        $SEVEN_DAY_HOUR_ID=$SEVEN_DAY_row['adl_workflows_id'];
        $TASK_ONE='Happy with policy';
        
        foreach ($TASK_ARRAY as $TASK_NAME) {
        
        $database->query("INSERT INTO adl_tasks SET adl_tasks_id_fk=:FK, adl_tasks_title=:TASK");
        $database->bind(':FK', $SEVEN_DAY_HOUR_ID, PDO::PARAM_INT);
        $database->bind(':TASK', $TASK_NAME, PDO::PARAM_STR);
        $database->execute();   
        
        }
        
        }         
        
        $database->query("INSERT INTO adl_workflows SET adl_workflows_client_id_fk=:CID, adl_workflows_assigned=:assign, adl_workflows_name=:task, adl_workflows_deadline=:deadline");
        $database->bind(':assign', $assign18, PDO::PARAM_STR);
        $database->bind(':task', $task18, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline18, PDO::PARAM_STR); 
        $database->bind(':CID', $CID); 
        $database->execute();
        
        $database->query("SELECT adl_workflows_id FROM adl_workflows WHERE adl_workflows_client_id_fk=:CID AND adl_workflows_name='18 day'");
        $database->bind(':CID', $CID);
        $EIGHTEEN_DAY_row = $database->single();
        
        if(isset($EIGHTEEN_DAY_row['adl_workflows_id'])) {
        
        $EIGHTEEN_DAY_HOUR_ID=$EIGHTEEN_DAY_row['adl_workflows_id'];
        $TASK_ONE='Happy with policy';
        
        foreach ($TASK_ARRAY as $TASK_NAME) {
        
        $database->query("INSERT INTO adl_tasks SET adl_tasks_id_fk=:FK, adl_tasks_title=:TASK");
        $database->bind(':FK', $EIGHTEEN_DAY_HOUR_ID, PDO::PARAM_INT);
        $database->bind(':TASK', $TASK_NAME, PDO::PARAM_STR);
        $database->execute();   
        
        }
        
        }        
        
        $database->query("INSERT INTO adl_workflows SET adl_workflows_client_id_fk=:CID, adl_workflows_assigned=:assign, adl_workflows_name=:task, adl_workflows_deadline=:deadline");
        $database->bind(':assign', $assign21, PDO::PARAM_STR);
        $database->bind(':task', $task21, PDO::PARAM_STR);
        $database->bind(':deadline', $deadline21, PDO::PARAM_STR); 
        $database->bind(':CID', $CID); 
        $database->execute();  
        
        $database->query("SELECT adl_workflows_id FROM adl_workflows WHERE adl_workflows_client_id_fk=:CID AND adl_workflows_name='21 day'");
        $database->bind(':CID', $CID);
        $TWENTY_ONE_DAY_row = $database->single();
        
        if(isset($TWENTY_ONE_DAY_row['adl_workflows_id'])) {
        
        $TWENTY_ONE_DAY_HOUR_ID=$TWENTY_ONE_DAY_row['adl_workflows_id'];
        $TASK_ONE='Happy with policy';
        
        foreach ($TASK_ARRAY as $TASK_NAME) {
        
        $database->query("INSERT INTO adl_tasks SET adl_tasks_id_fk=:FK, adl_tasks_title=:TASK");
        $database->bind(':FK', $TWENTY_ONE_DAY_HOUR_ID, PDO::PARAM_INT);
        $database->bind(':TASK', $TASK_NAME, PDO::PARAM_STR);
        $database->execute();   
        
        }
        
        }       
                
        $notedata= "Vitality Workflows and Tasks added!";
        $REF= "CRM Alert";
        $messagedata="All workflows and tasks have been assigned to this client";
                
        $database->query("INSERT INTO client_note SET client_id=:CID, client_name=:recipientholder, sent_by='ADL', note_type=:NOTE, message=:MSG ");
        $database->bind(':CID',$CID);
        $database->bind(':recipientholder',$REF);
        $database->bind(':NOTE',$notedata);
        $database->bind(':MSG',$messagedata);
        $database->execute();                  

        ?>