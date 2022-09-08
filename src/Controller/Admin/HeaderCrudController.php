<?php

namespace App\Controller\Admin;

use App\Entity\Header;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class HeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Header::class;
    }

 
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre du header'),
            TextareaField::new('content', 'Contenu de notre header'),
            TextField::new('btnTitle', 'Titre de notre bouton'),
            TextField::new('btnUrl', 'Destination de notre bouton'),
            ImageField::new('illustration')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            ChoiceField::new('backgroundPosition', "Alignement de l'image")
                    ->autocomplete()
                    ->setChoices([  'Centré' => 'center',
                                    'Haut' => 'top',
                                    'Bas' => 'bottom',
                                    'A droite' => 'right',
                                    'A gauche' => 'left'
                                    ] ),
            ChoiceField::new('textColor', 'couleur du text')
                    ->autocomplete()
                    ->setChoices([  'blanc' => '#fff',
                                    'sombre' => '#3b4045',
                                    ])
        ];
    }

}
