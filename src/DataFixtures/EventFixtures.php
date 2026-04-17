<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Organization;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $event = new Event();
        $event->setTitle('Christmas market');
        $event->setDate(new \DateTimeImmutable('2026-07-01 12:00:00'));
        $event->setUpdatedAt(new \DateTimeImmutable('now'));
        $event->setFkOrganizationId($this->getReference('MyAsso', Organization::class));
        $manager->persist($event);
        $manager->flush();

        $this->addReference('christmas-market', $event);
    }

    public function getDependencies(): array
    {
        return [
            OrganizationFixtures::class
        ];
    }
}
