<?php
/*
 * This file is part of the Noiselabs ZfTestCase Behat Extension.
 *
 * (c) Vítor Brandão <vitor@noiselabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Noiselabs\Behat\ZfTestCaseExtension\Context;

use Noiselabs\Behat\ZfTestCaseExtension\TestCase\HttpControllerTestCase;

class ZfTestCaseContext implements ZfTestCaseAwareContext
{
    /**
     * @var HttpControllerTestCase
     */
    protected $testCase;

    /**
     * @param HttpControllerTestCase $testCase
     */
    public function setTestCase(HttpControllerTestCase $testCase)
    {
        $this->testCase = $testCase;
    }
}