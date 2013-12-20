Autodns-API
===========

SDom


A full-featured implementation of the [AutoDNS-XML-API](http://www.internetx.com/en/software/autodns/xml-api.html).

[![Build Status](https://secure.travis-ci.org/tillkahlbrock/autodns-api.png?branch=master)](http://travis-ci.org/tillkahlbrock/autodns-api)

Design goals
------------

 * No need to build / parse XML for the user
 * Easy request building even for complex queries
 * Consistent and simple interface

Usage
-----

### ApiClient

``` php
use Autodns\Api\Account\Info;
use Autodns\Api\Client\Factory;

$accountInfo = new Info(
    'https://api.autodns.com',
    'username',
    'password',
    15
);

$client = Factory::create($accountInfo);
```

### Request with Query

``` php
use Autodns\Api\Client\Request\Task\Query;
use Autodns\Api\Client\Request\TaskBuilder\DomainInquireList;

$query = new Query();
$query = $query->addOr(
    $query->addAnd(
        array('name', 'like', '*.at'),
        array('created', 'lt', '2012-12-*')
    ),
    array('name', 'like', '*.de')
);

$task = new DomainInquireList();
$task->withView(array('offset' => 0, 'limit' => 20, 'children' => 0))
    ->withKeys(array('created', 'payable'))
    ->withQuery($query);
```

### Call

``` php
$response = $client->call($task)

$response->isSuccessful(); // -> true
$response->getStatusCode(); // -> "S12345"
$response->getStatusType(); // -> "success"
```

Todo
----

 * Add some error handling
 * ~~Make selection of tasks less error prone. By now it is: ```TaskBuilder::build('DomainListInquiry')```~~

Autodns tasks
-------------

### Domain

 * Domain Create (0101)
 * Domain Update (0102)
 * Domain Renew (0101003)
 * Domain Ownerchange (0104010)
 * Domain Delete (0103)
 * Domain Inquire (0105)
 * ~~Domain Inquire List (0105)~~
 * Domain Status (0102002)
 * Domain Status List (0102002)

### Cancelation

 * Cancelation Create (0103101)
 * Cancelation Update (0103102)
 * Cancelation Delete (0103103)
 * Cancelation Delete (0103103)
 * Cancelation Inquire (0103104)
 * Cancelation Inquire List (0103104)

### Domaintransfer

 * Domain Transfer In (0104)
 * Domain Transfer Out (0106002)
 * Domain Transfer Out Inquire (0106002)
 * Domain Status (0102002)
 * Domain Status List (0102002)
 * AuthInfo 1 Create (0113001)
 * AuthInfo 1 Delete (0113002)
 * AuthInfo 2 Create (0113003)
 * IRTP Inquire (0114001)
 * IRTP Restart (0114002)

### Domain Prereg

 * Domain Prereg Create (0110001)
 * Domain Prereg Update (0110002)
 * Domain Prereg Delete (0110003)
 * Domain Prereg Inquire (0110005)

### Domain Backorder

 * Domain Backorder Create (0141)
 * Domain Backorder Delete (0143)
 * Domain Backorder Inquire List (0146)
 * Domain Backorder User Inquire List (0145)

### Zone

 * Zone Create (0201)
 * Zone Update (0202)
 * Zone Import (0204)
 * Zone Delete (0203)
 * Zone Inquire (0205)

### Handle

 * Handle Create (0301)
 * Handle Update (0302)
 * Handle Delete (0303)
 * Handle Inquire (0304)

### Redirect

 * Redirect Create (0501)
 * Redirect Update (0502)
 * Redirect Delete (0503)
 * Redirect Inquire (0504)

### User

 * User Create (1301001)
 * User Update (1301002)
 * User Inquire (1301004)
 * User Profile Update (1301014)
 * Object User Assignment (1308)

### Order

 * Spool Inquire (0710)
 * History Inquire (0713)
