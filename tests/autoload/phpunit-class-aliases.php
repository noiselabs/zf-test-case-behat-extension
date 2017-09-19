<?php
/*
 * This file is part of the Noiselabs ZfTestCase Behat Extension.
 *
 * (c) Vítor Brandão <vitor@noiselabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

if (file_exists(__DIR__ . '/../../vendor/zendframework/zend-test/autoload/phpunit-class-aliases.php')) {
    require __DIR__ . '/../../vendor/zendframework/zend-test/autoload/phpunit-class-aliases.php';
}

if (!class_exists(Assert::class)) {
    class_alias(\PHPUnit_Framework_Assert::class, Assert::class);
}

if (!class_exists(TestCase::class)) {
    class_alias(\PHPUnit_Framework_TestCase::class, TestCase::class);
}