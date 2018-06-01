                            <table  class='table table-hover table-condensed'>
                                <thead>
                                    <tr>
                                        <th colspan='7'>Aviva</th>
                                    </tr>
                                <th>Comm Date</th>
                                <th>Policy</th>
                                <th>Commission Type</th>
                                <th>Policy Status</th>
                                <th>Closer</th>
                                <th>Lead</th>
                                <th>Amount</th>
                                </thead>
                                
    <?php foreach ($AVIVA_transList as $AVIVA_TRANS): ?>

    <?php
                                    if (isset($AVIVA_TRANS['POLID'])) {

                                        $PID = $AVIVA_TRANS['POLID'];
                                    }

                                    echo '<tr>';
                                    echo "<td>" . $AVIVA_TRANS['aviva_financial_uploaded_date'] . "</td>";
                                    echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $AVIVA_TRANS['policy_number'] . "</a></td>";
                                    echo "<td>" . $AVIVA_TRANS['aviva_financial_type'] . "</td>";
                                    echo "<td>" . $AVIVA_TRANS['policystatus'] . "</td>";
                                    echo "<td>" . $AVIVA_TRANS['closer'] . "</td>";
                                    echo "<td>" . $AVIVA_TRANS['lead'] . "</td>";
                                    if (intval($AVIVA_TRANS['aviva_financial_amount']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $AVIVA_TRANS['aviva_financial_amount'] . "</span></td>";
                                    } else if (intval($AVIVA_TRANS["aviva_financial_amount"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $AVIVA_TRANS['aviva_financial_amount'] . "</span></td>";
                                    } else {
                                        echo "<td><span class=\"label label-default\">" . $AVIVA_TRANS['aviva_financial_amount'] . "</span></td>";
                                    }                                   
                                    echo "</tr>";
                                    echo "\n";
                                
        ?>

    <?php endforeach ?>
</table> 