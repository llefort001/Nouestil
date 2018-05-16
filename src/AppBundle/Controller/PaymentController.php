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
        $this->denyAccessUnlessGranted('ROLE_ADMIN', 'Access denied', 'You cannot edit this item.');

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

    public function updatePaymentAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', 'Access denied', 'You cannot edit this item.');
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $paymentManager= $this->get('nouestil.payment');
            $paymentManager->updatePayment($data['id'],$data['title'],$data['category'], $data['amount'], $data['datetime'], $data['method'], $data['note']);

            //dump($data['note']); die;
        }

        $this->addFlash('success', 'Le paiement a bien été modifié');
        return $this->redirect($this->generateUrl('payments'));
    }

    public function deletePaymentAction($paymentId)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', 'Access denied', 'You cannot edit this item.');

        $paymentManager = $this->get('nouestil.payment');
        $paymentToDelete = $paymentManager->getPayment($paymentId);
        $paymentManager->deletePayment($paymentToDelete);

        // on redirige l'administrateur vers la liste des paiements si aucune erreur
        $this->addFlash('success', 'Le payment a bien été supprimé');
        return $this->redirect($this->generateUrl("payments"));

    }
}