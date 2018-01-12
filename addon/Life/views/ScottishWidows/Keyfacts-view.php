<?php foreach ($SW_KFList as $SW_KF_VARS):

                                            $SW_KF_LOCATION = $SW_KF_VARS['file'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$SW_KF_LOCATION")) {
                                            ?>
                                            <a href="/uploads/<?php echo $SW_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Scottish Widows Keyfacts</a> 
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $SW_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Scottish Widows Keyfacts</a> 
                                            <?php
                                        }
      
      endforeach ?>