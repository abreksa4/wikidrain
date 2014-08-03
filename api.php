<?php
while (isset($_GET['action']) & isset($_GET['query']) & isset($_GET['useragent'])) {
    $action = $_GET['action'];
    $query = $_GET['query'];
    if (isset($_GET['numresults'])) {
        $numresults = $_GET['numresults'];
    } else {
        $numresults = 10;
    }
    $wikidrain = new wikidrain($_GET['useragent']);
    switch ($action) {
        case('search'):
            $results = $wikidrain->Search($query, $numresults);
            echo $results;
            break;
        case('related'):
            $results = $wikidrain->getRelated($query);
            echo $results;
            break;
    }
}