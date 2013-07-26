<?php

use Jimdo\Autodns\Api\Client;
use Jimdo\Autodns\Api\Client\Method;

class ClientIntegrationTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldWork()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<response>
    <result>
        <msg>
            <code>MSG01046</code>
            <status>success</status>
            <text>Der bestehende Kuendigungsauftrag wurde storniert.</text>
            <type>notice</type>
        </msg>
        <status>
            <code>N0101003</code>
            <object>
                <type>domain</type>
                <value>example1695.com</value>
            </object>
            <text>Die Laufzeitverlaengerung wurde gestartet.</text>
            <type>notify</type>
        </status>
    </result>
</response>
XML;

        $expectedResult = array(
            'result' => array(
                'msg' => array(
                    'code' => 'MSG01046',
                    'status' => 'success',
                    'text' => 'Der bestehende Kuendigungsauftrag wurde storniert.',
                    'type' => 'notice'
                ),
                'status' => array(
                    'code' => 'N0101003',
                    'object' => array(
                        'type' => 'domain',
                        'value' => 'example1695.com'
                    ),
                    'text' => 'Die Laufzeitverlaengerung wurde gestartet.',
                    'type' => 'notify'
                )
            )
        );

        $response = $this->aStub('Buzz\Message\MessageInterface')->with('getContent', $xml);
        $sender = $this->aStub('Buzz\Browser')->with('post', $response)->build();
        $client = new Client(
            new Client\Method\Provider(),
            new \Jimdo\Autodns\Api\XmlDelivery(
                new \Jimdo\Tool\ArrayToXmlConverter(),
                new Jimdo\Autodns\Api\Account\Info(),
                $sender,
                new \Jimdo\Tool\XmlToArrayConverter()
            )
        );

        $payload = array(
            'name' => 'example1695.com',
            'payable' => '2012-12-22',
            'period' => 1,
            'remove_cancellation' => 'yes'
        );

        $result = $client->call(Method::DOMAIN_RENEW, 'deine mama', $payload);

        $this->assertEquals($expectedResult, $result);
    }
}
