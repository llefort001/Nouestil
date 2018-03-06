<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Course
 *
 * @ORM\Table(name="course")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourseRepository")
 */
class Course
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="session", type="string", length=255, unique=true)
     */
    protected $session;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="coursesTeach")
     * @return User
     */
    protected $userTeach;

    /** @ORM\ManyToMany(targetEntity="User", mappedBy="courses") */
    protected $users;

    /** @ORM\OneToMany(targetEntity="Checklist", mappedBy="course") */
    protected $checklists;

    public function __construct() {
        $this->users = new ArrayCollection();
        $this->checklists = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Course
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers(User $users)
    {
        $this->users[] = $users;
    }

    /**
     * @param $userTeach
     * @return $this
     */
    public function setUserTeach($userTeach)
    {
        $this->userTeach = $userTeach;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserTeach()
    {
        return $this->userTeach;
    }

    /**
     * @return mixed
     */
    public function getChecklists()
    {
        return $this->checklists;
    }

    /**
     * @param mixed $checklists
     */
    public function setChecklists($checklists)
    {
        $this->checklists[] = $checklists;
    }

    /**
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param string $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

}

