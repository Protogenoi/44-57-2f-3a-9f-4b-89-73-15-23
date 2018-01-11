<div class="container">
    <div class="col-md-12">
                                <table id="tracker" class="table table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Row</th>
                                            <th>Date</th>
                                            <th>Agent</th>
                                            <th>Phone</th>
                                            <th>Call Count</th>
                                            <th>Comments</th>
                                            <th>DISPO</th>
                                            <th></th>
                                        </tr>
                                    </thead>   
                                    
                                   <?php $SURVEY_ROW_ID=0; ?>
                                    
    <?php foreach ($SURVEY_USER_DATED_DATA_LIST_R as $STATS_result): 
        
        $SURVEY_ROW_ID++;
    $SID=$STATS_result['survey_tracker_id'];
    $SURVEY_AGENT=$STATS_result['survey_tracker_agent'];
    $SURVEY_DATE=$STATS_result['DATE'];
    $SURVEY_PHONE=$STATS_result['survey_tracker_number'];
    $SURVEY_CALL_COUNT=$STATS_result['survey_tracker_call_count'];
    $SURVEY_NOTES=$STATS_result['survey_tracker_notes'];
    $SURVEY_STATUS=$STATS_result['survey_tracker_status'];
        
        ?>
                                    
                                    <form method="POST" action="/addon/Trackers/php/Survey.php?EXECUTE=3<?php if(isset($SID)) { echo "&SID=$SID"; } ?>">
                                        <tr>
                                            <td><?php if(isset($SURVEY_ROW_ID)) { echo $SURVEY_ROW_ID; } ?></td>
                                            <td><?php if(isset($SURVEY_DATE)) { echo $SURVEY_DATE; } ?></td>
                                            <td><?php if(isset($SURVEY_AGENT)) { echo $SURVEY_AGENT; } ?></td>
                                            <td><?php if(isset($SURVEY_PHONE)) { echo $SURVEY_PHONE; } ?></td>
                                            <td><?php if(isset($SURVEY_CALL_COUNT)) { echo $SURVEY_CALL_COUNT; } ?></td>
                                            <td><textarea name="NOTES" class="form-control" data-toggle="tooltip"><?php if(isset($SURVEY_NOTES)) { echo $SURVEY_NOTES; } ?></textarea></td>
                                            <td><select name="DISPO" class="form-control" required>
                                                    <?php
                                                    if(isset($SURVEY_STATUS) && $SURVEY_STATUS == 'NEW') { 
                                                    ?>
                                                    <option value="NEW" selected>New lead</option>
                                                    <?php } ?>
                                                            <option value="NA" <?php if(isset($SURVEY_STATUS) && $SURVEY_STATUS == 'NA') { echo "selected"; } ?>>No answer</option>
                                                            <option value="AA" <?php if(isset($SURVEY_STATUS) && $SURVEY_STATUS == 'AA') { echo "selected"; } ?>>Answer machine</option>
                                                            <option value="NI" <?php if(isset($SURVEY_STATUS) && $SURVEY_STATUS == 'NI') { echo "selected"; } ?>>Not interested</option>
                                                            <option value="B" <?php if(isset($SURVEY_STATUS) && $SURVEY_STATUS == 'B') { echo "selected"; } ?>>Busy</option>
                                                            <option value="WN" <?php if(isset($SURVEY_STATUS) && $SURVEY_STATUS == 'WN') { echo "selected"; } ?>>Wrong number</option>
                                                            <option value="XFER" <?php if(isset($SURVEY_STATUS) && $SURVEY_STATUS == 'XFER') { echo "selected"; } ?>>Transfered</option>
                                                </select></td>
                                                <td><button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-save"></i> </button></td>
                                        </tr>
                                    </form>

    
   <?php endforeach ?>
                                    
                                </table>
    </div>
</div>