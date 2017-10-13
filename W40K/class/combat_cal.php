<?php

class combat_cal { 
    
    function weapon_stats ($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT) {

        if($FACTION=='Ultramarines') {
           
           require(__DIR__ . '/../unit_stats/ultramarines-stats.php');
           require(__DIR__ . '/../weapon_stats/ultramarines-weapons.php');

       }
       
       elseif($FACTION=='Eldar') {

           require(__DIR__ . '/../unit_stats/eldar-stats.php');
           require(__DIR__ . '/../weapon_stats/eldar-weapons.php');  
       
       }  
       
       elseif($FACTION=='Deathguard') {

           require(__DIR__ . '/../unit_stats/deathguard-stats.php');
           require(__DIR__ . '/../weapon_stats/deathguard-weapons.php');  
       
       }       
       
       elseif($FACTION=='Chaos Space Marines') {

           require(__DIR__ . '/../unit_stats/csm.php');
           require(__DIR__ . '/../weapon_stats/csm-weapons.php');  
       
       }        
        
 if(strpos($WEAPON_TYPE,"Assualt") !== false && $MOVEMENT=='Advanced') {
     
     $U_BS++;
     
 }   
 
  if(strpos($WEAPON_TYPE,"Heavy") !== false && $MOVEMENT=='Moved') {
     
     $U_BS++;
     
 }
       
    $AUTO_HIT_WEAPONS=array("Flamer","Warp Flame Pistol","Warpflamer","Plague Belcher","Plague Spewer","Heavy Flamer");
 
    if (in_array($UNIT_WEAPON,$AUTO_HIT_WEAPONS,true)) {
        
    $combat_cal = new combat_cal();
    $combat_cal->d_six_roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE);        
            
        
    }    
    
    elseif($UNIT_WEAPON=='Plasma Exterminator' || $UNIT_WEAPON=='Supercharged Plasma Exterminator') {
        
    $combat_cal = new combat_cal();
    $combat_cal->two_d_three_roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE,$U_ABILITIES);        
              
        
    }
    
    elseif($UNIT_WEAPON!='Flamer') {
    
    $combat_cal = new combat_cal();
    $combat_cal->roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE,$U_ABILITIES);        
    
    }
    
    }
    
    function two_d_three_roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE,$U_ABILITIES) {
        
$DIE_ONE_MOD=0;
$DIE_TWO_MOD=0;
$DIE_THREE_MOD=0;        
        
    for ($x = 0; $x <= $MODELS_TO_FIRE; $x++) {

        $DIE = mt_rand(1, 3);

        if ($DIE == 1) {
            $DIE_ONE_MOD++;
        }
        if ($DIE == 2) {
            $DIE_TWO_MOD++;
            $DIE_TWO_MOD++;
        }
        if ($DIE == 3) {
            $DIE_THREE_MOD++;
            $DIE_THREE_MOD++;
            $DIE_THREE_MOD++;
        }
		
		    }  
            
        $TOTAL_HITS=$DIE_ONE_MOD+$DIE_TWO_MOD+$DIE_THREE_MOD;    
        
    echo "<table class='table table-condensed'>
        <tr>
        <th colspan='4'>$WEAPON_TYPE Hits</th>
        </tr>
	<tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
        <th>Hits</th>
	</tr>
	<tr>
	<th>$DIE_ONE_MOD</th>
	<th>$DIE_TWO_MOD</th>
	<th>$DIE_THREE_MOD</th>
        <th>$TOTAL_HITS</th>  
	</tr>
	</table>";  
    
    $number=$TOTAL_HITS-1;
 
    $combat_cal = new combat_cal();
    $combat_cal->roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE,$U_ABILITIES);        
        
    }   
    
    function d_six_roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE) {

        $SHOW_ROLL_HITS=$number+1;
        
        $ROLL_ONE=0;
        $ROLL_TWO=0;
        $ROLL_THREE=0;
        $ROLL_FOUR=0;
        $ROLL_FIVE=0;
        $ROLL_SIX=0;
        $ROLL_SEVEN=0;
        $ROLL_EIGHT=0;
        $ROLL_NINE=0;
        $ROLL_TEN=0;
        
        if($SHOW_ROLL_HITS=='1') {

        $ROLL_ONE=(mt_rand(1, 6));
        
        $TOTAL_HITS=$ROLL_ONE;
        
        }
        
        if($SHOW_ROLL_HITS=='2') {

        $ROLL_ONE=(mt_rand(1, 6));
        $ROLL_TWO=(mt_rand(1, 6));
        
        $TOTAL_HITS=$ROLL_ONE+$ROLL_TWO;
        
        }

        if($SHOW_ROLL_HITS=='3') {

        $ROLL_ONE=(mt_rand(1, 6));
        $ROLL_TWO=(mt_rand(1, 6));
        $ROLL_THREE=(mt_rand(1, 6));
        
        $TOTAL_HITS=$ROLL_ONE+$ROLL_TWO+$ROLL_THREE;
        
        }

        if($SHOW_ROLL_HITS=='4') {

        $ROLL_ONE=(mt_rand(1, 6));
        $ROLL_TWO=(mt_rand(1, 6));
        $ROLL_THREE=(mt_rand(1, 6));
        $ROLL_FOUR=(mt_rand(1, 6));
        
        $TOTAL_HITS=$ROLL_ONE+$ROLL_TWO+$ROLL_THREE+$ROLL_FOUR;
        
        }

        if($SHOW_ROLL_HITS=='5') {

        $ROLL_ONE=(mt_rand(1, 6));
        $ROLL_TWO=(mt_rand(1, 6));
        $ROLL_THREE=(mt_rand(1, 6));
        $ROLL_FOUR=(mt_rand(1, 6));
        $ROLL_FIVE=(mt_rand(1, 6));
        
        $TOTAL_HITS=$ROLL_ONE+$ROLL_TWO+$ROLL_THREE+$ROLL_FOUR+$ROLL_FIVE;
        
        }

        if($SHOW_ROLL_HITS=='6') {

        $ROLL_ONE=(mt_rand(1, 6));
        $ROLL_TWO=(mt_rand(1, 6));
        $ROLL_THREE=(mt_rand(1, 6));
        $ROLL_FOUR=(mt_rand(1, 6));
        $ROLL_FIVE=(mt_rand(1, 6));
        $ROLL_SIX=(mt_rand(1, 6));
        
        $TOTAL_HITS=$ROLL_ONE+$ROLL_TWO+$ROLL_THREE+$ROLL_FOUR+$ROLL_FIVE+$ROLL_SIX;
        
        }

        if($SHOW_ROLL_HITS=='7') {

        $ROLL_ONE=(mt_rand(1, 6));
        $ROLL_TWO=(mt_rand(1, 6));
        $ROLL_THREE=(mt_rand(1, 6));
        $ROLL_FOUR=(mt_rand(1, 6));
        $ROLL_FIVE=(mt_rand(1, 6));
        $ROLL_SIX=(mt_rand(1, 6));
        $ROLL_SEVEN=(mt_rand(1, 6));
        
        $TOTAL_HITS=$ROLL_ONE+$ROLL_TWO+$ROLL_THREE+$ROLL_FOUR+$ROLL_FIVE+$ROLL_SIX+$ROLL_SEVEN;
        
        }

        if($SHOW_ROLL_HITS=='8') {

        $ROLL_ONE=(mt_rand(1, 6));
        $ROLL_TWO=(mt_rand(1, 6));
        $ROLL_THREE=(mt_rand(1, 6));
        $ROLL_FOUR=(mt_rand(1, 6));
        $ROLL_FIVE=(mt_rand(1, 6));
        $ROLL_SIX=(mt_rand(1, 6));
        $ROLL_SEVEN=(mt_rand(1, 6));
        $ROLL_EIGHT=(mt_rand(1, 6));
        
        $TOTAL_HITS=$ROLL_ONE+$ROLL_TWO+$ROLL_THREE+$ROLL_FOUR+$ROLL_FIVE+$ROLL_SIX+$ROLL_SEVEN+$ROLL_EIGHT;
        
        }

        if($SHOW_ROLL_HITS=='9') {

        $ROLL_ONE=(mt_rand(1, 6));
        $ROLL_TWO=(mt_rand(1, 6));
        $ROLL_THREE=(mt_rand(1, 6));
        $ROLL_FOUR=(mt_rand(1, 6));
        $ROLL_FIVE=(mt_rand(1, 6));
        $ROLL_SIX=(mt_rand(1, 6));
        $ROLL_SEVEN=(mt_rand(1, 6));
        $ROLL_EIGHT=(mt_rand(1, 6));
        $ROLL_NINE=(mt_rand(1, 6));
      
        $TOTAL_HITS=$ROLL_ONE+$ROLL_TWO+$ROLL_THREE+$ROLL_FOUR+$ROLL_FIVE+$ROLL_SIX+$ROLL_SEVEN+$ROLL_EIGHT+$ROLL_NINE;
        
        }

        if($SHOW_ROLL_HITS=='10') {

        $ROLL_ONE=(mt_rand(1, 6));
        $ROLL_TWO=(mt_rand(1, 6));
        $ROLL_THREE=(mt_rand(1, 6));
        $ROLL_FOUR=(mt_rand(1, 6));
        $ROLL_FIVE=(mt_rand(1, 6));
        $ROLL_SIX=(mt_rand(1, 6));
        $ROLL_SEVEN=(mt_rand(1, 6));
        $ROLL_EIGHT=(mt_rand(1, 6));
        $ROLL_NINE=(mt_rand(1, 6));
        $ROLL_TEN=(mt_rand(1, 6));
        
        $TOTAL_HITS=$ROLL_ONE+$ROLL_TWO+$ROLL_THREE+$ROLL_FOUR+$ROLL_FIVE+$ROLL_SIX+$ROLL_SEVEN+$ROLL_EIGHT+$ROLL_NINE+$ROLL_TEN;
        
        } 
        
        //ALTERNATIVE HOWEVER IS NOT AS FAIR AS ROLLING XD6 seperatly $TOTAL_HITS=(mt_rand($SHOW_ROLL_HITS, 6*$SHOW_ROLL_HITS)); 

    echo "<table class='table table-condensed'>
        <tr>
        <th colspan='11'>$SHOW_ROLL_HITS shots | $UNIT_WEAPON ($WEAPON_TYPE) | Auto 1D6 hits</th>
        </tr>
	<tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
	<th>4</th>
	<th>5</th>
	<th>6</th>
        <th>7</th>
        <th>8</th>
        <th>9</th>
        <th>10</th>
        <th>Hits</th>
	</tr>
	<tr>
	<th>$ROLL_ONE</th>
	<th>$ROLL_TWO</th>
	<th>$ROLL_THREE</th>
	<th>$ROLL_FOUR</th>
	<th>$ROLL_FIVE</th>
	<th>$ROLL_SIX</th>
        <th>$ROLL_SEVEN</th>
        <th>$ROLL_EIGHT</th>
        <th>$ROLL_NINE</th>
        <th>$ROLL_TEN</th>
        <th>$TOTAL_HITS</th>    
	</tr>
	</table>";
    
    $PASS_HITS=$TOTAL_HITS-1;
    $combat_cal = new combat_cal();
    $combat_cal->results(6,$PASS_HITS,$TARGET_UNIT,$WEAPON_STR,$WEAPON_DAMAGE,$FACTION,$ENEMY_FACTION,$WEAPON_AP,$UNIT_WEAPON,$RANGE_BONUS);
}
    
    
    function roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE,$U_ABILITIES) {
    
    $DIE_ONE = 0;
    $DIE_TWO = 0;
    $DIE_THREE = 0;
    $DIE_FOUR = 0;
    $DIE_FIVE = 0;
    $DIE_SIX = 0;
    
    if($WEAPON_TYPE=='Rapid Fire 1' && $RANGE_BONUS>=1) {
        $number=$number+$RANGE_BONUS;
    }
    
    if($WEAPON_TYPE=='Rapid Fire 2' && $RANGE_BONUS>=1) {
        $number=($MODELS_TO_FIRE+$RANGE_BONUS)*2-1;
    }  
    
    if($WEAPON_TYPE=='Rapid Fire 2' && $RANGE_BONUS==0) {
        $number=$number+$MODELS_TO_FIRE;
    }   
    
    if($WEAPON_TYPE=='Pistol 3') {
        $SHOW_ROLL_HITS=($number+1)*3;
        $number=$SHOW_ROLL_HITS-1;
    }     
    
    if($WEAPON_TYPE=='Assualt 2') {
        $SHOW_ROLL_HITS=($number+1)*2;
        $number=$number+$MODELS_TO_FIRE;

    } 
    
    if($WEAPON_TYPE=='Assualt 3') {
        $SHOW_ROLL_HITS=($number+1)*6;
        $number=$number+$SHOW_ROLL_HITS-$MODELS_TO_FIRE;

    }  

    if($WEAPON_TYPE=='Assualt 1D3') {
        if($UNIT_WEAPON=='Plasma Exterminator' || $UNIT_WEAPON=='Supercharged Plasma Exterminator') {
            
        } else{
        $number=$DIE = (mt_rand(1, 3));
    }        
    }
    
    if($WEAPON_TYPE=='Grenade D6') {
        $number=$DIE = (mt_rand(1, 6))-1;
    }
    
    if($WEAPON_TYPE=='Heavy 1D3') {
        $number=$DIE = (mt_rand(1, 3))-1;
    }     
    
    if($WEAPON_TYPE=='Heavy 1D6') {
        $number=$DIE = (mt_rand(1, 6))-1;
    }   
    
    if($WEAPON_TYPE=='Heavy 3') {
        $SHOW_ROLL_HITS=($number+1)*3;
        $number=$SHOW_ROLL_HITS-1;
    } 
    
    if($WEAPON_TYPE=='Heavy 2') {
        $SHOW_ROLL_HITS=($number+1)*2;
        $number=$SHOW_ROLL_HITS-1;
    }     
    
    if($WEAPON_TYPE=='Heavy 4') {
        $SHOW_ROLL_HITS=($number+1)*4;
        $number=$SHOW_ROLL_HITS-1;
    } 

    if($WEAPON_TYPE=='Heavy 6') {
        $SHOW_ROLL_HITS=($number+1)*6;
        $number=$SHOW_ROLL_HITS-1;
    }     
    
    if(empty($SHOW_ROLL_HITS)) {
               $SHOW_ROLL_HITS=$number+1;
    }

    for ($x = 0; $x <= $number; $x++) {

        $DIE = mt_rand(1, $sides);

        if ($DIE == 1) {
            $DIE_ONE++;
        }
        if ($DIE == 2) {
            $DIE_TWO++;
        }
        if ($DIE == 3) {
            $DIE_THREE++;
        }
        if ($DIE == 4) {
            $DIE_FOUR++;
        }
        if ($DIE == 5) {
            $DIE_FIVE++;
        }
        if ($DIE == 6) {
            $DIE_SIX++;
        }
    }       
 
    if($U_BS=='6') {
        $TOTAL_HITS=$DIE_SIX;
    }       
    if($U_BS=='5') {
        $TOTAL_HITS=$DIE_FIVE+$DIE_SIX;
    }      
    if($U_BS=='4') {
        $TOTAL_HITS=$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
    }     
    if($U_BS=='3') {
        $TOTAL_HITS=$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
    }
    if($U_BS=='2') {
        $TOTAL_HITS=$DIE_TWO+$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
    }      
    
    echo "<table class='table table-condensed'>
        <tr>
        <th colspan='7'>$SHOW_ROLL_HITS shots | $UNIT_WEAPON ($WEAPON_TYPE) | $U_BS+ to hit</th>
        </tr>
	<tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
	<th>4</th>
	<th>5</th>
	<th>6</th>
        <th>Hits</th>
	</tr>
	<tr>
	<th>$DIE_ONE</th>
	<th>$DIE_TWO</th>
	<th>$DIE_THREE</th>
	<th>$DIE_FOUR</th>
	<th>$DIE_FIVE</th>
	<th>$DIE_SIX</th>
        <th>$TOTAL_HITS</th>    
	</tr>
	</table>";
    
  $RE_ROLLL_ONES=array("Rites of Battle");
 
 if (array_intersect($RE_ROLLL_ONES, $U_ABILITIES)) {
     
    $PASS_HITS=$TOTAL_HITS-1;
    $combat_cal = new combat_cal();
    $combat_cal->reroll_ones(6,$PASS_HITS,$TARGET_UNIT,$WEAPON_STR,$WEAPON_DAMAGE,$FACTION,$ENEMY_FACTION,$WEAPON_AP,$UNIT_WEAPON,$RANGE_BONUS,$U_ABILITIES,$RE_ROLLL_ONES,$DIE_ONE,$U_BS);     
     
 } else {      
    
    $PASS_HITS=$TOTAL_HITS-1;
    $combat_cal = new combat_cal();
    $combat_cal->results(6,$PASS_HITS,$TARGET_UNIT,$WEAPON_STR,$WEAPON_DAMAGE,$FACTION,$ENEMY_FACTION,$WEAPON_AP,$UNIT_WEAPON,$RANGE_BONUS);
    
 }
}

function reroll_ones($sides, $TOTAL_HITS,$TARGET_UNIT,$WEAPON_STR,$WEAPON_DAMAGE,$FACTION,$ENEMY_FACTION,$WEAPON_AP,$UNIT_WEAPON,$RANGE_BONUS,$U_ABILITIES,$RE_ROLLL_ONES,$DIE_ONE,$U_BS) {
    
 if (array_intersect($RE_ROLLL_ONES, $U_ABILITIES)) {
     
    $DIE_ONE_ROLL = 0;
    $DIE_TWO_ROLL = 0;
    $DIE_THREE_ROLL = 0;
    $DIE_FOUR_ROLL = 0;
    $DIE_FIVE_ROLL = 0;
    $DIE_SIX_ROLL = 0;
    
    $MATCH_ABILITY_USED=array_intersect($RE_ROLLL_ONES, $U_ABILITIES);
    
      foreach($MATCH_ABILITY_USED as $row){
      $ABILITY_USED=$row;
  }

    $NUMBER_OF_REROLLS=$DIE_ONE-1;
    
if($DIE_ONE>0) {

    for ($x = 0; $x <= $NUMBER_OF_REROLLS; $x++) {

        $DIE_REROLL = mt_rand(1, $sides);

        if ($DIE_REROLL == 1) {
            $DIE_ONE_ROLL++;
        }
        if ($DIE_REROLL == 2) {
            $DIE_TWO_ROLL++;
        }
        if ($DIE_REROLL == 3) {
            $DIE_THREE_ROLL++;
        }
        if ($DIE_REROLL == 4) {
            $DIE_FOUR_ROLL++;
        }
        if ($DIE_REROLL == 5) {
            $DIE_FIVE_ROLL++;
        }
        if ($DIE_REROLL == 6) {
            $DIE_SIX_ROLL++;
        }
    }       
}
    if($U_BS=='6') {
        $REROLL_HITS=$DIE_SIX_ROLL;
    }       
    if($U_BS=='5') {
        $REROLL_HITS=$DIE_FIVE_ROLL+$DIE_SIX_ROLL;
    }      
    if($U_BS=='4') {
        $REROLL_HITS=$DIE_FOUR_ROLL+$DIE_FIVE_ROLL+$DIE_SIX_ROLL;
    }     
    if($U_BS=='3') {
        $REROLL_HITS=$DIE_THREE_ROLL+$DIE_FOUR_ROLL+$DIE_FIVE_ROLL+$DIE_SIX_ROLL;
    }
    if($U_BS=='2') {
        $REROLL_HITS=$DIE_TWO_ROLL+$DIE_THREE_ROLL+$DIE_FOUR_ROLL+$DIE_FIVE_ROLL+$DIE_SIX_ROLL;
    }     
    
    $TOTAL_HITS++;
    $DISPLAY_HITS=$TOTAL_HITS+$REROLL_HITS;

    echo "<table class='table table-condensed'>
        <tr>
        <th colspan='8'>$ABILITY_USED: $DIE_ONE re-roll(s) for hit rolls of 1</th>
        </tr>
	<tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
	<th>4</th>
	<th>5</th>
	<th>6</th>
        <th>Reroll</th>
        <th>Hits</th>
        <th>Total</th>
	</tr>
	<tr>
	<th>$DIE_ONE_ROLL</th>
	<th>$DIE_TWO_ROLL</th>
	<th>$DIE_THREE_ROLL</th>
	<th>$DIE_FOUR_ROLL</th>
	<th>$DIE_FIVE_ROLL</th>
	<th>$DIE_SIX_ROLL</th>
        <th>$REROLL_HITS</th>  
        <th>$TOTAL_HITS</th>  
        <th>$DISPLAY_HITS</th>          
	</tr>
	</table>";     
     
 }   
 
    $PASS_HITS=$TOTAL_HITS+$REROLL_HITS-1;
    $combat_cal = new combat_cal();
    $combat_cal->results(6,$PASS_HITS,$TARGET_UNIT,$WEAPON_STR,$WEAPON_DAMAGE,$FACTION,$ENEMY_FACTION,$WEAPON_AP,$UNIT_WEAPON,$RANGE_BONUS); 
    
}

function results($sides, $TOTAL_HITS,$TARGET_UNIT,$WEAPON_STR,$WEAPON_DAMAGE,$FACTION,$ENEMY_FACTION,$WEAPON_AP,$UNIT_WEAPON,$RANGE_BONUS) {

    $DIE_ONE = 0;
    $DIE_TWO = 0;
    $DIE_THREE = 0;
    $DIE_FOUR = 0;
    $DIE_FIVE = 0;
    $DIE_SIX = 0;

    for ($x = 0; $x <= $TOTAL_HITS; $x++) {

        $DIE = mt_rand(1, $sides);

        if ($DIE == 1) {
            $DIE_ONE++;
        }
        if ($DIE == 2) {
            $DIE_TWO++;
        }
        if ($DIE == 3) {
            $DIE_THREE++;
        }
        if ($DIE == 4) {
            $DIE_FOUR++;
        }
        if ($DIE == 5) {
            $DIE_FIVE++;
        }
        if ($DIE == 6) {
            $DIE_SIX++;
        }
    }
    
    if($ENEMY_FACTION=='Ultramarines') {
        require(__DIR__ . '/../target_stats/ultramarines-stats.php');  

    }

    if($ENEMY_FACTION=='Eldar') {
        require(__DIR__ . '/../target_stats/eldar-stats.php');  

    }    

    if($ENEMY_FACTION=='Deathguard') {
        require(__DIR__ . '/../target_stats/deathguard-stats.php');  

    } 
    
    if($ENEMY_FACTION=='Chaos Space Marines') {
        require(__DIR__ . '/../target_stats/csm-stats.php');  

    }     
    
    if($WEAPON_STR + $T_TOUGHNESS >= $WEAPON_STR) {
    //DOUBLE 2+
        $TOTAL_WOUNDS=$DIE_TWO+$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
        $WOUNDS_ON=2;
    }

    if($WEAPON_STR>$T_TOUGHNESS) {
        //3+
        $TOTAL_WOUNDS=$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
        $WOUNDS_ON=3;
    }
    if($WEAPON_STR==$T_TOUGHNESS) {
        //TO WOUND = 4+
        $TOTAL_WOUNDS=$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
        $WOUNDS_ON=4;
    }
    if($WEAPON_STR<$T_TOUGHNESS) {
        // 5+
        $TOTAL_WOUNDS=$DIE_FIVE+$DIE_SIX;
        $WOUNDS_ON=5;
    }    
    if($WEAPON_STR + $T_TOUGHNESS <= $WEAPON_STR) {
    //STR HALF OR LESS THAN T
        $TOTAL_WOUNDS=$DIE_SIX;
        $WOUNDS_ON=6;
    }
    
    if($WEAPON_DAMAGE==2) {
        $TOTAL_WOUNDS=$TOTAL_WOUNDS*2;
    }
    

    
    
    
    echo "<table class='table table-condensed'>
        <tr>
        <th colspan='7'>$TOTAL_WOUNDS Wounds | T $T_TOUGHNESS | STR $WEAPON_STR | DMG $WEAPON_DAMAGE | $WOUNDS_ON+ to wound </th>
        </tr>
	<tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
	<th>4</th>
	<th>5</th>
	<th>6</th>
        <th>Wounds</th>
	</tr>
	<tr>
	<th>$DIE_ONE</th>
	<th>$DIE_TWO</th>
	<th>$DIE_THREE</th>
	<th>$DIE_FOUR</th>
	<th>$DIE_FIVE</th>
	<th>$DIE_SIX</th>
        <th>$TOTAL_WOUNDS</th>  
	</tr>
	</table>";  
    
    if(!is_numeric ($WEAPON_DAMAGE) || $UNIT_WEAPON=='Grav-cannon and grav-amp' || $UNIT_WEAPON=='Grav-gun' && $T_SAVE=='3'|| $UNIT_WEAPON=='Meltagun' && $RANGE_BONUS>=1 || $UNIT_WEAPON=='Multi-melta' && $RANGE_BONUS>=1 || $UNIT_WEAPON=='Supercharged Plasma Exterminator') {

    $SAVE_ROLLS=$TOTAL_WOUNDS-1;
    $combat_cal = new combat_cal();
    $combat_cal->damage_modifier($TOTAL_WOUNDS,$WEAPON_DAMAGE,$T_SAVE,$WEAPON_AP,$UNIT_WEAPON,$RANGE_BONUS,$T_INVUL,$T_ABILITIES); 
    
    

    } elseif(is_numeric ($WEAPON_DAMAGE)) {
    $SAVE_ROLLS=$TOTAL_WOUNDS-1;
    $combat_cal = new combat_cal();
    $combat_cal->save_rolls($T_SAVE,$SAVE_ROLLS,$WEAPON_AP,$UNIT_WEAPON,$T_INVUL,$T_ABILITIES);
    
    }
    
}

function damage_modifier ($TOTAL_WOUNDS,$WEAPON_DAMAGE,$T_SAVE,$WEAPON_AP,$UNIT_WEAPON,$RANGE_BONUS,$T_INVUL,$T_ABILITIES) {
    
$WOUNDS_TO_ROLL=$TOTAL_WOUNDS-1;

    if($UNIT_WEAPON=='Meltagun' && $RANGE_BONUS>=1 || $UNIT_WEAPON=='Multi-melta' && $RANGE_BONUS>=1) {
 
$ORIG_DIE_ONE=0;
$ORIG_DIE_TWO=0;
$DIE=0;
        
    for ($x = 0; $x <= $WOUNDS_TO_ROLL; $x++) {
        
        $DIE = mt_rand(1, 6);
        $DIE_TWO = mt_rand(1, 6);
        
        $ORIG_DIE_ONE=$DIE;
        $ORIG_DIE_TWO=$DIE_TWO;
        
        if($DIE >= $DIE_TWO) {     
                    
            
        } if($DIE_TWO > $DIE) {      
          
          $DIE=$DIE_TWO;
            
        }      
		
		    }  
            
        $TOTAL_WOUNDS=$DIE." ($WEAPON_DAMAGE)";    
        
    echo "<table class='table table-condensed'>
        <tr>
        <th colspan='7'>2D6 Damage and discarded highest</th>
        </tr>
	<tr>
	<th>Die 1</th>
	<th>Die 2</th>
        <th>Wounds</th>
	</tr>
	<tr>
        <th>$ORIG_DIE_ONE</th>
        <th>$ORIG_DIE_TWO</th>            
        <th>$TOTAL_WOUNDS</th>  
	</tr>
	</table>";         
        
    }

    elseif($WEAPON_DAMAGE=='1D3') {
        
$DIE_ONE_MOD=0;
$DIE_TWO_MOD=0;
$DIE_THREE_MOD=0;        
        
    for ($x = 0; $x <= $WOUNDS_TO_ROLL; $x++) {

        $DIE = mt_rand(1, 3);

        if ($DIE == 1) {
            $DIE_ONE_MOD++;
        }
        if ($DIE == 2) {
            $DIE_TWO_MOD++;
            $DIE_TWO_MOD++;
        }
        if ($DIE == 3) {
            $DIE_THREE_MOD++;
            $DIE_THREE_MOD++;
            $DIE_THREE_MOD++;
        }
		
		    }  
            
        $TOTAL_WOUNDS=$DIE_ONE_MOD+$DIE_TWO_MOD+$DIE_THREE_MOD." ($WEAPON_DAMAGE)";    
        
    echo "<table class='table table-condensed'>
        <tr>
        <th colspan='4'>1D3 Damage</th>
        </tr>
	<tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
        <th>Wounds</th>
	</tr>
	<tr>
	<th>$DIE_ONE_MOD</th>
	<th>$DIE_TWO_MOD</th>
	<th>$DIE_THREE_MOD</th>
        <th>$TOTAL_WOUNDS</th>  
	</tr>
	</table>";        
                    
    }
    
    elseif($UNIT_WEAPON=='Grav-cannon and grav-amp' && $T_SAVE<=3 || $UNIT_WEAPON=='Grav-gun' && $T_SAVE=='3') {
        
    
$DIE_ONE_MOD=0;
$DIE_TWO_MOD=0;
$DIE_THREE_MOD=0;        
        
    for ($x = 0; $x <= $WOUNDS_TO_ROLL; $x++) {

        $DIE = mt_rand(1, 3);

        if ($DIE == 1) {
            $DIE_ONE_MOD++;
        }
        if ($DIE == 2) {
            $DIE_TWO_MOD++;
            $DIE_TWO_MOD++;
        }
        if ($DIE == 3) {
            $DIE_THREE_MOD++;
            $DIE_THREE_MOD++;
            $DIE_THREE_MOD++;
        }
		
		    }  
            
        $TOTAL_WOUNDS=$DIE_ONE_MOD+$DIE_TWO_MOD+$DIE_THREE_MOD." (1D3)";    
        
    echo "<table class='table table-condensed'>
        <tr>
        <th colspan='4'>1D3 Damage on 3+ save or better</th>
        </tr>
	<tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
        <th>Wounds</th>
	</tr>
	<tr>
	<th>$DIE_ONE_MOD</th>
	<th>$DIE_TWO_MOD</th>
	<th>$DIE_THREE_MOD</th>
        <th>$TOTAL_WOUNDS</th>  
	</tr>
	</table>";        
        
    }
    
    elseif($WEAPON_DAMAGE=='1D6') {
        
$DIE_ONE_MOD=0;
$DIE_TWO_MOD=0;
$DIE_THREE_MOD=0; 
$DIE_FOUR_MOD=0; 
$DIE_FIVE_MOD=0; 
$DIE_SIX_MOD=0; 
        
    for ($x = 0; $x <= $WOUNDS_TO_ROLL; $x++) {

        $DIE = mt_rand(1, 6);

        if ($DIE == 1) {
            $DIE_ONE_MOD++;
        }
        if ($DIE == 2) {
            $DIE_TWO_MOD++;
            $DIE_TWO_MOD++;
        }
        if ($DIE == 3) {
            $DIE_THREE_MOD++;
            $DIE_THREE_MOD++;
            $DIE_THREE_MOD++;
        }
        if ($DIE == 4) {
            $DIE_FOUR_MOD++;
            $DIE_FOUR_MOD++;
            $DIE_FOUR_MOD++;
            $DIE_FOUR_MOD++;
        }
        if ($DIE == 5) {
            $DIE_FIVE_MOD++;
            $DIE_FIVE_MOD++;
            $DIE_FIVE_MOD++;
            $DIE_FIVE_MOD++;
            $DIE_FIVE_MOD++;
        }
        if ($DIE == 6) {
            $DIE_SIX_MOD++;
            $DIE_SIX_MOD++;
            $DIE_SIX_MOD++;
            $DIE_SIX_MOD++;
            $DIE_SIX_MOD++;
            $DIE_SIX_MOD++;            
        }        
		
		    }  
            
        $TOTAL_WOUNDS=$DIE_ONE_MOD+$DIE_TWO_MOD+$DIE_THREE_MOD+$DIE_FOUR_MOD+$DIE_FIVE_MOD+$DIE_SIX_MOD." ($WEAPON_DAMAGE)";    
        
    echo "<table class='table table-condensed'>
        <tr>
        <th colspan='7'>1D6 Damage</th>
        </tr>
	<tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
        <th>4</th>
        <th>5</th>
        <th>6</th>
        <th>Wounds</th>
	</tr>
	<tr>
	<th>$DIE_ONE_MOD</th>
	<th>$DIE_TWO_MOD</th>
	<th>$DIE_THREE_MOD</th>
        <th>$DIE_FOUR_MOD</th>
        <th>$DIE_FIVE_MOD</th>
        <th>$DIE_SIX_MOD</th>            
        <th>$TOTAL_WOUNDS</th>  
	</tr>
	</table>";        
                    
    }    
    
    $SAVE_ROLLS=$TOTAL_WOUNDS-1;
    $combat_cal = new combat_cal();
    $combat_cal->save_rolls($T_SAVE,$SAVE_ROLLS,$WEAPON_AP,$UNIT_WEAPON,$T_INVUL,$T_ABILITIES);
    
}

function save_rolls($T_SAVE,$SAVE_ROLLS,$WEAPON_AP,$UNIT_WEAPON,$T_INVUL,$T_ABILITIES) {
    
    if($WEAPON_AP>=1) {
        if($WEAPON_AP=='1') {
            $T_SAVE++;
        }
        elseif($WEAPON_AP=='2') {
            $T_SAVE++;
            $T_SAVE++;
        }     
        elseif($WEAPON_AP=='3') {
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
        }        
        elseif($WEAPON_AP=='4') {
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
        }      
        elseif($WEAPON_AP=='5') {
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
        }       
        elseif($WEAPON_AP=='6') {
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
        }
        
    }    
    
    $DIE_ONE = 0;
    $DIE_TWO = 0;
    $DIE_THREE = 0;
    $DIE_FOUR = 0;
    $DIE_FIVE = 0;
    $DIE_SIX = 0;    
    
    for ($x = 0; $x <= $SAVE_ROLLS; $x++) {

        $DIE = mt_rand(1, 6);

        if ($DIE == 1) {
            $DIE_ONE++;
        }
        if ($DIE == 2) {
            $DIE_TWO++;
        }
        if ($DIE == 3) {
            $DIE_THREE++;
        }
        if ($DIE == 4) {
            $DIE_FOUR++;
        }
        if ($DIE == 5) {
            $DIE_FIVE++;
        }
        if ($DIE == 6) {
            $DIE_SIX++;
        }
    }
    
    if($T_SAVE>6) {
        $TOTAL_SAVES=0;
        $TOTAL_FAILS=$DIE_ONE+$DIE_TWO+$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;    
    }
    
    elseif($T_SAVE==6) {
        $TOTAL_SAVES=$DIE_SIX;
        $TOTAL_FAILS=$DIE_ONE+$DIE_TWO+$DIE_THREE+$DIE_FOUR+$DIE_FIVE;
    }      
    
    elseif($T_SAVE==5) {
        $TOTAL_SAVES=$DIE_FIVE+$DIE_SIX;
        $TOTAL_FAILS=$DIE_ONE+$DIE_TWO+$DIE_THREE+$DIE_FOUR;
    }     

    elseif($T_SAVE==4) {
        $TOTAL_SAVES=$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
        $TOTAL_FAILS=$DIE_ONE+$DIE_TWO+$DIE_THREE;
    } 
    
    elseif($T_SAVE==3) {
        $TOTAL_SAVES=$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
        $TOTAL_FAILS=$DIE_ONE+$DIE_TWO;
    }
    
    elseif($T_SAVE==2) {
        $TOTAL_SAVES=$DIE_TWO+$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
        $TOTAL_FAILS=$DIE_ONE;
    }    
    
    if(isset($T_INVUL)) {    

    if($T_INVUL>6) {
        $TOTAL_INVUL=0;
        $TOTAL_INVUL_FAILS=$DIE_ONE+$DIE_TWO+$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;    
    }
    
    elseif($T_INVUL==6) {
        $TOTAL_INVUL=$DIE_SIX;
        $TOTAL_INVUL_FAILS=$DIE_ONE+$DIE_TWO+$DIE_THREE+$DIE_FOUR+$DIE_FIVE;
    }      
    
    elseif($T_INVUL==5) {
        $TOTAL_INVUL=$DIE_FIVE+$DIE_SIX;
        $TOTAL_INVUL_FAILS=$DIE_ONE+$DIE_TWO+$DIE_THREE+$DIE_FOUR;
    }     

    elseif($T_INVUL==4) {
        $TOTAL_INVUL=$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
        $TOTAL_INVUL_FAILS=$DIE_ONE+$DIE_TWO+$DIE_THREE;
    }    
    
    elseif($T_INVUL==3) {
        $TOTAL_INVUL=$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
        $TOTAL_INVUL_FAILS=$DIE_ONE+$DIE_TWO;
    }
    
    elseif($T_INVUL==2) {
        $TOTAL_INVUL=$DIE_TWO+$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
        $TOTAL_INVUL_FAILS=$DIE_ONE;
    }
    
    else {
        $TOTAL_INVUL="-";
        $TOTAL_INVUL_FAILS="-";
    }
    
    }

    $SAVE_ROLL_DISPLAY=$SAVE_ROLLS+1;
    
    if($UNIT_WEAPON=='Sniper Rifle') {
    $MORTAL_WOUNDS=$DIE_SIX;
    }
    
    if(empty($MORTAL_WOUNDS)) {
        $MORTAL_WOUNDS=0;
    }

    echo "<table class='table table-condensed'>
        <tr>
        <th colspan='9'>$SAVE_ROLL_DISPLAY Save(s) | AP $WEAPON_AP | $T_SAVE+ to Save | $T_INVUL+ Invul</th>
        </tr>
	<tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
	<th>4</th>
	<th>5</th>
	<th>6</th>
        <th>Saves</th>
        <th>Invul</th>
        <th>Mortal</th>
	</tr>
	<tr>
	<th>$DIE_ONE</th>
	<th>$DIE_TWO</th>
	<th>$DIE_THREE</th>
	<th>$DIE_FOUR</th>
	<th>$DIE_FIVE</th>
	<th>$DIE_SIX</th>
        <th>$TOTAL_SAVES ($TOTAL_FAILS)</th>
        <th>$TOTAL_INVUL ($TOTAL_INVUL_FAILS)</th>   
        <th>$MORTAL_WOUNDS</th>    
	</tr>
	</table>";  
    
    $IGN_WOUND=array("Disgustingly Resilient");
    
    if (array_intersect($IGN_WOUND, $T_ABILITIES)) {
    
    $combat_cal = new combat_cal();
    $combat_cal->ignore_wounds($TOTAL_SAVES,$TOTAL_INVUL,$TOTAL_FAILS,$TOTAL_INVUL_FAILS);
    
    }
    
}

function ignore_wounds($TOTAL_SAVES,$TOTAL_INVUL,$TOTAL_FAILS,$TOTAL_INVUL_FAILS) {
        
    $DIE_ONE = 0;
    $DIE_TWO = 0;
    $DIE_THREE = 0;
    $DIE_FOUR = 0;
    $DIE_FIVE = 0;
    $DIE_SIX = 0;       
    
    if($TOTAL_SAVES>$TOTAL_INVUL) {
        $IGN_SAVE_ROLLS=$TOTAL_INVUL_FAILS-1;
        $SHOW_IGN_SAVE_ROLLS=$TOTAL_INVUL_FAILS;
    }
    elseif($TOTAL_SAVES<=$TOTAL_INVUL) {
        $IGN_SAVE_ROLLS=$TOTAL_FAILS-1;
        $SHOW_IGN_SAVE_ROLLS=$TOTAL_FAILS;
    }
        
    for ($x = 0; $x <= $IGN_SAVE_ROLLS; $x++) {

        $DIE = mt_rand(1, 6);

        if ($DIE == 1) {
            $DIE_ONE++;
        }
        if ($DIE == 2) {
            $DIE_TWO++;
        }
        if ($DIE == 3) {
            $DIE_THREE++;
        }
        if ($DIE == 4) {
            $DIE_FOUR++;
        }
        if ($DIE == 5) {
            $DIE_FIVE++;
        }
        if ($DIE == 6) {
            $DIE_SIX++;
        }
    }
    $IGNORE_WOUNDS=$DIE_FIVE+$DIE_SIX;
    $FAILS=$SHOW_IGN_SAVE_ROLLS-$IGNORE_WOUNDS;

    if(empty($IGNORE_WOUNDS)) {
        $IGNORE_WOUNDS=0;
        $FAILS="-";
    }
    
    echo "<table class='table table-condensed'>
        <tr>
        <th colspan='9'>$SHOW_IGN_SAVE_ROLLS roll(s) to Ignore wounds</th>
        </tr>
	<tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
	<th>4</th>
	<th>5</th>
	<th>6</th>
        <th>Saves</th>
	</tr>
	<tr>
	<th>$DIE_ONE</th>
	<th>$DIE_TWO</th>
	<th>$DIE_THREE</th>
	<th>$DIE_FOUR</th>
	<th>$DIE_FIVE</th>
	<th>$DIE_SIX</th> 
        <th>$IGNORE_WOUNDS($FAILS)</th>   
	</tr>
	</table>";      
    
    
}

}

