<?php

use Autodns\Api\Client\Method\Provider;
use Autodns\Api\Client\Method;

class ProviderTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateAMethodIfAMethodWithTheGivenNameExists()
    {
        $methodProvider = new Provider();

        $method = $methodProvider->fetchMethod(Method::DOMAIN_RENEW);

        $this->assertInstanceOf('Autodns\Api\Client\Method\DomainRenew', $method);
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionIfTheGivenMethodNameDoesNotExist()
    {
        $this->setExpectedException('Autodns\Api\Exception\MethodNameDoesNotExist');

        $methodProvider = new Provider();

        $methodProvider->fetchMethod('method name that does not exist');
    }
}
