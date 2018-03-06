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

        $authManager = $this->get('nouestil.user');

        foreach ($menus as $key => $menu) {
            if (!$authManager->isGranted('ROLE_ADMIN',$this->getUser()) && $menu['scope'] == "admin") {
                unset($menus[$key]);
            }

            if (!$authManager->isGranted('ROLE_USER',$this->getUser()) && $menu['scope'] == "user") {
                unset($menus[$key]);
            }
            if(isset($menu['items'])){
                foreach($menu["items"] as $subKey => $subMenu){
                    if(isset($subMenu['scope'])){
                        if (!$authManager->isGranted('ROLE_ADMIN',$this->getUser()) && $this->getUser()->getGroup()->getCode()!="pwp" && $subMenu['scope'] == "pwp") {
                            unset($menus[$key]['items'][$subKey]);
                        }
                        if (!$this->getUser()->getTimeTracking() && $subMenu['scope'] == "time-tracking") {
                            unset($menus[$key]['items'][$subKey]);
                        }
                    }

                }
            }

        }


        // Parent route
        $parentRequest = $this->container->get('request_stack')->getParentRequest();

        // Return
        return $this->render('PortailMkgBundle:Partials:sidebar.menu.html.twig', ['menu' => $menus, 'parentRequest' => $parentRequest]);

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
        return $this->render('PortailMkgBundle:Partials:topbar.menu.html.twig', ['config' => $params]);

    }

}
