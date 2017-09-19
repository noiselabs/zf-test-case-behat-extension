Feature: Using the ZF Test Case
  As a Developer
  I need an access to ZF Test Case
  In order to make requests to the ZF MVC application I'm testing

  Background: Create module for tests
    Given there is a file named "app/config/application.config.php" with:
    """
    <?php
    $modules = [];
    if (class_exists('Zend\Router\Module')) {
        $modules[] = 'Zend\Router';
    }
    $modules[] = 'Application';

    $config = [
        'modules' => $modules,
        'module_listener_options' => [
            'module_paths' => [
                __DIR__.'/../modules',
                './vendor',
            ],
        ],
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
    ];



    return $config;
    """
    And there is a file named "app/modules/Application/config/module.config.php" with:
    """
    <?php
    namespace Application;

    return [
        'router' => [
            'routes' => [
                'album' => [
                    'type' => 'literal',
                    'options' => [
                        'route'    => '/album',
                        'defaults' => [
                            'controller' => Controller\AlbumController::class,
                            'action'     => 'index',
                        ],
                    ],
                ],
            ],
        ],
        'controllers' => [
            'invokables' => [
                Controller\AlbumController::class => Controller\AlbumController::class,
            ],
        ],
        'view_manager' => [
            'strategies' => [
                'ViewJsonStrategy',
            ],
        ],
    ];
    """
    And there is a file named "app/modules/Application/Module.php" with:
    """
    <?php
    namespace Application;

    class Module
    {
        public function getConfig()
        {
            return require __DIR__ . '/config/module.config.php';
        }

        public function getAutoloaderConfig()
        {
            return [
                'Zend\Loader\StandardAutoloader' => [
                    'namespaces' => [
                        __NAMESPACE__ => __DIR__ . '/src/',
                    ],
                ],
            ];
        }
    }
    """
    And there is a file named "app/modules/Application/src/Controller/AlbumController.php" with:

    """
    <?php
    namespace Application\Controller;

    use Zend\Mvc\Controller\AbstractActionController;
    use Zend\View\Model\JsonModel;

    class AlbumController extends AbstractActionController
    {
        public function indexAction()
        {
            return new JsonModel();
        }
    }
    """
  Scenario: Making requests
    Given a behat configuration:
    """
    default:
      autoload:
        '': %paths.base%/features/bootstrap/
      suites:
        default:
          contexts: [ControllerDispatchContext]
      extensions:
        Noiselabs\Behat\ZfTestCaseExtension\ServiceContainer\ZfTestCaseExtension:
          configuration: app/config/application.config.php
      """
    Given the context file "features/bootstrap/ControllerDispatchContext.php" contains:
    """
      <?php

      use Application\Controller\AlbumController;
      use Behat\Behat\Context\Context;
      use Noiselabs\Behat\ZfTestCaseExtension\Context\ZfTestCaseAwareContext;
      use Noiselabs\Behat\ZfTestCaseExtension\TestCase\HttpControllerTestCase;

      class ControllerDispatchContext implements ZfTestCaseAwareContext
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
           * @When /^I call the Album URL$/
           */
          public function iCallTheAlbumURL()
          {
              $this->testCase->dispatch('/album');
          }

          /**
           * @Then /^I can assert that the album controller was used$/
           */
          public function iCanAssertThatTheAlbumControllerWasUsed()
          {
              $this->testCase->assertResponseStatusCode(200);
              $this->testCase->assertModuleName('Application');
              $this->testCase->assertControllerName(AlbumController::class);
              $this->testCase->assertControllerClass('AlbumController');
              $this->testCase->assertMatchedRouteName('album');
          }
      }
      """
    And the feature file "features/controller_dispatcher.feature" contains:
    """
      Feature:
        Scenario: Testing ZF controllers
          When I call the Album URL
          Then I can assert that the album controller was used
      """
    When I run behat
    Then it should pass with:
    """
    .

    1 scenario (1 passed)
    2 steps (2 passed)
    """