<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity
 */
class Country
{
    /**
     * @var string
     *
     * @ORM\Column(name="idCountry", type="string", length=2, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcountry;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="nameInPolish", type="string", length=45, nullable=false)
     */
    private $nameinpolish;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Production", mappedBy="idcountry")
     */
    private $idproduction;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idproduction = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdcountry(): ?string
    {
        return $this->idcountry;
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

    public function getNameinpolish(): ?string
    {
        return $this->nameinpolish;
    }

    public function setNameinpolish(string $nameinpolish): self
    {
        $this->nameinpolish = $nameinpolish;

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
            $idproduction->addIdcountry($this);
        }

        return $this;
    }

    public function removeIdproduction(Production $idproduction): self
    {
        if ($this->idproduction->contains($idproduction)) {
            $this->idproduction->removeElement($idproduction);
            $idproduction->removeIdcountry($this);
        }

        return $this;
    }

}
