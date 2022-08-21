<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\MenuElement;
use App\Form\Menu\MenuType;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/admin/menu")
 */
class MenuController extends AbstractController
{
    /**
     * @Route("/", name="zlotekarty_menu_list")
     */
    public function list(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(MenuElement::class); 
        return $this->render('admin/menu/list.html.twig', 
        [
            'menuElements' => $repository->findAll(),
        ]
    );
    }

    /**
     * @Route("/create", name="zlotekarty_menu_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = new MenuElement();

        $form = $this->createForm(MenuType::class, $menu);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $menu = $form->getData();
            $entityManager->persist($menu);
            $entityManager->flush();

            $this->addFlash('info', "Success!");

            return $this->redirectToRoute('zlotekarty_menu_show', [ 'id' => $menu->getId() ]);
        }

        return $this->renderForm('admin/menu/new.html.twig', [
            'form' => $form,
        ]);       
    }

    /**
     * @Route("/{id}", name="zlotekarty_menu_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Request $request, MenuElement $menu): Response
    {
        return $this->renderForm('admin/menu/show.html.twig', [
            'menuElement' => $menu,
        ]);       
    }

    /**
     * @Route("/edit/{id}", name="zlotekarty_menu_edit", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function edit(Request $request, MenuElement $menu): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('info', "Success!");

            return $this->redirectToRoute('zlotekarty_menu_edit', [
              'id' => $menu->getId()
            ]);
        }
        return $this->renderForm('admin/menu/edit.html.twig', [
           'form' => $form
        ]);       
    }

    /**
     * @Route("/delete/{id}", name="zlotekarty_menu_delete", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, MenuElement $menu): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($menu);
            $entityManager->flush();

            $this->addFlash('info', "Menu Link deleted!");
        }

        return $this->redirectToRoute('zlotekarty_menu_list', []);
    }

    public function createMainMenu(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(MenuElement::class); 
        return $this->render('mainMenu.html.twig', 
        [
            'menuElements' => $repository->findAll(),
        ]);
    }
}