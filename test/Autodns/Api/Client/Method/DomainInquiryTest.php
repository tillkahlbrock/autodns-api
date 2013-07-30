<?php

use Autodns\Api\Client\Method\DomainInquiry;

class DomainInquiryTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldGenerateTheTask()
    {
        $method = new DomainInquiry();

        $requestData = array(
            'name'                 => 'some-domain.org',
            'key'                  => array('payable', 'created'),
            'show_contact_details' => 'ownerc'
        );

        $expectedRequest = array(
            'code'                 => '0105',
            'domain'               => array(
                'name' => 'some-domain.org'
            ),
            'key'                  => array('payable', 'created'),
            'show_contact_details' => 'ownerc'
        );

        $request = $method->createTask($requestData);

        $this->assertEquals($expectedRequest, $request);
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionIfTheDomainNameIsMissingInTheRequestData()
    {
        $this->setExpectedException('Autodns\Api\Exception\RequestDataParameterMissing');

        $method = new DomainInquiry();

        $requestWithMissingDomainName = array(
            'key'                  => array('payable', 'create'),
            'show_contact_details' => 'ownerc'
        );

        $method->createTask($requestWithMissingDomainName);
    }
}
