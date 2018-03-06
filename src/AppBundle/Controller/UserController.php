<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\User;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all Users.
     *
     */
//    public function indexAction() // C'est comme ça qu'on faisait avant l'utilisation du userManager maison
//    {
//        $userManager = $this->get('fos_user.user_manager');
//        $entityManager = $this->getDoctrine()->getManager();
//        $users = $userManager->findUsers();
//        $groups = $entityManager->getRepository('AppBundle:Group')->findAll();
//        return $this->render('AppBundle:Users:users.html.twig', array(
//            'users' => $users,
//            'groups' => $groups,
//        ));
//    }

    public function indexAction()
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $roles = $this->container->getParameter('roles');
        $groups = $entityManager->getRepository('AppBundle:Group')->findAll();
        $users = $this->get('nouestil.user');
        return $this->render('AppBundle:Users:users.html.twig', array('users' => $users->getUsersList(), "roles" => $roles, "groups" => $groups, "currentUser" => $user));

    }

    public function deleteUserAction($userId)
    {
        $userManager = $this->get('nouestil.user');
        $userToDelete = $userManager->getUser($userId);
        if ($userToDelete == $this->getUser()) {
            $this->addFlash('Erreur', 'Impossible de supprimer l\'utilisateur actuellement connecté.');
        } else {
            $userManager->deleteUser($userToDelete);
        }
        return $this->redirect($this->generateUrl('users'));

    }

    public function updateGroupUserAction($userId, $group)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userManager = $this->get('nouestil.user');
        $userToUpdate = $userManager->getUser($userId);

        if ($userToUpdate instanceof User) {
            $groupToUpdate = $entityManager->getRepository('AppBundle:Group')->find(array("id" => $group));
            $userToUpdate->setGroup($groupToUpdate);
            $groupToUpdate->addUserGroup($userToUpdate);
            $entityManager->flush();

        }
        return $this->redirect($this->generateUrl('users'));
    }

    public function updateUserAction(Request $request)
    {

        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $entityManager = $this->getDoctrine()->getManager();
            $userToUpdate = $entityManager->getRepository('AppBundle:User')->find(array("id" => $data['id']));

//            $userToUpdate->setRoticoin($data['roticoin']);
            $entityManager->flush();


        }
        return $this->redirect($this->generateUrl('users'));
    }
    public function createUserAction(Request $request)
    {
        $formRegistration = $this->createForm(UserType::class);

        if ($request->isMethod('POST')) {

            // On récupère le gestionnaire d'entités
            $em = $this->getDoctrine()->getManager();

            $formRegistration->submit($request->request->get($formRegistration->getName()));
            // Enregistrer après soumission du formulaire les données dans l'objet $user

            if ($formRegistration->isSubmitted() && $formRegistration->isValid()) {



                $userData = $formRegistration->getData();
                dump($request);
                dump($userData);die;
                $this->get('nouestil.user')->save($userData);


                // on redirige l'administrateur vers la liste des clients si aucune erreur
                $this->addFlash('Success', 'L\'utilisateur a bien été enregistré');
                return $this->redirect($this->generateUrl("users"));
            }
        }


        return $this->render('AppBundle:Users:create.html.twig', array(
            'formRegistration' => $formRegistration->createView(),
        ));
    }

}