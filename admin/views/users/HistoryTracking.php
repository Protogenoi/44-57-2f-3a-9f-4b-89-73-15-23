<table class="table table-hover">
    <thead>
        <tr>
            <th colspan='5'><h2>History Tracking</h2> <a href="/admin/Admindash.php?users=y" class="btn btn-xs btn-success"><i class="fa fa-refresh"></i> </a></th>
        </tr>
        <tr>
            <th>Date</th>
            <th>User</th>
            <th>URL</th>
            <th>IP</th>
        </tr>
    </thead> 
    <?php foreach ($HistoryTrackingList as $HistoryTracking): ?>
    
        <?php
        
        $HISTORY_TRK_USER = $HistoryTracking['tracking_history_user'];
        $HISTORY_TRK_URL = $HistoryTracking['tracking_history_url'];
        $HISTORY_TRK_IP = $HistoryTracking['tracking_history_ip'];
        $HISTORY_TRK_DATE= $HistoryTracking['tracking_history_date'];
        
        ?>
<form>
        <tr>
        
        <td><?php if(isset($HISTORY_TRK_DATE)) { echo $HISTORY_TRK_DATE; } ?></td>      
        <td><?php if(isset($HISTORY_TRK_USER)) { echo $HISTORY_TRK_USER; } ?></td> 
        <td><?php if(isset($HISTORY_TRK_URL)) { echo $HISTORY_TRK_URL; } ?></td> 
        <td><h4><span class="label <?php if($HISTORY_TRK_IP!='81.145.167.66') { echo "label-danger"; } else { echo "label-success"; }?>"><?php if(isset($HISTORY_TRK_IP)) { echo $HISTORY_TRK_IP; } ?></span></h4></td> 

        </tr>
</form>
      



    <?php endforeach ?>
</table> 