<?php
/*
 * This file is part of the Noiselabs ZfTestCase Behat Extension.
 *
 * (c) Vítor Brandão <vitor@noiselabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Noiselabs\Behat\ZfTestCaseExtensionTest\Context\Initializer;

use Noiselabs\Behat\ZfTestCaseExtension\Context\Initializer\ZfTestCaseAwareInitializer;
use Noiselabs\Behat\ZfTestCaseExtension\Context\ZfTestCaseContext;
use Noiselabs\Behat\ZfTestCaseExtension\TestCase\HttpControllerTestCase;
use PHPUnit_Framework_TestCase;

/**
 * @group unit
 */
class ZfTestCaseAwareInitializerTest extends PHPUnit_Framework_TestCase
{
    public function test_it_can_initialize_the_context()
    {
        $context = new ZfTestCaseContext();
        $initializer = new ZfTestCaseAwareInitializer(new HttpControllerTestCase());

        $initializer->initializeContext($context);
    }
}
