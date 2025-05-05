<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use App\Entity\Song;
use App\Entity\Album;
use App\Entity\Device;
use App\Entity\Event;
use App\Entity\Image;
use App\Entity\Profile;
use App\Entity\Vibe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //Redirection par defaut vers la liste des genres
        $url = $this->adminUrlGenerator
            ->setController(RoomCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dashboard')
            ->setFaviconPath('images/logo2.png')
            ->renderContentMaximized(); // utilise tout l'espace de l'écran
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linkToUrl('Accueil', 'fa fa-home', 'http://localhost:8082/admin');
        yield MenuItem::linkToUrl('Aller sur le Swagger', 'fa fa-code', 'http://localhost:8082/api')->setLinkTarget('_blank');;


        //1ere section "catalogue"
        yield MenuItem::section('Maison');
        // sous menu pour les genres
        yield MenuItem::subMenu('Pièces', 'fa fa-tags')->setSubItems([
            MenuItem::linkToCrud('Ajouter une pièce', 'fa fa-plus-circle', Room::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les pièces', 'fa fa-eye', Room::class)
        ]);
        // sous menu pour les albums
        yield MenuItem::subMenu('Appareils', 'fa fa-record-vinyl')->setSubItems([
            MenuItem::linkToCrud('Ajouter un appareil', 'fa fa-plus-circle', Device::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les appareils', 'fa fa-eye', Device::class)
        ]);
        // sous-menu pour les chansons
        yield MenuItem::subMenu('Chansons', 'fa fa-music')->setSubItems([
            MenuItem::linkToCrud('Ajouter une chanson', 'fa fa-plus-circle', Song::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les chansons', 'fa fa-eye', Song::class)
        ]);

        //2eme section "chanteur et avatars"
        yield MenuItem::section('Profils et ');
        // sous menu pour les chanteurs
        yield MenuItem::subMenu('Profile', 'fa fa-user-plus')->setSubItems([
            MenuItem::linkToCrud('Ajouter un profil', 'fa fa-plus-circle', Profile::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les profils', 'fa fa-eye', Profile::class)
        ]);
        // sous menu pour les avatars
        yield MenuItem::subMenu('Images', 'fa fa-image')->setSubItems([
            MenuItem::linkToCrud('Ajouter une image', 'fa fa-plus-circle', Image::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les images', 'fa fa-eye', Image::class)
        ]);
        //menu pour gerer les abonnements
        yield MenuItem::subMenu('Evenements', 'fa fa-credit-card')->setSubItems([
            MenuItem::linkToCrud('Ajouter un évenement', 'fa fa-plus-circle', Event::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les évenements', 'fa fa-eye', Event::class)
        ]);
        yield MenuItem::subMenu('Ambiances', 'fa fa-credit-card')->setSubItems([
            MenuItem::linkToCrud('Ajouter une ambiance', 'fa fa-plus-circle', Vibe::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les ambiances', 'fa fa-eye', Vibe::class)
        ]);
    }
}
