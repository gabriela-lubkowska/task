<?php

namespace App\Controller\Admin;

use App\Entity\CurrencyOrder;
use App\Entity\PickupPoint;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        {
            return $this->render('admin_dashboard/index.html.twig');
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Task');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Pickup Points', 'fas fa-list', PickupPoint::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-list', CurrencyOrder::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
    }
}
