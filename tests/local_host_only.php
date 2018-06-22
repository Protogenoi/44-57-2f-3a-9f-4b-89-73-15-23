<?php

function getRealIpAddr()
{
    if (!empty(filter_input(INPUT_SERVER,'HTTP_CLIENT_IP', FILTER_SANITIZE_SPECIAL_CHARS)))   
    {
      $ip=filter_input(INPUT_SERVER,'HTTP_CLIENT_IP', FILTER_SANITIZE_SPECIAL_CHARS);
    } 
    elseif (!empty(filter_input(INPUT_SERVER,'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_SPECIAL_CHARS)))
    {
      $ip=filter_input(INPUT_SERVER,'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    else
    { 
      $ip=filter_input(INPUT_SERVER,'REMOTE_ADDR', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    return $ip;
}

getRealIpAddr();
$TRACKED_IP= getRealIpAddr();


echo "Your IP addressis $TRACKED_IP";

if($TRACKED_IP != "127.0.0.1") {
    echo "NOT LOCAL HOST";
} else {
    echo "local host";
}
 

?>