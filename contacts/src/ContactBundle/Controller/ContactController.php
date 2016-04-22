<?php

namespace ContactBundle\Controller;

use ContactBundle\Entity\Contact;
use ContactBundle\Entity\Address;
use ContactBundle\Entity\ContactGroup;
use ContactBundle\Entity\Email;
use ContactBundle\Entity\Phone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ContactController extends Controller {

    /**
     * @Route("/new")
     * @Template("ContactBundle:Contact:new.html.twig")
     */
    public function createAction(Request $request) {

        $contact = new Contact();
        $url = $this->generateUrl('contact_contact_create');
        $form = $this->newContactForm($contact, 'Add', $url);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('ContactBundle:Contact');
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('contact_contact_show', ['id' => $contact->getId()]);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/modify")
     * @Template()
     */
    public function modifyAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Contact');
        $contact = $repository->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }

        $url = $this->generateUrl('contact_contact_modify', ['id' => $id]);
        $form = $this->newContactForm($contact, 'Update', $url);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('notice', 'User updated');
            return $this->redirectToRoute('contact_contact_show', ['id' => $contact->getId()]);
        }

        $address = new Address();
        $url = $this->generateUrl('contact_contact_newaddress', ['id' => $id]);
        $addressForm = $this->newAddressForm($address, 'Add address', $url);

        $email = new Email();
        $url = $this->generateUrl('contact_contact_newemail', ['id' => $id]);
        $emailForm = $this->newEmailForm($email, 'Add email', $url);

        $phone = new Phone();
        $url = $this->generateUrl('contact_contact_newphone', ['id' => $id]);
        $phoneForm = $this->newPhoneForm($phone, 'Add phone', $url);

        $url = $this->generateUrl('contact_contact_newgroup', ['id' => $id]);
        $groupForm = $this->newGroupForm($url, $contact->getGroups());

        return ['form' => $form->createView(),
                'addressForm' => $addressForm->createView(),
                'emailForm' => $emailForm->createView(),
                'phoneForm' => $phoneForm->createView(),
                'groupForm' => $groupForm->createView()
        ];
    }

    /**
     * @Route("/{id}/addAddress")
     * @Template("ContactBundle:Contact:new.html.twig")
     * @Method("POST")
     */
    public function newAddressAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Contact');
        $contact = $repository->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }

        $url = $this->generateUrl('contact_contact_modify', ['id' => $id]);
        $form = $this->newContactForm($contact, 'Update', $url);

        $email = new Email();
        $url = $this->generateUrl('contact_contact_newemail', ['id' => $id]);
        $emailForm = $this->newEmailForm($email, 'Add email', $url);

        $phone = new Phone();
        $url = $this->generateUrl('contact_contact_newphone', ['id' => $id]);
        $phoneForm = $this->newPhoneForm($phone, 'Add phone', $url);

        $url = $this->generateUrl('contact_contact_newgroup', ['id' => $id]);
        $groupForm = $this->newGroupForm($url, $contact->getGroups());

        $address = new Address();
        $address->setContact($contact);
        $url = $this->generateUrl('contact_contact_newaddress', ['id' => $id]);
        $addressForm = $this->newAddressForm($address, 'Add address', $url);
        $addressForm->handleRequest($request);

        if ($addressForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            $contact->addAddress($address);
            $this->addFlash('notice', 'Address added');
            return $this->redirectToRoute('contact_contact_show', ['id' => $contact->getId()]);
        }

        return ['form' => $form->createView(),
                'addressFrom' => $addressForm->createView(),
                'emailForm' => $emailForm->createView(),
                'phoneForm' => $phoneForm->createView(),
                'groupForm' => $groupForm->createView()
        ];
    }

    /**
     * @Route("/{id}/addEmail")
     * @Template("ContactBundle:Contact:new.html.twig")
     * @Method("POST")
     */

    public function newEmailAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Contact');
        $contact = $repository->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }

        $url = $this->generateUrl('contact_contact_modify', ['id' => $id]);
        $form = $this->newContactForm($contact, 'Update', $url);

        $address = new Address();
        $url = $this->generateUrl('contact_contact_newaddress', ['id' => $id]);
        $addressForm = $this->newAddressForm($address, 'Add address', $url);

        $phone = new Phone();
        $url = $this->generateUrl('contact_contact_newphone', ['id' => $id]);
        $phoneForm = $this->newPhoneForm($phone, 'Add phone', $url);

        $url = $this->generateUrl('contact_contact_newgroup', ['id' => $id]);
        $groupForm = $this->newGroupForm($url, $contact->getGroups());

        $email = new Email();
        $email->setContact($contact);
        $url = $this->generateUrl('contact_contact_newemail', ['id' => $id]);
        $emailForm = $this->newEmailForm($email, 'Add email', $url);
        $emailForm->handleRequest($request);

        if ($emailForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();


            $contact->addEmail($email);
            $this->addFlash('notice', 'Email added');
            return $this->redirectToRoute('contact_contact_show', ['id' => $contact->getId()]);
        }

        return ['form' => $form->createView(),
            'addressFrom' => $addressForm->createView(),
            'emailForm' => $emailForm->createView(),
            'phoneForm' => $phoneForm->createView(),
            'groupForm' => $groupForm->createView()
        ];
    }


    /**
     * @Route("/{id}/addPhone")
     * @Template("ContactBundle:Contact:new.html.twig")
     * @Method("POST")
     */

    public function newPhoneAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Contact');
        $contact = $repository->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }

        $url = $this->generateUrl('contact_contact_modify', ['id' => $id]);
        $form = $this->newContactForm($contact, 'Update', $url);

        $address = new Address();
        $url = $this->generateUrl('contact_contact_newaddress', ['id' => $id]);
        $addressForm = $this->newAddressForm($address, 'Add address', $url);

        $email = new Email();
        $url = $this->generateUrl('contact_contact_newemail', ['id' => $id]);
        $emailForm = $this->newEmailForm($email, 'Add email', $url);

        $url = $this->generateUrl('contact_contact_newgroup', ['id' => $id]);
        $groupForm = $this->newGroupForm($url, $contact->getGroups());

        $phone = new Phone();
        $phone->setContact($contact);
        $url = $this->generateUrl('contact_contact_newphone', ['id' => $id]);
        $phoneForm = $this->newPhoneForm($phone, 'Add phone', $url);
        $phoneForm->handleRequest($request);

        if ($phoneForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($phone);
            $em->flush();


            $contact->addPhone($phone);
            $this->addFlash('notice', 'Phone added');
            return $this->redirectToRoute('contact_contact_show', ['id' => $contact->getId()]);
        }

        return ['form' => $form->createView(),
            'addressFrom' => $addressForm->createView(),
            'emailForm' => $emailForm->createView(),
            'phoneForm' => $phoneForm->createView(),
            'groupForm' => $groupForm->createView()
        ];
    }


    /**
     * @Route("/{id}/addGroup")
     * @Template("ContactBundle:Contact:new.html.twig")
     * @Method("POST")
     */

    public function newGroupAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Contact');
        $contact = $repository->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }

        $url = $this->generateUrl('contact_contact_modify', ['id' => $id]);
        $form = $this->newContactForm($contact, 'Update', $url);

        $address = new Address();
        $url = $this->generateUrl('contact_contact_newaddress', ['id' => $id]);
        $addressForm = $this->newAddressForm($address, 'Add address', $url);

        $email = new Email();
        $url = $this->generateUrl('contact_contact_newemail', ['id' => $id]);
        $emailForm = $this->newEmailForm($email, 'Add email', $url);

        $phone = new Phone();
        $url = $this->generateUrl('contact_contact_newphone', ['id' => $id]);
        $phoneForm = $this->newPhoneForm($phone, 'Add phone', $url);

        $url = $this->generateUrl('contact_contact_newgroup', ['id' => $id]);
        $groupForm = $this->newGroupForm($url, $contact->getGroups());
        $groupForm->handleRequest($request);

        if ($groupForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            $group = $groupForm->getData()['group'];

            if (!$group) {
                throw $this->createNotFoundException('No such group');
            }

            $group->addContact($contact);
            $contact->addGroup($group);
            $em->flush();

            $this->addFlash('notice', 'User added to group');
            return $this->redirectToRoute('contact_contact_show', ['id' => $contact->getId()]);
        }

        return ['form' => $form->createView(),
            'addressFrom' => $addressForm->createView(),
            'emailForm' => $emailForm->createView(),
            'phoneForm' => $phoneForm->createView(),
            'groupForm' => $groupForm->createView()
        ];

    }


    /**
     * @Route("/{id}/delete")
     */
    public function deleteAction($id) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Contact');
        $contact = $repository->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        $this->addFlash('notice', 'User deleted');

        return $this->redirectToRoute('contact_contact_showall');

        return new Response('');
    }

    /**
     * @Route("/{id}")
     * @Template()
     */
    public function showAction($id) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Contact');
        $contact = $repository->find($id);

        return ['contact' => $contact];
    }

    /**
     * @Route("/")
     * @Template()
     * @Method("GET")
     */
    public function showAllAction() {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Contact');
        $contacts = $repository->findAll();
        $search = $this->searchForm();

        return [
                'contacts' => $contacts,
                'search' => $search->createView()
        ];
    }

    /**
     * @Route("/")
     * @Template("ContactBundle:Contact:showAll.html.twig")
     * @Method("POST")
     */
    public function searchContactAction(Request $request) {
        $repository = $this->getDoctrine()->getRepository('ContactBundle:Contact');
        $searchForm = $this->searchForm();

        $form = $searchForm->handleRequest($request);
        $search = $form->get('searchPhrase')->getData();
        $contacts = $repository->findContacts($search);

        return [
            'contacts' => $contacts,
            'search' => $searchForm->createView()
        ];
    }

    private function newContactForm(Contact $contact, $submit, $url) {
        return $this->createFormBuilder($contact)
            ->setAction($url)
            ->add('name')
            ->add('surname')
            ->add('description')
            ->add($submit, 'submit')
            ->getForm();
    }


    private function newAddressForm(Address $address, $submit, $url) {
        return $this->createFormBuilder($address)
            ->setAction($url)
            ->add('city')
            ->add('street')
            ->add('houseNumber')
            ->add('flatNumber')
            ->add($submit, 'submit')
            ->getForm();
    }

    private function newEmailForm(Email $email, $submit, $url) {
        return $this->createFormBuilder($email)
            ->setAction($url)
            ->add('address')
            ->add('type')
            ->add($submit, 'submit')
            ->getForm();
    }

    private function newPhoneForm(Phone $phone, $submit, $url) {
        return $this->createFormBuilder($phone)
            ->setAction($url)
            ->add('number')
            ->add('type')
            ->add($submit, 'submit')
            ->getForm();
    }

    private function newGroupForm($url, $groups) {

        return $this->createFormBuilder([])
            ->setAction($url)
            ->add('group', 'entity', array(
                    'class' => 'ContactBundle:ContactGroup',
                    'query_builder' => function (EntityRepository $er) use($groups) {
                        $qb = $er->createQueryBuilder('cg');
                        $ids = [];
                        foreach ($groups as $group) {
                            $ids[] = $group->getId();
                        }
                        if (!empty($ids)) {
                            $qb->andWhere($qb->expr()->notIn('cg.id', $ids));
                        }
                        return $qb;
                    },
                    'choice_label' => 'name'
                ))
            ->add('Add user to group', 'submit')
            ->getForm();
    }



    private function searchForm() {
        return $this->createFormBuilder([])
            ->setAction($this->generateUrl('contact_contact_searchcontact'))
            ->add('searchPhrase', 'text')
            ->add('Search', 'submit')
            ->getForm();
    }

}
