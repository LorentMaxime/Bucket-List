<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\CategoryRepository;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{

    /**
     * @Route("/home", name="wish_home")
     */
    public function home(WishRepository $repo): Response
    {
        // $wishes = $repo->findBy(['isPublished'=>true], ['dateCreated'=>'DESC']);
        $wishes = $repo->findAll();
        return $this->render('back/home.html.twig',['wishes'=>$wishes]);
    }

/*-----------------------------------------------------------------------------*/    
    /**
     * @Route("/ajouter", name="wish_ajouter")
     */
    public function ajouter(Request $request): Response // par injection de dépendance
    {
        $em = $this->getDoctrine()->getManager();
        $wish = new Wish();
        $form = $this->createForm(WishType::class,$wish);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $wish->setDateCreated(new \DateTime());
            $em->persist($wish);
            $em->flush();
            return $this->redirectToRoute('wish_home');
        }
        return $this->render(
            'back/ajouter.html.twig',
            ['formWish' => $form->createView()]);
    }

/*--------------------------------------------------------------------------------*/
    /**
     * @Route("/enlever/{id}", name="wish_enlever")
     */

    public function enlever(Wish $wish, EntityManagerInterface $em): Response
    {
        $em->remove($wish);
        $em->flush();
        return $this->redirectToRoute('wish_home');

    }

/*--------------------------------------------------------------------------------*/
   /**
     * @Route("/liste", name="wish_liste")
     */
   public function liste(WishRepository $repo): Response
    {

        //$wishes = $repo->findBy(array(), array('date_created'=>'DESC'), array('isPublished'=>true));
        $wishes = $repo->findBy(['isPublished'=>true], ['dateCreated'=>'DESC']);
        return $this->json($wishes);

         
    }

/*---------------------------------------------------------------------------------*/
    /**
     * @Route("/categorie", name="wish_categorie")
     */

    public function listeCategory(CategoryRepository $repo):Response
    {
        $categories = $repo->findAll();
        return $this->json($categories);

    }

/*-----------------------------------------------------------------------------------*/
 /**
     * @Route("/modifier/{id}", name="wish_modifier")
     */
    public function modifier(Wish $wish, Request $request): Response // par injection de dépendance
    {
        $em = $this->getDoctrine()->getManager();
        //$wish = new Wish();
        $form = $this->createForm(WishType::class,$wish);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $wish->setDateCreated(new \DateTime());
            //$em->persist($wish);
            $em->flush();
            return $this->redirectToRoute('wish_home');
        }
        return $this->render(
            'back/modifier.html.twig',
            ['formWish' => $form->createView()]);
    }

   


}
