<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Hide on form to avoid editing

            EmailField::new('email'),

            MoneyField::new('balance')
                ->setCurrency('USD') // Adjust to your preferred currency
                ->hideOnIndex(),    // Hide on the listing page for privacy reasons

            ChoiceField::new('roles')
                ->allowMultipleChoices()
                ->setChoices([
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    // ... add more roles as needed
                ]),

//            // Add a virtual field to add balance (this won't map directly to the entity property)
//            IntegerField::new('addBalance', 'Add Balance')
//                ->onlyOnForms() // Only show on create/edit forms
//                ->setHelp('Enter a positive number to add to the balance or a negative to subtract.'),
        ];
    }
}
