<?php

namespace AppBundle\Controller;

use AppBundle\Form\PaymentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

use AppBundle\Entity\Payment;

class PaymentController extends Controller
{
    /**
     * Lists all Payments.
     *
     */
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $entityManager = $this->getDoctrine()->getManager();
        $users = $userManager->findUsers();
        $payments = $entityManager->getRepository('AppBundle:Payment')->findAll();
        return $this->render('AppBundle:Payments:payments.html.twig', array(
            'users' => $users,
            'payments' => $payments,
        ));
    }


    public function createPaymentAction(Request $request)
    {
        $formCreatePayment = $this->createForm(PaymentType::class);

        if ($request->isMethod('POST')) {
            $formCreatePayment->submit($request->request->get($formCreatePayment->getName()));
            // Enregistrer après soumission du formulaire les données dans l'objet $user

            if ($formCreatePayment->isSubmitted() && $formCreatePayment->isValid()) {

                $paymentData = $formCreatePayment->getData();
                //dump($paymentData);die;
                $this->get('nouestil.payment')->save($paymentData);

                // on redirige l'administrateur vers la liste des clients si aucune erreur
                $this->addFlash('success', 'Les payments ont bien été enregistrés');
                return $this->redirect($this->generateUrl("payments"));
            }
        }

        return $this->render('AppBundle:Payments:create.html.twig', array(
            'formCreatePayment' => $formCreatePayment->createView(),
        ));
    }

    public function deletePaymentAction($paymentId)
    {
        $paymentManager = $this->get('nouestil.payment');
        $paymentToDelete = $paymentManager->getPayment($paymentId);
        $paymentManager->deletePayment($paymentToDelete);

        // on redirige l'administrateur vers la liste des clients si aucune erreur
        $this->addFlash('Success', 'Les payments ont bien été supprimés');
        return $this->redirect($this->generateUrl("payments"));

    }
    public function updatePaymentAction(Request $request)
    {

        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $payment= $this->get('nouestil.payment');
            $payment->updatePayment($data['id'], $data['amount'], $data['datetime'], $data['method'], $data['note']);

            //dump($data['note']);die;
        }

        $this->addFlash('Success', 'Les payments ont bien été modifiés');
        return $this->redirect($this->generateUrl('payments'));
    }


    public function updateUserPaymentAction($paymentId, $user)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $paymentManager = $this->get('nouestil.payment');
        $paymentToUpdate = $paymentManager->getPayment($paymentId);

        if ($paymentToUpdate instanceof Payment) {
            $userToUpdate = $entityManager->getRepository('AppBundle:User')->find(array("id" => $user));
            $paymentToUpdate->setUser($userToUpdate);
            $userToUpdate->addPaymentUser($paymentToUpdate);
            $entityManager->flush();
        }
        return $this->redirect($this->generateUrl('payments'));
    }

    public function generateCsvAction(){

        //Connexion à la base de données avec le service database_connection
        $paymentManager = $this->get('nouestil.payment');

        //Requête
        //$results = $paymentManager->query("SELECT p.id, p.user_id, p.amount, p.datetime, p.method, p.comment FROM payment AS p");
        $results = $paymentManager->getPaymentListQuery($this->getUser());

        //dump($results);die;

        $response = new StreamedResponse();
        $response->setCallback(function() use($results){

            $handle = fopen('php://output', 'w+');

            //Nom des colonnes du CSV
            fputcsv($handle, array('ID',
                                    'Utilisateur',
                                    'Montant',
                                    'Methode',
                                    'Commentaire'
                    ),';');

            //Champs
            while( $row = $results->fetch() ){
                fputcsv($handle, array($row['id'],
                                    $row['utilisateur'],
                                    $row['montant'],
                                    $row['methode'],
                                    $row['commentaire']
                    ),';' );
            }
            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');

        return $response;
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