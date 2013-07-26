<?php

class ArrayToXmlConverterTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldConvertTheArrayToXml()
    {
        $request = array(
            'auth' => array(
                'user' => 'some user',
                'password' => 's3cr3t3',
                'context' => 2
            ),
            'task' => array(
                'code'   => '0101003',
                'domain' => array(
                    'name'                => 'some-domain.com',
                    'payable'             => '2012-01-15',
                    'period'              => 1,
                    'remove_cancellation' => 'no'
                )
            )
        );

        $expectedXml = <<<XML
<?xml version="1.0"encoding="utf-8" ?>
<request>
    <auth>
        <user>some user</user>
        <password>s3cr3t3</password>
        <context>2</context>
    </auth>
    <task>
        <code>0101003</code>
        <domain>
            <name>some-domain.com</name>
            <payable>2012-01-15</payable>
            <period>1</period>
            <remove_cancellation>no</remove_cancellation>
        </domain>
    </task>
</request>
XML;

        $converter = new Jimdo\Tool\ArrayToXmlConverter();

        $this->assertEquals($this->removeWhiteSpaces($expectedXml), $this->removeWhiteSpaces($converter->convert($request)));
    }

    private function removeWhiteSpaces($string)
    {
        return preg_replace('/\s/', '', $string);
    }
}
