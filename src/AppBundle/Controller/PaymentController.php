<?php

namespace AppBundle\Controller;

use AppBundle\Form\PaymentType;
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

        $paymentManager = $this->get('nouestil.payment');
        $payments = $paymentManager->getPaymentList();
        return $this->render('AppBundle:Payments:payments.html.twig', array(
            'payments' => $payments,
        ));
    }

  public function createPaymentAction(Request $request)
    {
        $formCreatePayment = $this->createForm(PaymentType::class);

        if ($request->isMethod('POST')) {

            $formCreatePayment->submit($request->request->get($formCreatePayment->getName()));
            // Enregistrer après soumission du formulaire les données dans l'objet payment

            if ($formCreatePayment->isSubmitted() && $formCreatePayment->isValid()) {


                $paymentData = $formCreatePayment->getData();
                $this->get('nouestil.payment')->save($paymentData);


                // on redirige l'administrateur vers la liste des clients si aucune erreur
                $this->addFlash('success', 'Le paiement a bien été enregistré');
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

        // on redirige l'administrateur vers la liste des paiements si aucune erreur
        $this->addFlash('success', 'Les payments ont bien été supprimés');
        return $this->redirect($this->generateUrl("payments"));

    }
    public function updatePaymentAction(Request $request)
    {

        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $payment= $this->get('nouestil.payment');
            $payment->updatePayment($data['id'], $data['amount'], $data['datetime'], $data['method']);
        }

        $this->addFlash('success', 'Le paieent a bien été modifié');
        return $this->redirect($this->generateUrl('payments'));
    }


//    public function updateUserPaymentAction($paymentId, $user)
//    {
//        $entityManager = $this->getDoctrine()->getManager();
//        $paymentManager = $this->get('nouestil.payment');
//        $paymentToUpdate = $paymentManager->getPayment($paymentId);
//
//        if ($paymentToUpdate instanceof Payment) {
//            $userToUpdate = $entityManager->getRepository('AppBundle:User')->find(array("id" => $user));
//            $paymentToUpdate->setUser($userToUpdate);
//            $userToUpdate->addPaymentUser($paymentToUpdate);
//            $entityManager->flush();
//        }
//        return $this->redirect($this->generateUrl('payments'));
//    }

}