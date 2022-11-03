<?php

namespace App\Controller;

use App\Entity\Acteurs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActeursRepository;

class ActeursController extends AbstractController
{
    /**
    * @Route("/acteurs", name="app_acteurs")
    */
    public function index(): Response
    {
        $acteurs = $this->getDoctrine()
            ->getRepository(Acteurs::class)
            ->findAll();
        return $this->render('acteurs/acteurs.html.twig', [
            'controller_name' => 'ActeursController',
            'acteurs'          => $acteurs
        ]);
    }

     /**
     * @Route("/acteur/{id}", name="acteur")
     */
    public function indiv(ActeursRepository $res ,$id): Response
    {
        $acteur=$res->find($id);
        return $this->render('acteurs/acteur.html.twig', [
            'controller_name' => 'ActeursController',
            'acteur'          => $acteur
        ]);
    }

    /**
    * @Route("/acteurs/create", name="app_acteurs_create")
    */
    public function create(Request $request): Response
    {
        if ($request->isMethod("POST")) {
            $acteur              = new Acteurs;
            $manager = $this->getDoctrine()->getManager();

            $image = $request->files->get('photo');
            $image_name = $image->getClientOriginalName();
            $image->move($this->getParameter('image_directory'),$image_name);
            // Insertion en BDD
         
            $acteur->setNom($request->request->get('nom'))
                ->setPrenom($request->request->get('prenom'))
                ->setDateDeNaissance(
                    \DateTime::createFromFormat('Y-m-d', $request->request->get('date_de_naissance'))
                )
                ->setDateDeMort(
                    \DateTime::createFromFormat('Y-m-d', $request->request->get('date_de_mort')) ?: null
                )
                ->setPhoto($image_name);
            $manager->persist($acteur);
            $manager->flush();
            
           
            return $this->redirectToRoute('app_acteurs');
        } else {
            // Affichage du formulaire
            return $this->render('acteurs/create.html.twig', [
                'controller_name' => 'ActeursController',
            ]);
        }
    }

    /**
    * @Route("/acteurs/{acteur}/edit", name="app_acteur_edit")
    */
    public function edit(Request $request, Acteurs $acteur): Response
    {
        if ($request->isMethod("POST")) {
            $manager = $this->getDoctrine()->getManager();

            $image = $request->files->get("photo");
            $image_name = $image->getClientOriginalName();
            $image->move($this->getParameter('image_directory'),$image_name);
            // Insertion en BDD
            $acteur->setNom($request->request->get('nom'))
                ->setPrenom($request->request->get('prenom'))
                ->setDateDeNaissance(
                    \DateTime::createFromFormat('Y-m-d', $request->request->get('date_de_naissance'))
                )
                ->setDateDeMort(
                    \DateTime::createFromFormat('Y-m-d', $request->request->get('date_de_mort')) ?: null
                )
                ->setPhoto($image_name);
            $manager->persist($acteur);
            $manager->flush();

            return $this->redirectToRoute('app_acteurs');
        } else {
            // Affichage du formulaire
            return $this->render('acteurs/edit.html.twig', [
                'controller_name' => 'ActeursController',
                'acteur'           => $acteur,
            ]);
        }
    }
    
    /**
    * @Route("/acteurs/{acteur}/delet", name="app_acteur_delete")
    */
    public function delete(Request $request, Acteurs $acteur): Response
    {
        $this->getDoctrine()->getManager()->remove($acteur);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('app_acteurs');
    }
    
}