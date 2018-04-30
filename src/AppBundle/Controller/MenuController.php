<?php
/**
 * Created by PhpStorm.
 * User: Lucas Lefort
 * Date: 06/03/2018
 * Time: 15:08
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function leftMenuAction(Request $request)
    {

        // Get menus
        $menus = $this->container->getParameter("leftMenu");

        $userManager = $this->get('nouestil.user');
        foreach ($menus as $key => $menu) {
            if (!$userManager->isAdmin($this->getUser()) && $menu['scope'] == "admin") {
                unset($menus[$key]);
            }

            if (!$userManager->isUser($this->getUser()) && $menu['scope'] == "user") {
                unset($menus[$key]);
            }
        }


        // Parent route
        $parentRequest = $this->container->get('request_stack')->getParentRequest();

        // Return
        return $this->render('AppBundle:Partials:left.menu.html.twig', ['menu' => $menus, 'parentRequest' => $parentRequest]);

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function topMenuAction(Request $request)
    {

        // Get menus
        $params = $this->container->getParameter("topbar");

        // Return
        return $this->render('AppBundle:Partials:top.menu.html.twig', ['config' => $params]);

    }

}
