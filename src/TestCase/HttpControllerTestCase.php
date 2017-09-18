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

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class HttpControllerTestCase extends AbstractHttpControllerTestCase
{
    /**
     * @param string $name Service name
     *
     * @return array|mixed|object
     */
    public function getService($name)
    {
        return $this->getApplicationServiceLocator()->get($name);
    }

    /**
     * @param string $name Service name
     * @param array|object $service
     */
    public function replaceService($name, $service)
    {
        $serviceManager = $this->getApplicationServiceLocator();

        $serviceManager->setAllowOverride(true);
        $serviceManager->setService($name, $service);
        $serviceManager->setAllowOverride(false);
    }
}