<?php

namespace App\CoreBundle\EventListener;

use App\CoreBundle\Entity\Customer;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

class CustomerListener
{
    /** @ORM\PreUpdate */
    public function preUpdateHandler(Customer $customer, PreUpdateEventArgs $event)
    {
        $customer->setUpdatedAt(new \DateTime());
    }
}