<center>
                        <br><br>
<div class="btn-group">

    <?php foreach ($LifeWorkflowsList as $WORKFLOW_TASK_VARS): ?>

<?php 

    $ADL_TASK_TITLE=$WORKFLOW_TASK_VARS['adl_tasks_title'];
    $ADL_TASK_OUTCOME=$WORKFLOW_TASK_VARS['adl_tasks_outcome'];
    
?>

                            <button data-toggle="collapse" data-target="#<?php echo str_replace(' ', '', $ADL_TASK_TITLE); ?>" class="<?php
                            if (empty($ADL_TASK_OUTCOME)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>"><?php echo $ADL_TASK_TITLE; ?> <br><?php if(isset($ADL_TASK_OUTCOME)) { echo $ADL_TASK_OUTCOME; } ?></button>   

    <?php endforeach ?>

 <br><br>

                       <form name="ClientTaskForm" id="ClientTaskForm" class="form-horizontal" method="POST" action="/addon/Workflows/php/update_workflow.php?EXECUTE=1&CID=<?php echo "$search"; ?>">

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="singlebutton"></label>
                                <div class="col-md-4">
                                    <select id="TASK_NAME" class="form-control" name="TASK_NAME" required>
                                        <option value="">Select Task</option>
                                        <option value="48 hour">48 hour</option>
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
                           
                   <?php foreach ($LifeWorkflowsList as $WORKFLOW_TASK_VARS): 
                       
                           $ADL_TASK_TITLE=$WORKFLOW_TASK_VARS['adl_tasks_title'];
    $ADL_TASK_OUTCOME=$WORKFLOW_TASK_VARS['adl_tasks_outcome'];
                       
                       ?>        

                            <div id="<?php echo str_replace(' ', '', $ADL_TASK_TITLE); ?>" class="collapse">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="<?php echo $ADL_TASK_TITLE; ?>"><?php echo $ADL_TASK_TITLE; ?></label>
                                    <div class="col-md-4"> 
                                        <label class="radio-inline" for="<?php echo $ADL_TASK_TITLE; ?>-0">
                                            <input name="<?php echo str_replace(' ', '', $ADL_TASK_TITLE); ?>" id="<?php echo str_replace(' ', '', $ADL_TASK_TITLE); ?>-0" value="Yes"  type="radio" <?php
                                        if (isset($ADL_TASK_OUTCOME)) {
                                            if ($ADL_TASK_OUTCOME == 'Yes') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            Yes
                                        </label> 
                                        <label class="radio-inline" for="<?php echo $ADL_TASK_TITLE; ?>-1">
                                            <input name="<?php echo str_replace(' ', '', $ADL_TASK_TITLE); ?>" id="<?php echo str_replace(' ', '', $ADL_TASK_TITLE); ?>-1" value="No" type="radio" <?php
                                        if (isset($ADL_TASK_OUTCOME)) {
                                            if ($ADL_TASK_OUTCOME == 'No') {
                                                echo "checked='checked'";
                                            }
                                        }
                                        ?>>
                                            No
                                        </label>

                                    </div>
                                </div>

                            </div>
                           
                            <?php endforeach ?>
                            
                    </form>      
    
</div>
</center>                       