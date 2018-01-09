
    <?php foreach ($TotalMissingWithDatesList as $TotalMissingWithDatesList_Resuts): ?>


        <?php
                $MISSING_WITH_DATES_COMMISSION = $TotalMissingWithDatesList_Resuts['commission'];
                
                                            $simply_MISSING_SUM = ($simply_biz / 100) * $MISSING_WITH_DATES_COMMISSION;
                            $ADL_MISSING_SUM = $MISSING_WITH_DATES_COMMISSION - $simply_MISSING_SUM;
                            
                            $ADL_MISSING_SUM_DATES_FORMAT = number_format($MISSING_WITH_DATES_COMMISSION, 2);
                            $simply_MISSING_SUM_FORMAT = number_format($simply_MISSING_SUM, 2);
                            $ADL_MISSING_SUM_FORMAT = number_format($ADL_MISSING_SUM, 2);
                            
                        ?>

    <?php endforeach ?>
