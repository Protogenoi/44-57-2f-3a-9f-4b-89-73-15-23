<?php foreach ($TRAININGTeamPadList as $TRAININGTeam_Pad): ?>

    <?php
    $TRAINING_COMM = number_format($TRAININGTeam_Pad['COMM'], 2);
    $TRAINING_AVG = number_format($TRAININGTeam_Pad['AVG'], 2);
    $TRAINING_TEAM = $TRAININGTeam_Pad['pad_statistics_group'];
    ?>
    <tr>
        <td><?php echo $TRAINING_TEAM; ?></td>
                <td><input size="8" disabled class="form-control" type="currency" name="TRAINING_AVG" value="<?php
                   if (isset($TRAINING_AVG)) {
                       echo "£$TRAINING_AVG";
                   }
                   ?>"></td>
        <td><input size="8" disabled class="form-control" type="currency" name="TRAINING_COMM" value="<?php
                   if (isset($TRAINING_COMM)) {
                       echo "£$TRAINING_COMM";
                   }
                   ?>"></td></tr>

<?php endforeach ?>
        