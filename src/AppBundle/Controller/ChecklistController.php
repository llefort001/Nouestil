<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ChecklistController extends controller
{
    public function indexAction(Request $request){
        $checklistManager = $this->get('nouestil.checklist');
        $checklists= $checklistManager->getChecklists();
        return $this->render('AppBundle:Checklist:checklists.html.twig',array(
            'checklists' => $checklists,
        ));
    }
    public function checklistAction($courseId, Request $request)
    {
        $courseManager = $this->get('nouestil.course');
        $userManager= $this->get('nouestil.user');
        $checklistManager= $this->get('nouestil.checklist');
        $usersNotRegister= $userManager->getNotUsersCourse($courseId);
        $checklist = $courseManager->getCourse($courseId);

        if($checklistManager->CourseIsChecked($courseId)){
            $courseName= $checklist->getName();
            $checklist= $checklistManager->getLastChecklist($courseId);
            $this->addFlash('warning','La liste d\'appel du cours ' . $courseName . ' à deja été effectué');
            return $this->render('AppBundle:Checklist:updateChecklist.html.twig', array(
                'results' => $usersNotRegister,
                'checklist' => $checklist
            ));
        }

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $checklistManager->addUsersChecklist($data['id'], $data);
            $this->addFlash('success', 'La liste d\'appel à bien été enregistré.');
            return $this->redirect($this->generateUrl('courses'));
        }

        return $this->render('AppBundle:Checklist:usersChecklist.html.twig', array(
            'results' => $usersNotRegister,
            'checklist' => $checklist
        ));

    }

    public function updateChecklistAction(Request $request){
        $checklistManager= $this->get('nouestil.checklist');
        if($request->isMethod('POST')){
            $data= $request->request->all();
            $checklistManager->updateUsersChecklist($data);
            $this->addFlash('success','La liste d\'appel à bien été mise ajour');
            if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
                $checklists= $checklistManager->getChecklists();
                return $this->render('AppBundle:Checklist:checklists.html.twig',array(
                    'checklists' => $checklists,
                ));
            }else{
                return $this->redirect($this->generateUrl('courses'));
            }

        }
        return $this->redirect($this->generateUrl('courses'));
    }

    public function displayChecklistAction($checklistId){
        $checklistManager= $this->get('nouestil.checklist');
        $userManager= $this->get('nouestil.user');
        $checklist= $checklistManager->getChecklistById($checklistId);
        $usersNotRegister= $userManager->getNotUsersCourse($checklist->getCourse()->getId());
        return $this->render('AppBundle:Checklist:updateChecklist.html.twig', array(
            'results' => $usersNotRegister,
            'checklist' => $checklist
        ));
    }

}