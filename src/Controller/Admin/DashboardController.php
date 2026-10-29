<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Entity\Commodite;
use App\Entity\Conversation;
use App\Entity\Espace;
use App\Entity\Message;
use App\Entity\PhotoEspace;
use App\Entity\TypeEspace;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sae3 01');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Gestion des utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', Utilisateur::class);

        yield MenuItem::section('Gestion des conversations');
        yield MenuItem::linkToCrud('Conversation', 'fa fa-comment-dots', Conversation::class);
        yield MenuItem::linkToCrud('Messages', 'fa fa-envelope', Message::class);

        yield MenuItem::section('Gestion des espaces');
        yield MenuItem::linkToCrud('Espaces', 'fa fa-building', Espace::class);
        yield MenuItem::linkToCrud('Types d\'espace', 'fa fa-layer-group', TypeEspace::class);
        yield MenuItem::linkToCrud('Commodités', 'fa fa-box-open', Commodite::class);
        yield MenuItem::linkToCrud('Photos des espaces', 'fa fa-photo', PhotoEspace::class);

        yield MenuItem::section('Gestion des avis');
        yield MenuItem::linkToCrud('Avis', 'fa fa-star', Avis::class);
    }
}
