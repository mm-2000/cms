<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\PageTag;


class TestController extends AbstractController
{
    /**
     * @Route("/test/setadminrole", name="zlotekarty_testtesttest")
     */
    public function setadminrole(): Response
    {
    /*
        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $entityManager->getRepository(User::class);       
        $admin = $userRepository->findOneBy(['username'=>'admin']);
        $admin->setRoles(['ROLE_ADMIN']);
        $entityManager->flush();
      */  
        return $this->render('test/test.html.twig', []);
    } 

    /**
     * @Route("/test/test", name="zlotekarty_testtesttest")
     */
    public function checktest(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $a = $entityManager->getRepository(PageTag::class);       
        $pageTags = $a->findAll();

        $counter = 0;
        foreach($pageTags as $b){
            var_dump($b->getPageId());
            var_dump($b->getTagId());
            //var_dump($b->getPage()->getTitle());
            echo '<br><br><br>';
            $counter++;
            if($counter >= 100){
                echo '#####################################';
                break;
            }
        }

        die();
        //return $this->render('test/test.html.twig', []);
    } 

    /**
     * @Route("/test/setadminpassword", name="zlotekarty_test_setadminpassword")
     */
    public function setadminpassword(UserPasswordHasherInterface $passwordHasher): Response
    {
        /*
        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $entityManager->getRepository(User::class);       
        $admin = $userRepository->findOneBy(['username'=>'admin']);
        $hashedPassword = $passwordHasher->hashPassword(
            $admin,
            'password'
        );
        $admin->setPassword($hashedPassword);
        $entityManager->flush();
        */
        return $this->render('test/test.html.twig', []);
    } 
}