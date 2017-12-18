                            <table  class='table table-hover table-condensed'>
                                <thead>
                                    <tr>
                                        <th colspan='7'>Vitality</th>
                                    </tr>
                                <th>Comm Date</th>
                                <th>Policy</th>
                                <th>Commission Type</th>
                                <th>Policy Status</th>
                                <th>Closer</th>
                                <th>Lead</th>
                                <th>Amount</th>
                                </thead>
                                
    <?php foreach ($VITtransList as $VIT_TRANS): ?>


        <?php
        
                                    if (isset($VIT_TRANS['POLID'])) {

                                        $PID = $VIT_TRANS['POLID'];
                                    }

                                    echo '<tr>';
                                    echo "<td>" . $VIT_TRANS['financials_insert'] . "</td>";
                                    echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $VIT_TRANS['policy_number'] . "</a></td>";
                                    echo "<td>" . $VIT_TRANS['type'] . "</td>";
                                    echo "<td>" . $VIT_TRANS['policystatus'] . "</td>";
                                    echo "<td>" . $VIT_TRANS['closer'] . "</td>";
                                    echo "<td>" . $VIT_TRANS['lead'] . "</td>";
                                    if (intval($VIT_TRANS['financials_payment']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $VIT_TRANS['financials_payment'] . "</span></td>";
                                    } else if (intval($VIT_TRANS["financials_payment"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $VIT_TRANS['financials_payment'] . "</span></td>";
                                    } else {
                                        echo "<td>" . $VIT_TRANS['financials_payment'] . "</td>";
                                    }
                                    echo "</tr>";
                                    echo "\n";
                                
        ?>


    <?php endforeach ?>
</table> 