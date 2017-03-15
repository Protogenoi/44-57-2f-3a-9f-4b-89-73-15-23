<!DOCTYPE html>
<html lang="en">
<title>ADL | Real Time Report</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="imagetoolbar" content="no" />
<script type="text/javascript" language="javascript" src="https://dev.adlcrm.com//js/jquery/jquery-3.0.0.min.js"></script>
<link rel="stylesheet" href="https://dev.adlcrm.com/styles/Connex.css" type="text/css" />
<link rel="stylesheet" href="https://dev.adlcrm.com/font-awesome/css/font-awesome.min.css">
<link rel="icon" type="../img/x-icon" href="/img/favicon.ico"  />
<style>
.status_piltrans {color: white; background: #551A8B; }

    .container{
        width: 95%;
    }
.backcolour {
    background-color:#05668d !important;
}
table {
    border: none !important;
}
.i_color_red {
  color: red;
}
.i_color_green {
  color: #00FF00;
}
.blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {  
  50% { opacity: 0; }
}
</style>
<script>
    function refresh_div() {
        jQuery.ajax({
            url:' ',
            type:'POST',
            success:function(results) {
                jQuery(".container").html(results);
            }
        });
    }

    t = setInterval(refresh_div,10000);
</script>
</head>
<body>
    <div class="container">
<?php
// example of how to use basic selector to retrieve HTML contents
include('../simple_html_dom.php');
 
// get DOM from URL or file
$html = file_get_html('http://10.26.114.7/wallboards/GridScore.php');



// find all div tags with id=gbar
foreach($html->find('div[class=container]') as $e)
    echo $e->innertext . '<br>';

foreach($html->find('div#container') as $e)
    echo $e->innertext . '<br>';
// extract text from HTML

?>
</div>
</body>
</html>