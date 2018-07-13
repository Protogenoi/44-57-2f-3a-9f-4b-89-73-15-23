<table id="ClientListTable" class="table table-hover">
    <thead>
        <tr>
            <th colspan='7'>Aviva Policies</th>
        </tr>
        <tr>
            <th>Client</th>
            <th>Policy</th>
            <th>AN</th>
            <th>Type</th>
            <th>Comm</th>
            <th>Term</th>
            <th>Premium</th>
            <th>Cover</th>
            <th>Status</th>
            <th>Financial</th>
            <th colspan="4">Options</th>
        </tr>
    </thead> 
    <?php foreach ($AvivaPoliciesList as $Aviva_Policies): ?>


        <?php
        $PID = $Aviva_Policies['id'];
        $polref = $Aviva_Policies['policy_number'];
        $polcap[] = $Aviva_Policies['id'];
        $POL_HOLDER = $Aviva_Policies['client_name'];
        $APP_NUMBER = $Aviva_Policies['application_number'];

        $COVER_AMOUNT = number_format($Aviva_Policies['covera'],2);

        echo '<tr>';
        echo "<td>$POL_HOLDER</td>";
        if (empty($polref)) {
            echo "<td>TBC</td>";
        } else {
            echo "<td><button type='submit' value='Search' name='command' class='btn btn-default btn-sm'><i class='fa fa-search'></i> $polref</button></td>";
        }
        echo "<td>$APP_NUMBER</td>";
        echo "<td>" . $Aviva_Policies['type'] . "</td>";
        echo "<td>" . $Aviva_Policies['CommissionType'] . "</td>";
        echo "<td>" . $Aviva_Policies['polterm'] . "</td>";
        echo "<td>£" . $Aviva_Policies['premium'] . "</td>";
        echo "<td>£$COVER_AMOUNT</td>";

        if ($Aviva_Policies['PolicyStatus'] == 'CLAWBACK' || ['PolicyStatus'] == 'CLAWBACK-LAPSE' || $Aviva_Policies['PolicyStatus'] == 'Declined') {
            echo "<td><span class=\"label label-danger\">" . $Aviva_Policies['PolicyStatus'] . "</span></td>";
        } 
        
        elseif ($Aviva_Policies['PolicyStatus'] == 'PENDING' || $Aviva_Policies['PolicyStatus'] == 'Live Awaiting Policy Number' || $Aviva_Policies['PolicyStatus'] == 'Awaiting Policy Number') {
            echo "<td><span class=\"label label-warning\">" . $Aviva_Policies['PolicyStatus'] . "</span></td>";
        }
        
        elseif ($Aviva_Policies['PolicyStatus'] == 'SUBMITTED-LIVE' || $Aviva_Policies['PolicyStatus'] == 'Live') {
            echo "<td><span class=\"label label-success\">" . $Aviva_Policies['PolicyStatus'] . "</span></td>";
        } 
        
        else {
            echo "<td><span class=\"label label-default\">" . $Aviva_Policies['PolicyStatus'] . "</span></td>";
        }
      

        if (($Aviva_Policies['aviva_financial_amount'])) {
            echo "<td><span class='label label-success'>On Financials</span> </td>";
        } else {

            echo "<td><span class='label label-warning'>Pending</span></td>";
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