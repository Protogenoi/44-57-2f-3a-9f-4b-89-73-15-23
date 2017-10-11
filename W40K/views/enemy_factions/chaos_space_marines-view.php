            <div class="col-xs-4">
             <div class="notice notice-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><center><strong>Enemy units:</strong></center></div>
             <div class="row">
                 
<div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="TARGET_UNIT">Target Unit:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="TARGET_UNIT" id="UNIT" style="width: 170px" required>
                        <option value="">Select...</option>
                        <option disabled>─────HQ─────</option>
                        <option value="Kharn the Betrayer" <?php if($TARGET_UNIT=='Kharn the Betrayer') { echo "selected"; } ?> >Kharn the Betrayer</option>
                        <option value="Abaddon the Despoiler" <?php if($TARGET_UNIT=='Abaddon the Despoiler') { echo "selected"; } ?> >Abaddon the Despoiler</option>
                        <option value="Khrone Daemon Prince" <?php if($TARGET_UNIT=='Khrone Daemon Prince') { echo "selected"; } ?> >Khrone Daemon Prince</option>
                        <option value="Nurgle Daemon Prince" <?php if($TARGET_UNIT=='Nurgle Daemon Prince') { echo "selected"; } ?> >Nurgle Daemon Prince</option>                        
                        <option value="Slaanesh Daemon Prince" <?php if($TARGET_UNIT=='Slaanesh Daemon Prince') { echo "selected"; } ?> >Slaanesh Daemon Prince</option>                        
                        <option value="Tzeentch Daemon Prince" <?php if($TARGET_UNIT=='Tzeentch Daemon Prince') { echo "selected"; } ?> >Tzeentch Daemon Prince</option>
                        <option disabled>─────ELITES─────</option>
                        <option value="Khorne Bezerkers" <?php if($TARGET_UNIT=='Khorne Bezerkers') { echo "selected"; } ?> >Khorne Bezerkers</option>
                        <option value="Bezerker Champion" <?php if($TARGET_UNIT=='Bezerker Champion') { echo "selected"; } ?> >Bezerker Champion</option>
                        <option value="Rubric Marines" <?php if($TARGET_UNIT=='Rubric Marines') { echo "selected"; } ?> >Rubric Marines</option>
                        <option value="Aspiring Sorcerer" <?php if($TARGET_UNIT=='Aspiring Sorcerer') { echo "selected"; } ?> >Aspiring Sorcerer</option>
                        <option value="Plague Marines" <?php if($TARGET_UNIT=='Plague Marines') { echo "selected"; } ?> >Plague Marines</option>
                        <option value="Plague Champion" <?php if($TARGET_UNIT=='Plague Champion') { echo "selected"; } ?> >Plague Champion</option>
                        <option value="Chaos Terminator" <?php if($TARGET_UNIT=='Chaos Terminator') { echo "selected"; } ?> >Chaos Terminator</option>
                        <option value="Terminator Champion" <?php if($TARGET_UNIT=='Terminator Champion') { echo "selected"; } ?> >Terminator Champion</option>
                        <option value="Helbrute" <?php if($TARGET_UNIT=='Helbrute') { echo "selected"; } ?> >Helbrute</option>                        
                        <option disabled>─────TROOPS─────</option>
                        <option value="Chaos Space Marines" <?php if($TARGET_UNIT=='Chaos Space Marines') { echo "selected"; } ?> >Chaos Space Marines</option>
                        <option value="Aspiring Champion" <?php if($TARGET_UNIT=='Aspiring Champion') { echo "selected"; } ?> >Aspiring Champion</option>
                        <option value="Chaos Cultists" <?php if($TARGET_UNIT=='Chaos Cultists') { echo "selected"; } ?> >Chaos Cultists</option>
                        <option value="Cultist Champion" <?php if($TARGET_UNIT=='Cultist Champion') { echo "selected"; } ?> >Cultist Champion</option>
                        <option value="Bloodletters" <?php if($TARGET_UNIT=='Bloodletters') { echo "selected"; } ?> >Bloodletters</option>
                        <option value="Bloodreaper" <?php if($TARGET_UNIT=='Bloodreaper') { echo "selected"; } ?> >Bloodreaper</option>
                        <option value="Pink Horrors" <?php if($TARGET_UNIT=='Pink Horrors') { echo "selected"; } ?> > Pink Horrors</option>
                        <option value="Blue Horrors" <?php if($TARGET_UNIT=='Blue Horrors') { echo "selected"; } ?> > Blue Horrors</option>
                        <option value="Pair of Brimstone Horrors" <?php if($TARGET_UNIT=='Pair of Brimstone Horrors') { echo "selected"; } ?> > Pair of Brimstone Horrors</option>
                        <option value="Plaguebearers" <?php if($TARGET_UNIT=='Plaguebearers') { echo "selected"; } ?> >Plaguebearers</option>
                        <option value="Plagueridden" <?php if($TARGET_UNIT=='Plagueridden') { echo "selected"; } ?> >Plagueridden</option>
                        <option value="Daemonettes" <?php if($TARGET_UNIT=='Daemonettes') { echo "selected"; } ?> >Daemonettes</option>
                        <option value="Alluress" <?php if($TARGET_UNIT=='Alluress') { echo "selected"; } ?> >Alluress</option>
                        <option disabled>─────HEAVY SUPPORT─────</option>
                        <option value="Havocs" <?php if($TARGET_UNIT=='Havocs') { echo "selected"; } ?> >Havocs</option>
                        <option value="Chaos Land Raider" <?php if($TARGET_UNIT=='Chaos Land Raider') { echo "selected"; } ?> >Chaos Land Raider</option>
                        <option value="Chaos Predator" <?php if($TARGET_UNIT=='Chaos Predator') { echo "selected"; } ?> >Chaos Predator</option>
                        
                    </select>
                </div>     
            </div> 
             </div>
         <?php if(isset($TARGET_UNIT)) { ?>
             <br><br><br><br><br><br><br><br><br><br>
              <div class="row">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">Abilities, keywords, and faction keywords.</div>
      <div class="panel-body">
          
<?php

        if($ENEMY_FACTION=='Chaos Space Marines') {
           
           require(__DIR__ . '/../../target_stats/csm-stats.php');

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
           <td>$T_MOVE</td>
           <td>$T_WS</td>
           <td>$T_BS</td>
           <td>$T_STR</td>
           <td>$T_TOUGHNESS</td>
           <td>$T_WOUNDS</td>
           <td>$T_ATTACKS</td>
           <td>$T_LD</td>
           <td>$T_SAVE</td>
           <td>$T_INVUL</td>
           </tr>
           </table>";
        
        echo "<strong>Abilities:</strong><ul>";
foreach($T_ABILITIES as $key) {
    echo "<li>$key</li>";
}

echo "</ul><strong>Faction Keywords:</strong><ul>";
foreach($T_FACTION_KW as $key) {
    echo "<li>$key</li>";
}
echo "</ul><strong>Keywords:</strong><ul>";
foreach($T_KEYWORDS as $key) {
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