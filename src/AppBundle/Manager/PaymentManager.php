<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Payment;
use Doctrine\ORM\EntityManager;

/**
 * Class UserManager
 * @package AppBundle\Manager
 */
class PaymentManager
{

    protected $amount;
    protected $user;
    protected $method;
    protected $datetime;
    protected $note;
    protected $em;

    /**
     * UserManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;

    }

    /**
     * @param Payment $payment
     */
    public function deletePayment(Payment $payment)
    {
        $this->em->remove($payment);
        $this->em->flush();
    }

    /**
     * @return array
     */
    public function getPaymentList()
    {

        $payments = $this->em
            ->getRepository('AppBundle:Payment')
            ->findAll();

        return $payments;

    }

    /**
     * @param $id
     * @return mixed
     */
    public function getPayment($id)
    {

        $payment = $this->em
            ->getRepository('AppBundle:Payment')
            ->findOneById($id);

        if (!$payment instanceof Payment) {
            throw $this->createNotFoundException(
                'Pas de paiements '
            );
        }
        return $payment;

    }

    public function getPaymentListQuery()
    {
        $payment = $this->em
            ->getRepository('AppBundle:Payment')
            ->findAll();
        return $payment;
    }
  
    /**
     * @param $usersList
     * @return array
     */
    public function filterPaymentsList($paymentsList)
    {
        if (isset($paymentsList) && sizeof($paymentsList) > 0) {
            $usersArray = array();
            foreach ($paymentsList as $payment) {
                $usersArray[] = array(
                    "id" => $payment->getId());
            }
            return $usersArray;
        }
        return array();
    }


    public function save(Payment $payment){

        if (!$payment instanceof Payment) {
            throw $this->createNotFoundException(
                'Pas de paiement '
            );
        }

        $this->em->persist($payment);
        $this->em->flush();
    }


    public function updatePayment($id, $amount, $datetime, $method, $note){

        $payment = $this->em
            ->getRepository('AppBundle:Payment')
            ->findOneById($id);
        $payment->setAmount($amount);
        $payment->setMethod($method);
        $payment->setNote($note);

        $payment->setDateTime( new \DateTime($datetime) );

        try{
            $this->em->persist($payment);
            $this->em->flush();
        }catch(\exception $e){
            $e->getMessage();
        }
        return $payment;
    }
}

