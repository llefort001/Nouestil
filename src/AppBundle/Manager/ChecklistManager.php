<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Checklist;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

/**
 * Class ChecklistManager
 * @package AppBundle\Manager
 */
class ChecklistManager
{
    protected $course;
    protected $date;
    protected $em;

    /**
     * ChecklistManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em= $em;
    }

    public function addChecklist($id)
    {
        $checklist =new Checklist();
        $course = $this->em->getRepository('AppBundle:Course')->findOneById($id);
        $checklist->setcourse($course);
        $checklist->setDatetime(new \DateTime());
        try{
            $this->em->persist($checklist);
            $this->em->flush();
        } catch (\exception $e){
            $e->getMessage();
        }
        return $checklist;
    }

    /**
     * @param Checklist $checklist
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteChecklist(Checklist $checklist)
    {
        $this->em->remove($checklist);
        $this->em->flush();
    }

    public function getLastChecklist($courseId){

        $checklist= $this->em->getRepository('AppBundle:Checklist')->queryLastChecklist($courseId);
        if(empty($checklist)){
            return $checklist;
        }
        return $checklist[0];
    }

    public function getChecklists(){
        $checklists= $this->em->getRepository('AppBundle:Checklist')->queryChecklists();
        return $checklists;
    }

    public function getChecklistById($checklistId){
        $checklist= $this->em->getRepository('AppBundle:Checklist')->findOneById($checklistId);
        return $checklist;
    }

    public function CourseIsChecked($courseId){
        $checklist= $this->getLastChecklist($courseId);
        if(empty($checklist)){
            return false;
        }
        $date= $checklist->getDateTime();
        $dateDiff= date_diff(new \DateTime(), $date);
        if(($dateDiff->d == 0)&&($dateDiff->h < 10)){
            return true;
        }
        return false;
    }

    public function updateUsersChecklist($users){
        $id= $users['id'];
        $checklist= $this->em
            ->getRepository('AppBundle:Checklist')
            ->findOneById($id);
        dump($checklist);
        $checklist->refresh();
        if(array_key_exists('users',$users)) {
            $usersAdd = $users['users'];
            unset($users['users']);
            foreach ($usersAdd as $user) {
                $user = $this->em
                    ->getRepository('AppBundle:User')
                    ->findOneById($user);
                $checklist->addUserPresent($user);
            }
        }
        foreach ($users as $key => $value) {
            if ($value === "1") {
                $user = $this->em
                    ->getRepository('AppBundle:User')
                    ->findOneById($key);
                $checklist->addUserPresent($user);
            }elseif ($value === "0"){
                $user = $this->em
                    ->getRepository('AppBundle:User')
                    ->findOneById($key);
                $checklist->addUserAbsent($user);
            }
        }
        try{
            $this->em->flush();
        } catch (\exception $e){
            $e->getMessage();
        }
    }

    public function addUsersChecklist($id, $users)
    {
        $checklist= $this->addChecklist($id);
        if(array_key_exists('users',$users)) {
            $usersAdd = $users['users'];
            unset($users['users']);
            foreach ($usersAdd as $user) {
                $user = $this->em
                    ->getRepository('AppBundle:User')
                    ->findOneById($user);
                $checklist->addUserPresent($user);
            }
        }
            foreach ($users as $key => $value) {
                if ($value === "1") {
                    $user = $this->em
                        ->getRepository('AppBundle:User')
                        ->findOneById($key);
                    $checklist->addUserPresent($user);
                }elseif ($value === "0"){
                    $user = $this->em
                        ->getRepository('AppBundle:User')
                        ->findOneById($key);
                    $checklist->addUserAbsent($user);
                }
            }
        try{
                $this->em->persist($checklist);
                $this->em->flush();
            } catch (\exception $e){
                $e->getMessage();
            }
    }

}