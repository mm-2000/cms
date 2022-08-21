<?php

namespace App\Entity;

use App\Repository\MenuElementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenuElementRepository::class)
 */
class MenuElement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $href;

    /**
     * @ORM\OneToOne(targetEntity=Page::class, cascade={"persist", "remove"})
     */
    private $pageId;

    public function __construct()
    {
        $this->page = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function setHref(?string $href): self
    {
        $this->href = $href;

        return $this;
    }

    public function getPageId(): ?Page
    {
        return $this->pageId;
    }

    public function setPageId(?Page $pageId): self
    {
        $this->pageId = $pageId;

        return $this;
    }
}
