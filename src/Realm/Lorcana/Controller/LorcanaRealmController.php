<?php

declare(strict_types=1);

namespace Tgc\Realm\Lorcana\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/realm/lorcana')]
class LorcanaRealmController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('lorcana/index.html.twig');
    }
}
