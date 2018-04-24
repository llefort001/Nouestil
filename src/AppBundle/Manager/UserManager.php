<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Contact;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @return bool
     */
    public function isAdmin($user)
    {
        return (in_array('ROLE_ADMIN', $user->getRoles())) ? true : false;
    }


    public function isProf($user)
    {
        return (in_array('ROLE_PROF', $user->getRoles())) ? true : false;
    }
    /**
     * @return bool
     */
    public function isUser($user)
    {
        return (in_array('ROLE_USER', $user->getRoles())) ? true : false;
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

        try {
            $user = $this->em
                ->getRepository('AppBundle:User')
                ->findOneById($id);
        } catch (ORMException $e) {
            throw new NotFoundHttpException('No user');
        }
        return $user;

    }


    public function getUsersLike($username)
    {
        try {
            $user = $this->em
                ->getRepository('AppBundle:User')
                ->findUsersLike($username);
        } catch (ORMException $e) {
            throw new NotFoundHttpException('No user');
        }
        return $user;
    }

    public function getUserByUsername($username)
    {
        try {
            $user = $this->em
                ->getRepository('AppBundle:User')
                ->findOneByUsername($username);
        } catch (ORMException $e) {
            throw new NotFoundHttpException('No user');
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
        $user->setEnabled(true);
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
        if (!$user->isEnabled()) {
            $user->setEnabled(true);
        }
        $this->em->persist($user);
        $this->em->flush();
    }


    public function unlinkContact($userId, $contactId)
    {
        $this->getUser($userId)->removeContact($contactId);
        $this->em->flush();

    }

    public function getNotUsersCourse($courseId){
        $results= $this->em
            ->getRepository('AppBundle:User')
            ->queryNotCourseUsers($courseId);
        foreach ($results[0] as $userInscrit){
            foreach ($results[1] as $index => $allUsers){
                if ($userInscrit == $allUsers){
                    unset($results[1][$index]);
                    break;
                }
            }
        }
        return $results[1];
    }
}
