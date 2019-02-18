<?php

namespace App\ApiBundle\Controller;

use App\CoreBundle\Entity\Product;
use App\CoreBundle\Form\ProductType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProductController extends BaseApiController
{
    /**
     * @Rest\Get("/products")
     */
    public function allAction(Request $request)
    {
        $result = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $result;
    }

    /**
     * @Rest\Get("/products/{id}")
     */
    public function getAction($id)
    {
        $result = $this->getDoctrine()->getRepository(Product::class)->find($id);

        if ($result === null) {
            throw $this->createNotFoundException(sprintf(
                'No product found with id "%s"',
                $id
            ));
        }

        return $result;
    }

    /**
     * @Rest\Post("/products")
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $this->processForm($request, $form);
        if (!$form->isValid()) {
            return $this->createValidationErrorResponse($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new View($product, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/products/{id}")
     * @Rest\Patch("/products/{id}")
     */
    public function putAction($id, Request $request)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(sprintf(
                'No product found with id "%s"',
                $id
            ));
        }

        $form = $this->createForm(ProductType::class, $product);
        $this->processForm($request, $form);
        if (!$form->isValid()) {
            return $this->createValidationErrorResponse($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new View($product, Response::HTTP_OK);

    }

    /**
     * @Rest\Delete("/products/{id}")
     */
    public function deleteAction($id, Request $request)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(sprintf(
                'No product found with id "%s"',
                $id
            ));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return new View(null, Response::HTTP_NO_CONTENT);
    }
}
