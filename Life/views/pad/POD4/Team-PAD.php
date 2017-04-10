<?php foreach ($POD4TeamPadList as $POD4Team_Pad): ?>

    <?php
    $POD_COMM4 = number_format($POD4Team_Pad['COMM'], 2);
    $POD_AVG4 = number_format($POD4Team_Pad['AVG'], 2);
    $POD_TEAM4 = $POD4Team_Pad['pad_statistics_group'];
    ?>
    <tr>
        <td><?php echo $POD_TEAM4; ?></td>
                <td><input size="8" disabled class="form-control" type="currency" name="POD_AVG" value="<?php
                   if (isset($POD_AVG4)) {
                       echo "£$POD_AVG4";
                   }
                   ?>"></td>
        <td><input size="8" disabled class="form-control" type="currency" name="POD_COMM" value="<?php
                   if (isset($POD_COMM4)) {
                       echo "£$POD_COMM4";
                   }
                   ?>"></td></tr>

<?php endforeach ?>
        