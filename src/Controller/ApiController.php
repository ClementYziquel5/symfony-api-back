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
....... Fichier qui permet de faire correspondre les routes de l'API aux fonctions associées
.......
__________________Oooo.__________________
         .oooO    (   )
         (   )     ) /
          \ (     (_/
           \_)

*/

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Echouage;
use App\Repository\EchouageRepository;

use App\Entity\Espece;
use App\Repository\EspeceRepository;

use App\Entity\Zone;
use App\Repository\ZoneRepository;

/**
 * @Route("/api/v1.0", name="api_")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/echouages/{date_start}/{date_end}/{espece}", name="echouages")
     */

    //Recuperation de la liste des echouages correspondants aux crières passés au travers du repository     
    public function findEchouage($date_start,$date_end,$espece): Response
    {   
        $echouages = $this->getDoctrine()->getRepository(Echouage::class)->findByParameters($date_start,$date_end,$espece);
            
        //reponse du controlleur en indiquant le format json et
        // en ajoutant la balise "Access-Control-Allow-Origin"
        // dans l'en-tete HTTP pour eviter les probleme de refus du au CORS
        $response = new Response();
        $response->setContent(json_encode($echouages));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/especes", name="especes")
     */

    //Recuperation de la liste des especes au travers du repository
    public function getAllEspeces(): Response
    {            
        //Recuperation de la liste des especes au travers du repository        
        $espece = $this->getDoctrine()->getRepository(Espece::class)->getEspeces();
            
        //reponse du controlleur en indiquant le format json et
        // en ajoutant la balise "Access-Control-Allow-Origin"
        // dans l'en-tete HTTP pour eviter les probleme de refus du au CORS
        $response = new Response();
        $response->setContent(json_encode($espece));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/dates", name="dates")
     */

    //Recuperation de la liste des dates au travers du repository
    public function getAllDates(): Response
    {                    
        $dates = $this->getDoctrine()->getRepository(Echouage::class)->getDates();
            
        //reponse du controlleur en indiquant le format json et
        // en ajoutant la balise "Access-Control-Allow-Origin"
        // dans l'en-tete HTTP pour eviter les probleme de refus du au CORS
        $response = new Response();
        $response->setContent(json_encode($dates));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/zones", name="zones")
     */

    //Recuperation de la liste des zones au travers du repository        
    public function getAllZones(): Response
    {            
        $zones = $this->getDoctrine()->getRepository(Zone::class)->getZones();
            
        //reponse du controlleur en indiquant le format json et
        // en ajoutant la balise "Access-Control-Allow-Origin"
        // dans l'en-tete HTTP pour eviter les probleme de refus du au CORS
        $response = new Response();
        $response->setContent(json_encode($zones));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}
