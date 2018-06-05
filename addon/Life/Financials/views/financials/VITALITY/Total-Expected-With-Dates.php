
    <?php foreach ($TotalExpectedWithDatesList as $TotalExpectedWithDatesList_Resuts): ?>


        <?php
                $VIT_EXPECTED_WITH_DATES_COMMISSION = $TotalExpectedWithDatesList_Resuts['commission'];
                
                            $VIT_simply_EXPECTED_SUM = ($simply_biz / 100) * $VIT_EXPECTED_WITH_DATES_COMMISSION;
                            $VIT_ADL_EXPECTED_SUM = $VIT_EXPECTED_WITH_DATES_COMMISSION - $VIT_simply_EXPECTED_SUM;
                            
                            $VIT_ADL_EXPECTED_SUM_DATES_FORMAT = number_format($VIT_EXPECTED_WITH_DATES_COMMISSION, 2);
                            $VIT_simply_EXPECTED_SUM_FORMAT = number_format($VIT_simply_EXPECTED_SUM, 2);
                            $VIT_ADL_EXPECTED_SUM_FORMAT = number_format($VIT_ADL_EXPECTED_SUM, 2);
                            
                        ?>

    <?php endforeach ?>
