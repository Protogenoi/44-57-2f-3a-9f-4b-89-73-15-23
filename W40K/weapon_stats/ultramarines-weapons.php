<?php

       if($UNIT_WEAPON=='Combi-flamer') {
           $UNIT_WEAPON='Flamer';
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
       
       if($UNIT_WEAPON=='Storm Bolter') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Rapid Fire 2';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";  
           
       }

        if($UNIT=='Captain in Gravis armour') {

        if($UNIT_WEAPON=='Boltstorm Gauntlet') {    
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Pistol 3';
            $WEAPON_STR=4;
            $WEAPON_AP=0;
            $WEAPON_DAMAGE="1";  
            
        }
        }
        
        if($UNIT=='Primaris Ancient') {
            
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
        
        if($UNIT=='Inceptor Squad' || $UNIT=='Inceptor Sergeant') {
            
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
          
                
            }
            if($UNIT_WEAPON=='Supercharged Plasma Exterminator') {
            $WEAPON_RANGE=18;
            $WEAPON_TYPE='Assualt 1D3';
            $WEAPON_STR=8;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="2";             
                
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
        
    }
    if($UNIT_WEAPON=='Master Crafted Stalker Bolt Rifle') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=4;
            $WEAPON_AP=2;
            $WEAPON_DAMAGE="2";  
      
        
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
        
    if($UNIT=='Intercessor Squad' || $UNIT=='Intercessor Sergeant') {
    
    if($UNIT_WEAPON=='Auto Bolt Rifle') {
        $WEAPON_STR=4;
        $WEAPON_AP=0;
        $WEAPON_DAMAGE=1;
        $WEAPON_TYPE='Assualt 2';
        $WEAPON_RANGE=24;   

        
    }
    if($UNIT_WEAPON=='Stalker Bolt Rifle') {
        $WEAPON_STR=4;
        $WEAPON_AP=2;
        $WEAPON_DAMAGE=1;
        $WEAPON_TYPE='Heavy 1';
        $WEAPON_RANGE=36;
       
        
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
    
    if($UNIT=='Hellblaster Squad' || $UNIT=='Hellblaster Sergeant') {

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
         
            
        }
        
        if($UNIT_WEAPON=='Supercharged Assualt Plasma Incinerator') {
            $WEAPON_RANGE=24;
            $WEAPON_TYPE='Assualt 2';
            $WEAPON_STR=7;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="2";           
            
        }   
        
        if($UNIT_WEAPON=='Heavy Plasma Incinerator') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=8;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1";  
         
            
        }
        
        if($UNIT_WEAPON=='Supercharged Heavy Plasma Incinerator') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1';
            $WEAPON_STR=9;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="2";          
            
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
    
    if($UNIT=='Scout Squad' || $UNIT=='Scout Sergeant') {
        
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
            
        }         
        
        if($UNIT_WEAPON=='Heavy Bolter') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 3';
            $WEAPON_STR=5;
            $WEAPON_AP=1;
            $WEAPON_DAMAGE="1";            
            
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
        
        if($UNIT_WEAPON=='Sniper Rifle') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1';
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
            
        }  

        if($UNIT_WEAPON=='Meltagun') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Assualt 1';
            $WEAPON_STR=8;
            $WEAPON_AP=4;
            $WEAPON_DAMAGE="1D6";          
        
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
        
    }
    
 if($UNIT=='Tactical Squad' || $UNIT=='Tactical Marine Sergeant') {
        
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

        if($UNIT_WEAPON=='Plasma Cannon') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1D3';
            $WEAPON_STR=7;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";                
            
        } 

        if($UNIT_WEAPON=='Supercharged Plasma Cannon') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1D3';
            $WEAPON_STR=8;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="2";             
            
        }          
    
        }    
        
if(strpos($UNIT,"Crusader Squad") !== false) {
        
        if($UNIT_WEAPON=='Astartes Shotgun') {
            $WEAPON_RANGE=12;
            $WEAPON_TYPE='Assault 1';
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

        if($UNIT_WEAPON=='Plasma Cannon') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1D3';
            $WEAPON_STR=7;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="1";               
            
        } 

        if($UNIT_WEAPON=='Supercharged Plasma Cannon') {
            $WEAPON_RANGE=36;
            $WEAPON_TYPE='Heavy 1D3';
            $WEAPON_STR=8;
            $WEAPON_AP=3;
            $WEAPON_DAMAGE="2";    
            
            
        }          
    
        }          

