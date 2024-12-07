<?php

declare(strict_types=1);

namespace App\Controller;

use App\Realm\Common\RealmManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/realm')]
class DashboardRealmController extends AbstractController
{
    #[Route('/', name: 'dashboard_realm_list', methods: ['GET'])]
    public function index(RealmManager $realmManager): Response
    {
        return $this->render('dashboard/realm/list.html.twig', [
            'realms' => $realmManager->realms(),
        ]);
    }
}
