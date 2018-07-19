<table  class="table table-hover">
    <thead>
        <tr>
            <th colspan="8">Average Commission and Premiums (Live Indemnity Policies)</th>
        </tr>
        <tr>
            <th>Insurer</th>
            <th>Commission</th>
            <th>Premium</th>
            <th>Policies sold</th>
        </tr>
    <?php foreach ($COMM_PREM_STATS_VARS as $COMM_PREM_STATS_Results): ?>


        <?php
                $STAT_POLICIES_SOLD = $COMM_PREM_STATS_Results['policies_sold'];
                $STAT_AVG_COMM = number_format($COMM_PREM_STATS_Results['avg_comm'],2);
                $STAT_AVG_PREM = number_format($COMM_PREM_STATS_Results['avg_prem'],2);
                $STAT_INSURER = $COMM_PREM_STATS_Results['insurer'];
        
                ?>
        <tr>
            <th><?php if(isset($STAT_INSURER)) { echo $STAT_INSURER; } ?></th>
            <td><?php if(isset($STAT_AVG_COMM)) { echo $STAT_AVG_COMM; } ?></td>
        <td><?php if(isset($STAT_AVG_PREM)) { echo $STAT_AVG_PREM; } ?></td>
        <td><?php if(isset($STAT_POLICIES_SOLD)) { echo $STAT_POLICIES_SOLD; } ?></td>     
        </tr>
    </thead>
   
    <?php endforeach; ?>

</table>
