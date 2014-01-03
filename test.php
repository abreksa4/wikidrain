<?php
//Include wikidrain
include('src/wikidrain.class.php');
//Get a new instance of wikidrain
$wiki = new wikidrain();
//Search for 'API'
$results = $wiki->Search('API', 10);
//For each of the ten results, print the title and description
for ($i = 0; $i < 10; $i++) {
    print "Title: {$results[$i]['title']}, Description: {$results[$i]['description']}";
}
//Get the sections of the 'API' page
$results = $wiki->getSections('API');
//Dump the array
print_r($results);
//Print the entire page, except for 'See also', 'References', and 'External links'
foreach ($results as $section) {
    $text = $wiki->getText('API', "{$section['index']}");
    print $text;
}
