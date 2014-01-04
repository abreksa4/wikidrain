<!DOCTYPE html>
<html>
<head>
    <title>Wikidrain example</title>
</head>
<body>
<form method="get" action="">
    Query: <input type="text" name="query" value=""/>
    <input type="submit" name="submit" value="Submit"/>
    <br/>
</form>
<?php
require_once('src/wikidrain.class.php');
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $wiki = new wikidrain();
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        switch ($action) {
            case('toc'):
                $results = $wiki->getSections($query);
                foreach ($results as $sec) {
                    print "<a href=\"example.php?action=text&query={$query}&index={$sec['index']}\">{$sec['title']}</a><br />";
                }
                break;
            case('text'):
                $index = $_GET['index'];
                $query = $_GET['query'];
                $results = $wiki->getText($query, $index);
                print "{$results}";
                break;
        }
    } else {
        $results = $wiki->Search($query, 10);
        foreach ($results as $page) {
            $title = str_replace(' ', '+', $page['title']);
            print "<a href=example.php?action=toc&query={$title}>{$page['title']}: {$page['description']}</a>";
            print "<br />";
        }
        $wiki = NULL;
    }
} else {
    exit;
}
?>
</body>
</html>

