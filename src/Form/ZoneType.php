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
....... Fichier qui correspond au formulaire auto-généré par symfony pour la table zone.
.......
__________________Oooo.__________________
         .oooO    (   )
         (   )     ) /
          \ (     (_/
           \_)

*/

namespace App\Form;

use App\Entity\Zone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('zone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Zone::class,
        ]);
    }
}
