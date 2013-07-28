<?php

namespace Tool;

class ArrayToXmlConverter
{
    /**
     * @param array $data
     * @return \SimpleXMLElement
     */
    public function convert(array $data)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?><request />');
        $this->arrayToXml($data, $xml);
        return $xml->asXML();
    }

    /**
     * @param array $data
     * @param \SimpleXMLElement $xml
     * @return \SimpleXMLElement
     */
    private function arrayToXml(array $data, \SimpleXMLElement &$xml)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $subNode = $xml->addChild("$key");
                $this->arrayToXml($value, $subNode);
            } else {
                $xml->addChild("$key", "$value");
            }
        }
    }
}
