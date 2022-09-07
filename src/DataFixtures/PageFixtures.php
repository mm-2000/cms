<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Page;
use App\Entity\User;
use App\Entity\Category;

class PageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user123@user123.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('$2y$13$onopPd6Ikfi1DcBfT4nX8.yP/Kd4ZOgwyR0KH6dbKj1cXY2pR7hk2');
        $user->setUsername('user123');
        $user->setIsVerified(true);
        $manager->persist($user);
        $manager->flush();

        $category = new Category();
        $category->setName('Category_test');
        $manager->persist($category);
        $manager->flush();

        $page = new Page();
        $page->setTitle('First title');
        $page->setContent('Lorem ipsum dolor cet emit.');
        $page->setCreateDateTime(new \DateTime('now'));
        $page->setUser($user);
        $page->setCategory($category);
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Next title');
        $page->setContent('Lorem ipsum dolor cet emit.');
        $page->setCreateDateTime(new \DateTime('now'));
        $page->setUser($user);
        $page->setCategory($category);
        $manager->persist($page);

        $manager->flush();
    }
}
