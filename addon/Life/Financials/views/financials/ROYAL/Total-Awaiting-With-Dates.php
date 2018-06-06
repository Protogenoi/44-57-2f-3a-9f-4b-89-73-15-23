
    <?php foreach ($RL_TotalAwaitingWithDatesList as $RL_TotalAwaitingWithDatesList_Resuts): ?>


        <?php
                $AWAITING_WITH_DATES_COMMISSION = $RL_TotalAwaitingWithDatesList_Resuts['commission'];
                
                            $simply_AWAITING_SUM = ($simply_biz / 100) * $AWAITING_WITH_DATES_COMMISSION;
                            $RL_ADL_AWAITING_SUM = $AWAITING_WITH_DATES_COMMISSION - $simply_AWAITING_SUM;
                            
                            $RL_ADL_AWAITING_SUM_DATES_FORMAT = number_format($AWAITING_WITH_DATES_COMMISSION, 2);
                            $simply_AWAITING_SUM_FORMAT = number_format($simply_AWAITING_SUM, 2);
                            $RL_ADL_AWAITING_SUM_FORMAT = number_format($RL_ADL_AWAITING_SUM, 2);
                            
                        ?>

    <?php endforeach ?>
