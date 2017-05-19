                                <table id="tracker" class="table table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Row</th>
                                            <th>Date</th>
                                            <th>Closer</th>
                                            <th>Agent</th>
                                            <th>Client</th>
                                            <th>Phone</th>
                                            <th>Current Premium</th>
                                            <th>Our Premium</th>
                                            <th>Comments</th>
                                            <th>DISPO</th>
                                            <th>DEC?</th>
                                            <th>MTG</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    
    <?php $i='0'; foreach ($CloserPadList as $TRACKER_EDIT_result): ?>

                                            <?php
                $i++;
                                        $TRK_EDIT_tracker_id = $TRACKER_EDIT_result['tracker_id'];
                                        $TRK_EDIT_agent = $TRACKER_EDIT_result['agent'];
                                        $TRK_EDIT_closer = $TRACKER_EDIT_result['closer'];
                                        $TRK_EDIT_client = $TRACKER_EDIT_result['client'];
                                        $TRK_EDIT_phone = $TRACKER_EDIT_result['phone'];
                                        $TRK_EDIT_current_premium = $TRACKER_EDIT_result['current_premium'];

                                        $TRK_EDIT_our_premium = $TRACKER_EDIT_result['our_premium'];
                                        $TRK_EDIT_comments = $TRACKER_EDIT_result['comments'];
                                        $TRK_EDIT_sale = $TRACKER_EDIT_result['sale'];

                                        $TRK_EDIT_MTG = $TRACKER_EDIT_result['mtg'];
                                        $TRK_EDIT_LEAD_UP = $TRACKER_EDIT_result['lead_up'];

                                        $TRK_EDIT_DATE = $TRACKER_EDIT_result['updated_date'];
?>
                                    <form method="POST" action="/Life/Trackers/php/Trackers.php?EXECUTE=2&TYPE=CLOSER">
               <input type="hidden" value="<?php echo $TRK_EDIT_tracker_id; ?>" name="tracker_id">
                                    <tr>
                                                                                                         <td><?php if (isset($i)) {
                    echo $i;
                } ?></td>                                         
                                                                <td><?php if (isset($TRK_EDIT_DATE)) {
                    echo $TRK_EDIT_DATE;
                } ?></td>    
                                        
                <td><input size="8" class="form-control" type="text" name="closer" id="provider-json" value="<?php if (isset($TRK_EDIT_agent)) {
                    echo $TRK_EDIT_closer;
                } ?>"></td>     
                                <td><input size="8" class="form-control" type="text" name="agent_name" id="provider-json" value="<?php if (isset($TRK_EDIT_agent)) {
                    echo $TRK_EDIT_agent;
                } ?>"></td>                      
                                <td><input size="8" class="form-control" type="text" name="client" value="<?php if (isset($TRK_EDIT_client)) {
                    echo $TRK_EDIT_client;
                } ?>"></td>
                                <td><input size="12" class="form-control" type="text" name="phone" value="<?php if (isset($TRK_EDIT_phone)) {
                    echo $TRK_EDIT_phone;
                } ?>"></td>
                                <td><input size="5" class="form-control" type="text" name="current_premium" value="<?php if (isset($TRK_EDIT_current_premium)) {
                    echo $TRK_EDIT_current_premium;
                } ?>"></td>
                                <td><input size="5" class="form-control" type="text" name="our_premium" value="<?php if (isset($TRK_EDIT_our_premium)) {
                    echo $TRK_EDIT_our_premium;
                } ?>"></td>
                                <td><input type="text" class="form-control" name="comments" value="<?php if (isset($TRK_EDIT_comments)) {
                    echo $TRK_EDIT_comments;
                } ?>"></td>
                                <td>
                                    <select name="sale" class="form-control" required>
                                        <option value="">DISPO</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'SALE') {
                        echo "selected";
                    }
                } ?> value="SALE">Sale</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QUN') {
                        echo "selected";
                    }
                } ?> value="QUN">Underwritten</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QQQ') {
                        echo "selected";
                    }
                } ?> value="QQQ">Quoted</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QNQ') {
                        echo "selected";
                    }
                } ?> value="QNQ">No Quote</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QML') {
                        echo "selected";
                    }
                } ?> value="QML">Quote Mortgage Lead</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QDE') {
                        echo "selected";
                    }
                } ?> value="QDE">Decline</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'QCBK') {
                        echo "selected";
                    }
                } ?> value="QCBK">Quoted Callback</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'NoCard') {
                        echo "selected";
                    }
                } ?> value="NoCard">No Card</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'DIDNO') {
                        echo "selected";
                    }
                } ?> value="DIDNO">Quote Not Beaten</option>
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'DETRA') {
                        echo "selected";
                    }
                } ?> value="DETRA">Declined but passed to upsale</option>
                <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'Hangup on XFER') {
                        echo "selected";
                    }
                } ?> value="Hangup on XFER">Hangup on XFER</option>
                                <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'Thought we were an insurer') {
                        echo "selected";
                    }
                } ?> value="Thought we were an insurer">Thought we were an insurer</option> 
                                        <option <?php if (isset($TRK_EDIT_sale)) {
                    if ($TRK_EDIT_sale == 'Other') {
                        echo "selected";
                    }
                } ?> value="Other">Other</option>
                                    </select>
                                </td>
                                
                                <td>
                                    <select name="LEAD_UP">
                                        <option <?php if(isset($TRK_EDIT_LEAD_UP) && $TRK_EDIT_LEAD_UP=='No') { echo "selected"; } ?> value="No">No</option>
                                        <option <?php if(isset($TRK_EDIT_LEAD_UP) && $TRK_EDIT_LEAD_UP=='Yes') { echo "selected"; } ?> value="Yes">Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="MTG">
                                        <option <?php if(isset($TRK_EDIT_MTG) && $TRK_EDIT_MTG=='No') { echo "selected"; } ?> value="No">No</option>
                                        <option <?php if(isset($TRK_EDIT_MTG) && $TRK_EDIT_MTG=='Yes') { echo "selected"; } ?> value="Yes">Yes</option>
                                    </select>
                                </td>
                                
                                <td><button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-save"></i> </button></td> 
                                    </tr>
                                    </form>

    <?php endforeach ?>
         
</table> 