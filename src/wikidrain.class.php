<?php
/**
 * Created by PhpStorm.
 * User: abreksa
 * Project: wikdrain
 * Date: 12/19/13
 * Time: 1:07 AM
 */

class wikidrain
{
    public $_limResults = 10;
    protected $_format = "xml";
    protected $_string;
    protected $_apiUrl;
    protected $_wikiQuery;
    protected $_searchParams = array(
        'action' => '',
        'params' => array(),
    );
    //Define the structure of the wikipedia page
    protected $_wikiBones = array(
        'title' => '', //This is the actual title
    );

    public function __construct($lang)
    {
        $this->setLang($lang);
    }

    public function setLang($lang)
    {
        $this->_apiUrl = "http://{$lang}.wikipedia.org/w/api.php?format={$this->_format}&";
    }

    public function getApi()
    {
        return $this->_apiUrl;
    }

    public function setQuery($query)
    {
        $this->_wikiQuery = $query;
        $this->cleanQuery();
    }

    public function getQuery()
    {
        return $this->_wikiQuery;
    }

    public function cleanQuery()
    {
        $this->_wikiQuery = htmlspecialchars($this->_wikiQuery);
    }

    public function setTitle($title)
    {
        $this->_wikiBones['title'] = "{$title}";
    }

    public function getTitle()
    {
        return $this->_wikiBones['title'];
    }

    public function sectionWiki($section)
    {
        $this->_searchParams['action'] = 'query';
        $this->_searchParams['params'] = array(
            "prop=revisions",
            "titles={$this->_wikiBones['title']}",
            "redirects=true",
            "rvprop=content",
            "rvsection={$section}",
        );
        $result = $this->callApi();
        return $result;
    }

    public function sectionsWiki()
    {
        $this->_searchParams['action'] = 'parse';
        $this->_searchParams['params'] = array(
            "prop=sections",
            "page={$this->_wikiBones['title']}",
            "redirects=true",
        );
        $result = $this->callApi();
        return $result;
    }

    public function searchWiki()
    {
        $this->_searchParams['action'] = 'opensearch';
        $this->_searchParams['params'] = array(
            "limit={$this->_limResults}",
            "search={$this->_wikiQuery}",
            "suggest=false",
        );
        $result = $this->callApi();
        return $result;
    }

    private function callApi()
    {
        $params = implode('&', $this->_searchParams['params']);
        $url = "{$this->_apiUrl}action={$this->_searchParams['action']}&{$params}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'wikidrain/1.0 (http://www.example.com/)');
        $result = curl_exec($curl);
        return $result;
    }
}