<?php

use Jimdo\Autodns\Api\Client\Method\Provider;
use Jimdo\Autodns\Api\Client\Method;

class ProviderTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateAMethodIfAMethodWithTheGivenNameExists()
    {
        $methodProvider = new Provider();

        $method = $methodProvider->fetchMethod(Method::DOMAIN_RENEW);

        $this->assertInstanceOf('Jimdo\Autodns\Api\Client\Method\DomainRenew', $method);
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionIfTheGivenMethodNameDoesNotExist()
    {
        $this->setExpectedException('Jimdo\Autodns\Api\Exception\MethodNameDoesNotExist');

        $methodProvider = new Provider();

        $methodProvider->fetchMethod('method name that does not exist');
    }
}
