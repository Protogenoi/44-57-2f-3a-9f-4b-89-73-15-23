<table id="ClientListTable" class="table table-hover">
    <thead>
        <tr>
            <th colspan='12'>TRB Legal and General Policies <i>(Any policy added before 1st Jan 2017)</i></th>
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
            <th>EWS</th>
            <th>Financial</th>
            <th colspan="4">Options</th>
        </tr>
    </thead> 
    <?php foreach ($OldPoliciesList as $Old_Policies): ?>


        <?php
        $PID = $Old_Policies['id'];
        $ANID = $Old_Policies['application_number'];
        $polref = $Old_Policies['policy_number'];
        $polcap[] = $Old_Policies['id'];
        $POL_HOLDER = $Old_Policies['client_name'];

        $ADLSTATUS = $Old_Policies['ADLSTATUS'];
        $EWSSTATUS = $Old_Policies['warning'];
        
        $TRIM_POL = substr($polref, 0, 9);

        echo '<tr>';
        echo "<td>$POL_HOLDER</td>";
        if (empty($polref)) {
            echo "<td>TBC</td>";
        } else {
            echo "<td><form target='_blank' action='//www20.landg.com/PolicyEnquiriesIFACentre/requests.do' method='post'>
                <input type='hidden' name='policyNumber' value='$TRIM_POL'>
                <input type='hidden' name='routeSelected' value='convLifeSummary'>
<button type='submit' class='btn btn-default btn-sm'>
<i class='fa fa-search'></i> $polref</button></form></td>";
        }
        echo "<td><a href='//www10.landg.com/CNBSWeb/administerApplicationDialogue/administerApplicationPage.htm?applicationId=$ANID' target='_blank' class='btn btn-default btn-sm'><i class='fa fa-search'></i> $ANID</a></td>";
        echo "<td>" . $Old_Policies['type'] . "</td>";
        echo "<td>" . $Old_Policies['CommissionType'] . "</td>";
        echo "<td>" . $Old_Policies['polterm'] . "</td>";
        echo "<td>£" . $Old_Policies['premium'] . "</td>";
        echo "<td>£" . $Old_Policies['covera'] . "</td>";

        if ($Old_Policies['PolicyStatus'] == 'CLAWBACK' || ['PolicyStatus'] == 'CLAWBACK-LAPSE' || $Old_Policies['PolicyStatus'] == 'Declined') {
            echo "<td><span class=\"label label-danger\">" . $Old_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($Old_Policies['PolicyStatus'] == 'PENDING' || $Old_Policies['PolicyStatus'] == 'Live Awaiting Policy Number' || $Old_Policies['PolicyStatus'] == 'Awaiting Policy Number') {
            echo "<td><span class=\"label label-warning\">" . $Old_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($Old_Policies['PolicyStatus'] == 'SUBMITTED-LIVE' || $Old_Policies['PolicyStatus'] == 'Live') {
            echo "<td><span class=\"label label-success\">" . $Old_Policies['PolicyStatus'] . "</span></td>";
        } else {
            echo "<td><span class=\"label label-default\">" . $Old_Policies['PolicyStatus'] . "</span></td>";
        }

        if ($ADLSTATUS != $EWSSTATUS) {
            switch ($EWSSTATUS) {
                case "RE-INSTATED":
                    echo "<td><span class='label label-success'>$EWSSTATUS</span></td>";
                    break;
                case "WILL CANCEL":
                    echo "<td><span class='label label-warning'>$EWSSTATUS</span></td>";
                    break;
                case "REDRAWN":
                case "WILL REDRAW":
                    echo "<td><span class='label label-purple'>$EWSSTATUS</td>";
                    break;
                case "CANCELLED":
                case "CFO":
                case "LAPSED":
                case "CANCELLED DD":
                case "BOUNCED DD":
                    echo "<td><span class='label label-danger'>$EWSSTATUS</td>";
                    break;
                default:
                    echo "<td><span class='label label-info'>$EWSSTATUS</td>";
            }
        } else {

            switch ($ADLSTATUS) {
                case "RE-INSTATED":
                    echo "<td><span class='label label-success'>$ADLSTATUS</span></td>";
                    break;
                case "WILL CANCEL":
                    echo "<td><span class='label label-warning'>$ADLSTATUS</span></td>";
                    break;
                case "REDRAWN":
                case "WILL REDRAW":
                    echo "<td><span class='label label-purple'>$ADLSTATUS</td>";
                    break;
                case "CANCELLED":
                case "CFO":
                case "LAPSED":
                case "CANCELLED DD":
                case "BOUNCED DD":
                    echo "<td><span class='label label-danger'>$ADLSTATUS</td>";
                    break;
                default:
                    echo "<td><span class='label label-info'>$ADLSTATUS</td>";
            }
        }

        if (($Old_Policies['payment_amount'])) {
            echo "<td><span class='label label-warning'>On Financial</span> </td>";
        } else {

            echo "<td> </td>";
        }
        if (file_exists("../uploads/LG/PolSummary/$TRIM_POL")) {
        echo "<td><a class='btn btn-default btn-xs' href='../uploads/LG/PolSummary/$TRIM_POL' target='_blank'> <i class='fa fa-file-pdf-o'></i> </a></td>";
        }
        echo "<td><a href='ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY' class='btn btn-info btn-xs'><i class='fa fa-eye'></i> </a></td>";
        echo "<td><a href='EditPolicy.php?id=$PID&search=$search&name=$POL_HOLDER' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> </a></td>";

        if ($companynamere == 'Bluestone Protect') {
            if (in_array($hello_name, $Level_10_Access, true)) {


                echo "<td>
                                                                                        <form method='POST' action='/admin/deletepolicy.php?DeleteLGPolicy=1'>
                                                                                        <input type='hidden' id='policyID' name='policyID' value='$PID'>
                                                                                            <button type='submit' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span> </button>
                                                                                            </form>
                                                                                            </td>";
            }
        }


        if (!empty($EWSSTATUS)) {
            echo "<td><a href='Reports/EWSPolicySearch.php?EWSView=1&search=$search&policy_number=$polref' class='btn btn-success btn-xs'><i class='fa fa-warning'></i> </a></td>";
        }
        echo "</tr>";
        ?>


    <?php endforeach ?>
</table> 