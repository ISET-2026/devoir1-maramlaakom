<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre est obligatoire")]
    #[Assert\Length(min: 5, minMessage: "Le titre doit faire au moins 5 caractères")]
    private ?string $titre = null;

    #[ORM\Column(type: 'text' ,nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime' ,nullable: true)]
    private ?\DateTime $dateDebut = null;
    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Assert\Expression(
        "this.getDateFin() >= this.getDateDebut()",
        message: "La date de fin ne peut pas être avant la date de début"
    )]
    private ?\DateTime $dateFin = null;
    
    #[ORM\Column(length:255)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    private ?Enseignant $enseignant = null;

    #[ORM\ManyToMany(targetEntity: Etudiant::class, inversedBy: 'projets')]
   
    #[Assert\Count(min: 1,minMessage: "Il faut au moins un étudiant par projet")]
    private Collection $etudiants;
    

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDateDebut(): ?\DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTime $dateDebut): static
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTime $dateFin): static
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): static
    {
        $this->enseignant = $enseignant;
        return $this;
    }

    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }
}