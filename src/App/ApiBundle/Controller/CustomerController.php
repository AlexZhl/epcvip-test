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
     * @Rest\Get("/customer")
     */
    public function allAction(Request $request)
    {
        $result = $this->getDoctrine()->getRepository(Customer::class)->findAll();

        if ($result === null) {
            return new View("There are no customers", Response::HTTP_NOT_FOUND);
        }

        return $result;
    }

    /**
     * @Rest\Get("/customer/{id}")
     */
    public function getAction($id)
    {
        $result = $this->getDoctrine()->getRepository(Customer::class)->find($id);

        if ($result === null) {
            return new View("Customer not found", Response::HTTP_NOT_FOUND);
        }

        return $result;
    }

    /**
     * @Rest\Post("/customer")
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);

        $this->processForm($request, $form);
        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            $data = [
                'type' => 'validation_error',
                'title' => 'There was a validation error',
                'errors' => $errors,
            ];

            return new View($data, Response::HTTP_BAD_REQUEST);
        }
        $password = $encoder->encodePassword($customer, '123');
        $customer->setPassword($password);

        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);
        $em->flush();

        return new View("User Added Successfully", Response::HTTP_OK);
    }
}
