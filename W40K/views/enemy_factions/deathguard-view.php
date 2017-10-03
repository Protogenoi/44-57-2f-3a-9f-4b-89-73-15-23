            <div class="col-xs-4">
             <div class="notice notice-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><center><strong>Enemy units:</strong></center></div>
             <div class="row">
                 
<div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="TARGET_UNIT">Target Unit:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="TARGET_UNIT" id="UNIT" style="width: 170px" required>
                        <option value="">Select...</option>
                        <option disabled>─────TROOPS─────</option>
                        <option value="Deathguard" <?php if($TARGET_UNIT=='Deathguard') { echo "selected"; } ?> >Deathguard</option>
                        <option value="Pox walkers" <?php if($TARGET_UNIT=='Pox walkers') { echo "selected"; } ?> >Pox walkers</option>
                    </select>
                </div>     
            </div>                   
                 
                 
                              </div>

        </div>