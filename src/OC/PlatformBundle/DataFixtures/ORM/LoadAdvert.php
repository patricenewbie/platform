<?php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Category;

class LoadAdvert
{

    public function load(ObjectManager $manager)

    {

        // Liste des noms de catégorie à ajouter

        $names = array(

            'Recherche Développeur Angular 5',

            'Compétences Recherchées: Angular 5 niveau Junior. Débutant accepté',



        );

        $advert = new Advert();

        foreach ($names as $name) {

            // On crée la catégorie



            $advert->setTitre($name[0]);
            $advert->setAuthor('patrice');
            $advert->setContent($name[1]);
            $advert->setPublished(1);





        }

        // On la persiste
        $manager->persist($advert);

        // On déclenche l'enregistrement de toutes les catégories
         $manager->flush();

    }

}