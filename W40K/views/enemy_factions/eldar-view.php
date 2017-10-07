            <div class="col-xs-4">
             <div class="notice notice-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><center><strong>Enemy units:</strong></center></div>
             <div class="row">
                 
<div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="TARGET_UNIT">Target Unit:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="TARGET_UNIT" id="UNIT" style="width: 170px" required>
                        <option value="">Select...</option>
                        <option disabled>─────HQ─────</option>
                        <option value="Eldrad Ulthran" <?php if($TARGET_UNIT=='Eldrad Ulthran') { echo "selected"; } ?> >Eldrad Ulthran</option>
                        <option value="Warlock" <?php if($TARGET_UNIT=='Warlock') { echo "selected"; } ?> >Warlock</option>
                        <option disabled>─────ELITES─────</option>
                        <option disabled>─────TROOPS─────</option>
                        <option value="Guardian Defenders" <?php if($TARGET_UNIT=='Guardian Defenders') { echo "selected"; } ?> >Guardian Defenders</option>
                        <option value="Rangers" <?php if($TARGET_UNIT=='Rangers') { echo "selected"; } ?> >Rangers</option>
                        <option value="Dire Avengers" <?php if($TARGET_UNIT=='Dire Avengers') { echo "selected"; } ?> >Dire Avengers</option>
                        <option value="Dire Avengers Exarch" <?php if($TARGET_UNIT=='Dire Avengers Exarch') { echo "selected"; } ?> >Dire Avengers Exarch</option>
                        <option disabled>─────FAST ATTACK─────</option>
                        <option disabled>─────HEAVY SUPPORT─────</option>
                        <option value="Dark Reapers" <?php if($TARGET_UNIT=='Dark Reapers') { echo "selected"; } ?> >Dark Reapers</option>
                        <option value="Dark Reapers Exarch" <?php if($TARGET_UNIT=='Dark Reapers Exarch') { echo "selected"; } ?> >Dark Reapers Exarch</option>
                    </select>
                </div>     
            </div>                   
                 
                 
                              </div>

        </div>