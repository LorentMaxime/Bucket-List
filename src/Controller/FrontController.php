<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\CategoryRepository;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(CategoryRepository $repo): Response
    {
        //$wishes = $repo->findBy(array(), array('dateCreated'=>'DESC'), array('isPublished'=>true)); peut etre formulé comme ci-dessous
        //$wishes = $repo->findBy(['isPublished'=>true], ['dateCreated'=>'DESC']);
        $categories = $repo->findByPublished();
        return $this->render('front/home.html.twig',['categories'=>$categories]);
    }

/*----------------------------------------------------------------------------*/    
    /**
     * @Route("/detail/{id}", name="wish_detail")
     */
    public function detail(Wish $wish): Response
    {
        return $this->render('front/detail.html.twig', ['wish'=> $wish]);
    }

    /**
     * @Route("/about-us", name="about")
     */
    public function about(): Response
    {
        return $this->render('front/about.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('front/contact.html.twig');
    }

    /**
     * @Route("/services", name="services")
     */
    public function services(): Response
    {
        return $this->render('front/services.html.twig');
    }

}
