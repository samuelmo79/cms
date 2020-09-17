<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *  fields={"email"},
 *     message="Já existe um usuário com esse email cadastrado."
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Preencha esta informação!")
     * @Assert\Email(message = "O email '{{ value }}' não é válido." )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\Length(max=4096)
     */
    private $senhaPura;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Artigo", mappedBy="autor")
     */
    private $artigos;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DadosPessoais", inversedBy="user", cascade={"persist", "remove"})
     */
    private $dadosPessoais;

    /**
     * @ORM\Column(type="string", length=254, nullable=true)
     */
    private $tokenResetPassword;

    public function __construct()
    {
        $this->artigos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSenhaPura()
    {
        return $this->senhaPura;
    }

    /**
     * @param mixed $senhaPura
     * @return User
     */
    public function setSenhaPura($senhaPura)
    {
        $this->senhaPura = $senhaPura;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Artigo[]
     */
    public function getArtigos(): Collection
    {
        return $this->artigos;
    }

    public function addArtigo(Artigo $artigo): self
    {
        if (!$this->artigos->contains($artigo)) {
            $this->artigos[] = $artigo;
            $artigo->setAutor($this);
        }

        return $this;
    }

    public function removeArtigo(Artigo $artigo): self
    {
        if ($this->artigos->contains($artigo)) {
            $this->artigos->removeElement($artigo);
            // set the owning side to null (unless already changed)
            if ($artigo->getAutor() === $this) {
                $artigo->setAutor(null);
            }
        }

        return $this;
    }

    public function getDadosPessoais(): ?DadosPessoais
    {
        return $this->dadosPessoais;
    }

    public function setDadosPessoais(?DadosPessoais $dadosPessoais): self
    {
        $this->dadosPessoais = $dadosPessoais;

        return $this;
    }

    public function getTokenResetPassword(): ?string
    {
        return $this->tokenResetPassword;
    }

    public function setTokenResetPassword(?string $tokenResetPassword): self
    {
        $this->tokenResetPassword = $tokenResetPassword;

        return $this;
    }
}
