<?php

namespace ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PhoneController extends Controller {
    /**
     * @Route("/{contact}/{id}/deletePhone")
     */
    public function deleteAction($id, $contact) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Phone');
        $phone = $repository->find($id);

        if (!$phone) {
            throw $this->createNotFoundException('Phone not found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($phone);
        $em->flush();
        $this->addFlash('notice', 'Phone deleted');

        return $this->redirectToRoute('contact_contact_show', ['id' => $contact]);

        return new Response('');
    }

}
