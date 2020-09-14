<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriaRepository")
 */
class Categoria
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=30)
     * @Gedmo\Slug(fields={"nome"}, updatable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $dataCadastro;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $dataAtualizacao;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Artigo", mappedBy="categoria")
     */
    private $artigos;

    public function __construct()
    {
        $this->artigos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDataCadastro(): ?\DateTimeInterface
    {
        return $this->dataCadastro;
    }

    public function setDataCadastro(\DateTimeInterface $dataCadastro): self
    {
        $this->dataCadastro = $dataCadastro;

        return $this;
    }

    public function getDataAtualizacao(): ?\DateTimeInterface
    {
        return $this->dataAtualizacao;
    }

    public function setDataAtualizacao(?\DateTimeInterface $dataAtualizacao): self
    {
        $this->dataAtualizacao = $dataAtualizacao;

        return $this;
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
            $artigo->setCategoria($this);
        }

        return $this;
    }

    public function removeArtigo(Artigo $artigo): self
    {
        if ($this->artigos->contains($artigo)) {
            $this->artigos->removeElement($artigo);
            // set the owning side to null (unless already changed)
            if ($artigo->getCategoria() === $this) {
                $artigo->setCategoria(null);
            }
        }

        return $this;
    }
}
