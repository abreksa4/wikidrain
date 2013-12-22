<?php
include_once('src\wikidrain.class.php');
$result = new wikidrain('en');
$result->setQuery('api');
$result->queryClean();
$result = $result->searchWiki();
print $result;



