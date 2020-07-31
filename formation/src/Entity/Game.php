<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="gamesIn")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teamIn;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="gamesOut")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teamOut;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTeamIn(): ?Team
    {
        return $this->teamIn;
    }

    public function setTeamIn(?Team $teamIn): self
    {
        $this->teamIn = $teamIn;

        return $this;
    }

    public function getTeamOut(): ?Team
    {
        return $this->teamOut;
    }

    public function setTeamOut(?Team $teamOut): self
    {
        $this->teamOut = $teamOut;

        return $this;
    }

    public function hasTheSameNbOfPlayers() 
    {
        if(count($this->teamIn->getPlayers()) == count($this->teamOut->getPlayers()))
            return true;
        return false;
    }
}
