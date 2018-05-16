<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ShowcaseController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:Showcase:index.html.twig');

    }

    public function stylesAction()
    {
        return $this->render('AppBundle:Showcase:styles.html.twig');

    }

    public function contactAction()
    {
        return $this->render('AppBundle:Showcase:contact.html.twig');

    }

    public function aboutAction()
    {
        return $this->render('AppBundle:Showcase:about.html.twig');
    }


    public function timetableAction()
    {
        return $this->render('AppBundle:Showcase:timetable.html.twig');
    }

    public function privacyAction()
    {
        return $this->render('AppBundle:Showcase:privacy.html.twig');
    }
}
