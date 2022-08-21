<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Tag;
use App\Entity\PageTag;
use App\Entity\Page;
use App\Form\Page\PageType;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    private function removeTags($page, $entityManager){
        $oldTags = $entityManager->getRepository(PageTag::class)->findBy(['pageId' => $page->getId()]);
        forEach($oldTags as $oldTag){
            $tag = $entityManager->getRepository(Tag::class)->findOneBy(['id' => $oldTag->getTagId()]);
            $entityManager->remove($tag);
            $entityManager->remove($oldTag);
        }
        $entityManager->flush();
    }

    private function newTags($page, $entityManager, $tagsString){
        $newTags = explode(',', $tagsString);
        $trimedNewTags = array();
        $temp = '';
        foreach($newTags as $newTag){
            $temp = trim($newTag);
            if(!empty($temp)){
                array_push($trimedNewTags, $temp);
            }
        }
        foreach($trimedNewTags as $tag){
            $oldTag = $entityManager->getRepository(Tag::class)->findOneBy(['name' => $tag]);
            if(empty($oldTag)){
                $oldTag = new Tag();
                $oldTag->setName($tag);
                $entityManager->persist($oldTag);
                $entityManager->flush();
            }
            $pageTag = new PageTag();
            $pageTag->setPageId($page->getId());
            $pageTag->setTagId($oldTag->getId()); 
            $entityManager->persist($pageTag);

        }
        $entityManager->flush();
    }



    /**
     * @Route("/", name="zlotekarty_admin_mainpage")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pagesRepository = $entityManager->getRepository(Page::class); 
        return $this->render('admin/admin.html.twig', 
        [
            'pages' => $pagesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/page/create", name="zlotekarty_page_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $page = new Page();
        $page->setCreateDateTime(new \DateTime('now'));

        $form = $this->createForm(PageType::class, $page);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $page = $form->getData();
            $user = $this->getUser();
            $page->setUser($user);
            $entityManager->persist($page);
            $entityManager->flush();

            $this->newTags($page, $entityManager, $request->request->get('page')['tags']);


            $this->addFlash('info', "Success!");

            return $this->redirectToRoute('zlotekarty_page_show', [ 'id' => $page->getId() ]);
        }

        return $this->renderForm('admin/page/new.html.twig', [
            'form' => $form,
        ]);       
    }

    /**
     * @Route("/page/{id}", name="zlotekarty_page_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Request $request, Page $page, EntityManagerInterface $entityManager): Response
    {
        $tags = $entityManager->getRepository(PageTag::class)->findByPageId($page->getId());
        return $this->renderForm('admin/page/show.html.twig', [
            'page' => $page,
            'tags' => $tags,
        ]);       
    }

    /**
     * @Route("/page/edit/{id}", name="zlotekarty_page_edit", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function edit(Request $request, Page $page, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->removeTags($page, $entityManager);
            $this->newTags($page, $entityManager, $request->request->get('page')['tags']);
            $this->addFlash('info', "Success!");

            return $this->redirectToRoute('zlotekarty_page_edit', [
              'id' => $page->getId()
            ]);
        }
        return $this->renderForm('admin/page/edit.html.twig', [
           'form' => $form
        ]);       
    }

    /**
     * @Route("/page/delete/{id}", name="zlotekarty_page_delete", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, Page $page, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {

            $entityManager = $this->getDoctrine()->getManager();
            $this->removeTags($page, $entityManager);
            $entityManager->remove($page);
            $entityManager->flush();

            $this->addFlash('info', "Page deleted!");
        }

        return $this->redirectToRoute('zlotekarty_admin_mainpage', []);
    }
}