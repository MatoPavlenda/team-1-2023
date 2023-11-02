<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Company::class)]
class Company
{ //tesst amendu
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $street;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    #[ORM\Column(type: 'string', length: 6)]
    private $postalCode;

    #[ORM\Column(type: 'string', length: 8)]
    private $ico;

    #[ORM\OneToMany(targetEntity: CompanySchoolContract::class, mappedBy: 'company')]
    private $contracts;

    #[ORM\OneToMany(targetEntity: CompanyEmployee::class, mappedBy: 'company')]
    private $employees;

    #[ORM\Column(type: 'datetime')]
    private $registrationTime;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
        $this->employees = new ArrayCollection();
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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

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

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getIco(): ?string
    {
        return $this->ico;
    }

    public function setIco(string $ico): self
    {
        $this->ico = $ico;

        return $this;
    }

    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function getRegistrationTime(): ?\DateTimeInterface // Updated getter name
    {
        return $this->registrationTime; // Updated property name
    }

    public function setRegistrationTime(\DateTimeInterface $registrationTime): self // Updated setter name
    {
        $this->registrationTime = $registrationTime; // Updated property name

        return $this;
    }

    public function getEmployees(): Collection
    {
        return $this->employees;
    }
}
