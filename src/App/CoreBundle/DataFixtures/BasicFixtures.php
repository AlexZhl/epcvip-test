<?php

namespace App\CoreBundle\DataFixtures;

use App\CoreBundle\Entity\Customer;
use App\CoreBundle\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BasicFixtures extends Fixture
{
    const NUMBER_OF_ITEMS = 20;

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadCustomers($manager);
        $this->loadProducts($manager);
    }

    private function loadCustomers(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::NUMBER_OF_ITEMS; $i++) {
            $customer = new Customer();
            $customer->setUsername('user_'.$i);
            $customer->setEmail('test'.$i.'@mail.com');
            $customer->setFirstName('Firstname ' . $i);
            $customer->setLastName('Lastname ' . $i);
            $customer->setDateOfBirth(new \DateTime(random_int(1,28) . '-' . random_int(1, 12) . '-' . random_int(1990, 2000)));
            $password = $this->encoder->encodePassword($customer, '123');
            $customer->setPassword($password);

            $manager->persist($customer);
            $this->addReference($customer->getUsername(), $customer);
        }

        $manager->flush();
    }

    private function loadProducts(ObjectManager $manager)
    {
        $phrases = $this->getPhrases();
        for ($i = 1; $i <= self::NUMBER_OF_ITEMS; $i++) {
            $product = new Product();
            $product->setName($phrases[random_int(0, count($phrases)-1)]);
            $product->setIssn(random_int(100, 20000));
            $product->setStatus(Product::STATUS_APPROVED);
            $product->setCustomer($this->getReference('user_' . random_int(1, self::NUMBER_OF_ITEMS)));

            $manager->persist($product);
        }

        $manager->flush();
    }

    private function getPhrases()
    {
        return [
            'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'Pellentesque vitae velit ex',
            'Mauris dapibus risus quis suscipit vulputate',
            'Eros diam egestas libero eu vulputate risus',
            'In hac habitasse platea dictumst',
            'Morbi tempus commodo mattis',
            'Ut suscipit posuere justo at vulputate',
            'Ut eleifend mauris et risus ultrices egestas',
            'Aliquam sodales odio id eleifend tristique',
            'Urna nisl sollicitudin id varius orci quam id turpis',
            'Nulla porta lobortis ligula vel egestas',
            'Curabitur aliquam euismod dolor non ornare',
            'Sed varius a risus eget aliquam',
            'Nunc viverra elit ac laoreet suscipit',
            'Pellentesque et sapien pulvinar consectetur',
            'Ubi est barbatus nix',
            'Abnobas sunt hilotaes de placidus vita',
            'Ubi est audax amicitia',
            'Eposs sunt solems de superbus fortis',
            'Vae humani generis',
            'Diatrias tolerare tanquam noster caesium',
            'Teres talis saepe tractare de camerarius flavum sensorem',
            'Silva de secundus galatae demitto quadra',
            'Sunt accentores vitare salvus flavum parses',
            'Potus sensim ad ferox abnoba',
            'Sunt seculaes transferre talis camerarius fluctuies',
            'Era brevis ratione est',
            'Sunt torquises imitari velox mirabilis medicinaes',
            'Mineralis persuadere omnes finises desiderium',
            'Bassus fatalis classiss virtualiter transferre de flavum',
        ];
    }
}
