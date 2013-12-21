<?php
/**
 * Created by PhpStorm.
 * User: abreksa
 * Project: wikdrain
 * Date: 12/19/13
 * Time: 1:07 AM
 */

class wikidrain {

    protected $_apiUrl;
    protected $_wikiQuery;
    //Define the structure of the wikipedia page
    protected $_wikiBones = array(
        'title' => '', //This is the actual title
        'sections' => array( //The titles of the sections
            'title' => array(),
        ),
    );
    //Define the data of the wikipedia page
    protected $_wikiData = array(
        'title' => '', //This is the summary
        'sections' => array( //The data in each section
            'text' => array(),
        ),
        'related' => array( //The related pages
            'title' => array(),
        ),
    );

    public function __construct($lang){
        $this->setLang($lang);
    }

    public function setLang($lang){
        $this->_apiUrl = "http://{$lang}.wikipedia.org/w/api.php";
    }

    public function getApi(){
        return $this->_apiUrl;
    }

    public function setQuery($query){
        $this->_wikiQuery = $query;
    }

    public function getQuery(){
        return $this->_wikiQuery;
    }

    public function queryClean(){
        $this->_wikiQuery = htmlspecialchars($this->_wikiQuery);
    }

}