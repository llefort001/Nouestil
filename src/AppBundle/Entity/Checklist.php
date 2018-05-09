<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Checklist
 *
 * @ORM\Table(name="checklist")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChecklistRepository")
 */
class Checklist
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
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="checklists", cascade={"persist"}, fetch="EAGER")
     */
    protected $course;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="checklistsPresents", cascade= {"persist"},fetch="EAGER")
     * @ORM\JoinTable(name="user_checklist_present")
     */
    protected $usersPresents;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="checklistsAbsents", cascade={"persist"},fetch="EAGER")
     * @ORM\JoinTable(name="user_checklist_absent")
     */
    protected $usersAbsents;

    public function __construct(){
        $this->usersPresents= new ArrayCollection();
        $this->usersAbsents= new ArrayCollection();
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
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Checklist
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param User $user
     */
    public function addUserPresent(User $user)
    {
        $this->usersPresents[]= $user;
    }

    public function getUsersPresents(){
        return $this->usersPresents;
    }

    public function getUsersAbsents(){
        return $this->usersAbsents;
    }

    /**
     * @param User $user
     */
    public function addUserAbsent(User $user)
    {
        $this->usersAbsents[]= $user;
    }

    /**
     * @param User $user
     */
    public function removeUserAbsent(User $user)
    {
        $this->usersAbsents->removeElement($user);
    }

    /**
     * @param User $user
     */
    public function removeUserPresent(User $user)
    {
        $this->usersPresents->removeElement($user);
    }

    public function refresh(){
        $this->usersAbsents->clear();
        $this->usersPresents->clear();
    }

    /**
     * @param $course
     */
    public function setCourse($course){
        $this->course = $course;
    }

    /**
     * @return mixed
     */
    public function getCourse(){
        return $this->course;
    }
}

