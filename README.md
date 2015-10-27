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

```php
<?php
    $wiki = new wikidrain('wikidrain/1.0 (http://www.example.com/)');
?>
```

NOTE: You must supply your user-agent info, here the example header is:
      
      'wikidrain/1.0 (http://www.example.com/)'
      
You can also specify a two-letter country code to search Wikipedia in your language:

```php
<?php
    $wiki = new wikidrain('wikidrain/1.0 (http://www.example.com/)', 'pt');
?>
```

NOTE: You can find the country code in the link of wikipedia when you visit wikipedia.org in your browser:
      
      'http://*pt*.wikipedia.org/'

To search wikipedia for articles, use the Search method:
This returns a multidimensional array...

```php
<?php
    $wiki = new wikidrain('wikidrain/1.0 (http://www.example.com/)');
    //The second argument allows for setting a limit on the number of results returned. On null, default is 10.
    $result = $wiki->Search('API', 10);
?>
```

To get the sections of a wikipedia page, use the getSections method:
This also returns a multidimensional array...

```php
<?php
    $wiki = new wikidrain('wikidrain/1.0 (http://www.example.com/)');
    $result = $wiki->getSections('API');
?>
```

NOTE: Wikidrain does not include any error checking/verification that the article
      exists, so be sure to only request the sections/text of articles that were
      returned by the Search() method...

To get the text of a section from a wikipedia page, use the getText
method.
This returns text...

```php
<?php
    $wiki = new wikidrain('wikidrain/1.0 (http://www.example.com/)');
    $result = $wiki->getText('API', '0');
?>
```

NOTE: Again, wikidrain does not include any error checking/verification to determine
      if an article or section exists, so make sure to only request data from pages/
      sections returned by the Search() and getSections() methods...

To get the list of articles listed in the 'See also' section, use the getRelated
method
This returns an array...

```php
<?php
    $wiki = new wikidrain('wikidrain/1.0 (http://www.example.com/)');
    $wiki->getRelated('API');
?>
```

The class caches results so it won't query wikipedia twice for the same data.
It will clean up after itself but you may want to release the cache before.
If you want to clear the cache on-demand to spare memory you can:

```php
<?php
    $wiki = new wikidrain('wikidrain/1.0 (http://www.example.com/)');
    
    $result = $wiki->getText('API', '0'); //First call is cached
    
    //Do stuff with the result...
    
    $result = $wiki->getText('API', '0'); //So now we don't even make a request
    
    //Do more stuff with the result...
    
    $wiki->release_cache(); //Release the cache from memory
?>
```


TODO:
===================================================================================

Currently, the objectives are as follows:

1. Anything to put less strain on the wikipedia servers

2. A method to return the wikipedia donation banner

3. Error checking

4. Any improvement to the parseText method
