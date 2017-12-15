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

                                    echo '<tr>';
                                    echo "<td>" . $WOL_TRANS['financials_insert'] . "</td>";
                                    echo "<td><a href='ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $WOL_TRANS['policy_number'] . "</a></td>";
                                    echo "<td>" . $WOL_TRANS['type'] . "</td>";
                                    echo "<td>" . $WOL_TRANS['policystatus'] . "</td>";
                                    echo "<td>" . $WOL_TRANS['closer'] . "</td>";
                                    echo "<td>" . $WOL_TRANS['lead'] . "</td>";
                                    if (intval($WOL_TRANS['financials_payment']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $WOL_TRANS['financials_payment'] . "</span></td>";
                                    } else if (intval($WOL_TRANS["financials_payment"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $WOL_TRANS['financials_payment'] . "</span></td>";
                                    } else {
                                        echo "<td>" . $WOL_TRANS['financials_payment'] . "</td>";
                                    }
                                    echo "</tr>";
                                    echo "\n";
                                
        ?>


    <?php endforeach ?>
</table> 