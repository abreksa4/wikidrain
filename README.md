wikidrain
===================================================================================

A PHP wrapper for the WikiMedia API centralized around querying Wikipedia articles.

There are many php classes, indeed complete frameworks, dedicated to the WikiMedia
API. But none of them are easy to implement, are accessible to those just learning
PHP, or focus on simply querying data from Wikipedia.  The goal of the wikidrain 
project is to develop a production-quality PHP library dedicated to easy, simple, 
and efficient querying of Wikipedia articles.


Usage:
===================================================================================

wikidrain is very simple to use, just make a new instance of wikidrain:

    <?php
    $wiki = new wikidrain();
    ?>

To search wikipedia for articles, use the Search method:
This returns a multidimensional array...

    <?php
    $wiki = new wikidrain();
    $result = $wiki->Search('API');
    ?>

To get the sections of a wikipedia page, use the getSections method:
This also returns a multidimensional array...

    <?php
    $wiki = new wikidrain();
    $result = $wiki->getSections('API');
    ?>

NOTE: Wikidrain does not include any error checking/verification that the article
      exists, so be sure to only request the sections/text of articles that were
      returned by the Search($query) method...

To get the text of a section from a wikipedia page, use the getText
method.
This returns text...

    <?php
    $wiki = new wikidrain();
    $result = $wiki->getText('API', '0');
    ?>

NOTE: Again, wikidrain does not include any error checking/verification to determine
      if an article or section exists, so make sure to only request data from pages/
      sections returned by the Search($query) and getSections($title) methods...

To get the list of articles listed in the 'See also' section, use the getRelated
method
This returns an array...

    <?php
    $wiki = new wikidrain();
    $wiki->getRelated('API');
    ?>

To prep titles for use, use the prepTitle method.
This returns a string...

    <?php
    $wiki = new wikidrain;
    $title = $wiki->prepTitle('Plug-in (computing)');
    ?>

TODO:
===================================================================================

Currently, the objectives are as follows:

1. Anything to put less strain on the wikipedia servers

2. A method to return the wikipedia donation banner

3. Error checking

4. Any improvement to the parseText method