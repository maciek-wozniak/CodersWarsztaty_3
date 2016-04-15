<?php

namespace ContactBundle\Controller;

use ContactBundle\Entity\Address;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class AddressController extends Controller {

    /**
     * @Route("/{contact}/{id}/deleteAddress")
     */
    public function deleteAction($id, $contact) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Address');
        $address = $repository->find($id);

        if (!$address) {
            throw $this->createNotFoundException('Address not found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($address);
        $em->flush();
        $this->addFlash('notice', 'Address deleted');

        return $this->redirectToRoute('contact_contact_show', ['id' => $contact]);

        return new Response('');
    }



}
