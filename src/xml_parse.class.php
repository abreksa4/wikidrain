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
        foreach ($this->_XML->parse->sections->s as $s) {
            $this->_data[$this->_count] = array(
                'title' => "{$s['line']}",
                'index' => "{$s['index']}",
                'position' => "{$s['number']}"
            );
            $this->_count++;
        }
        return $this->_data;
    }


} 