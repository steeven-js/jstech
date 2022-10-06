<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add('index', 'detail');
    }

    // Modification du trie par défault (Du plus ancien au plus vieux DESC)
    public function configureCrud(Crud $crud): Crud
    {
        // J'affiche mes category par défaut par ordre ascendant (par ordre alphabétique pour un meilleur regroupement des produits)
        return $crud->setDefaultSort(['category' => 'ASC']);

    }

    // Configuration des champs de easy admin en lien avec l'entité Product
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name')->hideOnIndex(),
            TextField::new('subtitle')->hideOnIndex(),
            TextareaField::new('description')->hideOnIndex(),
            TextareaField::new('description1', 'Détails')->hideOnIndex(), 
            BooleanField::new('isBest'),
            BooleanField::new('isNew'),
            ImageField::new('illustration')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            ImageField::new('illustration1')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            ImageField::new('illustration2')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            ImageField::new('illustration3')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('category'),
        ];
    }

    // Ajout d'un système de filtre
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('category')
        ;
    }
 
}
