<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Client;
use App\Entity\Transaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Basic extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $client = new Client('$firstName', '$lastName', '$country');
        $acc1 = new Account('USD', $client);
        $acc2 = new Account('GBP', $client);
        $acc1->updateBalance(333);
        $acc2->updateBalance(222);
        $t1 = new Transaction($acc1, $acc2, 111, 'USD');
        sleep(1);
        $t2 = new Transaction($acc2, $acc1, 111, 'GBP');


        $manager->persist($client);
        $manager->persist($acc1);
        $manager->persist($acc2);
        $manager->persist($t1);
        $manager->persist($t2);

        $manager->flush();
    }
}
