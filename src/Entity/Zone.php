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
....... Fichier lié à la table zone de la BDD. Il contient les champs, getters et setters
.......
__________________Oooo.__________________
         .oooO    (   )
         (   )     ) /
          \ (     (_/
           \_)

*/

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;

/**
 * Zone
 *
 * @ORM\Table(name="zone")
 * @ORM\Entity(repositoryClass=ZoneRepository::class)
 */
class Zone
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
     * @ORM\Column(name="zone", type="string", length=50, nullable=false)
     */
    private $zone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(string $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function __toString(){
        return $this->zone;
    }
}
