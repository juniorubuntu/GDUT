<?php

namespace DemandeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DemandeBundle:Default:index.html.twig');
    }
}
