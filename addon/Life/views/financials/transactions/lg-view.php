                            <table  class='table table-hover table-condensed'>
                                <thead>
                                    <tr>
                                        <th colspan='7'>Legal and General</th>
                                    </tr>
                                <th>Comm Date</th>
                                <th>Policy</th>
                                <th>Commission Type</th>
                                <th>Policy Status</th>
                                <th>Closer</th>
                                <th>Lead</th>
                                <th>Amount</th>
                                </thead>
                                
    <?php foreach ($LGtransList as $LG_TRANS): ?>


        <?php
        
        if (isset($LG_TRANS['POLID'])) {
            $PID = $LG_TRANS['POLID'];
            
        }

                                    echo '<tr>';
                                    echo "<td>" . $LG_TRANS['insert_date'] . "</td>";
                                    echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $LG_TRANS['Policy'] . "</a></td>";
                                    echo "<td>" . $LG_TRANS['CommissionType'] . "</td>";
                                    echo "<td>" . $LG_TRANS['policystatus'] . "</td>";
                                    echo "<td>" . $LG_TRANS['closer'] . "</td>";
                                    echo "<td>" . $LG_TRANS['lead'] . "</td>";
                                    if (intval($LG_TRANS['Payment_Amount']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $LG_TRANS['Payment_Amount'] . "</span></td>";
                                    } else if (intval($LG_TRANS["Payment_Amount"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $LG_TRANS['Payment_Amount'] . "</span></td>";
                                    } else {
                                        echo "<td>" . $LG_TRANS['Payment_Amount'] . "</td>";
                                    }
                                    echo "</tr>";
                                    echo "\n";
                                
        ?>


    <?php endforeach ?>
</table> 