<?php

namespace App\CoreBundle\EventListener;

use App\CoreBundle\Entity\Product;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

class ProductListener
{
    /** @ORM\PrePersist */
    public function prePersistHandler(Product $product, LifecycleEventArgs $event)
    {
        $product->setUpdatedAt(new \DateTime());
    }
}