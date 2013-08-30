<?php

namespace Tool;

class ArrayToXmlConverter
{
    /**
     * @param array $data
     * @return string
     */
    public function convert(array $data)
    {
        return Array2Xml::createXML('request', $data)->saveXML();
    }
}
