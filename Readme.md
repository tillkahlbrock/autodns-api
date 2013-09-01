Autodns-API
===========

A full-featured implementation of the [AutoDNS-XML-API](http://www.internetx.com/en/software/autodns/xml-api.html).

Design goals
------------

 * No need to build / parse XML for the user
 * Easy request building even for complex queries
 * Consistent and simple interface

Usage
-----

### ApiClient

``` php
$accountInfo = new Autodns\Api\Account\Info('username', 'password', $context);
$client = Autodns\Api\Client\Factory::create($accountInfo);
```

### Request with Query

``` php
$query = new Autodns\Api\Client\Request\Task\Query\OrQuery(
    new Autodns\Api\Client\Request\Task\Query\AndQuery(
        new Autodns\Api\Client\Request\Task\Query\Parameter('name', 'like', '*.at'),
        new Autodns\Api\Client\Request\Task\Query\Parameter('created', 'lt', '2012-12-*')
    ),
    new Autodns\Api\Client\Request\Task\Query\Parameter('name', 'like', '*.de')
);

$request = \Tool\RequestBuilder::build()
    ->withReplyTo('replyTo@this.com')
    ->withCtid('some identifier');
$request
    ->ofType('DomainListInquiry')
    ->withView(array('offset' => 0, 'limit' => 20, 'children' => 0))
    ->withKeys(array('created', 'payable'))
    ->withQuery($query);
```

### Call

``` php
$response = $client->call(self::SOME_URL, $request)

$response->isSuccessful(); // -> true
$response->getStatusCode(); // -> "S12345"
$response->getStatusType(); // -> "success"
```

Todo
----

 * Return a response object instead of an array
 * Implement all the tasks
  * Domain inquiry
  * Domain list inquiry
  * ...
 * Add client factory