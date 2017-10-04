              <div class="notice notice-info fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><center><strong>Results:</strong></center></div>

              <?php 
              include('../W40K/class/combat_cal.php');
$combat_cal = new combat_cal();
              $HITS =$MODELS_TO_FIRE-1;
             
$combat_cal->weapon_stats(6,$HITS,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT);

              ?>