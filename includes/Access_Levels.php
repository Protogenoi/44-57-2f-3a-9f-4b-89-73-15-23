<?php

require_once(__DIR__ . '../../includes/ADL_PDO_CON.php');

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
$cnquery->execute()or die(print_r($query->errorInfo(), true));
$companydetailsq = $cnquery->fetch(PDO::FETCH_ASSOC);

$companynamere = $companydetailsq['company_name'];

if ($companynamere == 'The Review Bureau') {
    $Level_10_Access = array("Michael", "Matt", "leighton", "Nick");
    $Level_9_Access = array("Michael", "Matt", "leighton", "Nick", "carys");
    $Level_8_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Tina", "Heidy", "Nicola", "Mike","Gavin");
    $Level_3_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Chloe", "Audits", "Keith","Rhiannon","Ryan","TEST","Assured","Gavin");
    $Level_1_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Chloe", "Audits","Rhiannon","Ryan","TEST","Assured","Gavin");
    $Task_Access = array("Michael", "Abbiek");
    $SECRET = array("Michael", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Amy', "Chloe");
    $Agent_Access = array("111111111");
    $Closer_Access = array("James", "Hayley", "David", "Mike", "Kyle", "Sarah", "Richard", "Mike");
    $Manager_Access = array("Richard", "Keith","Michael", "Matt", "leighton", "Nick", "carys");
    $QA_Access = array("Abbiek", "carys", "Jakob", "Nicola", "Tina", "Amy");
    
    $TRB_ACCESS = array("Matt", "leighton", "Nick", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Chloe", "Audits","Rhiannon","Ryan","Gavin");

    $COM_LVL_10_ACCESS=array("Michael","Hayden");
    $COM_MANAGER_ACCESS=array("Michael","Matt","Hayden");
    
      
    $PFP_ACCESS=array("BOB");
    $PLL_ACCESS=array("bbb");
    $WI_ACCESS=array("Michewael");
    $TFAC_ACCESS=array("Micerhael");
    $APM_ACCESS=array("Assured");
}

if ($companynamere == 'ADL_CUS') {
    $Level_10_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
    $Level_8_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
    $Level_3_Access = array("Michael", "Dean", "Helen", "Andrew", "David","James");
    $Level_1_Access = array("Michael", "Dean", "Helen", "Andrew", "David","James");
    $SECRET = array("Michael");
    $Task_Access = array("Michael", "Dean", "Helen", "Andrew", "David");
    
    $TFAC_ACCESS=array("Michael");
}

if ($companynamere == 'Assura') {
    $Level_10_Access = array("Michael");
    $Level_8_Access = array("Michael");
    $Level_3_Access = array("Michael");
    $Level_1_Access = array("Michael");
}

if ($companynamere == 'HWIFS') {
    $Level_10_Access = array("Michael");
    $Level_8_Access = array("Michael");
    $Level_3_Access = array("Michael");
    $Level_1_Access = array("Michael");
}

if ($companynamere == 'ADL') {
    $Level_10_Access = array("Michael");
    $Level_8_Access = array("Michael");
    $Level_3_Access = array("Michael");
    $Level_1_Access = array("Michael");
    
    $TRB_ACCESS=array("Michael","Matt","James Adams","Kyle Barnett","Sarah Wallace","David Bebee","Carys Riley","carys","Mike Lloyd","Hayley Hutchinson","Gavin Fulford");
    $PFP_ACCESS=array("Michael","Dawiez Kift","Mark Cinderby","Matthew Pearson","Steven Campisi");
    $PLL_ACCESS=array("Michael","Robert Richards","Antony Evans","Samuel Bose","Grant Fulcher");
    $WI_ACCESS=array("Michael","Mark Ives","Matthew Page","Daniel Ferman","Luke Ratner","Lisa Hall","Ben Dearing");
    $TFAC_ACCESS=array("Michael","Jordan Davies","Daniel Matthews","James Keen","Craig Howells","Joe Rimell","Jake Woods");
    $APM_ACCESS=array("Michael","Adam Gregory","Alex Clarke","Allan Burnett","Ben Sears","Zac Collins","Elena Clifton","Rebecca Smith","Ian Grist","Phoenix Rayner","Josh Clark","Aton John","Gary Longfield","George Gleeson","Rebecca Rainford","Ethan James","Alex Jennison","Sean Thomas");
    
    $COM_LVL_10_ACCESS=array("Michael","Hayden");
    
    $COM_MANAGER_ACCESS=array("Michael","Hayden","Ben Sears","Carys Riley","carys","Dawiez Kift","Grant Fulcher","Lisa Hall","Andrew Collier");
}


    
      
    $PFP_ACCESS=array("BOB");
    $PLL_ACCESS=array("bbb");
    $WI_ACCESS=array("Michewael");
    $TFAC_ACCESS=array("Micerhael");
    $APM_ACCESS=array("Assured");

?>