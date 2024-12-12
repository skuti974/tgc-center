<?php

declare(strict_types=1);

namespace Tgc\Realm\Pokemon\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Tgc\Realm\Pokemon\Repository\SerieRepository;

#[Route('/dashboard/realm/pokemon')]
class PokemonRealmController extends AbstractController
{
    #[Route('/', name: 'tgc_pokemon_realm', methods: ['GET'])]
    public function index(Request $request, SerieRepository $repository): Response
    {
        return $this->render('dashboard/realm/pokemon/index.html.twig', [
            'series' => $repository->findAllFromLocale($request->getLocale()),
        ]);
    }

//    #[Route('/test', name: 'aaaaaaaaaaaaaaa', defaults: ['_locale' => null])]
//    public function test(): Response
//    {
//        return $this->render('dashboard/realm/pokemon/test.html.twig');
//    }
}
