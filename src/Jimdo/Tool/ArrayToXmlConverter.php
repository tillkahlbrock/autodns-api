<?php

namespace Jimdo\Tool;


interface ArrayToXmlConverter
{
    /**
     * @param array $data
     * @return \SimpleXMLElement
     */
    public function convert(array $data);
}
