<?php

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
