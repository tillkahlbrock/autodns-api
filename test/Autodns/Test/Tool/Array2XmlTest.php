<?php

namespace Autodns\Test\Tool;


use Autodns\Api\Client\Request;
use Autodns\Test\TestCase;
use Autodns\Tool\Array2Xml;

class Array2XMLTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldWork()
    {
        $request = new Request(
            new \Autodns\Api\Client\Request\Task\DomainListInquiry(
                array('offset' => 0, 'limit' => 20, 'children' => 0),
                array('created'),
                new Request\Task\Query\OrQuery(
                    new Request\Task\Query\AndQuery(
                        new Request\Task\Query\Parameter('name', 'like', '*.at'),
                        new Request\Task\Query\Parameter('created', 'lt', '2012-12-*')
                    ),
                    new Request\Task\Query\Parameter('name', 'like', '*.de')
                )
            ),
            'replyTo@this.com',
            'some identifier'
        );

        $request->setAuth(array('user' => 'username', 'password' => 'password', 'context' => 'context'));

        $expectedXml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<request>
  <auth>
    <user>username</user>
    <password>password</password>
    <context>context</context>
  </auth>
  <task>
    <code>0105</code>
    <view>
      <offset>0</offset>
      <limit>20</limit>
      <children>0</children>
    </view>
    <key>created</key>
    <where>
      <or>
        <and>
          <key>name</key>
          <operator>like</operator>
          <value>*.at</value>
        </and>
        <and>
          <key>created</key>
          <operator>lt</operator>
          <value>2012-12-*</value>
        </and>
      </or>
      <or>
        <key>name</key>
        <operator>like</operator>
        <value>*.de</value>
      </or>
    </where>
  </task>
  <replyTo>replyTo@this.com</replyTo>
  <ctid>some identifier</ctid>
</request>
XML;

        $generatedXml = Array2Xml::createXML('request', $request->asArray())->saveXML();

        $this->assertXmlStringEqualsXmlString($expectedXml, $generatedXml);

    }
}
