<?php foreach ($LV_KFList as $LV_KF_VARS):

                                            $LV_KF_LOCATION = $LV_KF_VARS['file'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$LV_KF_LOCATION")) {
                                            ?>
                                            <a href="/uploads/<?php echo $LV_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="far fa-file-pdf"></i> LV Keyfacts</a> 
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $LV_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="far fa-file-pdf"></i> LV Keyfacts</a> 
                                            <?php
                                        }
      
      endforeach ?>