<?php

namespace ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EmailController extends Controller {
    /**
     * @Route("/{contact}/{id}/deleteEmail")
     */
    public function deleteAction($id, $contact) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Email');
        $email = $repository->find($id);

        if (!$email) {
            throw $this->createNotFoundException('Email not found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($email);
        $em->flush();
        $this->addFlash('notice', 'Email deleted');

        return $this->redirectToRoute('contact_contact_show', ['id' => $contact]);

        return new Response('');
    }

}
