<?php foreach ($VI_KFList as $VI_KF_VARS):

                                            $VI_KF_LOCATION = $VI_KF_VARS['file'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$VI_KF_LOCATION")) {
                                            ?>
                                            <a href="/uploads/<?php echo $VI_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="far fa-file-pdf"></i> Vitality Keyfacts</a> 
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $VI_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="far fa-file-pdf"></i> Vitality Keyfacts</a> 
                                            <?php
                                        }
      
      endforeach ?>