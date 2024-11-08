<?php

namespace App\User\Domain\Contracts;

use App\User\Domain\Model\Image;

Interface ImageRepositoryInterface
{
    public function upload(Image $image, string $destination): string;

}