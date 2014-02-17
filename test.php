<?php
//Include wikidrain
include('includes/wikidrain.class.php');
//Get a new instance of wikidrain
$wiki = new wikidrain('wikidrain/1.0 (http://www.example.com/)');
//Search for 'API'
$results = $wiki->Search('API', 10);
//For each of the results, print the title and description
foreach ($results as $res) {
    print "Title: {$res['title']}, Description: {$res['description']}";
}
//Get the sections of the 'API' page
$results = $wiki->getSections('API');
//Dump the array
print_r($results);
//Print the entire page, except for 'See also', 'References', and 'External links'
foreach ($results as $section) {
    $text = $wiki->getText('API', "{$section['index']}");
    print $text;
    print "\n";
}
//Print each of the 'See also' titles...
$results = $wiki->getRelated('API');
foreach ($results as $rec) {
    print "Recommendation: {$rec};";
}

