<?php

    if($TARGET_UNIT=='Kharn the Betrayer') {
        
        $T_MOVE=6;
        $T_WS=2;
        $T_BS=2;
        $T_STR=5;
        $T_TOUGHNESS=4;
        $T_WOUNDS=5;
        $T_ATTACKS=6;
        $T_LD=9;
        $T_SAVE=3; 
        $T_INVUL=4;         
        
    }     
    
    if($TARGET_UNIT=='Abaddon the Despoiler') {
        $T_MOVE=6;
        $T_WS=2;
        $T_BS=2;
        $T_STR=4;
        $T_TOUGHNESS=5;
        $T_WOUNDS=7;
        $T_ATTACKS=6;
        $T_LD=10;
        $T_SAVE=2; 
        $T_INVUL=4;
        
        $T_ABILITIES=array("Death to the false Emperor","The Warmaster","Dark Destiny","Lord of the Black Legion","Mark of Chaos Ascendant","Teleport Strike");
        
    } 

    if($TARGET_UNIT=='Daemon Prince') {
        $T_MOVE=8;
        $T_WS=2;
        $T_BS=2;
        $T_STR=7;
        $T_TOUGHNESS=6;
        $T_WOUNDS=8;
        $T_ATTACKS=4;
        $T_LD=10;
        $T_SAVE=3; 
        $T_INVUL=5;
        
    }   
    
    if($TARGET_UNIT=='Khorne Bezerkers') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=5;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=2;
        $T_LD=7;
        $T_SAVE=3; 
        $T_INVUL=0;
        
    }    
    
    if($TARGET_UNIT=='Bezerker Champion') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=5;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=3;
        $T_LD=8;
        $T_SAVE=3; 
        $T_INVUL=0;
        
    }    
    
    if($TARGET_UNIT=='Rubric Marines') {
        $T_MOVE=5;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=3; 
        $T_INVUL=5;
        
    }
    
    if($TARGET_UNIT=='Aspiring Sorcerer') {
        $T_MOVE=5;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=2;
        $T_LD=8;
        $T_SAVE=3; 
        $T_INVUL=5; 
        
    }    

    if($TARGET_UNIT=='Plague Marines') {
        $T_MOVE=5;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=5;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=3; 
        $T_INVUL=0; 
        
    }   
    
    if($TARGET_UNIT=='Plague Champion') {
        $T_MOVE=5;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=5;
        $T_WOUNDS=1;
        $T_ATTACKS=2;
        $T_LD=8;
        $T_SAVE=3; 
        $T_INVUL=0;  
        
    }    
    
    if($TARGET_UNIT=='Chaos Terminator') {
        $T_MOVE=5;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=2;
        $T_ATTACKS=2;
        $T_LD=8;
        $T_SAVE=2; 
        $T_INVUL=5;  
        
    }     

    if($TARGET_UNIT=='Terminator Champion') {
        $T_MOVE=5;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=2;
        $T_ATTACKS=3;
        $T_LD=9;
        $T_SAVE=2; 
        $T_INVUL=5;
        
    } 
    
    if($TARGET_UNIT=='Helbrute') {
        $T_MOVE=8;
        $T_WS=3;
        $T_BS=3;
        $T_STR=6;
        $T_TOUGHNESS=7;
        $T_WOUNDS=8;
        $T_ATTACKS=4;
        $T_LD=8;
        $T_SAVE=3; 
        $T_INVUL=0;
        
    } 
    
    if($TARGET_UNIT=='Havocs') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=3; 
        $T_INVUL=0;
        
    }   
    
    if($TARGET_UNIT=='Chaos Land Raider') {
        $T_MOVE=10;
        $T_WS=6;
        $T_BS=3;
        $T_STR=8;
        $T_TOUGHNESS=8;
        $T_WOUNDS=16;
        $T_ATTACKS=6;
        $T_LD=9;
        $T_SAVE=2; 
        $T_INVUL=0;
        
    }  
    
    if($TARGET_UNIT=='Chaos Predator') {
        $T_MOVE=12;
        $T_WS=6;
        $T_BS=3;
        $T_STR=6;
        $T_TOUGHNESS=7;
        $T_WOUNDS=11;
        $T_ATTACKS=3;
        $T_LD=8;
        $T_SAVE=3; 
        $T_INVUL=0;
        
    }     
    
    if($TARGET_UNIT=='Chaos Space Marines') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=3; 
        $T_INVUL=0;
        
    }  

    if($TARGET_UNIT=='Aspiring Champion') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=2;
        $T_LD=8;
        $T_SAVE=3; 
        $T_INVUL=0;
        
    }     

    if($TARGET_UNIT=='Chaos Cultists') {
        $T_MOVE=6;
        $T_WS=4;
        $T_BS=4;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=5;
        $T_SAVE=6; 
        $T_INVUL=0; 
        
    } 
    
    if($TARGET_UNIT=='Cultist Champion') {
        $T_MOVE=6;
        $T_WS=4;
        $T_BS=4;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=2;
        $T_LD=6;
        $T_SAVE=6; 
        $T_INVUL=0; 
        
    }     

    if($TARGET_UNIT=='Bloodletters') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=6; 
        $T_INVUL=5; 
        
    }
    
    if($TARGET_UNIT=='Bloodreaper') {
        $T_MOVE=6;
        $T_WS=3;
        $T_BS=3;
        $T_STR=4;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=6; 
        $T_INVUL=5; 
        
    }    
    
    if($TARGET_UNIT=='Pink Horrors') {
        $T_MOVE=6;
        $T_WS=4;
        $T_BS=4;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=6; 
        $T_INVUL=5;  
        
    }    

    if($TARGET_UNIT=='Blue Horrors') {
        $T_MOVE=6;
        $T_WS=4;
        $T_BS=0;
        $T_STR=2;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=6; 
        $T_INVUL=5; 
        
    }
    
    if($TARGET_UNIT=='Pair of Brimstone Horrors') {
        $T_MOVE=6;
        $T_WS=4;
        $T_BS=0;
        $T_STR=2;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=2;
        $T_LD=7;
        $T_SAVE=6; 
        $T_INVUL=5; 
        
    }    
    
    if($TARGET_UNIT=='Plaguebearers') {
        $T_MOVE=5;
        $T_WS=4;
        $T_BS=4;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=1;
        $T_LD=7;
        $T_SAVE=6; 
        $T_INVUL=5;  
        
    }  
    
    if($TARGET_UNIT=='Plagueridden') {
        $T_MOVE=5;
        $T_WS=4;
        $T_BS=4;
        $T_STR=4;
        $T_TOUGHNESS=4;
        $T_WOUNDS=1;
        $T_ATTACKS=2;
        $T_LD=7;
        $T_SAVE=6; 
        $T_INVUL=5;  
        
    }       

    if($TARGET_UNIT=='Daemonettes') {
        $T_MOVE=7;
        $T_WS=3;
        $T_BS=3;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=2;
        $T_LD=7;
        $T_SAVE=6; 
        $T_INVUL=5;  
        
    }  

    if($TARGET_UNIT=='Alluress') {
        $T_MOVE=7;
        $T_WS=3;
        $T_BS=3;
        $T_STR=3;
        $T_TOUGHNESS=3;
        $T_WOUNDS=1;
        $T_ATTACKS=3;
        $T_LD=7;
        $T_SAVE=6; 
        $T_INVUL=5; 
        
    } 

