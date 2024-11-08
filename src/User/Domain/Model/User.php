<?php

namespace App\User\Domain\Model;

use App\User\Domain\ValueObjects\Email;
use App\User\Domain\ValueObjects\FirstName;
use App\User\Domain\ValueObjects\IsActive;
use App\User\Domain\ValueObjects\LastName;
use App\User\Domain\ValueObjects\Password;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class User
{
    private $password = '';
    private $id;
    private $email;
    private $plainPassword;
    private $createdAt;
    private $updateAt;
    private $firstName;
    private $lastName;
    private $fullName;
    private $active;
    private $avatar;
    private $lastNewsletterSent;

    /**
     * @var Collection|Image[]
     */
    private $images;

    public function __construct(
        string $id,
        FirstName|string $firstName,
        LastName|string $lastName,
        Email|string $email,
        Password|string $plainPassword,
        IsActive|bool|int $active,
        string $avatar
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->plainPassword = $plainPassword;
        $this->active = $active;
        $this->avatar = $avatar;
        $this->createdAt = new DateTimeImmutable();
        $this->updateAt = new DateTimeImmutable();
        $this->lastNewsletterSent = null;

        $this->fullName = sprintf('%s %s', $firstName, $lastName);

        $this->images = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): FirstName|string
    {
        return $this->firstName;
    }

    public function getLastName(): LastName|string
    {
        return $this->lastName;
    }

    public function getEmail(): Email|string
    {
        return $this->email;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function isActive(): IsActive|bool
    {
        return $this->active;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdateAt(): DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPlainPassword(): Password|string
    {
        return $this->plainPassword;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages()
    {
        return $this->images;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }


    public function getLastNewsletterSent(): DateTimeImmutable
    {
        return $this->lastNewsletterSent;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function addImage(Image $image): void
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setUser($this);
        }
    }

    public function removeImage(Image $image): void
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            $image->setUser(null);
        }
    }

    public function setLastNewsletterSent(?DateTimeImmutable $lastNewsletterSent): void
    {
        $this->lastNewsletterSent = $lastNewsletterSent;
    }
}