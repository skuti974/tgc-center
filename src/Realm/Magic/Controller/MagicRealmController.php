<?php

declare(strict_types=1);

namespace Tgc\Realm\Magic\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/realm/magic')]
class MagicRealmController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('magic/index.html.twig');
    }
}
