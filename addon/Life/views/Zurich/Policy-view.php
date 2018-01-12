<?php foreach ($ZURICH_POLList as $ZURICH_POL_VARS):
                                        $ZURICH_POL_LOC = $ZURICH_POL_VARS['file'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$ZURICH_POL_LOC")) {
                                            ?>
                                            <a href="/uploads/<?php echo $ZURICH_POL_LOC; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Zurich Policy</a>
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $ZURICH_POL_LOC; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Zurich Policy</a>
                                            <?php
                                        }
      
      endforeach ?>