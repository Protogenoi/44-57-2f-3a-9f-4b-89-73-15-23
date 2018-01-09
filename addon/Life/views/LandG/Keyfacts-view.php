<?php foreach ($LG_KFList as $LG_KF_VARS):

                                            $LG_KF_LOCATION = $LG_KF_VARS['file'];
                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$LG_KF_LOCATION")) {
                                            ?>
                                            <a href="/uploads/<?php echo $LG_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> L&G Keyfacts</a> 
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $LG_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> L&G Keyfacts</a> 
                                            <?php
                                        }
      
      endforeach ?>