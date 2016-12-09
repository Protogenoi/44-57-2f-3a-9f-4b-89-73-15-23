<?php

$data= preg_replace("/[^0-9,.]/", "",file_get_contents("http://81.145.57.124/CREDIT.php?VALUE=c7dab0f65edb34722887fcdea3d14d010c9e65f5")); 

$today=date("h:m:s Y-m-d");
$date=date("Y-m-d");
$warning=100;


$file="/BalanceCheck/BalanceSent.txt";

$current = file_get_contents($file);

if($current!=$date && $data>=$warning) {

file_put_contents($file, $date, FILE_APPEND | LOCK_EX);

mail("michael@thereviewbureau.com","The Review Bureau Dialler Balance GOOD ($data)","AUTOMATED MESSAGE - Current balance is $data at $today Regards, Server");

}

if($current==$date)

{
mail("michael@thereviewbureau.com","The Review Bureau Dialler Balance $data","Email already sent at $today");
}

if($current!=$date && $data<=$warning) {

file_put_contents($file, $date, FILE_APPEND | LOCK_EX);

mail("michael@thereviewbureau.com","The Review Bureau Dialler Balance LOW ($data)","AUTOMATED MESSAGE - Can our dialler be topped up. Current balance is $data at $today Regards, Server");
}



?>
