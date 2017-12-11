<?php
include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('/../../includes/adl_features.php');
include('/../../includes/Access_Levels.php');
include('/../../includes/ADL_PDO_CON.php');
include('/../../includes/ADL_MYSQLI_CON.php');

if (!in_array($hello_name,$Level_8_Access, true)) {
    header('Location: /../../../CRMmain.php'); die;
}

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($EXECUTE)) {

$DATE= filter_input(INPUT_GET, 'DATE', FILTER_SANITIZE_SPECIAL_CHARS);

    $file="TRACKER_PANTS";
    $filename = $file."_".date("Y-m-d_H-i",time());
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$filename.'.csv');    

    if($EXECUTE=='1') {
        if(isset($DATE)) {
    
     $output = "Date, closer, agent, client, phone, current_premium, our_premium, sale, comments\n";
                    $query = $pdo->prepare("SELECT 
    date_updated,
    closer,
    agent,
    client,
    phone,
    current_premium,
    our_premium,
    comments,
    sale
FROM
    closer_trackers
WHERE
    DATE(date_added) = :DATE
ORDER BY date_added DESC");
                    $query->bindParam(':DATE', $DATE, PDO::PARAM_STR);
                    
        } else { 
            
            $output = "Date, closer, agent, client, phone, current_premium, our_premium, sale, comments\n";
            $query = $pdo->prepare("SELECT 
    date_updated,
    closer,
    agent,
    client,
    phone,
    current_premium,
    our_premium,
    comments,
    sale
FROM
    closer_trackers
WHERE
    DATE(date_added) >= CURDATE()
ORDER BY date_added DESC");
                    
}
                    $query->execute();
                    $list = $query->fetchAll();
                    foreach ($list as $rs) {
                    
                        $DATE=filter_var($rs['date_updated'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $closer=filter_var($rs['closer'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $agent=filter_var($rs['agent'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $client=filter_var($rs['client'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $phone=filter_var($rs['phone'],FILTER_SANITIZE_NUMBER_INT); 
                        $current_premium=filter_var($rs['current_premium'],FILTER_SANITIZE_NUMBER_FLOAT); 
                        $our_premium=filter_var($rs['our_premium'],FILTER_SANITIZE_NUMBER_FLOAT); 
                        $comments=filter_var($rs['comments'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                        $comments_edited = str_replace(',', ' ', $comments);
                        $sale=filter_var($rs['sale'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    
                        $output .= $DATE.",".$closer.",".$agent.",".$client.",".$phone.",".$current_premium.",".$our_premium.",".$sale.",".$comments_edited."\n";
                        
                    }
                    echo $output;
                    exit;         
        
    }

}
?>