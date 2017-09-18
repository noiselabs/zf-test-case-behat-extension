<?php
/*
 * This file is part of the Noiselabs ZfTestCase Behat Extension.
 *
 * (c) Vítor Brandão <vitor@noiselabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Noiselabs\Behat\ZfTestCaseExtension\Context\Initializer;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use Noiselabs\Behat\ZfTestCaseExtension\Context\ZfTestCaseAwareContext;
use Noiselabs\Behat\ZfTestCaseExtension\TestCase\HttpControllerTestCase;

/**
 * ZfTestCase aware contexts initializer.
 * Sets an HttpControllerTestCase instance to ZfTestCaseAware contexts.
 */
class ZfTestCaseAwareInitializer implements ContextInitializer
{
    /**
     * @var HttpControllerTestCase
     */
    private $testCase;

    public function __construct(HttpControllerTestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * {@inheritdoc}
     */
    public function initializeContext(Context $context)
    {
        if ($context instanceof ZfTestCaseAwareContext) {
            $context->setTestCase($this->testCase);
        }
    }
}