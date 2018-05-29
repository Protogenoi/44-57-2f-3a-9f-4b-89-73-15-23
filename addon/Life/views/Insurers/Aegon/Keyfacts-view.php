<?php foreach ($AEG_KFList as $AEG_KF_VARS):

                                            $AEG_KF_LOCATION = $AEG_KF_VARS['file'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$AEG_KF_LOCATION")) {
                                            ?>
                                            <a href="/uploads/<?php echo $AEG_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Aegon Keyfacts</a> 
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $AEG_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Aegon Keyfacts</a> 
                                            <?php
                                        }
      
      endforeach ?>