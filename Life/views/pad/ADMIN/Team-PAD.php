<?php foreach ($ADMINTeamPadList as $ADMINTeam_Pad): ?>

    <?php
    $ADMIN_COMM = number_format($ADMINTeam_Pad['COMM'], 2);
    $ADMIN_AVG = number_format($ADMINTeam_Pad['AVG'], 2);
    $ADMIN_TEAM = $ADMINTeam_Pad['pad_statistics_group'];
    ?>
    <tr>
        <td><?php echo $ADMIN_TEAM; ?></td>
                <td><input size="8" disabled class="form-control" type="currency" name="ADMIN_AVG" value="<?php
                   if (isset($ADMIN_AVG)) {
                       echo "£$ADMIN_AVG";
                   }
                   ?>"></td>
        <td><input size="8" disabled class="form-control" type="currency" name="ADMIN_COMM" value="<?php
                   if (isset($ADMIN_COMM)) {
                       echo "£$ADMIN_COMM";
                   }
                   ?>"></td></tr>

<?php endforeach ?>
        