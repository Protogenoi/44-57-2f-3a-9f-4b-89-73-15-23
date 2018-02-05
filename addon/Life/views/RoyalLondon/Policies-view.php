<table id="ClientListTable" class="table table-hover">
    <thead>
        <tr>
            <th colspan='7'>Royal London Policies</th>
        </tr>
        <tr>
            <th>Client</th>
            <th>Policy</th>
            <th>Type</th>
            <th>Comm Type</th>
            <th>Term</th>
            <th>Premium</th>
            <th>Cover</th>
            <th>Status</th>
            <th colspan="2">Financials</th>
            <th colspan="4">Options</th>
        </tr>
    </thead> 
    <?php foreach ($RLPoliciesList as $RL_Policies): ?>


        <?php
        $PID = $RL_Policies['id'];
        $polref = $RL_Policies['policy_number'];
        $polcap[] = $RL_Policies['id'];
        $POL_HOLDER = $RL_Policies['client_name'];
        
        if(empty($Old_Policies['covera'])) {
            $Old_Policies['covera']=0;
        }        
        
        $COVER_AMOUNT = number_format($RL_Policies['covera'],2);

        echo '<tr>';
        echo "<td>$POL_HOLDER</td>";
        if (empty($polref)) {
            echo "<td>TBC</td>";
        } else {
            echo "<td><form target='_blank' action='#' method='post'><input type='hidden' value='$polref'><input type='hidden' name='searchCriteria.referenceType' id='searchCriteria.referenceType' value='B'><input type='hidden' name='searchCriteria.includeLife' value='true' ><button type='submit' value='Search' name='command' class='btn btn-default btn-sm'><i class='fa fa-search'></i> $polref</button></form></td>";
        }
        echo "<td>" . $RL_Policies['type'] . "</td>";
        echo "<td>" . $RL_Policies['CommissionType'] . "</td>";
        echo "<td>" . $RL_Policies['polterm'] . "</td>";
        echo "<td>£" . $RL_Policies['premium'] . "</td>";
        echo "<td>£$COVER_AMOUNT</td>";

        if ($RL_Policies['PolicyStatus'] == 'CLAWBACK' || ['PolicyStatus'] == 'CLAWBACK-LAPSE' || $RL_Policies['PolicyStatus'] == 'Declined') {
            echo "<td><span class=\"label label-danger\">" . $RL_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($RL_Policies['PolicyStatus'] == 'PENDING' || $RL_Policies['PolicyStatus'] == 'Live Awaiting Policy Number' || $RL_Policies['PolicyStatus'] == 'Awaiting Policy Number') {
            echo "<td><span class=\"label label-warning\">" . $RL_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($RL_Policies['PolicyStatus'] == 'SUBMITTED-LIVE' || $RL_Policies['PolicyStatus'] == 'Live') {
            echo "<td><span class=\"label label-success\">" . $RL_Policies['PolicyStatus'] . "</span></td>";
        } else {
            echo "<td><span class=\"label label-default\">" . $RL_Policies['PolicyStatus'] . "</span></td>";
        }
            
        if ($RL_Policies['royal_london_financial_commission_credit_amount'] > 0.00) {
            
            echo "<td><span class='label label-success'>PAID</span> </td>";
            
        } else {

            echo "<td> </td>";
        }
        
        if ($RL_Policies['royal_london_financial_commission_debits_amount'] > 0.00) {
            
            echo "<td><span class='label label-danger'>CLAWBACK</span> </td>";
            
        } else {

            echo "<td> </td>";
        }

        echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY' class='btn btn-info btn-xs'><i class='fa fa-eye'></i> </a></td>";
        echo "<td><a href='/addon/Life/EditPolicy.php?id=$PID&search=$search&name=$POL_HOLDER' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> </a></td>";

            if (in_array($hello_name, $Level_10_Access, true)) {


                echo "<td>
                                                                                        <form method='POST' action='/app/admin/deletepolicy.php?DeleteLifePolicy=1'>
                                                                                        <input type='hidden' id='policyID' name='policyID' value='$PID'>
                                                                                            <button type='submit' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span> </button>
                                                                                            </form>
                                                                                            </td>";
            }
        echo "</tr>";
        ?>


    <?php endforeach ?>
</table> 