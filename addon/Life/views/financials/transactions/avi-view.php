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
                                
    <?php foreach ($AVItransList as $AVI_TRANS): ?>


        <?php
        
                                    if (isset($AVI_TRANS['POLID'])) {

                                        $PID = $AVI_TRANS['POLID'];
                                    }

                                    echo '<tr>';
                                    echo "<td>" . $AVI_TRANS['financials_insert'] . "</td>";
                                    echo "<td><a href='ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $AVI_TRANS['policy_number'] . "</a></td>";
                                    echo "<td>" . $AVI_TRANS['type'] . "</td>";
                                    echo "<td>" . $AVI_TRANS['policystatus'] . "</td>";
                                    echo "<td>" . $AVI_TRANS['closer'] . "</td>";
                                    echo "<td>" . $AVI_TRANS['lead'] . "</td>";
                                    if (intval($AVI_TRANS['financials_payment']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $AVI_TRANS['financials_payment'] . "</span></td>";
                                    } else if (intval($AVI_TRANS["financials_payment"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $AVI_TRANS['financials_payment'] . "</span></td>";
                                    } else {
                                        echo "<td>" . $AVI_TRANS['financials_payment'] . "</td>";
                                    }
                                    echo "</tr>";
                                    echo "\n";
                                
        ?>


    <?php endforeach ?>
</table> 