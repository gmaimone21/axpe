<?php

namespace App\User\Infrastructure\Symfony\AwsS3;

use App\User\Domain\Contracts\ImageRepositoryInterface;
use App\User\Domain\Model\Image;
use Aws\S3\S3Client;

class S3ImageUploader implements ImageRepositoryInterface
{
    public function __construct(
        private S3Client $s3Client,
        private string $bucketName
    )
    {
    }

    public function upload(Image $image, string $destination): string
    {
       $result = $this->s3Client->putObject([
            'Bucket' => $this->bucketName,
            'Key' => $destination,
            'SourceFile' => $image->getFile()->value() ?? $image->getFile(),
            'ACL' => 'public-read',
        ]);

       return $result['ObjectURL'];
    }
}