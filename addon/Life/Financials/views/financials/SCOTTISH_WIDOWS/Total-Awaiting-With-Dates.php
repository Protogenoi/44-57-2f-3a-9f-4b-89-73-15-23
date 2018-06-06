
    <?php foreach ($SCOTTISH_WIDOWS_TotalAwaitingWithDatesList as $SCOTTISH_WIDOWS_TotalAwaitingWithDatesList_Resuts): ?>


        <?php
                $AWAITING_WITH_DATES_COMMISSION = $SCOTTISH_WIDOWS_TotalAwaitingWithDatesList_Resuts['commission'];
                
                            $simply_AWAITING_SUM = ($simply_biz / 100) * $AWAITING_WITH_DATES_COMMISSION;
                            $SW_ADL_AWAITING_SUM = $AWAITING_WITH_DATES_COMMISSION - $simply_AWAITING_SUM;
                            
                            $SW_ADL_AWAITING_SUM_DATES_FORMAT = number_format($AWAITING_WITH_DATES_COMMISSION, 2);
                            $simply_AWAITING_SUM_FORMAT = number_format($simply_AWAITING_SUM, 2);
                            $SW_ADL_AWAITING_SUM_FORMAT = number_format($SW_ADL_AWAITING_SUM, 2);
                            
                        ?>

    <?php endforeach ?>
