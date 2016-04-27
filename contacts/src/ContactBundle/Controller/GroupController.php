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
        $group->setUser($this->getUser());
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
        $group = $this->getGroup($id);
        $this->checkIfGroupExists($group);
        $this->checkPrivileges($group);

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
        $group = $this->getGroup($id);
        $this->checkIfGroupExists($group);
        $this->checkPrivileges($group);

        return ['group' => $group];
    }

    /**
     * @Route("/group/showAll")
     * @Template()
     */
    public function showAllAction() {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:ContactGroup');
        $groups = $repository->findByUser($this->getUser());

        return ['groups' => $groups];
    }

    /**
     * @Route("/{groupId}/removeContactFromGroup/{contactId}")
     */
    public function removeContactFromGroup(Request $request, $groupId, $contactId) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Contact');
        $contact = $repository->find($contactId);

        $group = $this->getGroup($groupId);
        $this->checkIfGroupExists($group);

        $this->checkPrivileges($group);
        $this->checkPrivileges($contact);

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

    private function checkPrivileges($group) {
        if ($this->getUser() != $group->getUser()) {
            throw $this->createAccessDeniedException();
        }
    }

    private function checkIfGroupExists($group) {
        if (!$group) {
            throw $this->createNotFoundException('Group not found');
        }
    }

    private function getGroup($id) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:ContactGroup');
        $group = $repository->find($id);

        return $group;
    }
}
