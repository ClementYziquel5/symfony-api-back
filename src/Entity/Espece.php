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
....... Fichier lié à la table espece de la BDD. Il contient les champs, getters et setters
.......
__________________Oooo.__________________
         .oooO    (   )
         (   )     ) /
          \ (     (_/
           \_)

*/

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EspeceRepository;


/**
 * Espece
 *
 * @ORM\Table(name="espece")
 * @ORM\Entity(repositoryClass=EspeceRepository::class)
 */
class Espece
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="espece", type="string", length=50, nullable=false)
     */
    private $espece;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): self
    {
        $this->espece = $espece;

        return $this;
    }

    
    public function __toString(){
        return $this->espece;
    }


}
