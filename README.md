# Zf Test Case Behat Extension

[![Build Status](https://travis-ci.org/noiselabs/zf-test-case-behat-extension.svg)](https://travis-ci.org/noiselabs/zf-test-case-behat-extension)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/noiselabs/zf-test-case-behat-extension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/noiselabs/zf-test-case-behat-extension/?branch=master)

Integration testing for ZF MVC applications in Behat by exposing Zend\Test classes (originally built for PHPUnit).

Installation
------------

This extension requires:

* Behat 3.0+

The recommended installation method is through [Composer](http://getcomposer.org):

```bash
$ composer require --dev noiselabs/zf-test-case-behat-extension
```

You can then activate the extension in your ``behat.yml``:

```yaml
default:
    # ...
    extensions:
        Noiselabs\Behat\ZfTestCaseExtension\ServiceContainer\ZfTestCaseExtension:
            configuration: </path/to/application.config.php>
```

## Usage

Implement `ZfTestCaseAwareContext` or extend `ZfTestCaseContext`:

```php
<?php

use Album\Controller\AlbumController;
use Noiselabs\Behat\ZfTestCaseExtension\Context\ZfTestCaseAwareContext;
use Noiselabs\Behat\ZfTestCaseExtension\TestCase\HttpControllerTestCase;

class MyContext implements ZfTestCaseAwareContext
{
    /**
     * @var HttpControllerTestCase
     */
    private $testCase;

    public function setTestCase(HttpControllerTestCase $testCase)
    {
        $this->testCase = $testCase;
    }
    
    /**
     * @When /^the album endpoint is called$/
     */
    public function testIndexActionCanBeAccessed()
    {
        // See https://docs.zendframework.com/tutorials/unit-testing/
        $this->testCase->dispatch('/album');
        $this->testCase->assertResponseStatusCode(200);
        $this->testCase->assertModuleName('Album');
        $this->testCase->assertControllerName(AlbumController::class);
        $this->testCase->assertControllerClass('AlbumController');
        $this->testCase->assertMatchedRouteName('album');
    }
}

```

## Copyright
   
Copyright (c) 2017 [Vítor Brandão](https://noiselabs.io). Licensed under the [MIT License](LICENSE).
