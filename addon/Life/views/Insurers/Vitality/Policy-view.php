<?php foreach ($VIT_POLList as $VIT_POL_VARS):
                                        $VIT_POL_LOC = $VIT_POL_VARS['file'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$VIT_POL_LOC")) {
                                            ?>
                                            <a href="/uploads/<?php echo $VIT_POL_LOC; ?>" target="_blank" class="btn btn-default"><i class="far fa-file-pdf"></i> Vitality Policy</a>
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $VIT_POL_LOC; ?>" target="_blank" class="btn btn-default"><i class="far fa-file-pdf"></i> Vitality Policy</a>
                                            <?php
                                        }
      
      endforeach ?>