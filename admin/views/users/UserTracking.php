<table class="table table-hover">
    <thead>
        <tr>
            <th colspan='5'><h2>User Tracking</h2> <a href="/admin/Admindash.php?users=y" class="btn btn-xs btn-success"><i class="fa fa-refresh"></i> </a></th>
        </tr>
        <tr>
            <th>Date</th>
            <th>User</th>
            <th>URL</th>
            <th>IP</th>
        </tr>
    </thead> 
    <?php foreach ($UserTrackingList as $UserTracking): ?>
    
        <?php
        
        $USER_TRK_USER = $UserTracking['user_tracking_user'];
        $USER_TRK_URL = $UserTracking['user_tracking_url'];
        $USER_TRK_IP = $UserTracking['user_tracking_ip'];
        $USER_TRK_DATE= $UserTracking['user_tracking_date'];
        
        ?>
<form>
        <tr>
        
        <td><?php if(isset($USER_TRK_DATE)) { echo $USER_TRK_DATE; } ?></td>      
        <td><?php if(isset($USER_TRK_USER)) { echo $USER_TRK_USER; } ?></td> 
        <td><?php if(isset($USER_TRK_URL)) { echo $USER_TRK_URL; } ?></td> 
        <td><strong><?php if(isset($USER_TRK_IP)) { echo $USER_TRK_IP; } ?></strong></td> 

        </tr>
</form>
      



    <?php endforeach ?>
</table> 