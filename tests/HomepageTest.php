<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use App\Entity\User;

class HomepageTest extends WebTestCase
{

    public function testHomepage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Welcome!');
        $this->assertSelectorTextContains('h1', 'Homepage');
        
    }

    public function testHomepageMainMenu(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();        
        $this->assertCount(3, $crawler->filter('.nav-link'));
        $this->assertSelectorTextContains('.nav-item:nth-of-type(1)', 'menu element one');
        $this->assertSelectorTextContains('.nav-item:nth-of-type(2)', 'menu element two');
        $this->assertSelectorTextContains('.nav-item:last-child', 'Login');
        $this->assertSelectorTextNotContains('.nav-item:last-child', 'Logout');
    }

    public function testVisitingWhileLoggedInAdmin()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' =>'admin']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertCount(4, $crawler->filter('.nav-link'));
        $this->assertSelectorTextContains('.nav-item:nth-of-type(1)', 'menu element one');
        $this->assertSelectorTextContains('.nav-item:nth-of-type(2)', 'menu element two');
        $this->assertSelectorTextContains('.nav-item:nth-of-type(3)', 'Admin');
        $this->assertSelectorTextNotContains('.nav-item:last-child', 'Login');
        $this->assertSelectorTextContains('.nav-item:last-child', 'Logout');
    }

    public function testVisitingWhileLoggedInRegularUser()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' =>'user']);
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertCount(3, $crawler->filter('.nav-link'));
        $this->assertSelectorTextContains('.nav-item:nth-of-type(1)', 'menu element one');
        $this->assertSelectorTextContains('.nav-item:nth-of-type(2)', 'menu element two');
        $this->assertSelectorTextNotContains('.nav-item:nth-of-type(3)', 'Admin');
        $this->assertSelectorTextNotContains('.nav-item:last-child', 'Login');
        $this->assertSelectorTextContains('.nav-item:last-child', 'Logout');
    }
}
