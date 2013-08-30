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
                'code' => '0101003',
                'domain' => array(
                    'name' => 'some-domain.com',
                    'payable' => '2012-01-15',
                    'period' => 1,
                    'remove_cancellation' => 'no'
                )
            )
        );

        $expectedXml = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
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

        $this->assertRequestIsConvertedToExpectedXml($request, $expectedXml);
    }

    /**
     * @test
     */
    public function itShouldGenerateATagForEachValue()
    {
        $request = array(
            'task' => array(
                'code' => '0105',
                'domain' => array(
                    'name' => 'some-domain.net'
                ),
                'key' => array('payable', 'created')
            )
        );

        $expectedXml = <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<request>
    <task>
        <code>0105</code>
        <domain>
            <name>some-domain.net</name>
        </domain>
        <key>payable</key>
        <key>created</key>
    </task>
</request>
XML;

        $this->assertRequestIsConvertedToExpectedXml($request, $expectedXml);
    }

    /**
     * @param $request
     * @param $expectedXml
     */
    private function assertRequestIsConvertedToExpectedXml($request, $expectedXml)
    {
        $converter = new Tool\ArrayToXmlConverter();

        $this->assertXmlStringEqualsXmlString(
            $expectedXml,
            $converter->convert($request)
        );
    }
}
