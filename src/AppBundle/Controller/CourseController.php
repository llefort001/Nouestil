<?php

namespace AppBundle\Controller;

use AppBundle\Form\CourseType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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
        $this->denyAccessUnlessGranted('ROLE_ADMIN', 'Access denied', 'You cannot edit this item.');

        if ($request->isMethod('POST')) {
                $data = $request->request->all();
                $course = $this->get('nouestil.course');
                $course->updateCourse($data['id'], $data['style'], $data['category'], $data['timeslot'], $data['userTeach']);
                $this->addFlash('success', 'Le cours a bien été modifié.');
        }
        return $this->redirect($this->generateUrl('courses'));
    }

    public function deleteCourseAction($courseId)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', 'Access denied', 'You cannot edit this item.');

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
            $courseManager->addCourse($dataCourse['style'], $dataCourse['category'],$dataCourse['timeslot'], $dataCourse['userTeach']);
            $this->addFlash('success', 'Le cours a bien été enregistré.');
        }
        return $this->redirect($this->generateUrl('courses'));
    }

    public function usersCourseAction($courseId, Request $request)
    {
        $courseManager= $this->get('nouestil.course');
        $userManager= $this->get('nouestil.user');

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $courseManager->addUsersCourse($data['users'], $data['id']);
            $this->addFlash('success', 'Les élèves ont bien été ajoutés.');
            return $this->redirect($this->generateUrl('usersCourse', array('courseId' => $courseId)));
        }

        return $this->render('AppBundle:Course:usersCourse.html.twig', array(
            'results' => $userManager->getNotUsersCourse($courseId),
            'course' => $courseManager->getCourse($courseId)
        ));
    }

    public function deleteUserCourseAction($userId,$courseId){
        $courseService= $this->get('nouestil.course');
        $courseService->removeUserCourse($userId, $courseId);
        $this->addFlash('success', 'Les élèves ont bien été supprimé.');

        return $this->redirect($this->generateUrl('usersCourse', array('courseId' => $courseId)));
    }
}