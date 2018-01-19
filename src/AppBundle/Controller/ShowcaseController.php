<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ShowcaseController extends Controller
{
    public function indexAction(Request $request)
    {
        $parametre = "laurene est très puissante";
        return $this->render('AppBundle:Showcase:index.html.twig', [
            'parametre' => $parametre
        ]);
    }

    public function galleryAction(Request $request)
    {
        $parametre = "laurene est très puissante";
        return $this->render('AppBundle:Showcase:gallery.html.twig', [
            'parametre' => $parametre
        ]);
    }

    public function coursesAction(Request $request)
    {
        $parametre = "laurene est très puissante";
        return $this->render('AppBundle:Showcase:courses.html.twig', [
            'parametre' => $parametre
        ]);
    }

    public function contactAction(Request $request)
    {
        $parametre = "laurene est très puissante";
        return $this->render('AppBundle:Showcase:contact.html.twig', [
            'parametre' => $parametre
        ]);
    }

}
