<table id="ClientListTable" class="table table-hover">
    <thead>
        <tr>
            <th colspan='7'>Vitality Policies</th>
        </tr>
        <tr>
            <th>Client</th>
            <th>Policy</th>
            <th>Plan</th>
            <th>Type</th>
            <th></th>
            <th>Cover</th>
            <th>Term</th>
            <th>Premium</th>
            <th>Wellness</th>
            <th></th>
            <th>Opts</th>
            <th>Status</th>
            <th>Financial</th>
            <th colspan="3">Options</th>
        </tr>
    </thead> 
    <?php foreach ($VITALITYPoliciesList as $VITALITY_Policies): ?>

        <?php
        $PID = $VITALITY_Policies['vitality_policy_id'];
        $polref = $VITALITY_Policies['adl_policy_ref'];
        $POL_HOLDER = $VITALITY_Policies['adl_policy_policy_holder'];  
        
        if(isset($VITALITY_Policies['vitality_policy_premium'])) {
            $VITALITY_PREMIUM="£".$VITALITY_Policies['vitality_policy_premium'];
        }
        
        $ADL_VIT_POL_COM = (5.0 / 100) * $VITALITY_Policies['vitality_policy_comms'];
        
        if(empty($Old_Policies['vitality_policy_cover_amount'])) {
            $Old_Policies['vitality_policy_cover_amount']=0;
        }        
        
        $COVER_AMOUNT = number_format($VITALITY_Policies['vitality_policy_cover_amount'],2);

        echo '<tr>';
        echo "<td>$POL_HOLDER</td>";
        if (empty($polref)) {
            echo "<td>TBC</td>";
        } else {
            echo "<td>
                    <form target='_blank' id='searchForm' name='searchForm' action='https://adviser.vitality.co.uk/life/online/online/dashboard' method='POST'>
                    <button class='btn btn-info btn-sm'><i class='fa fa-search'></i> $polref</button>
                        <input id='searchForm:prugleSearchValue' type='hidden' name='searchForm:prugleSearchValue' value='$polref'>
                        <input type='hidden' autocomplete='off' name='searchForm' value='searchForm'>
                        <input type='hidden' autocomplete='off' name='autoScroll' value=''>
                        <input type='hidden' name='javax.faces.ViewState' id='javax.faces.ViewState' value='j_id5' autocomplete='off'>
                    </form>
                  </td>"; }
        echo "<td>" . $VITALITY_Policies['vitality_policy_plan'] . "</td>";
        echo "<td>" . $VITALITY_Policies['vitality_policy_cover'] . "</td>";
        echo "<td>" . $VITALITY_Policies['vitality_policy_type'] . "</td>";
        echo "<td>£$COVER_AMOUNT</td>";
        echo "<td>" . $VITALITY_Policies['vitality_policy_policy_term'] . "</td>";
        echo "<td>" . $VITALITY_Policies['vitality_policy_premium'] . "</td>";
        echo "<td>" . $VITALITY_Policies['vitality_policy_wellness'] . "</td>";
        echo "<td>" . $VITALITY_Policies['vitality_policy_term_prem'] . "</td>";
        echo "<td>" . $VITALITY_Policies['vitality_policy_sic_opt'] . "</td>";
        if ($VITALITY_Policies['adl_policy_status'] == 'CLAWBACK' || ['adl_policy_status'] == 'CLAWBACK-LAPSE' || $VITALITY_Policies['adl_policy_status'] == 'Declined') {
            echo "<td><span class=\"label label-danger\">" . $VITALITY_Policies['adl_policy_status'] . "</span></td>";
        } elseif ($VITALITY_Policies['adl_policy_status'] == 'PENDING' || $VITALITY_Policies['adl_policy_status'] == 'Live Awaiting Policy Number' || $VITALITY_Policies['adl_policy_status'] == 'Awaiting Policy Number') {
            echo "<td><span class=\"label label-warning\">" . $VITALITY_Policies['adl_policy_status'] . "</span></td>";
        } elseif ($VITALITY_Policies['adl_policy_status'] == 'SUBMITTED-LIVE' || $VITALITY_Policies['adl_policy_status'] == 'Live') {
            echo "<td><span class=\"label label-success\">" . $VITALITY_Policies['adl_policy_status'] . "</span></td>";
        } else {
            echo "<td><span class=\"label label-default\">" . $VITALITY_Policies['adl_policy_status'] . "</span></td>";
        }
        if (!empty($VITALITY_Policies['vitality_financial_amount'])) {
            
            echo "<td><span class='label label-success'>On Financials</span> </td>";    
        
        } 
        
        else {

            echo "<td> </td>";
        }

        echo "<td><a href='/addon/Life/Insurers/Vitality/view_policy.php?EXECUTE=1&PID=$PID&CID=$search' class='btn btn-info btn-xs'><i class='fa fa-eye'></i> </a></td>";
        echo "<td><a href='/addon/Life/Insurers/Vitality/edit_policy.php?EXECUTE=1&PID=$PID&CID=$search&NAME=$POL_HOLDER' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> </a></td>";

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