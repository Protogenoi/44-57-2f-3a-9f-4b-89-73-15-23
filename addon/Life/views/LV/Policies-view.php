<table id="ClientListTable" class="table table-hover">
    <thead>
        <tr>
            <th colspan='7'>LV Policies</th>
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
            <th>EWS</th>
            <th>Financial</th>
            <th colspan="3">Options</th>
        </tr>
    </thead> 
    <?php foreach ($LVPoliciesList as $LV_Policies): ?>


        <?php
        $PID = $LV_Policies['id'];
        $polref = $LV_Policies['policy_number'];
        $polcap[] = $LV_Policies['id'];
        $POL_HOLDER = $LV_Policies['client_name'];
        $LV_MODAL_APP = $LV_Policies['application_number'];
        
        if(empty($Old_Policies['covera'])) {
            $Old_Policies['covera']=0;
        }        
        
        $COVER_AMOUNT = number_format($LV_Policies['covera'],2);

        echo '<tr>';
        echo "<td>$POL_HOLDER</td>";
        if (empty($polref)) {
            echo "<td>TBC</td>";
        } else {
            echo "<td>
                    <a href='https://fastway.lv.com/review/index?applicationId=$LV_MODAL_APP' target='_blank' class='btn btn-info btn-sm'><i class='fa fa-search'></i> $polref</a>
                    </td>"; }
        echo "<td>" . $LV_Policies['type'] . "</td>";
        echo "<td>" . $LV_Policies['CommissionType'] . "</td>";
        echo "<td>" . $LV_Policies['polterm'] . "</td>";
        echo "<td>£" . $LV_Policies['premium'] . "</td>";
        echo "<td>£$COVER_AMOUNT</td>";

        if ($LV_Policies['PolicyStatus'] == 'CLAWBACK' || ['PolicyStatus'] == 'CLAWBACK-LAPSE' || $LV_Policies['PolicyStatus'] == 'Declined') {
            echo "<td><span class=\"label label-danger\">" . $LV_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($LV_Policies['PolicyStatus'] == 'PENDING' || $LV_Policies['PolicyStatus'] == 'Live Awaiting Policy Number' || $LV_Policies['PolicyStatus'] == 'Awaiting Policy Number') {
            echo "<td><span class=\"label label-warning\">" . $LV_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($LV_Policies['PolicyStatus'] == 'SUBMITTED-LIVE' || $LV_Policies['PolicyStatus'] == 'Live') {
            echo "<td><span class=\"label label-success\">" . $LV_Policies['PolicyStatus'] . "</span></td>";
        } else {
            echo "<td><span class=\"label label-default\">" . $LV_Policies['PolicyStatus'] . "</span></td>";
        }
        echo "<td><span class='label label-warning'>" . $LV_Policies['adl_ews_orig_status'] . "</span></td>";
        if (!empty($LV_Policies['lv_financial_indemnity'])) {
            
        if ($LV_Policies['lv_financial_indemnity'] >= 0) {
            
            echo "<td><span class='label label-success'>PAID</span> </td>";
            
        } elseif ($LV_Policies['lv_financial_indemnity'] < 0) {
            
            echo "<td><span class='label label-danger'>CLAWBACK</span> </td>";
            
        } 
        
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