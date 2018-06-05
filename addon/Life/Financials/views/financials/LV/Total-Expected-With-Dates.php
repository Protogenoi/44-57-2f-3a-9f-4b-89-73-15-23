
    <?php foreach ($LV_TotalExpectedWithDatesList as $LV_TotalExpectedWithDatesList_Resuts): ?>


        <?php
                $LV_EXPECTED_WITH_DATES_COMMISSION = $LV_TotalExpectedWithDatesList_Resuts['commission'];
                
                            $LV_simply_EXPECTED_SUM = ($simply_biz / 100) * $LV_EXPECTED_WITH_DATES_COMMISSION;
                            $LV_ADL_EXPECTED_SUM = $LV_EXPECTED_WITH_DATES_COMMISSION - $LV_simply_EXPECTED_SUM;
                            
                            $LV_ADL_EXPECTED_SUM_DATES_FORMAT = number_format($LV_EXPECTED_WITH_DATES_COMMISSION, 2);
                            $LV_simply_EXPECTED_SUM_FORMAT = number_format($LV_simply_EXPECTED_SUM, 2);
                            $LV_ADL_EXPECTED_SUM_FORMAT = number_format($LV_ADL_EXPECTED_SUM, 2);
                            
                        ?>

    <?php endforeach ?>
