<?php
include('includes/wikidrain.class.php');
while (isset($_GET['action']) && isset($_GET['query']) && isset($_GET['useragent'])) {
    $action = $_GET['action'];
    $query = $_GET['query'];
    $useragent = $_GET['useragent'];
    if (isset($_GET['numresults'])) {
        $numresults = $_GET['numresults'];
    } else {
        $numresults = 10;
    }
    $wikidrain = new wikidrain($useragent);
    switch ($action) {
        case('search'):
            $results = $wikidrain->Search($query, $numresults);
            return $results;
            break;
        case('sections'):
            $results = $wikidrain->getSections($query);
            return $results;
            break;
        case('text'):
            if (isset($_GET['section'])) {
                $section = $_GET['section'];
            } else {
                $section = 0;
            }
            $results = $wikidrain->getText($query, $section);
            return $results;
            break;
        case('related'):
            $results = $wikidrain->getRelated($query);
            return $results;
            break;
    }
}
