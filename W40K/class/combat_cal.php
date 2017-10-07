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
    
    function weapon_stats ($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT) {
        
                
       if($UNIT_WEAPON=='Combi-flamer') {
           $UNIT_WEAPON='Flamer';
       }
       if($UNIT_WEAPON=='Combi-melta') {
           $UNIT_WEAPON='Meltagun';
       }
       if($UNIT_WEAPON=='Combi-plasma') {
           $UNIT_WEAPON=='Plasma Gun';
       }
       if($UNIT_WEAPON=='Supercharged Combi-plasma') {
           $UNIT_WEAPON=='Supercharged Plasma Gun';
       }
       
       if($UNIT_WEAPON=='Storm Bolter') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Rapid Fire 2';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";  
           
       }
       
        if($FACTION=='Ultramarines') {
            
        if($UNIT=='Captain in Gravis armour') {
        $U_BS=2;
        if($UNIT_WEAPON=='Boltstorm Gauntlet') {    
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Pistol 3';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";  
            
        }
        }
        
        if($UNIT=='Primaris Ancient') {
            $U_BS=3;
            
    if($UNIT_WEAPON=='Bolt Rifle') {
        $WEAPON_RANGE=30;
        $WEAPON_TYPE='Rapid Fire 1';
        $WEAPON_STR=4;
        $WEAPON_AP=1;
        $WEAPON_DAMAGE=1;
            
    }             

        if($UNIT_WEAPON=='Bolt Pistol') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Pistol 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }      
    
        if($UNIT_WEAPON=='Frag Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade D6';
            $WEAPON_STR=3;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }        
        
        if($UNIT_WEAPON=='Krak Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade 1';
            $WEAPON_STR=6;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1D3";          
        }             
            
        }
        
        if($UNIT=='Inceptor Squad') {
            $U_BS=3;
            
            if($UNIT_WEAPON=='Assualt Bolter') {
            $WEAPON_RANGE=18;
            $WEAPON_TYPE='Assualt 3';
            $WEAPON_STR=5;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1";  
                
            }
            if($UNIT_WEAPON=='Plasma Exterminator') {
            $WEAPON_RANGE=18;
            $WEAPON_TYPE='Assualt 1D3';
            $WEAPON_STR=7;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1"; 
            
        if($MOVEMENT=='Advanced') {
            $U_BS=4;
        }            
                
            }
            if($UNIT_WEAPON=='Supercharged Plasma Exterminator') {
            $WEAPON_RANGE=18;
            $WEAPON_TYPE='Assualt 1D3';
            $WEAPON_STR=8;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="2";  
            
        if($MOVEMENT=='Advanced') {
            $U_BS=4;
        }            
                
            }            
        }
            
            if($UNIT=='Primaris Lieutenants') {
                
                $U_BS=3;
                
    if($UNIT_WEAPON=='Master Crafted Auto Bolt Rifle') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Assualt 2';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="2";     
    
        if($MOVEMENT=='Advanced') {
            $U_BS=4;
        }
        
    }
    if($UNIT_WEAPON=='Master Crafted Stalker Bolt Rifle') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=4;
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="2";  

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }        
        
    }  
        if($UNIT_WEAPON=='Bolt Pistol') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Pistol 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }      
    
        if($UNIT_WEAPON=='Frag Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade D6';
            $WEAPON_STR=3;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }        
        
        if($UNIT_WEAPON=='Krak Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade 1';
            $WEAPON_STR=6;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1D3";          
        }      
    
    }    
        
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
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Pistol 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }      
    
    if($UNIT_WEAPON=='Bolt Rifle') {
        $WEAPON_RANGE=30;
        $WEAPON_TYPE='Rapid Fire 1';
        $WEAPON_STR=4;
        $WEAPON_AP=1;
        $WEAPON_DAMAGE=1;
            
    } 
    
        if($UNIT_WEAPON=='Frag Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade D6';
            $WEAPON_STR=3;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }        
        
        if($UNIT_WEAPON=='Krak Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade 1';
            $WEAPON_STR=6;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1D3";          
        }      
    
    }
    
    if($UNIT=='Hellblaster Squad') {
        $U_BS=3;
         if($UNIT_WEAPON=='Bolt Pistol') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Pistol 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }      
    
        if($UNIT_WEAPON=='Frag Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade D6';
            $WEAPON_STR=3;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }        
        
        if($UNIT_WEAPON=='Krak Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade 1';
            $WEAPON_STR=6;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1D3";          
        }        

        if($UNIT_WEAPON=='Assualt Plasma Incinerator') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Assualt 2';
            $WEAPON_STR=6;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1";  
            
         if($MOVEMENT=='Advanced') {
            $U_BS=4;
        }           
            
        }
        
        if($UNIT_WEAPON=='Supercharged Assualt Plasma Incinerator') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Assualt 2';
            $WEAPON_STR=7;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="2";  
            
         if($MOVEMENT=='Advanced') {
            $U_BS=4;
        }           
            
        }   
        
        if($UNIT_WEAPON=='Heavy Plasma Incinerator') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=8;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1";  
            
         if($MOVEMENT=='Moved') {
            $U_BS=4;
        }           
            
        }
        
        if($UNIT_WEAPON=='Supercharged Heavy Plasma Incinerator') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=9;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="2";  
            
         if($MOVEMENT=='Moved') {
            $U_BS=4;
        }           
            
        }        
        
        if($UNIT_WEAPON=='Plasma Incinerator') {
            $WEAPON_RANGE=30;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=7;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1";           
            
        }
        
        if($UNIT_WEAPON=='Supercharged Plasma Incinerator') {
            $WEAPON_RANGE=30;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=8;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="2";             
            
        }         
        
    }
    
    if($UNIT=='Scout Squad') {
        $U_BS=3;
        
        if($UNIT_WEAPON=='Boltgun') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }
        
        if($UNIT_WEAPON=='Bolt Pistol') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Pistol 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }  
        
        if($UNIT_WEAPON=='Astartes Shotgun') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Assault 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1"; 

        if($MOVEMENT=='Advanced') {
            $U_BS=4;
        }            
            
        }         
        
        if($UNIT_WEAPON=='Heavy Bolter') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 3';
            $WEAPON_STR=5;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1";  
 
        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }            
            
        }    
        
        if($UNIT_WEAPON=='Frag Missile Launcher') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 1D6';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";   

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }             
            
        }  
        
        if($UNIT_WEAPON=='Krak Missile Launcher') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=8;
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="1D6"; 

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }             
            
        }   
        
        if($UNIT_WEAPON=='Sniper Rifle') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";  
            
        if($MOVEMENT=='Moved') {
            $U_BS=4;
        } 
        
        }  
        
        if($UNIT_WEAPON=='Frag Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade D6';
            $WEAPON_STR=3;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }        
        
        if($UNIT_WEAPON=='Krak Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade 1';
            $WEAPON_STR=6;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1D3";          
        }  
        
    }
    
 if($UNIT=='Tactical Squad') {
        $U_BS=3;
        
        if($UNIT_WEAPON=='Boltgun') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }
        
        if($UNIT_WEAPON=='Bolt Pistol') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Pistol 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }           
        
        if($UNIT_WEAPON=='Frag Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade D6';
            $WEAPON_STR=3;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }        
        
        if($UNIT_WEAPON=='Krak Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade 1';
            $WEAPON_STR=6;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1D3";          
        }

        if($UNIT_WEAPON=='Flamer') {
            $WEAPON_RANGE=8;
            $WEAPON_TYPE='Assualt 1D6';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";   
 
        if($MOVEMENT=='Advanced') {
            $U_BS=4;
        }             
            
        }    
        
        if($UNIT_WEAPON=='Grav-gun') {
            $WEAPON_RANGE=18;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=5;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";          
        }
        
        if($UNIT_WEAPON=='Meltagun') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Assualt 1';
            $WEAPON_STR=8;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1D6";   
 
        if($MOVEMENT=='Advanced') {
            $U_BS=4;
        }         
        
    } 
    
        if($UNIT_WEAPON=='Plasma Gun') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=7;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";           
        
    }

        if($UNIT_WEAPON=='Supercharged Plasma Gun') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=8;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="2";           
        
    }  
    
        if($UNIT_WEAPON=='Grav-cannon and grav-amp') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Heavy 4';
            $WEAPON_STR=5;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";  

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }            
            
        }     
  
        if($UNIT_WEAPON=='Heavy Bolter') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 3';
            $WEAPON_STR=5;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1";  
 
        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }            
            
        }
        
        if($UNIT_WEAPON=='Lascannon') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=9;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1D6";  
 
        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }            
            
        }   
        
        if($UNIT_WEAPON=='Frag Missile Launcher') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 1D6';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";   

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }             
            
        }  
        
        if($UNIT_WEAPON=='Krak Missile Launcher') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=8;
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="1D6"; 

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }             
            
        }   
        
        if($UNIT_WEAPON=='Multi-melta') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=8;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1D6";    

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }             
            
        } 

        if($UNIT_WEAPON=='Plasma Cannon') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1D3';
            $WEAPON_STR=7;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";    

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }             
            
        } 

        if($UNIT_WEAPON=='Supercharged Plasma Cannon') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1D3';
            $WEAPON_STR=8;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="2";    

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }             
            
        }          
    
        }    
        
if(strpos($UNIT,"Crusader Squad") !== false) {
        $U_BS=3;
        
        if($UNIT_WEAPON=='Astartes Shotgun') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Assault 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1"; 

        if($MOVEMENT=='Advanced') {
            $U_BS=4;
        }            
            
        }         
        
        if($UNIT_WEAPON=='Boltgun') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }
        
        if($UNIT_WEAPON=='Bolt Pistol') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Pistol 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }           
        
        if($UNIT_WEAPON=='Frag Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade D6';
            $WEAPON_STR=3;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }        
        
        if($UNIT_WEAPON=='Krak Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade 1';
            $WEAPON_STR=6;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1D3";          
        }

        if($UNIT_WEAPON=='Flamer') {
            $WEAPON_RANGE=8;
            $WEAPON_TYPE='Assualt 1D6';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";   
 
        if($MOVEMENT=='Advanced') {
            $U_BS=4;
        }             
            
        }    
        
        if($UNIT_WEAPON=='Grav-gun') {
            $WEAPON_RANGE=18;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=5;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";          
        }
        
        if($UNIT_WEAPON=='Meltagun') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Assualt 1';
            $WEAPON_STR=8;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1D6";   
 
        if($MOVEMENT=='Advanced') {
            $U_BS=4;
        }         
        
    } 
    
        if($UNIT_WEAPON=='Plasma Gun') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=7;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";           
        
    }

        if($UNIT_WEAPON=='Supercharged Plasma Gun') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=8;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="2";           
        
    }  
    
        if($UNIT_WEAPON=='Grav-cannon and grav-amp') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Heavy 4';
            $WEAPON_STR=5;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";  

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }            
            
        }     
  
        if($UNIT_WEAPON=='Heavy Bolter') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 3';
            $WEAPON_STR=5;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1";  
 
        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }            
            
        }
        
        if($UNIT_WEAPON=='Lascannon') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=9;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1D6";  
 
        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }            
            
        }   
        
        if($UNIT_WEAPON=='Frag Missile Launcher') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 1D6';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";   

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }             
            
        }  
        
        if($UNIT_WEAPON=='Krak Missile Launcher') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=8;
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="1D6"; 

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }             
            
        }   
        
        if($UNIT_WEAPON=='Multi-melta') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=8;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1D6";    

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }             
            
        } 

        if($UNIT_WEAPON=='Plasma Cannon') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1D3';
            $WEAPON_STR=7;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";    

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }             
            
        } 

        if($UNIT_WEAPON=='Supercharged Plasma Cannon') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1D3';
            $WEAPON_STR=8;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="2";    

        if($MOVEMENT=='Moved') {
            $U_BS=4;
        }             
            
        }          
    
        }          
    
        }        
        
    if($UNIT_WEAPON=='Flamer') {
        
    $combat_cal = new combat_cal();
    $combat_cal->d_six_roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE);        
            
        
    }    
    
    elseif($UNIT_WEAPON=='Plasma Exterminator' || $UNIT_WEAPON=='Supercharged Plasma Exterminator') {
        
    $combat_cal = new combat_cal();
    $combat_cal->two_d_three_roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE);        
              
        
    }
    
    elseif($UNIT_WEAPON!='Flamer') {
    
    $combat_cal = new combat_cal();
    $combat_cal->roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE);        
    
    }
    
    }
    
    function two_d_three_roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE) {
        
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
        
    echo "<table class='table'>
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
    $combat_cal->roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE);        
        
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

    echo "<table class='table'>
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
    
    
    function roll($sides, $number,$UNIT,$TARGET_UNIT,$UNIT_WEAPON,$RANGE_BONUS,$FACTION,$ENEMY_FACTION,$MODELS_TO_FIRE,$MOVEMENT,$WEAPON_STR,$WEAPON_DAMAGE,$WEAPON_AP,$U_BS,$WEAPON_TYPE,$WEAPON_RANGE) {
    
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
    
    if($WEAPON_TYPE=='Heavy 4') {
        $SHOW_ROLL_HITS=($number+1)*4;
        $number=$SHOW_ROLL_HITS-1;
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
        $TOTAL_HITS=$DIE_TWO+$DIE_THREE+$DIE_FOUR+$DIE_FIVE+$DIE_SIX;
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
    
if($ENEMY_FACTION || $FACTION =='Ultramarines') {
    
    if($TARGET_UNIT=='Captain in Gravis armour') {
        $T_MOVE=5;
        $T_WS=2;
        $T_BS=2;
        $T_STR=4;
        $T_TOUGHNESS=5;
        $T_WOUNDS=6;
        $T_ATTACKS=5;
        $T_LD=9;
        $T_SAVE=3; 
        $T_INVUL =4;        
    }
    
    if($TARGET_UNIT=='Primaris Lieutenants') {
        $T_MOVE=6;
        $T_WS=2;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=5;
        $T_ATTACKS=4;
        $T_LD=8;
        $T_SAVE=3; 
        $T_INVUL =0;        
    }    
    
    if($TARGET_UNIT=='Primaris Ancient') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=5;
        $T_ATTACKS=4;
        $T_LD=8;
        $T_SAVE=3; 
        $T_INVUL =0;        
    } 
    
    if($TARGET_UNIT=='Intercessor Squad') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=2;
        $T_ATTACKS=2;
        $T_LD=7;
        $T_SAVE=3; 
        $T_INVUL =0;        
    }  
    
    if($TARGET_UNIT=='Intercessor Sergeant') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=2;
        $T_ATTACKS=3;
        $T_LD=8;
        $T_SAVE=3; 
        $T_INVUL =0;        
    }   
    
    if($TARGET_UNIT=='Tactical Squad') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=3; 
        $T_INVUL =0;        
    } 

    if($TARGET_UNIT=='Tactical Marine Sergeant') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=2;
        $T_LD=8;
        $T_SAVE=3; 
        $T_INVUL =0;        
    } 

    if($TARGET_UNIT=='Scout Squad') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=4; 
        $T_INVUL =0;        
    } 

    if($TARGET_UNIT=='Scout Sergeant') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=2;
        $T_LD=8;
        $T_SAVE=4; 
        $T_INVUL =0;        
    }     
    
}    
    
    if($ENEMY_FACTION || $FACTION =='Eldar') {
        
    if($TARGET_UNIT=='Eldrad Ulthran') {
        $T_WS=2;
        $T_BS=2;
        $T_STR=3;
        $T_TOUGHNESS=4;
        $T_WOUNDS=6;
        $T_ATTACKS=2;
        $T_LD=9;
        $T_SAVE=6; 
        $T_INVUL =3;
        
    } 
    
    if($TARGET_UNIT=='Warlock') {
        $T_WS=3;
        $T_BS=3;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=2;
        $T_ATTACKS=2;
        $T_LD=8;
        $T_SAVE=6; 
        $T_INVUL =4;
        
    }     
        
    if($TARGET_UNIT=='Guardian Defenders') {
        $T_WS=3;
        $T_BS=3;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=5; 
        $T_INVUL =0;
        
    }   
    
    if($TARGET_UNIT=='Rangers') {
        $T_WS=3;
        $T_BS=3;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=5; 
        $T_INVUL =0;
        
    }  
    
    if($TARGET_UNIT=='Dire Avengers') {
        $T_WS=3;
        $T_BS=3;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=8;
        $T_SAVE=4; 
        $T_INVUL =0;
        
    } 

    if($TARGET_UNIT=='Dire Avengers Exarch') {
        $T_WS=3;
        $T_BS=3;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=2;
        $T_ATTACKS=2;
        $T_LD=8;
        $T_SAVE=4; 
        $T_INVUL =0;
        
    }    
    
    if($TARGET_UNIT=='Dark Reapers') {
        $T_WS=3;
        $T_BS=3;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=8;
        $T_SAVE=3; 
        $T_INVUL =0;
        
    }    
    
    if($TARGET_UNIT=='Dark Reapers Exarch') {
        $T_WS=3;
        $T_BS=3;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=2;
        $T_ATTACKS=2;
        $T_LD=8;
        $T_SAVE=3; 
        $T_INVUL =0;
        
    }    
    
    }
        
    if($ENEMY_FACTION || $FACTION =='Deathguard') {
    
        
    if($TARGET_UNIT=='Lord of Contagion') {
        $T_WS=2;
        $T_BS=2;
        $T_STR=4;
        $T_TOUGHNESS=5;
        $T_WOUNDS=6;
        $T_ATTACKS=4;
        $T_LD=9;
        $T_SAVE=2; 
        
    }
    
    if($TARGET_UNIT=='Malignant Plaguecaster') {
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=5;
        $T_WOUNDS=4;
        $T_ATTACKS=3;
        $T_LD=8;
        $T_SAVE=3; 
        
    } 

    if($TARGET_UNIT=='Noxious Blightbringer') {
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=5;
        $T_WOUNDS=4;
        $T_ATTACKS=3;
        $T_LD=8;
        $T_SAVE=3; 
        
    }     
        
    if($TARGET_UNIT=='Plague Marines') {
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=5;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=3; 
        
    } 
    
    if($TARGET_UNIT=='Plague Champion') {
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=5;
        $T_WOUNDS=1;
        $T_ATTACKS=2;
        $T_LD=8;
        $T_SAVE=3; 
        
    }     
    
    if($TARGET_UNIT=='Pox walkers') {
        $T_WS=5;
        $T_BS=6;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=2;
        $T_LD=4;
        $T_SAVE=7; 
        
    }
    
    if($TARGET_UNIT=='Foetid Bloat-Drone') {
        $T_WS=4;
        $T_BS=4;
        $T_STR=6;
        $T_TOUGHNESS=7;
        $T_WOUNDS=10;
        $T_ATTACKS=3;
        $T_LD=49;
        $T_SAVE=3; 
        
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
    

    
    
    
    echo "<table class='table'>
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
    $combat_cal->damage_modifier($TOTAL_WOUNDS,$WEAPON_DAMAGE,$T_SAVE,$WEAPON_AP,$UNIT_WEAPON,$RANGE_BONUS); 
    
    

    } elseif(is_numeric ($WEAPON_DAMAGE)) {
    $SAVE_ROLLS=$TOTAL_WOUNDS-1;
    $combat_cal = new combat_cal();
    $combat_cal->save_rolls($T_SAVE,$SAVE_ROLLS,$WEAPON_AP,$UNIT_WEAPON);
    
    }
    
}

function damage_modifier ($TOTAL_WOUNDS,$WEAPON_DAMAGE,$T_SAVE,$WEAPON_AP,$UNIT_WEAPON,$RANGE_BONUS) {
    
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
        
    echo "<table class='table'>
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
        
    echo "<table class='table'>
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
        
    echo "<table class='table'>
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
        
    echo "<table class='table'>
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
    $combat_cal->save_rolls($T_SAVE,$SAVE_ROLLS,$WEAPON_AP,$UNIT_WEAPON);
    
}

function save_rolls($T_SAVE,$SAVE_ROLLS,$WEAPON_AP,$UNIT_WEAPON) {
    
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
    
    if($UNIT_WEAPON=='Sniper Rifle') {
    $MORTAL_WOUNDS=$DIE_SIX;
    }
    
    if(empty($MORTAL_WOUNDS)) {
        $MORTAL_WOUNDS=0;
    }

    echo "<table class='table'>
        <tr>
        <th colspan='9'>$SAVE_ROLL_DISPLAY Save(s) | AP $WEAPON_AP | $T_SAVE+ to Save</th>
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
        <th>Mortal</th>
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
        <th>$MORTAL_WOUNDS</th>    
	</tr>
	</table>";    
    
}

}

