<?php

/*
 * This file is part of the Noiselabs ZfTestCase Behat Extension.
 *
 * (c) Vítor Brandão <vitor@noiselabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Noiselabs\Behat\ZfTestCaseExtension\ServiceContainer;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Noiselabs\Behat\ZfTestCaseExtension\Context\Initializer\ZfTestCaseAwareInitializer;
use Noiselabs\Behat\ZfTestCaseExtension\TestCase\HttpControllerTestCase;
use Noiselabs\Behat\ZfTestCaseExtension\TestCase\HttpControllerTestCaseFactory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Vítor Brandão <vitor@noiselabs.io>
 */
class ZfTestCaseExtension implements Extension
{
    const EXTENSION_ID = 'noiselabs_zf_test_case';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        // TODO: Implement process() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return self::EXTENSION_ID;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
        // TODO: Implement initialize() method.
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('configuration')->info('Path to config path of Zend application')->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $this->loadHttpControllerTestCase($container, $config);
        $this->loadContextInitializer($container);
    }

    private function loadHttpControllerTestCase(ContainerBuilder $container, array $config)
    {
        $container
            ->register(self::EXTENSION_ID . '.http_controller_test_case', HttpControllerTestCase::class)
            ->setFactory([HttpControllerTestCaseFactory::class, 'create'])
            ->addArgument($config['configuration']);
    }

    private function loadContextInitializer(ContainerBuilder $container)
    {
        $container
            ->register(self::EXTENSION_ID . '.context_initializer', ZfTestCaseAwareInitializer::class)
            ->addArgument(new Reference(self::EXTENSION_ID . '.http_controller_test_case'))
            ->addTag(ContextExtension::INITIALIZER_TAG);
    }
}