<?php
include('src/wikidrain.class.php');
include('src/xml_parse.class.php');
$wiki = new wikidrain();
$parser = new xml_parse();
$results = $wiki->Search('API', 10);
$results = $parser->parseSearch($results);
for ($i = 0; $i < 10; $i++) {
    print "Title: {$results[$i]['title']}, Description: {$results[$i]['description']}";
}
$results = $wiki->getSections('API');
$results = $parser->parseSections($results);
print_r($results);
foreach ($results as $section) {
    $text = $wiki->getText('API', "{$section['index']}");
    $text = $parser->parseText($text);
    print $text;
}
