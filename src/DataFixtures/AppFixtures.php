<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Plan;
use App\Entity\PlacedItem;
use App\Entity\ItemCatalog;
use App\Entity\Recommendation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // ---------------------
        // Création d'utilisateurs
        // ---------------------
        $user1 = new User();
        $user1->setEmail('alice@example.com');
        $user1->setPassword(password_hash('password1', PASSWORD_BCRYPT));
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('bob@example.com');
        $user2->setPassword(password_hash('password2', PASSWORD_BCRYPT));
        $manager->persist($user2);

        // ---------------------
        // Création de catalog items
        // ---------------------
        $chair = new ItemCatalog();
        $chair->setName('Chaise');
        $chair->setCategory('Meuble');
        $chair->setStyle('Moderne');
        $chair->setImageSvg('chair.svg');
        $chair->setDefaultWidth(50);
        $chair->setDefaultHeight(50);
        $manager->persist($chair);

        $table = new ItemCatalog();
        $table->setName('Table');
        $table->setCategory('Meuble');
        $table->setStyle('Classique');
        $table->setImageSvg('table.svg');
        $table->setDefaultWidth(100);
        $table->setDefaultHeight(60);
        $manager->persist($table);

        // ---------------------
        // Création de plans
        // ---------------------
        $plan1 = new Plan();
        $plan1->setName('Salon Alice');
        $plan1->setWidth(500);
        $plan1->setHeight(400);
        $plan1->setOwner($user1);
        $plan1->setCreatedAt(new \DateTime());
        $plan1->setUpdatedAt(new \DateTime());
        $manager->persist($plan1);

        $plan2 = new Plan();
        $plan2->setName('Bureau Bob');
        $plan2->setWidth(300);
        $plan2->setHeight(200);
        $plan2->setOwner($user2);
        $plan2->setCreatedAt(new \DateTime());
        $plan2->setUpdatedAt(new \DateTime());
        $manager->persist($plan2);

        // ---------------------
        // Placed Items
        // ---------------------
        $placedChair = new PlacedItem();
        $placedChair->setX(50);
        $placedChair->setY(60);
        $placedChair->setRotation(0);
        $placedChair->setCurrentWidth(50);
        $placedChair->setCurrentHeight(50);
        $placedChair->setPlan($plan1);
        $placedChair->setCatalogItem($chair);
        $manager->persist($placedChair);

        $placedTable = new PlacedItem();
        $placedTable->setX(100);
        $placedTable->setY(150);
        $placedTable->setRotation(0);
        $placedTable->setCurrentWidth(100);
        $placedTable->setCurrentHeight(60);
        $placedTable->setPlan($plan2);
        $placedTable->setCatalogItem($table);
        $manager->persist($placedTable);

        // ---------------------
        // Recommendations
        // ---------------------
        $rec1 = new Recommendation();
        $rec1->setType('Conseil');
        $rec1->setMessage('Placer la table près de la fenêtre');
        $rec1->setCreatedAt(new \DateTime());
        $rec1->setPlan($plan2);
        $manager->persist($rec1);

        $rec2 = new Recommendation();
        $rec2->setType('Astuce');
        $rec2->setMessage('Éviter de bloquer le passage avec les chaises');
        $rec2->setCreatedAt(new \DateTime());
        $rec2->setPlan($plan1);
        $manager->persist($rec2);

        // ---------------------
        // Envoi en BDD
        // ---------------------
        $manager->flush();
    }
}