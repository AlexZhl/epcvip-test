<?php

namespace App\CoreBundle\Command;

use App\CoreBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PendingProductsNotificator extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:pending-products-notificator')

            ->setDescription('Look for products on “pending” for a week or more and send email.')

            ->setHelp('This command looks for products on “pending” for a week or more and send email to customer notifying about this.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(Product::class)
            ->getCustomersWithPendingProducts(new \DateTime('now - 7 days'));

        $mailer = $this->getContainer()->get('mailer');

        foreach ($products as $product) {
            $email = $product->getCustomer()->getEmail();

            $message = (new \Swift_Message('Pending Products Notificator'))
                ->setFrom($this->getContainer()->getParameter('mailer_user'))
                ->setTo($email)
                ->setBody('You have pending products for over 7 days')
            ;

            $mailer->send($message);
        }
    }
}