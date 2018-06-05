
    <?php foreach ($SCOTTISH_WIDOWS_TotalExpectedWithDatesList as $SCOTTISH_WIDOWS_TotalExpectedWithDatesList_Resuts): ?>


        <?php
                $SW_EXPECTED_WITH_DATES_COMMISSION = $SCOTTISH_WIDOWS_TotalExpectedWithDatesList_Resuts['commission'];
                
                            $SW_simply_EXPECTED_SUM = ($simply_biz / 100) * $SW_EXPECTED_WITH_DATES_COMMISSION;
                            $SW_ADL_EXPECTED_SUM = $SW_EXPECTED_WITH_DATES_COMMISSION - $SW_simply_EXPECTED_SUM;
                            
                            $SW_ADL_EXPECTED_SUM_DATES_FORMAT = number_format($SW_EXPECTED_WITH_DATES_COMMISSION, 2);
                            $SW_simply_EXPECTED_SUM_FORMAT = number_format($SW_simply_EXPECTED_SUM, 2);
                            $SW_ADL_EXPECTED_SUM_FORMAT = number_format($SW_ADL_EXPECTED_SUM, 2);
                            
                        ?>

    <?php endforeach ?>
