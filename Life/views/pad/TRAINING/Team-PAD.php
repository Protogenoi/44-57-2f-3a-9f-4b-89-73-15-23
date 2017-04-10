<?php foreach ($TRAININGTeamPadList as $TRAININGTeam_Pad): ?>

    <?php
    $POD_COMM6 = number_format($TRAININGTeam_Pad['COMM'], 2);
    $POD_AVG6 = number_format($TRAININGTeam_Pad['AVG'], 2);
    $POD_TEAM6 = $TRAININGTeam_Pad['pad_statistics_group'];
    ?>
    <tr>
        <td><?php echo $POD_TEAM6; ?></td>
                <td><input size="8" disabled class="form-control" type="currency" name="POD_AVG" value="<?php
                   if (isset($POD_AVG6)) {
                       echo "£$POD_AVG6";
                   }
                   ?>"></td>
        <td><input size="8" disabled class="form-control" type="currency" name="POD_COMM" value="<?php
                   if (isset($POD_COMM6)) {
                       echo "£$POD_COMM6";
                   }
                   ?>"></td></tr>

<?php endforeach ?>
        