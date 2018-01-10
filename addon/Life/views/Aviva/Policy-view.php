<?php foreach ($AVI_POLList as $AVI_POL_VARS):
                                        $AVI_POL_LOC = $AVI_POL_VARS['file'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$AVI_POL_LOC")) {
                                            ?>
                                            <a href="/uploads/<?php echo $AVI_POL_LOC; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Aviva Policy</a>
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $AVI_POL_LOC; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Aviva Policy</a>
                                            <?php
                                        }
      
      endforeach ?>