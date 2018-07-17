<?php 

foreach ($EWS_COUNT_NEW_LIST as $EWS_COUNT_NEW_ROWS): 
    
    $EWS_COUNTED_NEW = $EWS_COUNT_NEW_ROWS['EWS_NEW'];
    $EWS_COUNTED_LAPSED = $EWS_COUNT_NEW_ROWS['EWS_LAPSED'];
    $EWS_COUNTED_CANCELLED_DD = $EWS_COUNT_NEW_ROWS['EWS_DD_CANCELLED'];
    $EWS_COUNTED_DD_REJECT = $EWS_COUNT_NEW_ROWS['EWS_DD_REJECT'];
    $EWS_COUNTED_CANCELLED = $EWS_COUNT_NEW_ROWS['EWS_CANCELLED'];
    $EWS_COUNTED_OUTSTANDING = $EWS_COUNT_NEW_ROWS['EWS_OUTSTANDING'];

endforeach; ?>

<table  class="table table-hover">
    <thead>
        <tr>
            <th colspan="8">Unresolved</th>
        </tr>
    <th>New</th>
    <th>Lapsed</th>
    <th>DD Cancelled</th>
    <th>DD Rejection</th>
    <th>Outstanding Premium</th>
    <th>Cancelled</th>
    
    </thead>
    
    <tr>
        <th><?php if(isset($EWS_COUNTED_NEW)) { echo $EWS_COUNTED_NEW; } ?></th>
        <th><?php if(isset($EWS_COUNTED_LAPSED)) { echo $EWS_COUNTED_LAPSED; } ?></th>
        <th><?php if(isset($EWS_COUNTED_CANCELLED_DD)) { echo $EWS_COUNTED_CANCELLED_DD; } ?></th>
        <th><?php if(isset($EWS_COUNTED_DD_REJECT)) { echo $EWS_COUNTED_DD_REJECT; } ?></th>
        <th><?php if(isset($EWS_COUNTED_OUTSTANDING)) { echo $EWS_COUNTED_OUTSTANDING; } ?></th>
        <th><?php if(isset($EWS_COUNTED_CANCELLED)) { echo $EWS_COUNTED_CANCELLED; } ?></th>
        <th></th>
    </tr>
    
</table>