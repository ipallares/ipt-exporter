<?php

declare(strict_types=1);

namespace App\exporter\domain\model\fields;

use App\exporter\domain\model\interfaces\SingleContentLengthExportInterface;
use InvalidArgumentException;

class Name implements SingleContentLengthExportInterface
{
    protected string $name;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $name)
    {
        $this->validate($name);
        $this->name = $name;
    }

    public function export(): string
    {
        return '<name>' . $this->getName() . '</name>';
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(string $name): void
    {
        if ($this->isInvalidName($name)) {
            throw new InvalidArgumentException('Name can`t be empty and can only contain letters, dashes, apostrophes and whitespaces');
        }
    }

    private function isInvalidName(string $name): bool
    {
        return '' === trim($name) || !preg_match("/^[a-zA-Z-' ]*$/",$name);
    }
}
