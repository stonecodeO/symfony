<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchRepository")
 */
class Search
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recherche;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prixMin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $PrixMax;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     */
    private $categories;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $promo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecherche(): ?string
    {
        return $this->recherche;
    }

    public function setRecherche(?string $recherche): self
    {
        $this->recherche = $recherche;

        return $this;
    }

    public function getPrixMin(): ?int
    {
        return $this->prixMin;
    }

    public function setPrixMin(?int $prixMin): self
    {
        $this->prixMin = $prixMin;

        return $this;
    }

    public function getPrixMax(): ?int
    {
        return $this->PrixMax;
    }

    public function setPrixMax(?int $PrixMax): self
    {
        $this->PrixMax = $PrixMax;

        return $this;
    }

    public function getCategories(): ?Category
    {
        return $this->categories;
    }

    public function setCategories(?Category $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getPromo(): ?bool
    {
        return $this->promo;
    }

    public function setPromo(?bool $promo): self
    {
        $this->promo = $promo;

        return $this;
    }
}
