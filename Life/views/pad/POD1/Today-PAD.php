 <table id="pad" class="table table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Added/Updated</th>
                                <th>Lead</th>
                                <th>COMM</th>
                                <th>Closer</th>
                                <th>Notes</th>
                                <th>Team</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
    <?php $i='0'; foreach ($TodayPadList as $Overview_All_Pad): ?>


        <?php
        $i++;
                $OVR_group = $Overview_All_Pad['pad_statistics_group'];
                $OVR_id = $Overview_All_Pad['pad_statistics_id'];
                $OVR_lead = $Overview_All_Pad['pad_statistics_lead'];
                $OVR_closer = $Overview_All_Pad['pad_statistics_closer'];
                $OVR_notes = $Overview_All_Pad['pad_statistics_notes'];
                $OVR_status = $Overview_All_Pad['pad_statistics_status'];
                $OVR_our_col = $Overview_All_Pad['pad_statistics_col'];
                $OVR_our_date = $Overview_All_Pad['pad_statistics_update_date'];
?>
                        <form action="../php/Pad.php?query=Edit" method="POST">            
                        <input type="hidden" value="<?php echo $OVR_id; ?>" name="pad_id">
                                     <td><?php echo $i; ?></td>
                                            <td><input size="4" disabled class="form-control" type="text" name="date" id="date" value="<?php if (isset($OVR_our_date)) {
                    echo $OVR_our_date;
                } ?>"></td>   
                                <td><input size="8" class="form-control" type="text" name="lead" id="provider-json" value="<?php if (isset($OVR_lead)) {
                    echo $OVR_lead;
                } ?>"></td>                      
                                <td><input size="4" class="form-control" type="text" name="col" value="<?php if (isset($OVR_our_col)) {
                    echo $OVR_our_col;
                } ?>"></td>
                                <td><input size="12" class="form-control" type="text" name="closer" value="<?php if (isset($OVR_closer)) {
                    echo $OVR_closer;
                } ?>"></td>
                                <td><input size="8" class="form-control" type="text" name="notes" value="<?php if (isset($OVR_notes)) {
                    echo $OVR_notes;
                } ?>"></td>
                                <td> <select id="group" name="group" class="form-control" required>
                        <option <?php
                        if (isset($OVR_group)) {
                            if ($OVR_group == 'POD 1') {
                                echo "selected";
                            }
                        }
                        ?> value="POD 1" selected>POD 1</option>
                        <option <?php
                        if (isset($OVR_group)) {
                            if ($OVR_group == 'POD 2') {
                                echo "selected";
                            }
                        }
                        ?> value="POD 2">POD 2</option>
                        <option <?php
                        if (isset($OVR_group)) {
                            if ($OVR_group == 'POD 3') {
                                echo "selected";
                            }
                        }
                        ?> value="POD 3">POD 3</option>
                        <option <?php
                        if (isset($OVR_group)) {
                            if ($OVR_group == 'POD 4') {
                                echo "selected";
                            }
                        }
                        ?> value="POD 4">POD 4</option>
                        <option <?php
                            if (isset($OVR_group)) {
                                if ($OVR_group == 'POD 5') {
                                    echo "selected";
                                }
                            }
                            ?> value="POD 5">POD 5</option>
                        <option <?php
                        if (isset($OVR_group)) {
                            if ($OVR_group == 'POD 6') {
                                echo "selected";
                            }
                        }
                        ?> value="POD 6">POD 6</option>
                        <option <?php
                        if (isset($OVR_group)) {
                            if ($OVR_group == 'Training') {
                                echo "selected";
                            }
                        }
                        ?> value="Training">Training</option>
                        <option <?php
                        if (isset($OVR_group)) {
                            if ($OVR_group == 'Closers') {
                                echo "selected";
                            }
                        }
                        ?> value="Closers">Closers</option>
                        <option <?php
                        if (isset($OVR_group)) {
                            if ($OVR_group == 'Admin') {
                                echo "selected";
                            }
                        }
                        ?> value="Admin">Admin</option>
                    </select></td>
                                <td><select name="status" class="form-control" required>
                                        <option>Select Status</option>
                                        <option <?php if (isset($OVR_status)) {
                    if ($OVR_status == 'Green') {
                        echo "selected";
                    }
                } ?> value="Green">Green</option>
                                        <option <?php if (isset($OVR_status)) {
                    if ($OVR_status == 'Red') {
                        echo "selected";
                    }
                } ?> value="Red">Red</option>
                                        <option <?php if (isset($OVR_status)) {
                    if ($OVR_status == 'White') {
                        echo "selected";
                    }
                } ?> value="White">White</option>
                                    
                                    </select></td>
                                    <td>
                                        <a href='Pad.php?query=Edit&OVR_ID=<?php echo $OVR_id; ?>' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i> </a>
                                        <?php if(in_array($hello_name, $Level_9_Access, true)) { ?>     
                                        <button class='btn btn-success btn-sm'><i class='fa fa-check-circle-o'></i> </button>
                                        <a href='../php/Pad.php?query=Delete&pad_id=<?php echo $OVR_id; ?>' class='btn btn-danger btn-sm confirmation'><i class='fa fa-trash'></i> </a></td> 
                        </tr>
                                            <?php } ?>
</form>
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