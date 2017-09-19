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

if (!class_exists(Assert::class)) {
    class_alias(\PHPUnit_Framework_Assert::class, Assert::class);
}
