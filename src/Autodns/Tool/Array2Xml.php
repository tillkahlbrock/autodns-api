<?php

namespace Autodns\Tool;

use \DOMDocument;

class Array2Xml
{
    /**
     * @param string $rootNode
     * @param array $inputArray
     * @param string $version
     * @param string $encoding
     * @return DOMDocument
     */
    public function buildXml($rootNode, array $inputArray, $version = '1.0', $encoding = 'utf-8')
    {
        $xml = new DomDocument($version, $encoding);
        $xml->formatOutput = true;

        $xml->appendChild($this->convert($rootNode, $inputArray, $xml));

        return $xml;
    }

    /**
     * @param $nodeName
     * @param $input
     * @param DOMDocument $xml
     * @return \DOMElement
     */
    private function convert($nodeName, $input, DomDocument $xml)
    {

        $node = $xml->createElement($nodeName);

        if (is_array($input)) {
            foreach ($input as $key => $value) {
                if (is_array($value) && is_numeric(key($value))) {
                    foreach ($value as $v) {
                        $node->appendChild($this->convert($key, $v, $xml));
                    }
                } else {
                    $node->appendChild($this->convert($key, $value, $xml));
                }
                unset($input[$key]);
            }
        } else {
            $node->appendChild($xml->createTextNode($this->bool2str($input)));
        }

        return $node;
    }

    /**
     * @param $input
     * @return string
     */
    private function bool2str($input)
    {
        if (!($input === true || $input === false)) {
            return $input;
        }

        return $input ? 'true' : 'false';
    }
}
