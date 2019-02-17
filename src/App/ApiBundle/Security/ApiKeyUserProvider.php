<?php

namespace App\ApiBundle\Security;

use App\CoreBundle\Entity\Customer;
use App\CoreBundle\Repository\CustomerRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class ApiKeyUserProvider implements UserProviderInterface
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function getUsernameForApiKey($apiKey)
    {
        $user = $this->managerRegistry
            ->getRepository(Customer::class)
            ->findOneBy(['apiKey' => $apiKey]);

        if (!$user) {
            return null;
        }

        return $user->getUsername();
    }

    public function loadUserByUsername($username)
    {
        return new User(
            $username,
            null,
            array('ROLE_API_USER')
        );
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}