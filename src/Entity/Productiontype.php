<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Productiontype
 *
 * @ORM\Table(name="productiontype")
 * @ORM\Entity
 */
class Productiontype
{
    /**
     * @var int
     *
     * @ORM\Column(name="idProductionType", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproductiontype;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    public function getIdproductiontype(): ?int
    {
        return $this->idproductiontype;
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


}
