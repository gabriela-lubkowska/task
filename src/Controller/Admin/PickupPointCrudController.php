<?php

namespace App\Controller\Admin;

use App\Entity\PickupPoint;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PickupPointCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PickupPoint::class;
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
