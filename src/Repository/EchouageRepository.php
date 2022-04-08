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
....... Fichier qui contient les fonctions exécutant les requêtes sql vers la table echouage de la BDD.
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
use Doctrine\ORM\Query\Expr;
use App\Entity\Echouage;


/**
 * @method Echouage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Echouage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Echouage[]    findAll()
 * @method Echouage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EchouageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Echouage::class);
    }

    //Fonction appellée par l'api pour la recherche du nombre d'échouages selon une date de début, fin et l'espèce.
    public function findByParameters($date_start,$date_end,$espece): ?array
    {
        $em = $this->createQueryBuilder('e');

        $em->join('e.zone', 'z')
        ->select('e.date,z.zone,z.id AS zone_id,sum(e.nombre) AS nombre');  


        if($date_start){ //Si une date de début est sélectionnée
            $em->andWhere('e.date >= :date_start')
            ->setParameter('date_start', $date_start);
        }

        if($date_end){ //Si une date de fin est sélectionnée
            $em->andWhere('e.date <= :date_end')
            ->setParameter('date_end', $date_end);
        }

        //Selon l'espece sélectionnée
        $em->andWhere('e.espece = :espece')
        ->setParameter('espece', $espece);

        //Arrangement des valeurs retournées
        $em->orderBy('zone_id,e.date,z.id')
        ->groupBy('e.date,z.zone');

        return $em->getQuery()->getArrayResult();
    }


    //Fonction qui renvoie les échouages selon la zone et l'espèce.
    public function getEchouages($zone_id, $espece_id)
    {
        $em = $this->createQueryBuilder('e')
        ->select('e.id,e.date,sum(e.nombre) as nombre');

        if($zone_id){ //Si une zone précise est sélectionnée
            $em->andWhere('e.zone = :zone_id')
            ->setParameter('zone_id', $zone_id);
        }

        //Sélection de l'espèce choisie
        $em->andWhere('e.espece = :espece_id')
        ->setParameter('espece_id', $espece_id);

        //Arrangement des valeurs retournées
        $em->orderBy('e.date','ASC')
        ->groupBy('e.date,e.zone');

        return $em->getQuery()->getArrayResult();
    }

    //Fonction qui renvoie toutes les dates où ont lieu des échouages
    public function getDates()
    {
        $em = $this->createQueryBuilder('e')
        ->select('e.date');

        $em->orderBy('e.date','ASC')
        ->groupBy('e.date');

        return $em->getQuery()->getResult();
    }
    
}
