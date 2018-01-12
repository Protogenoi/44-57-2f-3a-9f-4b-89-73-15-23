<?php foreach ($SW_POLList as $SW_POL_VARS):
                                        $SW_POL_LOC = $SW_POL_VARS['file'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/$SW_POL_LOC")) {
                                            ?>
                                            <a href="/uploads/<?php echo $SW_POL_LOC; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Scottish Widows Policy</a>
                                        <?php } else { ?>
                                            <a href="/uploads/life/<?php echo $search; ?>/<?php echo $SW_POL_LOC; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Scottish Widows Policy</a>
                                            <?php
                                        }
      
      endforeach ?>