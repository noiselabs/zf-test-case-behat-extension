<?php
/*
 * This file is part of the Noiselabs ZfTestCase Behat Extension.
 *
 * (c) Vítor Brandão <vitor@noiselabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use PHPUnit\Framework\Assert;

/**
 * Class FeatureContext.
 *
 * Adapted from https://github.com/jakzal/BehatRestExtension/blob/master/features/bootstrap/BehatRunnerContext.php
 */
class FeatureContext implements Context
{
    /**
     * @var BehatRunner
     */
    private $behatRunner;

    /**
     * @BeforeScenario
     */
    public function bootstrap()
    {
        $this->behatRunner = new BehatRunner(sprintf('%s/%s/', sys_get_temp_dir(), uniqid('ZfTestCaseExtension')));
    }

    /**
     * @AfterScenario
     */
    public function removeWorkDir()
    {
        $this->behatRunner->removeWorkspace();
    }

    /**
     * Creates a file with specified name and context in current workdir.
     *
     * @Given /^(?:there is )?a file named "([^"]*)" with:$/
     *
     * @param   string $filename name of the file (relative path)
     * @param   PyStringNode $content PyString string instance
     */
    public function aFileNamedWith($filename, PyStringNode $content)
    {
        $this->behatRunner->addFile($filename, $content->getRaw());
    }

    /**
     * @Given /^a behat configuration:$/
     */
    public function givenBehatConfiguration(PyStringNode $content)
    {
        $this->behatRunner->addFile('behat.yml', $content->getRaw());
    }

    /**
     * @Given /^(?:|an?|the )(?:|context |class |feature |.*)file "(?P<fileName>[^"]*)" contains:$/
     */
    public function aContextFileNamedWith($fileName, PyStringNode $content)
    {
        $this->behatRunner->addFile($fileName, $content->getRaw());
    }

    /**
     * @When /^I run behat$/
     */
    public function iRunBehat()
    {
        $this->behatRunner->run();
    }

    /**
     * @Then /^it should pass$/
     */
    public function itShouldPass()
    {
        try {
            Assert::assertSame(0, $this->behatRunner->getExitCode(), 'Command terminated with an error');
            Assert::assertStringNotMatchesFormat('PHP Warning:', $this->behatRunner->getFullOutput());
            Assert::assertStringNotMatchesFormat('PHP Notice:', $this->behatRunner->getFullOutput());
        } catch (\Exception $e) {
            echo $this->behatRunner->getFullOutput();

            throw $e;
        }
    }

    /**
     * @Then /^it should fail$/
     */
    public function itShouldFail()
    {
        try {
            Assert::assertNotSame(0, $this->behatRunner->getExitCode(), 'Command succeeded');
        } catch (\Exception $e) {
            echo $this->behatRunner->getFullOutput();

            throw $e;
        }
    }

    /**
     * @Then /^it should pass with:$/
     */
    public function itShouldPassWith(PyStringNode $expectedOutput)
    {
        $this->itShouldPass();

        foreach ($expectedOutput->getStrings() as $expectedLine) {
            Assert::assertRegExp('/' . preg_quote($expectedLine, '/') . '/sm', $this->behatRunner->getFullOutput());
        }
    }

    /**
     * @Then /^it should fail with:$/
     */
    public function itShouldFailWith(PyStringNode $expectedOutput)
    {
        $this->itShouldFail();

        foreach ($expectedOutput->getStrings() as $expectedLine) {
            Assert::assertRegExp('/' . preg_quote($expectedLine, '/') . '/sm', $this->behatRunner->getFullOutput());
        }
    }

    /**
     * @param string $path
     */
    public function givenBehatProject($path)
    {
        $this->behatRunner->addDirectory($path);
    }

    /**
     * @return string
     */
    public function getFullOutput()
    {
        return $this->behatRunner->getFullOutput();
    }
}