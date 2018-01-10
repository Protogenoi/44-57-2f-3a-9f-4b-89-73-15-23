<?php foreach ($AVI_KFList as $AVI_KF_VARS):

                                            $AVI_KF_LOCATION = $AVI_KF_VARS['file'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$AVI_KF_LOCATION")) {
                                            ?>
                                            <a href="/uploads/<?php echo $AVI_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Aviva Keyfacts</a> 
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $AVI_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Aviva Keyfacts</a> 
                                            <?php
                                        }
      
      endforeach ?>