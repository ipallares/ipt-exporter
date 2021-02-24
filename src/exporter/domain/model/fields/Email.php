<?php

declare(strict_types=1);

namespace App\exporter\domain\model\fields;

use App\exporter\domain\model\interfaces\SingleContentLengthExportInterface;
use InvalidArgumentException;
use PharIo\Manifest\InvalidEmailException;

class Email implements SingleContentLengthExportInterface
{
    private string $email;

    public function __construct(string $email)
    {
        $this->validate($email);
        $this->email = $email;
    }

    public function export(): string
    {
        return '<email>' . $this->getEmail() . '</email>';
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(string $email): void
    {
        if ($this->isInvalidEmail($email)) {
            throw new InvalidEmailException();
        }
    }

    private function isInvalidEmail(string $email): bool
    {
        return !filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
