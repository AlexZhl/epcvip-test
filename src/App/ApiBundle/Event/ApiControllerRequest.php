<?php

namespace App\ApiBundle\Event;

use App\ApiBundle\Entity\ApiRequest;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ApiControllerRequest
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onControllerResponse(PostResponseEvent $event)
    {
        $this->logger->info(
            sprintf('API Request URI: "%s"; ', $event->getRequest()->getRequestUri()) .
            sprintf('API Request Content: "%s"; ', $event->getRequest()->getContent()) .
            sprintf('API Response Status Code: "%s"; ', $event->getResponse()->getStatusCode()) .
            sprintf('API Response Content: "%s"', $event->getResponse()->getContent())
        );

        $apiRequest = new ApiRequest();
        $apiRequest->setRequestUri($event->getRequest()->getRequestUri());
        $apiRequest->setRequestContent($event->getRequest()->getContent());
        $apiRequest->setResponseStatusCode($event->getResponse()->getStatusCode());
        $apiRequest->setResponseContent($event->getResponse()->getContent());

        try {
            $this->entityManager->persist($apiRequest);
            $this->entityManager->flush($apiRequest);
        } catch(\Exception $ex) {

        }
    }
}