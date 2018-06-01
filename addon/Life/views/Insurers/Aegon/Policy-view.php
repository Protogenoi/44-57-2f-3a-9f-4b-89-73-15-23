<?php foreach ($AEG_POLList as $AEG_POL_VARS):
                                        $AEG_POL_LOC = $AEG_POL_VARS['file'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$AEG_POL_LOC")) {
                                            ?>
                                            <a href="/uploads/<?php echo $AEG_POL_LOC; ?>" target="_blank" class="btn btn-default"><i class="far fa-file-pdf"></i> Aegon Policy</a>
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $AEG_POL_LOC; ?>" target="_blank" class="btn btn-default"><i class="far fa-file-pdf"></i> Aegon Policy</a>
                                            <?php
                                        }
      
      endforeach ?>