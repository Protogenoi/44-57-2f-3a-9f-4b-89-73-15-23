                            <table  class='table table-hover table-condensed'>
                                <thead>
                                    <tr>
                                        <th colspan='7'>Royal London</th>
                                    </tr>
                                <th>Comm Date</th>
                                <th>Policy</th>
                                <th>Commission Type</th>
                                <th>Policy Status</th>
                                <th>Closer</th>
                                <th>Lead</th>
                                <th>Credit</th>
                                <th>Debits</th>
                                </thead>
                                
    <?php foreach ($RLtransList as $RL_TRANS): ?>


        <?php
        
                                    if (isset($RL_TRANS['POLID'])) {

                                        $PID = $RL_TRANS['POLID'];
                                    }

                                    echo '<tr>';
                                    echo "<td>" . $RL_TRANS['royal_london_financial_uploaded_date'] . "</td>";
                                    echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $RL_TRANS['policy_number'] . "</a></td>";
                                    echo "<td>" . $RL_TRANS['royal_london_financial_commission_type'] . "</td>";
                                    echo "<td>" . $RL_TRANS['policystatus'] . "</td>";
                                    echo "<td>" . $RL_TRANS['closer'] . "</td>";
                                    echo "<td>" . $RL_TRANS['lead'] . "</td>";
                                    if (intval($RL_TRANS['royal_london_financial_commission_credit_amount']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $RL_TRANS['royal_london_financial_commission_credit_amount'] . "</span></td>";
                                    } else if (intval($RL_TRANS["royal_london_financial_commission_credit_amount"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $RL_TRANS['royal_london_financial_commission_credit_amount'] . "</span></td>";
                                    } else {
                                        echo "<td><span class=\"label label-default\">" . $RL_TRANS['royal_london_financial_commission_credit_amount'] . "</span></td>";
                                    }
                                    if (intval($RL_TRANS['royal_london_financial_commission_debits_amount']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $RL_TRANS['royal_london_financial_commission_debits_amount'] . "</span></td>";
                                    } else if (intval($RL_TRANS["royal_london_financial_commission_debits_amount"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $RL_TRANS['royal_london_financial_commission_debits_amount'] . "</span></td>";
                                    } else {
                                        echo "<td><span class=\"label label-default\">" . $RL_TRANS['royal_london_financial_commission_debits_amount'] . "</span></td>";
                                    }                                    
                                    echo "</tr>";
                                    echo "\n";
                                
        ?>


    <?php endforeach ?>
</table> 