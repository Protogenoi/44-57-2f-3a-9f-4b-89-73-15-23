
    <?php foreach ($TotalExpectedWithDatesList as $TotalExpectedWithDatesList_Resuts): ?>


        <?php
                $EXPECTED_WITH_DATES_COMMISSION = $TotalExpectedWithDatesList_Resuts['commission'];
                
                            $simply_EXPECTED_SUM = ($simply_biz / 100) * $EXPECTED_WITH_DATES_COMMISSION;
                            $ADL_EXPECTED_SUM = $EXPECTED_WITH_DATES_COMMISSION - $simply_EXPECTED_SUM;
                            
                            $ADL_EXPECTED_SUM_DATES_FORMAT = number_format($EXPECTED_WITH_DATES_COMMISSION, 2);
                            $simply_EXPECTED_SUM_FORMAT = number_format($simply_EXPECTED_SUM, 2);
                            $ADL_EXPECTED_SUM_FORMAT = number_format($ADL_EXPECTED_SUM, 2);
                            
                        ?>

    <?php endforeach ?>
