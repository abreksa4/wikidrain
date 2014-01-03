<?php
include('src/wikidrain.class.php');
$wikidrain = new wikidrain();
$results = $wikidrain->Search('API', 10);
print $results;
$results = $wikidrain->Sections('API');
print $results;
$results = $wikidrain->Text('API', '0');
print $results;
