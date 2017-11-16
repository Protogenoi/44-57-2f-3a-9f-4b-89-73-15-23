<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 * 
*/  

date_default_timezone_set('UTC');
$XMAS= date("F");
$HALLOWEEN= date("jS \of F");

if($XMAS=='December') {
    
$XMAS_ARRAY = array("santascoming.mp3", "ninnymuggins.mp3", "arnold_reindeer.mp3", "youstink.mp3", "sonofanut.mp3","workshop.mp3","ChristmasScat.mp3","Buzz-your-girl-friend-Woof.mp3","snakes_money.mp3","jack_snowballs.mp3");
$RAND_XMAS_ARRAY = array_rand($XMAS_ARRAY, 2);
    
?>
<script src="../js/jquery.snow.js"></script>
    <script>
    $(document).ready( function(){
        $.fn.snow({ minSize: 9, maxSize: 65, newOn: 1000, flakeColor: '#2D7A95' } );
    });
    </script>
    
    <?php } 
    if($HALLOWEEN=='31st of October') { 
        
$HALLOWEEN_ARRAY = array("jonny.mp3", "were.mp3", "scream.mp3","Halloween.mp3");
$DIE = mt_rand(1, 4);


                                    switch ($DIE):
                                        case "1":
                                            $RAND_HALLOWEEN_ARRAY = "jonny.mp3";
                                            break;
                                        case "2":
                                            $RAND_HALLOWEEN_ARRAY = "were.mp3";
                                            break;
                                        case "3":
                                            $RAND_HALLOWEEN_ARRAY = "scream.mp3";
                                            break; 
                                        case "4":
                                            $RAND_HALLOWEEN_ARRAY = "Halloween.mp3";
                                            break;                                        
                                        default:
                                            $RAND_HALLOWEEN_ARRAY = "scream.mp3";
                                    endswitch;

        ?>
    <script src="/resources/lib/bats/halloween-bats.js"></script>
	<script type="text/javascript">
		$.fn.halloweenBats({
	image: 'https://review.adlcrm.com/resources/lib/bats/bats.png', // Path to the image.
	zIndex: 10000, // The z-index you need.
	amount: 15, // Bat amount.
	width: 100, // Image width.
	height: 20, // Animation frame height.
	frames: 4, // Amount of animation frames.
	speed: 20, // Higher value = faster.
	flickering: 15 // Higher value = slower.
});
	</script>   
    <?php } ?>
