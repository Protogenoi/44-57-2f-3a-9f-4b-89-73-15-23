<?php
$url = 'http://maps.googleapis.com/maps/api/geocode/xml?address=SA8+4NA&sensor=false';
$parsedXML = simplexml_load_file($url);
?>

<?php
if($parsedXML->status != "OK") {
echo "There has been a problem: " . $parsedXML->status;
}
?>

<?php
$myAddress = array();
foreach($parsedXML->result->address_component as $component) {
if(is_array($component->type)) $type = (string)$component->type[0];
else $type = (string)$component->type;

$myAddress[$type] = (string)$component->long_name;
}
print_r($myAddress);


?>
