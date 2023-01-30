<?php

namespace App\Service;

use App\Entity\Credential;
use App\Repository\CredentialRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CredentialManager
{

    private UserPasswordHasherInterface $passwordHasher;
    private CredentialRepository $credentialRepository;

    public function __construct(UserPasswordHasherInterface $passwordHasher, CredentialRepository $credentialRepository){
        $this->passwordHasher = $passwordHasher;
        $this->credentialRepository = $credentialRepository;
    }

    public function createAdmin(string $email, string $password){
        $user = new Credential();
        $user
            ->setEmail($email)
            ->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $password
                )
            )
            ->setRoles(['ROLE_ADMIN']);

        $this->credentialRepository->save($user, true);
    }


}