<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogRepository")
 * @ORM\Table(name="logs")
 */
class Log
{
    public const TYPE_LOGIN = 'login';
    public const TYPE_LOGOUT = 'logout';
    public const TYPE_ACCOUNT_DELETION = 'account_deletion';
    public const TYPE_CONTACT_MESSAGE = 'contact_message';
    public const TYPE_FILE_UPLOAD = 'file_upload';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $type;

    #[ORM\Column(type: 'string')]
    private string $message;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    public function __construct(string $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
        $this->createdAt = new \DateTime();
    }

    // Getters and Setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
