<?php
include('src/wikidrain.class.php');
include('src/xml_parse.class.php');
$wiki = new wikidrain();
$parse = new xml_parse();
$results = $wiki->Search('API', 10);
$results = $parse->parseSearch($results);
for ($i = 0; $i < 10; $i++) {
    print "Title: {$results[$i]['title']}, Description: {$results[$i]['description']}";
}

$results = $wiki->getSections('API');
$results = $parse->parseSections($results);
print_r($results);
$results = $wiki->getText('API', '0');
print $results;
?>
*/

