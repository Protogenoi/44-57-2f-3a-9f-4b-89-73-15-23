<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($ffdealsheets) && $ffdealsheets=='0') {
    header('Location: ../../CRMmain.php?Feature=NotEnabled'); die;
}

        $QUERY= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_NUMBER_INT);
        
        if(isset($QUERY)) {
        
    include('../../includes/Access_Levels.php');
    include('../../classes/database_class.php');
    
switch($hello_name) {
    
    case "724";
        $real_name='Chloe John';
        break;
    case "1034";
        $real_name='Adam Arrigan';
        break;
    case "Michael";
        $real_name='Michael';
        break;
        case "Roxy";
        $real_name='Roxy';
        break;
            case "carys";
        $real_name='Carys Riley';
        break;
                case "Abbiek";
        $real_name='Abbie Kenyon';
        break;
            case "511";
        $real_name='Kyle Barnett';
        break;
                case "519";
        $real_name='Ricky Derrick';
        break;
     case "103";
        $real_name='Sarah Wallace';
        break;
         case "212";
        $real_name='Natham James';
        break;
         case "104";
        $real_name='Richard Michaels';
        break;
    case "188";
        $real_name='Gavin Fulford';
        break;
    case "555";
        $real_name='James Adams';
        break;
        case "1009";
        $real_name='Matthew Jasper';
        break;
            case "1185";
        $real_name='Rhys Morris';
        break;
    default;
        $real_name=$hello_name;
        
}
    
    if($QUERY=='1') {
    
    $database = new Database(); 
        $database->beginTransaction();
        
            $database->query("SELECT agent FROM dealsheet_call WHERE agent=:agent");
            $database->bind(':agent',$real_name);
            $database->execute(); 
            
            if ($database->rowCount()>=1) {
                
            $database->query("DELETE FROM dealsheet_call WHERE agent=:agent");
            $database->bind(':agent',$real_name);
            $database->execute();                 
                
                
            }
  
            else {
                
            $database->query("INSERT INTO dealsheet_call set agent=:agent");
            $database->bind(':agent',$real_name);
            $database->execute(); 
            
            }
            
  $database->endTransaction();
    }

    
        }
  
  ?>