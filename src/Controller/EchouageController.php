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
....... Fichier qui permet la gestion de la table echouage de la BDD
....... Il permet aussi de faire correspondre les routes de aux fonction associées pour la gestion de la partie back-office
.......
__________________Oooo.__________________
         .oooO    (   )
         (   )     ) /
          \ (     (_/
           \_)

*/

namespace App\Controller;

use App\Entity\Echouage;
use App\Entity\Espece;
use App\Entity\Zone;
use App\Form\EchouageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/echouage")
 */
class EchouageController extends AbstractController
{
    /**
     * @Route("/accueil", name="echouage_accueil", methods={"GET"})
     */

    //La fonction accueil récupère la liste des zones et espèces afin de créer le formulaire dans la vue
    public function accueil(): Response
    {
        $zones = $this->getDoctrine()
            ->getRepository(Zone::class)
            ->findAll();
        
        $especes = $this->getDoctrine()
            ->getRepository(Espece::class)
            ->findAll();
        
        return $this->render('echouage/accueil.html.twig', [
            'zones' => $zones,
            'especes' => $especes,
        ]);
    }

    /**
     * @Route("/search", name="echouage_search", methods={"GET"})
     */

    //La fonction search prend comme paramètre la requête passées par le formulaire contenant zone_id et espece_id
    //Elle renvoie le nom de l'espèce sélectionnée ($espece_name['espece']), le ou les noms de zone en fonction de ce que l'utilisateur souhaite($zone_names), et un tableau contenant pour chaque date, le nombre d'échouage dans la zone($echouageByDateAndZone)
    public function search(Request $requete): Response
    {
        $espece_id = $requete->query->get("espece");
        $zone_id = $requete->query->get("zone");

        $espece_name = $this->getDoctrine()->getRepository(Espece::class)->getEspeceName($espece_id);

        $echouages = $this->getDoctrine()->getRepository(Echouage::class)->getEchouages($zone_id,$espece_id);
        
        //Je créé un tableau qui contient toutes les dates une seule fois
        $dates_array = [];
        foreach ($echouages as $echouage) {
            array_push($dates_array,$echouage['date']);
        }


        $echouageByDateAndZone = [];

        if(!$zone_id){ //Si toutes les zones sélectionnées
            $zone_names = $this->getDoctrine()->getRepository(Zone::class)->findAll(); //Récupère le nom et id de chaque zone


            foreach ($zone_names as $zone) { //Pour chaque zone, j'ajoute à $echouageByDateAndZone les dates et le nombre d'echouages asssocié
                $dateNumberArray = [];
                $echouagesByZone = $this->getDoctrine()->getRepository(Echouage::class)->getEchouages($zone['id'],$espece_id); //Récupère les echouages en fonction d'une espece dans une zone

                foreach ($dates_array as $date) { //Pour chaque date je cherche le nombre d'echouages associé
                    $date_count = 0;
                    foreach ($echouagesByZone as $echouageByZone ) {
                        if($echouageByZone['date']==$date) $date_count = $echouageByZone['nombre']; //Si l'echouage a eu lieu à cette date
                    }
                    $dateNumberArray[$date] = $date_count; //Contient 'date'=>'nombreEchouagesACetteDate'
                }
                $echouageByDateAndZone[$zone['id']] = $dateNumberArray; 
            }

        }else{ //Si une seule zone est sélectionnée
            $dateNumberArray = []; 
            foreach ($dates_array as $date) { //Pour chaque date je cherche le nombre d'echouages associé
                $date_count = 0;
                foreach ($echouages as $echouage ) {
                    if($echouage['date']==$date)  $date_count = $echouage['nombre']; //Si l'echouage a eu lieu à cette date
                }
                $dateNumberArray[$date] = $date_count; //Contient 'date'=>'nombreEchouagesACetteDate'
            }
            $zone_names = $this->getDoctrine()->getRepository(Zone::class)->findById($zone_id); //Contient une seule zone, correspondant à $zone_id
            $echouageByDateAndZone[$zone_names[0]['id']] = $dateNumberArray; 
        }

        return $this->render('echouage/search.html.twig', [
            'echouages' => $echouageByDateAndZone,
            'zones' => $zone_names,
            'espece' => $espece_name['espece'],
        ]);    
    }

    /**
     * @Route("/", name="echouage_index", methods={"GET"})
     */

    //Fonction générée par CRUD pour afficher toutes les echouages et les liens pour créer, afficher, modifier, supprimer un echouage
    public function index(): Response
    {
        $echouages = $this->getDoctrine()
            ->getRepository(Echouage::class)
            ->findAll();

        return $this->render('echouage/index.html.twig', [
            'echouages' => $echouages,
        ]);
    }

    /**
     * @Route("/new", name="echouage_new", methods={"GET","POST"})
     */

    //Fonction générée par CRUD pour créer un echouage
    public function new(Request $request): Response
    {
        $echouage = new Echouage();
        $form = $this->createForm(EchouageType::class, $echouage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($echouage);
            $entityManager->flush();

            return $this->redirectToRoute('echouage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('echouage/new.html.twig', [
            'echouage' => $echouage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="echouage_show", methods={"GET"})
     */

    //Fonction générée par CRUD pour afficher une echouage
    public function show(Echouage $echouage): Response
    {
        return $this->render('echouage/show.html.twig', [
            'echouage' => $echouage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="echouage_edit", methods={"GET","POST"})
     */

    //Fonction générée par CRUD pour modifier un echouage
    public function edit(Request $request, Echouage $echouage): Response
    {
        $form = $this->createForm(EchouageType::class, $echouage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('echouage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('echouage/edit.html.twig', [
            'echouage' => $echouage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="echouage_delete", methods={"POST"})
     */

    //Fonction générée par CRUD pour supprimer un echouage
    public function delete(Request $request, Echouage $echouage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$echouage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($echouage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('echouage_index', [], Response::HTTP_SEE_OTHER);
    }
}
