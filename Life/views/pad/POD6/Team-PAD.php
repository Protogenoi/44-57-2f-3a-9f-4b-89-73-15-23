<?php foreach ($POD6TeamPadList as $POD6Team_Pad): ?>

    <?php
    $POD_COMM6 = number_format($POD6Team_Pad['COMM'], 2);
    $POD_AVG6 = number_format($POD6Team_Pad['AVG'], 2);
    $POD_TEAM6 = $POD6Team_Pad['pad_statistics_group'];
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
        