<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Creation;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SerieRepository")
 */
class Serie extends Creation {

}
