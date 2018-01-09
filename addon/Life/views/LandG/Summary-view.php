<?php foreach ($LG_SUMList as $LG_SUM_VARS):
    
                                        $LG_POL_SUM_LOC = $LG_SUM_VARS['file'];
                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$LG_POL_SUM_LOC")) {
                                            ?>
                                            <a href="/uploads/<?php echo $LG_POL_SUM_LOC; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> L&G Policy Summary</a>
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $LG_POL_SUM_LOC; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> L&G Policy Summary</a>
                                            <?php
                                        }
      
      endforeach ?>