<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Premiere
 *
 * @ORM\Table(name="premiere", indexes={@ORM\Index(name="fk_Premiere_Country1_idx", columns={"idCountry"})})
 * @ORM\Entity
 */
class Premiere
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPremiere", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpremiere;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \Country
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCountry", referencedColumnName="idCountry")
     * })
     */
    private $idcountry;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Production", mappedBy="idpremiere")
     */
    private $idproduction;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idproduction = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdpremiere(): ?int
    {
        return $this->idpremiere;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdcountry(): ?Country
    {
        return $this->idcountry;
    }

    public function setIdcountry(?Country $idcountry): self
    {
        $this->idcountry = $idcountry;

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
            $idproduction->addIdpremiere($this);
        }

        return $this;
    }

    public function removeIdproduction(Production $idproduction): self
    {
        if ($this->idproduction->contains($idproduction)) {
            $this->idproduction->removeElement($idproduction);
            $idproduction->removeIdpremiere($this);
        }

        return $this;
    }

}
