<?php

namespace Autodns\Test\Tool;


use Autodns\Api\Client\Request;
use Autodns\Test\TestCase;
use Autodns\Tool\Array2Xml;
use Autodns\Tool\QueryBuilder;
use Autodns\Tool\RequestBuilder;

class Array2XMLTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldWork()
    {
        $request = RequestBuilder::build()->withReplyTo('replyTo@this.com')->withCtid('some identifier');
        $request->ofType('DomainListInquiry')
            ->withView(array('offset' => 0, 'limit' => 20, 'children' => 0))
            ->withKeys(array('created', 'updated'))
            ->withQuery(
                QueryBuilder::build()->addOr(
                    QueryBuilder::build()->addAnd(
                        array('name', 'like', '*.at'),
                        array('created', 'lt', '2012-12-*')
                    ),
                    array('name', 'like', '*.de')
                )
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
    <key>updated</key>
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

        $array2Xml = new Array2Xml();
        $generatedXml = $array2Xml->buildXml('request', $request->asArray())->saveXML();

        $this->assertXmlStringEqualsXmlString($expectedXml, $generatedXml);

    }
}
