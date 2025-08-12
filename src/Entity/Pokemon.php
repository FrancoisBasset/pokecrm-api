<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['pokemon:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['pokemon:list'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['pokemon:list'])]
    private ?string $english_name = null;

    #[ORM\Column]
    #[Groups(['pokemon:list'])]
    private ?int $generation = null;

    #[ORM\Column(length: 255)]
    #[Groups(['pokemon:list'])]
    private $sprite;

    #[ORM\Column(type: Types::ARRAY)]
    #[Groups(['pokemon:list'])]
    private array $types = [];

    #[ORM\Column]
    #[Groups(['pokemon:list'])]
    private ?float $height = null;

    #[ORM\Column]
    #[Groups(['pokemon:list'])]
    private ?float $weight = null;

    #[ORM\Column]
    #[Groups(['pokemon:list'])]
    private ?int $catchrate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEnglishName(): ?string
    {
        return $this->english_name;
    }

    public function setEnglishName(string $english_name): static
    {
        $this->english_name = $english_name;

        return $this;
    }

    public function getGeneration(): ?int
    {
        return $this->generation;
    }

    public function setGeneration(int $generation): static
    {
        $this->generation = $generation;

        return $this;
    }

    public function getSprite()
    {
        return $this->sprite;
    }

    public function setSprite($sprite): static
    {
        $this->sprite = $sprite;

        return $this;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function setTypes(array $types): static
    {
        $this->types = $types;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCatchrate(): ?int
    {
        return $this->catchrate;
    }

    public function setCatchrate(int $catchrate): static
    {
        $this->catchrate = $catchrate;

        return $this;
    }
}
