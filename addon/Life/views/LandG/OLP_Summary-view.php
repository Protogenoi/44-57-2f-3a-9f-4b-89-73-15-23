<?php foreach ($OLP_SUMList as $OLP_SUM_VARS):
    
    $POL_LOCATION = substr($OLP_SUM_VARS['policy_number'], 0, 9);
    $POL_NORMAL=$OLP_SUM_VARS['policy_number'];
    
    if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/LG/PolSummary/$POL_LOCATION")) { ?>
<a target="_blank" class="btn btn-default" href='/uploads/LG/PolSummary/<?php echo $POL_LOCATION; ?>' > <i class='fa fa-folder-open'></i> LG Summary (<?php echo "<strong>$POL_LOCATION</strong>"; ?>)</a>
      <?php  } 
      if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/LG/OLPSummary/$POL_NORMAL")) { ?>
<a target="_blank" class="btn btn-default" href='/uploads/LG/OLPSummary/<?php echo $POL_NORMAL; ?>' > <i class='fa fa-folder-open-o'></i> OLP Status (<?php echo "<strong>$POL_NORMAL</strong>"; ?>)</a>
      <?php  }
      if (file_exists("/uploads/LG/OLPSummary/$POL_NORMAL")) { ?>
<a target="_blank" class="btn btn-default" href='/uploads/LG/OLPSummary/<?php echo $POL_NORMAL; ?>' > <i class='fa fa-folder-open-o'></i> OLP Status (<?php echo "<strong>$POL_NORMAL</strong>"; ?>)</a>
      <?php  } ?>
   <a target="_blank" class="btn btn-default" href='/uploads/LG/OLPSummary/<?php echo $POL_NORMAL; ?>' > <i class='fa fa-folder-open-o'></i> OLP Status (<?php echo "<strong>$POL_NORMAL</strong>"; ?>)</a>
   <?php
      endforeach ?>