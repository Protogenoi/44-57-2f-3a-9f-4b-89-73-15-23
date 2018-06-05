
    <?php foreach ($ZURICH_TotalExpectedWithDatesList as $ZURICH_TotalExpectedWithDatesList_Resuts): ?>


        <?php
                $ZURICH_EXPECTED_WITH_DATES_COMMISSION = $ZURICH_TotalExpectedWithDatesList_Resuts['commission'];
                
                            $ZURICH_simply_EXPECTED_SUM = ($simply_biz / 100) * $ZURICH_EXPECTED_WITH_DATES_COMMISSION;
                            $ZURICH_ADL_EXPECTED_SUM = $ZURICH_EXPECTED_WITH_DATES_COMMISSION - $ZURICH_simply_EXPECTED_SUM;
                            
                            $ZURICH_ADL_EXPECTED_SUM_DATES_FORMAT = number_format($ZURICH_EXPECTED_WITH_DATES_COMMISSION, 2);
                            $ZURICH_simply_EXPECTED_SUM_FORMAT = number_format($ZURICH_simply_EXPECTED_SUM, 2);
                            $ZURICH_ADL_EXPECTED_SUM_FORMAT = number_format($ZURICH_ADL_EXPECTED_SUM, 2);
                            
                        ?>

    <?php endforeach ?>
