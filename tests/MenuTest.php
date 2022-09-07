<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use App\Repository\MenuElementRepository;
use App\Repository\PageRepository;

class MenuTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $menuRepository = static::getContainer()->get(MenuElementRepository::class);
        $menus = $menuRepository->findAll();
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/menu/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.table', $menus[0]->getName());
        $this->assertSelectorTextContains('.table', $menus[0]->getType());
        $this->assertSelectorTextContains('.table', $menus[1]->getName());
        $this->assertSelectorTextContains('.table', $menus[1]->getType());
    }

    public function testCreateForm(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $pageRepository = static::getContainer()->get(PageRepository::class);
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $pages = $pageRepository->findAll();
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/menu/new');
        $this->assertResponseIsSuccessful();
        $buttonCrawlerNode = $crawler->selectButton('Save');
        $form = $buttonCrawlerNode->form();
        $form['menu[name]'] = 'Menu name';
        $form['menu[type]']->select('href');
        $form['menu[href]'] = '/somewhere';
        $form['menu[pageId]']->select($pages[0]->getId());
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('#info-box', 'Success!'); 
        $this->assertSelectorTextContains('.table', 'Menu name');
    }

    public function testShowTag(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $menuRepository = static::getContainer()->get(MenuElementRepository::class);
        $menus = $menuRepository->findAll();     
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/menu/' . $menus[0]->getId() . '/', ['id' => $menus[0]->getId()]); 
        $crawler = $client->followRedirect();     
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.menuName', $menus[0]->getName());
    }

    public function testSendEditForm(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $menuRepository = static::getContainer()->get(MenuElementRepository::class);
        $pageRepository = static::getContainer()->get(PageRepository::class);
        $pages = $pageRepository->findAll();
        $menu = $menuRepository->findOneBy(['name' => 'menu element one']); 
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/menu/' . $menu->getId() . '/edit/', ['id' => $menu->getId()]);
        $this->assertResponseIsSuccessful();

        $buttonCrawlerNode = $crawler->selectButton('Save');
        $form = $buttonCrawlerNode->form();
        $form['menu[name]'] = 'New name';
        $form['menu[type]']->select('page');
        $form['menu[href]'] = '/somewhere';
        $form['menu[pageId]']->select($pages[1]->getId());
        $client->submit($form);
        //$this->assertResponseIsSuccessful();
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('#info-box', 'Success!');
        $menu = $menuRepository->findOneBy(['id' => $menu->getId() ]);
        $this->assertEquals( 'New name', $menu->getName());
    }
/*
    public function testDeleteCategory(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $menuRepository = static::getContainer()->get(MenuElementRepository::class);
        $menu = $menuRepository->findOneBy(['name' => 'menu element two']);     
        $categoryId = $menu->getId();
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/menu/' . $menu->getId(), ['id' => $menu->getId()]);      
        $this->assertResponseIsSuccessful();
        $buttonCrawlerNode = $crawler->selectButton('Delete');
        $form = $buttonCrawlerNode->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('#info-box', 'Success!');
        $category = $menuRepository->findOneBy(['id' => $categoryId]);
        $this->assertEquals( NULL, $category);
    }
   */ 
}
