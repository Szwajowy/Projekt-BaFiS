<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Genre
 *
 * @ORM\Table(name="genre")
 * @ORM\Entity
 */
class Genre
{
    /**
     * @var int
     *
     * @ORM\Column(name="idGenre", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idgenre;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Production", mappedBy="idgenre")
     */
    private $idproduction;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idproduction = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdgenre(): ?int
    {
        return $this->idgenre;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Production[]
     */
    public function getIdproduction(): Collection
    {
        return $this->idproduction;
    }

    public function addIdproduction(Production $idproduction): self
    {
        if (!$this->idproduction->contains($idproduction)) {
            $this->idproduction[] = $idproduction;
            $idproduction->addIdgenre($this);
        }

        return $this;
    }

    public function removeIdproduction(Production $idproduction): self
    {
        if ($this->idproduction->contains($idproduction)) {
            $this->idproduction->removeElement($idproduction);
            $idproduction->removeIdgenre($this);
        }

        return $this;
    }

}
