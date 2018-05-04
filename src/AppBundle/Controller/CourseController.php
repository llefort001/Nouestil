<?php

namespace AppBundle\Controller;

use AppBundle\Form\CourseType;
use AppBundle\Form\autocompleteUsersType;
use AppBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\User;

class CourseController extends controller
{

    public function indexAction()
    {
        $formCreateCourse = $this->createForm(CourseType::class);
        $courses = $this->get('nouestil.course');
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:User');
        $usersTeach = $repository->findProfessor()->getQuery()->getResult();

        return $this->render('AppBundle:Course:courses.html.twig', array(
            'courses' => $courses->getCourseList(),
            'formCreateCourse' => $formCreateCourse->createView(),
            'usersTeach' => $usersTeach
        ));
    }

    public function updateCourseAction(Request $request)
    {
        if ($request->isMethod('POST')) {
                $data = $request->request->all();
                $course = $this->get('nouestil.course');
                $course->updateCourse($data['id'], $data['name'], $data['session'], $data['userTeach']);
                $this->addFlash('success', 'Le cours a bien été modifié.');
        }
        return $this->redirect($this->generateUrl('courses'));
    }

    public function deleteCourseAction($courseId)
    {
        $course = $this->get('nouestil.course');
        $courseToDelete = $course->getCourse($courseId);
        $course->deleteCourse($courseToDelete);
        $this->addFlash('success', 'Le cours a bien été supprimé.');

        return $this->redirect($this->generateUrl('courses'));
    }

    public function addCourseAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $dataCourse = $data['course'];
            $courseManager = $this->get('nouestil.course');
            $courseManager->addCourse($dataCourse['name'], $dataCourse['session'], $dataCourse['userTeach']);
            $this->addFlash('success', 'Le cours a bien été enregistré.');
        }
        return $this->redirect($this->generateUrl('courses'));
    }

    public function usersCourseAction($courseId, Request $request)
    {
        $courseService= $this->get('nouestil.course');
        $userService= $this->get('nouestil.user');

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $addCourse= $courseService->addUsersCourse($data['users'], $data['id']);
            $this->addFlash('success', 'Les élèves ont bien été ajoutés.');
            return $this->redirect($this->generateUrl('usersCourse', array('courseId' => $courseId)));
        }

        return $this->render('AppBundle:Course:usersCourse.html.twig', array(
            'results' => $userService->getNotUsersCourse($courseId),
            'course' => $courseService->getCourse($courseId)
        ));
    }

    public function deleteUserCourseAction($userId,$courseId){
        $courseService= $this->get('nouestil.course');
        $userService= $this->get('nouestil.user');
        $userCourseToDelete= $courseService->removeUserCourse($userId, $courseId);
        $this->addFlash('success', 'Les élèves ont bien été supprimé.');

        return $this->redirect($this->generateUrl('usersCourse', array('courseId' => $courseId)));
    }
}