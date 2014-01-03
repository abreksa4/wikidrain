<?php
/**
 * Created by PhpStorm.
 * User: Andrew Breksa
 * Project: wikidrain
 * Date: 1/2/14
 * Time: 8:46 PM
 */

class wikidrain
{
    protected $_apiURL = 'http://en.wikipedia.org/w/api.php?format=xml&';
    protected $_apiParams = array();
    protected $_query;
    protected $_title;
    protected $_section;


    function __destruct()
    {
        $this->_apiParams = NULL;
        $this->_query = NULL;
        $this->_title = NULL;
        $this->_section = NULL;
    }


    public function Search($query, $numResult)
    {
        $this->_query = htmlspecialchars($query);
        $this->_apiParams['action'] = 'opensearch';
        $this->_apiParams['params'] = array(
            "limit={$numResult}",
            "search={$this->_query}",
            "suggest=false",
        );
        $result = $this->callApi();
        return $result;
    }

    public function getSections($title)
    {
        $this->_title = htmlspecialchars($title);
        $this->_apiParams['action'] = 'parse';
        $this->_apiParams['params'] = array(
            "prop=sections",
            "page={$this->_title}",
            "redirects=true",
        );
        $result = $this->callApi();
        return $result;
    }

    public function getText($title, $section)
    {
        $this->_title = htmlspecialchars($title);
        $this->_section = htmlspecialchars($section);
        $this->_apiParams['action'] = 'query';
        $this->_apiParams['params'] = array(
            "prop=revisions",
            "titles={$this->_title}",
            "redirects=true",
            "rvprop=content",
            "rvsection={$this->_section}",
        );
        $result = $this->callApi();
        return $result;
    }

    public function getRelated($title)
    {

    }

    private function callApi()
    {
        $params = implode('&', $this->_apiParams['params']);
        $url = "{$this->_apiURL}action={$this->_apiParams['action']}&{$params}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'wikidrain/1.0 (http://www.example.com/)');
        $result = curl_exec($curl);
        return $result;
    }
}

?>