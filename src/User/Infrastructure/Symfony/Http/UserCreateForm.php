<?php

namespace App\User\Infrastructure\Symfony\Http;



use App\User\Application\Command\UserCreate\UserCreateCommand;
use App\User\Domain\ValueObjects\Email;
use App\User\Domain\ValueObjects\FirstName;
use App\User\Domain\ValueObjects\IsActive;
use App\User\Domain\ValueObjects\LastName;
use App\User\Domain\ValueObjects\Password;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserCreateForm
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    public $firstName;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    public $lastName;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    public $email;


    /**
     * @var bool
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    public $active;

    /**
     * @var string
     */
    public $avatar;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    public $password;

    public function __construct(Request $request)
    {
        $email = new Email($request->get('email')??null);
        $firstName = new FirstName($request->get('firstName')??null);
        $lastName = new LastName($request->get('lastName')??null);
        $active = new IsActive($request->get('isActive'));
        $password = new Password($request->get('password')??null);
        $avatar = $request->files->get('avatar')??null;
        $this->email = $email->getEmail();
        $this->firstName = $firstName->getFirstName();
        $this->lastName = $lastName->getLastName();
        $this->active = $active->isActive();
        $this->avatar = $avatar;
        $this->password = $password;
    }

    public function params(): UserCreateCommand
    {
        return new UserCreateCommand(
            $this->firstName,
            $this->lastName,
            $this->email,
            $this->active,
            $this->password,
            $this->avatar
        );
    }
}