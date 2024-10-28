<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$email, $password]) {
            $user = new User();
            $user->setPassword(md5($password));
            $user->setEmail($email);
            $manager->persist($user);
        }

        $manager->flush();
    }
    private function getUserData(): array
    {
        return [
            ['tom@email.com', 'user123'],
            ['john@email.com', 'user123'],
            ['jane@email.com', 'user123'],
        ];
    }
}
