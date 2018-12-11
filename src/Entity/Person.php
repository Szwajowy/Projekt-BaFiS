<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity
 */
class Person
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPerson", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idperson;

    /**
     * @var string
     *
     * @ORM\Column(name="Forename", type="string", length=45, nullable=false)
     */
    private $forename;

    /**
     * @var string
     *
     * @ORM\Column(name="Surname", type="string", length=45, nullable=false)
     */
    private $surname;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Production", mappedBy="idpersonforactror")
     */
    private $idproductionforactor;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Production", mappedBy="idpersonfordirector")
     */
    private $idproductionfordirector;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Production", mappedBy="idpersonforproducer")
     */
    private $idproductionforproducer;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Production", mappedBy="idpersonforscenarist")
     */
    private $idproductionforscenarist;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idproductionforactor = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idproductionfordirector = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idproductionforproducer = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idproductionforscenarist = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdperson(): ?int
    {
        return $this->idperson;
    }

    public function getForename(): ?string
    {
        return $this->forename;
    }

    public function setForename(string $forename): self
    {
        $this->forename = $forename;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return Collection|Production[]
     */
    public function getIdproductionforactor(): Collection
    {
        return $this->idproductionforactor;
    }

    public function addIdproductionforactor(Production $idproductionforactor): self
    {
        if (!$this->idproductionforactor->contains($idproductionforactor)) {
            $this->idproductionforactor[] = $idproductionforactor;
            $idproductionforactor->addIdpersonforactror($this);
        }

        return $this;
    }

    public function removeIdproductionforactor(Production $idproductionforactor): self
    {
        if ($this->idproductionforactor->contains($idproductionforactor)) {
            $this->idproductionforactor->removeElement($idproductionforactor);
            $idproductionforactor->removeIdpersonforactror($this);
        }

        return $this;
    }

    /**
     * @return Collection|Production[]
     */
    public function getIdproductionfordirector(): Collection
    {
        return $this->idproductionfordirector;
    }

    public function addIdproductionfordirector(Production $idproductionfordirector): self
    {
        if (!$this->idproductionfordirector->contains($idproductionfordirector)) {
            $this->idproductionfordirector[] = $idproductionfordirector;
            $idproductionfordirector->addIdpersonfordirector($this);
        }

        return $this;
    }

    public function removeIdproductionfordirector(Production $idproductionfordirector): self
    {
        if ($this->idproductionfordirector->contains($idproductionfordirector)) {
            $this->idproductionfordirector->removeElement($idproductionfordirector);
            $idproductionfordirector->removeIdpersonfordirector($this);
        }

        return $this;
    }

    /**
     * @return Collection|Production[]
     */
    public function getIdproductionforproducer(): Collection
    {
        return $this->idproductionforproducer;
    }

    public function addIdproductionforproducer(Production $idproductionforproducer): self
    {
        if (!$this->idproductionforproducer->contains($idproductionforproducer)) {
            $this->idproductionforproducer[] = $idproductionforproducer;
            $idproductionforproducer->addIdpersonforproducer($this);
        }

        return $this;
    }

    public function removeIdproductionforproducer(Production $idproductionforproducer): self
    {
        if ($this->idproductionforproducer->contains($idproductionforproducer)) {
            $this->idproductionforproducer->removeElement($idproductionforproducer);
            $idproductionforproducer->removeIdpersonforproducer($this);
        }

        return $this;
    }

    /**
     * @return Collection|Production[]
     */
    public function getIdproductionforscenarist(): Collection
    {
        return $this->idproductionforscenarist;
    }

    public function addIdproductionforscenarist(Production $idproductionforscenarist): self
    {
        if (!$this->idproductionforscenarist->contains($idproductionforscenarist)) {
            $this->idproductionforscenarist[] = $idproductionforscenarist;
            $idproductionforscenarist->addIdpersonforscenarist($this);
        }

        return $this;
    }

    public function removeIdproductionforscenarist(Production $idproductionforscenarist): self
    {
        if ($this->idproductionforscenarist->contains($idproductionforscenarist)) {
            $this->idproductionforscenarist->removeElement($idproductionforscenarist);
            $idproductionforscenarist->removeIdpersonforscenarist($this);
        }

        return $this;
    }

}
