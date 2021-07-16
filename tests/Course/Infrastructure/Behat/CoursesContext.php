<?php

declare(strict_types=1);

namespace App\Tests\Course\Infrastructure\Behat;

use Behat\MinkExtension\Context\RawMinkContext;

class CoursesContext extends RawMinkContext
{
    /**
     * @Given /^I have a browser prepared$/
     */
    public function iHaveABrowserPrepared()
    {
    }
}
