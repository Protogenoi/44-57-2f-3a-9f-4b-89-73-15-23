<?php 

foreach ($EWS_COUNT_UPDATED_LIST as $EWS_COUNT_UPDATED_ROWS): 
    
    $EWS_COUNTED_UPDATED_RE_INSTATED = $EWS_COUNT_UPDATED_ROWS['REINSTATED'];
    $EWS_COUNTED_UPDATED_WILL_CANCEL = $EWS_COUNT_UPDATED_ROWS['WILL_CANCEL'];
    $EWS_COUNTED_UPDATED_REDRAWN = $EWS_COUNT_UPDATED_ROWS['REDRAWN'];
    $EWS_COUNTED_UPDATED_WILL_REDRAW = $EWS_COUNT_UPDATED_ROWS['WILL_REDRAW'];
    $EWS_COUNTED_UPDATED_CANCELLED = $EWS_COUNT_UPDATED_ROWS['CANCELLED'];
    $EWS_COUNTED_UPDATED_FUTURE_CALLBACK = $EWS_COUNT_UPDATED_ROWS['FUTURE_CALLBACK'];

endforeach; ?>


<table  class="table table-hover">
    <thead>
        <tr>
            <th colspan="8">Updated</th>
        </tr>
    <th>Re-Instated</th>
    <th>Will Cancel</th>
    <th>Redrawn</th>
    <th>Will redraw</th>
    <th>Cancelled</th>
    <th>Callback</th>
    
    </thead>
    
    <tr>
        <th><?php if(isset($EWS_COUNTED_UPDATED_RE_INSTATED)) { echo $EWS_COUNTED_UPDATED_RE_INSTATED; } ?></th>
        <th><?php if(isset($EWS_COUNTED_UPDATED_WILL_CANCEL)) { echo $EWS_COUNTED_UPDATED_WILL_CANCEL; } ?></th>
        <th><?php if(isset($EWS_COUNTED_UPDATED_REDRAWN)) { echo $EWS_COUNTED_UPDATED_REDRAWN; } ?></th>
        <th><?php if(isset($EWS_COUNTED_UPDATED_WILL_REDRAW)) { echo $EWS_COUNTED_UPDATED_WILL_REDRAW; } ?></th>
        <th><?php if(isset($EWS_COUNTED_UPDATED_CANCELLED)) { echo $EWS_COUNTED_UPDATED_CANCELLED; } ?></th>
        <th><?php if(isset($EWS_COUNTED_UPDATED_FUTURE_CALLBACK)) { echo $EWS_COUNTED_UPDATED_FUTURE_CALLBACK; } ?></th>
        <th></th>
    </tr>
    
</table>   