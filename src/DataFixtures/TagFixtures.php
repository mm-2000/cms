<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Tag;


class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tag = new Tag();
        $tag->setName('first tag');
        $manager->persist($tag);

        $manager->flush();

        $tag = new Tag();
        $tag->setName('next tag');
        $manager->persist($tag);

        $manager->flush();
    }
}
