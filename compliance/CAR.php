<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

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
                  $AGENCY_ENTITY_ID='1';
                  }        
        
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
<?php if(isset($COMPANY_ENTITY)) { echo $COMPANY_ENTITY; } ?> Compliance Audit and Review
</h3>
<div class="card-block">
    
    <?php if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
    
<div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <center><strong><?php if(isset($AGENCY)) { echo "$AGENCY audit progress"; } else { echo "Select a company from the drop down to view thier audit document"; }  ?><br>
                       </strong></center></div>	    
    
    <form method="GET" action="CAR.php">
              <div class="form-group">
    <label for="AGENCY">Company:</label>
    <select class="form-control" name='AGENCY' onchange="this.form.submit()" required>
        <option value="">Select...</option>
        <option <?php if(isset($AGENCY) && $AGENCY=='Bluestone Protect') { echo "selected"; } ?> value='Bluestone Protect'>Bluestone Protect</option>
        <option <?php if(isset($AGENCY) && $AGENCY=='Protect Family Plans') { echo "selected"; } ?> value='Protect Family Plans'>Protect Family Plans</option>
        <option <?php if(isset($AGENCY) && $AGENCY=='Protected Life Ltd') { echo "selected"; } ?> value='Protected Life Ltd'>Protected Life Ltd</option>
        <option <?php if(isset($AGENCY) && $AGENCY=='We Insure') { echo "selected"; } ?> value='We Insure'>We Insure</option>
        <option <?php if(isset($AGENCY) && $AGENCY=='The Financial Assessment Centre') { echo "selected"; } ?> value='The Financial Assessment Centre'>The Financial Assessment Centre</option>
        <option <?php if(isset($AGENCY) && $AGENCY=='Assured Protect and Mortgages') { echo "selected"; } ?> value='Assured Protect and Mortgages'>Assured Protect and Mortgages</option>
    </select>
  </div>
    </form>
    <?php } ?>
    
    
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

      <?php
      
    $query = $pdo->prepare("SELECT 
    car_business_overview_len,
    car_business_overview_tr,
    car_business_overview_pf,
    car_business_overview_an,
    car_business_overview_ico_rd,
    car_business_overview_psdi,
    car_business_overview_bm,
    car_business_overview_gs,
    car_business_overview_ca,
    car_business_overview_ce,
    car_business_overview_sd,
    car_business_overview_tc,
    car_business_overview_dpa,
    car_business_overview_ch
    FROM
    car_business_overview 
    WHERE
    car_business_overview_id_fk =:FK");
    if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) {
    $query->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_INT);
    } else {
    $query->bindParam(':FK', $COMPANY_ENTITY_ID, PDO::PARAM_INT);
    }
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC); 
    
    if(isset($data1['car_business_overview_len'])) {
        $LEGAL_ENTITY_NAME=$data1['car_business_overview_len'];
    }
    if(isset($data1['car_business_overview_tr'])) {
        $TRADING_NAMES=$data1['car_business_overview_tr'];
    }
    if(isset($data1['car_business_overview_pf'])) {
        $PRINCIPAL_FIRM=$data1['car_business_overview_pf'];
    }
    if(isset($data1['car_business_overview_an'])) {
        $AUTH_NUMBERS=$data1['car_business_overview_an'];
    }
    if(isset($data1['car_business_overview_ico_rd'])) {
        $ICO_RENEWAL_DATE=$data1['car_business_overview_ico_rd'];
    }  
    if(isset($data1['car_business_overview_psdi'])) {
        $DIRECTOR_INFO=$data1['car_business_overview_psdi'];
    }
    if(isset($data1['car_business_overview_bm'])) {
        $BUSINESS_OVERVIEW=$data1['car_business_overview_bm'];
    }  
    if(isset($data1['car_business_overview_gs'])) {
        $GOV_STRAT_OVERVIEW=$data1['car_business_overview_gs'];
    } 
    if(isset($data1['car_business_overview_ca'])) {
        $CLIENT_ACQ_OVERVIEW=$data1['car_business_overview_ca'];
    } 
    if(isset($data1['car_business_overview_ce'])) {
        $CLIENT_ENG_OVERVIEW=$data1['car_business_overview_ce'];
    }    
    if(isset($data1['car_business_overview_sd'])) {
        $SER_DEL_OVERVIEW=$data1['car_business_overview_sd'];
    }        
    if(isset($data1['car_business_overview_tc'])) {
        $TRN_COM_OVERVIEW=$data1['car_business_overview_tc'];
    }
    if(isset($data1['car_business_overview_dpa'])) {
        $DATA_PRO_ARR_OVERVIEW=$data1['car_business_overview_dpa'];
    }
    if(isset($data1['car_business_overview_ch'])) {
        $COMP_HAN_OVERVIEW=$data1['car_business_overview_ch'];
    }    
      ?>
  
      <h3>Firm Information</h3>
      
      <form method="POST" action="<?php if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) { echo "php/CAR_MANAGER.php?EXECUTE=1&AGENCY=$AGENCY"; } else { echo "php/CAR.php?EXECUTE=1"; }?>" class="form-horizontal">
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="LEGAL_ENTITY_NAME" class="col-sm-3 col-form-label">Legal Entity Name:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="LEGAL_ENTITY_NAME" name="LEGAL_ENTITY_NAME" value="<?php if(isset($LEGAL_ENTITY_NAME)) { echo $LEGAL_ENTITY_NAME; } ?>">
                    </div>
                </div>
            </div>
 
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="TRADING_NAMES" class="col-sm-3 col-form-label">Trading Names:</label>
                    <div class="col-sm-9">
                       <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TRADING_NAMES" name="TRADING_NAMES"><?php if(isset($TRADING_NAMES)) { echo $TRADING_NAMES; } ?></textarea>
                    </div>
                </div>
            </div> 
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="PRINCIPAL_FIRM" class="col-sm-3 col-form-label">Principal Firm:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="PRINCIPAL_FIRM" name="PRINCIPAL_FIRM" placeholder="Hayden Williams Independent Financial Services LTD" value="<?php if(isset($PRINCIPAL_FIRM)) { echo $PRINCIPAL_FIRM; } ?>">
                    </div>
                </div>
            </div>       

           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="AUTH_NUMBERS" class="col-sm-3 col-form-label">Authorisation Numbers (FCA/ICO):</label>
                    <div class="col-sm-9">
                       <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AUTH_NUMBERS" name="AUTH_NUMBERS"><?php if(isset($AUTH_NUMBERS)) { echo $AUTH_NUMBERS; } ?></textarea>
                    </div>
                </div>
            </div>           
          
                     <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="ICO_RENEWAL_DATE" class="col-sm-3 col-form-label">ICO Renewal Date:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="ICO_RENEWAL_DATE" name="ICO_RENEWAL_DATE" value="<?php if(isset($ICO_RENEWAL_DATE)) { echo $ICO_RENEWAL_DATE; } ?>">
                    </div>
                </div>
            </div> 
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="DIRECTOR_INFO" class="col-sm-3 col-form-label">Principal, Shareholder and Director Information:</label>
                    <div class="col-sm-9">
                       <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DIRECTOR_INFO" name="DIRECTOR_INFO"><?php if(isset($DIRECTOR_INFO)) { echo $DIRECTOR_INFO; } ?></textarea>
                    </div>
                </div>
            </div>        
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="BUSINESS_OVERVIEW" class="col-sm-3 col-form-label">Overview of Business Model:</label>
                    <div class="col-sm-9">
                       <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="BUSINESS_OVERVIEW" name="BUSINESS_OVERVIEW"><?php if(isset($BUSINESS_OVERVIEW)) { echo $BUSINESS_OVERVIEW; } ?></textarea>
                    </div>
                </div>
            </div>     
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="GOV_STRAT_OVERVIEW" class="col-sm-3 col-form-label">Overview of Governance and Strategy:</label>
                    <div class="col-sm-9">
                       <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="GOV_STRAT_OVERVIEW" name="GOV_STRAT_OVERVIEW"><?php if(isset($GOV_STRAT_OVERVIEW)) { echo $GOV_STRAT_OVERVIEW; } ?></textarea>
                    </div>
                </div>
            </div>
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="CLIENT_ACQ_OVERVIEW" class="col-sm-3 col-form-label">Overview of Client Acquisition:</label>
                    <div class="col-sm-9">
                       <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CLIENT_ACQ_OVERVIEW" name="CLIENT_ACQ_OVERVIEW"><?php if(isset($CLIENT_ACQ_OVERVIEW)) { echo $CLIENT_ACQ_OVERVIEW; } ?></textarea>
                    </div>
                </div>
            </div>
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="CLIENT_ENG_OVERVIEW" class="col-sm-3 col-form-label">Overview of Client Engagement:</label>
                    <div class="col-sm-9">
                       <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CLIENT_ENG_OVERVIEW" name="CLIENT_ENG_OVERVIEW"><?php if(isset($CLIENT_ENG_OVERVIEW)) { echo $CLIENT_ENG_OVERVIEW; } ?></textarea>
                    </div>
                </div>
            </div>
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="SER_DEL_OVERVIEW" class="col-sm-3 col-form-label">Overview of Service Delivery:</label>
                    <div class="col-sm-9">
                       <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="SER_DEL_OVERVIEW" name="SER_DEL_OVERVIEW"><?php if(isset($SER_DEL_OVERVIEW)) { echo $SER_DEL_OVERVIEW; } ?></textarea>
                    </div>
                </div>
            </div>
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="TRN_COM_OVERVIEW" class="col-sm-3 col-form-label">Overview of Training and Competence:</label>
                    <div class="col-sm-9">
                       <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TRN_COM_OVERVIEW" name="TRN_COM_OVERVIEW"><?php if(isset($TRN_COM_OVERVIEW)) { echo $TRN_COM_OVERVIEW; } ?></textarea>
                    </div>
                </div>
            </div> 
 
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="DATA_PRO_ARR_OVERVIEW" class="col-sm-3 col-form-label">Overview of Data Protection Arrangements:</label>
                    <div class="col-sm-9">
                       <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DATA_PRO_ARR_OVERVIEW" name="DATA_PRO_ARR_OVERVIEW"><?php if(isset($DATA_PRO_ARR_OVERVIEW)) { echo $DATA_PRO_ARR_OVERVIEW; } ?></textarea>
                    </div>
                </div>
            </div>
          
           <div class="form-group form-group-sm col-sm-6">
                <div class="row">
                    <label for="COMP_HAN_OVERVIEW" class="col-sm-3 col-form-label">Overview of Complaints Handling:</label>
                    <div class="col-sm-9">
                       <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="COMP_HAN_OVERVIEW" name="COMP_HAN_OVERVIEW"><?php if(isset($COMP_HAN_OVERVIEW)) { echo $COMP_HAN_OVERVIEW; } ?></textarea>
                    </div>
                </div>
            </div>    

             <div class="form-group">
<button type="submit" class="btn btn-primary form-control">Save Business Overview</button>
    </div>
          
      </form>
   
  </div>
    <div class="tab-pane" id="profile" role="tabpanel">

        <?php
        
    $RO_PR_1 = $pdo->prepare("SELECT 
 car_risk_overview_tps_sr,
 car_risk_overview_tps_cr,
 car_risk_overview_tps_ri,
 car_risk_overview_tps_rs,
 car_risk_overview_tps_rp,
 car_risk_overview_du_sr,
 car_risk_overview_du_cr,
 car_risk_overview_du_ri,
 car_risk_overview_du_rs,
 car_risk_overview_du_rp,
 car_risk_overview_dprk_sr,
 car_risk_overview_dprk_cr,
 car_risk_overview_dprk_ri,
 car_risk_overview_dprk_rs,
 car_risk_overview_dprk_rp,
 car_risk_overview_sc_sr,
 car_risk_overview_sc_cr,
 car_risk_overview_sc_ri,
 car_risk_overview_sc_rs,
 car_risk_overview_sc_rp,
 car_risk_overview_ch_sr,
 car_risk_overview_ch_cr,
 car_risk_overview_ch_ri,
 car_risk_overview_ch_rs,
 car_risk_overview_ch_rp
    FROM
    car_risk_overview_1 
    WHERE
    car_risk_overview_id_fk =:FK");
        if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) {
    $RO_PR_1->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_INT);
    } else {
    $RO_PR_1->bindParam(':FK', $COMPANY_ENTITY_ID, PDO::PARAM_INT);
    }
    $RO_PR_1->execute();
    $data2 = $RO_PR_1->fetch(PDO::FETCH_ASSOC);         
        
if(isset($data2['car_risk_overview_tps_sr'])) {
    $TPS_SUM_RISK=$data2['car_risk_overview_tps_sr'];
}

if(isset($data2['car_risk_overview_tps_cr'])) {
    $TPS_COM_RISK=$data2['car_risk_overview_tps_cr'];
}
if(isset($data2['car_risk_overview_tps_ri'])) {
    $TPS_IMPACT_RISK=$data2['car_risk_overview_tps_ri'];
}
if(isset($data2['car_risk_overview_tps_rs'])) {
    $TPS_SCORE_RISK=$data2['car_risk_overview_tps_rs'];
}
if(isset($data2['car_risk_overview_tps_rp'])) {
    $TPS_PRO_RISK=$data2['car_risk_overview_tps_rp'];
}

if(isset($data2['car_risk_overview_du_sr'])) {
    $DU_SUM_RISK=$data2['car_risk_overview_du_sr'];
}
if(isset($data2['car_risk_overview_du_cr'])) {
    $DU_COM_RISK=$data2['car_risk_overview_du_cr'];
}
if(isset($data2['car_risk_overview_du_ri'])) {
    $DU_IMPACT_RISK=$data2['car_risk_overview_du_ri'];
}
if(isset($data2['car_risk_overview_du_rs'])) {
    $DU_SCORE_RISK=$data2['car_risk_overview_du_rs'];
}
if(isset($data2['car_risk_overview_du_rp'])) {
    $DU_PRO_RISK=$data2['car_risk_overview_du_rp'];
}

if(isset($data2['car_risk_overview_dprk_sr'])) {
    $DPRK_SUM_RISK=$data2['car_risk_overview_dprk_sr'];
}
if(isset($data2['car_risk_overview_dprk_cr'])) {
    $DPRK_COM_RISK=$data2['car_risk_overview_dprk_cr'];
}
if(isset($data2['car_risk_overview_dprk_ri'])) {
    $DPRK_IMPACT_RISK=$data2['car_risk_overview_dprk_ri'];
}
if(isset($data2['car_risk_overview_dprk_rs'])) {
    $DPRK_SCORE_RISK=$data2['car_risk_overview_dprk_rs'];
}
if(isset($data2['car_risk_overview_dprk_rp'])) {
    $DPRK_PRO_RISK=$data2['car_risk_overview_dprk_rp'];
}

if(isset($data2['car_risk_overview_sc_sr'])) {
    $SAC_SUM_RISK=$data2['car_risk_overview_sc_sr'];
}
if(isset($data2['car_risk_overview_sc_cr'])) {
    $SAC_COM_RISK=$data2['car_risk_overview_sc_cr'];
}
if(isset($data2['car_risk_overview_sc_ri'])) {
    $SAC_IMPACT_RISK=$data2['car_risk_overview_sc_ri'];
}
if(isset($data2['car_risk_overview_sc_rs'])) {
    $SAC_SCORE_RISK=$data2['car_risk_overview_sc_rs'];
}
if(isset($data2['car_risk_overview_sc_rp'])) {
    $SAC_PRO_RISK=$data2['car_risk_overview_sc_rp'];
}   

if(isset($data2['car_risk_overview_ch_sr'])) {
    $CH_SUM_RISK=$data2['car_risk_overview_ch_sr'];
}
if(isset($data2['car_risk_overview_ch_cr'])) {
    $CH_COM_RISK=$data2['car_risk_overview_ch_cr'];
}
if(isset($data2['car_risk_overview_ch_ri'])) {
    $CH_IMPACT_RISK=$data2['car_risk_overview_ch_ri'];
}
if(isset($data2['car_risk_overview_ch_rs'])) {
    $CH_SCORE_RISK=$data2['car_risk_overview_ch_rs'];
}
if(isset($data2['car_risk_overview_ch_rp'])) {
    $CH_PRO_RISK=$data2['car_risk_overview_ch_rp'];
}
        ?>
        
<form method="POST" action="<?php if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) { echo "php/CAR_MANAGER.php?EXECUTE=2&AGENCY=$AGENCY"; } else { echo "php/CAR.php?EXECUTE=2"; }?>">        
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
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TPS_SUM_RISK" name="TPS_SUM_RISK"><?php if(isset($TPS_SUM_RISK)) { echo $TPS_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="TPS_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($TPS_COM_RISK) && $TPS_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($TPS_COM_RISK) && $TPS_COM_RISK=='Red') { echo "selected"; } ?> value="Red">Red</option>
          </select>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TPS_IMPACT_RISK" name="TPS_IMPACT_RISK"><?php if(isset($TPS_IMPACT_RISK)) { echo $TPS_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TPS_SCORE_RISK" name="TPS_SCORE_RISK"><?php if(isset($TPS_SCORE_RISK)) { echo $TPS_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TPS_PRO_RISK" name="TPS_PRO_RISK"><?php if(isset($TPS_PRO_RISK)) { echo $TPS_PRO_RISK; } ?></textarea>
      </td>      
    </tr>
    <tr>
      <th scope="row">Due diligence</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DU_SUM_RISK" name="DU_SUM_RISK"><?php if(isset($DU_SUM_RISK)) { echo $DU_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="DU_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($DU_COM_RISK) && $DU_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($DU_COM_RISK) && $DU_COM_RISK=='Red') { echo "selected"; } ?> value="Red">Red</option>
          </select>      
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DU_IMPACT_RISK" name="DU_IMPACT_RISK"><?php if(isset($DU_IMPACT_RISK)) { echo $DU_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DU_SCORE_RISK" name="DU_SCORE_RISK"><?php if(isset($DU_SCORE_RISK)) { echo $DU_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DU_PRO_RISK" name="DU_PRO_RISK"><?php if(isset($DU_PRO_RISK)) { echo $DU_PRO_RISK; } ?></textarea>
      </td>  
    </tr>
    <tr>
      <th scope="row">Data protection and recording keeping</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DPRK_SUM_RISK" name="DPRK_SUM_RISK"><?php if(isset($DPRK_SUM_RISK)) { echo $DPRK_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="DPRK_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($DPRK_COM_RISK) && $DPRK_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($DPRK_COM_RISK) && $DPRK_COM_RISK=='Red') { echo "selected"; } ?> value="Red">Red</option>
          </select>            
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DPRK_IMPACT_RISK" name="DPRK_IMPACT_RISK"><?php if(isset($DPRK_IMPACT_RISK)) { echo $DPRK_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DPRK_SCORE_RISK" name="DPRK_SCORE_RISK"><?php if(isset($DPRK_SCORE_RISK)) { echo $DPRK_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DPRK_PRO_RISK" name="DPRK_PRO_RISK"><?php if(isset($DPRK_PRO_RISK)) { echo $DPRK_PRO_RISK; } ?></textarea>
      </td>  
    </tr>
    <tr>
      <th scope="row">Systems and controls</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="SAC_SUM_RISK" name="SAC_SUM_RISK"><?php if(isset($SAC_SUM_RISK)) { echo $SAC_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="SAC_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($SAC_COM_RISK) && $SAC_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($SAC_COM_RISK) && $SAC_COM_RISK=='Red') { echo "selected"; } ?> value="Red">Red</option>
          </select>            
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="SAC_IMPACT_RISK" name="SAC_IMPACT_RISK"><?php if(isset($SAC_IMPACT_RISK)) { echo $SAC_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="SAC_SCORE_RISK" name="SAC_SCORE_RISK"><?php if(isset($SAC_SCORE_RISK)) { echo $SAC_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="SAC_PRO_RISK" name="SAC_PRO_RISK"><?php if(isset($SAC_PRO_RISK)) { echo $SAC_PRO_RISK; } ?></textarea>
      </td>  
    </tr>       
    <tr>
      <th scope="row">Complaints handling</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="COMP_HAN_OVERVIEW" name="CH_SUM_RISK"><?php if(isset($CH_SUM_RISK)) { echo $CH_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="CH_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($CH_COM_RISK) && $CH_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($CH_COM_RISK) && $CH_COM_RISK=='Red') { echo "selected"; } ?> value="Red">Red</option>
          </select>             
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CH_IMPACT_RISK" name="CH_IMPACT_RISK"><?php if(isset($CH_IMPACT_RISK)) { echo $CH_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CH_SCORE_RISK" name="CH_SCORE_RISK"><?php if(isset($CH_SCORE_RISK)) { echo $CH_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CH_PRO_RISK" name="CH_PRO_RISK"><?php if(isset($CH_PRO_RISK)) { echo $CH_PRO_RISK; } ?></textarea>
      </td>  
    </tr> 
    
<?php

   $RO_PR_2 = $pdo->prepare("SELECT 
 car_risk_overview_vc_sr,
 car_risk_overview_vc_cr,
 car_risk_overview_vc_ri,
 car_risk_overview_vc_rs,
 car_risk_overview_vc_rp,
 car_risk_overview_cru_sr,
 car_risk_overview_cru_cr,
 car_risk_overview_cru_ri,
 car_risk_overview_cru_rs,
 car_risk_overview_cru_rp,
 car_risk_overview_pci_sr,
 car_risk_overview_pci_cr,
 car_risk_overview_pci_ri,
 car_risk_overview_pci_rs,
 car_risk_overview_pci_rp,
 car_risk_overview_as_sr,
 car_risk_overview_as_cr,
 car_risk_overview_as_ri,
 car_risk_overview_as_rs,
 car_risk_overview_as_rp,
 car_risk_overview_rfa_sr,
 car_risk_overview_rfa_cr,
 car_risk_overview_rfa_ri,
 car_risk_overview_rfa_rs,
 car_risk_overview_rfa_rp
    FROM
    compliance_risk_overview_2 
    WHERE
    compliance_risk_overview_2_id_fk =:FK");
           if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) {
    $RO_PR_2->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_INT);
    } else {
    $RO_PR_2->bindParam(':FK', $COMPANY_ENTITY_ID, PDO::PARAM_INT);
    }
    $RO_PR_2->execute();
    $data3 = $RO_PR_2->fetch(PDO::FETCH_ASSOC);  

if(isset($data3['car_risk_overview_vc_sr'])) {
    $VC_SUM_RISK=$data3['car_risk_overview_vc_sr'];
}
if(isset($data3['car_risk_overview_vc_cr'])) {
    $VC_COM_RISK=$data3['car_risk_overview_vc_cr'];
}
if(isset($data3['car_risk_overview_vc_ri'])) {
    $VC_IMPACT_RISK=$data3['car_risk_overview_vc_ri'];
}
if(isset($data3['car_risk_overview_vc_rs'])) {
    $VC_SCORE_RISK=$data3['car_risk_overview_vc_rs'];
}
if(isset($data3['car_risk_overview_vc_rp'])) {
    $VC_PRO_RISK=$data3['car_risk_overview_vc_rp'];
}

if(isset($data3['car_risk_overview_cru_sr'])) {
    $CRU_SUM_RISK=$data3['car_risk_overview_cru_sr'];
}
if(isset($data3['car_risk_overview_cru_cr'])) {
    $CRU_COM_RISK=$data3['car_risk_overview_cru_cr'];
}
if(isset($data3['car_risk_overview_cru_ri'])) {
    $CRU_IMPACT_RISK=$data3['car_risk_overview_cru_ri'];
}
if(isset($data3['car_risk_overview_cru_rs'])) {
    $CRU_SCORE_RISK=$data3['car_risk_overview_cru_rs'];
}
if(isset($data3['car_risk_overview_cru_rp'])) {
    $CRU_PRO_RISK=$data3['car_risk_overview_cru_rp'];
}

if(isset($data3['car_risk_overview_pci_sr'])) {
    $PCI_SUM_RISK=$data3['car_risk_overview_pci_sr'];
}
if(isset($data3['car_risk_overview_pci_cr'])) {
    $PCI_COM_RISK=$data3['car_risk_overview_pci_cr'];
}
if(isset($data3['car_risk_overview_pci_ri'])) {
    $PCI_IMPACT_RISK=$data3['car_risk_overview_pci_ri'];
}
if(isset($data3['car_risk_overview_pci_rs'])) {
    $PCI_SCORE_RISK=$data3['car_risk_overview_pci_rs'];
}
if(isset($data3['car_risk_overview_pci_rp'])) {
    $PCI_PRO_RISK=$data3['car_risk_overview_pci_rp'];
}

if(isset($data3['car_risk_overview_as_sr'])) {
    $AS_SUM_RISK=$data3['car_risk_overview_as_sr'];
}
if(isset($data3['car_risk_overview_as_cr'])) {
    $AS_COM_RISK=$data3['car_risk_overview_as_cr'];
}
if(isset($data3['car_risk_overview_as_ri'])) {
    $AS_IMPACT_RISK=$data3['car_risk_overview_as_ri'];
}
if(isset($data3['car_risk_overview_as_rs'])) {
    $AS_SCORE_RISK=$data3['car_risk_overview_as_rs'];
}
if(isset($data3['car_risk_overview_as_rp'])) {
    $AS_PRO_RISK=$data3['car_risk_overview_as_rp'];
}    

if(isset($data3['car_risk_overview_rfa_sr'])) {
    $RFA_SUM_RISK=$data3['car_risk_overview_rfa_sr'];
}  
if(isset($data3['car_risk_overview_rfa_cr'])) {
    $RFA_COM_RISK=$data3['car_risk_overview_rfa_cr'];
}  
if(isset($data3['car_risk_overview_rfa_ri'])) {
    $RFA_IMPACT_RISK=$data3['car_risk_overview_rfa_ri'];
}
if(isset($data3['car_risk_overview_rfa_rs'])) {
    $RFA_SCORE_RISK=$data3['car_risk_overview_rfa_rs'];
}
if(isset($data3['car_risk_overview_rfa_rp'])) {
    $RFA_PRO_RISK=$data3['car_risk_overview_rfa_rp'];
}
?>
    
    <tr>
      <th scope="row">Vulnerable customers</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="VC_SUM_RISK" name="VC_SUM_RISK"><?php if(isset($VC_SUM_RISK)) { echo $VC_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="VC_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($VC_COM_RISK) && $VC_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($VC_COM_RISK) && $VC_COM_RISK=='Red') { echo "selected"; } ?> value="Red">Red</option>
          </select>           
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="VC_IMPACT_RISK" name="VC_IMPACT_RISK"><?php if(isset($VC_IMPACT_RISK)) { echo $VC_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="VC_SCORE_RISK" name="VC_SCORE_RISK"><?php if(isset($VC_SCORE_RISK)) { echo $VC_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="VC_PRO_RISK" name="VC_PRO_RISK"><?php if(isset($VC_PRO_RISK)) { echo $VC_PRO_RISK; } ?></textarea>
      </td>  
    </tr>
    <tr>
      <th scope="row">Consent relied upon</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CRU_SUM_RISK" name="CRU_SUM_RISK"><?php if(isset($CRU_SUM_RISK)) { echo $CRU_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="CRU_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($CRU_COM_RISK) && $CRU_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($CRU_COM_RISK) && $CRU_COM_RISK=='Red') { echo "selected"; } ?>  value="Red">Red</option>
          </select>            
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CRU_IMPACT_RISK" name="CRU_IMPACT_RISK"><?php if(isset($CRU_IMPACT_RISK)) { echo $CRU_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CRU_SCORE_RISK" name="CRU_SCORE_RISK"><?php if(isset($CRU_SCORE_RISK)) { echo $CRU_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CRU_PRO_RISK" name="CRU_PRO_RISK"><?php if(isset($CRU_PRO_RISK)) { echo $CRU_PRO_RISK; } ?></textarea>
      </td>  
    </tr>      
    <tr>
      <th scope="row">PCI Compliance</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="PCI_SUM_RISK" name="PCI_SUM_RISK"><?php if(isset($PCI_SUM_RISK)) { echo $PCI_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="PCI_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($PCI_COM_RISK) && $PCI_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($PCI_COM_RISK) && $PCI_COM_RISK=='Red') { echo "selected"; } ?> value="Red">Red</option>
          </select>           
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="PCI_IMPACT_RISK" name="PCI_IMPACT_RISK"><?php if(isset($PCI_IMPACT_RISK)) { echo $PCI_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="PCI_SCORE_RISK" name="PCI_SCORE_RISK"><?php if(isset($PCI_SCORE_RISK)) { echo $PCI_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="PCI_PRO_RISK" name="PCI_PRO_RISK"><?php if(isset($PCI_PRO_RISK)) { echo $PCI_PRO_RISK; } ?></textarea>
      </td>  
    </tr>
    <tr>
      <th scope="row">Advised sales</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AS_SUM_RISK" name="AS_SUM_RISK"><?php if(isset($AS_SUM_RISK)) { echo $AS_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="AS_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($AS_COM_RISK) && $AS_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($AS_COM_RISK) && $AS_COM_RISK=='Red') { echo "selected"; } ?> value="Red">Red</option>
          </select>            
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AS_IMPACT_RISK" name="AS_IMPACT_RISK"><?php if(isset($AS_IMPACT_RISK)) { echo $AS_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AS_SCORE_RISK" name="AS_SCORE_RISK"><?php if(isset($AS_SCORE_RISK)) { echo $AS_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AS_PRO_RISK" name="AS_PRO_RISK"><?php if(isset($AS_PRO_RISK)) { echo $AS_PRO_RISK; } ?></textarea>
      </td>  
    </tr>      
    <tr>
      <th scope="row">Referrals to a Financial Advisor</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="RFA_SUM_RISK" name="RFA_SUM_RISK"><?php if(isset($RFA_SUM_RISK)) { echo $RFA_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="RFA_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($RFA_COM_RISK) && $RFA_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($RFA_COM_RISK) && $RFA_COM_RISK=='Red') { echo "selected"; } ?> value="Red">Red</option>
          </select>            
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="RFA_IMPACT_RISK" name="RFA_IMPACT_RISK"><?php if(isset($RFA_IMPACT_RISK)) { echo $RFA_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="RFA_SCORE_RISK" name="RFA_SCORE_RISK"><?php if(isset($RFA_SCORE_RISK)) { echo $RFA_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="RFA_PRO_RISK" name="RFA_PRO_RISK"><?php if(isset($RFA_PRO_RISK)) { echo $RFA_PRO_RISK; } ?></textarea>
      </td>  
    </tr>     
    
<?php

   $RO_PR_3 = $pdo->prepare("SELECT 
 car_risk_overview_mmc_sr,
 car_risk_overview_mmc_cr,
 car_risk_overview_mmc_ri,
 car_risk_overview_mmc_rs,
 car_risk_overview_mmc_rp,
 car_risk_overview_ar_sr,
 car_risk_overview_ar_cr,
 car_risk_overview_ar_ri,
 car_risk_overview_ar_rs,
 car_risk_overview_ar_rp,
 car_risk_overview_tc_sr,
 car_risk_overview_tc_cr,
 car_risk_overview_tc_ri,
 car_risk_overview_tc_rs,
 car_risk_overview_tc_rp
    FROM
    compliance_risk_overview_3 
    WHERE
     compliance_risk_overview_3_id_fk =:FK");
              if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) {
    $RO_PR_3->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_INT);
    } else {
    $RO_PR_3->bindParam(':FK', $COMPANY_ENTITY_ID, PDO::PARAM_INT);
    }
    $RO_PR_3->execute();
    $data4 = $RO_PR_3->fetch(PDO::FETCH_ASSOC);  

if(isset($data4['car_risk_overview_mmc_sr'])) {
    $MMC_SUM_RISK=$data4['car_risk_overview_mmc_sr'];
}
if(isset($data4['car_risk_overview_mmc_cr'])) {
    $MMC_COM_RISK=$data4['car_risk_overview_mmc_cr'];
}
if(isset($data4['car_risk_overview_mmc_ri'])) {
    $MMC_IMPACT_RISK=$data4['car_risk_overview_mmc_ri'];
}
if(isset($data4['car_risk_overview_mmc_rs'])) {
    $MMC_SCORE_RISK=$data4['car_risk_overview_mmc_rs'];
}
if(isset($data4['car_risk_overview_mmc_rp'])) {
    $MMC_PRO_RISK=$data4['car_risk_overview_mmc_rp'];
}

if(isset($data4['car_risk_overview_ar_sr'])) {
    $AR_SUM_RISK=$data4['car_risk_overview_ar_sr'];
}
if(isset($data4['car_risk_overview_ar_cr'])) {
    $AR_COM_RISK=$data4['car_risk_overview_ar_cr'];
}
if(isset($data4['car_risk_overview_ar_ri'])) {
    $AR_IMPACT_RISK=$data4['car_risk_overview_ar_ri'];
}
if(isset($data4['car_risk_overview_ar_rs'])) {
    $AR_SCORE_RISK=$data4['car_risk_overview_ar_rs'];
}
if(isset($data4['car_risk_overview_ar_rp'])) {
    $AR_PRO_RISK=$data4['car_risk_overview_ar_rp'];
}

if(isset($data4['car_risk_overview_tc_sr'])) {
    $TAC_SUM_RISK=$data4['car_risk_overview_tc_sr'];
}
if(isset($data4['car_risk_overview_tc_cr'])) {
    $TAC_COM_RISK=$data4['car_risk_overview_tc_cr'];
}
if(isset($data4['car_risk_overview_tc_ri'])) {
    $TAC_IMPACT_RISK=$data4['car_risk_overview_tc_ri'];
}
if(isset($data4['car_risk_overview_tc_rs'])) {
    $TAC_SCORE_RISK=$data4['car_risk_overview_tc_rs'];
}
if(isset($data4['car_risk_overview_tc_rp'])) {
    $TAC_PRO_RISK=$data4['car_risk_overview_tc_rp'];
}
?>
    
    
    <tr>
      <th scope="row">Misleading marketing content</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="MMC_SUM_RISK" name="MMC_SUM_RISK"><?php if(isset($MMC_SUM_RISK)) { echo $MMC_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="MMC_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($MMC_COM_RISK) && $MMC_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($MMC_COM_RISK) && $MMC_COM_RISK=='Red') { echo "selected"; } ?> value="Red">Red</option>
          </select>            
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="MMC_IMPACT_RISK" name="MMC_IMPACT_RISK"><?php if(isset($MMC_IMPACT_RISK)) { echo $MMC_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="MMC_SCORE_RISK" name="MMC_SCORE_RISK"><?php if(isset($MMC_SCORE_RISK)) { echo $MMC_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="MMC_PRO_RISK" name="MMC_PRO_RISK"><?php if(isset($MMC_PRO_RISK)) { echo $MMC_PRO_RISK; } ?></textarea>
      </td>  
    </tr>   
    <tr>
      <th scope="row">Adequate Resources</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AR_SUM_RISK" name="AR_SUM_RISK"><?php if(isset($AR_SUM_RISK)) { echo $AR_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="AR_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($AR_COM_RISK) && $AR_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($AR_COM_RISK) && $AR_COM_RISK=='Red') { echo "selected"; } ?>  value="Red">Red</option>
          </select>               
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AR_IMPACT_RISK" name="AR_IMPACT_RISK"><?php if(isset($AR_IMPACT_RISK)) { echo $AR_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AR_SCORE_RISK" name="AR_SCORE_RISK"><?php if(isset($AR_SCORE_RISK)) { echo $AR_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AR_PRO_RISK" name="AR_PRO_RISK"><?php if(isset($AR_PRO_RISK)) { echo $AR_PRO_RISK; } ?></textarea>
      </td>  
    </tr>
        <tr>
      <th scope="row">Training and competency</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TAC_SUM_RISK" name="TAC_SUM_RISK"><?php if(isset($TAC_SUM_RISK)) { echo $TAC_SUM_RISK; } ?></textarea>
      </td>
      <td>
          <select class="form-control" name="TAC_COM_RISK">
              <option value="0">Grade</option>
              <option <?php if(isset($TAC_COM_RISK) && $TAC_COM_RISK=='Green') { echo "selected"; } ?> value="Green">Green</option>
              <option <?php if(isset($TAC_COM_RISK) && $TAC_COM_RISK=='Red') { echo "selected"; } ?> value="Red">Red</option>
          </select>           
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TAC_COM_RISK" name="TAC_IMPACT_RISK"><?php if(isset($TAC_IMPACT_RISK)) { echo $TAC_IMPACT_RISK; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TAC_COM_RISK" name="TAC_SCORE_RISK"><?php if(isset($TAC_SCORE_RISK)) { echo $TAC_SCORE_RISK; } ?></textarea>
      </td> 
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TAC_COM_RISK" name="TAC_PRO_RISK"><?php if(isset($TAC_PRO_RISK)) { echo $TAC_PRO_RISK; } ?></textarea>
      </td>  
    </tr>  
  </tbody>
</table>   
    <button type="submit" class="btn btn-primary form-control">Save Risk Overview</button>
    </form>
        
        
    </div>
    <div class="tab-pane" id="messages" role="tabpanel">
        <form method="POST" action="<?php if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) { echo "php/CAR_MANAGER.php?EXECUTE=3&AGENCY=$AGENCY"; } else { echo "php/CAR.php?EXECUTE=3"; }?>">
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
      
<?php

   $RO_PR_4 = $pdo->prepare("SELECT 
 car_remedial_action_1_tps_srar,
 car_remedial_action_1_tps_tra,
 car_remedial_action_1_tps_oa,
 car_remedial_action_1_tps_dd,
 car_remedial_action_1_tps_id,
 car_remedial_action_1_tps_rd,
 car_remedial_action_1_tps_owner,
 car_remedial_action_1_du_srar,
 car_remedial_action_1_du_tra,
 car_remedial_action_1_du_oa,
 car_remedial_action_1_du_dd,
 car_remedial_action_1_du_id,
 car_remedial_action_1_du_rd,
 car_remedial_action_1_du_owner,
 car_remedial_action_1_dprk_srar,
 car_remedial_action_1_dprk_tra,
 car_remedial_action_1_dprk_oa,
 car_remedial_action_1_dprk_dd,
 car_remedial_action_1_dprk_id,
 car_remedial_action_1_dprk_rd,
 car_remedial_action_1_dprk_owner,
 car_remedial_action_1_sc_srar,
 car_remedial_action_1_sc_tra,
 car_remedial_action_1_sc_oa,
 car_remedial_action_1_sc_dd,
 car_remedial_action_1_sc_id,
 car_remedial_action_1_sc_rd,
 car_remedial_action_1_sc_owner,
 car_remedial_action_1_ch_srar,
 car_remedial_action_1_ch_tra,
 car_remedial_action_1_ch_oa,
 car_remedial_action_1_ch_dd,
 car_remedial_action_1_ch_id,
 car_remedial_action_1_ch_rd,
 car_remedial_action_1_ch_owner
    FROM
    car_remedial_action_1 
    WHERE
     car_remedial_action_1_id_fk =:FK");
                 if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) {
    $RO_PR_4->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_INT);
    } else {
    $RO_PR_4->bindParam(':FK', $COMPANY_ENTITY_ID, PDO::PARAM_INT);
    }
    $RO_PR_4->execute();
    $data5 = $RO_PR_4->fetch(PDO::FETCH_ASSOC); 

if(isset($data5['car_remedial_action_1_tps_srar'])) {
    $TPS_SUM_ACTION=$data5['car_remedial_action_1_tps_srar'];
} 
if(isset($data5['car_remedial_action_1_tps_tra'])) {
    $TPS_TYPE_ACTION=$data5['car_remedial_action_1_tps_tra'];
}
if(isset($data5['car_remedial_action_1_tps_oa'])) {
    $TPS_ON_ACTION=$data5['car_remedial_action_1_tps_oa'];
} 
if(isset($data5['car_remedial_action_1_tps_dd'])) {
    $TPS_DUE_DATE=$data5['car_remedial_action_1_tps_dd'];
}
if(isset($data5['car_remedial_action_1_tps_id'])) {
    $TPS_IMP_DATE=$data5['car_remedial_action_1_tps_id'];
}  
if(isset($data5['car_remedial_action_1_tps_rd'])) {
    $TPS_REVIEW=$data5['car_remedial_action_1_tps_rd'];
}  
if(isset($data5['car_remedial_action_1_tps_owner'])) {
    $TPS_OWNER=$data5['car_remedial_action_1_tps_owner'];
}

if(isset($data5['car_remedial_action_1_du_srar'])) {
    $DU_SUM_ACTION=$data5['car_remedial_action_1_du_srar'];
} 
if(isset($data5['car_remedial_action_1_du_tra'])) {
    $DU_TYPE_ACTION=$data5['car_remedial_action_1_du_tra'];
}
if(isset($data5['car_remedial_action_1_du_oa'])) {
    $DU_ON_ACTION=$data5['car_remedial_action_1_du_oa'];
} 
if(isset($data5['car_remedial_action_1_du_dd'])) {
    $DU_DUE_DATE=$data5['car_remedial_action_1_du_dd'];
}
if(isset($data5['car_remedial_action_1_du_id'])) {
    $DU_IMP_DATE=$data5['car_remedial_action_1_du_id'];
}  
if(isset($data5['car_remedial_action_1_du_rd'])) {
    $DU_REVIEW=$data5['car_remedial_action_1_du_rd'];
}  
if(isset($data5['car_remedial_action_1_du_owner'])) {
    $DU_OWNER=$data5['car_remedial_action_1_du_owner'];
}

if(isset($data5['car_remedial_action_1_dprk_srar'])) {
    $DPRK_SUM_ACTION=$data5['car_remedial_action_1_dprk_srar'];
} 
if(isset($data5['car_remedial_action_1_dprk_tra'])) {
    $DPRK_TYPE_ACTION=$data5['car_remedial_action_1_dprk_tra'];
}
if(isset($data5['car_remedial_action_1_dprk_oa'])) {
    $DPRK_ON_ACTION=$data5['car_remedial_action_1_dprk_oa'];
} 
if(isset($data5['car_remedial_action_1_dprk_dd'])) {
    $DPRK_DUE_DATE=$data5['car_remedial_action_1_dprk_dd'];
}
if(isset($data5['car_remedial_action_1_dprk_id'])) {
    $DPRK_IMP_DATE=$data5['car_remedial_action_1_dprk_id'];
}  
if(isset($data5['car_remedial_action_1_dprk_rd'])) {
    $DPRK_REVIEW=$data5['car_remedial_action_1_dprk_rd'];
}  
if(isset($data5['car_remedial_action_1_dprk_owner'])) {
    $DPRK_OWNER=$data5['car_remedial_action_1_dprk_owner'];
}

if(isset($data5['car_remedial_action_1_sc_srar'])) {
    $SAC_SUM_ACTION=$data5['car_remedial_action_1_sc_srar'];
} 
if(isset($data5['car_remedial_action_1_sc_tra'])) {
    $SAC_TYPE_ACTION=$data5['car_remedial_action_1_sc_tra'];
}
if(isset($data5['car_remedial_action_1_sc_oa'])) {
    $SAC_ON_ACTION=$data5['car_remedial_action_1_sc_oa'];
} 
if(isset($data5['car_remedial_action_1_sc_dd'])) {
    $SAC_DUE_DATE=$data5['car_remedial_action_1_sc_dd'];
}
if(isset($data5['car_remedial_action_1_sc_id'])) {
    $SAC_IMP_DATE=$data5['car_remedial_action_1_sc_id'];
}  
if(isset($data5['car_remedial_action_1_sc_rd'])) {
    $SAC_REVIEW=$data5['car_remedial_action_1_sc_rd'];
}  
if(isset($data5['car_remedial_action_1_sc_owner'])) {
    $SAC_OWNER=$data5['car_remedial_action_1_sc_owner'];
}  

if(isset($data5['car_remedial_action_1_ch_srar'])) {
    $CH_SUM_ACTION=$data5['car_remedial_action_1_ch_srar'];
} 
if(isset($data5['car_remedial_action_1_ch_tra'])) {
    $CH_TYPE_ACTION=$data5['car_remedial_action_1_ch_tra'];
}
if(isset($data5['car_remedial_action_1_ch_oa'])) {
    $CH_ON_ACTION=$data5['car_remedial_action_1_ch_oa'];
} 
if(isset($data5['car_remedial_action_1_ch_dd'])) {
    $CH_DUE_DATE=$data5['car_remedial_action_1_ch_dd'];
}
if(isset($data5['car_remedial_action_1_ch_id'])) {
    $CH_IMP_DATE=$data5['car_remedial_action_1_ch_id'];
}  
if(isset($data5['car_remedial_action_1_ch_rd'])) {
    $CH_REVIEW=$data5['car_remedial_action_1_ch_rd'];
}  
if(isset($data5['car_remedial_action_1_ch_owner'])) {
    $CH_OWNER=$data5['car_remedial_action_1_ch_owner'];
}  
?>
      
    <tr>
      <th scope="row">TPS screening</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TPS_SUM_ACTION" name="TPS_SUM_ACTION"><?php if(isset($TPS_SUM_ACTION)) { echo $TPS_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TPS_TYPE_ACTION" name="TPS_TYPE_ACTION"><?php if(isset($TPS_TYPE_ACTION)) { echo $TPS_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TPS_ON_ACTION" name="TPS_ON_ACTION"><?php if(isset($TPS_ON_ACTION)) { echo $TPS_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="TPS_DUE_DATE" name="TPS_DUE_DATE" value="<?php if(isset($TPS_DUE_DATE)) { echo $TPS_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="TPS_IMP_DATE" name="TPS_IMP_DATE" value="<?php if(isset($TPS_IMP_DATE)) { echo $TPS_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="TPS_REVIEW" name="TPS_REVIEW" value="<?php if(isset($TPS_REVIEW)) { echo $TPS_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TPS_OWNER" name="TPS_OWNER"><?php if(isset($TPS_OWNER)) { echo $TPS_OWNER; } ?></textarea>
      </td>        
    </tr>
    <tr>
      <th scope="row">Due diligence</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DU_SUM_ACTION" name="DU_SUM_ACTION"><?php if(isset($DU_SUM_ACTION)) { echo $DU_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DU_TYPE_ACTION" name="DU_TYPE_ACTION"><?php if(isset($DU_TYPE_ACTION)) { echo $DU_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DU_ON_ACTION" name="DU_ON_ACTION"><?php if(isset($DU_ON_ACTION)) { echo $DU_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="DU_DUE_DATE" name="DU_DUE_DATE" value="<?php if(isset($DU_DUE_DATE)) { echo $DU_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="DU_IMP_DATE" name="DU_IMP_DATE" value="<?php if(isset($DU_IMP_DATE)) { echo $DU_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="DU_REVIEW" name="DU_REVIEW" value="<?php if(isset($DU_REVIEW)) { echo $DU_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DU_OWNER" name="DU_OWNER"><?php if(isset($DU_OWNER)) { echo $DU_OWNER; } ?></textarea>
      </td>       
    </tr>
    <tr>
      <th scope="row">Data protection and recording keeping</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DPRK_SUM_ACTION" name="DPRK_SUM_ACTION"><?php if(isset($DPRK_SUM_ACTION)) { echo $DPRK_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DPRK_TYPE_ACTION" name="DPRK_TYPE_ACTION"><?php if(isset($DPRK_TYPE_ACTION)) { echo $DPRK_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DPRK_ON_ACTION" name="DPRK_ON_ACTION"><?php if(isset($DPRK_ON_ACTION)) { echo $DPRK_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="DPRK_DUE_DATE" name="DPRK_DUE_DATE" value="<?php if(isset($DPRK_DUE_DATE)) { echo $DPRK_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="DPRK_IMP_DATE" name="DPRK_IMP_DATE" value="<?php if(isset($DPRK_IMP_DATE)) { echo $DPRK_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="DPRK_REVIEW" name="DPRK_REVIEW" value="<?php if(isset($DPRK_REVIEW)) { echo $DPRK_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="DPRK_OWNER" name="DPRK_OWNER"><?php if(isset($DPRK_OWNER)) { echo $DPRK_OWNER; } ?></textarea>
      </td>     
    </tr>
    <tr>
      <th scope="row">Systems and controls</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="SAC_SUM_ACTION" name="SAC_SUM_ACTION"><?php if(isset($SAC_SUM_ACTION)) { echo $SAC_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="SAC_TYPE_ACTION" name="SAC_TYPE_ACTION"><?php if(isset($SAC_TYPE_ACTION)) { echo $SAC_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="SAC_ON_ACTION" name="SAC_ON_ACTION"><?php if(isset($SAC_ON_ACTION)) { echo $SAC_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="SAC_DUE_DATE" name="SAC_DUE_DATE" value="<?php if(isset($SAC_DUE_DATE)) { echo $SAC_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="SAC_IMP_DATE" name="SAC_IMP_DATE" value="<?php if(isset($SAC_IMP_DATE)) { echo $SAC_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="SAC_REVIEW" name="SAC_REVIEW" value="<?php if(isset($SAC_REVIEW)) { echo $SAC_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="SAC_OWNER" name="SAC_OWNER"><?php if(isset($SAC_OWNER)) { echo $SAC_OWNER; } ?></textarea>
      </td>  
    </tr>       
    <tr>
      <th scope="row">Complaints handling</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CH_SUM_ACTION" name="CH_SUM_ACTION"><?php if(isset($CH_SUM_ACTION)) { echo $CH_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CH_TYPE_ACTION" name="CH_TYPE_ACTION"><?php if(isset($CH_TYPE_ACTION)) { echo $CH_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CH_ON_ACTION" name="CH_ON_ACTION"><?php if(isset($CH_ON_ACTION)) { echo $CH_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="CH_DUE_DATE" name="CH_DUE_DATE" value="<?php if(isset($CH_DUE_DATE)) { echo $CH_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="CH_IMP_DATE" name="CH_IMP_DATE" value="<?php if(isset($CH_IMP_DATE)) { echo $CH_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="CH_REVIEW" name="CH_REVIEW" value="<?php if(isset($CH_REVIEW)) { echo $CH_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CH_OWNER" name="CH_OWNER"><?php if(isset($CH_OWNER)) { echo $CH_OWNER; } ?></textarea>
      </td>   
    </tr>   
 
<?php

   $RO_PR_5 = $pdo->prepare("SELECT 
 car_remedial_action_2_vc_srar,
 car_remedial_action_2_vc_tra,
 car_remedial_action_2_vc_oa,
 car_remedial_action_2_vc_dd,
 car_remedial_action_2_vc_id,
 car_remedial_action_2_vc_rd,
 car_remedial_action_2_vc_owner,
 car_remedial_action_2_cru_srar,
 car_remedial_action_2_cru_tra,
 car_remedial_action_2_cru_oa,
 car_remedial_action_2_cru_dd,
 car_remedial_action_2_cru_id,
 car_remedial_action_2_cru_rd,
 car_remedial_action_2_cru_owner,
 car_remedial_action_2_pci_srar,
 car_remedial_action_2_pci_tra,
 car_remedial_action_2_pci_oa,
 car_remedial_action_2_pci_dd,
 car_remedial_action_2_pci_id,
 car_remedial_action_2_pci_rd,
 car_remedial_action_2_pci_owner,
 car_remedial_action_2_as_srar,
 car_remedial_action_2_as_tra,
 car_remedial_action_2_as_oa,
 car_remedial_action_2_as_dd,
 car_remedial_action_2_as_id,
 car_remedial_action_2_as_rd,
 car_remedial_action_2_as_owner,
 car_remedial_action_2_rfa_srar,
 car_remedial_action_2_rfa_tra,
 car_remedial_action_2_rfa_oa,
 car_remedial_action_2_rfa_dd,
 car_remedial_action_2_rfa_id,
 car_remedial_action_2_rfa_rd,
 car_remedial_action_2_rfa_owner
    FROM
    car_remedial_action_2
    WHERE
     car_remedial_action_2_id_fk =:FK");
    if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) {
    $RO_PR_5->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_INT);
    } else {
    $RO_PR_5->bindParam(':FK', $COMPANY_ENTITY_ID, PDO::PARAM_INT);
    }
    $RO_PR_5->execute();
    $data6 = $RO_PR_5->fetch(PDO::FETCH_ASSOC); 
    
if(isset($data6['car_remedial_action_2_vc_srar'])) {
    $VC_SUM_ACTION=$data6['car_remedial_action_2_vc_srar'];
} 
if(isset($data6['car_remedial_action_2_vc_tra'])) {
    $VC_TYPE_ACTION=$data6['car_remedial_action_2_vc_tra'];
}
if(isset($data6['car_remedial_action_2_vc_oa'])) {
    $VC_ON_ACTION=$data6['car_remedial_action_2_vc_oa'];
} 
if(isset($data6['car_remedial_action_2_vc_dd'])) {
    $VC_DUE_DATE=$data6['car_remedial_action_2_vc_dd'];
}
if(isset($data6['car_remedial_action_2_vc_id'])) {
    $VC_IMP_DATE=$data6['car_remedial_action_2_vc_id'];
}  
if(isset($data6['car_remedial_action_2_vc_rd'])) {
    $VC_REVIEW=$data6['car_remedial_action_2_vc_rd'];
}  
if(isset($data6['car_remedial_action_2_vc_owner'])) {
    $VC_OWNER=$data6['car_remedial_action_2_vc_owner'];
}    

if(isset($data6['car_remedial_action_2_cru_srar'])) {
    $CRU_SUM_ACTION=$data6['car_remedial_action_2_cru_srar'];
} 
if(isset($data6['car_remedial_action_2_cru_tra'])) {
    $CRU_TYPE_ACTION=$data6['car_remedial_action_2_cru_tra'];
}
if(isset($data6['car_remedial_action_2_cru_oa'])) {
    $CRU_ON_ACTION=$data6['car_remedial_action_2_cru_oa'];
} 
if(isset($data6['car_remedial_action_2_cru_dd'])) {
    $CRU_DUE_DATE=$data6['car_remedial_action_2_cru_dd'];
}
if(isset($data6['car_remedial_action_2_cru_id'])) {
    $CRU_IMP_DATE=$data6['car_remedial_action_2_cru_id'];
}  
if(isset($data6['car_remedial_action_2_cru_rd'])) {
    $CRU_REVIEW=$data6['car_remedial_action_2_cru_rd'];
}  
if(isset($data6['car_remedial_action_2_cru_owner'])) {
    $CRU_OWNER=$data6['car_remedial_action_2_cru_owner'];
}

if(isset($data6['car_remedial_action_2_pci_srar'])) {
    $PCI_SUM_ACTION=$data6['car_remedial_action_2_pci_srar'];
} 
if(isset($data6['car_remedial_action_2_pci_tra'])) {
    $PCI_TYPE_ACTION=$data6['car_remedial_action_2_pci_tra'];
}
if(isset($data6['car_remedial_action_2_pci_oa'])) {
    $PCI_ON_ACTION=$data6['car_remedial_action_2_pci_oa'];
} 
if(isset($data6['car_remedial_action_2_pci_dd'])) {
    $PCI_DUE_DATE=$data6['car_remedial_action_2_pci_dd'];
}
if(isset($data6['car_remedial_action_2_pci_id'])) {
    $PCI_IMP_DATE=$data6['car_remedial_action_2_pci_id'];
}  
if(isset($data6['car_remedial_action_2_pci_rd'])) {
    $PCI_REVIEW=$data6['car_remedial_action_2_pci_rd'];
}  
if(isset($data6['car_remedial_action_2_pci_owner'])) {
    $PCI_OWNER=$data6['car_remedial_action_2_pci_owner'];
}

if(isset($data6['car_remedial_action_2_as_srar'])) {
    $AS_SUM_ACTION=$data6['car_remedial_action_2_as_srar'];
} 
if(isset($data6['car_remedial_action_2_as_tra'])) {
    $AS_TYPE_ACTION=$data6['car_remedial_action_2_as_tra'];
}
if(isset($data6['car_remedial_action_2_as_oa'])) {
    $AS_ON_ACTION=$data6['car_remedial_action_2_as_oa'];
} 
if(isset($data6['car_remedial_action_2_as_dd'])) {
    $AS_DUE_DATE=$data6['car_remedial_action_2_as_dd'];
}
if(isset($data6['car_remedial_action_2_as_id'])) {
    $AS_IMP_DATE=$data6['car_remedial_action_2_as_id'];
}  
if(isset($data6['car_remedial_action_2_as_rd'])) {
    $AS_REVIEW=$data6['car_remedial_action_2_as_rd'];
}  
if(isset($data6['car_remedial_action_2_as_owner'])) {
    $AS_OWNER=$data6['car_remedial_action_2_as_owner'];
}

if(isset($data6['car_remedial_action_2_rfa_srar'])) {
    $RFA_SUM_ACTION=$data6['car_remedial_action_2_rfa_srar'];
} 
if(isset($data6['car_remedial_action_2_rfa_tra'])) {
    $RFA_TYPE_ACTION=$data6['car_remedial_action_2_rfa_tra'];
}
if(isset($data6['car_remedial_action_2_rfa_oa'])) {
    $RFA_ON_ACTION=$data6['car_remedial_action_2_rfa_oa'];
} 
if(isset($data6['car_remedial_action_2_rfa_dd'])) {
    $RFA_DUE_DATE=$data6['car_remedial_action_2_rfa_dd'];
}
if(isset($data6['car_remedial_action_2_rfa_id'])) {
    $RFA_IMP_DATE=$data6['car_remedial_action_2_rfa_id'];
}  
if(isset($data6['car_remedial_action_2_rfa_rd'])) {
    $RFA_REVIEW=$data6['car_remedial_action_2_rfa_rd'];
}  
if(isset($data6['car_remedial_action_2_rfa_owner'])) {
    $RFA_OWNER=$data6['car_remedial_action_2_rfa_owner'];
}   
?>
    
    <tr>
      <th scope="row">Vulnerable customers</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="VC_SUM_ACTION" name="VC_SUM_ACTION"><?php if(isset($VC_SUM_ACTION)) { echo $VC_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="VC_TYPE_ACTION" name="VC_TYPE_ACTION"><?php if(isset($VC_TYPE_ACTION)) { echo $VC_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="VC_ON_ACTION" name="VC_ON_ACTION"><?php if(isset($VC_ON_ACTION)) { echo $VC_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="VC_DUE_DATE" name="VC_DUE_DATE" value="<?php if(isset($VC_DUE_DATE)) { echo $VC_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="VC_IMP_DATE" name="VC_IMP_DATE" value="<?php if(isset($VC_IMP_DATE)) { echo $VC_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="VC_REVIEW" name="VC_REVIEW" value="<?php if(isset($VC_REVIEW)) { echo $VC_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="VC_OWNER" name="VC_OWNER"><?php if(isset($VC_OWNER)) { echo $VC_OWNER; } ?></textarea>
      </td>    
    </tr>
    <tr>
      <th scope="row">Consent relied upon</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CRU_SUM_ACTION" name="CRU_SUM_ACTION"><?php if(isset($CRU_SUM_ACTION)) { echo $CRU_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CRU_TYPE_ACTION" name="CRU_TYPE_ACTION"><?php if(isset($CRU_TYPE_ACTION)) { echo $CRU_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CRU_ON_ACTION" name="CRU_ON_ACTION"><?php if(isset($CRU_ON_ACTION)) { echo $CRU_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="CRU_DUE_DATE" name="CRU_DUE_DATE" value="<?php if(isset($CRU_DUE_DATE)) { echo $CRU_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="CRU_IMP_DATE" name="CRU_IMP_DATE" value="<?php if(isset($CRU_IMP_DATE)) { echo $CRU_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="CRU_REVIEW" name="CRU_REVIEW" value="<?php if(isset($CRU_REVIEW)) { echo $CRU_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="CRU_OWNER" name="CRU_OWNER"><?php if(isset($CRU_OWNER)) { echo $CRU_OWNER; } ?></textarea>
      </td>    
    </tr>      
    <tr>
      <th scope="row">PCI Compliance</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="PCI_SUM_ACTION" name="PCI_SUM_ACTION"><?php if(isset($PCI_SUM_ACTION)) { echo $PCI_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="PCI_TYPE_ACTION" name="PCI_TYPE_ACTION"><?php if(isset($PCI_TYPE_ACTION)) { echo $PCI_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="PCI_ON_ACTION" name="PCI_ON_ACTION"><?php if(isset($PCI_ON_ACTION)) { echo $PCI_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="PCI_DUE_DATE" name="PCI_DUE_DATE" value="<?php if(isset($PCI_DUE_DATE)) { echo $PCI_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="PCI_IMP_DATE" name="PCI_IMP_DATE" value="<?php if(isset($PCI_IMP_DATE)) { echo $PCI_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="PCI_REVIEW" name="PCI_REVIEW" value="<?php if(isset($PCI_REVIEW)) { echo $PCI_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="PCI_OWNER" name="PCI_OWNER"><?php if(isset($PCI_OWNER)) { echo $PCI_OWNER; } ?></textarea>
      </td>   
    </tr>
    <tr>
      <th scope="row">Advised sales</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AS_SUM_ACTION" name="AS_SUM_ACTION"><?php if(isset($AS_SUM_ACTION)) { echo $AS_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AS_TYPE_ACTION" name="AS_TYPE_ACTION"><?php if(isset($AS_TYPE_ACTION)) { echo $AS_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AS_ON_ACTION" name="AS_ON_ACTION"><?php if(isset($AS_ON_ACTION)) { echo $AS_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="AS_DUE_DATE" name="AS_DUE_DATE" value="<?php if(isset($AS_DUE_DATE)) { echo $AS_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="AS_IMP_DATE" name="AS_IMP_DATE" value="<?php if(isset($AS_IMP_DATE)) { echo $AS_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="AS_REVIEW" name="AS_REVIEW" value="<?php if(isset($AS_REVIEW)) { echo $AS_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AS_OWNER" name="AS_OWNER"><?php if(isset($AS_OWNER)) { echo $AS_OWNER; } ?></textarea>
      </td>    
    </tr>      
    <tr>
      <th scope="row">Referrals to a Financial Advisor</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="RFA_SUM_ACTION" name="RFA_SUM_ACTION"><?php if(isset($RFA_SUM_ACTION)) { echo $RFA_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="RFA_TYPE_ACTION" name="RFA_TYPE_ACTION"><?php if(isset($RFA_TYPE_ACTION)) { echo $RFA_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="RFA_ON_ACTION" name="RFA_ON_ACTION"><?php if(isset($RFA_ON_ACTION)) { echo $RFA_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="RFA_DUE_DATE" name="RFA_DUE_DATE" value="<?php if(isset($RFA_DUE_DATE)) { echo $RFA_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="RFA_IMP_DATE" name="RFA_IMP_DATE" value="<?php if(isset($RFA_IMP_DATE)) { echo $RFA_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="RFA_REVIEW" name="RFA_REVIEW" value="<?php if(isset($RFA_REVIEW)) { echo $RFA_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="RFA_OWNER" name="RFA_OWNER"><?php if(isset($RFA_OWNER)) { echo $RFA_OWNER; } ?></textarea>
      </td>   
    </tr>
    
<?php

   $RO_PR_6 = $pdo->prepare("SELECT 
 car_remedial_action_3_mmc_srar,
 car_remedial_action_3_mmc_tra,
 car_remedial_action_3_mmc_oa,
 car_remedial_action_3_mmc_dd,
 car_remedial_action_3_mmc_id,
 car_remedial_action_3_mmc_rd,
 car_remedial_action_3_mmc_owner,
 car_remedial_action_3_ar_srar,
 car_remedial_action_3_ar_tra,
 car_remedial_action_3_ar_oa,
 car_remedial_action_3_ar_dd,
 car_remedial_action_3_ar_id,
 car_remedial_action_3_ar_rd,
 car_remedial_action_3_ar_owner,
 car_remedial_action_3_tc_srar,
 car_remedial_action_3_tc_tra,
 car_remedial_action_3_tc_oa,
 car_remedial_action_3_tc_dd,
 car_remedial_action_3_tc_id,
 car_remedial_action_3_tc_rd,
 car_remedial_action_3_tc_owner    
 FROM
 car_remedial_action_3
    WHERE
     car_remedial_action_3_id_fk =:FK");
       if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) {
    $RO_PR_6->bindParam(':FK', $AGENCY_ENTITY_ID, PDO::PARAM_INT);
    } else {
    $RO_PR_6->bindParam(':FK', $COMPANY_ENTITY_ID, PDO::PARAM_INT);
    }
    $RO_PR_6->execute();
    $data7 = $RO_PR_6->fetch(PDO::FETCH_ASSOC); 
    
if(isset($data7['car_remedial_action_3_mmc_srar'])) {
    $MMC_SUM_ACTION=$data7['car_remedial_action_3_mmc_srar'];
} 
if(isset($data7['car_remedial_action_3_mmc_tra'])) {
    $MMC_TYPE_ACTION=$data7['car_remedial_action_3_mmc_tra'];
}
if(isset($data7['car_remedial_action_3_mmc_oa'])) {
    $MMC_ON_ACTION=$data7['car_remedial_action_3_mmc_oa'];
} 
if(isset($data7['car_remedial_action_3_mmc_dd'])) {
    $MMC_DUE_DATE=$data7['car_remedial_action_3_mmc_dd'];
}  
if(isset($data7['car_remedial_action_3_mmc_id'])) {
    $MMC_IMP_DATE=$data7['car_remedial_action_3_mmc_id'];
}  
if(isset($data7['car_remedial_action_3_mmc_rd'])) {
    $MMC_REVIEW=$data7['car_remedial_action_3_mmc_rd'];
}   
if(isset($data7['car_remedial_action_3_mmc_owner'])) {
    $MMC_OWNER=$data7['car_remedial_action_3_mmc_owner'];
}

if(isset($data7['car_remedial_action_3_ar_srar'])) {
    $AR_SUM_ACTION=$data7['car_remedial_action_3_ar_srar'];
} 
if(isset($data7['car_remedial_action_3_ar_tra'])) {
    $AR_TYPE_ACTION=$data7['car_remedial_action_3_ar_tra'];
}
if(isset($data7['car_remedial_action_3_ar_oa'])) {
    $AR_ON_ACTION=$data7['car_remedial_action_3_ar_oa'];
} 
if(isset($data7['car_remedial_action_3_ar_dd'])) {
    $AR_DUE_DATE=$data7['car_remedial_action_3_ar_dd'];
}  
if(isset($data7['car_remedial_action_3_ar_id'])) {
    $AR_IMP_DATE=$data7['car_remedial_action_3_ar_id'];
}  
if(isset($data7['car_remedial_action_3_ar_rd'])) {
    $AR_REVIEW=$data7['car_remedial_action_3_ar_rd'];
}   
if(isset($data7['car_remedial_action_3_ar_owner'])) {
    $AR_OWNER=$data7['car_remedial_action_3_ar_owner'];
}

if(isset($data7['car_remedial_action_3_tc_srar'])) {
    $TAC_SUM_ACTION=$data7['car_remedial_action_3_tc_srar'];
} 
if(isset($data7['car_remedial_action_3_tc_tra'])) {
    $TAC_TYPE_ACTION=$data7['car_remedial_action_3_tc_tra'];
}
if(isset($data7['car_remedial_action_3_tc_oa'])) {
    $TAC_ON_ACTION=$data7['car_remedial_action_3_tc_oa'];
} 
if(isset($data7['car_remedial_action_3_tc_dd'])) {
    $TAC_DUE_DATE=$data7['car_remedial_action_3_tc_dd'];
}  
if(isset($data7['car_remedial_action_3_tc_id'])) {
    $TAC_IMP_DATE=$data7['car_remedial_action_3_tc_id'];
}  
if(isset($data7['car_remedial_action_3_tc_rd'])) {
    $TAC_REVIEW=$data7['car_remedial_action_3_tc_rd'];
}   
if(isset($data7['car_remedial_action_3_tc_owner'])) {
    $TAC_OWNER=$data7['car_remedial_action_3_tc_owner'];
}
    
    ?>
    
    <tr>
      <th scope="row">Misleading marketing content</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="MMC_SUM_ACTION" name="MMC_SUM_ACTION"><?php if(isset($MMC_SUM_ACTION)) { echo $MMC_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="MMC_TYPE_ACTION" name="MMC_TYPE_ACTION"><?php if(isset($MMC_TYPE_ACTION)) { echo $MMC_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="MMC_ON_ACTION" name="MMC_ON_ACTION"><?php if(isset($MMC_ON_ACTION)) { echo $MMC_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="MMC_DUE_DATE" name="MMC_DUE_DATE" value="<?php if(isset($MMC_DUE_DATE)) { echo $MMC_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="MMC_IMP_DATE" name="MMC_IMP_DATE" value="<?php if(isset($MMC_IMP_DATE)) { echo $MMC_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="MMC_REVIEW" name="MMC_REVIEW" value="<?php if(isset($MMC_REVIEW)) { echo $MMC_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="MMC_OWNER" name="MMC_OWNER"><?php if(isset($MMC_OWNER)) { echo $MMC_OWNER; } ?></textarea>
      </td>     
    </tr>   
    <tr>
      <th scope="row">Adequate Resources</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AR_SUM_ACTION" name="AR_SUM_ACTION"><?php if(isset($AR_SUM_ACTION)) { echo $AR_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AR_TYPE_ACTION" name="AR_TYPE_ACTION"><?php if(isset($AR_TYPE_ACTION)) { echo $AR_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AR_ON_ACTION" name="AR_ON_ACTION"><?php if(isset($AR_ON_ACTION)) { echo $AR_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="AR_DUE_DATE" name="AR_DUE_DATE" value="<?php if(isset($AR_DUE_DATE)) { echo $AR_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="AR_IMP_DATE" name="AR_IMP_DATE" value="<?php if(isset($AR_IMP_DATE)) { echo $AR_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="AR_REVIEW" name="AR_REVIEW" value="<?php if(isset($AR_REVIEW)) { echo $AR_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="AR_OWNER" name="AR_OWNER"><?php if(isset($AR_OWNER)) { echo $AR_OWNER; } ?></textarea>
      </td>     
    </tr>
        <tr>
      <th scope="row">Training and competency</th>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TAC_SUM_ACTION" name="TAC_SUM_ACTION"><?php if(isset($TAC_SUM_ACTION)) { echo $TAC_SUM_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TAC_TYPE_ACTION" name="TAC_TYPE_ACTION"><?php if(isset($TAC_TYPE_ACTION)) { echo $TAC_TYPE_ACTION; } ?></textarea>
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TAC_ON_ACTION" name="TAC_ON_ACTION"><?php if(isset($TAC_ON_ACTION)) { echo $TAC_ON_ACTION; } ?></textarea>
      </td>
      <td>
          <input type="text" class="form-control" id="TAC_DUE_DATE" name="TAC_DUE_DATE" value="<?php if(isset($TAC_DUE_DATE)) { echo $TAC_DUE_DATE; } ?>">
      </td> 
      <td>
          <input type="text" class="form-control" id="TAC_IMP_DATE" name="TAC_IMP_DATE" value="<?php if(isset($TAC_IMP_DATE)) { echo $TAC_IMP_DATE; } ?>">
      </td>
      <td>
          <input type="text" class="form-control" id="TAC_REVIEW" name="TAC_REVIEW" value="<?php if(isset($TAC_REVIEW)) { echo $TAC_REVIEW; } ?>">
      </td>
      <td>
         <textarea onkeyup="textAreaAdjust(this)" class="form-control" id="TAC_OWNER" name="TAC_OWNER"><?php if(isset($TAC_OWNER)) { echo $TAC_OWNER; } ?></textarea>
      </td>     
    </tr>  
  </tbody>
</table>      
                <button type="submit" class="btn btn-primary form-control">Save Risk Overview</button>

        </form>  
        
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
    <script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
    </script>
              <script type="text/javascript">
                                textAreaAdjust(document.getElementById("DIRECTOR_INFO"));
                                textAreaAdjust(document.getElementById("BUSINESS_OVERVIEW"));
                                textAreaAdjust(document.getElementById("GOV_STRAT_OVERVIEW"));
                                textAreaAdjust(document.getElementById("CLIENT_ACQ_OVERVIEW"));
                                textAreaAdjust(document.getElementById("CLIENT_ENG_OVERVIEW"));
                                textAreaAdjust(document.getElementById("SER_DEL_OVERVIEW"));
                                textAreaAdjust(document.getElementById("TRN_COM_OVERVIEW"));
                                textAreaAdjust(document.getElementById("DATA_PRO_ARR_OVERVIEW"));
                                textAreaAdjust(document.getElementById("COMP_HAN_OVERVIEW"));
                            </script> 
        <script>$('#myTab a[href="#profile"]').tab('show') // Select tab by name
$('#myTab a:first').tab('show') // Select first tab
$('#myTab a:last').tab('show') // Select last tab
$('#myTab li:eq(2) a').tab('show') // Select third tab (0-indexed)</script>
</body>
</html>
