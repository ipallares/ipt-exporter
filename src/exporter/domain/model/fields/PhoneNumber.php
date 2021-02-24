<?php

declare(strict_types=1);

namespace App\exporter\domain\model\fields;

use App\exporter\domain\model\interfaces\SingleContentLengthExportInterface;
use InvalidArgumentException;

class PhoneNumber implements SingleContentLengthExportInterface
{
    private string $phoneNumber;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $phoneNumber)
    {
        $this->validate($phoneNumber);
        $this->phoneNumber = $phoneNumber;
    }

    public function export(): string
    {
        return '<phonenumber>' . $this->getPhoneNumber() . '</phonenumber>';
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    private function validate(string $phoneNumber): void
    {
        if ($this->isInvalidPhoneNumber($phoneNumber)) {
            throw new InvalidArgumentException("Phone number has an invalid format '$phoneNumber'");
        }
    }

    private function isInvalidPhoneNumber(string $phoneNumber): bool
    {
        // Other validations might be added
        return '' === $phoneNumber;
    }
}
