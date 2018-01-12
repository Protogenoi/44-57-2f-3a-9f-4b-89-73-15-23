<?php foreach ($ZURICH_KFList as $ZURICH_KF_VARS):

                                            $ZURICH_KF_LOCATION = $ZURICH_KF_VARS['file'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$ZURICH_KF_LOCATION")) {
                                            ?>
                                            <a href="/uploads/<?php echo $ZURICH_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Zurich Keyfacts</a> 
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $ZURICH_KF_LOCATION; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Zurich Keyfacts</a> 
                                            <?php
                                        }
      
      endforeach ?>