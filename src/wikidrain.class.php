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
    protected $_wikiPage;
    protected $_wikiData;

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

    public function getSections(){
        $this->_wikiData = "{$this->_apiUrl}?format=html&action=parse&prop=sections&title={$this->_wikiPage}";
        return $this->_wikiData;
    }
}