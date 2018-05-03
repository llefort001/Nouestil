<?php
/**
 * Created by PhpStorm.
 * User: Lucas Lefort
 * Date: 01/03/2018
 * Time: 09:26
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends Controller
{

    public function indexAction()
    {
        $contacts = $this->get('nouestil.contact');
        return $this->render('AppBundle:Contacts:contacts.html.twig', array('contacts' => $contacts->getContactsList()));

    }

    public function deleteContactAction($contactId)
    {
        $contactManager = $this->get('nouestil.contact');
        $contactToDelete = $contactManager->getContact($contactId);
        $contactManager->deleteContact($contactToDelete);
        $this->addFlash('success', 'Le contact a bien été supprimé');
        return $this->redirect($this->generateUrl('contacts'));

    }


    public function updateContactAction(Request $request)
    {

        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $contact= $this->get('nouestil.contact');
            $contact->updateContact($data['id'],$data['lastname'], $data['firstname'], $data['phoneNumber'], $data['email'] );
        }
        $this->addFlash('success', 'Le contact a bien été modifié');
        return $this->redirect($this->generateUrl('contacts'));
    }

    public function createContactAction(Request $request)
    {
        $formContact = $this->createForm(ContactType::class);
        if ($request->isMethod('POST')) {
            $formContact->submit($request->request->get($formContact->getName()));

            // Enregistrer après soumission du formulaire les données dans l'objet $contact
            if ($formContact->isSubmitted() && $formContact->isValid()) {
                $contactData = $formContact->getData();
                $this->get('nouestil.contact')->createContact($contactData['email'], $contactData['firstname'], $contactData['lastname'], $contactData['phone_number'], $contactData['kinship'], $contactData['user']);
                $this->addFlash('success', 'Le contact a bien été enregistré');
                return $this->redirect($this->generateUrl("contacts"));
            }
        }


        return $this->render('AppBundle:Contacts:create.html.twig', array(
            'formContact' => $formContact->createView(),
        ));
    }
}

