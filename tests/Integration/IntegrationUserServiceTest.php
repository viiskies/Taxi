<?php

namespace App\Tests\Integration;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Input\ArrayInput;

class IntegrationUserServiceTest extends KernelTestCase
{
    protected $userService;

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();

         $kernel = self::createKernel();
         $application = new Application($kernel);
         $application->setAutoExit(false);

         $application->run(new ArrayInput([
             'command' => 'doctrine:database:drop',
             '--force' => true
         ]));

         $application->run(new ArrayInput([
             'command' => 'doctrine:database:create'
         ]));

         $application->run(new ArrayInput([
             'command' => 'doctrine:migrations:migrate',
             '--no-interaction' => true
         ]));

         $application->run(new ArrayInput([
             'command' => 'doctrine:fixtures:load',
             '--append' => true
         ]));

        $userRepository = $kernel->getContainer()
            ->get('doctrine')
            ->getRepository(User::class);

        /** @var UserService $userRepository */
        $this->userService = new UserService($userRepository);
    }

    public function testSomething()
    {
        $result = $this->userService->getAmount();
        $this->assertEquals(5, $result);
    }
}
