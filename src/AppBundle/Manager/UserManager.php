<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Contact;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class UserManager
 * @package AppBundle\Manager
 */
class UserManager
{

    protected $login;
    protected $username;
    protected $firstname;
    protected $lastname;
    protected $phoneNumber;
    protected $roles;
    protected $group;
    protected $payments;
    protected $contacts;
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
     * @return array
     */
    public function getRoles()
    {
        $roles = array();
        if (is_array($this->roles) && sizeof($this->roles) > 0) {
            foreach ($this->roles as $role) {
                $roles[] = $role->name;
            }
        }

        return $roles;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return (in_array('admin', $this->getRoles())) ? true : false;
    }


    /**
     * @return bool
     */
    public function getLogin()
    {
        return ($this->login !== NULL) ? $this->login : 'Unknown user';
    }

    /**
     * @param $login
     * @return bool
     */
    public function userEmailRegistered($login)
    {

        // check if the user have already register his account
        $user = $this->em
            ->getRepository('AppBundle:User')
            ->findByEmail($login);
        return (sizeof($user) == 0) ? false : true;

    }

    public function deleteUser(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    /**
     * @param $username
     * @return bool
     */
    public function userUsernameRegistered($username)
    {

        // check if the user have already register his account
        $user = $this->em
            ->getRepository('AppBundle:User')
            ->findByUsername($username);
        return (sizeof($user) == 0) ? false : true;

    }

    /**
     * @return array
     */
    public function getUsersList()
    {

        $user = $this->em
            ->getRepository('AppBundle:User')
            ->findAll();

        return $user;

    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUser($id)
    {

        $user = $this->em
            ->getRepository('AppBundle:User')
            ->findOneById($id);

        if (!$user instanceof User) {
            throw $this->createNotFoundException(
                'Pas d\'utilisateurs '
            );
        }
        return $user;

    }

    public function getUserByUsername($username)
    {

        $user = $this->em
            ->getRepository('AppBundle:User')
            ->findOneByUsername($username);

        if (!$user instanceof User) {
            throw $this->createNotFoundException(
                'Pas d\'utilisateurs '
            );
        }
        return $user;

    }

    /**
     * @param $usersList
     * @return array
     */
    public function filterUsersList($usersList)
    {
        if (isset($usersList) && sizeof($usersList) > 0) {
            $usersArray = array();
            foreach ($usersList as $user) {
                $usersArray[] = array(
                    "id" => $user->getId(),
                    "name" => $user->getFirstName(),
                    "lastname" => $user->getLastName());
            }
            return $usersArray;
        }
        return array();
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
     * @return User
     */
    public function createUser($username, $email, $password, $firstName, $lastName, $phoneNumber, $birthDate, $city)
    {
        $user = new User();
        $user->setEmail($email);
        $user->setEmailCanonical($email);
        $user->setPlainPassword($password);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPhoneNumber($phoneNumber);
        $user->setBirthDate($birthDate);
        $user->setcity($city);
        $user->setUsername($username);
        $user->setUsernameCanonical($username);
        $user->setEnabled(1);
        try {
            $this->em->persist($user);
            $this->em->flush();
        } catch (\Exception $e) {
//            dump($e->getMessage());
        }
        return $user;
    }

    public function save(User $user){

        if (!$user instanceof User) {
            throw $this->createNotFoundException(
                'Pas d\'utilisateurs '
            );
        }

        $this->em->persist($user);
        $this->em->flush();
    }


    /**
     * @return array
     */
    public function getContacts()
    {
        $contacts = array();
        if (is_array($this->contacts) && sizeof($this->contacts) > 0) {
            foreach ($this->contacts as $contact) {
                $users[] = $contact->name;
            }
        }

        return $contacts;
    }

    /**
     * @return array
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

    public function unlinkContact($userId, $contactId){
        $this->getUser($userId)->removeContact($contactId);
        $this->em->flush();

    }
}
