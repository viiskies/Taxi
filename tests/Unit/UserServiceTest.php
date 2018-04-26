<?php

namespace App\Tests\Unit;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    protected $userRepository;
    protected $userService;

    protected function setUp()
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->userService = new UserService($this->userRepository);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->userRepository = null;
        $this->userService = null;
    }

    public function testGetAmountWorksWith0Items()
    {
        $this->userRepository->method('findAll')->willReturn([]);

        $amount = $this->userService->getAmount();
        $this->assertEquals(0, $amount);
    }

    public function testGetAmountWith4Items()
    {
        $this->userRepository->method('findAll')->willReturn(
            [
            $this->createMock(User::class),
            $this->createMock(User::class),
            $this->createMock(User::class),
            $this->createMock(User::class)
            ]
        );

        $amount = $this->userService->getAmount();
        $this->assertEquals(4, $amount);
    }
}
