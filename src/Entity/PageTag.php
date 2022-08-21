<?php

namespace App\Entity;

use App\Repository\PageTagRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageTagRepository::class)
 */
class PageTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $pageId;

    /**
     * @ORM\Column(type="integer")
     */
    private $tagId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPageId(): ?int
    {
        return $this->pageId;
    }

    public function setPageId(int $pageId): self
    {
        $this->pageId = $pageId;

        return $this;
    }

    public function getTagId(): ?int
    {
        return $this->tagId;
    }

    public function setTagId(int $tagId): self
    {
        $this->tagId = $tagId;

        return $this;
    }
}
