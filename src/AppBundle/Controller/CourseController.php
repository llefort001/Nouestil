<?php

namespace AppBundle\Controller;

use AppBundle\Form\CourseType;
use AppBundle\Form\autocompleteUsersType;
use AppBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\User;

class CourseController extends controller{

    public function indexAction (){
        $formCreateCourse= $this->createForm(CourseType::class);
        $courses= $this->get('nouestil.course');
        $repository= $this->getDoctrine()->getManager()->getRepository('AppBundle:User');
        $usersTeach= $repository->findProfessor()->getQuery()->getResult();

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
            $course= $this->get('nouestil.course');
            $course->updateCourse($data['id'],$data['name'],$data['session'],$data['userTeach']);
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
        if ($request->isMethod('POST')){
            $data= $request->request->all();
            $dataCourse= $data['course'];
            $courseManager= $this->get('nouestil.course');
            $courseManager->addCourse($dataCourse['name'],$dataCourse['session'],$dataCourse['userTeach']);
            $this->addFlash('success', 'Le cours a bien été enregistré.');
        }
            $this->addFlash('success', 'Le cours a bien été enregistré.');
        return $this->redirect($this->generateUrl('courses'));
    }

    public function usersCourseAction($courseId, Request $request){
        $course= $this->get('nouestil.course')->getCourse($courseId);

        $q = $request->query->get('term');
        $results = $this->getDoctrine()->getRepository('AppBundle:User')->findLikeName($q);

        dump($results);die;

        return $this->render('AppBundle:Course:usersListCourse.html.twig', array(
            'course' => $course,
            'results' => $results
        ));
    }

    public function getAuthorAction($id = null)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        return new Response($user->getName());
    }
}