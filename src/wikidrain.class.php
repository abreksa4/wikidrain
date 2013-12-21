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
    protected $_wikiBones = array(
        'title' => '',
        'suggestions' => array(),
        'sections' => array(),
        ''
    );
    protected $_wikiData = array(

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