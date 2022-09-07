<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Category name');
        $manager->persist($category);
        $manager->flush();

        $category = new Category();
        $category->setName('Category two');
        $manager->persist($category);
        $manager->flush();
    }
}
