<?php 
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/../../../classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($ffdealsheets == '0') {
    header('Location: /../../../../CRMmain.php?Feature=NotEnabled');
    die;
}
    
    $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
    $TYPE= filter_input(INPUT_GET, 'TYPE', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if(isset($EXECUTE)){
            
        $tracker_id= filter_input(INPUT_POST, 'tracker_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);        
        $agent= filter_input(INPUT_POST, 'agent_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $closer= filter_input(INPUT_POST, 'closer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $client= filter_input(INPUT_POST, 'client', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $phone= filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $curprem= filter_input(INPUT_POST, 'current_premium', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $ourprem= filter_input(INPUT_POST, 'our_premium', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $comments= filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sale= filter_input(INPUT_POST, 'sale', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dec= filter_input(INPUT_POST, 'dec', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        
        $MTG= filter_input(INPUT_POST, 'MTG', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $LEAD_UP= filter_input(INPUT_POST, 'LEAD_UP', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
           $YEAR = date("Y");
    $DAY = date("D");
    $MONTH = date("M");
    $DATE = date("D d-m-y");
            
            if($EXECUTE=='1') {
                $TID= filter_input(INPUT_GET, 'TID', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                $UPSELL_STATUS= filter_input(INPUT_POST, 'UPSELLS_STATUS', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                $UPSELL_NOTES= filter_input(INPUT_POST, 'UPSELLS_NOTES', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 

                
            $UPDATE = $pdo->prepare("UPDATE closer_trackers set upsell_status=:STATUS, upsell_notes=:NOTES, upsell_agent=:AGENT WHERE tracker_id=:ID");
            $UPDATE->bindParam(':ID', $TID, PDO::PARAM_INT); 
            $UPDATE->bindParam(':AGENT', $hello_name, PDO::PARAM_STR); 
            $UPDATE->bindParam(':NOTES', $UPSELL_NOTES, PDO::PARAM_STR); 
            $UPDATE->bindParam(':STATUS', $UPSELL_STATUS, PDO::PARAM_STR); 
            $UPDATE->execute();
            
           header('Location: ../Trackers.php?query=DEFAULT&result=UPDATED'); die;
            }
            if($EXECUTE=='2') {
                
                        //GET EMPLOYEE_ID TO ADD TO RAG
        
        $GET_EID = $pdo->prepare("SELECT 
    employee_id
FROM
    employee_details
WHERE
    CONCAT(firstname, ' ', lastname) = :NAME");
        $GET_EID->bindParam(':NAME', $agent, PDO::PARAM_STR);
        $GET_EID->execute();
        $EID_RESULT = $GET_EID->fetch(PDO::FETCH_ASSOC);

        $EID = $EID_RESULT['employee_id'];        

        //UPDATE TRACKERS
                
            $UPDATE = $pdo->prepare("UPDATE closer_trackers set mtg=:mtg, lead_up=:up, agent=:agent, client=:client, phone=:phone, current_premium=:curprem, our_premium=:ourprem, comments=:comments, sale=:sale WHERE tracker_id=:id AND closer=:closer");
            $UPDATE->bindParam(':id', $tracker_id, PDO::PARAM_INT); 
            $UPDATE->bindParam(':closer', $closer, PDO::PARAM_STR); 
            $UPDATE->bindParam(':agent', $agent, PDO::PARAM_STR); 
            $UPDATE->bindParam(':client', $client, PDO::PARAM_STR); 
            $UPDATE->bindParam(':phone', $phone, PDO::PARAM_STR); 
            $UPDATE->bindParam(':curprem', $curprem, PDO::PARAM_STR); 
            $UPDATE->bindParam(':up', $LEAD_UP, PDO::PARAM_STR);
            $UPDATE->bindParam(':ourprem', $ourprem, PDO::PARAM_STR); 
            $UPDATE->bindParam(':comments', $comments, PDO::PARAM_STR); 
            $UPDATE->bindParam(':sale', $sale, PDO::PARAM_STR); 
            $UPDATE->bindParam(':mtg', $MTG, PDO::PARAM_STR); 
            $UPDATE->execute();
            
        //CHECK IF AGENT IS ON EMPLOYEE DATABASE FIRST OTHERWISE IGNORE BELOW
        if($EID>'0') {
            
         //GET LEADS AND SALES
            
        $GET_LS = $pdo->prepare("SELECT 
agent,
    COUNT(IF(sale = 'SALE',
        1,
        NULL)) AS Sales,
 COUNT(IF(sale IN ('SALE' , 'NoCard',
            'QDE',
            'DEC',
            'QUN',
            'DIDNO',
            'QCBK',
            'QQQ',
            'QML'),
        1,
        NULL)) AS Leads
FROM
    closer_trackers

WHERE
date_added > DATE(NOW()) AND agent=:agent");
        $GET_LS->bindParam(':agent', $agent, PDO::PARAM_STR);
        $GET_LS->execute();
        $GL_RESULT = $GET_LS->fetch(PDO::FETCH_ASSOC);
   
        $SALES=$GL_RESULT['Sales'];
        $LEADS=$GL_RESULT['Leads'];
        
        //CHECK IF AGENT IS ALREADY ON RAG
        
        $CHK_RAG = $pdo->prepare("SELECT 
    employee_id, id
FROM
    lead_rag
WHERE
    employee_id =:EID AND date=:date AND year=:year AND month=:month ");
        $CHK_RAG->bindParam(':EID', $EID, PDO::PARAM_STR);
        $CHK_RAG->bindParam(':date', $DATE, PDO::PARAM_STR);
        $CHK_RAG->bindParam(':year', $YEAR, PDO::PARAM_STR);
        $CHK_RAG->bindParam(':month', $MONTH, PDO::PARAM_STR);
        $CHK_RAG->execute();
        $CHK_RAGRESULT = $CHK_RAG->fetch(PDO::FETCH_ASSOC);     
        if ($CHK_RAG->rowCount()>=1) { 
        
        $RAG_ID=$CHK_RAGRESULT['id'];    
            //IF YES UPDATE
            
        $database = new Database();
        $database->beginTransaction();

        $database->query("UPDATE lead_rag set sales=:sales, leads=:leads, updated_by=:hello WHERE id=:RID AND month=:month AND year=:year AND date=:date");
        $database->bind(':RID', $RAG_ID);
        $database->bind(':leads',$LEADS);
        $database->bind(':sales',$SALES);
        $database->bind(':date', $DATE);
        $database->bind(':year', $YEAR);
        $database->bind(':month', $MONTH);
        $database->bind(':hello', $hello_name);
        $database->execute();

        $database->endTransaction();
            
            
        } else {

            //IF NO INSERT
            
        $database = new Database();
        $database->beginTransaction();

        $database->query("INSERT INTO lead_rag set sales=:sales, leads=:leads, updated_by=:hello, employee_id=:REF, month=:month, year=:year, date=:date");
        $database->bind(':REF', $EID);
        $database->bind(':leads',$LEADS);
        $database->bind(':sales',$SALES);
        $database->bind(':date', $DATE);
        $database->bind(':year', $YEAR);
        $database->bind(':month', $MONTH);
        $database->bind(':hello', $hello_name);
        $database->execute();
 
        }
        
        }              
            
            if(isset($TYPE)) {
                if($TYPE=='CLOSER'){
                    header('Location: /addon/Trackers/Closers.php?EXECUTE=1&RETURN=UPDATED'); die;
                }
                if($TYPE=='AGENT') {
                    header('Location: /addon/Trackers/Agent.php?EXECUTE=1&RETURN=UPDATED'); die;
                }
                if($TYPE=='UPSELL') {
                    header('Location: /addon/Trackers/Upsell.php?EXECUTE=1&RETURN=UPDATED'); die;
                }
            }
            
   
                
            }
        }
        
       header('Location: /../../../../CRMmain.php'); die;
        
        ?>