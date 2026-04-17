<?php

namespace App\DataFixtures;

use App\Entity\Organization;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrganizationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $myAsso = new Organization();
        $myAsso->setName('MyAsso');
        $myAsso->setUpdatedAt(new \DateTimeImmutable('now'));
        $manager->persist($myAsso);
        $manager->flush();

        $this->addReference('MyAsso', $myAsso);
    }
}
