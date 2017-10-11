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
        
        $T_ABILITIES=array("Death to the False Emperor","Blood for the Blood God","The Betrayer","Kill! Maim! Burn!","Sigil of Corruption");
        $T_FACTION_KW=array("Chaos","Khorne","Heretic Astartes","World Eaters");
        $T_KEYWORDS=array("Character","Infantry","Chaos Lord","Kharn the Betrayer");        
        
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
        
        $T_ABILITIES=array("Death to the False Emperor","The Warmaster","Dark Destiny","Lord of the Black Legion","Mark of Chaos Ascendant","Teleport Strike");
        $T_FACTION_KW=array("Chaos","Khorne","Nurgle","Slaanesh","Tzeentch","Heretic Astartes","Black Legion");
        $T_KEYWORDS=array("Character","Infantry","Chaos Lord","Terminator","Abaddon the Despoiler");
        
    } 

    if($TARGET_UNIT=='Khorne Daemon Prince') {
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
        
        $T_ABILITIES=array("Death to the False Emperor","Prince of Chaos","Daemonic","Might of Magic");
        $T_FACTION_KW=array("Chaos","Khorne","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Character","Monster","Daemon","Daemon Prince");        
        
    }
  
    if($TARGET_UNIT=='Nurgle Daemon Prince') {
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
        
        $T_ABILITIES=array("Death to the False Emperor","Prince of Chaos","Daemonic");
        $T_FACTION_KW=array("Chaos","Nurgle","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Character","Monster","Daemon","Daemon Prince","Psyker");        
        
    } 

    if($TARGET_UNIT=='Slaanesh Daemon Prince') {
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
        
        $T_ABILITIES=array("Death to the False Emperor","Prince of Chaos","Daemonic");
        $T_FACTION_KW=array("Chaos","Slaanesh","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Character","Monster","Daemon","Daemon Prince","Psyker");        
        
    } 

    if($TARGET_UNIT=='Tzeentch Daemon Prince') {
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
        
        $T_ABILITIES=array("Death to the False Emperor","Prince of Chaos","Daemonic");
        $T_FACTION_KW=array("Chaos","Tzeentch","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Character","Monster","Daemon","Daemon Prince","Psyker");        
        
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
        
        $T_ABILITIES=array("Death to the False Emperor","Blood for the Blood God");
        $T_FACTION_KW=array("Chaos","Khorne","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Khorne Bezerkers");         
        
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
        
        $T_ABILITIES=array("Death to the False Emperor","Blood for the Blood God");
        $T_FACTION_KW=array("Chaos","Khorne","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Khorne Bezerkers");          
        
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
        
        $T_ABILITIES=array("Death to the False Emperor","Favoured of Tzeentch","All is Dust");
        $T_FACTION_KW=array("Chaos","Tzeentch","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Psyker","Rubric Marines");         
        
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
        
        $T_ABILITIES=array("Death to the False Emperor","Favoured of Tzeentch","All is Dust");
        $T_FACTION_KW=array("Chaos","Tzeentch","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Psyker","Rubric Marines");          
        
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
        
        $T_ABILITIES=array("Death to the False Emperor","Disgustingly Resilient","Vectors of Death and Disease","Plague Weapon");
        $T_FACTION_KW=array("Chaos","Nurgle","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Plague Marines");          
        
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
        
        $T_ABILITIES=array("Death to the False Emperor","Disgustingly Resilient","Vectors of Death and Disease","Plague Weapon");
        $T_FACTION_KW=array("Chaos","Nurgle","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Plague Marines");           
        
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
        
        $T_ABILITIES=array("Death to the False Emperor","Teleport Strike","Terminator Armour");
        $T_FACTION_KW=array("Chaos","Mark of Chaos","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Terminators","Chaos Terminator");         
        
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
        
        $T_ABILITIES=array("Death to the False Emperor","Teleport Strike","Terminator Armour");
        $T_FACTION_KW=array("Chaos","Mark of Chaos","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Terminators","Chaos Terminator");         
        
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
        
        $T_ABILITIES=array("Crazed","Explodes","Battering Onslaught");
        $T_FACTION_KW=array("Chaos","Mark of Chaos","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Vehicle","Helbrute");         
        
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
        
        $T_ABILITIES=array("Death to the False Emperor");
        $T_FACTION_KW=array("Chaos","Mark of Chaos","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Havocs");           
        
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
        
        $T_ABILITIES=array("Smoke Launchers","Explodes","Daemonic Machine Spirit");
        $T_FACTION_KW=array("Chaos","Mark of Chaos","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Vehicle","Transport","Chaos Land Raider");         
        
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
        
        $T_ABILITIES=array("Smoke Launchers","Explodes");
        $T_FACTION_KW=array("Chaos","Mark of Chaos","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Vehicle","Chaos Predator");          
        
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
        
        $T_ABILITIES=array("Death to the False Emperor");
        $T_FACTION_KW=array("Chaos","Mark of Chaos","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Chaos Space Marines");             
        
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
        
        $T_ABILITIES=array("Death to the False Emperor");
        $T_FACTION_KW=array("Chaos","Mark of Chaos","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Chaos Space Marines");            
        
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
        
        $T_ABILITIES=array("None");
        $T_FACTION_KW=array("Chaos","Mark of Chaos","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Chaos Cultists");            
        
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
        
        $T_ABILITIES=array("None");
        $T_FACTION_KW=array("Chaos","Mark of Chaos","Heretic Astartes","LEGION");
        $T_KEYWORDS=array("Infantry","Chaos Cultists");         
        
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
        
        $T_ABILITIES=array("Daemonic Ritual","Murderous Tide","Daemonic","Daemonic Icon","Unstoppable Ferocity","Instrument of Chaos");
        $T_FACTION_KW=array("Chaos","Khorne");
        $T_KEYWORDS=array("Infantry","Daemon","Bloodletters");         
        
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
        
        $T_ABILITIES=array("Daemonic Ritual","Murderous Tide","Daemonic","Daemonic Icon","Unstoppable Ferocity","Instrument of Chaos");
        $T_FACTION_KW=array("Chaos","Khorne");
        $T_KEYWORDS=array("Infantry","Daemon","Bloodletters");          
        
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
        
        $T_ABILITIES=array("Daemonic Ritual","Made Magic Manifest","Daemonic","Split","Ephemeral Form","Daemonic Icon","Iridescent Horror","Instrument of Chaos");
        $T_FACTION_KW=array("Chaos","Tzeentch");
        $T_KEYWORDS=array("Infantry","Pysker","Daemon","Horrors");          
        
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
        
        $T_ABILITIES=array("Daemonic Ritual","Made Magic Manifest","Daemonic","Split","Ephemeral Form","Daemonic Icon","Iridescent Horror","Instrument of Chaos");
        $T_FACTION_KW=array("Chaos","Tzeentch");
        $T_KEYWORDS=array("Infantry","Pysker","Daemon","Horrors");          
        
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
        
        $T_ABILITIES=array("Daemonic Ritual","Made Magic Manifest","Daemonic","Split","Ephemeral Form","Daemonic Icon","Iridescent Horror","Instrument of Chaos");
        $T_FACTION_KW=array("Chaos","Tzeentch");
        $T_KEYWORDS=array("Infantry","Pysker","Daemon","Horrors");          
        
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
        
        $T_ABILITIES=array("Daemonic Ritual","Instrument of Chaos","Daemonic","Cloud of Flies","Disgustingly Resilient","Daemonic Icon");
        $T_FACTION_KW=array("Chaos","Nurgle");
        $T_KEYWORDS=array("Infantry","Daemon","Plaguebearers");          
        
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
        
        $T_ABILITIES=array("Daemonic Ritual","Instrument of Chaos","Daemonic","Cloud of Flies","Disgustingly Resilient","Daemonic Icon");
        $T_FACTION_KW=array("Chaos","Nurgle");
        $T_KEYWORDS=array("Infantry","Daemon","Plaguebearers");         
        
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
        
        $T_ABILITIES=array("Daemonic Ritual","Instrument of Chaos","Daemonic","Quicksilver Swiftness","Graceful Killers","Daemonic Icon");
        $T_FACTION_KW=array("Chaos","Slaanesh");
        $T_KEYWORDS=array("Infantry","Daemon","Daemonettes");         
        
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
        
        $T_ABILITIES=array("Daemonic Ritual","Instrument of Chaos","Daemonic","Quicksilver Swiftness","Graceful Killers","Daemonic Icon");
        $T_FACTION_KW=array("Chaos","Slaanesh");
        $T_KEYWORDS=array("Infantry","Daemon","Daemonettes");         
        
    } 

