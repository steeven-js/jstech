<?php

namespace App\Controller\Admin;

use App\Entity\CategorySmartphone;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategorySmartphoneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategorySmartphone::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
