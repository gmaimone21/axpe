<?php

namespace App\User\Domain\Model;

use App\User\Domain\ValueObjects\File;
use DateTimeImmutable;

class Image
{
    private int $id;
    public string $url;
    public string $name;

    public function __construct(
        public File|string $file,
        public ?User $user,
        public \DateTimeImmutable $createdAt = new \DateTimeImmutable(),
        public \DateTimeImmutable $updateAt = new DateTimeImmutable(),
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFile(): File|string
    {
        return $this->file;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdateAt(): \DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}