<?php

namespace Acme\LibraryBundle\Features\Context;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\WebApiExtension\Context\WebApiContext;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends WebApiContext implements SnippetAcceptingContext
{

}
