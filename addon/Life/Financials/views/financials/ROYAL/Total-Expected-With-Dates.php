
    <?php foreach ($RL_TotalExpectedWithDatesList as $RL_TotalExpectedWithDatesList_Resuts): ?>


        <?php
                $RL_EXPECTED_WITH_DATES_COMMISSION = $RL_TotalExpectedWithDatesList_Resuts['commission'];
                
                            $RL_simply_EXPECTED_SUM = ($simply_biz / 100) * $RL_EXPECTED_WITH_DATES_COMMISSION;
                            $RL_ADL_EXPECTED_SUM = $RL_EXPECTED_WITH_DATES_COMMISSION - $RL_simply_EXPECTED_SUM;
                            
                            $RL_ADL_EXPECTED_SUM_DATES_FORMAT = number_format($RL_EXPECTED_WITH_DATES_COMMISSION, 2);
                            $RL_simply_EXPECTED_SUM_FORMAT = number_format($RL_simply_EXPECTED_SUM, 2);
                            $RL_ADL_EXPECTED_SUM_FORMAT = number_format($RL_ADL_EXPECTED_SUM, 2);
                            
                        ?>

    <?php endforeach ?>
