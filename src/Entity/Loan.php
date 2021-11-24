<?php

namespace App\Entity;

use App\Repository\LoanRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoanRepository::class)
 */
class Loan
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="loans")
     * @ORM\JoinColumn(nullable=true)
     */
    private $askedBy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $signature;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfLoan;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfReturn;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAskedBy(): ?User
    {
        return $this->askedBy;
    }

    public function setAskedBy(?User $askedBy): self
    {
        $this->askedBy = $askedBy;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getDateOfLoan(): ?\DateTimeInterface
    {
        return $this->dateOfLoan;
    }

    public function setDateOfLoan(?\DateTimeInterface $dateOfLoan): self
    {
        $this->dateOfLoan = $dateOfLoan;

        return $this;
    }

    public function getDateOfReturn(): ?\DateTimeInterface
    {
        return $this->dateOfReturn;
    }

    public function setDateofReturn(?\DateTimeInterface $dateOfReturn): self
    {
        $this->dateOfReturn = $dateOfReturn;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
