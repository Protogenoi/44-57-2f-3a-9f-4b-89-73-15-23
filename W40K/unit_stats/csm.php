<?php

    if($UNIT=='Kharn the Betrayer') {
        
        $U_MOVE=6;
        $U_WS=2;
        $U_BS=2;
        $U_STR=5;
        $U_TOUGHNESS=4;
        $U_WOUNDS=5;
        $U_ATTACKS=6;
        $U_LD=9;
        $U_SAVE=3; 
        $U_INVUL=4;         
        
    }     
    
    if($UNIT=='Abaddon the Despoiler') {
        $U_MOVE=6;
        $U_WS=2;
        $U_BS=2;
        $U_STR=4;
        $U_TOUGHNESS=5;
        $U_WOUNDS=7;
        $U_ATTACKS=6;
        $U_LD=10;
        $U_SAVE=2; 
        $U_INVUL=4;
        
        $U_ABILITIES=array("Death to the false Emperor","The Warmaster","Dark Destiny","Lord of the Black Legion","Mark of Chaos Ascendant","Teleport Strike");
        
    } 

    if($UNIT=='Daemon Prince') {
        $U_MOVE=8;
        $U_WS=2;
        $U_BS=2;
        $U_STR=7;
        $U_TOUGHNESS=6;
        $U_WOUNDS=8;
        $U_ATTACKS=4;
        $U_LD=10;
        $U_SAVE=3; 
        $U_INVUL=5;
        
    }   
    
    if($UNIT=='Khorne Bezerkers') {
        $U_MOVE=6;
        $U_WS=3;
        $U_BS=3;
        $U_STR=5;
        $U_TOUGHNESS=4;
        $U_WOUNDS=1;
        $U_ATTACKS=2;
        $U_LD=7;
        $U_SAVE=3; 
        $U_INVUL=0;
        
    }    
    
    if($UNIT=='Bezerker Champion') {
        $U_MOVE=6;
        $U_WS=3;
        $U_BS=3;
        $U_STR=5;
        $U_TOUGHNESS=4;
        $U_WOUNDS=1;
        $U_ATTACKS=3;
        $U_LD=8;
        $U_SAVE=3; 
        $U_INVUL=0;
        
    }    
    
    if($UNIT=='Rubric Marines') {
        $U_MOVE=5;
        $U_WS=3;
        $U_BS=3;
        $U_STR=4;
        $U_TOUGHNESS=4;
        $U_WOUNDS=1;
        $U_ATTACKS=1;
        $U_LD=7;
        $U_SAVE=3; 
        $U_INVUL=5;
        
    }
    
    if($UNIT=='Aspiring Sorcerer') {
        $U_MOVE=5;
        $U_WS=3;
        $U_BS=3;
        $U_STR=4;
        $U_TOUGHNESS=4;
        $U_WOUNDS=1;
        $U_ATTACKS=2;
        $U_LD=8;
        $U_SAVE=3; 
        $U_INVUL=5; 
        
    }    

    if($UNIT=='Plague Marines') {
        $U_MOVE=5;
        $U_WS=3;
        $U_BS=3;
        $U_STR=4;
        $U_TOUGHNESS=5;
        $U_WOUNDS=1;
        $U_ATTACKS=1;
        $U_LD=7;
        $U_SAVE=3; 
        $U_INVUL=0; 
        
    }   
    
    if($UNIT=='Plague Champion') {
        $U_MOVE=5;
        $U_WS=3;
        $U_BS=3;
        $U_STR=4;
        $U_TOUGHNESS=5;
        $U_WOUNDS=1;
        $U_ATTACKS=2;
        $U_LD=8;
        $U_SAVE=3; 
        $U_INVUL=0;  
        
    }    
    
    if($UNIT=='Chaos Terminator') {
        $U_MOVE=5;
        $U_WS=3;
        $U_BS=3;
        $U_STR=4;
        $U_TOUGHNESS=4;
        $U_WOUNDS=2;
        $U_ATTACKS=2;
        $U_LD=8;
        $U_SAVE=2; 
        $U_INVUL=5;  
        
    }     

    if($UNIT=='Terminator Champion') {
        $U_MOVE=5;
        $U_WS=3;
        $U_BS=3;
        $U_STR=4;
        $U_TOUGHNESS=4;
        $U_WOUNDS=2;
        $U_ATTACKS=3;
        $U_LD=9;
        $U_SAVE=2; 
        $U_INVUL=5;
        
    } 
    
    if($UNIT=='Helbrute') {
        $U_MOVE=8;
        $U_WS=3;
        $U_BS=3;
        $U_STR=6;
        $U_TOUGHNESS=7;
        $U_WOUNDS=8;
        $U_ATTACKS=4;
        $U_LD=8;
        $U_SAVE=3; 
        $U_INVUL=0;
        
    } 
    
    if($UNIT=='Havocs') {
        $U_MOVE=6;
        $U_WS=3;
        $U_BS=3;
        $U_STR=4;
        $U_TOUGHNESS=4;
        $U_WOUNDS=1;
        $U_ATTACKS=1;
        $U_LD=7;
        $U_SAVE=3; 
        $U_INVUL=0;
        
    }   
    
    if($UNIT=='Chaos Land Raider') {
        $U_MOVE=10;
        $U_WS=6;
        $U_BS=3;
        $U_STR=8;
        $U_TOUGHNESS=8;
        $U_WOUNDS=16;
        $U_ATTACKS=6;
        $U_LD=9;
        $U_SAVE=2; 
        $U_INVUL=0;
        
    }  
    
    if($UNIT=='Chaos Predator') {
        $U_MOVE=12;
        $U_WS=6;
        $U_BS=3;
        $U_STR=6;
        $U_TOUGHNESS=7;
        $U_WOUNDS=11;
        $U_ATTACKS=3;
        $U_LD=8;
        $U_SAVE=3; 
        $U_INVUL=0;
        
    }     
    
    if($UNIT=='Chaos Space Marines') {
        $U_MOVE=6;
        $U_WS=3;
        $U_BS=3;
        $U_STR=4;
        $U_TOUGHNESS=4;
        $U_WOUNDS=1;
        $U_ATTACKS=1;
        $U_LD=7;
        $U_SAVE=3; 
        $U_INVUL=0;
        
    }  

    if($UNIT=='Aspiring Champion') {
        $U_MOVE=6;
        $U_WS=3;
        $U_BS=3;
        $U_STR=4;
        $U_TOUGHNESS=4;
        $U_WOUNDS=1;
        $U_ATTACKS=2;
        $U_LD=8;
        $U_SAVE=3; 
        $U_INVUL=0;
        
    }     

    if($UNIT=='Chaos Cultists') {
        $U_MOVE=6;
        $U_WS=4;
        $U_BS=4;
        $U_STR=3;
        $U_TOUGHNESS=3;
        $U_WOUNDS=1;
        $U_ATTACKS=1;
        $U_LD=5;
        $U_SAVE=6; 
        $U_INVUL=0; 
        
    } 
    
    if($UNIT=='Cultist Champion') {
        $U_MOVE=6;
        $U_WS=4;
        $U_BS=4;
        $U_STR=3;
        $U_TOUGHNESS=3;
        $U_WOUNDS=1;
        $U_ATTACKS=2;
        $U_LD=6;
        $U_SAVE=6; 
        $U_INVUL=0; 
        
    }     

    if($UNIT=='Bloodletters') {
        $U_MOVE=6;
        $U_WS=3;
        $U_BS=3;
        $U_STR=4;
        $U_TOUGHNESS=3;
        $U_WOUNDS=1;
        $U_ATTACKS=1;
        $U_LD=7;
        $U_SAVE=6; 
        $U_INVUL=5; 
        
    }
    
    if($UNIT=='Bloodreaper') {
        $U_MOVE=6;
        $U_WS=3;
        $U_BS=3;
        $U_STR=4;
        $U_TOUGHNESS=3;
        $U_WOUNDS=1;
        $U_ATTACKS=1;
        $U_LD=7;
        $U_SAVE=6; 
        $U_INVUL=5; 
        
    }    
    
    if($UNIT=='Pink Horrors') {
        $U_MOVE=6;
        $U_WS=4;
        $U_BS=4;
        $U_STR=3;
        $U_TOUGHNESS=3;
        $U_WOUNDS=1;
        $U_ATTACKS=1;
        $U_LD=7;
        $U_SAVE=6; 
        $U_INVUL=5;  
        
    }    

    if($UNIT=='Blue Horrors') {
        $U_MOVE=6;
        $U_WS=4;
        $U_BS=0;
        $U_STR=2;
        $U_TOUGHNESS=3;
        $U_WOUNDS=1;
        $U_ATTACKS=1;
        $U_LD=7;
        $U_SAVE=6; 
        $U_INVUL=5; 
        
    }
    
    if($UNIT=='Pair of Brimstone Horrors') {
        $U_MOVE=6;
        $U_WS=4;
        $U_BS=0;
        $U_STR=2;
        $U_TOUGHNESS=3;
        $U_WOUNDS=1;
        $U_ATTACKS=2;
        $U_LD=7;
        $U_SAVE=6; 
        $U_INVUL=5; 
        
    }    
    
    if($UNIT=='Plaguebearers') {
        $U_MOVE=5;
        $U_WS=4;
        $U_BS=4;
        $U_STR=4;
        $U_TOUGHNESS=4;
        $U_WOUNDS=1;
        $U_ATTACKS=1;
        $U_LD=7;
        $U_SAVE=6; 
        $U_INVUL=5;  
        
    }  
    
    if($UNIT=='Plagueridden') {
        $U_MOVE=5;
        $U_WS=4;
        $U_BS=4;
        $U_STR=4;
        $U_TOUGHNESS=4;
        $U_WOUNDS=1;
        $U_ATTACKS=2;
        $U_LD=7;
        $U_SAVE=6; 
        $U_INVUL=5;  
        
    }       

    if($UNIT=='Daemonettes') {
        $U_MOVE=7;
        $U_WS=3;
        $U_BS=3;
        $U_STR=3;
        $U_TOUGHNESS=3;
        $U_WOUNDS=1;
        $U_ATTACKS=2;
        $U_LD=7;
        $U_SAVE=6; 
        $U_INVUL=5;  
        
    }  

    if($UNIT=='Alluress') {
        $U_MOVE=7;
        $U_WS=3;
        $U_BS=3;
        $U_STR=3;
        $U_TOUGHNESS=3;
        $U_WOUNDS=1;
        $U_ATTACKS=3;
        $U_LD=7;
        $U_SAVE=6; 
        $U_INVUL=5; 
        
    } 

