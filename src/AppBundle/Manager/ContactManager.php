<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Contact;
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
     * @param $username
     * @param $email
     * @param $password
     * @param $firstName
     * @param $lastName
     * @param $phoneNumber
     * @param $birthDate
     * @param $city
     * @return Contact
     */
    public function createUser($email, $firstName, $lastName, $phoneNumber,$kinship)
    {
        $contact = new Contact();
        $contact->setEmail($email);
        $contact->setFirstName($firstName);
        $contact->setLastName($lastName);
        $contact->setPhoneNumber($phoneNumber);
        $contact->setKinship($kinship);
        try {
            $this->em->persist($contact);
            $this->em->flush();
        } catch (\Exception $e) {
//            dump($e->getMessage());
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
}
