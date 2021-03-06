<table id="ClientListTable" class="table table-hover">
    <thead>
        <tr>
            <th colspan='7'>Scottish Widows Policies</th>
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
    <?php foreach ($SWPoliciesList as $SW_Policies): ?>


        <?php
        $PID = $SW_Policies['id'];
        $polref = $SW_Policies['policy_number'];
        $polcap[] = $SW_Policies['id'];
        $POL_HOLDER = $SW_Policies['client_name'];
        $APP_NUMBER = $SW_Policies['application_number'];

        $ADLSTATUS = $SW_Policies['ADLSTATUS'];
        $EWSSTATUS = $SW_Policies['warning'];
        
        $COVER_AMOUNT = number_format($SW_Policies['covera'],2);

        echo '<tr>';
        echo "<td>$POL_HOLDER</td>";
        if (empty($polref)) {
            echo "<td>TBC</td>";
        } else {
            echo "<td><form target='_blank' action='#' method='post'><input type='hidden' value='$polref'><input type='hidden' name='searchCriteria.referenceType' id='searchCriteria.referenceType' value='B'><input type='hidden' name='searchCriteria.includeLife' value='true' ><button type='submit' value='Search' name='command' class='btn btn-default btn-sm'><i class='fa fa-search'></i> $polref</button></form></td>";
        }
        echo "<td>$APP_NUMBER</td>";
        echo "<td>" . $SW_Policies['type'] . "</td>";
        echo "<td>" . $SW_Policies['CommissionType'] . "</td>";
        echo "<td>" . $SW_Policies['polterm'] . "</td>";
        echo "<td>£" . $SW_Policies['premium'] . "</td>";
        echo "<td>£$COVER_AMOUNT</td>";

        if ($SW_Policies['PolicyStatus'] == 'CLAWBACK' || ['PolicyStatus'] == 'CLAWBACK-LAPSE' || $SW_Policies['PolicyStatus'] == 'Declined') {
            echo "<td><span class=\"label label-danger\">" . $SW_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($SW_Policies['PolicyStatus'] == 'PENDING' || $SW_Policies['PolicyStatus'] == 'Live Awaiting Policy Number' || $SW_Policies['PolicyStatus'] == 'Awaiting Policy Number') {
            echo "<td><span class=\"label label-warning\">" . $SW_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($SW_Policies['PolicyStatus'] == 'SUBMITTED-LIVE' || $SW_Policies['PolicyStatus'] == 'Live') {
            echo "<td><span class=\"label label-success\">" . $SW_Policies['PolicyStatus'] . "</span></td>";
        } else {
            echo "<td><span class=\"label label-default\">" . $SW_Policies['PolicyStatus'] . "</span></td>";
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

        if (($SW_Policies['financials_payment'])) {
            echo "<td><span class='label label-warning'>On Financial</span> </td>";
        } else {

            echo "<td> </td>";
        }

        echo "<td><a href='/addon/Life/ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY' class='btn btn-info btn-xs'><i class='fa fa-eye'></i> </a></td>";
        echo "<td><a href='/addon/Life/EditPolicy.php?id=$PID&search=$search&name=$POL_HOLDER' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> </a></td>";

        if ($companynamere == 'Bluestone Protect') {
            if (in_array($hello_name, $Level_10_Access, true)) {


                echo "<td>
                                                                                        <form method='POST' action='/app/admin/deletepolicy.php?DeleteLifePolicy=1'>
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