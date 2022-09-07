<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use App\Repository\TagRepository;

class TagTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $tagRepository = static::getContainer()->get(TagRepository::class);
        $tags = $tagRepository->findAll();
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/tag/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('table', $tags[0]->getId());
        $this->assertSelectorTextContains('table', $tags[0]->getName());
        $this->assertSelectorTextContains('table', $tags[1]->getId());
        $this->assertSelectorTextContains('table', $tags[1]->getName());
    }

    public function testCreateForm(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/tag/new');
        $buttonCrawlerNode = $crawler->selectButton('Save');
        $form = $buttonCrawlerNode->form();
        $form['tag[name]'] = 'A_tag_name';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('#info-box', 'Success!'); 
        $this->assertSelectorTextContains('table', 'A_tag_name');
    }

    public function testShowTag(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $tagRepository = static::getContainer()->get(TagRepository::class);
        $tags = $tagRepository->findAll();     
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/tag/', ['id' => $tags[0]->getId()]);      
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Tag');
        $this->assertSelectorTextContains('table', $tags[0]->getId());
        $this->assertSelectorTextContains('table', $tags[0]->getName());
    }

    public function testSendEditForm(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $tagRepository = static::getContainer()->get(TagRepository::class);
        $tags = $tagRepository->findAll(); 
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $client->request('GET', '/admin/tag/' . $tags[0]->getId() . '/edit/');
        $crawler = $client->followRedirect();
        $buttonCrawlerNode = $crawler->selectButton('Update');
        $form = $buttonCrawlerNode->form();
        $form['tag[name]'] = 'New_name';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('#info-box', 'Success!');
        $category = $tagRepository->findOneBy(['id' =>$tags[0]->getId() ]);
        $this->assertEquals( 'New_name', $category->getName());
    }

    public function testDeleteCategory(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $tagRepository = static::getContainer()->get(TagRepository::class);
        $tags = $tagRepository->findAll();     
        $categoryId = $tags[0]->getId();
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/tag/' . $tags[0]->getId(), ['id' => $tags[0]->getId()]);      
        $this->assertResponseIsSuccessful();
        $buttonCrawlerNode = $crawler->selectButton('Delete');
        $form = $buttonCrawlerNode->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('#info-box', 'Success!');
        $category = $tagRepository->findOneBy(['id' => $categoryId]);
        $this->assertEquals( NULL, $category);
    }
}
