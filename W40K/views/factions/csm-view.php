       
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
                                if(strpos($UNIT,"Prince") !== false) {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Warp Bolter'<?php if($UNIT_WEAPON=='Warp Bolter') { echo "selected"; } ?> >Warp Bolter</option>
                        <option disabled>─────Melee─────</option>
                        <option value='Hellforged Sword'<?php if($UNIT_WEAPON=='Hellforged Sword') { echo "selected"; } ?> >Hellforged Sword</option>                       
                        <option value='Daemonic Axe'<?php if($UNIT_WEAPON=='Daemonic Axe') { echo "selected"; } ?> >Daemonic Axe</option>
                        <option value='Malefic Talons'<?php if($UNIT_WEAPON=='Malefic Talons') { echo "selected"; } ?> >Malefic Talons</option>                     
                            <?php }
                            if(strpos($UNIT,"Bezerker") !== false) {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Bolt Pistol'<?php if($UNIT_WEAPON=='Bolt Pistol') { echo "selected"; } ?> >Bolt Pistol</option>
                        <option value='Plasma Pistol' <?php if($UNIT_WEAPON=='Plasma Pistol') { echo "selected"; } ?> >Plasma Pistol</option>
                        <option value='Supercharged Plasma Pistol' <?php if($UNIT_WEAPON=='Supercharged Plasma Pistol') { echo "selected"; } ?> >Supercharged Plasma Pistol</option>
                        <option value='Frag Grenade' <?php if($UNIT_WEAPON=='Frag Grenade') { echo "selected"; } ?> >Frag Grenade</option>
                        <option value='Krak Grenade' <?php if($UNIT_WEAPON=='Krak Grenade') { echo "selected"; } ?> >Krak Grenade</option>
                        <option disabled>─────Melee─────</option>
                        <option value='Chain Sword' <?php if($UNIT_WEAPON=='Chain Sword') { echo "selected"; } ?> >Chain Sword</option>
                        <option value='Chainaxe' <?php if($UNIT_WEAPON=='Chainaxe') { echo "selected"; } ?> >Chainaxe</option>
                        <option disabled>─────Champion Equipment─────</option>
                        <option value='Boltgun' <?php if($UNIT_WEAPON=='Boltgun') { echo "selected"; } ?> >Boltgun</option>
                        <option value='Combi-bolter'<?php if($UNIT_WEAPON=='Combi-bolter') { echo "selected"; } ?> >Combi-bolter</option> 
                        <option value='Combi-flamer'<?php if($UNIT_WEAPON=='Combi-flamer') { echo "selected"; } ?> >Combi-flamer</option>                       
                        <option value='Combi-melta'<?php if($UNIT_WEAPON=='Combi-melta') { echo "selected"; } ?> >Combi-melta</option>
                        <option value='Combi-plasma'<?php if($UNIT_WEAPON=='Combi-plasma') { echo "selected"; } ?> >Combi-plasma</option>
                        <option value='Supercharged Combi-plasma'<?php if($UNIT_WEAPON=='Supercharged Combi-plasma') { echo "selected"; } ?> >Supercharged Combi-plasma</option>
                        <option disabled>─────Melee─────</option>
                        <option value='Lighting Claw' <?php if($UNIT_WEAPON=='Lighting Claw') { echo "selected"; } ?> >Lighting Claw</option>
                        <option value='Power Axe' <?php if($UNIT_WEAPON=='Power Axe') { echo "selected"; } ?> >Power Axe</option>
                        <option value='Power Fist' <?php if($UNIT_WEAPON=='Power Fist') { echo "selected"; } ?> >Power Fist</option>
                        <option value='Power Maul' <?php if($UNIT_WEAPON=='Power Maul') { echo "selected"; } ?> >Power Maul</option>
                        <option value='Power Sword' <?php if($UNIT_WEAPON=='Power Sword') { echo "selected"; } ?> >Power Sword</option>
                            <?php } 
                            if($UNIT=='Rubric Marines') {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Inferno Boltgun' <?php if($UNIT_WEAPON=='Inferno Boltgun') { echo "selected"; } ?> >Inferno Boltgun</option>
                        <option value='Warpflamer' <?php if($UNIT_WEAPON=='Warpflamer') { echo "selected"; } ?> >Warpflamer</option>
                        <option value='Soulreaper Cannon' <?php if($UNIT_WEAPON=='Soulreaper Cannon') { echo "selected"; } ?> >Soulreaper Cannon</option>
                            <?php }   
                            if($UNIT=='Aspiring Sorcerer') {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Inferno Bolt Pistol'<?php if($UNIT_WEAPON=='Inferno Bolt Pistol') { echo "selected"; } ?> >Inferno Bolt Pistol</option>
                        <option value='Warp Flame Pistol'<?php if($UNIT_WEAPON=='Warp Flame Pistol') { echo "selected"; } ?> >Warp Flame Pistol</option>
                        <option disabled>─────Melee─────</option>
                        <option value='Force Stave' <?php if($UNIT_WEAPON=='Force Stave') { echo "selected"; } ?> >Force Stave</option> 
                        <option value='Force Axe' <?php if($UNIT_WEAPON=='Force Axe') { echo "selected"; } ?> >Force Axe</option> 
                        <option value='Force Sword' <?php if($UNIT_WEAPON=='Force Sword') { echo "selected"; } ?> >Force Sword</option> 
                            <?php } 
                            if($UNIT=='Plague Marines') {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Blight Launcher'<?php if($UNIT_WEAPON=='Blight Launcher') { echo "selected"; } ?> >Blight Launcher</option>
                        <option value='Plasma Gun'<?php if($UNIT_WEAPON=='Plasma Gun') { echo "selected"; } ?> >Plasma Gun</option>
                        <option value='Supercharged Plasma Gun'<?php if($UNIT_WEAPON=='Supercharged Plasma Gun') { echo "selected"; } ?> >Supercharged Plasma Gun</option>
                        <option value='Boltgun'<?php if($UNIT_WEAPON=='Boltgun') { echo "selected"; } ?> >Boltgun</option>
                        <option value='Meltagun'<?php if($UNIT_WEAPON=='Meltagun') { echo "selected"; } ?> >Meltagun</option>
                        <option value='Plague Belcher'<?php if($UNIT_WEAPON=='Plague Belcher') { echo "selected"; } ?> >Plague Belcher</option>
                        <option value='Plague Spewer'<?php if($UNIT_WEAPON=='Plague Spewer') { echo "selected"; } ?> >Plague Spewer</option>
                        <option disabled>─────Grenades─────</option>
                        <option value='Blight Grenade' <?php if($UNIT_WEAPON=='Blight Grenade') { echo "selected"; } ?> >Blight Grenade</option>
                        <option value='Frag Grenade' <?php if($UNIT_WEAPON=='Frag Grenade') { echo "selected"; } ?> >Frag Grenade</option>
                        <option value='Krak Grenade' <?php if($UNIT_WEAPON=='Krak Grenade') { echo "selected"; } ?> >Krak Grenade</option>                        
                        <option disabled>─────Melee─────</option>
                        <option value='Plague Knife' <?php if($UNIT_WEAPON=='Plague Knife') { echo "selected"; } ?> >Plague Knife</option> 
                        <option value='Bubotic Axe' <?php if($UNIT_WEAPON=='Bubotic Axe') { echo "selected"; } ?> >Bubotic Axe</option>
                        <option value='Flail of Corruption' <?php if($UNIT_WEAPON=='Flail of Corruption') { echo "selected"; } ?> >Flail of Corruption</option>
                        <option value='Great Plague Cleaver' <?php if($UNIT_WEAPON=='Great Plague Cleaver') { echo "selected"; } ?> >Great Plague Cleaver</option>
                        <option value='Mace of Contagion' <?php if($UNIT_WEAPON=='Mace of Contagion') { echo "selected"; } ?> >Mace of Contagion</option>
                            <?php }   
                            if($UNIT=='Plague Champion') {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Plasma Gun'<?php if($UNIT_WEAPON=='Plasma Gun') { echo "selected"; } ?> >Plasma Gun</option>
                        <option value='Supercharged Plasma Gun'<?php if($UNIT_WEAPON=='Supercharged Plasma Gun') { echo "selected"; } ?> >Supercharged Plasma Gun</option>
                        <option value='Bolt Pistol'<?php if($UNIT_WEAPON=='Bolt Pistol') { echo "selected"; } ?> >Bolt Pistol</option>
                        <option value='Plasma Pistol'<?php if($UNIT_WEAPON=='Plasma Pistol') { echo "selected"; } ?> >Plasma Pistol</option>
                        <option value='Supercharged Plasma Pistol'<?php if($UNIT_WEAPON=='Supercharged Plasma Pistol') { echo "selected"; } ?> >Supercharged Plasma Pistol</option>
                        <option value='Boltgun'<?php if($UNIT_WEAPON=='Boltgun') { echo "selected"; } ?> >Boltgun</option>
                        <option disabled>─────Grenades─────</option>
                        <option value='Blight Grenade' <?php if($UNIT_WEAPON=='Blight Grenade') { echo "selected"; } ?> >Blight Grenade</option>
                        <option value='Frag Grenade' <?php if($UNIT_WEAPON=='Frag Grenade') { echo "selected"; } ?> >Frag Grenade</option>
                        <option value='Krak Grenade' <?php if($UNIT_WEAPON=='Krak Grenade') { echo "selected"; } ?> >Krak Grenade</option>                        
                        <option disabled>─────Melee─────</option>
                        <option value='Plague Knife' <?php if($UNIT_WEAPON=='Plague Knife') { echo "selected"; } ?> >Plague Knife</option> 
                        <option value='Plague Sword' <?php if($UNIT_WEAPON=='Plague Sword') { echo "selected"; } ?> >Plague Sword</option> 
                        <option value='Power Fist' <?php if($UNIT_WEAPON=='Power Fist') { echo "selected"; } ?> >Power Fist</option>
                            <?php } 
                            if(strpos($UNIT,"Terminator") !== false) {    
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Combi-bolter'<?php if($UNIT_WEAPON=='Combi-bolter') { echo "selected"; } ?> >Combi-bolter</option>
                        <option value='Combi-flamer'<?php if($UNIT_WEAPON=='Combi-flamer') { echo "selected"; } ?> >Combi-flamer</option>                       
                        <option value='Combi-melta'<?php if($UNIT_WEAPON=='Combi-melta') { echo "selected"; } ?> >Combi-melta</option>
                        <option value='Combi-plasma'<?php if($UNIT_WEAPON=='Combi-plasma') { echo "selected"; } ?> >Combi-plasma</option>
                        <option value='Supercharged Combi-plasma'<?php if($UNIT_WEAPON=='Supercharged Combi-plasma') { echo "selected"; } ?> >Supercharged Combi-plasma</option>                        
                        <option value='Heavy Flamer'<?php if($UNIT_WEAPON=='Heavy Flamer') { echo "selected"; } ?> >Heavy Flamer</option>
                        <option value='Reaper Autocannon'<?php if($UNIT_WEAPON=='Reaper Autocannon') { echo "selected"; } ?> >Reaper Autocannon</option>                      
                        <option disabled>─────Melee─────</option>
                        <option value='Lighting Claw' <?php if($UNIT_WEAPON=='Lighting Claw') { echo "selected"; } ?> >Lighting Claw</option> 
                        <option value='Power Axe' <?php if($UNIT_WEAPON=='Power Axe') { echo "selected"; } ?> >Power Axe</option> 
                        <option value='Power Fist' <?php if($UNIT_WEAPON=='Power Fist') { echo "selected"; } ?> >Power Fist</option>
                        <option value='Power Maul' <?php if($UNIT_WEAPON=='Power Maul') { echo "selected"; } ?> >Power Maul</option>
                        <option value='Power Sword' <?php if($UNIT_WEAPON=='Power Sword') { echo "selected"; } ?> >Power Sword</option>
                        <option value='Chain Fist' <?php if($UNIT_WEAPON=='Chain Fist') { echo "selected"; } ?> >Chain Fist</option>
                            <?php }
                             if($UNIT=='Helbrute') {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Combi-bolter'<?php if($UNIT_WEAPON=='Combi-bolter') { echo "selected"; } ?> >Combi-bolter</option>
                        <option value='Twin Heavy Bolter'<?php if($UNIT_WEAPON=='Twin Heavy Bolter') { echo "selected"; } ?> >Twin Heavy Bolter</option>
                        <option value='Heavy Flamer'<?php if($UNIT_WEAPON=='Heavy Flamer') { echo "selected"; } ?> >Heavy Flamer</option>
                        <option value='Twin Lascannon'<?php if($UNIT_WEAPON=='Twin Lascannon') { echo "selected"; } ?> >Twin Lascannon</option>
                        <option value='Helbrute Plasma Cannon'<?php if($UNIT_WEAPON=='Helbrute Plasma Cannon') { echo "selected"; } ?> >Helbrute Plasma Cannon</option>
                        <option value='Frag Missile Launcher'<?php if($UNIT_WEAPON=='Frag Missile Launcher') { echo "selected"; } ?> >Frag Missile Launcher</option>
                        <option value='Krak Missile Launcher'<?php if($UNIT_WEAPON=='Krak Missile Launcher') { echo "selected"; } ?> >Krak Missile Launcher</option>
                        <option value='Multi-melta'<?php if($UNIT_WEAPON=='Multi-melta') { echo "selected"; } ?> >Multi-melta</option>
                        <option value='Reaper Autocannon'<?php if($UNIT_WEAPON=='Reaper Autocannon') { echo "selected"; } ?> >Reaper Autocannon</option>
                        <option disabled>─────Melee─────</option>
                        <option value='Helbrute Fist' <?php if($UNIT_WEAPON=='Helbrute Fist') { echo "selected"; } ?> >Helbrute Fist</option> 
                        <option value='Helbrute Hammer' <?php if($UNIT_WEAPON=='Helbrute Hammer') { echo "selected"; } ?> >Helbrute Hammer</option>
                        <option value='Power Scourge' <?php if($UNIT_WEAPON=='Power Scourge') { echo "selected"; } ?> >Power Scourge</option>
                            <?php }  
                             if($UNIT=='Chaos Space Marines') {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Bolt Pistol'<?php if($UNIT_WEAPON=='Bolt Pistol') { echo "selected"; } ?> >Bolt Pistol</option>
                        <option value='Boltgun'<?php if($UNIT_WEAPON=='Boltgun') { echo "selected"; } ?> >Boltgun</option>
                        <option value='Plasma Gun'<?php if($UNIT_WEAPON=='Plasma Gun') { echo "selected"; } ?> >Plasma Gun</option>
                        <option value='Supercharged Plasma Gun'<?php if($UNIT_WEAPON=='Supercharged Plasma Gun') { echo "selected"; } ?> >Supercharged Plasma Gun</option>
                        <option disabled>─────Special Weapons─────</option>
                        <option value='Flamer'<?php if($UNIT_WEAPON=='Flamer') { echo "selected"; } ?> >Flamer</option>
                        <option value='Meltagun'<?php if($UNIT_WEAPON=='Meltagun') { echo "selected"; } ?> >Meltagun</option>                        
                        <option value='Plasma Gun'<?php if($UNIT_WEAPON=='Plasma Gun') { echo "selected"; } ?> >Plasma Gun</option>
                        <option value='Supercharged Plasma Gun'<?php if($UNIT_WEAPON=='Supercharged Plasma Gun') { echo "selected"; } ?> >Supercharged Plasma Gun</option> 
                        <option disabled>─────Heavy Weapons─────</option>
                        <option value='Autocannon'<?php if($UNIT_WEAPON=='Autocannon') { echo "selected"; } ?> >Autocannon</option>
                        <option value='Heavy Bolter'<?php if($UNIT_WEAPON=='Heavy Bolter') { echo "selected"; } ?> >Heavy Bolter</option>
                        <option value='Lascannon'<?php if($UNIT_WEAPON=='Lascannon') { echo "selected"; } ?> >Lascannon</option>
                        <option value='Frag Missile Launcher'<?php if($UNIT_WEAPON=='Frag Missile Launcher') { echo "selected"; } ?> >Frag Missile Launcher</option>
                        <option value='Krak Missile Launcher'<?php if($UNIT_WEAPON=='Krak Missile Launcher') { echo "selected"; } ?> >Krak Missile Launcher</option>
                        <option disabled>─────Grenades─────</option>
                        <option value='Frag Grenade' <?php if($UNIT_WEAPON=='Frag Grenade') { echo "selected"; } ?> >Frag Grenade</option>
                        <option value='Krak Grenade' <?php if($UNIT_WEAPON=='Krak Grenade') { echo "selected"; } ?> >Krak Grenade</option>                        
                        <option disabled>─────Melee─────</option>
                        <option value='Chain Sword' <?php if($UNIT_WEAPON=='Chain Sword') { echo "selected"; } ?> >Chain Sword</option> 
                            <?php }
                             if($UNIT=='Aspiring Champion') {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Bolt Pistol'<?php if($UNIT_WEAPON=='Bolt Pistol') { echo "selected"; } ?> >Bolt Pistol</option>
                        <option value='Boltgun'<?php if($UNIT_WEAPON=='Boltgun') { echo "selected"; } ?> >Boltgun</option>
                        <option disabled>─────Champion Equipment─────</option>
                        <option value='Plasma Pistol'<?php if($UNIT_WEAPON=='Plasma Pistol') { echo "selected"; } ?> >Plasma Pistol</option>
                        <option value='Supercharged Plasma Pistol'<?php if($UNIT_WEAPON=='Supercharged Plasma Pistol') { echo "selected"; } ?> >Supercharged Plasma Pistol</option> 
                        <option value='Combi-bolter'<?php if($UNIT_WEAPON=='Combi-bolter') { echo "selected"; } ?> >Combi-bolter</option> 
                        <option value='Combi-flamer'<?php if($UNIT_WEAPON=='Combi-flamer') { echo "selected"; } ?> >Combi-flamer</option>                       
                        <option value='Combi-melta'<?php if($UNIT_WEAPON=='Combi-melta') { echo "selected"; } ?> >Combi-melta</option>
                        <option value='Combi-plasma'<?php if($UNIT_WEAPON=='Combi-plasma') { echo "selected"; } ?> >Combi-plasma</option>
                        <option value='Supercharged Combi-plasma'<?php if($UNIT_WEAPON=='Supercharged Combi-plasma') { echo "selected"; } ?> >Supercharged Combi-plasma</option>
                        <option disabled>─────Champion Melee─────</option>
                        <option value='Chainaxe' <?php if($UNIT_WEAPON=='Chainaxe') { echo "selected"; } ?> >Chainaxe</option>
                        <option value='Lighting Claw' <?php if($UNIT_WEAPON=='Lighting Claw') { echo "selected"; } ?> >Lighting Claw</option>
                        <option value='Power Axe' <?php if($UNIT_WEAPON=='Power Axe') { echo "selected"; } ?> >Power Axe</option>
                        <option value='Power Fist' <?php if($UNIT_WEAPON=='Power Fist') { echo "selected"; } ?> >Power Fist</option>
                        <option value='Power Maul' <?php if($UNIT_WEAPON=='Power Maul') { echo "selected"; } ?> >Power Maul</option>
                        <option value='Power Sword' <?php if($UNIT_WEAPON=='Power Sword') { echo "selected"; } ?> >Power Sword</option>                        
                        <option disabled>─────Grenades─────</option>
                        <option value='Frag Grenade' <?php if($UNIT_WEAPON=='Frag Grenade') { echo "selected"; } ?> >Frag Grenade</option>
                        <option value='Krak Grenade' <?php if($UNIT_WEAPON=='Krak Grenade') { echo "selected"; } ?> >Krak Grenade</option>                        
                        <option disabled>─────Melee─────</option>
                        <option value='Chain Sword' <?php if($UNIT_WEAPON=='Chain Sword') { echo "selected"; } ?> >Chain Sword</option> 
                            <?php } 
                             if($UNIT=='Chaos Cultists') {
                            ?>
                        <option disabled>─────Wargear─────</option>
                        <option value='Autogun'<?php if($UNIT_WEAPON=='Autogun') { echo "selected"; } ?> >Autogun</option>
                        <option value='Heavy Stubber'<?php if($UNIT_WEAPON=='Heavy Stubber') { echo "selected"; } ?> >Heavy Stubber</option>
                        <option value='Autopistol'<?php if($UNIT_WEAPON=='Autopistol') { echo "selected"; } ?> >Autopistol</option>
                        <option value='Shotgun'<?php if($UNIT_WEAPON=='Shotgun') { echo "selected"; } ?> >Shotgun</option> 
                        <option value='Flamer'<?php if($UNIT_WEAPON=='Flamer') { echo "selected"; } ?> >Flamer</option> 
                        <option disabled>─────Melee─────</option>
                        <option value='Brutal Assault Weapon' <?php if($UNIT_WEAPON=='Brutal Assault Weapon') { echo "selected"; } ?> >Brutal Assault Weapon</option> 
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
        } else if (val === "Nurgle Winged Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        } else if (val === "Slaanesh Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        } else if (val === "Slaanesh Winged Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        } else if (val === "Tzeentch Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        } else if (val === "Tzeentch Winged Daemon Prince") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Warp Bolter'>Warp Bolter</option><option disabled>─────Melee─────</option><option value='Hellforged Sword'>Hellforged Sword</option><option value='Daemonic Axe'>Daemonic Axe</option><option value='Malefic Talons'>Malefic Talons</option>");
        } else if (val === "Khorne Bezerkers") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Bolt Pistol'>Bolt Pistol</option><option value='Plasma Pistol'>Plasma Pistol</option><option value='Supercharged Plasma Pistol'>Supercharged Plasma Pistol</option><option value='Frag Grenade'>Frag Grenade</option><option value='Krak Grenade'>Krak Grenade</option><option disabled>─────Melee─────</option><option value='Chain Sword'>Chain Sword</option><option value='Chainaxe'>Chainaxe</option>");
        } else if (val === "Bezerker Champion") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Bolt Pistol'>Bolt Pistol</option><option value='Plasma Pistol'>Plasma Pistol</option><option value='Supercharged Plasma Pistol'>Supercharged Plasma Pistol</option><option value='Frag Grenade'>Frag Grenade</option><option value='Krak Grenade'>Krak Grenade</option><option disabled>─────Melee─────</option><option value='Chain Sword'>Chain Sword</option><option value='Chainaxe'>Chainaxe</option><option disabled>─────Champion Equipment─────</option><option value='Boltgun'>Boltgun</option><option value='Combi-bolter'>Combi-bolter</option><option value='Combi-flamer'>Combi-flamer</option><option value='Combi-melta'>Combi-melta</option><option value='Combi-plasma'>Combi-plasma</option><option value='Supercharged Combi-plasma'>Supercharged Combi-plasma</option><option disabled>─────Melee─────</option><option value='Lighting Claw'>Lighting Claw</option><option value='Power Axe'>Power Axe</option><option value='Power Fist'>Power Fist</option><option value='Power Maul'>Power Maul</option><option value='Power Sword'>Power Sword</option>");
        } else if (val === "Rubric Marines") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Inferno Boltgun'>Inferno Boltgun</option><option value='Warpflamer'>Warpflamer</option><option value='Soulreaper Cannon'>Soulreaper Cannon</option>");
        } else if (val === "Aspiring Sorcerer") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Inferno Bolt Pistol'>Inferno Bolt Pistol</option><option value='Warp Flame Pistol'>Warp Flame Pistol</option><option disabled>─────Melee─────</option><option value='Force Stave'>Force Stave</option><option value='Force Axe'>Force Axe</option><option value='Force Sword'>Force Sword</option>");
        } else if (val === "Plague Marines") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Blight Launcher'>Blight Launcher</option><option value='Plasma Gun'>Plasma Gun</option><option value='Supercharged Plasma Gun'>Supercharged Plasma Gun</option><option value='Boltgun'>Boltgun</option><option value='Meltagun'>Meltagun</option><option value='Plague Belcher'>Plague Belcher</option><option value='Plague Spewer'>Plague Spewer</option><option disabled>─────Grenades─────</option><option value='Blight Grenade'>Blight Grenade</option><option value='Frag Grenade'>Frag Grenade</option><option value='Krak Grenade'>Krak Grenade</option><option disabled>─────Melee─────</option><option value='Plague Knife'>Plague Knife</option><option value='Bubotic Axe'>Bubotic Axe</option><option value='Flail of Corruption'>Flail of Corruption</option><option value='Great Plague Cleaver'>Great Plague Cleaver</option><option value='Mace of Contagion'>Mace of Contagion</option>");
        } else if (val === "Plague Champion") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Plasma Gun'>Plasma Gun</option><option value='Supercharged Plasma Gun'>Supercharged Plasma Gun</option><option value='Bolt Pistol'>Bolt Pistol</option><option value='Plasma Pistol'>Plasma Pistol</option><option value='Supercharged Plasma Pistol'>Supercharged Plasma Pistol</option><option value='Boltgun'>Boltgun</option><option disabled>─────Grenades─────</option><option value='Blight Grenade'>Blight Grenade</option><option value='Frag Grenade'>Frag Grenade</option><option value='Krak Grenade'>Krak Grenade</option><option disabled>─────Melee─────</option><option value='Plague Knife'>Plague Knife</option><option value='Plague Sword'>Plague Sword</option><option value='Power Fist'>Power Fist</option>");
        } else if (val === "Chaos Terminator") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Combi-bolter'>Combi-bolter</option><option value='Combi-flamer'>Combi-flamer</option><option value='Combi-melta'>Combi-melta</option><option value='Combi-plasma'>Combi-plasma</option><option value='Supercharged Combi-plasma'>Supercharged Combi-plasma</option><option value='Heavy Flamer'>Heavy Flamer</option><option value='Reaper Autocannon'>Reaper Autocannon</option><option disabled>─────Melee─────</option><option value='Lighting Claw'>Lighting Claw</option><option value='Power Axe'>Power Axe</option><option value='Power Fist'>Power Fist</option><option value='Power Maul'>Power Maul</option><option value='Power Sword'>Power Sword</option><option value='Chain Fist'>Chain Fist</option>");
        } else if (val === "Terminator Champion") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Combi-bolter'>Combi-bolter</option><option value='Combi-flamer'>Combi-flamer</option><option value='Combi-melta'>Combi-melta</option><option value='Combi-plasma'>Combi-plasma</option><option value='Supercharged Combi-plasma'>Supercharged Combi-plasma</option><option value='Heavy Flamer'>Heavy Flamer</option><option value='Reaper Autocannon'>Reaper Autocannon</option><option disabled>─────Melee─────</option><option value='Lighting Claw'>Lighting Claw</option><option value='Power Axe'>Power Axe</option><option value='Power Fist'>Power Fist</option><option value='Power Maul'>Power Maul</option><option value='Power Sword'>Power Sword</option><option value='Chain Fist'>Chain Fist</option>");
        } else if (val === "Helbrute") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Combi-bolter'>Combi-bolter</option><option value='Twin Heavy Bolter'>Twin Heavy Bolter</option><option value='Heavy Flamer'>Heavy Flamer</option><option value='Twin Lascannon'>Twin Lascannon</option><option value='Helbrute Plasma Cannon'>Helbrute Plasma Cannon</option><option value='Frag Missile Launcher'>Frag Missile Launcher</option><option value='Krak Missile Launcher'>Krak Missile Launcher</option><option value='Multi-melta'>Multi-melta</option><option value='Reaper Autocannon'>Reaper Autocannon</option><option disabled>─────Melee─────</option><option value='Helbrute Fist'>Helbrute Fist</option><option value='Helbrute Hammer'>Helbrute Hammer</option><option value='Power Scourge'>Power Scourge</option>");
        } else if (val === "Chaos Space Marines") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Bolt Pistol'>Bolt Pistol</option><option value='Boltgun'>Boltgun</option><option value='Plasma Gun'>Plasma Gun</option><option value='Supercharged Plasma Gun'>Supercharged Plasma Gun</option><option value='Meltagun'>Meltagun</option><option disabled>─────Special Weapons─────</option><option value='Flamer'>Flamer</option><option value='Meltagun'>Meltagun</option><option value='Plasma Gun'>Plasma Gun</option><option value='Supercharged Plasma Gun'>Supercharged Plasma Gun</option><option disabled>─────Heavy Weapons─────</option><option value='Autocannon'>Autocannon</option><option value='Heavy Bolter'>Heavy Bolter</option><option value='Lascannon'>Lascannon</option><option value='Frag Missile Launcher'>Frag Missile Launcher</option><option value='Krak Missile Launcher'>Krak Missile Launcher</option><option disabled>─────Grenades─────</option><option value='Frag Grenade'>Frag Grenade</option><option value='Krak Grenade'>Krak Grenade</option><option disabled>─────Melee─────</option><option value='Chain Sword'>Chain Sword</option>");
        } else if (val === "Aspiring Champion") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Bolt Pistol'>Bolt Pistol</option><option value='Boltgun'>Boltgun</option><option disabled>─────Champion Equipment─────</option><option value='Plasma Pistol'>Plasma Pistol</option><option value='Supercharged Plasma Pistol'>Supercharged Plasma Pistol</option><option value='Combi-bolter'>Combi-bolter</option><option value='Combi-flamer'>Combi-flamer</option><option value='Combi-melta'>Combi-melta</option><option value='Combi-plasma'>Combi-plasma</option><option value='Supercharged Combi-plasma'>Supercharged Combi-plasma</option><option disabled>─────Champion Melee─────</option><option value='Chainaxe'>Chainaxe</option><option value='Lighting Claw'>Lighting Claw</option><option value='Power Axe'>Power Axe</option><option value='Power Fist'>Power Fist</option><option value='Power Maul'>Power Maul</option><option value='Power Sword'>Power Sword</option><option disabled>─────Grenades─────</option><option value='Frag Grenade'>Frag Grenade</option><option value='Krak Grenade'>Krak Grenade</option><option disabled>─────Melee─────</option><option value='Chain Sword'>Chain Sword</option>");
        } else if (val === "Chaos Cultists") {
            $("#UNIT_WEAPON").html("<option disabled>─────Wargear─────</option><option value='Autogun'>Autogun</option><option value='Heavy Stubber'>Heavy Stubber</option><option value='Autopistol'>Autopistol</option><option value='Shotgun'>Shotgun</option><option value='Flamer'>Flamer</option><option disabled>─────Melee─────</option><option value='Brutal Assault Weapon'>Brutal Assault Weapon</option>");
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
