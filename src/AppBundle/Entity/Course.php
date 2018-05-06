<?php

namespace AppBundle\Entity;

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
     * @ORM\Column(name="style", type="string", length=255)
     */
    protected $style;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    protected $category;

    /**
     * @var string
     *
     * @ORM\Column(name="timeslot", type="string", length=255)
     */
    protected $timeslot;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="coursesTeach")
     * @return User
     */
    protected $userTeach;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="courses", cascade= {"persist"},fetch="EAGER")
     * @ORM\JoinTable(name="user_course")
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Checklist", mappedBy="course", cascade= {"persist"}, fetch="EAGER")
     */
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
     * Set style
     *
     * @param string $style
     *
     * @return Course
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->users[]= $user;
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
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
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getTimeslot()
    {
        return $this->timeslot;
    }

    /**
     * @param string $timeslot
     */
    public function setTimeslot($timeslot)
    {
        $this->timeslot = $timeslot;
    }

}

