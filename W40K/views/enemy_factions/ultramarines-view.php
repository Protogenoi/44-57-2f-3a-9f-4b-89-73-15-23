            <div class="col-xs-4">
             <div class="notice notice-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><center><strong>Enemy units:</strong></center></div>
             <div class="row">
                 
<div class="form-group">
                <label class="col-sm-4 control-label" style="text-align:left;" for="TARGET_UNIT">Target Unit:</label>
                <div class="col-sm-6">
                    <select class="form-control" name="TARGET_UNIT" id="UNIT" style="width: 170px" required>
                        <option value="">Select...</option>
                        <option disabled>─────HQ─────</option>
                        <option value="Captain in Gravis armour" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Captain in Gravis armour') { echo "selected"; } ?> >Captain in Gravis armour</option>
                        <option value="Primaris Lieutenants" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Primaris Lieutenants') { echo "selected"; } ?> >Primaris Lieutenants</option>
                        <option disabled>─────ELITES─────</option>
                        <option value="Primaris Ancient" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Primaris Ancient') { echo "selected"; } ?> >Primaris Ancient</option>
                        <option disabled>─────TROOPS─────</option>
                        <option value="Intercessor Squad" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Intercessor Squad') { echo "selected"; } ?> >Intercessor Squad</option>
                        <option value="Intercessor Sergeant" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Intercessor Sergeant') { echo "selected"; } ?> >Intercessor Sergeant</option>
                        <option value="Tactical Squad" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Tactical Squad') { echo "selected"; } ?> >Tactical Squad</option>
                        <option value="Tactical Marine Sergeant" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Tactical Marine Sergeant') { echo "selected"; } ?> >Tactical Marine Sergeant</option>
                        <option value="Scout Squad" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Scout Squad') { echo "selected"; } ?> >Scout Squad</option>
                        <option value="Scout Sergeant" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Scout Sergeant') { echo "selected"; } ?> >Scout Sergeant</option>
                        <option value="Crusader Squad" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Crusader Squad') { echo "selected"; } ?> >Crusader Squad (Black Templars)</option>
                        <option disabled>─────FAST ATTACK─────</option>
                        <option value="Inceptor Squad" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Inceptor Squad') { echo "selected"; } ?> >Inceptor Squad</option>
                        <option value="Inceptor Sergeant" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Inceptor Sergeant') { echo "selected"; } ?> >Inceptor Sergeant</option>
                        <option disabled>─────HEAVY SUPPORT─────</option>
                        <option value="Hellblaster Squad" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Hellblaster Squad') { echo "selected"; } ?> >Hellblaster Squad</option>
                        <option value="Hellblaster Sergeant" <?php if(isset($TARGET_UNIT) && $TARGET_UNIT=='Hellblaster Sergeant') { echo "selected"; } ?> >Hellblaster Sergeant</option>
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

        if($ENEMY_FACTION=='Ultramarines') {
           
           require(__DIR__ . '/../../target_stats/ultramarines-stats.php');

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