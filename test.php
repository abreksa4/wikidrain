<?php
include('src/wikidrain.class.php');
$wiki = new wikidrain();
$results = $wiki->Search('API', 10);
print $results;
$results = $wiki->getSections('API');
print $results;
$results = $wiki->getText('API', '0');
print $results;
?>
