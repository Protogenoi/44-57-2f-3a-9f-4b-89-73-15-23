<?php

class HistoryOverviewModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getHistoryOverview($TRACKING_USER,$TRACKING_DATE) {

        $stmt = $this->pdo->prepare("SELECT 
    tracking_history_user,
    COUNT(IF(tracking_history_url LIKE '%auditor_menu.php?RETURN=ADDED%',
        1,
        NULL)) AS LG_Audit,
    COUNT(IF(tracking_history_url LIKE '%lead_gen_reports.php?audit=y%',
        1,
        NULL)) AS Lead_Audit,
    COUNT(IF(tracking_history_url LIKE '%Aviva/Menu.php?RETURN=ADDED%',
        1,
        NULL)) AS Aviva_Audit,
     COUNT(IF(tracking_history_url LIKE '%WOL/Menu.php?query=WOL%',
        1,
        NULL)) AS WOL_Audit,       
    COUNT(IF(tracking_history_url LIKE '%ViewClient.php?search=%',
        1,
        NULL)) AS Client_Views,
    COUNT(IF(tracking_history_url LIKE '%AddClient.php',
        1,
        NULL)) AS Add_Client,
     COUNT(IF(tracking_history_url LIKE '%ViewClient.php?clientedited=y%',
        1,
        NULL)) AS Edit_Client, 
     COUNT(IF(tracking_history_url LIKE '%ViewClient.php?policyedited=y%',
        1,
        NULL)) AS Edit_Policy,          
     COUNT(IF(tracking_history_url LIKE '%ViewClient.php?clientnotesadded%',
        1,
        NULL)) AS Client_Notes,             
            COUNT(IF(tracking_history_url LIKE '%ViewClient.php?policyadded=y%',
        1,
        NULL)) AS Add_Policy,     
        COUNT(IF(tracking_history_url LIKE '%ViewClient.php?email%',
        1,
        NULL)) AS Email_Client,   
         COUNT(IF(tracking_history_url LIKE '%ViewClient.php?smssent=y%',
        1,
        NULL)) AS Sent_SMS,          
    COUNT(IF(tracking_history_url LIKE '%ViewPolicy.php?policyid=%',
        1,
        NULL)) AS View_Policy,
    COUNT(IF(tracking_history_url LIKE '%life_upload.php?life=%',
        1,
        NULL)) AS Uploads,
    COUNT(IF(tracking_history_url LIKE '%SearchClients.php',
        1,
        NULL)) AS Advanced_Client_Search,
    COUNT(IF(tracking_history_url LIKE '%Search.php',
        1,
        NULL)) AS Basic_Client_Search,
    COUNT(IF(tracking_history_url LIKE '%SearchPolicies.php',
        1,
        NULL)) AS Advanced_Policy_Search,
    COUNT(IF(tracking_history_url LIKE '%KeyFactsEmail.php?emailsent%',
        1,
        NULL)) AS Keyfacts_Email,    
    COUNT(IF(tracking_history_url LIKE '%LifeDealSheet.php?query=CloserTrackers&%',
        1,
        NULL)) AS Tracker_Added     
FROM
    tracking_history
WHERE
    tracking_history_user=:USER
AND
    DATE(tracking_history_date)=:DATE");
        $stmt->bindParam(':USER', $TRACKING_USER, PDO::PARAM_STR);
        $stmt->bindParam(':DATE', $TRACKING_DATE, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>