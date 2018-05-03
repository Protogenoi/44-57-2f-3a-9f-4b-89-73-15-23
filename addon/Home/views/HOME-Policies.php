<table id="ClientListTable" class="table table-hover">
    <thead>
        <tr>
            <th colspan='7'>Ageas Home Insurance Policies</th>
        </tr>
        <tr>
            <th>Client</th>
            <th>Policy</th>
            <th>Type</th>
            <th>Cover</th>
            <th>Premium</th>
            <th>Status</th>
            <th colspan="3">Options</th>
        </tr>
    </thead> 
    <?php foreach ($HOMEPoliciesList as $HOME_Policies): ?>

        <?php
        $PID = $HOME_Policies['ageas_home_insurance_id'];
        $APID = $HOME_Policies['adl_policy_id'];
        $polref = $HOME_Policies['adl_policy_ref'];
        $POL_HOLDER = $HOME_Policies['adl_policy_policy_holder'];  
        
        if(isset($HOME_Policies['ageas_home_insurance_premium'])) {
            $HOME_PREMIUM="£".$HOME_Policies['ageas_home_insurance_premium'];
        }
        
        $ADL_VIT_POL_COM = (5.0 / 100) * $HOME_Policies['ageas_home_insurance_commission'];
        
        if(empty($Old_Policies['ageas_home_insurance_cover_amount'])) {
            $Old_Policies['ageas_home_insurance_cover_amount']=0;
        }        
        
        $COVER_AMOUNT = number_format($HOME_Policies['ageas_home_insurance_cover'],2);

        echo '<tr>';
        echo "<td>$POL_HOLDER</td>";
        if (empty($polref)) {
            echo "<td>TBC</td>";
        } else {
            echo "<td>$polref</td>"; }
        echo "<td>" . $HOME_Policies['ageas_home_insurance_type'] . "</td>";
        echo "<td>£$COVER_AMOUNT</td>";
        echo "<td>" . $HOME_Policies['ageas_home_insurance_premium'] . "</td>";
        
        if ($HOME_Policies['adl_policy_status'] == 'CLAWBACK' || ['adl_policy_status'] == 'CLAWBACK-LAPSE' || $HOME_Policies['adl_policy_status'] == 'Declined') {
            echo "<td><span class=\"label label-danger\">" . $HOME_Policies['adl_policy_status'] . "</span></td>";
        } elseif ($HOME_Policies['adl_policy_status'] == 'PENDING' || $HOME_Policies['adl_policy_status'] == 'Live Awaiting Policy Number' || $HOME_Policies['adl_policy_status'] == 'Awaiting Policy Number') {
            echo "<td><span class=\"label label-warning\">" . $HOME_Policies['adl_policy_status'] . "</span></td>";
        } elseif ($HOME_Policies['adl_policy_status'] == 'SUBMITTED-LIVE' || $HOME_Policies['adl_policy_status'] == 'Live') {
            echo "<td><span class=\"label label-success\">" . $HOME_Policies['adl_policy_status'] . "</span></td>";
        } else {
            echo "<td><span class=\"label label-default\">" . $HOME_Policies['adl_policy_status'] . "</span></td>";
        }

        echo "<td><a href='/addon/Home/Insurers/Ageas/view_policy.php?EXECUTE=1&PID=$PID&CID=$search' class='btn btn-info btn-xs'><i class='fa fa-eye'></i> </a></td>";
        echo "<td><a href='/addon/Home/Insurers/Ageas/edit_policy.php?EXECUTE=1&PID=$PID&CID=$search&NAME=$POL_HOLDER' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> </a></td>";

        if (in_array($hello_name, $Level_10_Access, true)) {

        echo "<td><a href='/addon/Home/Insurers/Ageas/delete_policy.php?EXECUTE=1&PID=$APID&CID=$search' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> </a></td>";

            }
            
        echo "</tr>";
        ?>

    <?php endforeach ?>
</table> 