<?php

       if($UNIT_WEAPON=='Combi-flamer') {
           $UNIT_WEAPON='Flamer';
       }
       if($UNIT_WEAPON=='Combi-bolter') {
           $UNIT_WEAPON='Boltgun';
       }       
       if($UNIT_WEAPON=='Combi-melta') {
           $UNIT_WEAPON='Meltagun';
       }
       if($UNIT_WEAPON=='Combi-plasma') {
           $UNIT_WEAPON='Plasma Gun';
       }
       if($UNIT_WEAPON=='Supercharged Combi-plasma') {
           $UNIT_WEAPON='Supercharged Plasma Gun';
       }

        if($UNIT_WEAPON=='Kharns Plasma Pistol') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Pistol 1';
            $WEAPON_STR=8;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="2";           
        
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
        
        if($UNIT_WEAPON=='Gorechild') {
            $WEAPON_RANGE="Melee";
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="+1";
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1D3";
            
            $WEAPON_ABILITY="Allways rolls to hit on a 2 regardless of any modifiers";
        }     
        
        if($UNIT_WEAPON=='Talon of Horus') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Rapid Fire 2';
            $WEAPON_STR=4;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1D3";           
        
    } 
    
        if($UNIT_WEAPON=='Talon of Horus (Melee)') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="x2";
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1D3";           
        
    }     

    if($UNIT_WEAPON=='Drachnyen') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="+1";
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1D3";          
            
        $WEAPON_ABILITY="Roll 1D6 each time Abaddon fights. On a 1 he suffers a mortal wound and cannot use this weapon again this phase. Only a 2+ he makes that many extra attacks with this weapon";    
        
    }
    
        if($UNIT_WEAPON=='Warp Bolter') {
            $WEAPON_RANGE='24';
            $WEAPON_TYPE='Assualt 2';
            $WEAPON_STR="4";
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="2";           
        
    }    
    
        if($UNIT_WEAPON=='Hellforged Sword') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="User";
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="3";           
        
    }    
    
        if($UNIT_WEAPON=='Daemonic Axe') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="+1";
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="3";  
            
        $WEAPON_ABILITY="When attacking subtract 1 from hit rolls.";      
        
    }  
    
        if($UNIT_WEAPON=='Malefic Talons') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="User";
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="2"; 
            
        $WEAPON_ABILITY="Each time this model fights it can make 1 additional attack with this weapon. A model armed with 2 Malefic Talons can make an additional 3 attacks with them.";    
        
    } 

        if($UNIT_WEAPON=='Bolt Pistol') {
            $WEAPON_RANGE='12';
            $WEAPON_TYPE='Pistol 1';
            $WEAPON_STR="4";
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";           
        
    }
    
        if($UNIT_WEAPON=='Plasma Pistol') {
            $WEAPON_RANGE='12';
            $WEAPON_TYPE='Pistol 1';
            $WEAPON_STR="7";
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";           
        
    } 
    
        if($UNIT_WEAPON=='Supercharged Plasma Pistol') {
            $WEAPON_RANGE='12';
            $WEAPON_TYPE='Pistol 1';
            $WEAPON_STR="8";
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="2";           
        
    }    
    
        if($UNIT_WEAPON=='Chain Sword') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="User";
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";  
            
        $WEAPON_ABILITY="Each time the bearer fights it can make 1 additional attack with this weapon";    
        
    }   
    
        if($UNIT_WEAPON=='Chainaxe') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="+1";
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1";  
                    
    }   
    
        if($UNIT_WEAPON=='Flamer') {
            $WEAPON_RANGE=8;
            $WEAPON_TYPE='Assualt 1D6';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";              
            
        }   
        
        if($UNIT_WEAPON=='Boltgun') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";          
        }

        if($UNIT_WEAPON=='Meltagun') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Assualt 1';
            $WEAPON_STR=8;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1D6";          
        
    } 
    
        if($UNIT_WEAPON=='Plasma Gun') {
            $WEAPON_RANGE='24';
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR="7";
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";           
        
    } 
    
        if($UNIT_WEAPON=='Supercharged Plasma Gun') {
            $WEAPON_RANGE='24';
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR="8";
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="2";           
        
    }    

        if($UNIT_WEAPON=='Lighting Claw') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="User";
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="1";  
            
        $WEAPON_ABILITY="you can reroll failed wound rolls with this weapon. If a model is armed with 2 claws it can make 1 additional attack with them.";    
        
    }  

        if($UNIT_WEAPON=='Power Axe') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="+1";
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="1";  
                    
    }   
    
        if($UNIT_WEAPON=='Power Fist') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="x2";
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1D3";  
            
       $WEAPON_ABILITY="When attacking with this weapon subtract 1 from the hit roll.";     
                    
    }     
    
        if($UNIT_WEAPON=='Power Maul') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="2";
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1";  
                                
    }   
    
        if($UNIT_WEAPON=='Power Sword') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="User";
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";  
                                
    } 
     
        if($UNIT_WEAPON=='Inferno Bolt Pistol') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Pistol 1';
            $WEAPON_STR=4;
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="1";          
        }  
        
        if($UNIT_WEAPON=='Warp Flame Pistol') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Pistol 1D6';
            $WEAPON_STR=3;
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="1";
            
        }  

        if($UNIT_WEAPON=='Force Stave') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR=+2;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1D3";          
        }  
        
        if($UNIT_WEAPON=='Inferno Boltgun') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Rapid Fire 1';
            $WEAPON_STR=4;
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="1";          
        } 
        
        if($UNIT_WEAPON=='Warpflamer') {
            $WEAPON_RANGE=8;
            $WEAPON_TYPE='Assualt 1D6';
            $WEAPON_STR=4;
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="1";
            
        } 

        if($UNIT_WEAPON=='Soulreaper Cannon') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Heavy 4';
            $WEAPON_STR=5;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";          
        }  
        
        if($UNIT_WEAPON=='Blight Launcher') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Assualt 2';
            $WEAPON_STR=6;
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="1D3";          
        }
        
        if($UNIT_WEAPON=='Plague Knife') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR='User';
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";  
         
        $WEAPON_ABILITY="You can reroll wound rolls of 1 for this weapon.";    
            
        }         

        if($UNIT_WEAPON=='Plague Sword') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR='User';
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1"; 
            
            //Re-roll 2's misprint in book (says 1 in book)?
        $WEAPON_ABILITY="You can reroll wound rolls of 2 for this weapon.";   
            
        } 
        
        if($UNIT_WEAPON=='Bubotic Axe') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR='+1';
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="1";  
         
        $WEAPON_ABILITY="This weapon automaticaly hits its target.";    
            
        }     
        
        if($UNIT_WEAPON=='Flail of Corruption') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR='+2';
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="2";  
         
        $WEAPON_ABILITY="Make D3 hits each time you attack with this weapon instead of only 1. Excess damage is not lost from this weapon, instead keep allocating damage to another model in the target unit either all the damage has been allocated or the target destroyed.";    
            
        }   
        
         if($UNIT_WEAPON=='Blight Grenade') {
            $WEAPON_RANGE=6;
            $WEAPON_TYPE='Grenade D6';
            $WEAPON_STR=3;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";  
            
        $WEAPON_ABILITY="You can reroll wound rolls of 1 for this weapon.";     
            
        }    
        
        if($UNIT_WEAPON=='Plague Belcher') {
            $WEAPON_RANGE=9;
            $WEAPON_TYPE='Assualt 1D6';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";    
            
        $WEAPON_ABILITY="This weapon automaticaly hits its target.";     
            
        }   
        
         if($UNIT_WEAPON=='Great Plague Cleaver') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR='x2';
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1D6";  
         
        $WEAPON_ABILITY="When attacking with this weapon subtract 1 from the hit roll.";    
            
        }     
        
        if($UNIT_WEAPON=='Plague Spewer') {
            $WEAPON_RANGE=9;
            $WEAPON_TYPE='Heavy 1D6';
            $WEAPON_STR=5;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1";    
            
        $WEAPON_ABILITY="This weapon automaticaly hits its target.";     
            
        }         
        
         if($UNIT_WEAPON=='Mace of Contagion') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR='+2';
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="3";  
         
        $WEAPON_ABILITY="When attacking with this weapon subtract 1 from the hit roll.";    
            
        }   
        
        if($UNIT_WEAPON=='Heavy Flamer') {
            $WEAPON_RANGE=8;
            $WEAPON_TYPE='Heavy 1D6';
            $WEAPON_STR=5;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1";    
            
        $WEAPON_ABILITY="This weapon automaticaly hits its target.";     
            
        }       
        
        if($UNIT_WEAPON=='Reaper Autocannon') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 4';
            $WEAPON_STR=7;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1";      
            
        }        
        
         if($UNIT_WEAPON=='Chain Fist') {
            $WEAPON_RANGE='Melee';
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="x2";
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="2";  
            
       $WEAPON_ABILITY="When attacking with this weapon subtract 1 from the hit roll.";     
                    
    } 
    
        if($UNIT_WEAPON=='Twin Heavy Bolter') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 6';
            $WEAPON_STR=5;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1";      
            
        }
        
        if($UNIT_WEAPON=='Twin Lascannon') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 2';
            $WEAPON_STR=9;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1D6";      
            
        }   
        
        if($UNIT_WEAPON=='Helbrute Plasma Cannon') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1D3';
            $WEAPON_STR=8;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="2";   
            
        $WEAPON_ABILITY="For each hit roll of 1, the Helbrute suffers a mortal wound after all of this weapons shots have been resolved.";   
            
        } 

        if($UNIT_WEAPON=='Frag Missile Launcher') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 1D6';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";   
                        
        }   
        
        if($UNIT_WEAPON=='Krak Missile Launcher') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=8;
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="1D6";   
                        
        }   
        
        if($UNIT_WEAPON=='Multi-melta') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=8;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1D6";                
            
        }         
        
        if($UNIT_WEAPON=='Helbrute Fist') {
            $WEAPON_RANGE="Melee";
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="x2";
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="3";                
            
        }    
        
        if($UNIT_WEAPON=='Helbrute Hammer') {
            $WEAPON_RANGE="Melee";
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="x2";
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1D6";  
            
        $WEAPON_ABILITY="When attacking with this weapon subtract 1 from the hit roll.";     
    
            
        }      
        
        if($UNIT_WEAPON=='Power Scourge') {
            $WEAPON_RANGE="Melee";
            $WEAPON_TYPE='Melee';
            $WEAPON_STR="+2";
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="2";  
            
        $WEAPON_ABILITY="Each time the bearer fights it can make 3 additional attacks with this weapon.";     
    
            
        }    
        
        if($UNIT_WEAPON=='Autocannon') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 2';
            $WEAPON_STR=7;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="2";      
            
        }    
        
        if($UNIT_WEAPON=='Heavy Bolter') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 3';
            $WEAPON_STR=5;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1";      
            
        }   
        
        if($UNIT_WEAPON=='Lascannon') {
            $WEAPON_RANGE=48;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=9;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1D6";      
            
        }        