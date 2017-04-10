<?php foreach ($POD3TeamPadList as $POD3Team_Pad): ?>

    <?php
    $POD_COMM3 = number_format($POD3Team_Pad['COMM'], 2);
    $POD_AVG3 = number_format($POD3Team_Pad['AVG'], 2);
    $POD_TEAM3 = $POD3Team_Pad['pad_statistics_group'];
    ?>
    <tr>
        <td><?php echo $POD_TEAM3; ?></td>
                <td><input size="8" disabled class="form-control" type="currency" name="POD_AVG" value="<?php
                   if (isset($POD_AVG3)) {
                       echo "£$POD_AVG3";
                   }
                   ?>"></td>
        <td><input size="8" disabled class="form-control" type="currency" name="POD_COMM" value="<?php
                   if (isset($POD_COMM3)) {
                       echo "£$POD_COMM3";
                   }
                   ?>"></td></tr>

<?php endforeach ?>
        