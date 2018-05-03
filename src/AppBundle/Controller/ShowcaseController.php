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

    public function stylesAction(Request $request)
    {
        $parametre = "laurene est très puissante";
        return $this->render('AppBundle:Showcase:styles.html.twig', [
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

    public function aboutAction(Request $request)
    {
        $parametre = "laurene est très puissante";
        return $this->render('AppBundle:Showcase:about.html.twig', [
            'parametre' => $parametre
        ]);
    }

    public function timetableAction(Request $request)
    {
        $parametre = "laurene est très puissante";
        return $this->render('AppBundle:Showcase:timetable.html.twig', [
            'parametre' => $parametre
        ]);
    }
}
