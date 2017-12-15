<table id="ClientListTable" class="table table-hover">
    <thead>
        <tr>
            <th colspan='12'>Legal and General Policies</th>
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
    <?php foreach ($LGPoliciesList as $LG_Policies): ?>


        <?php
        $PID = $LG_Policies['id'];
        $ANID = $LG_Policies['application_number'];
        $polref = $LG_Policies['policy_number'];
        $polcap[] = $LG_Policies['id'];
        $POL_HOLDER = $LG_Policies['client_name'];

        $ADLSTATUS = $LG_Policies['ADLSTATUS'];
        $EWSSTATUS = $LG_Policies['warning'];
        
         if(empty($Old_Policies['covera'])) {
            $Old_Policies['covera']=0;
        }       
        
        $COVER_AMOUNT = number_format($LG_Policies['covera'],2);
        
        /*
        $COVER_WORDS = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $COVER_WORDS->format($COVER_AMOUNT);
        */
        $TRIM_POL = substr($polref, 0, 9);
        
        $COVER_WORDS='NOT ENABLED YET';

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
        echo "<td>" . $LG_Policies['type'] . "</td>";
        echo "<td>" . $LG_Policies['CommissionType'] . "</td>";
        echo "<td>" . $LG_Policies['polterm'] . "</td>";
        echo "<td>£" . $LG_Policies['premium'] . "</td>";
        echo "<td title='$COVER_WORDS'>£$COVER_AMOUNT</td>";

        if ($LG_Policies['PolicyStatus'] == 'CLAWBACK' || ['PolicyStatus'] == 'CLAWBACK-LAPSE' || $LG_Policies['PolicyStatus'] == 'Declined') {
            echo "<td><span class=\"label label-danger\">" . $LG_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($LG_Policies['PolicyStatus'] == 'PENDING' || $LG_Policies['PolicyStatus'] == 'Live Awaiting Policy Number' || $LG_Policies['PolicyStatus'] == 'Awaiting Policy Number') {
            echo "<td><span class=\"label label-warning\">" . $LG_Policies['PolicyStatus'] . "</span></td>";
        } elseif ($LG_Policies['PolicyStatus'] == 'SUBMITTED-LIVE' || $LG_Policies['PolicyStatus'] == 'Live') {
            echo "<td><span class=\"label label-success\">" . $LG_Policies['PolicyStatus'] . "</span></td>";
        } else {
            echo "<td><span class=\"label label-default\">" . $LG_Policies['PolicyStatus'] . "</span></td>";
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

        if (($LG_Policies['payment_amount'])) {
            echo "<td><span class='label label-warning'>On Financial</span> </td>";
        } else {

            echo "<td> </td>";
        }
        if (file_exists("../uploads/LG/PolSummary/$TRIM_POL")) {
        echo "<td><a class='btn btn-default btn-xs' href='../uploads/LG/PolSummary/$TRIM_POL' target='_blank'> <i class='fa fa-file-pdf-o'></i> </a></td>";
        }
        echo "<td><a href='/Life/ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY' class='btn btn-info btn-xs'><i class='fa fa-eye'></i> </a></td>";
        echo "<td><a href='/Life/EditPolicy.php?id=$PID&search=$search&name=$POL_HOLDER' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> </a></td>";
            if (in_array($hello_name, $Level_10_Access, true)) {


                echo "<td>
                                                                                        <form method='POST' action='/app/admin/deletepolicy.php?DeleteLGPolicy=1'>
                                                                                        <input type='hidden' id='policyID' name='policyID' value='$PID'>
                                                                                            <button type='submit' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span> </button>
                                                                                            </form>
                                                                                            </td>";
            }

        if (!empty($EWSSTATUS)) {
            echo "<td><a href='/Life/Reports/EWSPolicySearch.php?EWSView=1&search=$search&policy_number=$polref' class='btn btn-success btn-xs'><i class='fa fa-warning'></i> </a></td>";
        }
        echo "</tr>";
        ?>


    <?php endforeach ?>
</table> 