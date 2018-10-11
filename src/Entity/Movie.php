<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Creation;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie extends Creation {

}
