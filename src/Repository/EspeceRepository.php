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
....... Fichier qui contient les fonctions exécutant les requêtes sql vers la table espece de la BDD.
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
use App\Entity\Espece;


/**
 * @method Espece|null find($id, $lockMode = null, $lockVersion = null)
 * @method Espece|null findOneBy(array $criteria, array $orderBy = null)
 * @method Espece[]    findAll()
 * @method Espece[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EspeceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Espece::class);
    }

    //Fonction qui renvoie le nom de l'espèce en fonction de l'id passé
    public function getEspeceName($espece_id)
    {
        $em = $this->createQueryBuilder('e')
        ->select('e.espece')
        ->andWhere('e.id = :espece_id')
        ->setParameter('espece_id', $espece_id);


        return $em->getQuery()->getOneOrNullResult();
    }

    
    //Fonction pour l'api qui renvoie le nom et l'id de toutes les espèces
    public function getEspeces()
    {
        $em = $this->createQueryBuilder('e')
        ->select('e.espece,e.id');

        return $em->getQuery()->getArrayResult();
    }
    
}
