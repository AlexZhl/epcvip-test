<?php

namespace App\CoreBundle\EventListener;

use App\CoreBundle\Entity\Customer;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

class CustomerListener
{
    /** @ORM\PrePersist */
    public function prePersistHandler(Customer $customer, LifecycleEventArgs $event)
    {
        $customer->setUpdatedAt(new \DateTime());
    }
}