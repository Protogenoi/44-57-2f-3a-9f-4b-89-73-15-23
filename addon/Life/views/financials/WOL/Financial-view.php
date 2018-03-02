                            <table  class='table table-hover table-condensed'>
                                <thead>
                                    <tr>
                                        <th colspan='7'>One Family</th>
                                    </tr>
                                <th>Comm Date</th>
                                <th>Policy</th>
                                <th>Commission Type</th>
                                <th>Policy Status</th>
                                <th>Closer</th>
                                <th>Lead</th>
                                <th>Amount</th>
                                </thead>
                                
    <?php foreach ($WOLtransList as $WOL_TRANS): ?>


        <?php
        
                                    if (isset($WOL_TRANS['POLID'])) {

                                        $PID = $WOL_TRANS['POLID'];
                                    }
                                    
        if($WOL_TRANS['one_family_financial_transaction_type'] == 'BACS_OUT') {
            
$PAYMENT_AMOUNT=abs($WOL_TRANS['one_family_financial_commission_amount']);            
            
        }   elseif($WOL_TRANS['one_family_financial_transaction_type'] =='INTCOMCB') {
            
            $PAYMENT_AMOUNT=$WOL_TRANS['one_family_financial_commission_amount'];
            
        }   else {
            
        $PAYMENT_AMOUNT=$WOL_TRANS['one_family_financial_commission_amount'];    
            
        }                      

                                    echo '<tr>';
                                    echo "<td>" . $WOL_TRANS['one_family_financial_uploaded_date'] . "</td>";
                                    echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $WOL_TRANS['policy_number'] . "</a></td>";
                                    echo "<td>" . $WOL_TRANS['one_family_financial_transaction_type'] . "</td>";
                                    echo "<td>" . $WOL_TRANS['policystatus'] . "</td>";
                                    echo "<td>" . $WOL_TRANS['closer'] . "</td>";
                                    echo "<td>" . $WOL_TRANS['lead'] . "</td>";
                                    if (intval($PAYMENT_AMOUNT) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $PAYMENT_AMOUNT . "</span></td>";
                                    } else if (intval($PAYMENT_AMOUNT) < 0) {
                                        echo "<td><span class=\"label label-danger\">$PAYMENT_AMOUNT</span></td>";
                                    } else {
                                        echo "<td><span class=\"label label-default\">$PAYMENT_AMOUNT</span></td>";
                                    }                                  
                                    echo "</tr>";
                                    echo "\n";
                                
        ?>

    <?php endforeach ?>
</table> 