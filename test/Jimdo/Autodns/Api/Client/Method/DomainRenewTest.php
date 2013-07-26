<?php

use Jimdo\Autodns\Api\Client\Method\DomainRenew;

class DomainRenewTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldGenerateTheTask()
    {
        $domainName = 'some-domain.org';
        $payableDate = '2012-12-24';
        $period = 1;
        $removeCancellation = 'yes';

        $method = new DomainRenew();

        $requestData = array(
            'name' => $domainName,
            'payable' => $payableDate,
            'period' => $period,
            'remove_cancellation' => $removeCancellation
        );

        $expectedRequest = array(
            'code' => '0101003',
            'domain' => array(
                'name' => $domainName,
                'payable' => $payableDate,
                'period' => $period,
                'remove_cancellation' => $removeCancellation
            )
        );

        $request = $method->createTask($requestData);

        $this->assertEquals($expectedRequest, $request);
    }
}
