<?php
include_once('src\wikidrain.class.php');
$result = new wikidrain('en');
$result->setQuery('api');
$result->_limResults = 10;
$result->cleanQuery();
$results = $result->searchWiki();
print $results;
$result->setTitle('API');
$sections = $result->sectionsWiki();
print $sections;
$summary = $result->sectionWiki(2);
print $summary;