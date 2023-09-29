<?php

namespace App\Controller\Admin;

use App\Entity\CurrencyOrder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CurrencyOrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CurrencyOrder::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $order = $this->getDoctrine()->getRepository(CurrencyOrder::class)->find(11);
        dump($order->getOrderItems());
        return [
            IdField::new('id'),
            TextField::new('firstName', 'First Name'),
            TextField::new('lastName', 'Last Name'),
            TextField::new('addressLine1', 'Address Line 1'),
            TextField::new('addressLine2', 'Address Line 2'),
            TextField::new('city', 'City'),
            TextField::new('postalCode', 'Postal Code'),
            TextField::new('phone', 'Phone'),
            EmailField::new('email', 'Email'),
            CollectionField::new('orderItems')->onlyOnDetail(),
        ];
    }
}
