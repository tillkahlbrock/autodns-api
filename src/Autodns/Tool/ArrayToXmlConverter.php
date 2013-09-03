<?php

namespace Autodns\Tool;

class ArrayToXmlConverter
{
    /**
     * @param array $data
     * @return string
     */
    public function convert(array $data)
    {
        $converter = new Array2Xml();
        return $converter->buildXml('request', $data)->saveXML();
    }
}
