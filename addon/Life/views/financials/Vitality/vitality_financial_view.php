                            <table  class='table table-hover table-condensed'>
                                <thead>
                                    <tr>
                                        <th colspan='7'>Vitality (new)</th>
                                    </tr>
                                <th>Comm Date</th>
                                <th>Policy</th>
                                <th>Commission Type</th>
                                <th>Policy Status</th>
                                <th>Closer</th>
                                <th>Lead</th>
                                <th>Amount</th>
                                </thead>
                                
    <?php foreach ($VIT_NEW_TRANList as $VIT_NEW_TRAN_VAR): ?>


        <?php
        
                                    if (isset($VIT_NEW_TRAN_VAR['POLID'])) {

                                        $PID = $VIT_NEW_TRAN_VAR['POLID'];
                                    }

                                    echo '<tr>';
                                    echo "<td>" . $VIT_NEW_TRAN_VAR['vitality_financial_uploaded_date'] . "</td>";
                                    echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $VIT_NEW_TRAN_VAR['adl_policy_ref'] . "</a></td>";
                                    echo "<td>" . $VIT_NEW_TRAN_VAR['vitality_policy_type'] . "</td>";
                                    echo "<td>" . $VIT_NEW_TRAN_VAR['adl_policy_status'] . "</td>";
                                    echo "<td>" . $VIT_NEW_TRAN_VAR['adl_policy_closer'] . "</td>";
                                    echo "<td>" . $VIT_NEW_TRAN_VAR['adl_policy_agent'] . "</td>";
                                    if (intval($VIT_NEW_TRAN_VAR['vitality_financial_amount']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $VIT_NEW_TRAN_VAR['vitality_financial_amount'] . "</span></td>";
                                    } else if (intval($VIT_NEW_TRAN_VAR["vitality_financial_amount"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $VIT_NEW_TRAN_VAR['vitality_financial_amount'] . "</span></td>";
                                    } else {
                                        echo "<td>" . $VIT_NEW_TRAN_VAR['vitality_financial_amount'] . "</td>";
                                    }
                                    echo "</tr>";
                                    echo "\n";
                                
        ?>


    <?php endforeach ?>
</table> 