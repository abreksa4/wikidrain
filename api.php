<?php
include('includes/wikidrain.class.php');
while (isset($_GET['action']) & isset($_GET['query'])) {
    $action = $_GET['action'];
    $query = $_GET['query'];
    if (isset($_GET['numresults'])) {
        $numresults = $_GET['numresults'];
    } else {
        $numresults = 10;
    }
    switch ($action) {
        case('search'):
            $wikidrain = new wikidrain('wikidrain/1.0 (http://www.example.com/); (abreksa4@gmail.com)');
            $results = $wikidrain->Search($query, $numresults);
            return $results;
            break;
        case('sections'):
            $wikidrain = new wikidrain('wikidrain/1.0 (http://www.example.com/); (abreksa4@gmail.com)');
            $query = $wikidrain->prepTitle($query);
            $results = $wikidrain->getSections($query);
            return $results;
            break;
        case('text'):
            if (isset($_GET['section'])) {
                $section = $_GET['section'];
            } else {
                $section = 0;
            }
            $wikidrain = new wikidrain('wikidrain/1.0 (http://www.example.com/); (abreksa4@gmail.com)');
            $query = $wikidrain->prepTitle($query);
            $results = $wikidrain->getText($query, $section);
            return $results;
            break;
    }
}
