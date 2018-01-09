<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 *
 * @ORM\Table(name="user_group")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupRepository")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\OneToMany(targetEntity="User", mappedBy="group") */
    protected $users;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=4)
     */


    public function __toString()
    {
        return (string)$this->name;
    }


    public function __construct()
    {

        $this->users = new ArrayCollection();
    }
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User $user
     */
    public function addUserGroup(User $user)
    {
        if ($this->users->contains($user)) {
            return;
        }
        $this->users->add($user);
    }

    /**
     * @param User $user
     */
    public function removeUserGroup(User $user)
    {
        $this->resources->removeElement($user);
    }

}