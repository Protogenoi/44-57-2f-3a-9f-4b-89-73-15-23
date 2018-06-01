<?php foreach ($LV_POLList as $LV_POL_VARS):
                                        $LV_POL_LOC = $LV_POL_VARS['file'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$LV_POL_LOC")) {
                                            ?>
                                            <a href="/uploads/<?php echo $LV_POL_LOC; ?>" target="_blank" class="btn btn-default"><i class="far fa-file-pdf"></i> LV Policy</a>
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $LV_POL_LOC; ?>" target="_blank" class="btn btn-default"><i class="far fa-file-pdf"></i> LV Policy</a>
                                            <?php
                                        }
      
      endforeach ?>