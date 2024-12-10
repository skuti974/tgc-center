<?php

declare(strict_types=1);

namespace Tgc\Controller;

use Tgc\Realm\Common\RealmManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/realm')]
class DashboardRealmController extends AbstractController
{
    #[Route('/', name: 'tgc_dashboard_realm_list', methods: ['GET'])]
    public function index(RealmManager $realmManager): Response
    {
        return $this->render('dashboard/realm/list.html.twig', [
            'realms' => $realmManager->realms(),
        ]);
    }

    #[Route('/{code}', name: 'tgc_dashboard_realm_details', methods: ['GET'])]
    public function details(RealmManager $realmManager, string $code): Response
    {
        return $this->forward($realmManager->realms()[$code]->controllerClasses()['realm'] . '::index');
    }
}
