<?php
/*
 * This file is part of the Noiselabs ZfTestCase Behat Extension.
 *
 * (c) Vítor Brandão <vitor@noiselabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Noiselabs\Behat\ZfTestCaseExtensionTest\ServiceContainer;

use Behat\Testwork\ServiceContainer\Configuration\ConfigurationTree;
use Noiselabs\Behat\ZfTestCaseExtension\Context\Initializer\ZfTestCaseAwareInitializer;
use Noiselabs\Behat\ZfTestCaseExtension\ServiceContainer\ZfTestCaseExtension;
use Noiselabs\Behat\ZfTestCaseExtension\TestCase\HttpControllerTestCase;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @group integration
 */
class ZfTestCaseExtensionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var ZfTestCaseExtension
     */
    private $extension;

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new ZfTestCaseExtension();
    }

    public function test_it_is_a_testwork_extension()
    {
        $this->assertInstanceOf(ZfTestCaseExtension::class, $this->extension);
    }

    public function test_it_exposes_its_extension_id()
    {
        $this->assertSame(ZfTestCaseExtension::EXTENSION_ID, $this->extension->getConfigKey());
    }

    public function test_it_loads_the_http_controller_test_case()
    {
        $this->loadExtension(['configuration' => __DIR__ . '/../Fixtures/application.config.php']);
        $this->assertServiceRegistered(ZfTestCaseExtension::EXTENSION_ID . '.http_controller_test_case',
            HttpControllerTestCase::class);
    }

    public function test_it_loads_the_context_initializer()
    {
        $this->loadExtension(['configuration' => __DIR__ . '/../Fixtures/application.config.php']);
        $this->assertServiceRegistered(ZfTestCaseExtension::EXTENSION_ID . '.context_initializer',
            ZfTestCaseAwareInitializer::class);
    }

    private function assertServiceRegistered($id, $class)
    {
        $this->assertTrue($this->container->has($id));
        $this->assertInstanceOf($class, $this->container->get($id));
    }

    private function loadExtension(array $config = [])
    {
        $this->extension->load($this->container, $this->processConfiguration($config));
        $this->container->compile();
    }

    private function processConfiguration(array $config = [])
    {
        $configurationTree = new ConfigurationTree();
        $configTree = $configurationTree->getConfigTree([$this->extension]);
        $key = $this->extension->getConfigKey();
        $config = (new Processor())->process($configTree, ['testwork' => [$key => $config]]);

        return $config[$key];
    }
}
