<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Course;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseManager
 * @package AppBundle\Manager
 */
class CourseManager
{
    protected $name;
    protected $session;
    protected $professor;
    protected $em;

    /**
     * CourseManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em= $em;
    }


    /**
     * @param Course $course
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteCourse(Course $course)
    {
        $this->em->remove($course);
        $this->em->flush();
    }

    /**
     * @return mixed
     */
    public function getCourseList()
    {
        $course = $this->em
            ->getRepository('AppBundle:Course')
            ->findAll();
        return $course;
    }

    /**
     * @param $id
     * @param $name
     * @param $session
     * @return null|object
     */
    public function updateCourse($id, $name, $session, $userTeach)
    {
        $course= $this->em
            ->getRepository('AppBundle:Course')
            ->findOneById($id);
        $course->setName($name);
        $course->setSession($session);
        $teacher = $this->em->getRepository('AppBundle:User')->findById($userTeach);
        $course->setUserTeach($teacher[0]);
        try{
            $this->em->persist($course);
            $this->em->flush();
        } catch (\exception $e){
            dump($e->getMessage());
        }

        return $course;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCourse($id)
    {
        $course= $this->em
            ->getRepository('AppBundle:Course')
            ->findOneById($id);
        if (!$course instanceof Course){
            throw $this->createNotFoundException(
                'Pas de cours'
            );
        }
        return $course;
    }

    public function addCourse($name, $session, $userTeach)
    {
        $course =new Course();
        $course->setName($name);
        $course->setSession($session);
        $teacher = $this->em->getRepository('AppBundle:User')->findById($userTeach);
        $course->setUserTeach($teacher[0]);
        try{
            $this->em->persist($course);
            $this->em->flush();
        } catch (\exception $e){
            dump($e->getMessage());
        }
           return $course;
    }

    public function addUsersCourse($users, $id)
    {
//        $course= $this->em
//            ->getRepository('AppBundle:Course')
//            ->findOneById($id);
//
//        foreach ($users as $value){
//            $user= $this->em
//                ->getRepository('AppBundle:User')
//                ->findOneById($value);
//            if (!$user instanceof User) {
//                throw $this->createNotFoundException(
//                    'User incorecct'
//                );
//            }
//
//            $course->setUser($user);
//        }
    }

    public function getProfesssor()
    {
        return findProfessor();
    }

}
