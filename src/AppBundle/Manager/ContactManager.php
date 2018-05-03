<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Contact;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

/**
 * Class ContactManager
 * @package AppBundle\Manager
 */
class ContactManager
{

    protected $firstname;
    protected $lastname;
    protected $email;
    protected $phoneNumber;
    protected $kinship;
    protected $users;
    protected $em;

    /**
     * ContactManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;

    }


    /**
     * @param $id
     * @return mixed
     */
    public function getContact($id)
    {

        $contact = $this->em
            ->getRepository('AppBundle:Contact')
            ->findOneById($id);

        if (!$contact instanceof Contact) {
            throw $this->createNotFoundException(
                'Pas un contact '
            );
        }
        return $contact;

    }

    /**
     * @return array
     */
    public function getUsers()
    {
        $users = array();
        if (is_array($this->users) && sizeof($this->users) > 0) {
            foreach ($this->users as $user) {
                $users[] = $user->name;
            }
        }

        return $users;
    }

    public function deleteContact(Contact $contact)
    {
        $this->em->remove($contact);
        $this->em->flush();
    }

    /**
     * @return array
     */
    public function getContactsList()
    {

        $contacts = $this->em
            ->getRepository('AppBundle:Contact')
            ->findAll();

        return $contacts;

    }

    /**
     * @param $email
     * @param $firstName
     * @param $lastName
     * @param $phoneNumber
     * @param $kinship
     * @param User $user
     * @return Contact
     */
    public function createContact($email, $firstName, $lastName, $phoneNumber,$kinship,User $user)
    {
        $contact = new Contact();
        $contact->setEmail($email);
        $contact->setFirstName($firstName);
        $contact->setLastName($lastName);
        $contact->setPhoneNumber($phoneNumber);
        $contact->setKinship($kinship);
        $user->addContact($contact);

        try {
            dump($contact);
            $this->em->persist($contact);
            $this->em->persist($user);

            $this->em->flush();
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
        return $contact;
    }

    public function updateContact($id, $lastname, $firstname, $phoneNumber, $email){

        $contact = $this->em
            ->getRepository('AppBundle:Contact')
            ->findOneById($id);
        $contact->setFirstname($firstname);
        $contact->setLastname($lastname);
        $contact->setPhoneNumber($phoneNumber);
        $contact->setEmail($email);

        try{
            $this->em->persist($contact);
            $this->em->flush();
        }catch(\exception $e){
            $e->getMessage();
        }
        return $contact;
    }

    public function save(Contact $contact){

        if (!$contact instanceof Contact) {
            throw $this->createNotFoundException(
                'Ce n\'est pas un contact '
            );
        }

        $this->em->persist($contact);
        $this->em->flush();
    }

    /**
     * @return Contact
     */
    public function getContactById($id)
    {
        $contact = $this->em
            ->getRepository('AppBundle:Contact')
            ->findOneById($id);

        if (!$contact instanceof Contact) {
            throw $this->createNotFoundException(
                'N\'est pas un contact'
            );
        }
        return $contact;
    }
}
