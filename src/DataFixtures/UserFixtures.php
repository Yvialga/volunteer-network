<?php

namespace App\DataFixtures;

use App\Entity\Organization;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        /** Admin manage and moderate all the accounts and the entire application network. */
        $admin = new User();
        $admin->setUsername("admin");
        $admin->setUpdatedAt(new \DateTimeImmutable("now"));
        $admin->setEmail('admin@volunteer-network.com');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, "Admin123"));
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        /** President is a member and leader of an organization, he can manage his organization's events. */
        $president = new User();
        $president->setUsername("president");
        $president->setEmail('president@myasso.com');
        $president->setUpdatedAt(new \DateTimeImmutable("now"));
        $president->setPassword($this->passwordHasher->hashPassword($president, "Present123"));
        $president->setRoles(["ROLE_BOARD_MEMBER"]);
        $president->addFkOrganizationId($this->getReference('MyAsso', Organization::class));
        $manager->persist($president);

        /** Volunteer participates to event that interest him. He is not affiliated with any organization. */
        $volunteer = new User();
        $volunteer->setUsername("volunteer");
        $volunteer->setEmail('j.doe@mycontacts.com');
        $volunteer->setUpdatedAt(new \DateTimeImmutable("now"));
        $volunteer->setPassword($this->passwordHasher->hashPassword($volunteer, "Volunteer123"));
        $volunteer->setRoles(["ROLE_VOLUNTEER"]);
        $manager->persist($volunteer);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OrganizationFixtures::class
        ];
    }
}
