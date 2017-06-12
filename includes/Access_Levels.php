<?php

require_once(__DIR__ . '../../includes/ADL_PDO_CON.php');

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
$cnquery->execute()or die(print_r($query->errorInfo(), true));
$companydetailsq = $cnquery->fetch(PDO::FETCH_ASSOC);

$companynamere = $companydetailsq['company_name'];


    $TRB_ACCESS = array("Michael","Tom Owen","Matt", "leighton", "Nick", "Abbiek", "carys", "Jakob", "Nicola", "Tina");
    $PFP_ACCESS=array("Dawiez Kift","Mark Cinderby","Matthew Pearson","Steven Campisi");
    $PLL_ACCESS=array("Robert Richards","Antony Evans","Samuel Bose","Grant Fulcher");
    $WI_ACCESS=array("Mark Ives","Matthew Page","Daniel Ferman","Luke Ratner","Lisa Hall","Ben Dearing");
    $TFAC_ACCESS=array("Jordan Davies","Daniel Matthews","James Keen","Craig Howells","Joe Rimell","Jake Woods");
    $APM_ACCESS=array("Adam Gregory","Alex Clarke","Allan Burnett","Ben Sears","Zac Collins","Elena Clifton","Rebecca Smith","Ian Grist","Phoenix Rayner","Josh Clark","Aton John","Gary Longfield","George Gleeson","Rebecca Rainford","Ethan James","Alex Jennison","Sean Thomas");
    
    $COM_LVL_10_ACCESS=array("Michael","Hayden");
    
    $COM_MANAGER_ACCESS=array("Michael","Hayden","Ben Sears","Carys Riley","carys","Dawiez Kift","Grant Fulcher","Lisa Hall","Andrew Collier");
    
    if (in_array($hello_name, $TRB_ACCESS, true)) { 
    $COMPANY_ENTITY='The Review Bureau';
    
    $Level_10_Access = array("Michael", "Matt", "leighton", "Nick");
    $Level_9_Access = array("Michael", "Matt", "leighton", "Nick", "carys");
    $Level_8_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Tina", "Heidy", "Nicola", "Mike","Gavin");
    $Level_3_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Chloe", "Audits", "Keith","Rhiannon","Ryan","TEST","Assured","Gavin");
    $Level_1_Access = array("Tom Owen","Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Chloe", "Audits","Rhiannon","Ryan","TEST","Assured","Gavin", "Keith");
    $Task_Access = array("Michael", "Abbiek");
    $SECRET = array("Michael", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Amy', "Chloe");
    $Agent_Access = array("111111111");
    $Closer_Access = array("James", "Hayley", "David", "Mike", "Kyle", "Sarah", "Richard", "Mike","Nicola");
    $Manager_Access = array("Richard", "Keith","Michael", "Matt", "leighton", "Nick", "carys");
    $QA_Access = array("Abbiek", "carys", "Jakob", "Nicola", "Tina", "Amy");

    }
        if (in_array($hello_name, $PFP_ACCESS, true)) { 
    $COMPANY_ENTITY='Protect Family Plans';
    }
        if (in_array($hello_name, $PLL_ACCESS, true)) { 
    $COMPANY_ENTITY='Protected Life Ltd';
    }
        if (in_array($hello_name, $WI_ACCESS, true)) { 
    $COMPANY_ENTITY='We Insure';
    }
        if (in_array($hello_name, $TFAC_ACCESS, true)) { 
    $COMPANY_ENTITY='The Financial Assessment Centre';
    }
        if (in_array($hello_name, $APM_ACCESS, true)) { 
    $COMPANY_ENTITY='Assured Protect and Mortgages';
    }
        if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 
    $COMPANY_ENTITY= filter_input(INPUT_POST, 'COMPANY_ENTITY', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(empty($COMPANY_ENTITY)) {
        
            if (in_array($hello_name, $TRB_ACCESS, true)) { 
    $COMPANY_ENTITY='The Review Bureau';
            }
        
                if (in_array($hello_name, $PFP_ACCESS, true)) { 
    $COMPANY_ENTITY='Protect Family Plans';
    }
        if (in_array($hello_name, $PLL_ACCESS, true)) { 
    $COMPANY_ENTITY='Protected Life Ltd';
    }
        if (in_array($hello_name, $WI_ACCESS, true)) { 
    $COMPANY_ENTITY='We Insure';
    }
        if (in_array($hello_name, $TFAC_ACCESS, true)) { 
    $COMPANY_ENTITY='The Financial Assessment Centre';
    }
        if (in_array($hello_name, $APM_ACCESS, true)) { 
    $COMPANY_ENTITY='Assured Protect and Mortgages';
    }
        
    }
    
    }     
    

if ($companynamere == 'The Review Bureau') {
    $Level_10_Access = array("Michael", "Matt", "leighton", "Nick");
    $Level_9_Access = array("Michael", "Matt", "leighton", "Nick", "carys");
    $Level_8_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Tina", "Heidy", "Nicola", "Mike","Gavin");
    $Level_3_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Chloe", "Audits", "Keith","Rhiannon","Ryan","TEST","Assured","Gavin");
    $Level_1_Access = array("Michael", "Matt", "leighton", "Nick", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Heidy', 'Amy', "Chloe", "Audits","Rhiannon","Ryan","TEST","Assured","Gavin", "Keith");
    $Task_Access = array("Michael", "Abbiek");
    $SECRET = array("Michael", "Abbiek", "carys", "Jakob", "Nicola", "Tina", 'Amy', "Chloe");
    $Agent_Access = array("111111111");
    $Closer_Access = array("James", "Hayley", "David", "Mike", "Kyle", "Sarah", "Richard", "Mike","Nicola");
    $Manager_Access = array("Richard", "Keith","Michael", "Matt", "leighton", "Nick", "carys");
    $QA_Access = array("Abbiek", "carys", "Jakob", "Nicola", "Tina", "Amy");

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

if ($companynamere == 'ADLp') {
    $Level_10_Access = array("Michael");
    $Level_8_Access = array("Michael");
    $Level_3_Access = array("Michael");
    $Level_1_Access = array("Michael");
    
}



?>