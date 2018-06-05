
    <?php foreach ($WOL_TotalExpectedWithDatesList as $WOL_TotalExpectedWithDatesList_Resuts): ?>


        <?php
                $WOL_EXPECTED_WITH_DATES_COMMISSION = $WOL_TotalExpectedWithDatesList_Resuts['commission'];
                
                            $WOL_simply_EXPECTED_SUM = ($simply_biz / 100) * $WOL_EXPECTED_WITH_DATES_COMMISSION;
                            $WOL_ADL_EXPECTED_SUM = $WOL_EXPECTED_WITH_DATES_COMMISSION - $WOL_simply_EXPECTED_SUM;
                            
                            $WOL_ADL_EXPECTED_SUM_DATES_FORMAT = number_format($WOL_EXPECTED_WITH_DATES_COMMISSION, 2);
                            $WOL_simply_EXPECTED_SUM_FORMAT = number_format($WOL_simply_EXPECTED_SUM, 2);
                            $WOL_ADL_EXPECTED_SUM_FORMAT = number_format($WOL_ADL_EXPECTED_SUM, 2);
                            
                        ?>

    <?php endforeach ?>
