            <div class="col-xs-4">
             <div class="notice notice-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><center><strong>Enemy units:</strong></center></div>
             <div class="row">
                 
<div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="TARGET_UNIT">Target Unit:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="TARGET_UNIT" id="UNIT" style="width: 170px" required>
                        <option value="">Select...</option>
                        <option disabled>─────HQ─────</option>
                        <option value="Lord of Contagion" <?php if($TARGET_UNIT=='Lord of Contagion') { echo "selected"; } ?> >Lord of Contagion</option>
                        <option value="Malignant Plaguecaster" <?php if($TARGET_UNIT=='Malignant Plaguecaster') { echo "selected"; } ?> >Malignant Plaguecaster</option>
                        <option disabled>─────ELITES─────</option>
                        <option value="Noxious Blightbringer" <?php if($TARGET_UNIT=='Noxious Blightbringer') { echo "selected"; } ?> >Noxious Blightbringer</option>
                        <option disabled>─────TROOPS─────</option>
                        <option value="Plague Marines" <?php if($TARGET_UNIT=='Plague Marines') { echo "selected"; } ?> >Plague Marines</option>
                        <option value="Plague Champion" <?php if($TARGET_UNIT=='Plague Champion') { echo "selected"; } ?> >Plague Champion</option>
                        <option value="Pox walkers" <?php if($TARGET_UNIT=='Pox walkers') { echo "selected"; } ?> >Pox walkers</option>
                        <option disabled>─────FAST ATTACK─────</option>
                        <option value="Foetid Bloat-Drone" <?php if($TARGET_UNIT=='Foetid Bloat-Drone') { echo "selected"; } ?> >Foetid Bloat-Drone</option>
                        <option disabled>─────HEAVY SUPPORT─────</option>
                    </select>
                </div>     
            </div>                   
                 
                 
                              </div>

        </div>