<?php

declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\Behat;

use App\Course\Infrastructure\Persistence\Doctrine\DataFixtures\CourseFixtures;
use App\Course\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use App\Tests\Shared\Infrastructure\Fixtures\LoadFixtures;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Routing\RouterInterface;

class SharedContext extends RawMinkContext
{
    use LoadFixtures;

    private Session $session;
    private RouterInterface $router;
    private EntityManagerInterface $entityManager;

    public function __construct(Session $minkSession, RouterInterface $router, EntityManagerInterface $entityManager)
    {
        $this->session = $minkSession;
        $this->router = $router;
        $this->entityManager = $entityManager;
    }

    /**
     * @Given /^the data of the fixtures is loaded$/
     */
    public function theDataOfTheFixturesIsLoaded()
    {
        $this->executeFixtures($this->entityManager, new CourseFixtures(), new UserFixtures());
    }

    /**
     * @Given /^I have a token to enter access to the system$/
     */
    public function iHaveATokenToEnterAccessToTheSystem()
    {
        $this->session->
            getDriver()->
            getClient()->
            setServerParameter(
                'HTTP_X-AUTH-TOKEN',
                'eyJhbGciOiJkaXIiLCJlbmMiOiJBMjU2R0NNIiwiemlwIjoiREVGIn0..RDn-WnSMJOSJi7cN.05c4S6csHFt9Szawt5u8gnCIOysyakz5zZLI.tgxBHwroAzVZoNMel6j5aA'
            );
    }

    /**
     * @Given /^I don't have a token to enter access to the system$/
     */
    public function iDonTHaveATokenToEnterAccessToTheSystem()
    {
        $this->session->getDriver()->getClient()->setServerParameter('HTTP_X-AUTH-TOKEN', '');
    }

    /**
     * @Given I send a :method request to :url
     */
    public function iSendAGetRequestTo($method, $url)
    {
        $this->session->getDriver()->getClient()->request($method, $url);
    }

    /**
     * @Then the response content should be:
     */
    public function theResponseContentShouldBe(PyStringNode $expectedResponse)
    {
        $expected = $this->sanitizeOutput($expectedResponse->getRaw());
        $actual = $this->sanitizeOutput($this->session->getPage()->getContent());
        if ($expected !== $actual) {
            throw new RuntimeException(
                sprintf("The outputs does not match!\n\n-- Expected:\n%s\n\n-- Actual:\n%s", $expected, $actual)
            );
        }
    }

    private function sanitizeOutput(string $output): false|string
    {
        return json_encode(json_decode(trim($output), true));
    }
}
