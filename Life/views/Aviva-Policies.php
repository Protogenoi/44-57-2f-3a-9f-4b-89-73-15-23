<table id="ClientListTable" class="table table-hover">
    <thead>
        <tr>
            <th colspan='7'>Aviva Policies</th>
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
            <th colspan="4">Options</th>
        </tr>
    </thead> 
    <?php foreach ($AvivaPoliciesList as $Aviva_Policies): ?>


        <?php
        $PID = $Aviva_Policies['id'];
        $polref = $Aviva_Policies['policy_number'];
        $polcap[] = $Aviva_Policies['id'];
        $POL_HOLDER = $Aviva_Policies['client_name'];

        $ADLSTATUS = $Aviva_Policies['ADLSTATUS'];
        $EWSSTATUS = $Aviva_Policies['warning'];

        echo '<tr>';
        echo "<td>$POL_HOLDER</td>";
        if (empty($polref)) {
            echo "<td>TBC</td>";
        } else {
            echo "<td><form target='_blank' action='#' method='post'><input type='hidden' value='$polref'><input type='hidden' name='searchCriteria.referenceType' id='searchCriteria.referenceType' value='B'><input type='hidden' name='searchCriteria.includeLife' value='true' ><button type='submit' value='Search' name='command' class='btn btn-default btn-sm'><i class='fa fa-search'></i> $polref</button></form></td>";
        }
        echo "<td>" . $Aviva_Policies['type'] . "</td>";
        echo "<td>" . $Aviva_Policies['CommissionType'] . "</td>";
        echo "<td>" . $Aviva_Policies['polterm'] . "</td>";
        echo "<td>£" . $Aviva_Policies['premium'] . "</td>";
        echo "<td>£" . $Aviva_Policies['covera'] . "</td>";

        if ($Aviva_Policies['PolicyStatus'] == 'CLAWBACK' || ['PolicyStatus'] == 'CLAWBACK-LAPSE' || $Aviva_Policies['PolicyStatus'] == 'Declined') {
            echo "<td><span class=\"label label-danger\">" . $Aviva_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($Aviva_Policies['PolicyStatus'] == 'PENDING' || $Aviva_Policies['PolicyStatus'] == 'Live Awaiting Policy Number' || $Aviva_Policies['PolicyStatus'] == 'Awaiting Policy Number') {
            echo "<td><span class=\"label label-warning\">" . $Aviva_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($Aviva_Policies['PolicyStatus'] == 'SUBMITTED-LIVE' || $Aviva_Policies['PolicyStatus'] == 'Live') {
            echo "<td><span class=\"label label-success\">" . $Aviva_Policies['PolicyStatus'] . "</span></td>";
        } else {
            echo "<td><span class=\"label label-default\">" . $Aviva_Policies['PolicyStatus'] . "</span></td>";
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

        if (($Aviva_Policies['wol_comm'])) {
            echo "<td><span class='label label-warning'>On Financial</span> </td>";
        } else {

            echo "<td> </td>";
        }

        echo "<td><a href='ViewPolicy.php?policyID=$PID&search=$search' class='btn btn-info btn-xs'><i class='fa fa-eye'></i> </a></td>";
        echo "<td><a href='EditPolicy.php?id=$PID&search=$search&name=$POL_HOLDER' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> </a></td>";

        if ($companynamere == 'The Review Bureau' || $companynamere == 'ADL_CUS') {
            if (in_array($hello_name, $Level_10_Access, true)) {


                echo "<td>
                                                                                        <form method='POST' action='/admin/deletepolicy.php?DeleteLifePolicy=1'>
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