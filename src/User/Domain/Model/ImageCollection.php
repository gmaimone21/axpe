<?php

namespace App\User\Domain\Model;

use App\User\Domain\Exception\ValidationException;

class ImageCollection
{
    private const MAX_PHOTOS = 4;
    private array $images = [];

    public function addImage(Image $image): void
    {
        if (count($this->images) >= self::MAX_PHOTOS) {
            throw new ValidationException('Images','No se pueden subir más de ' . self::MAX_PHOTOS . ' fotos.');
        }
        $this->images[] = $image;
    }

    public function getImages(): array
    {
        return $this->images;
    }
}