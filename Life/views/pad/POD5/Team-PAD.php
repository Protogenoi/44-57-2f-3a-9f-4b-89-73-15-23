<?php foreach ($POD5TeamPadList as $POD5Team_Pad): ?>

    <?php
    $POD_COMM5 = number_format($POD5Team_Pad['COMM'], 2);
    $POD_AVG5 = number_format($POD5Team_Pad['AVG'], 2);
    $POD_TEAM5 = $POD5Team_Pad['pad_statistics_group'];
    ?>
    <tr>
        <td><?php echo $POD_TEAM5; ?></td>
                <td><input size="8" disabled class="form-control" type="currency" name="POD_AVG" value="<?php
                   if (isset($POD_AVG5)) {
                       echo "£$POD_AVG5";
                   }
                   ?>"></td>
        <td><input size="8" disabled class="form-control" type="currency" name="POD_COMM" value="<?php
                   if (isset($POD_COMM5)) {
                       echo "£$POD_COMM5";
                   }
                   ?>"></td></tr>

<?php endforeach ?>
        