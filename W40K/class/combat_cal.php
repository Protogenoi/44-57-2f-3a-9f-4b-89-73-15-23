<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of combat_cal
 *
 * @author michael
 */
class combat_cal { 
    
    function roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RAPID_FIRE,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT) {
    
        if($FACTION=='Ultramarines') {
        
    if($UNIT=='Intercessor Squad') {
        $U_BS=3; 
    
    if($UNIT_WEAPON=='Auto Bolt Rifle') {
        $WEAPON_STR=4;
        $WEAPON_AP=0;
        $WEAPON_DAMAGE=1;
        $WEAPON_TYPE='Assualt 2';
        $WEAPON_RANGE=24;   
    
        if($MOVEMENT=='Advanced') {
            $U_BS=4;
        }
        
    }
    if($UNIT_WEAPON=='Stalker Bolt Rifle') {
        $WEAPON_STR=4;
        $WEAPON_AP=2;
        $WEAPON_DAMAGE=1;
        $WEAPON_TYPE='Heavy 1';
        $WEAPON_RANGE=36;

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }        
        
    }  
    
    if($UNIT_WEAPON=='Bolt Pistol') {
        $WEAPON_STR=4;
        $WEAPON_AP=0;
        $WEAPON_DAMAGE=1;
        $WEAPON_TYPE='Pistol 1';
        $WEAPON_RANGE=12;
    }      
    
    if($UNIT_WEAPON=='Bolt Rifle') {
        $WEAPON_STR=4;
        $WEAPON_AP=1;
        $WEAPON_DAMAGE=1;
        $WEAPON_TYPE='Rapid Fire 1';
        $WEAPON_RANGE=30;
    } 
    
    if($UNIT_WEAPON=='Frag grenade') {
        $WEAPON_STR=3;
        $WEAPON_AP=0;
        $WEAPON_DAMAGE=1;
        $WEAPON_TYPE='Grenade D6';
        $WEAPON_RANGE=6;
    }

    if($UNIT_WEAPON=='Krak grenade') {
        $WEAPON_STR=6;
        $WEAPON_AP=1;
        $WEAPON_DAMAGE="1D3";
        $WEAPON_TYPE='Grenade 1';
        $WEAPON_RANGE=6;
    }     
    
    }
    
        }
    
    if($ENEMY_FACTION=='Deathguard') {
        
    }    
    
    $DIE_ONE = 0;
    $DIE_TWO = 0;
    $DIE_THREE = 0;
    $DIE_FOUR = 0;
    $DIE_FIVE = 0;
    $DIE_SIX = 0;
    
    if($WEAPON_TYPE=='Rapid Fire 1' && $RAPID_FIRE>=1) {
        $number=$number+$RAPID_FIRE;
    }
    
    if($WEAPON_TYPE=='Assualt 2') {
        $SHOW_ROLL_HITS=($number+1)*2;
        $number=$number+$MODELS_TO_FIRE;

    }  
    
    if(empty($SHOW_ROLL_HITS)) {
               $SHOW_ROLL_HITS=$number+1;
    }

    for ($x = 0; $x <= $number; $x++) {

        $DIE = mt_rand(1, $sides) . "<br>";

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
        $TOTAL_HITS=$DIE_TWO;
    }      

    echo "<table class='table'>
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
    
    $PASS_HITS=$TOTAL_HITS-1;
    $combat_cal = new combat_cal();
    $combat_cal->results(6,$PASS_HITS,$TARGET_UNIT,$WEAPON_STR,$WEAPON_DAMAGE,$FACTION,$ENEMY_FACTION,$WEAPON_AP);
}

function results($sides, $TOTAL_HITS,$TARGET_UNIT,$WEAPON_STR,$WEAPON_DAMAGE,$FACTION,$ENEMY_FACTION,$WEAPON_AP) {

    $DIE_ONE = 0;
    $DIE_TWO = 0;
    $DIE_THREE = 0;
    $DIE_FOUR = 0;
    $DIE_FIVE = 0;
    $DIE_SIX = 0;

    for ($x = 0; $x <= $TOTAL_HITS; $x++) {

        $DIE = mt_rand(1, $sides) . "<br>";

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
        
    if($ENEMY_FACTION || $FACTION =='Deathguard') {
    if($TARGET_UNIT=='Deathguard') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=3;
        $T_TOUGHNESS=5; 
        
    }   
    
    if($TARGET_UNIT=='Pox walkers') {
        $T_WS=5;
        $T_BS=5;
        $T_WOUNDS=1;
        $T_SAVE=6;
        $T_TOUGHNESS=3; 
        
    }
    
    }
    
    if($ENEMY_FACTION || $FACTION =='Chaos Space Marines') {
        
    if($TARGET_UNIT=='Kharn the Betrayer') {
        $T_WS=2;
        $T_BS=2;
        $T_WOUNDS=5;
        $T_SAVE=3;
        $T_TOUGHNESS=4; 
        
    }     
    
    if($TARGET_UNIT=='Abaddon the Despoiler') {
        $T_WS=2;
        $T_BS=2;
        $T_WOUNDS=7;
        $T_SAVE=2;
        $T_TOUGHNESS=5; 
        
    } 

    if($TARGET_UNIT=='Daemon Prince') {
        $T_WS=2;
        $T_BS=2;
        $T_WOUNDS=8;
        $T_SAVE=3;
        $T_TOUGHNESS=6; 
        
    }   
    
    if($TARGET_UNIT=='Khorne Bezerkers') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=3;
        $T_TOUGHNESS=4; 
        
    }    
    
    if($TARGET_UNIT=='Bezerker Champion') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=3;
        $T_TOUGHNESS=4; 
        
    }    
    
    if($TARGET_UNIT=='Rubric Marines') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=3;
        $T_TOUGHNESS=4; 
        
    }
    
    if($TARGET_UNIT=='Aspiring Sorcerer') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=3;
        $T_TOUGHNESS=4; 
        
    }    

    if($TARGET_UNIT=='Plague Marines') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=3;
        $T_TOUGHNESS=5; 
        
    }   
    
    if($TARGET_UNIT=='Plague Champion') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=3;
        $T_TOUGHNESS=5; 
        
    }    
    
    if($TARGET_UNIT=='Chaos Terminator') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=2;
        $T_SAVE=2;
        $T_TOUGHNESS=4; 
        
    }     

    if($TARGET_UNIT=='Terminator Champion') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=2;
        $T_SAVE=2;
        $T_TOUGHNESS=4; 
        
    } 
    
    if($TARGET_UNIT=='Helbrute') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=8;
        $T_SAVE=3;
        $T_TOUGHNESS=7; 
        
    } 
    
    if($TARGET_UNIT=='Havocs') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=3;
        $T_TOUGHNESS=4; 
        
    }   
    
    if($TARGET_UNIT=='Chaos Land Raider') {
        $T_WS=6;
        $T_BS=0;
        $T_WOUNDS=16;
        $T_SAVE=2;
        $T_TOUGHNESS=8; 
        
    }  
    
    if($TARGET_UNIT=='Chaos Predator') {
        $T_WS=6;
        $T_BS=0;
        $T_WOUNDS=11;
        $T_SAVE=3;
        $T_TOUGHNESS=7; 
        
    }     
    
    if($TARGET_UNIT=='Chaos Space Marines') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=3;
        $T_TOUGHNESS=4; 
        
    }  

    if($TARGET_UNIT=='Aspiring Champion') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=3;
        $T_TOUGHNESS=4; 
        
    }     

    if($TARGET_UNIT=='Chaos Cultists') {
        $T_WS=4;
        $T_BS=4;
        $T_WOUNDS=1;
        $T_SAVE=6;
        $T_TOUGHNESS=3; 
        
    } 
    
    if($TARGET_UNIT=='Cultist Champion') {
        $T_WS=4;
        $T_BS=4;
        $T_WOUNDS=1;
        $T_SAVE=6;
        $T_TOUGHNESS=3; 
        
    }     

    if($TARGET_UNIT=='Bloodletters') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=6;
        $T_TOUGHNESS=3; 
        
    }
    
    if($TARGET_UNIT=='Bloodreaper') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=6;
        $T_TOUGHNESS=3; 
        
    }    
    
    if($TARGET_UNIT=='Pink Horrors') {
        $T_WS=4;
        $T_BS=4;
        $T_WOUNDS=1;
        $T_SAVE=6;
        $T_TOUGHNESS=3; 
        
    }    

    if($TARGET_UNIT=='Blue Horrors') {
        $T_WS=5;
        $T_BS=0;
        $T_WOUNDS=1;
        $T_SAVE=6;
        $T_TOUGHNESS=3; 
        
    }
    
    if($TARGET_UNIT=='Pair of Brimstone Horrors') {
        $T_WS=5;
        $T_BS=0;
        $T_WOUNDS=1;
        $T_SAVE=6;
        $T_TOUGHNESS=3; 
        
    }    
    
    if($TARGET_UNIT=='Plaguebearers') {
        $T_WS=4;
        $T_BS=4;
        $T_WOUNDS=1;
        $T_SAVE=6;
        $T_TOUGHNESS=4; 
        
    }  
    
    if($TARGET_UNIT=='Plagueridden') {
        $T_WS=4;
        $T_BS=4;
        $T_WOUNDS=1;
        $T_SAVE=6;
        $T_TOUGHNESS=4; 
        
    }       

    if($TARGET_UNIT=='Daemonettes') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=6;
        $T_TOUGHNESS=3; 
        
    }  

    if($TARGET_UNIT=='Alluress') {
        $T_WS=3;
        $T_BS=3;
        $T_WOUNDS=1;
        $T_SAVE=6;
        $T_TOUGHNESS=3; 
        
    } 
    
    }
    
    if($WEAPON_AP>=1) {
        if($WEAPON_AP=='1') {
            $T_SAVE++;
        }
        if($WEAPON_AP=='2') {
            $T_SAVE++;
            $T_SAVE++;
        }     
        if($WEAPON_AP=='3') {
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
        }        
        if($WEAPON_AP=='4') {
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
        }      
        if($WEAPON_AP=='5') {
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
        }       
        if($WEAPON_AP=='6') {
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
            $T_SAVE++;
        }
        
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
    
    echo "<table class='table'>
        <tr>
        <th colspan='7'>Toughness $T_TOUGHNESS | Weapon Str $WEAPON_STR | $WOUNDS_ON+ to wound </th>
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
    
    if(!is_numeric ($WEAPON_DAMAGE)) {
    
    $SAVE_ROLLS=$TOTAL_WOUNDS-1;
    $combat_cal = new combat_cal();
    $combat_cal->damage_modifier($TOTAL_WOUNDS,$WEAPON_DAMAGE,$T_SAVE); 
    
    } if(is_numeric ($WEAPON_DAMAGE)) {
    
    $SAVE_ROLLS=$TOTAL_WOUNDS-1;
    $combat_cal = new combat_cal();
    $combat_cal->save_rolls($T_SAVE,$SAVE_ROLLS);
    
    }
    
}

function damage_modifier ($TOTAL_WOUNDS,$WEAPON_DAMAGE,$T_SAVE) {
    
$WOUNDS_TO_ROLL=$TOTAL_WOUNDS-1;

    if($WEAPON_DAMAGE=='1D3') {
        
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
        
    echo "<table class='table'>
        <tr>
        <th colspan='7'>1D3 Damage</th>
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
    
    $SAVE_ROLLS=$TOTAL_WOUNDS-1;
    $combat_cal = new combat_cal();
    $combat_cal->save_rolls($T_SAVE,$SAVE_ROLLS);
    
}

function save_rolls($T_SAVE,$SAVE_ROLLS) {
    
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
    
    if($T_SAVE==6) {
        $TOTAL_SAVES=$DIE_SIX;
        $TOTAL_FAILS=$DIE_ONE+$DIE_TWO+$DIE_THREE+$DIE_FOUR+$DIE_FIVE;
    }      
    
    if($T_SAVE==5) {
        $TOTAL_SAVES=$DIE_FIVE+$DIE_SIX;
        $TOTAL_FAILS=$DIE_ONE+$DIE_TWO+$DIE_THREE+$DIE_FOUR;
    }     

    if($T_SAVE==4) {
        $TOTAL_SAVES=$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
        $TOTAL_FAILS=$DIE_ONE+$DIE_TWO+$DIE_THREE;
    }    
    
    if($T_SAVE==3) {
        $TOTAL_SAVES=$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
        $TOTAL_FAILS=$DIE_ONE+$DIE_TWO;
    }
    
    if($T_SAVE==2) {
        $TOTAL_SAVES=$DIE_TWO+$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
        $TOTAL_FAILS=$DIE_ONE;
    }    
    
    $SAVE_ROLL_DISPLAY=$SAVE_ROLLS+1;

    echo "<table class='table'>
        <tr>
        <th colspan='7'>$SAVE_ROLL_DISPLAY Wound(s) | $T_SAVE+ to Save</th>
        </tr>
	<tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
	<th>4</th>
	<th>5</th>
	<th>6</th>
        <th>Fails</th>
        <th>Saves</th>
	</tr>
	<tr>
	<th>$DIE_ONE</th>
	<th>$DIE_TWO</th>
	<th>$DIE_THREE</th>
	<th>$DIE_FOUR</th>
	<th>$DIE_FIVE</th>
	<th>$DIE_SIX</th>
        <th>$TOTAL_FAILS</th>
        <th>$TOTAL_SAVES</th>  
	</tr>
	</table>";    
    
}

}

