<?php foreach ($POD2TeamPadList as $POD2Team_Pad): ?>

    <?php
    $POD_COMM2 = number_format($POD2Team_Pad['COMM'], 2);
    $POD_AVG2 = number_format($POD2Team_Pad['AVG'], 2);
    $POD_TEAM2 = $POD2Team_Pad['pad_statistics_group'];
    ?>
    <tr>
        <td><?php echo $POD_TEAM2; ?></td>
                <td><input size="8" disabled class="form-control" type="currency" name="POD_AVG" value="<?php
                   if (isset($POD_AVG2)) {
                       echo "£$POD_AVG2";
                   }
                   ?>"></td>
        <td><input size="8" disabled class="form-control" type="currency" name="POD_COMM" value="<?php
                   if (isset($POD_COMM2)) {
                       echo "£$POD_COMM2";
                   }
                   ?>"></td></tr>

<?php endforeach ?>
        