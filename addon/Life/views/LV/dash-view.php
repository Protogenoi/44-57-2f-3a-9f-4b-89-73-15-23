<?php foreach ($LV_DASHList as $LV_DASH_VARS):
                                        $LV_DASH_LOC = $LV_DASH_VARS['application_number'];

                                        if (file_exists(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/addon/Insurers/LV/dashboard/$LV_DASH_LOC")) {
                                            ?>
                                            <a href="/addon/Insurers/LV/dashboard/<?php echo $LV_DASH_LOC; ?>" target="_blank" class="btn btn-info"><i class="fa fa-folder-open"></i> ADL LV</a>
                                        <?php }
      endforeach ?>