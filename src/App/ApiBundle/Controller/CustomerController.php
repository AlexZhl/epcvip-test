<?php

namespace App\ApiBundle\Controller;

use App\CoreBundle\Entity\Customer;
use App\CoreBundle\Form\CustomerType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerController extends BaseApiController
{
    /**
     * @Rest\Get("/customers")
     */
    public function allAction(Request $request)
    {
        $result = $this->getDoctrine()->getRepository(Customer::class)->findAll();

        return $result;
    }

    /**
     * @Rest\Get("/customers/{id}")
     */
    public function getAction($id)
    {
        $result = $this->getDoctrine()->getRepository(Customer::class)->find($id);

        if ($result === null) {
            throw $this->createNotFoundException(sprintf(
                'No customer found with id "%s"',
                $id
            ));
        }

        return $result;
    }

    /**
     * @Rest\Post("/customers")
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);

        $this->processForm($request, $form);
        if (!$form->isValid()) {
            return $this->createValidationErrorResponse($form);
        }
        $password = $encoder->encodePassword($customer, $form->getData()->getPassword());
        $customer->setPassword($password);

        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);
        $em->flush();

        return new View($customer, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/customers/{id}")
     * @Rest\Patch("/customers/{id}")
     */
    public function putAction($id, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);

        if (!$customer) {
            throw $this->createNotFoundException(sprintf(
                'No customer found with id "%s"',
                $id
            ));
        }

        $form = $this->createForm(CustomerType::class, $customer);
        $this->processForm($request, $form);
        if (!$form->isValid()) {
            return $this->createValidationErrorResponse($form);
        }
        if ($request->get('password')) {
            $password = $encoder->encodePassword($customer, $form->getData()->getPassword());
            $customer->setPassword($password);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);
        $em->flush();

        return new View($customer, Response::HTTP_OK);

    }

    /**
     * @Rest\Delete("/customers/{id}")
     */
    public function deleteAction($id, Request $request)
    {
        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);

        if (!$customer) {
            throw $this->createNotFoundException(sprintf(
                'No customer found with id "%s"',
                $id
            ));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($customer);
        $em->flush();

        return new View(null, Response::HTTP_NO_CONTENT);
    }
}
