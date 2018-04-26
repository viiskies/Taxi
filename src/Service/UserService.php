<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService {

    /**
     * @var \App\Repository\UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAmount()
    {
        $users = $this->userRepository->findAll();
        return count($users);
    }

}