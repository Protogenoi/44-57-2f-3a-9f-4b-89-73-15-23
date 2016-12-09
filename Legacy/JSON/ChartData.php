<?php

include('../../includes/ADL_PDO_CON');

$Legacy= filter_input(INPUT_GET, 'Legacy', FILTER_SANITIZE_NUMBER_INT);

if(isset($Legacy)) { if($Legacy=='1') {
    
    $dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
    $datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);

    if(!isset($dateto)) { 
    
$query = $pdo->prepare("select ews_status AS status, count(ews_status) AS Total from assura_ews_data group by ews_status");

$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results);

header("content-type:application/json");
echo $json=json_encode($results);
    }
    
    
        if(isset($dateto)) { 
            
            $datefromnew ="$datefrom 00:00:00";
            $datenewfrom ="$dateto 22:00:00";
    
$query = $pdo->prepare("select ews_status AS status, count(ews_status) AS Total from assura_ews_data WHERE updated_date between :datefrom and :dateto AND ews_status !='NEW' group by ews_status");
$query->bindParam(':datefrom', $datefromnew, PDO::PARAM_STR, 100);
$query->bindParam(':dateto', $datenewfrom, PDO::PARAM_STR, 100);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results);

header("content-type:application/json");
echo $json=json_encode($results);
    }
    
}

}

?>
