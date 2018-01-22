<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $phoneNumber;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $publicNote;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $privateNote;

    /**
     * @ORM\Column(type="date")
     */
    protected $birthDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $address;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="users", cascade={"persist"})
     */
    protected $group;

    /**
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="users", cascade={"persist"})
     */
    protected $contact;

    /**
     * @ORM\OneToMany(targetEntity="Payment", mappedBy="user", cascade={"persist"})
     */
    protected $payments;

    /**
     * @ORM\ManyToMany(targetEntity="Course", inversedBy="users", cascade={"persist"})
     */
    protected $courses;


    public function __construct()
    {
        parent::__construct();
// Add role
        $this->courses = new ArrayCollection();
        $this->addRole("ROLE_USER");    }

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param mixed $payments
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getPublicNote()
    {
        return $this->publicNote;
    }

    /**
     * @param mixed $note
     */
    public function setPublicNote($note)
    {
        $this->publicNote = $note;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getPrivateNote()
    {
        return $this->privateNote;
    }

    /**
     * @param mixed $privateNote
     */
    public function setPrivateNote($privateNote)
    {
        $this->privateNote = $privateNote;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param mixed $courses
     */
    public function setCourses($courses)
    {
        $this->courses = $courses;
    }


}