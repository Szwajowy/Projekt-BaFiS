<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 *  @ORM\MappedSuperclass()
 */
abstract class Creation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected  $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    protected  $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected  $description;

    /**
     * @ORM\Column(type="array", length=30)
     */
    protected  $genres;

    /**
     * @ORM\Column(type="boolean")
     */
    protected  $isApproved;

    public function __construct()
    {
        $this->genres = [];
    }

    // Get and Set
    public function getId(): ?int 
    {
        return $this->id;
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
    
    public function getGenres(): ?string 
    {
        $string = '';
        for ($i = 0; $i < count($this->genres); $i++) {
            $string = $string.$this->genres[$i];
            if ($i != (count($this->genres)- 1)) {
                $string = $string.', ';
            }
        }
        return $string;
    }

    public function getGenresArray(): ?array 
    {
        return $this->genres;
    }

    public function setGenres(?string $genres): self 
    {
        $genresArray = explode(",", $genres);
        $this->genres = array_map('trim', $genresArray);
        
        return $this;
    }

    public function getIsApproved() 
    {
        return $this->isApproved;
    }

    public function setIsApproved( $isApproved): self 
    {
        $this->isApproved = $isApproved;
        return $this;
    }
}
