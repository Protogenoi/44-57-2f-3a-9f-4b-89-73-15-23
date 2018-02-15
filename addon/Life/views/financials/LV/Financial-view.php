                            <table  class='table table-hover table-condensed'>
                                <thead>
                                    <tr>
                                        <th colspan='7'>LV</th>
                                    </tr>
                                <th>Comm Date</th>
                                <th>Policy</th>
                                <th>Commission Type</th>
                                <th>Policy Status</th>
                                <th>Closer</th>
                                <th>Lead</th>
                                <th>Amount</th>
                                </thead>
                                
    <?php foreach ($LVtransList as $LV_TRANS): ?>


        <?php
        
                                    if (isset($LV_TRANS['POLID'])) {

                                        $PID = $LV_TRANS['POLID'];
                                    }

                                    echo '<tr>';
                                    echo "<td>" . $LV_TRANS['lv_financial_uploaded_date'] . "</td>";
                                    echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $LV_TRANS['policy_number'] . "</a></td>";
                                    echo "<td>" . $LV_TRANS['lv_financial_type'] . "</td>";
                                    echo "<td>" . $LV_TRANS['policystatus'] . "</td>";
                                    echo "<td>" . $LV_TRANS['closer'] . "</td>";
                                    echo "<td>" . $LV_TRANS['lead'] . "</td>";
                                    if (intval($LV_TRANS['lv_financial_indemnity']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $LV_TRANS['lv_financial_indemnity'] . "</span></td>";
                                    } else if (intval($LV_TRANS["lv_financial_indemnity"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $LV_TRANS['lv_financial_indemnity'] . "</span></td>";
                                    } else {
                                        echo "<td><span class=\"label label-default\">" . $LV_TRANS['lv_financial_indemnity'] . "</span></td>";
                                    }                                  
                                    echo "</tr>";
                                    echo "\n";
                                
        ?>


    <?php endforeach ?>
</table> 