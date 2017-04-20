                                <table  class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Admin Statistics</th>
                                        </tr>
                                        <tr>
                                            <th>Team</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
<?php foreach ($TeamPadList as $Team_Pad):?>

    <?php
    $POD_COMM = number_format($Team_Pad['COMM'], 2);
    $POD_AVG = number_format($Team_Pad['AVG'], 2);
    $POD_TEAM = $Team_Pad['pad_statistics_group'];
    ?>
    <tr>
        <td><?php echo $POD_TEAM; ?></td>
        <td><input size="8" disabled class="form-control" type="currency" name="POD_COMM" value="<?php
                   if (isset($POD_COMM)) {
                   echo "£$POD_COMM (Avg £$POD_AVG)";}
                   
                   ?>"></td>
    
    </tr>

<?php endforeach ?>
                                </table>