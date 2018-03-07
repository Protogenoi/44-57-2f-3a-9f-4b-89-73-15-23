<table id="ClientListTable" class="table table-hover">
    <thead>
        <tr>
            <th colspan='7'>Vitality Policies</th>
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
            <th>Financial</th>
            <th colspan="3">Options</th>
        </tr>
    </thead> 
    <?php foreach ($VITALITYPoliciesList as $VITALITY_Policies): ?>


        <?php
        $PID = $VITALITY_Policies['id'];
        $polref = $VITALITY_Policies['policy_number'];
        $polcap[] = $VITALITY_Policies['id'];
        $POL_HOLDER = $VITALITY_Policies['client_name'];
        $VITALITY_TOTAL_AMOUNT = $VITALITY_Policies['VITALITY_TOTAL_AMOUNT'];        
        
        $ADL_VIT_POL_COM = (5.0 / 100) * $VITALITY_Policies['commission'];
        
        if(empty($Old_Policies['covera'])) {
            $Old_Policies['covera']=0;
        }        
        
        $COVER_AMOUNT = number_format($VITALITY_Policies['covera'],2);

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
        echo "<td>" . $VITALITY_Policies['type'] . "</td>";
        echo "<td>" . $VITALITY_Policies['CommissionType'] . "</td>";
        echo "<td>" . $VITALITY_Policies['polterm'] . "</td>";
        echo "<td>£" . $VITALITY_Policies['premium'] . "</td>";
        echo "<td>£$COVER_AMOUNT</td>";

        if ($VITALITY_Policies['PolicyStatus'] == 'CLAWBACK' || ['PolicyStatus'] == 'CLAWBACK-LAPSE' || $VITALITY_Policies['PolicyStatus'] == 'Declined') {
            echo "<td><span class=\"label label-danger\">" . $VITALITY_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($VITALITY_Policies['PolicyStatus'] == 'PENDING' || $VITALITY_Policies['PolicyStatus'] == 'Live Awaiting Policy Number' || $VITALITY_Policies['PolicyStatus'] == 'Awaiting Policy Number') {
            echo "<td><span class=\"label label-warning\">" . $VITALITY_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($VITALITY_Policies['PolicyStatus'] == 'SUBMITTED-LIVE' || $VITALITY_Policies['PolicyStatus'] == 'Live') {
            echo "<td><span class=\"label label-success\">" . $VITALITY_Policies['PolicyStatus'] . "</span></td>";
        } else {
            echo "<td><span class=\"label label-default\">" . $VITALITY_Policies['PolicyStatus'] . "</span></td>";
        }
        if (!empty($VITALITY_Policies['vitality_financial_amount'])) {
            
        if ($VITALITY_TOTAL_AMOUNT > $ADL_VIT_POL_COM) {
            
            echo "<td><span class='label label-success'>FULL PAYMENT</span> </td>";
            
        } 
        
        elseif ($VITALITY_TOTAL_AMOUNT > 0 && $VITALITY_TOTAL_AMOUNT < $ADL_VIT_POL_COM) {
            
            echo "<td><span class='label label-warning'>PART PAYMENT</span> </td>";
            
        }
        
        elseif ($VITALITY_Policies['vitality_financial_amount'] < 0) {
            
            echo "<td><span class='label label-danger'>Clawback</span> </td>";
            
        }  
        
        else {
            echo "<td><span class='label label-danger'>Clawback</span> </td>";
        }
        
        } 
        
        else {

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