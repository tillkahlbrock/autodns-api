<?php

namespace Autodns\Test;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $className
     * @return \TestDataBuilder_StubBuilder
     */
    public function aStub($className)
    {
        return new \TestDataBuilder_StubBuilder($className, $this);
    }

    /**
     * @param string $className
     * @return \TestDataBuilder_ObjectBuilder
     */
    public function anObject($className)
    {
        return new \TestDataBuilder_ObjectBuilder($className);
    }
}
