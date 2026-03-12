<?php

namespace App\Tests\Controller;

use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ProjetControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $projetRepository;
    private string $path = '/projet/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->projetRepository = $this->manager->getRepository(Projet::class);

        foreach ($this->projetRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Projet index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'projet[titre]' => 'Testing',
            'projet[description]' => 'Testing',
            'projet[dateDebut]' => 'Testing',
            'projet[dateFin]' => 'Testing',
            'projet[statut]' => 'Testing',
            'projet[enseignant]' => 'Testing',
            'projet[etudiants]' => 'Testing',
        ]);

        self::assertResponseRedirects('/projet');

        self::assertSame(1, $this->projetRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new Projet();
        $fixture->setTitre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setStatut('My Title');
        $fixture->setEnseignant('My Title');
        $fixture->setEtudiants('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Projet');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new Projet();
        $fixture->setTitre('Value');
        $fixture->setDescription('Value');
        $fixture->setDateDebut('Value');
        $fixture->setDateFin('Value');
        $fixture->setStatut('Value');
        $fixture->setEnseignant('Value');
        $fixture->setEtudiants('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'projet[titre]' => 'Something New',
            'projet[description]' => 'Something New',
            'projet[dateDebut]' => 'Something New',
            'projet[dateFin]' => 'Something New',
            'projet[statut]' => 'Something New',
            'projet[enseignant]' => 'Something New',
            'projet[etudiants]' => 'Something New',
        ]);

        self::assertResponseRedirects('/projet');

        $fixture = $this->projetRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getDateDebut());
        self::assertSame('Something New', $fixture[0]->getDateFin());
        self::assertSame('Something New', $fixture[0]->getStatut());
        self::assertSame('Something New', $fixture[0]->getEnseignant());
        self::assertSame('Something New', $fixture[0]->getEtudiants());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new Projet();
        $fixture->setTitre('Value');
        $fixture->setDescription('Value');
        $fixture->setDateDebut('Value');
        $fixture->setDateFin('Value');
        $fixture->setStatut('Value');
        $fixture->setEnseignant('Value');
        $fixture->setEtudiants('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/projet');
        self::assertSame(0, $this->projetRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
