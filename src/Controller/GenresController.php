<?php

namespace App\Controller;

use App\Entity\Genres;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenresController extends AbstractController
{
    /**
     * @Route("/genres", name="app_genres")
     */
    public function index(): Response
    {
        $genres = $this->getDoctrine()
            ->getRepository(Genres::class)
            ->findAll();
        return $this->render('genres/genres.html.twig', [
            'controller_name' => 'GenresController',
            'genres'          => $genres
        ]);
    }

    /**
    * @Route("/genres/create", name="app_genres_create")
    */
    public function create(Request $request): Response
    {
        if ($request->isMethod("POST")) {
            $manager = $this->getDoctrine()->getManager();
            // Insertion en BDD
            $genre              = new Genres;
            $genre->setNom($request->request->get('nom'));

            $manager->persist($genre);
            $manager->flush();

            return $this->redirectToRoute('app_genres');
        } else {
            // Affichage du formulaire
            return $this->render('genres/create.html.twig', [
                'controller_name' => 'GenresController',
            ]);
        }
    }

    /**
     * @Route("/genres/{genre}/edit", name="app_genre_edit")
     */
    public function edit(Request $request, Genres $genre): Response
    {
        if ($request->isMethod("POST")) {
            $manager = $this->getDoctrine()->getManager();
            // Insertion en BDD
            $genre->setNom($request->request->get('nom'));

            $manager->flush();

            return $this->redirectToRoute('app_genres');
        } else {
            // Affichage du formulaire
            return $this->render('genres/edit.html.twig', [
                'controller_name' => 'GenresController',
                'genre'           => $genre,
            ]);
        }
    }

    /**
     * @Route("/genres/{genre}/delet", name="app_genre_delete")
     */
    public function delete(Request $request, Genres $genre): Response
    {
        $this->getDoctrine()->getManager()->remove($genre);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('app_genres');
    }



}