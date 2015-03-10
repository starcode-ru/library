<?php

namespace Acme\LibraryBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class DefaultController extends FOSRestController
{
    public function indexAction()
    {
        return $this->render('LibraryBundle:Default:index.html.twig');
    }
}
