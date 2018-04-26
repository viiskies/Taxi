<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername($faker->lastName);
            $password = $this->userPasswordEncoder->encodePassword($user, 'vitkis');
            $user->setPassword($password);
            $user->setRoles(['ROLE_ADMIN']);

            $manager->persist($user);
        }
        $manager->flush();
    }
}