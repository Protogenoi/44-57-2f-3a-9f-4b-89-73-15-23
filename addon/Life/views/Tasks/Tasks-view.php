    <?php foreach ($LifeTasksList as $LIFE_TASK_VARS): ?>


    <?php endforeach ?>

<?php

    $LIFE_TASK_HAPPY=$LIFE_TASK_VARS['life_tasks_happy'];
    $LIFE_TASK_EMAIL=$LIFE_TASK_VARS['life_tasks_email'];
    $LIFE_TASK_DD=$LIFE_TASK_VARS['life_tasks_dd'];
    $LIFE_TASK_FIRST=$LIFE_TASK_VARS['life_tasks_first_dd'];
    $LIFE_TASK_TRUST=$LIFE_TASK_VARS['life_tasks_trust'];
    $LIFE_TASK_TPS=$LIFE_TASK_VARS['life_tasks_tps'];

?>

<center>
                        <br><br>

                        <div class="btn-group">
                            <button data-toggle="collapse" data-target="#LIFE_TASK_HAPPY" class="<?php
                            if (empty($LIFE_TASK_HAPPY)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">Happy with Policy <br><?php if(isset($LIFE_TASK_HAPPY)) { echo $LIFE_TASK_HAPPY; } ?></button>   
                            
                            <button data-toggle="collapse" data-target="#LIFE_TASK_EMAIL" class="<?php
                            if (empty($LIFE_TASK_EMAIL)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">Doc's Emailed <br><?php echo $LIFE_TASK_EMAIL; ?></button>

                            <button data-toggle="collapse" data-target="#LIFE_TASK_CANCEL" class="<?php
                            if (empty($LIFE_TASK_DD)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">Cancelled DD's <br><?php echo $LIFE_TASK_DD; ?></button>                            
                            
                            <button data-toggle="collapse" data-target="#LIFE_TASK_FIRST" class="<?php
                            if (empty($LIFE_TASK_FIRST)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">Confirm 1st DD <br><?php echo $LIFE_TASK_FIRST; ?></button>
                            
                            <button data-toggle="collapse" data-target="#LIFE_TASK_TPS" class="<?php
                            if (empty($LIFE_TASK_TPS)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">TPS <br><?php echo $LIFE_TASK_TPS; ?></button>   
                            
                            <button data-toggle="collapse" data-target="#LIFE_TASK_TRUST" class="<?php
                            if (empty($LIFE_TASK_TRUST)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">Trust <br><?php echo $LIFE_TASK_TRUST; ?></button>                           

                        </div>                        
 
                        <br><br>

                       <form name="ClientTaskForm" id="ClientTaskForm" class="form-horizontal" method="POST" action="/addon/Life/php/Tasks.php?EXECUTE=3&CID=<?php echo "$search"; ?>">

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="singlebutton"></label>
                                <div class="col-md-4">
                                    <select id="TASK_NAME" class="form-control" name="TASK_NAME" required>
                                        <option value="">Select Task</option>
                                        <option value="48">48 hours</option>
                                        <option value="7 day">7 day</option>
                                        <option value="18 day">18 day</option>
                                        <option value="21 day">21 day</option>                                      
                                    </select>

                                </div>   
                            </div>


                            <div class="form-group">

                                <label class="col-md-4 control-label" for="singlebutton"></label>
                                <div class="col-md-4">
                                    <button class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok"></span> Update</button>

                                </div>
                            </div>
                            
                            <div id="LIFE_TASK_HAPPY" class="collapse">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="LIFE_TASK_HAPPY">Happy with Policy?</label>
                                    <div class="col-md-4"> 
                                        <label class="radio-inline" for="LIFE_TASK_HAPPY-0">
                                            <input name="LIFE_TASK_HAPPY" id="LIFE_TASK_HAPPY-0" value="No" type="radio" <?php
                            if (isset($LIFE_TASK_HAPPY)) {
                                if ($LIFE_TASK_HAPPY == 'No') {
                                    echo "checked='checked'";
                                }
                            }
                            ?>>
                                            No
                                        </label> 
                                        <label class="radio-inline" for="LIFE_TASK_HAPPY-1">
                                            <input name="LIFE_TASK_HAPPY" id="LIFE_TASK_HAPPY-1" value="Yes" type="radio" <?php
                            if (isset($LIFE_TASK_HAPPY)) {
                                if ($LIFE_TASK_HAPPY == 'Yes') {
                                    echo "checked='checked'";
                                }
                            }
                            ?>>
                                            Yes
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div id="LIFE_TASK_EMAIL" class="collapse">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="LIFE_TASK_EMAIL">Docs Emailed?</label>
                                    <div class="col-md-4"> 
                                        <label class="radio-inline" for="LIFE_TASK_EMAIL-0">
                                            <input name="LIFE_TASK_EMAIL" id="LIFE_TASK_EMAIL-0" value="Yes"  type="radio" <?php
                                        if (isset($LIFE_TASK_EMAIL)) {
                                            if ($LIFE_TASK_EMAIL == 'Yes') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            Yes
                                        </label> 
                                        <label class="radio-inline" for="LIFE_TASK_EMAIL-1">
                                            <input name="LIFE_TASK_EMAIL" id="LIFE_TASK_EMAIL-1" value="No" type="radio" <?php
                                        if (isset($LIFE_TASK_EMAIL)) {
                                            if ($LIFE_TASK_EMAIL == 'No') {
                                                echo "checked='checked'";
                                            }
                                        }
                                        ?>>
                                            No
                                        </label>
                                        <label class="radio-inline" for="LIFE_TASK_EMAIL-3">
                                            <input name="LIFE_TASK_EMAIL" id="LIFE_TASK_EMAIL-3" value="Not Checked" type="radio" <?php
                                        if (isset($LIFE_TASK_EMAIL)) {
                                            if ($LIFE_TASK_EMAIL == 'Not Checked') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            Not Checked
                                        </label>
                                    </div>
                                </div>

                            </div>
                            
                            <div id="LIFE_TASK_CANCEL" class="collapse">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="LIFE_TASK_CANCEL">Cancelled DD's</label>
                                    <div class="col-md-4"> 
                                        <label class="radio-inline" for="LIFE_TASK_CANCEL-0">
                                            <input name="LIFE_TASK_CANCEL" id="LIFE_TASK_CANCEL-0" value="Yes"  type="radio" <?php
                                        if (isset($LIFE_TASK_CANCEL)) {
                                            if ($LIFE_TASK_CANCEL == 'Yes') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            Yes
                                        </label> 
                                        <label class="radio-inline" for="LIFE_TASK_CANCEL-1">
                                            <input name="LIFE_TASK_CANCEL" id="LIFE_TASK_CANCEL-1" value="No" type="radio" <?php
                                        if (isset($LIFE_TASK_CANCEL)) {
                                            if ($LIFE_TASK_CANCEL == 'No') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            No
                                        </label>
                                        
                                    </div>
                                </div>

                            </div>                            

                            <div id="LIFE_TASK_FIRST" class="collapse">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="LIFE_TASK_FIRST">Confirm 1st DD</label>
                                    <div class="col-md-4"> 
                                        <label class="radio-inline" for="LIFE_TASK_FIRST-0">
                                            <input name="LIFE_TASK_FIRST" id="LIFE_TASK_FIRST-0" value="Yes"  type="radio" <?php
                                        if (isset($LIFE_TASK_FIRST)) {
                                            if ($LIFE_TASK_FIRST == 'Yes') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            Yes
                                        </label> 
                                        <label class="radio-inline" for="LIFE_TASK_FIRST-1">
                                            <input name="LIFE_TASK_FIRST" id="LIFE_TASK_FIRST-1" value="No" type="radio" <?php
                                        if (isset($LIFE_TASK_FIRST)) {
                                            if ($LIFE_TASK_FIRST == 'No') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            No
                                        </label>
                                        
                                    </div>
                                </div>

                            </div>                            

                            <div id="LIFE_TASK_TPS" class="collapse">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="LIFE_TASK_TPS">TPS</label>
                                    <div class="col-md-4"> 
                                        <label class="radio-inline" for="LIFE_TASK_TPS-0">
                                            <input name="LIFE_TASK_TPS" id="LIFE_TASK_TPS-0" value="Yes"  type="radio" <?php
                                        if (isset($LIFE_TASK_TPS)) {
                                            if ($LIFE_TASK_TPS == 'Yes') {
                                                echo "checked='checked'";
                                            }
                                        }
                                        ?>>
                                            Yes
                                        </label> 
                                        <label class="radio-inline" for="LIFE_TASK_TPS-1">
                                            <input name="LIFE_TASK_TPS" id="LIFE_TASK_TPS-1" value="No" type="radio" <?php
                                        if (isset($LIFE_TASK_TPS)) {
                                            if ($LIFE_TASK_TPS == 'No') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            No
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div id="LIFE_TASK_TRUST" class="collapse">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="LIFE_TASK_TRUST">Pitch Trust</label>
                                    <div class="col-md-4"> 
                                        <label class="radio-inline" for="LIFE_TASK_TRUST-0">
                                            <input name="LIFE_TASK_TRUST" id="LIFE_TASK_TRUST-0" value="Yes"  type="radio" <?php
                                        if (isset($LIFE_TASK_TRUST)) {
                                            if ($LIFE_TASK_TRUST == 'Yes') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            Yes
                                        </label> 
                                        <label class="radio-inline" for="LIFE_TASK_TRUST-1">
                                            <input name="LIFE_TASK_TRUST" id="LIFE_TASK_TRUST-1" value="No" type="radio" <?php
                                        if (isset($LIFE_TASK_TRUST)) {
                                            if ($LIFE_TASK_TRUST == 'No') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            No
                                        </label> 
                                        
                                    </div>
                                </div>

                            </div>

                    </center> 
                    </form>