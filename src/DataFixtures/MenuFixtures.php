<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\MenuElement;


class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $menuElement = new MenuElement();
        $menuElement->setName('menu element one');
        $menuElement->setType('href');
        $menuElement->setHref('/one');
        $manager->persist($menuElement);
        $manager->flush();

        $menuElement = new MenuElement();
        $menuElement->setName('menu element two');
        $menuElement->setType('href');
        $menuElement->setHref('/two');
        $manager->persist($menuElement);
        $manager->flush();
    }
}
