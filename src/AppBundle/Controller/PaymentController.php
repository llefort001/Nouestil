<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Payment;

class PaymentController extends Controller
{
    /**
     * Lists all Payments.
     *
     */
    public function indexAction()
    {
//        $userManager = $this->get('fos_user.user_manager');
        $entityManager = $this->getDoctrine()->getManager();
//        $users = $userManager->findUsers();
        $payments = $entityManager->getRepository('AppBundle:Payment')->findAll();
        return $this->render('AppBundle:Payments:payments.html.twig', array(
//            'users' => $users,
            'payments' => $payments,
        ));
    }

//    public function withdrawAction($userId)
//    {
//        $entityManager = $this->getDoctrine()->getManager();
//        $userToWithdraw = $entityManager->getRepository('AppBundle:User')->find(array("id" => $userId));
//
//        if ($userToWithdraw instanceof User) {
//            $old_roticoin = $userToWithdraw->getRoticoin();
//            $value = 20000;
//            $new_roticoin = $old_roticoin - $value;
//            if ($new_roticoin < 0) {
//                $this->addFlash('Erreur', 'Impossible de retirer, solde insuffisant.');
//            } else {
//                $userToWithdraw->setRoticoin($new_roticoin);
//                $entityManager->flush();
//                //TODO:Actions a faire suite a un retrait
//            }
//        }
//        return $this->redirect($this->generateUrl('base_users'));
//
//
//    }
//
//    public function updateGroupUserAction($userId, $group)
//    {
//        $entityManager = $this->getDoctrine()->getManager();
//        $userToUpdate = $entityManager->getRepository('AppBundle:User')->find(array("id" => $userId));
//
//        if ($userToUpdate instanceof User) {
//            $groupToUpdate = $entityManager->getRepository('AppBundle:Group')->find(array("id" => $group));
//            $userToUpdate->setGroup($groupToUpdate);
//            $groupToUpdate->addUserGroup($userToUpdate);
//            $entityManager->flush();
//
//        }
//        return $this->redirect($this->generateUrl('base_users'));
//    }
//
//    public function updateUserAction(Request $request)
//    {
//
//        if ($request->isMethod('POST')) {
//            $data = $request->request->all();
//
//            $entityManager = $this->getDoctrine()->getManager();
//            $userToUpdate = $entityManager->getRepository('AppBundle:User')->find(array("id" => $data['id']));
//
//            $userToUpdate->setRoticoin($data['roticoin']);
//            $entityManager->flush();
//
//
//        }
//        return $this->redirect($this->generateUrl('base_users'));
//    }


}