       
            <div class="col-xs-4">
              <div class="notice notice-success fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><center><strong>Your units:</strong></center></div>
          
<div class="row">

<div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="UNIT">Unit:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="UNIT" id="UNIT" style="width: 170px" required>
                        <option value="">Select...</option>
                        <option disabled>─────TROOPS─────</option>
                        <option value="Intercessor Squad" <?php if(isset($UNIT) && $UNIT=='Intercessor Squad') { echo "selected"; } ?> >Intercessor Squad</option>
                        <option value="Tactical Squad" <?php if(isset($UNIT) && $UNIT=='Tactical Squad') { echo "selected"; } ?> >Tactical Squad</option>
                        <option value="Scout Squad" <?php if(isset($UNIT) && $UNIT=='Scout Squad') { echo "selected"; } ?> >Scout Squad</option>
                    </select>
                </div>     
            </div>  
            
            <div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="MODELS_TO_FIRE">Models firing:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="MODELS_TO_FIRE" id="MODELS_TO_FIRE" style="width: 170px" required>
                        <option value="">Select...</option>
                            <?php for ($SQUAD_SIZE_COUNT = 10; $SQUAD_SIZE_COUNT > 0; $SQUAD_SIZE_COUNT = $SQUAD_SIZE_COUNT - 1) {
                                                            if($SQUAD_SIZE_COUNT> 11) {
                                                               break; 
                                                    } 
                                                            ?>
                        <option value="<?php if(isset($SQUAD_SIZE_COUNT)) { echo $SQUAD_SIZE_COUNT; } ?>" <?php if($MODELS_TO_FIRE==$SQUAD_SIZE_COUNT) { echo "selected"; } ?> ><?php if(isset($SQUAD_SIZE_COUNT)) { echo $SQUAD_SIZE_COUNT; } ?></option>

                        <?php } ?>
                    </select>
                </div>     
            </div>
         
            <div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="UNIT_WEAPON">Weapon:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="UNIT_WEAPON" id="UNIT_WEAPON" style="width: 170px" required>
                        <?php if(isset($UNIT_WEAPON)) {
                            if($UNIT=='Intercessor Squad') {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value="Auto Bolt Rifle" <?php if($UNIT_WEAPON=='Auto Bolt Rifle') { echo "selected"; } ?> >Auto Bolt Rifle</option>
                        <option value="Stalker Bolt Rifle" <?php if($UNIT_WEAPON=='Stalker Bolt Rifle') { echo "selected"; } ?> >Stalker Bolt Rifle</option>
                        <option value="Bolt Rifle" <?php if($UNIT_WEAPON=='Bolt Rifle') { echo "selected"; } ?> >Bolt Rifle</option>
                        <option value="Bolt Pistol" <?php if($UNIT_WEAPON=='Bolt Pistol') { echo "selected"; } ?> >Bolt Pistol</option>
                        <option value="Frag grenade" <?php if($UNIT_WEAPON=='Frag grenade') { echo "selected"; } ?> >Frag grenade</option>
                        <option value="Krak grenade" <?php if($UNIT_WEAPON=='Krak grenade') { echo "selected"; } ?> >Krak grenade</option>                        
                            <?php } } else { ?>
                        <option value=''>Select...</option>
                            <?php } ?>
                    </select>
                </div>     
            </div>
        <script>
$(document).ready(function () {
    $("#UNIT").change(function () {
        var val = $(this).val();  
        if (val === "Intercessor Squad") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Auto Bolt Rifle'>Auto Bolt Rifle</option><option value='Stalker Bolt Rifle'>Stalker Bolt Rifle</option><option value='Bolt Rifle'>Bolt Rifle</option><option value='Bolt Pistol'>Bolt Pistol</option><option value='Frag grenade'>Frag grenade</option><option value='Krak grenade'>Krak grenade</option>");
        } else if (val === "Tactical Squad") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Boltgun'>Boltgun</option><option value='Bolt Pistol'>Bolt Pistol</option><option value='Frag grenade'>Frag grenade</option><option value='Krak grenade'>Krak grenade</option><option disabled>─────Heavy Weapons─────</option><option value='Grav-cannon and grav-amp'>Grav-cannon and grav-amp</option><option value='Heavy bolter'>Heavy bolter</option><option value='Lascannon'>Lascannon</option><option value='Missile launcher'>Missile launcher</option><option value='Multi-meta'>Multi-melta</option><option value='Plasma cannon'>Plasma cannon</option><option disabled>─────Special Weapons─────</option><option value='Flamer'>Flamer</option><option value='Grav-gun'>Grav-gun</option><option value='Meltagun'>Meltagun</option><option value='Plasma gun'>Plasma gun</option>");
        } else if (val === "Scout Squad") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Boltgun'>Boltgun</option><option value='Bolt Pistol'>Bolt Pistol</option><option value='Frag grenade'>Frag grenade</option><option value='Krak grenade'>Krak grenade</option><option value='Astartes shotgun'>Astartes shotgun</option><option value='Heavy Bolter'>Heavy Bolter</option><option value='Missile launcher'>Missile launcher</option><option value='Sniper rifle'>Sniper rifle</option>");
        }
    });
});        
</script>
            <div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="MOVEMENT">Movement:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="MOVEMENT" id="MOVEMENT" style="width: 170px" required>
                        <option value="">Select...</option> 
                        <option value="Stationary" <?php if($MOVEMENT=='Stationary') { echo "selected"; } ?> >Stationary</option>
                        <option value="Moved" <?php if($MOVEMENT=='Moved') { echo "selected"; } ?> >Moved</option>
                        <option value="Advanced" <?php if($MOVEMENT=='Advanced') { echo "selected"; } ?> >Advanced</option>
                        <option value="Charged" <?php if($MOVEMENT=='Charged') { echo "selected"; } ?> >Charged</option>
                    </select>
                </div>     
            </div>   

            <div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="RAPID_FIRE">Models in Rapid fire:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="RAPID_FIRE" id="RAPID_FIRE" style="width: 170px" required>
                        <option value="">Select...</option>
                        <?php if(isset($RAPID_FIRE) && $RAPID_FIRE==0) { ?>
                        <option value="0" selected>0</option>
                        <?php } ?>
                            <?php for ($RAPID_FIRE_COUNT = 10; $RAPID_FIRE_COUNT > 0; $RAPID_FIRE_COUNT = $RAPID_FIRE_COUNT - 1) {
                                                            if($RAPID_FIRE_COUNT> 11) {
                                                               break; 
                                                    } 
                                                            ?>
                        <option value="<?php if(isset($RAPID_FIRE_COUNT)) { echo $RAPID_FIRE_COUNT; } ?>" <?php if($RAPID_FIRE==$RAPID_FIRE_COUNT) { echo "selected"; } ?> ><?php if(isset($RAPID_FIRE_COUNT)) { echo $RAPID_FIRE_COUNT; } ?></option>

                        <?php } ?>
                        <option value="0">0</option>
                    </select>
                </div>     
            </div> 
</div>

            
       
        </div>
