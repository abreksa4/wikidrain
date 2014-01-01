<?php
include_once('src\wikidrain.class.php');
$result = new wikidrain('en');
$result->setQuery('api');
//$result->setLim('20');
$result->queryClean();
$results = $result->searchWiki();
print $results;
$result->setTitle('API');
/*
$summary = $result->summaryWiki();
print $summary;
*/
$sections = $result->sectionsWiki();
print $sections;