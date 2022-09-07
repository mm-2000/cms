<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //admin
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $user->setPassword('$2y$13$onopPd6Ikfi1DcBfT4nX8.yP/Kd4ZOgwyR0KH6dbKj1cXY2pR7hk2');
        $user->setUsername('admin');
        $user->setIsVerified(true);
        $manager->persist($user);
        $manager->flush();

        //user
        $user = new User();
        $user->setEmail('user@user.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('$2y$13$onopPd6Ikfi1DcBfT4nX8.yP/Kd4ZOgwyR0KH6dbKj1cXY2pR7hk2');
        $user->setUsername('user');
        $user->setIsVerified(true);
        $manager->persist($user);
        $manager->flush();
    }
}
