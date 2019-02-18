<?php

namespace App\CoreBundle\EventListener;

use App\CoreBundle\Entity\Product;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

class ProductListener
{
    /** @ORM\PreUpdate */
    public function preUpdateHandler(Product $product, PreUpdateEventArgs $event)
    {
        $product->setUpdatedAt(new \DateTime());
    }
}