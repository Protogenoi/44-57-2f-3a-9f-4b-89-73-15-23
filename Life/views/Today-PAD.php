 <table id="pad" class="table table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Lead</th>
                                <th>COMM</th>
                                <th>Closer</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
    <?php $i='0'; foreach ($TodayPadList as $Today_Pad): ?>


        <?php
        $i++;
                $PAD_id = $Today_Pad['pad_statistics_id'];
                $PAD_lead = $Today_Pad['pad_statistics_lead'];
                $PAD_closer = $Today_Pad['pad_statistics_closer'];
                $PAD_notes = $Today_Pad['pad_statistics_notes'];
                $PAD_status = $Today_Pad['pad_statistics_status'];
                $PAD_our_col = $Today_Pad['pad_statistics_col'];
?>
                                     <input type="hidden" value="<?php echo $PAD_id; ?>" name="pad_id">
                                     <td><?php echo $i; ?></td>
                                <td><input size="8" class="form-control" type="text" name="lead" id="provider-json" value="<?php if (isset($PAD_lead)) {
                    echo $PAD_lead;
                } ?>"></td>                      
                                <td><input size="4" class="form-control" type="text" name="col" value="<?php if (isset($PAD_our_col)) {
                    echo $PAD_our_col;
                } ?>"></td>
                                <td><input size="12" class="form-control" type="text" name="closer" value="<?php if (isset($PAD_closer)) {
                    echo $PAD_closer;
                } ?>"></td>
                                <td><input size="8" class="form-control" type="text" name="notes" value="<?php if (isset($PAD_notes)) {
                    echo $PAD_notes;
                } ?>"></td>
                                <td><select name="status" class="form-control" required>
                                        <option>Select Status</option>
                                        <option <?php if (isset($PAD_status)) {
                    if ($PAD_status == 'Green') {
                        echo "selected";
                    }
                } ?> value="Green">Green</option>
                                        <option <?php if (isset($PAD_status)) {
                    if ($PAD_status == 'Red') {
                        echo "selected";
                    }
                } ?> value="Red">Red</option>
                                        <option <?php if (isset($PAD_status)) {
                    if ($PAD_status == 'White') {
                        echo "selected";
                    }
                } ?> value="White">White</option>
                                    
                                    </select></td>
                                    <td><a href='Pad.php?query=Edit&PAD_ID=<?php echo $PAD_id; ?>' class='btn btn-info btn-xs'><i class='fa fa-edit'></i> EDIT</a>
 <?php if(in_array($hello_name, $Level_10_Access, true)) { ?>                               
 <a href='../php/Pad.php?query=Delete&pad_id=<?php echo $PAD_id; ?>' class='btn btn-danger btn-xs confirmation'><i class='fa fa-trash'></i> DELETE</a></td> </tr>
                        
     <?php } ?>

    <?php endforeach ?>
          <script type="text/javascript">
                                    var elems = document.getElementsByClassName('confirmation');
                                    var confirmIt = function (e) {
                                        if (!confirm('Are you sure you want delete this record?'))
                                            e.preventDefault();
                                    };
                                    for (var i = 0, l = elems.length; i < l; i++) {
                                        elems[i].addEventListener('click', confirmIt, false);
                                    }
                                </script>
</table> 