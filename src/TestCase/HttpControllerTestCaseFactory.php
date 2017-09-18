<?php
/*
 * This file is part of the Noiselabs ZfTestCase Behat Extension.
 *
 * (c) Vítor Brandão <vitor@noiselabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Noiselabs\Behat\ZfTestCaseExtension\TestCase;

use RuntimeException;

class HttpControllerTestCaseFactory
{
    /**
     * @param string $applicationConfigPath
     *
     * @return HttpControllerTestCase
     */
    public static function create($applicationConfigPath)
    {
        if (!file_exists($applicationConfigPath)) {
            throw new RuntimeException(sprintf("Invalid path to ZF application config: '%s'", $applicationConfigPath));
        }

        $applicationConfig = require_once $applicationConfigPath;

        $testCase = new HttpControllerTestCase();
        $testCase->reset();
        $testCase->setApplicationConfig($applicationConfig);


        return $testCase;
    }
}