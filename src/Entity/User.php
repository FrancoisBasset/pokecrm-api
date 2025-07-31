<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $storage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accesstoken = null;

    /**
     * @var Collection<int, Pokemon>
     */
    #[ORM\ManyToMany(targetEntity: Pokemon::class)]
    private Collection $pokemonOwneds;

    public function __construct()
    {
        $this->pokemonOwneds = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function setUsername(string $username): static {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(string $password): static {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    public function getFirstname(): ?string {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static {
        $this->lastname = $lastname;

        return $this;
    }

    public function getStorage(): ?string {
        return $this->storage;
    }

    public function setStorage(string $storage): static {
        $this->storage = $storage;

        return $this;
    }

    #[\Deprecated]
    public function eraseCredentials(): void{
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getAccesstoken(): ?string
    {
        return $this->accesstoken;
    }

    public function setAccesstoken(?string $accesstoken): static
    {
        $this->accesstoken = $accesstoken;

        return $this;
    }

    /**
     * @return Collection<int, Pokemon>
     */
    public function getPokemonOwneds(): Collection
    {
        return $this->pokemonOwneds;
    }

    public function addPokemonOwned(Pokemon $pokemonOwned): static
    {
        if (!$this->pokemonOwneds->contains($pokemonOwned)) {
            $this->pokemonOwneds->add($pokemonOwned);
        }

        return $this;
    }

    public function removePokemonOwned(Pokemon $pokemonOwned): static
    {
        $this->pokemonOwneds->removeElement($pokemonOwned);

        return $this;
    }
}
