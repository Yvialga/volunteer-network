<?php

namespace App\DataFixtures;

use App\DataFixtures\EventFixtures;
use App\Entity\Announcement;
use App\Entity\Event;
use App\Enum\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnnouncementFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $recruitment = new Announcement();
        $recruitment->setUpdatedAt(new \DateTimeImmutable('now'));
        $recruitment->setTitle('Looking for volunteer !!!');
        $recruitment->setStatus(Status::ACTIVE);
        $recruitment->setMessage('We looking for volunteer for the next edition of our event, we need some help to ...');
        $recruitment->setOpeningDate(new \DateTimeImmutable('now'));
        $recruitment->setFkEventId($this->getReference('christmas-market', Event::class));
        $manager->persist($recruitment);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventFixtures::class,
        ];
    }
}
