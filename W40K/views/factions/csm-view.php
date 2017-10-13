       
            <div class="col-xs-4">
              <div class="notice notice-success fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><center><strong>Your units:</strong></center></div>
          
<div class="row">

<div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="UNIT">Unit:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="UNIT" id="UNIT" style="width: 170px" required>
                        <option value="">Select...</option>
                        <option disabled>─────HQ─────</option>
                        <option value="Kharn the Betrayer" <?php if($UNIT=='Kharn the Betrayer') { echo "selected"; } ?> >Kharn the Betrayer</option>
                        <option value="Abaddon the Despoiler" <?php if($UNIT=='Abaddon the Despoiler') { echo "selected"; } ?> >Abaddon the Despoiler</option>
                        <option value="Khorne Daemon Prince" <?php if($UNIT=='Khorne Daemon Prince') { echo "selected"; } ?> >Khorne Daemon Prince</option>
                        <option value="Khorne Winged Daemon Prince" <?php if($UNIT=='Khorne Winged Daemon Prince') { echo "selected"; } ?> >Khorne Winged Daemon Prince</option>
                        <option value="Nurgle Daemon Prince" <?php if($UNIT=='Nurgle Daemon Prince') { echo "selected"; } ?> >Nurgle Daemon Prince</option> 
                        <option value="Nurgle Winged Daemon Prince" <?php if($UNIT=='Nurgle Winged Daemon Prince') { echo "selected"; } ?> >Nurgle Winged Daemon Prince</option> 
                        <option value="Slaanesh Daemon Prince" <?php if($UNIT=='Slaanesh Daemon Prince') { echo "selected"; } ?> >Slaanesh Daemon Prince</option> 
                        <option value="Slaanesh Winged Daemon Prince" <?php if($UNIT=='Slaanesh Winged Daemon Prince') { echo "selected"; } ?> >Slaanesh Winged Daemon Prince</option> 
                        <option value="Tzeentch Daemon Prince" <?php if($UNIT=='Tzeentch Daemon Prince') { echo "selected"; } ?> >Tzeentch Daemon Prince</option>
                        <option value="Tzeentch Winged Daemon Prince" <?php if($UNIT=='Tzeentch Winged Daemon Prince') { echo "selected"; } ?> >Tzeentch Winged Daemon Prince</option>
                        <option disabled>─────ELITES─────</option>
                        <option value="Khorne Bezerkers" <?php if($UNIT=='Khorne Bezerkers') { echo "selected"; } ?> >Khorne Bezerkers</option>
                        <option value="Bezerker Champion" <?php if($UNIT=='Bezerker Champion') { echo "selected"; } ?> >Bezerker Champion</option>
                        <option value="Rubric Marines" <?php if($UNIT=='Rubric Marines') { echo "selected"; } ?> >Rubric Marines</option>
                        <option value="Aspiring Sorcerer" <?php if($UNIT=='Aspiring Sorcerer') { echo "selected"; } ?> >Aspiring Sorcerer</option>
                        <option value="Plague Marines" <?php if($UNIT=='Plague Marines') { echo "selected"; } ?> >Plague Marines</option>
                        <option value="Plague Champion" <?php if($UNIT=='Plague Champion') { echo "selected"; } ?> >Plague Champion</option>
                        <option value="Chaos Terminator" <?php if($UNIT=='Chaos Terminator') { echo "selected"; } ?> >Chaos Terminator</option>
                        <option value="Terminator Champion" <?php if($UNIT=='Terminator Champion') { echo "selected"; } ?> >Terminator Champion</option>
                        <option value="Helbrute" <?php if($UNIT=='Helbrute') { echo "selected"; } ?> >Helbrute</option>                        
                        <option disabled>─────TROOPS─────</option>
                        <option value="Chaos Space Marines" <?php if($UNIT=='Chaos Space Marines') { echo "selected"; } ?> >Chaos Space Marines</option>
                        <option value="Aspiring Champion" <?php if($UNIT=='Aspiring Champion') { echo "selected"; } ?> >Aspiring Champion</option>
                        <option value="Chaos Cultists" <?php if($UNIT=='Chaos Cultists') { echo "selected"; } ?> >Chaos Cultists</option>
                        <option value="Cultist Champion" <?php if($UNIT=='Cultist Champion') { echo "selected"; } ?> >Cultist Champion</option>
                        <option value="Bloodletters" <?php if($UNIT=='Bloodletters') { echo "selected"; } ?> >Bloodletters</option>
                        <option value="Bloodreaper" <?php if($UNIT=='Bloodreaper') { echo "selected"; } ?> >Bloodreaper</option>
                        <option value="Pink Horrors" <?php if($UNIT=='Pink Horrors') { echo "selected"; } ?> > Pink Horrors</option>
                        <option value="Blue Horrors" <?php if($UNIT=='Blue Horrors') { echo "selected"; } ?> > Blue Horrors</option>
                        <option value="Pair of Brimstone Horrors" <?php if($UNIT=='Pair of Brimstone Horrors') { echo "selected"; } ?> > Pair of Brimstone Horrors</option>
                        <option value="Plaguebearers" <?php if($UNIT=='Plaguebearers') { echo "selected"; } ?> >Plaguebearers</option>
                        <option value="Plagueridden" <?php if($UNIT=='Plagueridden') { echo "selected"; } ?> >Plagueridden</option>
                        <option value="Daemonettes" <?php if($UNIT=='Daemonettes') { echo "selected"; } ?> >Daemonettes</option>
                        <option value="Alluress" <?php if($UNIT=='Alluress') { echo "selected"; } ?> >Alluress</option>
                        <option disabled>─────HEAVY SUPPORT─────</option>
                        <option value="Havocs" <?php if($UNIT=='Havocs') { echo "selected"; } ?> >Havocs</option>
                        <option value="Chaos Land Raider" <?php if($UNIT=='Chaos Land Raider') { echo "selected"; } ?> >Chaos Land Raider</option>
                        <option value="Chaos Predator" <?php if($UNIT=='Chaos Predator') { echo "selected"; } ?> >Chaos Predator</option>                          
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
                            if($UNIT=='Kharn the Betrayer') { ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Kharns Plasma Pistol'<?php if($UNIT_WEAPON=='Kharns Plasma Pistol') { echo "selected"; } ?> >Kharns Plasma Pistol</option>
                        <option value='Frag Grenade'<?php if($UNIT_WEAPON=='Frag Grenade') { echo "selected"; } ?> >Frag Grenade</option>
                        <option value='Krak Grenade'<?php if($UNIT_WEAPON=='Krak Grenade') { echo "selected"; } ?> >Krak Grenade</option>
                        <option disabled>─────Melee─────</option>
                        <option value='Gorechild'<?php if($UNIT_WEAPON=='Gorechild') { echo "selected"; } ?> >Gorechild</option>
                            <?php } 
                            if($UNIT=='Abaddon the Despoiler') {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Talon of Horus' <?php if($UNIT_WEAPON=='Talon of Horus') { echo "selected"; } ?> >Talon of Horus</option>
                        <option disabled>─────Melee─────</option>
                        <option value='Talon of Horus (Melee)'<?php if($UNIT_WEAPON=='Talon of Horus (Melee)') { echo "selected"; } ?> >Talon of Horus (Melee)</option>                       
                        <option value='Drachnyen' <?php if($UNIT_WEAPON=='Drachnyen') { echo "selected"; } ?> >Drach'nyen</option>                        
                            <?php }                             
                            if(strpos($UNIT=='Daemon Prince') !== false) {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Warp Bolter'<?php if($UNIT_WEAPON=='Warp Bolter') { echo "selected"; } ?> >Warp Bolter</option>
                        <option disabled>─────Melee─────</option>
                        <option value='Hellforged Sword'<?php if($UNIT_WEAPON=='Hellforged Sword') { echo "selected"; } ?> >Hellforged Sword</option>                       
                        <option value='Daemonic Axe'<?php if($UNIT_WEAPON=='Daemonic Axe') { echo "selected"; } ?> >Daemonic Axe</option>
                        <option value='Malefic Talons'<?php if($UNIT_WEAPON=='Malefic Talons') { echo "selected"; } ?> >Malefic Talons</option>                     
                            <?php }
                        } else { ?>
                        <option value=''>Select...</option>
                            <?php } ?>
                    </select>
                </div>     
            </div>

        <script>
$(document).ready(function () {
    $("#UNIT").change(function () {
        var val = $(this).val();  
        if (val === "Kharn the Betrayer") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Kharns Plasma Pistol'>Kharns Plasma Pistol</option><option value='Frag Grenade'>Frag Grenade</option><option value='Krak Grenade'>Krak Grenade</option><option disabled>─────Melee─────</option><option value='Gorechild'>Gorechild</option>");
        } else if (val === "Abaddon the Despoiler") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Talon of Horus'>Talon of Horus</option><option disabled>─────Melee─────</option><option value='Talon of Horus (Melee)'>Talon of Horus (Melee)</option><option value='Drachnyen'>Drach'nyen</option>");
        } else if (val === "Khorne Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        } else if (val === "Khorne Winged Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        } else if (val === "Nurgle Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        } else if (val === "Nurgled Winged Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        } else if (val === "Slaanesh Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        } else if (val === "Slaanesh Winged Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        } else if (val === "Tzeentch Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        } else if (val === "Tzeentch Winged Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        }
    });
});        
</script>
            <div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="MOVEMENT">Movement:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="MOVEMENT" id="MOVEMENT" style="width: 170px" required>
                        <option value="Stationary" <?php if($MOVEMENT=='Stationary') { echo "selected"; } ?> >Stationary</option>
                        <option value="Moved" <?php if($MOVEMENT=='Moved') { echo "selected"; } ?> >Moved</option>
                        <option value="Advanced" <?php if($MOVEMENT=='Advanced') { echo "selected"; } ?> >Advanced</option>
                        <option value="Charged" <?php if($MOVEMENT=='Charged') { echo "selected"; } ?> >Charged</option>
                    </select>
                </div>     
            </div>   

            <div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="RANGE_BONUS">Range Bonus:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="RANGE_BONUS" id="RANGE_BONUS" style="width: 170px" required>
                        <option value="0">0</option>
                        <?php if(isset($RANGE_BONUS) && $RANGE_BONUS==0) { ?>
                        <option value="0" selected>0</option>
                        <?php } ?>
                            <?php for ($RANGE_BONUS_COUNT = 10; $RANGE_BONUS_COUNT > 0; $RANGE_BONUS_COUNT = $RANGE_BONUS_COUNT - 1) {
                                                            if($RANGE_BONUS_COUNT> 11) {
                                                               break; 
                                                    } 
                                                            ?>
                        <option value="<?php if(isset($RANGE_BONUS_COUNT)) { echo $RANGE_BONUS_COUNT; } ?>" <?php if($RANGE_BONUS==$RANGE_BONUS_COUNT) { echo "selected"; } ?> ><?php if(isset($RANGE_BONUS_COUNT)) { echo $RANGE_BONUS_COUNT; } ?></option>

                        <?php } ?>
                        
                    </select>
                </div>     
            </div> 
</div>
              <?php if(isset($UNIT)) { ?>
              <br><br><br>
              <div class="row">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">Abilities, keywords, and faction keywords.</div>
      <div class="panel-body">
          
<?php

        if($FACTION=='Chaos Space Marines') {
           
           require(__DIR__ . '/../../unit_stats/csm.php');

       }
       
       echo "<table class='table table-condensed'>
           <tr>
           <th colspan='10'>Unit Stats</th>
           </tr>
           <tr>
           <th>M</th>
           <th>WS</th>
           <th>BS</th>
           <th>S</th>
           <th>T</th>
           <th>W</th>
           <th>A</th>
           <th>Ld</th>
           <th>Save</th>
           <th>Invul</th>
           </tr>
           <tr>
           <td>$U_MOVE</td>
           <td>$U_WS</td>
           <td>$U_BS</td>
           <td>$U_STR</td>
           <td>$U_TOUGHNESS</td>
           <td>$U_WOUNDS</td>
           <td>$U_ATTACKS</td>
           <td>$U_LD</td>
           <td>$U_SAVE</td>
           <td>$U_INVUL</td>
           </tr>
           </table>";       
        
        echo "<strong>Abilities</strong>:<ul>";
foreach($U_ABILITIES as $key) {
    echo "<li>$key</li>";
}

echo "</ul><strong>Faction Keywords:</strong><ul>";
foreach($U_FACTION_KW as $key) {
    echo "<li>$key</li>";
}
echo "</ul><strong>Keywords:</strong><ul>";
foreach($U_KEYWORDS as $key) {
    echo "<li>$key</li>";
}
echo "</ul>";
?>
      
      </div>
    </div>
  </div>
              </div>
              <?php } ?>
            
       
        </div>
