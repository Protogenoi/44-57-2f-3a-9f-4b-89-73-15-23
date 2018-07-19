<table  class="table table-hover">
    <thead>
        <tr>
            <th colspan="4">Average Commission and Premiums (Not Live Policies <?php echo "$DATEFROM - $DATETO"; ?>)</th>
        </tr>
        <tr>
            <th>Insurer</th>
            <th>Commission</th>
            <th>Premium</th>
            <th>Policies Cancelled</th>
        </tr>
    <?php foreach ($CANCELS_STATS_VARS as $CANCELS_STATS_Results): ?>


        <?php
                $CANCELS_STAT_POLICIES_SOLD = $CANCELS_STATS_Results['policies_cancelled'];
                $CANCELS_STAT_AVG_COMM = number_format($CANCELS_STATS_Results['avg_comm'],2);
                $CANCELS_STAT_AVG_PREM = number_format($CANCELS_STATS_Results['avg_prem'],2);
                $CANCELS_STAT_INSURER = $CANCELS_STATS_Results['insurer'];
        
                ?>
        <tr>
            <th><?php if(isset($CANCELS_STAT_INSURER)) { echo $CANCELS_STAT_INSURER; } ?></th>
            <td><?php if(isset($CANCELS_STAT_AVG_COMM)) { echo $CANCELS_STAT_AVG_COMM; } ?></td>
            <td><?php if(isset($CANCELS_STAT_AVG_PREM)) { echo $CANCELS_STAT_AVG_PREM; } ?></td>
            <td><?php if(isset($CANCELS_STAT_POLICIES_SOLD)) { echo $CANCELS_STAT_POLICIES_SOLD; } ?></td>     
        </tr> 
   
    <?php endforeach; ?>
</thead>
</table>