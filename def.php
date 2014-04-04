<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/14
 * Time: 1:38 PM
 */

include('includes/wikidrain.class.php');

$wiki = new wikidrain('ok');

if (isset($_GET['terms'])) {
    $terms = $_GET['terms'];
    $terms = htmlspecialchars_decode($terms);
    $array = explode(',', $terms);
    foreach ($array as $term) {
        $term = trim($term);
        $results = $wiki->Search($term, 3);
        print $term;
        foreach ($results as $res) {
            print $res['title'] . ": " . $res['description'];
            print '<p></p>';
        }
        print "==========";
    }
}