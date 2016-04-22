<?php

namespace ContactBundle\Controller;

use ContactBundle\Entity\ContactGroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller {
    /**
     * @Route("/group/new")
     * @Template("ContactBundle:Group:new.html.twig")
     */
    public function newAction(Request $request) {

        $group = new ContactGroup();
        $form = $this->createFormBuilder($group)
            ->setAction($this->generateUrl('contact_group_new'))
            ->add('name')
            ->add('Add group', 'submit')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('contact_group_show', ['id' => $group->getId()]);
        }

        return ['groupForm' => $form->createView()];
    }

    /**
     * @Route("/{id}/deleteGroup")
     */
    public function deleteAction($id) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:ContactGroup');
        $group = $repository->find($id);

        if (!$group) {
            throw $this->createNotFoundException('Group not found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($group);
        $em->flush();
        $this->addFlash('notice', 'Group deleted');

        return $this->redirectToRoute('contact_group_showall');
    }

    /**
     * @Route("/{id}/showGroup")
     * @Template()
     */
    public function showAction($id) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:ContactGroup');
        $group = $repository->find($id);

        return ['group' => $group];
    }

    /**
     * @Route("/group/showAll")
     * @Template()
     */
    public function showAllAction() {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:ContactGroup');
        $groups = $repository->findAll();

        return ['groups' => $groups];
    }

    /**
     * @Route("/{groupId}/removeContactFromGroup/{contactId}")
     */
    public function removeContactFromGroup(Request $request, $groupId, $contactId) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Contact');
        $contact = $repository->find($contactId);

        $repository = $this->getDoctrine()->getRepository('ContactBundle:ContactGroup');
        $group = $repository->find($groupId);

        $group->removeContact($contact);
        $contact->removeGroup($group);

        $em = $this->getDoctrine()->getManager();
        $em->persist($group);
        $em->persist($contact);
        $em->flush();

        $page = $request->query->get('page');

        if ($page == 'contact') {
            $redirect = 'contact_contact_show';
            $slugs = ['id' => $contactId];
        }

        if ($page == 'group') {
            $redirect = 'contact_group_show';
            $slugs = ['id' => $groupId];
        }


        return $this->redirectToRoute($redirect, $slugs);
    }
}
