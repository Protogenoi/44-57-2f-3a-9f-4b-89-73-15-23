<?php foreach ($CLOSERTeamPadList as $CLOSERTeam_Pad): ?>

    <?php
    $CLOSER_COMM = number_format($CLOSERTeam_Pad['COMM'], 2);
    $CLOSER_AVG = number_format($CLOSERTeam_Pad['AVG'], 2);
    $CLOSER_TEAM = $CLOSERTeam_Pad['pad_statistics_group'];
    ?>
    <tr>
        <td><?php echo $CLOSER_TEAM; ?></td>
                <td><input size="8" disabled class="form-control" type="currency" name="CLOSER_AVG" value="<?php
                   if (isset($CLOSER_AVG)) {
                       echo "£$CLOSER_AVG";
                   }
                   ?>"></td>
        <td><input size="8" disabled class="form-control" type="currency" name="CLOSER_COMM" value="<?php
                   if (isset($CLOSER_COMM)) {
                       echo "£$CLOSER_COMM";
                   }
                   ?>"></td></tr>

<?php endforeach ?>
        