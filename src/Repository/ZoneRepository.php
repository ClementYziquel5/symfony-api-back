<?php

/* 
            \\\||||||////
             \\  ~ ~  //
              (  @ @  )
___________ oOOo-(_)-oOOo________________
.......
....... 2021-2022 - Mini projet Framework Symfony - ReactJS
.......
....... @author Mathis QUEMENER (mathis.quemener@isen-ouest.yncrea.fr) - Clément YZIQUEL (clement.yziquel@isen-ouest.yncrea.fr)
....... 
....... @version 1.0
....... 
....... Fichier qui contient les fonctions exécutant les requêtes sql vers la table zone de la BDD.
.......
__________________Oooo.__________________
         .oooO    (   )
         (   )     ) /
          \ (     (_/
           \_)

*/

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Zone;


/**
 * @method Zone|null find($id, $lockMode = null, $lockVersion = null)
 * @method Zone|null findOneBy(array $criteria, array $orderBy = null)
 * @method Zone[]    findAll()
 * @method Zone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zone::class);
    }


    //Je redéfinis la médhode findAll afin d'avoir un résultat sous forme de tableau
    public function findAll() 
    {
        $em = $this->createQueryBuilder('z');

        return $em->getQuery()->getArrayResult();

    }

    //Fonction qui renvoie le nom de la zone en fonction de l'id passé
    public function findById($zone_id){
        $em = $this->createQueryBuilder('z');

        $em->andWhere('z.id = :zone_id')
        ->setParameter('zone_id', $zone_id);

        return $em->getQuery()->getArrayResult();

    }

    //Fonction pour l'api qui renvoie le nom et l'id de toutes les zones
    public function getZones()
    {
        $em = $this->createQueryBuilder('z')
        ->select('z.zone,z.id');


        return $em->getQuery()->getArrayResult();
    }
    
}
