<?php

declare(strict_types=1);

namespace App\exporter\domain\model\fields;

use App\exporter\domain\model\interfaces\SingleContentLengthExportInterface;
use InvalidArgumentException;

class Surname implements SingleContentLengthExportInterface
{
    protected string $surname;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $surname)
    {
        $this->validate($surname);
        $this->surname = $surname;
    }

    public function export(): string
    {
        return '<surname>' . $this->getSurname() . '</surname>';
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(string $surname): void
    {
        if ($this->isInvalidSurname($surname)) {
            throw new InvalidArgumentException('Surname can`t be empty and can only contain letters, dashes, apostrophes and whitespaces');
        }
    }

    private function isInvalidSurname(string $surname): bool
    {
        return '' === trim($surname) || !preg_match("/^[a-zA-Z-' ]*$/", $surname);
    }
}
