<?php
require_once(__DIR__ . '../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 9);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '../../../includes/adl_features.php');
require_once(__DIR__ . '../../../includes/Access_Levels.php');
require_once(__DIR__ . '../../../includes/adlfunctions.php');
require_once(__DIR__ . '../../../classes/database_class.php');
require_once(__DIR__ . '../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$AGENCY = filter_input(INPUT_GET, 'AGENCY', FILTER_SANITIZE_SPECIAL_CHARS);

      switch ($AGENCY) {
          case "Bluestone Protect":
              $AGENCY_ENTITY_ID='1';
              break;
          case "Protect Family Plans":
              $AGENCY_ENTITY_ID='2';
              break;
          case "Protected Life Ltd":
                $AGENCY_ENTITY_ID='3';
                  break;
              case "We Insure":             
                  $AGENCY_ENTITY_ID='4';
                  break;
              case "The Financial Assessment Centre":             
                  $AGENCY_ENTITY_ID='5';
                  break;
              case "Assured Protect and Mortgages":             
                  $AGENCY_ENTITY_ID='6';
                  break;              
              default:
                  $AGENCY_ENTITY_ID='0';
                  }   

if(isset($EXECUTE)) {
    if($EXECUTE=='1') {
             
    $LEGAL_ENTITY_NAME = filter_input(INPUT_POST, 'LEGAL_ENTITY_NAME', FILTER_SANITIZE_SPECIAL_CHARS);
    $TRADING_NAMES = filter_input(INPUT_POST, 'TRADING_NAMES', FILTER_SANITIZE_SPECIAL_CHARS);
    $PRINCIPAL_FIRM = filter_input(INPUT_POST, 'PRINCIPAL_FIRM', FILTER_SANITIZE_SPECIAL_CHARS);
    $AUTH_NUMBERS = filter_input(INPUT_POST, 'AUTH_NUMBERS', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICO_RENEWAL_DATE = filter_input(INPUT_POST, 'ICO_RENEWAL_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $DIRECTOR_INFO = filter_input(INPUT_POST, 'DIRECTOR_INFO', FILTER_SANITIZE_SPECIAL_CHARS);
    $BUSINESS_OVERVIEW = filter_input(INPUT_POST, 'BUSINESS_OVERVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $GOV_STRAT_OVERVIEW = filter_input(INPUT_POST, 'GOV_STRAT_OVERVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $CLIENT_ACQ_OVERVIEW = filter_input(INPUT_POST, 'CLIENT_ACQ_OVERVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $CLIENT_ENG_OVERVIEW = filter_input(INPUT_POST, 'CLIENT_ENG_OVERVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $SER_DEL_OVERVIEW = filter_input(INPUT_POST, 'SER_DEL_OVERVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $TRN_COM_OVERVIEW = filter_input(INPUT_POST, 'TRN_COM_OVERVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $DATA_PRO_ARR_OVERVIEW = filter_input(INPUT_POST, 'DATA_PRO_ARR_OVERVIEW', FILTER_SANITIZE_SPECIAL_CHARS);   
    $COMP_HAN_OVERVIEW = filter_input(INPUT_POST, 'COMP_HAN_OVERVIEW', FILTER_SANITIZE_SPECIAL_CHARS); 

$DUPE_CHK = $pdo->prepare("SELECT car_business_overview_id_fk FROM car_business_overview WHERE car_business_overview_id_fk=:FK");
$DUPE_CHK->bindParam(':FK',$AGENCY_ENTITY_ID, PDO::PARAM_INT);
$DUPE_CHK->execute(); 
  $row=$DUPE_CHK->fetch(PDO::FETCH_ASSOC);
     if ($DUPE_CHK->rowCount()>=1) {  
         
        $UPDATE = $pdo->prepare("UPDATE car_business_overview 
SET
    car_business_overview_len =:LEN,
    car_business_overview_tr =:TR,
    car_business_overview_pf =:PF,
    car_business_overview_an =:AN,
    car_business_overview_ico_rd =:ICO,
    car_business_overview_psdi =:PSDI,
    car_business_overview_bm =:BM,
    car_business_overview_gs =:GS,
    car_business_overview_ca =:CA,
    car_business_overview_ce =:CE,
    car_business_overview_sd =:SD,
    car_business_overview_tc =:TC,
    car_business_overview_dpa =:DPA,
    car_business_overview_ch =:CH
    WHERE
    car_business_overview_id_fk =:FK");
        $UPDATE->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
        $UPDATE->bindParam(':LEN', $LEGAL_ENTITY_NAME, PDO::PARAM_STR);
        $UPDATE->bindParam(':TR', $TRADING_NAMES, PDO::PARAM_STR);
        $UPDATE->bindParam(':PF', $PRINCIPAL_FIRM, PDO::PARAM_STR);
        $UPDATE->bindParam(':AN', $AUTH_NUMBERS, PDO::PARAM_STR);
        $UPDATE->bindParam(':ICO', $ICO_RENEWAL_DATE, PDO::PARAM_STR);
        $UPDATE->bindParam(':PSDI', $DIRECTOR_INFO, PDO::PARAM_STR);
        $UPDATE->bindParam(':BM', $BUSINESS_OVERVIEW, PDO::PARAM_STR);
        $UPDATE->bindParam(':GS', $GOV_STRAT_OVERVIEW, PDO::PARAM_STR);
        $UPDATE->bindParam(':CA', $CLIENT_ACQ_OVERVIEW, PDO::PARAM_STR);
        $UPDATE->bindParam(':CE', $CLIENT_ENG_OVERVIEW, PDO::PARAM_STR);
        $UPDATE->bindParam(':SD', $SER_DEL_OVERVIEW, PDO::PARAM_STR);
        $UPDATE->bindParam(':TC', $TRN_COM_OVERVIEW, PDO::PARAM_STR);
        $UPDATE->bindParam(':DPA', $DATA_PRO_ARR_OVERVIEW, PDO::PARAM_STR);
        $UPDATE->bindParam(':CH', $COMP_HAN_OVERVIEW, PDO::PARAM_STR);
        $UPDATE->execute();  
        
        header('Location: ../CAR.php?RETURN=UPDATED&AGENCY='.$AGENCY); die;
         
     } else {

        $INSERT = $pdo->prepare("INSERT INTO car_business_overview 
SET
    car_business_overview_len =:LEN,
    car_business_overview_tr =:TR,
    car_business_overview_pf =:PF,
    car_business_overview_an =:AN,
    car_business_overview_ico_rd =:ICO,
    car_business_overview_psdi =:PSDI,
    car_business_overview_bm =:BM,
    car_business_overview_gs =:GS,
    car_business_overview_ca =:CA,
    car_business_overview_ce =:CE,
    car_business_overview_sd =:SD,
    car_business_overview_tc =:TC,
    car_business_overview_dpa =:DPA,
    car_business_overview_ch =:CH,
    car_business_overview_id_fk =:FK");
        $INSERT->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
        $INSERT->bindParam(':LEN', $LEGAL_ENTITY_NAME, PDO::PARAM_STR);
        $INSERT->bindParam(':TR', $TRADING_NAMES, PDO::PARAM_STR);
        $INSERT->bindParam(':PF', $PRINCIPAL_FIRM, PDO::PARAM_STR);
        $INSERT->bindParam(':AN', $AUTH_NUMBERS, PDO::PARAM_STR);
        $INSERT->bindParam(':ICO', $ICO_RENEWAL_DATE, PDO::PARAM_STR);
        $INSERT->bindParam(':PSDI', $DIRECTOR_INFO, PDO::PARAM_STR);
        $INSERT->bindParam(':BM', $BUSINESS_OVERVIEW, PDO::PARAM_STR);
        $INSERT->bindParam(':GS', $GOV_STRAT_OVERVIEW, PDO::PARAM_STR);
        $INSERT->bindParam(':CA', $CLIENT_ACQ_OVERVIEW, PDO::PARAM_STR);
        $INSERT->bindParam(':CE', $CLIENT_ENG_OVERVIEW, PDO::PARAM_STR);
        $INSERT->bindParam(':SD', $SER_DEL_OVERVIEW, PDO::PARAM_STR);
        $INSERT->bindParam(':TC', $TRN_COM_OVERVIEW, PDO::PARAM_STR);
        $INSERT->bindParam(':DPA', $DATA_PRO_ARR_OVERVIEW, PDO::PARAM_STR);
        $INSERT->bindParam(':CH', $COMP_HAN_OVERVIEW, PDO::PARAM_STR);
        $INSERT->execute();
        
        header('Location: ../CAR.php?RETURN=INSERT&AGENCY='.$AGENCY); die;
        
     } 
    header('Location: ../CAR.php?RETURN=FAIL'); die;
    
    }
    
    if($EXECUTE=='2') {
    /* RISK OVERVIEW */
    
    $TPS_SUM_RISK = filter_input(INPUT_POST, 'TPS_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);    
    $TPS_COM_RISK = filter_input(INPUT_POST, 'TPS_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $TPS_IMPACT_RISK = filter_input(INPUT_POST, 'TPS_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $TPS_SCORE_RISK = filter_input(INPUT_POST, 'TPS_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $TPS_PRO_RISK = filter_input(INPUT_POST, 'TPS_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $DU_SUM_RISK = filter_input(INPUT_POST, 'DU_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $DU_COM_RISK = filter_input(INPUT_POST, 'DU_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $DU_IMPACT_RISK = filter_input(INPUT_POST, 'DU_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $DU_SCORE_RISK = filter_input(INPUT_POST, 'DU_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $DU_PRO_RISK = filter_input(INPUT_POST, 'DU_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $DPRK_SUM_RISK = filter_input(INPUT_POST, 'DPRK_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $DPRK_COM_RISK = filter_input(INPUT_POST, 'DPRK_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $DPRK_IMPACT_RISK = filter_input(INPUT_POST, 'DPRK_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $DPRK_SCORE_RISK = filter_input(INPUT_POST, 'DPRK_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $DPRK_PRO_RISK = filter_input(INPUT_POST, 'DPRK_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $SAC_SUM_RISK = filter_input(INPUT_POST, 'SAC_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $SAC_COM_RISK = filter_input(INPUT_POST, 'SAC_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $SAC_IMPACT_RISK = filter_input(INPUT_POST, 'SAC_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $SAC_SCORE_RISK = filter_input(INPUT_POST, 'SAC_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $SAC_PRO_RISK = filter_input(INPUT_POST, 'SAC_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CH_SUM_RISK = filter_input(INPUT_POST, 'CH_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $CH_COM_RISK = filter_input(INPUT_POST, 'CH_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $CH_IMPACT_RISK = filter_input(INPUT_POST, 'CH_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $CH_SCORE_RISK = filter_input(INPUT_POST, 'CH_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $CH_PRO_RISK = filter_input(INPUT_POST, 'CH_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $VC_SUM_RISK = filter_input(INPUT_POST, 'VC_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $VC_COM_RISK = filter_input(INPUT_POST, 'VC_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $VC_IMPACT_RISK = filter_input(INPUT_POST, 'VC_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $VC_SCORE_RISK = filter_input(INPUT_POST, 'VC_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $VC_PRO_RISK = filter_input(INPUT_POST, 'VC_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CRU_SUM_RISK = filter_input(INPUT_POST, 'CRU_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $CRU_COM_RISK = filter_input(INPUT_POST, 'CRU_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $CRU_IMPACT_RISK = filter_input(INPUT_POST, 'CRU_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $CRU_SCORE_RISK = filter_input(INPUT_POST, 'CRU_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $CRU_PRO_RISK = filter_input(INPUT_POST, 'CRU_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
   
    $PCI_SUM_RISK = filter_input(INPUT_POST, 'PCI_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $PCI_COM_RISK = filter_input(INPUT_POST, 'PCI_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $PCI_IMPACT_RISK = filter_input(INPUT_POST, 'PCI_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $PCI_SCORE_RISK = filter_input(INPUT_POST, 'PCI_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $PCI_PRO_RISK = filter_input(INPUT_POST, 'PCI_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $AS_SUM_RISK = filter_input(INPUT_POST, 'AS_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $AS_COM_RISK = filter_input(INPUT_POST, 'AS_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $AS_IMPACT_RISK = filter_input(INPUT_POST, 'AS_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS); 
    $AS_SCORE_RISK = filter_input(INPUT_POST, 'AS_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $AS_PRO_RISK = filter_input(INPUT_POST, 'AS_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $RFA_SUM_RISK = filter_input(INPUT_POST, 'RFA_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $RFA_COM_RISK = filter_input(INPUT_POST, 'RFA_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $RFA_IMPACT_RISK = filter_input(INPUT_POST, 'RFA_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $RFA_SCORE_RISK = filter_input(INPUT_POST, 'RFA_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $RFA_PRO_RISK = filter_input(INPUT_POST, 'RFA_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $MMC_SUM_RISK = filter_input(INPUT_POST, 'MMC_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $MMC_COM_RISK = filter_input(INPUT_POST, 'MMC_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $MMC_IMPACT_RISK = filter_input(INPUT_POST, 'MMC_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $MMC_SCORE_RISK = filter_input(INPUT_POST, 'MMC_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $MMC_PRO_RISK = filter_input(INPUT_POST, 'MMC_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $AR_SUM_RISK = filter_input(INPUT_POST, 'AR_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $AR_COM_RISK = filter_input(INPUT_POST, 'AR_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $AR_IMPACT_RISK = filter_input(INPUT_POST, 'AR_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $AR_SCORE_RISK = filter_input(INPUT_POST, 'AR_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $AR_PRO_RISK = filter_input(INPUT_POST, 'AR_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $TAC_SUM_RISK = filter_input(INPUT_POST, 'TAC_SUM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $TAC_COM_RISK = filter_input(INPUT_POST, 'TAC_COM_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $TAC_IMPACT_RISK = filter_input(INPUT_POST, 'TAC_IMPACT_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $TAC_SCORE_RISK = filter_input(INPUT_POST, 'TAC_SCORE_RISK', FILTER_SANITIZE_SPECIAL_CHARS);
    $TAC_PRO_RISK = filter_input(INPUT_POST, 'TAC_PRO_RISK', FILTER_SANITIZE_SPECIAL_CHARS);       
    
$DUPE_CHK = $pdo->prepare("SELECT car_risk_overview_id_fk FROM car_risk_overview_1 WHERE car_risk_overview_id_fk=:FK");
$DUPE_CHK->bindParam(':FK',$AGENCY_ENTITY_ID, PDO::PARAM_INT);
$DUPE_CHK->execute(); 
  $row=$DUPE_CHK->fetch(PDO::FETCH_ASSOC);
     if ($DUPE_CHK->rowCount()>=1) {  
         
        $UPDATE1 = $pdo->prepare("UPDATE car_risk_overview_1
SET 
car_risk_overview_tps_sr=:TPS_SR, 
car_risk_overview_tps_cr=:TPS_CR, 
car_risk_overview_tps_ri=:TPS_RI, 
car_risk_overview_tps_rs=:TPS_RS, 
car_risk_overview_tps_rp=:TPS_RP, 
car_risk_overview_du_sr=:DU_SR, 
car_risk_overview_du_cr=:DU_CR, 
car_risk_overview_du_ri=:DU_RI, 
car_risk_overview_du_rs=:DU_RS, 
car_risk_overview_du_rp=:DU_RP, 
car_risk_overview_dprk_sr=:DPRK_SR, 
car_risk_overview_dprk_cr=:DPRK_CR, 
car_risk_overview_dprk_ri=:DPRK_RI, 
car_risk_overview_dprk_rs=:DPRK_RS, 
car_risk_overview_dprk_rp=:DPRK_RP, 
car_risk_overview_sc_sr=:SC_SR, 
car_risk_overview_sc_cr=:SC_CR, 
car_risk_overview_sc_ri=:SC_RI, 
car_risk_overview_sc_rs=:SC_RS, 
car_risk_overview_sc_rp=:SC_RP, 
car_risk_overview_ch_sr=:CH_SR, 
car_risk_overview_ch_cr=:CH_CR, 
car_risk_overview_ch_ri=:CH_RI, 
car_risk_overview_ch_rs=:CH_RS, 
car_risk_overview_ch_rp=:CH_RP
WHERE
car_risk_overview_id_fk=:FK");
        $UPDATE1->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
        $UPDATE1->bindParam(':TPS_SR', $TPS_SUM_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':TPS_CR', $TPS_COM_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':TPS_RI', $TPS_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':TPS_RS', $TPS_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':TPS_RP', $TPS_PRO_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':DU_SR', $DU_SUM_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':DU_CR', $DU_COM_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':DU_RI', $DU_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':DU_RS', $DU_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':DU_RP', $DU_PRO_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':DPRK_SR', $DPRK_SUM_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':DPRK_CR', $DPRK_COM_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':DPRK_RI', $DPRK_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':DPRK_RS', $DPRK_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':DPRK_RP', $DPRK_PRO_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':SC_SR', $SAC_SUM_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':SC_CR', $SAC_COM_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':SC_RI', $SAC_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':SC_RS', $SAC_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':SC_RP', $SAC_PRO_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':CH_SR', $CH_SUM_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':CH_CR', $CH_COM_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':CH_RI', $CH_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':CH_RS', $CH_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE1->bindParam(':CH_RP', $CH_PRO_RISK, PDO::PARAM_STR);
        $UPDATE1->execute();    
        
     } 
     
    else {
        echo " ABC $AGENCY_ENTITY_ID ABC $TPS_SUM_RISK ABC $TPS_COM_RISK ABC $TPS_IMPACT_RISK ABC $TPS_SCORE_RISK ABC $TPS_PRO_RISK <br>";
        echo " ABC $AGENCY_ENTITY_ID ABC $DU_SUM_RISK ABC $DU_COM_RISK ABC $DU_IMPACT_RISK ABC $DU_SCORE_RISK ABC $DU_PRO_RISK <br>";
        echo " ABC $AGENCY_ENTITY_ID ABC $DPRK_SUM_RISK ABC $DPRK_COM_RISK ABC $DPRK_IMPACT_RISK ABC $DPRK_SCORE_RISK ABC $DPRK_PRO_RISK <br>";
        echo " ABC $AGENCY_ENTITY_ID ABC $SAC_SUM_RISK ABC $SAC_COM_RISK ABC $SAC_IMPACT_RISK ABC $SAC_SCORE_RISK ABC $SAC_PRO_RISK <br>";
        echo " ABC $AGENCY_ENTITY_ID ABC $CH_SUM_RISK ABC $CH_COM_RISK ABC $CH_IMPACT_RISK ABC $CH_SCORE_RISK ABC $CH_PRO_RISK <br>";
        
        $INSERT1 = $pdo->prepare("
            INSERT INTO
            car_risk_overview_1
            SET
            car_risk_overview_tps_sr=:TPS_SR, 
car_risk_overview_tps_cr=:TPS_CR, 
car_risk_overview_tps_ri=:TPS_RI, 
car_risk_overview_tps_rs=:TPS_RS, 
car_risk_overview_tps_rp=:TPS_RP, 
car_risk_overview_du_sr=:DU_SR, 
car_risk_overview_du_cr=:DU_CR, 
car_risk_overview_du_ri=:DU_RI, 
car_risk_overview_du_rs=:DU_RS, 
car_risk_overview_du_rp=:DU_RP, 
car_risk_overview_dprk_sr=:DPRK_SR, 
car_risk_overview_dprk_cr=:DPRK_CR, 
car_risk_overview_dprk_ri=:DPRK_RI, 
car_risk_overview_dprk_rs=:DPRK_RS, 
car_risk_overview_dprk_rp=:DPRK_RP, 
car_risk_overview_sc_sr=:SC_SR, 
car_risk_overview_sc_cr=:SC_CR, 
car_risk_overview_sc_ri=:SC_RI, 
car_risk_overview_sc_rs=:SC_RS, 
car_risk_overview_sc_rp=:SC_RP, 
car_risk_overview_ch_sr=:CH_SR, 
car_risk_overview_ch_cr=:CH_CR, 
car_risk_overview_ch_ri=:CH_RI, 
car_risk_overview_ch_rs=:CH_RS, 
car_risk_overview_ch_rp=:CH_RP,
car_risk_overview_id_fk=:FK");
        $INSERT1->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
        $INSERT1->bindParam(':TPS_SR', $TPS_SUM_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':TPS_CR', $TPS_COM_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':TPS_RI', $TPS_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':TPS_RS', $TPS_SCORE_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':TPS_RP', $TPS_PRO_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':DU_SR', $DU_SUM_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':DU_CR', $DU_COM_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':DU_RI', $DU_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':DU_RS', $DU_SCORE_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':DU_RP', $DU_PRO_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':DPRK_SR', $DPRK_SUM_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':DPRK_CR', $DPRK_COM_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':DPRK_RI', $DPRK_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':DPRK_RS', $DPRK_SCORE_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':DPRK_RP', $DPRK_PRO_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':SC_SR', $SAC_SUM_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':SC_CR', $SAC_COM_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':SC_RI', $SAC_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':SC_RS', $SAC_SCORE_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':SC_RP', $SAC_PRO_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':CH_SR', $CH_SUM_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':CH_CR', $CH_COM_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':CH_RI', $CH_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':CH_RS', $CH_SCORE_RISK, PDO::PARAM_STR);
        $INSERT1->bindParam(':CH_RP', $CH_PRO_RISK, PDO::PARAM_STR);
        $INSERT1->execute();  
        
    }
        
$DUPE_CHK2 = $pdo->prepare("SELECT
        compliance_risk_overview_2_id 
        FROM 
        compliance_risk_overview_2 
        WHERE 
        compliance_risk_overview_2_id_fk=:FK");
$DUPE_CHK2->bindParam(':FK',$AGENCY_ENTITY_ID, PDO::PARAM_INT);
$DUPE_CHK2->execute(); 
  $row2=$DUPE_CHK2->fetch(PDO::FETCH_ASSOC);
     if ($DUPE_CHK2->rowCount()>=1) {  
        
        $UPDATE2 = $pdo->prepare("UPDATE
            compliance_risk_overview_2
SET 
car_risk_overview_vc_sr=:VC_SR, 
car_risk_overview_vc_cr=:VC_CR, 
car_risk_overview_vc_ri=:VC_RI, 
car_risk_overview_vc_rs=:VC_RS, 
car_risk_overview_vc_rp=:VC_RP, 
car_risk_overview_cru_sr=:CRU_SR, 
car_risk_overview_cru_cr=:CRU_CR, 
car_risk_overview_cru_ri=:CRU_RI, 
car_risk_overview_cru_rs=:CRU_RS, 
car_risk_overview_cru_rp=:CRU_RP, 
car_risk_overview_pci_sr=:PCI_SR, 
car_risk_overview_pci_cr=:PCI_CR, 
car_risk_overview_pci_ri=:PCI_RI, 
car_risk_overview_pci_rs=:PCI_RS, 
car_risk_overview_pci_rp=:PCI_RP, 
car_risk_overview_as_sr=:AS_SR, 
car_risk_overview_as_cr=:AS_CR, 
car_risk_overview_as_ri=:AS_RI, 
car_risk_overview_as_rs=:AS_RS, 
car_risk_overview_as_rp=:AS_RP, 
car_risk_overview_rfa_sr=:RFA_SR, 
car_risk_overview_rfa_cr=:RFA_CR, 
car_risk_overview_rfa_ri=:RFA_RI, 
car_risk_overview_rfa_rs=:RFA_RS, 
car_risk_overview_rfa_rp=:RFA_RP
WHERE
compliance_risk_overview_2_id_fk=:FK");
        $UPDATE2->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
        $UPDATE2->bindParam(':VC_SR', $VC_SUM_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':VC_CR', $VC_COM_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':VC_RI', $VC_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':VC_RS', $VC_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':VC_RP', $VC_PRO_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':CRU_SR', $CRU_SUM_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':CRU_CR', $CRU_COM_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':CRU_RI', $CRU_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':CRU_RS', $CRU_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':CRU_RP', $CRU_PRO_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':PCI_SR', $PCI_SUM_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':PCI_CR', $PCI_COM_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':PCI_RI', $PCI_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':PCI_RS', $PCI_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':PCI_RP', $PCI_PRO_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':AS_SR', $AS_SUM_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':AS_CR', $AS_COM_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':AS_RI', $AS_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':AS_RS', $AS_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':AS_RP', $AS_PRO_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':RFA_SR', $RFA_SUM_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':RFA_CR', $RFA_COM_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':RFA_RI', $RFA_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':RFA_RS', $RFA_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE2->bindParam(':RFA_RP', $RFA_PRO_RISK, PDO::PARAM_STR);       
        $UPDATE2->execute();            
        
     } else {
        
   $INSERT2 = $pdo->prepare("INSERT INTO compliance_risk_overview_2
SET 
car_risk_overview_vc_sr=:VC_SR, 
car_risk_overview_vc_cr=:VC_CR, 
car_risk_overview_vc_ri=:VC_RI, 
car_risk_overview_vc_rs=:VC_RS, 
car_risk_overview_vc_rp=:VC_RP, 
car_risk_overview_cru_sr=:CRU_SR, 
car_risk_overview_cru_cr=:CRU_CR, 
car_risk_overview_cru_ri=:CRU_RI, 
car_risk_overview_cru_rs=:CRU_RS, 
car_risk_overview_cru_rp=:CRU_RP, 
car_risk_overview_pci_sr=:PCI_SR, 
car_risk_overview_pci_cr=:PCI_CR, 
car_risk_overview_pci_ri=:PCI_RI, 
car_risk_overview_pci_rs=:PCI_RS, 
car_risk_overview_pci_rp=:PCI_RP, 
car_risk_overview_as_sr=:AS_SR, 
car_risk_overview_as_cr=:AS_CR, 
car_risk_overview_as_ri=:AS_RI, 
car_risk_overview_as_rs=:AS_RS, 
car_risk_overview_as_rp=:AS_RP, 
car_risk_overview_rfa_sr=:RFA_SR, 
car_risk_overview_rfa_cr=:RFA_CR, 
car_risk_overview_rfa_ri=:RFA_RI, 
car_risk_overview_rfa_rs=:RFA_RS, 
car_risk_overview_rfa_rp=:RFA_RP,
compliance_risk_overview_2_id_fk=:FK");
        $INSERT2->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
        $INSERT2->bindParam(':VC_SR', $VC_SUM_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':VC_CR', $VC_COM_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':VC_RI', $VC_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':VC_RS', $VC_SCORE_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':VC_RP', $VC_PRO_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':CRU_SR', $CRU_SUM_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':CRU_CR', $CRU_COM_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':CRU_RI', $CRU_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':CRU_RS', $CRU_SCORE_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':CRU_RP', $CRU_PRO_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':PCI_SR', $PCI_SUM_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':PCI_CR', $PCI_COM_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':PCI_RI', $PCI_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':PCI_RS', $PCI_SCORE_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':PCI_RP', $PCI_PRO_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':AS_SR', $AS_SUM_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':AS_CR', $AS_COM_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':AS_RI', $AS_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':AS_RS', $AS_SCORE_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':AS_RP', $AS_PRO_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':RFA_SR', $RFA_SUM_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':RFA_CR', $RFA_COM_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':RFA_RI', $RFA_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':RFA_RS', $RFA_SCORE_RISK, PDO::PARAM_STR);
        $INSERT2->bindParam(':RFA_RP', $RFA_PRO_RISK, PDO::PARAM_STR);       
        $INSERT2->execute();       
        
     }
     
             $DUPE_CHK3 = $pdo->prepare("SELECT compliance_risk_overview_3_id_fk FROM compliance_risk_overview_3 WHERE compliance_risk_overview_3_id_fk=:FK");
$DUPE_CHK3->bindParam(':FK',$AGENCY_ENTITY_ID, PDO::PARAM_INT);
$DUPE_CHK3->execute(); 
  $row3=$DUPE_CHK3->fetch(PDO::FETCH_ASSOC);
     if ($DUPE_CHK3->rowCount()>=1) {  
    
        $UPDATE3 = $pdo->prepare("UPDATE  compliance_risk_overview_3
SET 
car_risk_overview_mmc_sr=:MMC_SR, 
car_risk_overview_mmc_cr=:MMC_CR, 
car_risk_overview_mmc_ri=:MMC_RI, 
car_risk_overview_mmc_rs=:MMC_RS, 
car_risk_overview_mmc_rp=:MMC_RP, 
car_risk_overview_ar_sr=:AR_SR, 
car_risk_overview_ar_cr=:AR_CR, 
car_risk_overview_ar_ri=:AR_RI, 
car_risk_overview_ar_rs=:AR_RS, 
car_risk_overview_ar_rp=:AR_RP, 
car_risk_overview_tc_sr=:TC_SR, 
car_risk_overview_tc_cr=:TC_CR, 
car_risk_overview_tc_ri=:TC_RI, 
car_risk_overview_tc_rs=:TC_RS, 
car_risk_overview_tc_rp=:TC_RP
WHERE
compliance_risk_overview_3_id_fk=:FK");
        $UPDATE3->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
        $UPDATE3->bindParam(':MMC_SR', $MMC_SUM_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':MMC_CR', $MMC_COM_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':MMC_RI', $MMC_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':MMC_RS', $MMC_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':MMC_RP', $MMC_PRO_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':AR_SR', $AR_SUM_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':AR_CR', $AR_COM_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':AR_RI', $AR_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':AR_RS', $AR_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':AR_RP', $AR_PRO_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':TC_SR', $TAC_SUM_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':TC_CR', $TAC_COM_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':TC_RI', $TAC_IMPACT_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':TC_RS', $TAC_SCORE_RISK, PDO::PARAM_STR);
        $UPDATE3->bindParam(':TC_RP', $TAC_PRO_RISK, PDO::PARAM_STR);      
        $UPDATE3->execute();      
    
     } else {
        
        $INSERT3 = $pdo->prepare("INSERT INTO  compliance_risk_overview_3
SET 
car_risk_overview_mmc_sr=:MMC_SR, 
car_risk_overview_mmc_cr=:MMC_CR, 
car_risk_overview_mmc_ri=:MMC_RI, 
car_risk_overview_mmc_rs=:MMC_RS, 
car_risk_overview_mmc_rp=:MMC_RP, 
car_risk_overview_ar_sr=:AR_SR, 
car_risk_overview_ar_cr=:AR_CR, 
car_risk_overview_ar_ri=:AR_RI, 
car_risk_overview_ar_rs=:AR_RS, 
car_risk_overview_ar_rp=:AR_RP, 
car_risk_overview_tc_sr=:TC_SR, 
car_risk_overview_tc_cr=:TC_CR, 
car_risk_overview_tc_ri=:TC_RI, 
car_risk_overview_tc_rs=:TC_RS, 
car_risk_overview_tc_rp=:TC_RP,
compliance_risk_overview_3_id_fk=:FK");
        $INSERT3->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
        $INSERT3->bindParam(':MMC_SR', $MMC_SUM_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':MMC_CR', $MMC_COM_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':MMC_RI', $MMC_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':MMC_RS', $MMC_SCORE_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':MMC_RP', $MMC_PRO_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':AR_SR', $AR_SUM_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':AR_CR', $AR_COM_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':AR_RI', $AR_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':AR_RS', $AR_SCORE_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':AR_RP', $AR_PRO_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':TC_SR', $TAC_SUM_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':TC_CR', $TAC_COM_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':TC_RI', $TAC_IMPACT_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':TC_RS', $TAC_SCORE_RISK, PDO::PARAM_STR);
        $INSERT3->bindParam(':TC_RP', $TAC_PRO_RISK, PDO::PARAM_STR);      
        $INSERT3->execute();    
        
     }
        
    header('Location: ../CAR.php?RETURN=UPDATED&AGENCY='.$AGENCY); die;
    
    }
    
    if($EXECUTE=='3') {
    /* REMEDIAL ACTION */
    
    $TPS_SUM_ACTION = filter_input(INPUT_POST, 'TPS_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $TPS_TYPE_ACTION = filter_input(INPUT_POST, 'TPS_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $TPS_ON_ACTION = filter_input(INPUT_POST, 'TPS_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $TPS_DUE_DATE = filter_input(INPUT_POST, 'TPS_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $TPS_IMP_DATE = filter_input(INPUT_POST, 'TPS_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $TPS_REVIEW = filter_input(INPUT_POST, 'TPS_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $TPS_OWNER = filter_input(INPUT_POST, 'TPS_OWNER', FILTER_SANITIZE_SPECIAL_CHARS);    

    $DU_SUM_ACTION = filter_input(INPUT_POST, 'DU_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $DU_TYPE_ACTION = filter_input(INPUT_POST, 'DU_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $DU_ON_ACTION = filter_input(INPUT_POST, 'DU_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $DU_DUE_DATE = filter_input(INPUT_POST, 'DU_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $DU_IMP_DATE = filter_input(INPUT_POST, 'DU_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $DU_REVIEW = filter_input(INPUT_POST, 'DU_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $DU_OWNER = filter_input(INPUT_POST, 'DU_OWNER', FILTER_SANITIZE_SPECIAL_CHARS);        
 
    $DPRK_SUM_ACTION = filter_input(INPUT_POST, 'DPRK_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $DPRK_TYPE_ACTION = filter_input(INPUT_POST, 'DPRK_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $DPRK_ON_ACTION = filter_input(INPUT_POST, 'DPRK_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $DPRK_DUE_DATE = filter_input(INPUT_POST, 'DPRK_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $DPRK_IMP_DATE = filter_input(INPUT_POST, 'DPRK_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $DPRK_REVIEW = filter_input(INPUT_POST, 'DPRK_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $DPRK_OWNER = filter_input(INPUT_POST, 'DPRK_OWNER', FILTER_SANITIZE_SPECIAL_CHARS);   

    $SAC_SUM_ACTION = filter_input(INPUT_POST, 'SAC_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $SAC_TYPE_ACTION = filter_input(INPUT_POST, 'SAC_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $SAC_ON_ACTION = filter_input(INPUT_POST, 'SAC_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $SAC_DUE_DATE = filter_input(INPUT_POST, 'SAC_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $SAC_IMP_DATE = filter_input(INPUT_POST, 'SAC_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $SAC_REVIEW = filter_input(INPUT_POST, 'SAC_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $SAC_OWNER = filter_input(INPUT_POST, 'SAC_OWNER', FILTER_SANITIZE_SPECIAL_CHARS);        

    $CH_SUM_ACTION = filter_input(INPUT_POST, 'CH_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $CH_TYPE_ACTION = filter_input(INPUT_POST, 'CH_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $CH_ON_ACTION = filter_input(INPUT_POST, 'CH_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $CH_DUE_DATE = filter_input(INPUT_POST, 'CH_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $CH_IMP_DATE = filter_input(INPUT_POST, 'CH_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $CH_REVIEW = filter_input(INPUT_POST, 'CH_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $CH_OWNER = filter_input(INPUT_POST, 'CH_OWNER', FILTER_SANITIZE_SPECIAL_CHARS); 

    $VC_SUM_ACTION = filter_input(INPUT_POST, 'VC_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $VC_TYPE_ACTION = filter_input(INPUT_POST, 'VC_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $VC_ON_ACTION = filter_input(INPUT_POST, 'VC_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $VC_DUE_DATE = filter_input(INPUT_POST, 'VC_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $VC_IMP_DATE = filter_input(INPUT_POST, 'VC_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $VC_REVIEW = filter_input(INPUT_POST, 'VC_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $VC_OWNER = filter_input(INPUT_POST, 'VC_OWNER', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CRU_SUM_ACTION = filter_input(INPUT_POST, 'CRU_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $CRU_TYPE_ACTION = filter_input(INPUT_POST, 'CRU_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $CRU_ON_ACTION = filter_input(INPUT_POST, 'CRU_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $CRU_DUE_DATE = filter_input(INPUT_POST, 'CRU_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $CRU_IMP_DATE = filter_input(INPUT_POST, 'CRU_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $CRU_REVIEW = filter_input(INPUT_POST, 'CRU_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $CRU_OWNER = filter_input(INPUT_POST, 'CRU_OWNER', FILTER_SANITIZE_SPECIAL_CHARS);    

    $PCI_SUM_ACTION = filter_input(INPUT_POST, 'PCI_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $PCI_TYPE_ACTION = filter_input(INPUT_POST, 'PCI_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $PCI_ON_ACTION = filter_input(INPUT_POST, 'PCI_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $PCI_DUE_DATE = filter_input(INPUT_POST, 'PCI_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $PCI_IMP_DATE = filter_input(INPUT_POST, 'PCI_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $PCI_REVIEW = filter_input(INPUT_POST, 'PCI_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $PCI_OWNER = filter_input(INPUT_POST, 'PCI_OWNER', FILTER_SANITIZE_SPECIAL_CHARS); 
    
    $AS_SUM_ACTION = filter_input(INPUT_POST, 'AS_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $AS_TYPE_ACTION = filter_input(INPUT_POST, 'AS_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $AS_ON_ACTION = filter_input(INPUT_POST, 'AS_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $AS_DUE_DATE = filter_input(INPUT_POST, 'AS_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $AS_IMP_DATE = filter_input(INPUT_POST, 'AS_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $AS_REVIEW = filter_input(INPUT_POST, 'AS_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $AS_OWNER = filter_input(INPUT_POST, 'AS_OWNER', FILTER_SANITIZE_SPECIAL_CHARS); 
    
    $RFA_SUM_ACTION = filter_input(INPUT_POST, 'RFA_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $RFA_TYPE_ACTION = filter_input(INPUT_POST, 'RFA_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $RFA_ON_ACTION = filter_input(INPUT_POST, 'RFA_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $RFA_DUE_DATE = filter_input(INPUT_POST, 'RFA_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $RFA_IMP_DATE = filter_input(INPUT_POST, 'RFA_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $RFA_REVIEW = filter_input(INPUT_POST, 'RFA_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $RFA_OWNER = filter_input(INPUT_POST, 'RFA_OWNER', FILTER_SANITIZE_SPECIAL_CHARS);   
    
    $MMC_SUM_ACTION = filter_input(INPUT_POST, 'MMC_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $MMC_TYPE_ACTION = filter_input(INPUT_POST, 'MMC_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $MMC_ON_ACTION = filter_input(INPUT_POST, 'MMC_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $MMC_DUE_DATE = filter_input(INPUT_POST, 'MMC_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $MMC_IMP_DATE = filter_input(INPUT_POST, 'MMC_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $MMC_REVIEW = filter_input(INPUT_POST, 'MMC_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $MMC_OWNER = filter_input(INPUT_POST, 'MMC_OWNER', FILTER_SANITIZE_SPECIAL_CHARS);       
    
    $AR_SUM_ACTION = filter_input(INPUT_POST, 'AR_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $AR_TYPE_ACTION = filter_input(INPUT_POST, 'AR_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $AR_ON_ACTION = filter_input(INPUT_POST, 'AR_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $AR_DUE_DATE = filter_input(INPUT_POST, 'AR_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $AR_IMP_DATE = filter_input(INPUT_POST, 'AR_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $AR_REVIEW = filter_input(INPUT_POST, 'AR_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $AR_OWNER = filter_input(INPUT_POST, 'AR_OWNER', FILTER_SANITIZE_SPECIAL_CHARS);        
    
    $TAC_SUM_ACTION = filter_input(INPUT_POST, 'TAC_SUM_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $TAC_TYPE_ACTION = filter_input(INPUT_POST, 'TAC_TYPE_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $TAC_ON_ACTION = filter_input(INPUT_POST, 'TAC_ON_ACTION', FILTER_SANITIZE_SPECIAL_CHARS);
    $TAC_DUE_DATE = filter_input(INPUT_POST, 'TAC_DUE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $TAC_IMP_DATE = filter_input(INPUT_POST, 'TAC_IMP_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $TAC_REVIEW = filter_input(INPUT_POST, 'TAC_REVIEW', FILTER_SANITIZE_SPECIAL_CHARS);
    $TAC_OWNER = filter_input(INPUT_POST, 'TAC_OWNER', FILTER_SANITIZE_SPECIAL_CHARS);     
    
                 $DUPE_CHK = $pdo->prepare("SELECT car_remedial_action_1_id_fk FROM car_remedial_action_1 WHERE car_remedial_action_1_id_fk=:FK");
$DUPE_CHK->bindParam(':FK',$AGENCY_ENTITY_ID, PDO::PARAM_INT);
$DUPE_CHK->execute(); 
  $row=$DUPE_CHK->fetch(PDO::FETCH_ASSOC);
     if ($DUPE_CHK->rowCount()>=1) {  
    
            $UPDATE4 = $pdo->prepare("UPDATE car_remedial_action_1
    SET
    car_remedial_action_1_tps_srar=:TPS1,
     car_remedial_action_1_tps_tra=:TPS2,
     car_remedial_action_1_tps_oa=:TPS3, 
     car_remedial_action_1_tps_dd=:TPS4,
     car_remedial_action_1_tps_id=:TPS5,
     car_remedial_action_1_tps_rd=:TPS6,
     car_remedial_action_1_tps_owner=:TPS7,
     car_remedial_action_1_du_srar=:DU1, 
     car_remedial_action_1_du_tra=:DU2, 
     car_remedial_action_1_du_oa=:DU3, 
     car_remedial_action_1_du_dd=:DU4, 
     car_remedial_action_1_du_id=:DU5, 
     car_remedial_action_1_du_rd=:DU6, 
     car_remedial_action_1_du_owner=:DU7, 
     car_remedial_action_1_dprk_srar=:DPRK1, 
     car_remedial_action_1_dprk_tra=:DPRK2, 
     car_remedial_action_1_dprk_oa=:DPRK3, 
     car_remedial_action_1_dprk_dd=:DPRK4, 
     car_remedial_action_1_dprk_id=:DPRK5, 
     car_remedial_action_1_dprk_rd=:DPRK6, 
     car_remedial_action_1_dprk_owner=:DPRK7, 
     car_remedial_action_1_sc_srar=:SC1, 
     car_remedial_action_1_sc_tra=:SC2, 
     car_remedial_action_1_sc_oa=:SC3, 
     car_remedial_action_1_sc_dd=:SC4, 
     car_remedial_action_1_sc_id=:SC5, 
     car_remedial_action_1_sc_rd=:SC6, 
     car_remedial_action_1_sc_owner=:SC7,
     car_remedial_action_1_ch_srar=:CH1, 
     car_remedial_action_1_ch_tra=:CH2, 
     car_remedial_action_1_ch_oa=:CH3, 
     car_remedial_action_1_ch_dd=:CH4, 
     car_remedial_action_1_ch_id=:CH5, 
     car_remedial_action_1_ch_rd=:CH6, 
     car_remedial_action_1_ch_owner=:CH7
    WHERE
    car_remedial_action_1_id_fk=:FK");
            $UPDATE4->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
            $UPDATE4->bindParam(':TPS1', $TPS_SUM_ACTION, PDO::PARAM_STR);
            $UPDATE4->bindParam(':TPS2', $TPS_TYPE_ACTION, PDO::PARAM_STR);
            $UPDATE4->bindParam(':TPS3', $TPS_ON_ACTION, PDO::PARAM_STR);
            $UPDATE4->bindParam(':TPS4', $TPS_DUE_DATE, PDO::PARAM_STR);
            $UPDATE4->bindParam(':TPS5', $TPS_IMP_DATE, PDO::PARAM_STR);
            $UPDATE4->bindParam(':TPS6', $TPS_REVIEW, PDO::PARAM_STR);
            $UPDATE4->bindParam(':TPS7', $TPS_OWNER, PDO::PARAM_STR);
            $UPDATE4->bindParam(':DU1', $DU_SUM_ACTION, PDO::PARAM_STR);
            $UPDATE4->bindParam(':DU2', $DU_TYPE_ACTION, PDO::PARAM_STR);
            $UPDATE4->bindParam(':DU3', $DU_ON_ACTION, PDO::PARAM_STR);
            $UPDATE4->bindParam(':DU4', $DU_DUE_DATE, PDO::PARAM_STR);
            $UPDATE4->bindParam(':DU5', $DU_IMP_DATE, PDO::PARAM_STR);
            $UPDATE4->bindParam(':DU6', $DU_REVIEW, PDO::PARAM_STR);
            $UPDATE4->bindParam(':DU7', $DU_OWNER, PDO::PARAM_STR);
            $UPDATE4->bindParam(':DPRK1', $DPRK_SUM_ACTION, PDO::PARAM_STR);      
            $UPDATE4->bindParam(':DPRK2', $DPRK_TYPE_ACTION, PDO::PARAM_STR); 
            $UPDATE4->bindParam(':DPRK3', $DPRK_ON_ACTION, PDO::PARAM_STR); 
            $UPDATE4->bindParam(':DPRK4', $DPRK_DUE_DATE, PDO::PARAM_STR); 
            $UPDATE4->bindParam(':DPRK5', $DPRK_IMP_DATE, PDO::PARAM_STR); 
            $UPDATE4->bindParam(':DPRK6', $DPRK_REVIEW, PDO::PARAM_STR); 
            $UPDATE4->bindParam(':DPRK7', $DPRK_OWNER, PDO::PARAM_STR);   
            $UPDATE4->bindParam(':SC1', $SAC_SUM_ACTION, PDO::PARAM_STR);
            $UPDATE4->bindParam(':SC2', $SAC_TYPE_ACTION, PDO::PARAM_STR);   
            $UPDATE4->bindParam(':SC3', $SAC_ON_ACTION, PDO::PARAM_STR);   
            $UPDATE4->bindParam(':SC4', $SAC_DUE_DATE, PDO::PARAM_STR);   
            $UPDATE4->bindParam(':SC5', $SAC_IMP_DATE, PDO::PARAM_STR);   
            $UPDATE4->bindParam(':SC6', $SAC_REVIEW, PDO::PARAM_STR);   
            $UPDATE4->bindParam(':SC7', $SAC_OWNER, PDO::PARAM_STR); 
            $UPDATE4->bindParam(':CH1', $CH_SUM_ACTION, PDO::PARAM_STR);   
            $UPDATE4->bindParam(':CH2', $CH_TYPE_ACTION, PDO::PARAM_STR);
            $UPDATE4->bindParam(':CH3', $CH_ON_ACTION, PDO::PARAM_STR);
            $UPDATE4->bindParam(':CH4', $CH_DUE_DATE, PDO::PARAM_STR);
            $UPDATE4->bindParam(':CH5', $CH_IMP_DATE, PDO::PARAM_STR);
            $UPDATE4->bindParam(':CH6', $CH_REVIEW, PDO::PARAM_STR);
            $UPDATE4->bindParam(':CH7', $CH_OWNER, PDO::PARAM_STR);        
            $UPDATE4->execute();      



            $UPDATE5 = $pdo->prepare("UPDATE car_remedial_action_2
    SET
    car_remedial_action_2_vc_srar=:VC1,
     car_remedial_action_2_vc_tra=:VC2,
     car_remedial_action_2_vc_oa=:VC3, 
     car_remedial_action_2_vc_dd=:VC4,
     car_remedial_action_2_vc_id=:VC5,
     car_remedial_action_2_vc_rd=:VC6,
     car_remedial_action_2_vc_owner=:VC7,
     car_remedial_action_2_cru_srar=:CRU1, 
     car_remedial_action_2_cru_tra=:CRU2, 
     car_remedial_action_2_cru_oa=:CRU3, 
     car_remedial_action_2_cru_dd=:CRU4, 
     car_remedial_action_2_cru_id=:CRU5, 
     car_remedial_action_2_cru_rd=:CRU6, 
     car_remedial_action_2_cru_owner=:CRU7, 
     car_remedial_action_2_pci_srar=:PCI1, 
     car_remedial_action_2_pci_tra=:PCI2, 
     car_remedial_action_2_pci_oa=:PCI3, 
     car_remedial_action_2_pci_dd=:PCI4, 
     car_remedial_action_2_pci_id=:PCI5, 
     car_remedial_action_2_pci_rd=:PCI6, 
     car_remedial_action_2_pci_owner=:PCI7, 
     car_remedial_action_2_as_srar=:AS1, 
     car_remedial_action_2_as_tra=:AS2, 
     car_remedial_action_2_as_oa=:AS3, 
     car_remedial_action_2_as_dd=:AS4, 
     car_remedial_action_2_as_id=:AS5, 
     car_remedial_action_2_as_rd=:AS6, 
     car_remedial_action_2_as_owner=:AS7,
     car_remedial_action_2_rfa_srar=:RFA1, 
     car_remedial_action_2_rfa_tra=:RFA2, 
     car_remedial_action_2_rfa_oa=:RFA3, 
     car_remedial_action_2_rfa_dd=:RFA4, 
     car_remedial_action_2_rfa_id=:RFA5, 
     car_remedial_action_2_rfa_rd=:RFA6, 
     car_remedial_action_2_rfa_owner=:RFA7
    WHERE
    car_remedial_action_2_id_fk=:FK");
            $UPDATE5->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
            $UPDATE5->bindParam(':VC1', $VC_SUM_ACTION, PDO::PARAM_STR);
            $UPDATE5->bindParam(':VC2', $VC_TYPE_ACTION, PDO::PARAM_STR);
            $UPDATE5->bindParam(':VC3', $VC_ON_ACTION, PDO::PARAM_STR);
            $UPDATE5->bindParam(':VC4', $VC_DUE_DATE, PDO::PARAM_STR);
            $UPDATE5->bindParam(':VC5', $VC_IMP_DATE, PDO::PARAM_STR);
            $UPDATE5->bindParam(':VC6', $VC_REVIEW, PDO::PARAM_STR);
            $UPDATE5->bindParam(':VC7', $VC_OWNER, PDO::PARAM_STR);
            $UPDATE5->bindParam(':CRU1', $CRU_SUM_ACTION, PDO::PARAM_STR);
            $UPDATE5->bindParam(':CRU2', $CRU_TYPE_ACTION, PDO::PARAM_STR);
            $UPDATE5->bindParam(':CRU3', $CRU_ON_ACTION, PDO::PARAM_STR);
            $UPDATE5->bindParam(':CRU4', $CRU_DUE_DATE, PDO::PARAM_STR);
            $UPDATE5->bindParam(':CRU5', $CRU_IMP_DATE, PDO::PARAM_STR);
            $UPDATE5->bindParam(':CRU6', $CRU_REVIEW, PDO::PARAM_STR);
            $UPDATE5->bindParam(':CRU7', $CRU_OWNER, PDO::PARAM_STR);
            $UPDATE5->bindParam(':PCI1', $PCI_SUM_ACTION, PDO::PARAM_STR);      
            $UPDATE5->bindParam(':PCI2', $PCI_TYPE_ACTION, PDO::PARAM_STR); 
            $UPDATE5->bindParam(':PCI3', $PCI_ON_ACTION, PDO::PARAM_STR); 
            $UPDATE5->bindParam(':PCI4', $PCI_DUE_DATE, PDO::PARAM_STR); 
            $UPDATE5->bindParam(':PCI5', $PCI_IMP_DATE, PDO::PARAM_STR); 
            $UPDATE5->bindParam(':PCI6', $PCI_REVIEW, PDO::PARAM_STR); 
            $UPDATE5->bindParam(':PCI7', $PCI_OWNER, PDO::PARAM_STR);   
            $UPDATE5->bindParam(':AS1', $AS_SUM_ACTION, PDO::PARAM_STR);
            $UPDATE5->bindParam(':AS2', $AS_TYPE_ACTION, PDO::PARAM_STR);   
            $UPDATE5->bindParam(':AS3', $AS_ON_ACTION, PDO::PARAM_STR);   
            $UPDATE5->bindParam(':AS4', $AS_DUE_DATE, PDO::PARAM_STR);   
            $UPDATE5->bindParam(':AS5', $AS_IMP_DATE, PDO::PARAM_STR);   
            $UPDATE5->bindParam(':AS6', $AS_REVIEW, PDO::PARAM_STR);   
            $UPDATE5->bindParam(':AS7', $AS_OWNER, PDO::PARAM_STR); 
            $UPDATE5->bindParam(':RFA1', $RFA_SUM_ACTION, PDO::PARAM_STR);   
            $UPDATE5->bindParam(':RFA2', $RFA_TYPE_ACTION, PDO::PARAM_STR);
            $UPDATE5->bindParam(':RFA3', $RFA_ON_ACTION, PDO::PARAM_STR);
            $UPDATE5->bindParam(':RFA4', $RFA_DUE_DATE, PDO::PARAM_STR);
            $UPDATE5->bindParam(':RFA5', $RFA_IMP_DATE, PDO::PARAM_STR);
            $UPDATE5->bindParam(':RFA6', $RFA_REVIEW, PDO::PARAM_STR);
            $UPDATE5->bindParam(':RFA7', $RFA_OWNER, PDO::PARAM_STR);        
            $UPDATE5->execute();       

            $UPDATE6 = $pdo->prepare("UPDATE car_remedial_action_3
    SET
    car_remedial_action_3_mmc_srar=:MMC1,
     car_remedial_action_3_mmc_tra=:MMC2,
     car_remedial_action_3_mmc_oa=:MMC3, 
     car_remedial_action_3_mmc_dd=:MMC4,
     car_remedial_action_3_mmc_id=:MMC5,
     car_remedial_action_3_mmc_rd=:MMC6,
     car_remedial_action_3_mmc_owner=:MMC7,
     car_remedial_action_3_ar_srar=:AR1, 
     car_remedial_action_3_ar_tra=:AR2, 
     car_remedial_action_3_ar_oa=:AR3, 
     car_remedial_action_3_ar_dd=:AR4, 
     car_remedial_action_3_ar_id=:AR5, 
     car_remedial_action_3_ar_rd=:AR6, 
     car_remedial_action_3_ar_owner=:AR7, 
     car_remedial_action_3_tc_srar=:TC1, 
     car_remedial_action_3_tc_tra=:TC2, 
     car_remedial_action_3_tc_oa=:TC3, 
     car_remedial_action_3_tc_dd=:TC4, 
     car_remedial_action_3_tc_id=:TC5, 
     car_remedial_action_3_tc_rd=:TC6, 
     car_remedial_action_3_tc_owner=:TC7
    WHERE
    car_remedial_action_3_id_fk=:FK");
            $UPDATE6->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
            $UPDATE6->bindParam(':MMC1', $MMC_SUM_ACTION, PDO::PARAM_STR);
            $UPDATE6->bindParam(':MMC2', $MMC_TYPE_ACTION, PDO::PARAM_STR);
            $UPDATE6->bindParam(':MMC3', $MMC_ON_ACTION, PDO::PARAM_STR);
            $UPDATE6->bindParam(':MMC4', $MMC_DUE_DATE, PDO::PARAM_STR);
            $UPDATE6->bindParam(':MMC5', $MMC_IMP_DATE, PDO::PARAM_STR);
            $UPDATE6->bindParam(':MMC6', $MMC_REVIEW, PDO::PARAM_STR);
            $UPDATE6->bindParam(':MMC7', $MMC_OWNER, PDO::PARAM_STR);
            $UPDATE6->bindParam(':AR1', $AR_SUM_ACTION, PDO::PARAM_STR);
            $UPDATE6->bindParam(':AR2', $AR_TYPE_ACTION, PDO::PARAM_STR);
            $UPDATE6->bindParam(':AR3', $AR_ON_ACTION, PDO::PARAM_STR);
            $UPDATE6->bindParam(':AR4', $AR_DUE_DATE, PDO::PARAM_STR);
            $UPDATE6->bindParam(':AR5', $AR_IMP_DATE, PDO::PARAM_STR);
            $UPDATE6->bindParam(':AR6', $AR_REVIEW, PDO::PARAM_STR);
            $UPDATE6->bindParam(':AR7', $AR_OWNER, PDO::PARAM_STR);
            $UPDATE6->bindParam(':TC1', $TAC_SUM_ACTION, PDO::PARAM_STR);      
            $UPDATE6->bindParam(':TC2', $TAC_TYPE_ACTION, PDO::PARAM_STR); 
            $UPDATE6->bindParam(':TC3', $TAC_ON_ACTION, PDO::PARAM_STR); 
            $UPDATE6->bindParam(':TC4', $TAC_DUE_DATE, PDO::PARAM_STR); 
            $UPDATE6->bindParam(':TC5', $TAC_IMP_DATE, PDO::PARAM_STR); 
            $UPDATE6->bindParam(':TC6', $TAC_REVIEW, PDO::PARAM_STR); 
            $UPDATE6->bindParam(':TC7', $TAC_OWNER, PDO::PARAM_STR);          
            $UPDATE6->execute();  

     }
     
        else {
            
  $INSERT4 = $pdo->prepare("INSERT INTO car_remedial_action_1
SET
car_remedial_action_1_tps_srar=:TPS1,
 car_remedial_action_1_tps_tra=:TPS2,
 car_remedial_action_1_tps_oa=:TPS3, 
 car_remedial_action_1_tps_dd=:TPS4,
 car_remedial_action_1_tps_id=:TPS5,
 car_remedial_action_1_tps_rd=:TPS6,
 car_remedial_action_1_tps_owner=:TPS7,
 car_remedial_action_1_du_srar=:DU1, 
 car_remedial_action_1_du_tra=:DU2, 
 car_remedial_action_1_du_oa=:DU3, 
 car_remedial_action_1_du_dd=:DU4, 
 car_remedial_action_1_du_id=:DU5, 
 car_remedial_action_1_du_rd=:DU6, 
 car_remedial_action_1_du_owner=:DU7, 
 car_remedial_action_1_dprk_srar=:DPRK1, 
 car_remedial_action_1_dprk_tra=:DPRK2, 
 car_remedial_action_1_dprk_oa=:DPRK3, 
 car_remedial_action_1_dprk_dd=:DPRK4, 
 car_remedial_action_1_dprk_id=:DPRK5, 
 car_remedial_action_1_dprk_rd=:DPRK6, 
 car_remedial_action_1_dprk_owner=:DPRK7, 
 car_remedial_action_1_sc_srar=:SC1, 
 car_remedial_action_1_sc_tra=:SC2, 
 car_remedial_action_1_sc_oa=:SC3, 
 car_remedial_action_1_sc_dd=:SC4, 
 car_remedial_action_1_sc_id=:SC5, 
 car_remedial_action_1_sc_rd=:SC6, 
 car_remedial_action_1_sc_owner=:SC7,
 car_remedial_action_1_ch_srar=:CH1, 
 car_remedial_action_1_ch_tra=:CH2, 
 car_remedial_action_1_ch_oa=:CH3, 
 car_remedial_action_1_ch_dd=:CH4, 
 car_remedial_action_1_ch_id=:CH5, 
 car_remedial_action_1_ch_rd=:CH6, 
 car_remedial_action_1_ch_owner=:CH7,
car_remedial_action_1_id_fk=:FK");
        $INSERT4->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
        $INSERT4->bindParam(':TPS1', $TPS_SUM_ACTION, PDO::PARAM_STR);
        $INSERT4->bindParam(':TPS2', $TPS_TYPE_ACTION, PDO::PARAM_STR);
        $INSERT4->bindParam(':TPS3', $TPS_ON_ACTION, PDO::PARAM_STR);
        $INSERT4->bindParam(':TPS4', $TPS_DUE_DATE, PDO::PARAM_STR);
        $INSERT4->bindParam(':TPS5', $TPS_IMP_DATE, PDO::PARAM_STR);
        $INSERT4->bindParam(':TPS6', $TPS_REVIEW, PDO::PARAM_STR);
        $INSERT4->bindParam(':TPS7', $TPS_OWNER, PDO::PARAM_STR);
        $INSERT4->bindParam(':DU1', $DU_SUM_ACTION, PDO::PARAM_STR);
        $INSERT4->bindParam(':DU2', $DU_TYPE_ACTION, PDO::PARAM_STR);
        $INSERT4->bindParam(':DU3', $DU_ON_ACTION, PDO::PARAM_STR);
        $INSERT4->bindParam(':DU4', $DU_DUE_DATE, PDO::PARAM_STR);
        $INSERT4->bindParam(':DU5', $DU_IMP_DATE, PDO::PARAM_STR);
        $INSERT4->bindParam(':DU6', $DU_REVIEW, PDO::PARAM_STR);
        $INSERT4->bindParam(':DU7', $DU_OWNER, PDO::PARAM_STR);
        $INSERT4->bindParam(':DPRK1', $DPRK_SUM_ACTION, PDO::PARAM_STR);      
        $INSERT4->bindParam(':DPRK2', $DPRK_TYPE_ACTION, PDO::PARAM_STR); 
        $INSERT4->bindParam(':DPRK3', $DPRK_ON_ACTION, PDO::PARAM_STR); 
        $INSERT4->bindParam(':DPRK4', $DPRK_DUE_DATE, PDO::PARAM_STR); 
        $INSERT4->bindParam(':DPRK5', $DPRK_IMP_DATE, PDO::PARAM_STR); 
        $INSERT4->bindParam(':DPRK6', $DPRK_REVIEW, PDO::PARAM_STR); 
        $INSERT4->bindParam(':DPRK7', $DPRK_OWNER, PDO::PARAM_STR);   
        $INSERT4->bindParam(':SC1', $SAC_SUM_ACTION, PDO::PARAM_STR);
        $INSERT4->bindParam(':SC2', $SAC_TYPE_ACTION, PDO::PARAM_STR);   
        $INSERT4->bindParam(':SC3', $SAC_ON_ACTION, PDO::PARAM_STR);   
        $INSERT4->bindParam(':SC4', $SAC_DUE_DATE, PDO::PARAM_STR);   
        $INSERT4->bindParam(':SC5', $SAC_IMP_DATE, PDO::PARAM_STR);   
        $INSERT4->bindParam(':SC6', $SAC_REVIEW, PDO::PARAM_STR);   
        $INSERT4->bindParam(':SC7', $SAC_OWNER, PDO::PARAM_STR); 
        $INSERT4->bindParam(':CH1', $CH_SUM_ACTION, PDO::PARAM_STR);   
        $INSERT4->bindParam(':CH2', $CH_TYPE_ACTION, PDO::PARAM_STR);
        $INSERT4->bindParam(':CH3', $CH_ON_ACTION, PDO::PARAM_STR);
        $INSERT4->bindParam(':CH4', $CH_DUE_DATE, PDO::PARAM_STR);
        $INSERT4->bindParam(':CH5', $CH_IMP_DATE, PDO::PARAM_STR);
        $INSERT4->bindParam(':CH6', $CH_REVIEW, PDO::PARAM_STR);
        $INSERT4->bindParam(':CH7', $CH_OWNER, PDO::PARAM_STR);        
        $INSERT4->execute();      


    
        $INSERT5 = $pdo->prepare("INSERT INTO car_remedial_action_2
SET
car_remedial_action_2_vc_srar=:VC1,
 car_remedial_action_2_vc_tra=:VC2,
 car_remedial_action_2_vc_oa=:VC3, 
 car_remedial_action_2_vc_dd=:VC4,
 car_remedial_action_2_vc_id=:VC5,
 car_remedial_action_2_vc_rd=:VC6,
 car_remedial_action_2_vc_owner=:VC7,
 car_remedial_action_2_cru_srar=:CRU1, 
 car_remedial_action_2_cru_tra=:CRU2, 
 car_remedial_action_2_cru_oa=:CRU3, 
 car_remedial_action_2_cru_dd=:CRU4, 
 car_remedial_action_2_cru_id=:CRU5, 
 car_remedial_action_2_cru_rd=:CRU6, 
 car_remedial_action_2_cru_owner=:CRU7, 
 car_remedial_action_2_pci_srar=:PCI1, 
 car_remedial_action_2_pci_tra=:PCI2, 
 car_remedial_action_2_pci_oa=:PCI3, 
 car_remedial_action_2_pci_dd=:PCI4, 
 car_remedial_action_2_pci_id=:PCI5, 
 car_remedial_action_2_pci_rd=:PCI6, 
 car_remedial_action_2_pci_owner=:PCI7, 
 car_remedial_action_2_as_srar=:AS1, 
 car_remedial_action_2_as_tra=:AS2, 
 car_remedial_action_2_as_oa=:AS3, 
 car_remedial_action_2_as_dd=:AS4, 
 car_remedial_action_2_as_id=:AS5, 
 car_remedial_action_2_as_rd=:AS6, 
 car_remedial_action_2_as_owner=:AS7,
 car_remedial_action_2_rfa_srar=:RFA1, 
 car_remedial_action_2_rfa_tra=:RFA2, 
 car_remedial_action_2_rfa_oa=:RFA3, 
 car_remedial_action_2_rfa_dd=:RFA4, 
 car_remedial_action_2_rfa_id=:RFA5, 
 car_remedial_action_2_rfa_rd=:RFA6, 
 car_remedial_action_2_rfa_owner=:RFA7,
car_remedial_action_2_id_fk=:FK");
        $INSERT5->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
        $INSERT5->bindParam(':VC1', $VC_SUM_ACTION, PDO::PARAM_STR);
        $INSERT5->bindParam(':VC2', $VC_TYPE_ACTION, PDO::PARAM_STR);
        $INSERT5->bindParam(':VC3', $VC_ON_ACTION, PDO::PARAM_STR);
        $INSERT5->bindParam(':VC4', $VC_DUE_DATE, PDO::PARAM_STR);
        $INSERT5->bindParam(':VC5', $VC_IMP_DATE, PDO::PARAM_STR);
        $INSERT5->bindParam(':VC6', $VC_REVIEW, PDO::PARAM_STR);
        $INSERT5->bindParam(':VC7', $VC_OWNER, PDO::PARAM_STR);
        $INSERT5->bindParam(':CRU1', $CRU_SUM_ACTION, PDO::PARAM_STR);
        $INSERT5->bindParam(':CRU2', $CRU_TYPE_ACTION, PDO::PARAM_STR);
        $INSERT5->bindParam(':CRU3', $CRU_ON_ACTION, PDO::PARAM_STR);
        $INSERT5->bindParam(':CRU4', $CRU_DUE_DATE, PDO::PARAM_STR);
        $INSERT5->bindParam(':CRU5', $CRU_IMP_DATE, PDO::PARAM_STR);
        $INSERT5->bindParam(':CRU6', $CRU_REVIEW, PDO::PARAM_STR);
        $INSERT5->bindParam(':CRU7', $CRU_OWNER, PDO::PARAM_STR);
        $INSERT5->bindParam(':PCI1', $PCI_SUM_ACTION, PDO::PARAM_STR);      
        $INSERT5->bindParam(':PCI2', $PCI_TYPE_ACTION, PDO::PARAM_STR); 
        $INSERT5->bindParam(':PCI3', $PCI_ON_ACTION, PDO::PARAM_STR); 
        $INSERT5->bindParam(':PCI4', $PCI_DUE_DATE, PDO::PARAM_STR); 
        $INSERT5->bindParam(':PCI5', $PCI_IMP_DATE, PDO::PARAM_STR); 
        $INSERT5->bindParam(':PCI6', $PCI_REVIEW, PDO::PARAM_STR); 
        $INSERT5->bindParam(':PCI7', $PCI_OWNER, PDO::PARAM_STR);   
        $INSERT5->bindParam(':AS1', $AS_SUM_ACTION, PDO::PARAM_STR);
        $INSERT5->bindParam(':AS2', $AS_TYPE_ACTION, PDO::PARAM_STR);   
        $INSERT5->bindParam(':AS3', $AS_ON_ACTION, PDO::PARAM_STR);   
        $INSERT5->bindParam(':AS4', $AS_DUE_DATE, PDO::PARAM_STR);   
        $INSERT5->bindParam(':AS5', $AS_IMP_DATE, PDO::PARAM_STR);   
        $INSERT5->bindParam(':AS6', $AS_REVIEW, PDO::PARAM_STR);   
        $INSERT5->bindParam(':AS7', $AS_OWNER, PDO::PARAM_STR); 
        $INSERT5->bindParam(':RFA1', $RFA_SUM_ACTION, PDO::PARAM_STR);   
        $INSERT5->bindParam(':RFA2', $RFA_TYPE_ACTION, PDO::PARAM_STR);
        $INSERT5->bindParam(':RFA3', $RFA_ON_ACTION, PDO::PARAM_STR);
        $INSERT5->bindParam(':RFA4', $RFA_DUE_DATE, PDO::PARAM_STR);
        $INSERT5->bindParam(':RFA5', $RFA_IMP_DATE, PDO::PARAM_STR);
        $INSERT5->bindParam(':RFA6', $RFA_REVIEW, PDO::PARAM_STR);
        $INSERT5->bindParam(':RFA7', $RFA_OWNER, PDO::PARAM_STR);        
        $INSERT5->execute();       
    
        $INSERT6 = $pdo->prepare("INSERT INTO car_remedial_action_3
SET
car_remedial_action_3_mmc_srar=:MMC1,
 car_remedial_action_3_mmc_tra=:MMC2,
 car_remedial_action_3_mmc_oa=:MMC3, 
 car_remedial_action_3_mmc_dd=:MMC4,
 car_remedial_action_3_mmc_id=:MMC5,
 car_remedial_action_3_mmc_rd=:MMC6,
 car_remedial_action_3_mmc_owner=:MMC7,
 car_remedial_action_3_ar_srar=:AR1, 
 car_remedial_action_3_ar_tra=:AR2, 
 car_remedial_action_3_ar_oa=:AR3, 
 car_remedial_action_3_ar_dd=:AR4, 
 car_remedial_action_3_ar_id=:AR5, 
 car_remedial_action_3_ar_rd=:AR6, 
 car_remedial_action_3_ar_owner=:AR7, 
 car_remedial_action_3_tc_srar=:TC1, 
 car_remedial_action_3_tc_tra=:TC2, 
 car_remedial_action_3_tc_oa=:TC3, 
 car_remedial_action_3_tc_dd=:TC4, 
 car_remedial_action_3_tc_id=:TC5, 
 car_remedial_action_3_tc_rd=:TC6, 
 car_remedial_action_3_tc_owner=:TC7, 
car_remedial_action_3_id_fk=:FK");
        $INSERT6->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_STR);
        $INSERT6->bindParam(':MMC1', $MMC_SUM_ACTION, PDO::PARAM_STR);
        $INSERT6->bindParam(':MMC2', $MMC_TYPE_ACTION, PDO::PARAM_STR);
        $INSERT6->bindParam(':MMC3', $MMC_ON_ACTION, PDO::PARAM_STR);
        $INSERT6->bindParam(':MMC4', $MMC_DUE_DATE, PDO::PARAM_STR);
        $INSERT6->bindParam(':MMC5', $MMC_IMP_DATE, PDO::PARAM_STR);
        $INSERT6->bindParam(':MMC6', $MMC_REVIEW, PDO::PARAM_STR);
        $INSERT6->bindParam(':MMC7', $MMC_OWNER, PDO::PARAM_STR);
        $INSERT6->bindParam(':AR1', $AR_SUM_ACTION, PDO::PARAM_STR);
        $INSERT6->bindParam(':AR2', $AR_TYPE_ACTION, PDO::PARAM_STR);
        $INSERT6->bindParam(':AR3', $AR_ON_ACTION, PDO::PARAM_STR);
        $INSERT6->bindParam(':AR4', $AR_DUE_DATE, PDO::PARAM_STR);
        $INSERT6->bindParam(':AR5', $AR_IMP_DATE, PDO::PARAM_STR);
        $INSERT6->bindParam(':AR6', $AR_REVIEW, PDO::PARAM_STR);
        $INSERT6->bindParam(':AR7', $AR_OWNER, PDO::PARAM_STR);
        $INSERT6->bindParam(':TC1', $TAC_SUM_ACTION, PDO::PARAM_STR);      
        $INSERT6->bindParam(':TC2', $TAC_TYPE_ACTION, PDO::PARAM_STR); 
        $INSERT6->bindParam(':TC3', $TAC_ON_ACTION, PDO::PARAM_STR); 
        $INSERT6->bindParam(':TC4', $TAC_DUE_DATE, PDO::PARAM_STR); 
        $INSERT6->bindParam(':TC5', $TAC_IMP_DATE, PDO::PARAM_STR); 
        $INSERT6->bindParam(':TC6', $TAC_REVIEW, PDO::PARAM_STR); 
        $INSERT6->bindParam(':TC7', $TAC_OWNER, PDO::PARAM_STR);          
        $INSERT6->execute();  
                
            
        }
     header('Location: ../CAR.php?RETURN=UPDATED&AGENCY='.$AGENCY); die; 
    }

}

?>