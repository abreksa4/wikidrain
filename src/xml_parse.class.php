<?php
/**
 * Created by PhpStorm.
 * User: Andrew Breksa
 * Project: wikidrain
 * Date: 1/2/14
 * Time: 10:26 PM
 */

class xml_parse
{
    protected $_XML;
    protected $_data = array();
    protected $_count = 0;
    protected $_string;
    protected $_deadSections = array('See also', 'References', 'External links');

    function __destruct()
    {
        $this->_XML = NULL;
        $this->_data = NULL;
    }

    public function parseSearch($xml)
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

    public function parseSections($xml)
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

    public function parseText($xml)
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