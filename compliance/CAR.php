<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$Level_2_Access = array("Jade");

if (in_array($hello_name, $Level_2_Access, true)) {

    header('Location: ../Life/Financial_Menu.php');
    die;
}

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_1_Access, true)) {

    header('Location: /index.php?AccessDenied');
    die;
}

        
        $COMID = filter_input(INPUT_GET, 'COMID', FILTER_SANITIZE_NUMBER_INT);
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL | Compliance Audit and Review</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
                <link rel="stylesheet" href="/styles/Notices.css">
        <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
       <link rel="stylesheet" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/../includes/NAV.php'); ?> 

    <div class="container-fluid"><br>

        
                <div class="row">
            <?php require_once(__DIR__ . '/includes/LeftSide.html'); ?> 
            
            <div class="col-9">
        
<div class="card"">
<h3 class="card-header">
Compliance Audit and Review
</h3>
<div class="card-block">
    
    
    <ul class="nav nav-tabs nav-justified" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Business Overview</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Risk Overview</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#messages" role="tab">Remedial Action</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Glossary</a>
  </li>
</ul>
    <br>
<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="home" role="tabpanel">
  
  
      <h3>Firm Information</h3>
      
      <form method="POST" action="php/CAR.php" class="form-horizontal">
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="LEGAL_ENTITY_NAME" class="col-sm-3 col-form-label">Legal Entity Name:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="LEGAL_ENTITY_NAME" name="LEGAL_ENTITY_NAME">
                    </div>
                </div>
            </div>
 
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="TRADING_NAMES" class="col-sm-3 col-form-label">Trading Names:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="TRADING_NAMES" name="TRADING_NAMES"></textarea>
                    </div>
                </div>
            </div> 
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="PRINCIPAL_FIRM" class="col-sm-3 col-form-label">Principal Firm:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="PRINCIPAL_FIRM" name="PRINCIPAL_FIRM" placeholder="Hayden Williams Independent Financial Services Limit" value="Hayden Williams Independent Financial Services Limit">
                    </div>
                </div>
            </div>       

           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="AUTH_NUMBERS" class="col-sm-3 col-form-label">Authorisation Numbers (FCA/ICO):</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="AUTH_NUMBERS" name="AUTH_NUMBERS"></textarea>
                    </div>
                </div>
            </div>           
          
                     <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="ICO_RENEWAL_DATE" class="col-sm-3 col-form-label">ICO Renewal Date:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="ICO_RENEWAL_DATE" name="ICO_RENEWAL_DATE">
                    </div>
                </div>
            </div> 
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="DIRECTOR_INFO" class="col-sm-3 col-form-label">Principal, Shareholder and Director Information:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="DIRECTOR_INFO" name="DIRECTOR_INFO"></textarea>
                    </div>
                </div>
            </div>        
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="BUSINESS_OVERVIEW" class="col-sm-3 col-form-label">Overview of Business Model:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="BUSINESS_OVERVIEW" name="BUSINESS_OVERVIEW"></textarea>
                    </div>
                </div>
            </div>
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="GOV_STRAT_OVERVIEW" class="col-sm-3 col-form-label">Overview of Governance and Strategy:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="GOV_STRAT_OVERVIEW" name="GOV_STRAT_OVERVIEW"></textarea>
                    </div>
                </div>
            </div>
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="CLIENT_ACQ_OVERVIEW" class="col-sm-3 col-form-label">Overview of Client Acquisition:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="CLIENT_ACQ_OVERVIEW" name="CLIENT_ACQ_OVERVIEW"></textarea>
                    </div>
                </div>
            </div>
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="CLIENT_ENG_OVERVIEW" class="col-sm-3 col-form-label">Overview of Client Engagement:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="CLIENT_ENG_OVERVIEW" name="CLIENT_ENG_OVERVIEW"></textarea>
                    </div>
                </div>
            </div>
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="SER_DEL_OVERVIEW" class="col-sm-3 col-form-label">Overview of Service Delivery:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="SER_DEL_OVERVIEW" name="SER_DEL_OVERVIEW"></textarea>
                    </div>
                </div>
            </div>
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="TRN_COM_OVERVIEW" class="col-sm-3 col-form-label">Overview of Training and Competence:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="TRN_COM_OVERVIEW" name="TRN_COM_OVERVIEW"></textarea>
                    </div>
                </div>
            </div> 

           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="DATA_PRO_ARR_OVERVIEW" class="col-sm-3 col-form-label">Overview of Data Protection Arrangements:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="DATA_PRO_ARR_OVERVIEW" name="DATA_PRO_ARR_OVERVIEW"></textarea>
                    </div>
                </div>
            </div>
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="COMP_HAN_OVERVIEW" class="col-sm-3 col-form-label">Overview of Complaints Handling:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="COMP_HAN_OVERVIEW"></textarea>
                    </div>
                </div>
            </div>            
          
      </form>
   
  </div>
    <div class="tab-pane" id="profile" role="tabpanel">
        
        
<table class="table">
  <thead>
    <tr>
      <th>Rule/Legislation</th>
      <th>Summary of Risk</th>
      <th>Compliance Risk</th>
      <th>Risk Impact</th>
      <th>Risk Score</th>
      <th>Risk Probability</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">TPS screening</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="TPS_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="TPS_COM_RISK" name="TPS_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="TPS_COM_RISK" name="TPS_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="TPS_COM_RISK" name="TPS_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="TPS_COM_RISK" name="TPS_PRO_RISK"></textarea>
      </td>      
    </tr>
    <tr>
      <th scope="row">Due diligence</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="DU_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="DU_COM_RISK" name="DU_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="DU_COM_RISK" name="DU_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="DU_COM_RISK" name="DU_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="DU_COM_RISK" name="DU_PRO_RISK"></textarea>
      </td>  
    </tr>
    <tr>
      <th scope="row">Data protection and recording keeping</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="DPRK_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="DPRK_COM_RISK" name="DPRK_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="DPRK_COM_RISK" name="DPRK_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="DPRK_COM_RISK" name="DPRK_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="DPRK_COM_RISK" name="DPRK_PRO_RISK"></textarea>
      </td>  
    </tr>
    <tr>
      <th scope="row">Systems and controls</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="SAC_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="SAC_COM_RISK" name="SAC_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="SAC_COM_RISK" name="SAC_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="SAC_COM_RISK" name="SAC_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="SAC_COM_RISK" name="SAC_PRO_RISK"></textarea>
      </td>  
    </tr>       
    <tr>
      <th scope="row">Complaints handling</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="CH_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="CH_COM_RISK" name="CH_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="CH_COM_RISK" name="CH_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="CH_COM_RISK" name="CH_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="CH_COM_RISK" name="CH_PRO_RISK"></textarea>
      </td>  
    </tr>    
    <tr>
      <th scope="row">Vulnerable customers</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="VC_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="VC_COM_RISK" name="VC_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="VC_COM_RISK" name="VC_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="VC_COM_RISK" name="VC_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="VC_COM_RISK" name="VC_PRO_RISK"></textarea>
      </td>  
    </tr>
    <tr>
      <th scope="row">Consent relied upon</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="CRU_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="CRU_COM_RISK" name="CRU_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="CRU_COM_RISK" name="CRU_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="CRU_COM_RISK" name="CRU_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="CRU_COM_RISK" name="CRU_PRO_RISK"></textarea>
      </td>  
    </tr>      
    <tr>
      <th scope="row">PCI Compliance</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="PCI_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="PCI_COM_RISK" name="PCI_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="PCI_COM_RISK" name="PCI_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="PCI_COM_RISK" name="PCI_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="PCI_COM_RISK" name="PCI_PRO_RISK"></textarea>
      </td>  
    </tr>
    <tr>
      <th scope="row">Advised sales</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="AS_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="AS_COM_RISK" name="AS_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="AS_COM_RISK" name="AS_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="AS_COM_RISK" name="AS_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="AS_COM_RISK" name="AS_PRO_RISK"></textarea>
      </td>  
    </tr>      
    <tr>
      <th scope="row">Referrals to a Financial Advisor</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="RFA_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="RFA_COM_RISK" name="RFA_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="RFA_COM_RISK" name="RFA_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="RFA_COM_RISK" name="RFA_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="RFA_COM_RISK" name="RFA_PRO_RISK"></textarea>
      </td>  
    </tr>      
    <tr>
      <th scope="row">Misleading marketing content</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="MMC_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="MMC_COM_RISK" name="MMC_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="MMC_COM_RISK" name="MMC_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="MMC_COM_RISK" name="MMC_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="MMC_COM_RISK" name="MMC_PRO_RISK"></textarea>
      </td>  
    </tr>   
    <tr>
      <th scope="row">Adequate Resources</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="AR_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="AR_COM_RISK" name="AR_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="AR_COM_RISK" name="AR_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="AR_COM_RISK" name="AR_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="AR_COM_RISK" name="AR_PRO_RISK"></textarea>
      </td>  
    </tr>
        <tr>
      <th scope="row">Training and competency</th>
      <td>
          <textarea class="form-control" id="COMP_HAN_OVERVIEW" name="TAC_SUM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="TAC_COM_RISK" name="TAC_COM_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="TAC_COM_RISK" name="TAC_IMPACT_RISK"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="TAC_COM_RISK" name="TAC_SCORE_RISK"></textarea>
      </td> 
      <td>
          <textarea class="form-control" id="TAC_COM_RISK" name="TAC_PRO_RISK"></textarea>
      </td>  
    </tr>  
  </tbody>
</table>        
        
        
        
    </div>
    <div class="tab-pane" id="messages" role="tabpanel">
        
<table class="table">
  <thead>
    <tr>
      <th>Risk</th>
      <th>Summary of Remedial Action Required</th>
      <th>Type of Remedial Action</th>
      <th>Ongoing Action</th>
      <th>Due date</th>
      <th>Implementation date</th>
      <th>Review date</th>
      <th>Owner</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">TPS screening</th>
      <td>
          <textarea class="form-control" id="TPS_SUM_ACTION" name="TPS_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="TPS_TYPE_ACTION" name="TPS_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="TPS_ON_ACTION" name="TPS_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="TPS_DUE_DATE" name="TPS_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="TPS_IMP_DATE" name="TPS_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="TPS_REVIEW" name="TPS_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="TPS_OWNER" name="TPS_OWNER"></textarea>
      </td>        
    </tr>
    <tr>
      <th scope="row">Due diligence</th>
      <td>
          <textarea class="form-control" id="DU_SUM_ACTION" name="DU_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="DU_TYPE_ACTION" name="DU_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="DU_ON_ACTION" name="DU_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="DU_DUE_DATE" name="DU_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="DU_IMP_DATE" name="DU_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="DU_REVIEW" name="DU_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="DU_OWNER" name="DU_OWNER"></textarea>
      </td>       
    </tr>
    <tr>
      <th scope="row">Data protection and recording keeping</th>
      <td>
          <textarea class="form-control" id="DPRK_SUM_ACTION" name="DPRK_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="DPRK_TYPE_ACTION" name="DPRK_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="DPRK_ON_ACTION" name="DPRK_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="DPRK_DUE_DATE" name="DPRK_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="DPRK_IMP_DATE" name="DPRK_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="DPRK_REVIEW" name="DPRK_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="DPRK_OWNER" name="DPRK_OWNER"></textarea>
      </td>     
    </tr>
    <tr>
      <th scope="row">Systems and controls</th>
      <td>
          <textarea class="form-control" id="SAC_SUM_ACTION" name="SAC_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="SAC_TYPE_ACTION" name="SAC_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="SAC_ON_ACTION" name="SAC_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="SAC_DUE_DATE" name="SAC_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="SAC_IMP_DATE" name="SAC_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="SAC_REVIEW" name="SAC_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="SAC_OWNER" name="SAC_OWNER"></textarea>
      </td>  
    </tr>       
    <tr>
      <th scope="row">Complaints handling</th>
      <td>
          <textarea class="form-control" id="CH_SUM_ACTION" name="CH_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="CH_TYPE_ACTION" name="CH_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="CH_ON_ACTION" name="CH_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="CH_DUE_DATE" name="CH_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="CH_IMP_DATE" name="CH_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="CH_REVIEW" name="CH_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="CH_OWNER" name="CH_OWNER"></textarea>
      </td>   
    </tr>    
    <tr>
      <th scope="row">Vulnerable customers</th>
      <td>
          <textarea class="form-control" id="VC_SUM_ACTION" name="VC_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="VC_TYPE_ACTION" name="VC_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="VC_ON_ACTION" name="VC_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="VC_DUE_DATE" name="VC_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="VC_IMP_DATE" name="VC_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="VC_REVIEW" name="VC_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="VC_OWNER" name="VC_OWNER"></textarea>
      </td>    
    </tr>
    <tr>
      <th scope="row">Consent relied upon</th>
      <td>
          <textarea class="form-control" id="CRU_SUM_ACTION" name="CRU_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="CRU_TYPE_ACTION" name="CRU_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="CRU_ON_ACTION" name="CRU_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="CRU_DUE_DATE" name="CRU_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="CRU_IMP_DATE" name="CRU_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="CRU_REVIEW" name="CRU_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="CRU_OWNER" name="CRU_OWNER"></textarea>
      </td>    
    </tr>      
    <tr>
      <th scope="row">PCI Compliance</th>
      <td>
          <textarea class="form-control" id="PCI_SUM_ACTION" name="PCI_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="PCI_TYPE_ACTION" name="PCI_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="PCI_ON_ACTION" name="PCI_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="PCI_DUE_DATE" name="PCI_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="PCI_IMP_DATE" name="PCI_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="PCI_REVIEW" name="PCI_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="PCI_OWNER" name="PCI_OWNER"></textarea>
      </td>   
    </tr>
    <tr>
      <th scope="row">Advised sales</th>
      <td>
          <textarea class="form-control" id="AS_SUM_ACTION" name="AS_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="AS_TYPE_ACTION" name="AS_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="AS_ON_ACTION" name="AS_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="AS_DUE_DATE" name="AS_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="AS_IMP_DATE" name="AS_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="AS_REVIEW" name="AS_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="AR_OWNER" name="AR_OWNER"></textarea>
      </td>    
    </tr>      
    <tr>
      <th scope="row">Referrals to a Financial Advisor</th>
      <td>
          <textarea class="form-control" id="RFA_SUM_ACTION" name="RFA_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="RFA_TYPE_ACTION" name="RFA_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="RFA_ON_ACTION" name="RFA_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="RFA_DUE_DATE" name="RFA_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="RFA_IMP_DATE" name="RFA_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="RFA_REVIEW" name="RFA_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="RFA_OWNER" name="RFA_OWNER"></textarea>
      </td>   
    </tr>      
    <tr>
      <th scope="row">Misleading marketing content</th>
      <td>
          <textarea class="form-control" id="MMC_SUM_ACTION" name="MMC_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="MMC_TYPE_ACTION" name="MMC_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="MMC_ON_ACTION" name="MMC_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="MMC_DUE_DATE" name="MMC_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="MMC_IMP_DATE" name="MMC_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="MMC_REVIEW" name="MMC_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="MMC_OWNER" name="MMC_OWNER"></textarea>
      </td>     
    </tr>   
    <tr>
      <th scope="row">Adequate Resources</th>
      <td>
          <textarea class="form-control" id="AR_SUM_ACTION" name="AR_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="AR_TYPE_ACTION" name="AR_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="AR_ON_ACTION" name="AR_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="AR_DUE_DATE" name="AR_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="AR_IMP_DATE" name="AR_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="AR_REVIEW" name="AR_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="AR_OWNER" name="AR_OWNER"></textarea>
      </td>     
    </tr>
        <tr>
      <th scope="row">Training and competency</th>
      <td>
          <textarea class="form-control" id="TAC_SUM_ACTION" name="TAC_SUM_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="TAC_TYPE_ACTION" name="TAC_TYPE_ACTION"></textarea>
      </td>
      <td>
          <textarea class="form-control" id="TAC_ON_ACTION" name="TAC_ON_ACTION"></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="TAC_DUE_DATE" name="TAC_DUE_DATE">
      </td> 
      <td>
          <input type="text" class="form-control" id="TAC_IMP_DATE" name="TAC_IMP_DATE">
      </td>
      <td>
          <input type="text" class="form-control" id="TAC_REVIEW" name="TAC_REVIEW">
      </td>
      <td>
          <textarea class="form-control" id="TAC_OWNER" name="TAC_OWNER"></textarea>
      </td>     
    </tr>  
  </tbody>
</table>                
        
        
    </div>
  <div class="tab-pane" id="settings" role="tabpanel">4</div>
</div>

<p class="card-text">
   
    


</p>
</div>
<div class="card-footer">
ADL
</div>
</div>        
        
               
    </div>
                </div>
    </div>

            <script src="/js/jquery/jquery-3.0.0.min.js"></script>
                    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script>
    $(function () {
        $("#ICO_RENEWAL_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>
        <script>
    $(function () {
        $("#TAC_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>
        <script>
    $(function () {
        $("#TAC_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>
        <script>
    $(function () {
        $("#TAC_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>



        <script>
    $(function () {
        $("#AS_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>
        <script>
    $(function () {
        $("#AS_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>
        <script>
    $(function () {
        $("#AS_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#MMC_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#MMC_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#MMC_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>



        <script>
    $(function () {
        $("#RFA_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#RFA_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#RFA_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>


        <script>
    $(function () {
        $("#AR_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#AR_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#AR_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>



        <script>
    $(function () {
        $("#PCI_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#PCI_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#PCI_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>


        <script>
    $(function () {
        $("#CRU_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#CRU_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#CRU_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>


        <script>
    $(function () {
        $("#VC_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#VC_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#VC_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>


        <script>
    $(function () {
        $("#CH_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#CH_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#CH_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#SAC_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#SAC_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#SAC_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#DPRK_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#DPRK_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#DPRK_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>


        <script>
    $(function () {
        $("#DU_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#DU_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#DU_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>


        <script>
    $(function () {
        $("#TPS_DUE_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#TPS_IMP_DATE").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>
    $(function () {
        $("#TPS_REVIEW").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+1"
        });
    });
</script>

        <script>$('#myTab a[href="#profile"]').tab('show') // Select tab by name
$('#myTab a:first').tab('show') // Select first tab
$('#myTab a:last').tab('show') // Select last tab
$('#myTab li:eq(2) a').tab('show') // Select third tab (0-indexed)</script>
</body>
</html>
