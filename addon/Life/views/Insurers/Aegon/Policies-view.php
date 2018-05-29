<table id="ClientListTable" class="table table-hover">
    <thead>
        <tr>
            <th colspan='7'>Aegon Policies</th>
        </tr>
        <tr>
            <th>Client</th>
            <th>Policy</th>
            <th>Type</th>
            <th>Cover</th>
            <th>Term</th>
            <th>Premium</th>
            <th>Status</th>
            <th>Financial</th>
            <th colspan="3">Options</th>
        </tr>
    </thead> 
    <?php foreach ($AEGONPoliciesList as $AEGON_Policies): ?>

        <?php
        $PID = $AEGON_Policies['aegon_policy_id'];
        $APID = $AEGON_Policies['adl_policy_id'];
        $polref = $AEGON_Policies['adl_policy_ref'];
        $POL_HOLDER = $AEGON_Policies['adl_policy_policy_holder'];  
        
        if(isset($AEGON_Policies['aegon_policy_premium'])) {
            $AEGON_PREMIUM="£".$AEGON_Policies['aegon_policy_premium'];
        }
        
        $ADL_VIT_POL_COM = (5.0 / 100) * $AEGON_Policies['aegon_policy_comms'];
        
        if(empty($Old_Policies['aegon_policy_cover_amount'])) {
            $Old_Policies['aegon_policy_cover_amount']=0;
        }        
        $COVER_AMOUNT = number_format($AEGON_Policies['aegon_policy_cover_amount'],2);
        
        echo '<tr>';
        echo "<td>$POL_HOLDER</td>";
        if (empty($polref)) {
            echo "<td>TBC</td>";
        } else {
            echo "<td>$polref</td>"; }
        echo "<td>" . $AEGON_Policies['aegon_policy_type'] . "</td>";
        echo "<td>£$COVER_AMOUNT</td>";
        echo "<td>" . $AEGON_Policies['aegon_policy_policy_term'] . "</td>";
        echo "<td>" . $AEGON_Policies['aegon_policy_premium'] . "</td>";
       
        if ($AEGON_Policies['adl_policy_status'] == 'CLAWBACK' || ['adl_policy_status'] == 'CLAWBACK-LAPSE' || $AEGON_Policies['adl_policy_status'] == 'Declined') {
            echo "<td><span class=\"label label-danger\">" . $AEGON_Policies['adl_policy_status'] . "</span></td>";
        } elseif ($AEGON_Policies['adl_policy_status'] == 'PENDING' || $AEGON_Policies['adl_policy_status'] == 'Live Awaiting Policy Number' || $AEGON_Policies['adl_policy_status'] == 'Awaiting Policy Number') {
            echo "<td><span class=\"label label-warning\">" . $AEGON_Policies['adl_policy_status'] . "</span></td>";
        } elseif ($AEGON_Policies['adl_policy_status'] == 'SUBMITTED-LIVE' || $AEGON_Policies['adl_policy_status'] == 'Live') {
            echo "<td><span class=\"label label-success\">" . $AEGON_Policies['adl_policy_status'] . "</span></td>";
        } else {
            echo "<td><span class=\"label label-default\">" . $AEGON_Policies['adl_policy_status'] . "</span></td>";
        }
        if (!empty($AEGON_Policies['vitality_financial_amount'])) {
            
            echo "<td><span class='label label-success'>On Financials</span> </td>";    
        
        } 
        
        else {

            echo "<td> </td>";
        }

        echo "<td><a href='/addon/Life/Insurers/Aegon/view_policy.php?EXECUTE=1&PID=$PID&CID=$search' class='btn btn-info btn-xs'><i class='fa fa-eye'></i> </a></td>";
        echo "<td><a href='/addon/Life/Insurers/Aegon/edit_policy.php?EXECUTE=1&PID=$PID&CID=$search&NAME=$POL_HOLDER' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> </a></td>";

        if (in_array($hello_name, $Level_10_Access, true)) {

        echo "<td><a href='/addon/Life/Insurers/Aegon/delete_policy.php?EXECUTE=1&PID=$APID&CID=$search' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> </a></td>";

            }
            
        echo "</tr>";
        ?>

    <?php endforeach ?>
</table> 