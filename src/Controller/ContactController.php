<?php


namespace App\Controller;


use App\Model\ContactManager;

class ContactController extends AbstractController
{
    public function contactForm()
    {

        $contactManagerForm = new ContactManager();

        $contact = $contactManagerForm->fillContactForm();
        return $this->twig->render('contact_form.html.twig', [
            'contact_form' => $contact,
        ]);
    }
}
