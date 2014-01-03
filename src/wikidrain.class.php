<?php
/**
 * Created by PhpStorm.
 * User: Andrew Breksa
 * Project: wikidrain
 * File: wikidrain.class.php
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
    protected $_tmp = array();
    //XML vars
    protected $_XML;
    protected $_data = array();
    protected $_count = 0;
    protected $_string;
    protected $_deadSections = array('See also', 'References', 'External links');


    function __destruct()
    {
        $this->release();
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
        $result = $this->parseSearch($result);
        $this->release();
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
        $result = $this->parseSections($result);
        $this->release();
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
        $result = $this->parseText($result);
        $this->release();
        return $result;
    }

    public function getRelated($title)
    {
        $this->_data = $this->getSections($title);
        $this->_string = count($this->_data) + 1;
        $result = $this->getText($title, $this->_string);
        $result = preg_replace('/==(.*?)\==/s', '', $result);
        $result = str_replace("\r\n", "\n", $result);
        $result = str_replace("*", '', $result);
        $result = explode("\n", $result);
        $result = array_filter(array_map('trim', $result));
        $this->release();
        return $result;

    }

    private function release()
    {
        $this->_apiParams = NULL;
        $this->_query = NULL;
        $this->_title = NULL;
        $this->_section = NULL;
        //XML vars
        $this->_XML = NULL;
        $this->_data = NULL;
        //Shared
        $this->_tmp = NULL;
        $this->_string = NULL;
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

    //XML parsing methods

    private function parseSearch($xml)
    {
        $this->_count = 0;
        $this->_XML = new SimpleXMLElement($xml);
        foreach ($this->_XML->Section->Item as $item) {
            $this->_data[$this->_count] = array(
                "title" => "$item->Text",
                "description" => "$item->Description",
            );
            $this->_count++;
        }
        return $this->_data;
    }

    private function parseSections($xml)
    {
        $this->_count = 0;
        $this->_XML = new SimpleXMLElement($xml);
        foreach ($this->_XML->parse->sections->s as $section) {
            if (!in_array($section['line'], $this->_deadSections)) {
                $this->_data[$this->_count] = array(
                    'title' => "{$section['line']}",
                    'index' => "{$section['index']}",
                    'position' => "{$section['number']}"
                );
                $this->_count++;
            }
        }
        return $this->_data;
    }

    private function parseText($xml)
    {
        //Totally cheating here, just replacing characters...
        $this->_XML = new SimpleXMLElement($xml);
        $this->_data = $this->_XML->query->pages->page->revisions->rev;
        $string = $this->_data[0];
        $string = preg_replace('/<ref[^>]*>([\s\S]*?)<\/ref[^>]*>/', '', $string);
        $string = str_replace('|', '/', $string);
        $string = str_replace('[[', '', $string);
        $string = str_replace(']]', '', $string);
        $string = preg_replace('/{{(.*?)\}}/s', '', $string);
        $string = strip_tags($string);
        return $string;
    }
}
