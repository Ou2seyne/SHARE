<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LoginLogRepository;

#[ORM\Entity(repositoryClass: LoginLogRepository::class)]
#[ORM\Table(name: 'login_log')]
class LoginLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $loggedAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'loginLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getLoggedAt(): \DateTimeInterface
    {
        return $this->loggedAt;
    }

    public function setLoggedAt(\DateTimeInterface $loggedAt): static
    {
        $this->loggedAt = $loggedAt;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;
        return $this;
    }
}
