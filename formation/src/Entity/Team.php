<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity=Player::class, mappedBy="team")
     */
    private $players;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="teamIn")
     */
    private $gamesIn;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="teamOut")
     */
    private $gamesOut;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->gamesIn = new ArrayCollection();
        $this->gamesOut = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setTeam($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getTeam() === $this) {
                $player->setTeam(null);
            }
        }

        return $this;
    }

    public function getNbPlayers(): int
    {
        return count($this->players);
    }

    /**
     * @return Collection|Game[]
     */
    public function getGamesIn(): Collection
    {
        return $this->gamesIn;
    }

    public function addGamesIn(Game $gamesIn): self
    {
        if (!$this->gamesIn->contains($gamesIn)) {
            $this->gamesIn[] = $gamesIn;
            $gamesIn->setTeamIn($this);
        }

        return $this;
    }

    public function removeGamesIn(Game $gamesIn): self
    {
        if ($this->gamesIn->contains($gamesIn)) {
            $this->gamesIn->removeElement($gamesIn);
            // set the owning side to null (unless already changed)
            if ($gamesIn->getTeamIn() === $this) {
                $gamesIn->setTeamIn(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGamesOut(): Collection
    {
        return $this->gamesOut;
    }

    public function addGamesOut(Game $gamesOut): self
    {
        if (!$this->gamesOut->contains($gamesOut)) {
            $this->gamesOut[] = $gamesOut;
            $gamesOut->setTeamOut($this);
        }

        return $this;
    }

    public function removeGamesOut(Game $gamesOut): self
    {
        if ($this->gamesOut->contains($gamesOut)) {
            $this->gamesOut->removeElement($gamesOut);
            // set the owning side to null (unless already changed)
            if ($gamesOut->getTeamOut() === $this) {
                $gamesOut->setTeamOut(null);
            }
        }

        return $this;
    }

}
