<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PracticeOffer::class)]
class PracticeOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'date')]
    private $start;

    #[ORM\Column(type: 'date')]
    private $end;

    #[ORM\Column(type: 'datetime')]
    private $createTime;

    #[ORM\Column(type: 'integer')]
    private $studentCount;

    #[ORM\ManyToOne(targetEntity: CompanyEmployee::class)]
    #[ORM\JoinColumn(name: 'tutor_id', referencedColumnName: 'id')]
    private $tutor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getCreateTime(): ?\DateTimeInterface
    {
        return $this->createTime;
    }

    public function setCreateTime(\DateTimeInterface $createTime): self
    {
        $this->createTime = $createTime;

        return $this;
    }

    public function getStudentCount(): ?int
    {
        return $this->studentCount;
    }

    public function setStudentCount(int $studentCount): self
    {
        $this->studentCount = $studentCount;

        return $this;
    }

    public function getTutor(): ?CompanyEmployee
    {
        return $this->tutor;
    }

    public function setTutor(?CompanyEmployee $tutor): self
    {
        $this->tutor = $tutor;

        return $this;
    }
}
