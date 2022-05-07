<?php

namespace App\Entity;

use App\Repository\SearchRepository;

class Search
{
    public $titre;

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre($titre): self
    {
        $this->titre = $titre;

        return $this;
    }

}
