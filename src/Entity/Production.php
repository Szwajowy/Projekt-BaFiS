<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Production
 *
 * @ORM\Table(name="production", indexes={@ORM\Index(name="productiontype_fk_idx", columns={"type"})})
 * @ORM\Entity
 */
class Production
{
    /**
     * @var int
     *
     * @ORM\Column(name="idProduction", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproduction;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=false)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="boxoffice", type="string", length=45, nullable=true)
     */
    private $boxoffice;

    /**
     * @var \Productiontype
     *
     * @ORM\ManyToOne(targetEntity="Productiontype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="idProductionType")
     * })
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isApproved", type="boolean", nullable=false)
     */
    private $isApproved;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="idproductionforactor")
     * @ORM\JoinTable(name="productionactor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idProductionForActor", referencedColumnName="idProduction")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idPersonForActror", referencedColumnName="idPerson")
     *   }
     * )
     */
    private $idpersonforactror;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Country", inversedBy="idproduction")
     * @ORM\JoinTable(name="productioncountry",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idProduction", referencedColumnName="idProduction")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idCountry", referencedColumnName="idCountry")
     *   }
     * )
     */
    private $idcountry;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="idproductionfordirector")
     * @ORM\JoinTable(name="productiondirector",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idProductionForDirector", referencedColumnName="idProduction")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idPersonForDirector", referencedColumnName="idPerson")
     *   }
     * )
     */
    private $idpersonfordirector;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="idproduction", cascade={"persist"}, fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="productiongenre",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idProduction", referencedColumnName="idProduction")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idGenre", referencedColumnName="idGenre")
     *   }
     * )
     */
    private $idgenre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Premiere", inversedBy="idproduction")
     * @ORM\JoinTable(name="productionpremiere",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idProduction", referencedColumnName="idProduction")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idPremiere", referencedColumnName="idPremiere")
     *   }
     * )
     */
    private $idpremiere;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="idproductionforproducer")
     * @ORM\JoinTable(name="productionproducer",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idProductionForProducer", referencedColumnName="idProduction")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idPersonForProducer", referencedColumnName="idPerson")
     *   }
     * )
     */
    private $idpersonforproducer;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="idproductionforscenarist")
     * @ORM\JoinTable(name="productionscenarist",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idProductionForScenarist", referencedColumnName="idProduction")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idPersonForScenarist", referencedColumnName="idPerson")
     *   }
     * )
     */
    private $idpersonforscenarist;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idpersonforactror = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idcountry = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idpersonfordirector = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idgenre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idpremiere = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idpersonforproducer = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idpersonforscenarist = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdproduction(): ?int
    {
        return $this->idproduction;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBoxoffice(): ?string
    {
        return $this->boxoffice;
    }

    public function setBoxoffice(?string $boxoffice): self
    {
        $this->boxoffice = $boxoffice;

        return $this;
    }

    public function getType(): ?Productiontype
    {
        return $this->type;
    }

    public function setType(?Productiontype $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getIdpersonforactror(): Collection
    {
        return $this->idpersonforactror;
    }

    public function addIdpersonforactror(Person $idpersonforactror): self
    {
        if (!$this->idpersonforactror->contains($idpersonforactror)) {
            $this->idpersonforactror[] = $idpersonforactror;
        }

        return $this;
    }

    public function removeIdpersonforactror(Person $idpersonforactror): self
    {
        if ($this->idpersonforactror->contains($idpersonforactror)) {
            $this->idpersonforactror->removeElement($idpersonforactror);
        }

        return $this;
    }

    /**
     * @return Collection|Country[]
     */
    public function getIdcountry(): Collection
    {
        return $this->idcountry;
    }

    public function addIdcountry(Country $idcountry): self
    {
        if (!$this->idcountry->contains($idcountry)) {
            $this->idcountry[] = $idcountry;
        }

        return $this;
    }

    public function removeIdcountry(Country $idcountry): self
    {
        if ($this->idcountry->contains($idcountry)) {
            $this->idcountry->removeElement($idcountry);
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getIdpersonfordirector(): Collection
    {
        return $this->idpersonfordirector;
    }

    public function addIdpersonfordirector(Person $idpersonfordirector): self
    {
        if (!$this->idpersonfordirector->contains($idpersonfordirector)) {
            $this->idpersonfordirector[] = $idpersonfordirector;
        }

        return $this;
    }

    public function removeIdpersonfordirector(Person $idpersonfordirector): self
    {
        if ($this->idpersonfordirector->contains($idpersonfordirector)) {
            $this->idpersonfordirector->removeElement($idpersonfordirector);
        }

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getIdgenre(): Collection
    {
        return $this->idgenre;
    }

    public function addIdgenre(Genre $idgenre): self
    {
        if (!$this->idgenre->contains($idgenre)) {
            $this->idgenre[] = $idgenre;
            $idgenre->addIdproduction($this);
        }

        return $this;
    }

    public function removeIdgenre(Genre $idgenre): self
    {
        if ($this->idgenre->contains($idgenre)) {
            $this->idgenre->removeElement($idgenre);
        }

        return $this;
    }

    /**
     * @return Collection|Premiere[]
     */
    public function getIdpremiere(): Collection
    {
        return $this->idpremiere;
    }

    public function addIdpremiere(Premiere $idpremiere): self
    {
        if (!$this->idpremiere->contains($idpremiere)) {
            $this->idpremiere[] = $idpremiere;
        }

        return $this;
    }

    public function removeIdpremiere(Premiere $idpremiere): self
    {
        if ($this->idpremiere->contains($idpremiere)) {
            $this->idpremiere->removeElement($idpremiere);
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getIdpersonforproducer(): Collection
    {
        return $this->idpersonforproducer;
    }

    public function addIdpersonforproducer(Person $idpersonforproducer): self
    {
        if (!$this->idpersonforproducer->contains($idpersonforproducer)) {
            $this->idpersonforproducer[] = $idpersonforproducer;
        }

        return $this;
    }

    public function removeIdpersonforproducer(Person $idpersonforproducer): self
    {
        if ($this->idpersonforproducer->contains($idpersonforproducer)) {
            $this->idpersonforproducer->removeElement($idpersonforproducer);
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getIdpersonforscenarist(): Collection
    {
        return $this->idpersonforscenarist;
    }

    public function addIdpersonforscenarist(Person $idpersonforscenarist): self
    {
        if (!$this->idpersonforscenarist->contains($idpersonforscenarist)) {
            $this->idpersonforscenarist[] = $idpersonforscenarist;
        }

        return $this;
    }

    public function removeIdpersonforscenarist(Person $idpersonforscenarist): self
    {
        if ($this->idpersonforscenarist->contains($idpersonforscenarist)) {
            $this->idpersonforscenarist->removeElement($idpersonforscenarist);
        }

        return $this;
    }

    public function getIsApproved()
    {
        return $this->isApproved;
    }

    public function setIsApproved($isApproved): self
    {
        $this->isApproved = $isApproved;

        return $this;
    }

}
