<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;

class CategoryTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $categoryRepository = static::getContainer()->get(CategoryRepository::class);
        $categorys = $categoryRepository->findAll();
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/category/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Category index');
        $this->assertSelectorTextContains('table', $categorys[0]->getId());
        $this->assertSelectorTextContains('table', $categorys[0]->getName());
        $this->assertSelectorTextContains('table', $categorys[1]->getId());
        $this->assertSelectorTextContains('table', $categorys[1]->getName());
    }

    public function testCreateForm(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/category/new');
        $buttonCrawlerNode = $crawler->selectButton('Save');
        $form = $buttonCrawlerNode->form();
        $form['category[name]'] = 'A_tag_name';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('#info-box', 'Success!'); 
        $this->assertSelectorTextContains('table', 'A_tag_name');
    }


    public function testShowCategory(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $categoryRepository = static::getContainer()->get(CategoryRepository::class);
        $categorys = $categoryRepository->findAll();     
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/category/', ['id' => $categorys[0]->getId()]);      
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Category');
        $this->assertSelectorTextContains('table', $categorys[0]->getId());
        $this->assertSelectorTextContains('table', $categorys[0]->getName());
    }

    
    public function testSendEditForm(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $categoryRepository = static::getContainer()->get(CategoryRepository::class);
        $category = $categoryRepository->findOneBy(['name' => 'Category name']); 
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $client->request('GET', '/admin/category/' . $category->getId() . '/edit/');
        $crawler = $client->followRedirect();
        $buttonCrawlerNode = $crawler->selectButton('Update');
        $form = $buttonCrawlerNode->form();
        $form['category[name]'] = 'New name';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('#info-box', 'Success!');
        $category = $categoryRepository->findOneBy(['id' =>$category->getId() ]);
        $this->assertEquals( 'New name', $category->getName());
    }

    public function testDeleteCategory(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $categoryRepository = static::getContainer()->get(CategoryRepository::class);
        $category = $categoryRepository->findOneBy(['name' => 'Category two']);     
        $categoryId = $category->getId();
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/category/' . $category->getId(), ['id' => $category->getId()]);      
        $this->assertResponseIsSuccessful();
        $buttonCrawlerNode = $crawler->selectButton('Delete');
        $form = $buttonCrawlerNode->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('#info-box', 'Success!');
        $category = $categoryRepository->findOneBy(['id' => $categoryId]);
        $this->assertEquals( NULL, $category);
    }
}
