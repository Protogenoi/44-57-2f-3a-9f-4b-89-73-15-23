
    <?php foreach ($AVI_TotalExpectedWithDatesList as $AVI_TotalExpectedWithDatesList_Resuts): ?>


        <?php
                $AVI_EXPECTED_WITH_DATES_COMMISSION = $AVI_TotalExpectedWithDatesList_Resuts['commission'];
                
                            $AVI_simply_EXPECTED_SUM = ($simply_biz / 100) * $AVI_EXPECTED_WITH_DATES_COMMISSION;
                            $AVI_ADL_EXPECTED_SUM = $AVI_EXPECTED_WITH_DATES_COMMISSION - $AVI_simply_EXPECTED_SUM;
                            
                            $AVI_ADL_EXPECTED_SUM_DATES_FORMAT = number_format($AVI_EXPECTED_WITH_DATES_COMMISSION, 2);
                            $AVI_simply_EXPECTED_SUM_FORMAT = number_format($AVI_simply_EXPECTED_SUM, 2);
                            $AVI_ADL_EXPECTED_SUM_FORMAT = number_format($AVI_ADL_EXPECTED_SUM, 2);
                            
                        ?>

    <?php endforeach ?>
