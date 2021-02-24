<?php

declare(strict_types=1);

namespace App\exporter\domain\model\sections;

use App\exporter\domain\model\fields\Email;
use App\exporter\domain\model\fields\Name;
use App\exporter\domain\model\fields\PhoneNumber;
use App\exporter\domain\model\fields\Surname;
use App\exporter\domain\model\interfaces\MultipleContentLengthExportInterface;

class PersonalDetails implements MultipleContentLengthExportInterface
{
    private Name $name;

    private Surname $surname;

    private Email $email;

    private PhoneNumber $phoneNumber;

    public function __construct(Name $name, Surname $surname, Email $email, PhoneNumber $phoneNumber)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }

    public function exportCompressed(): string
    {
        return '<compressed-personaldetails>'
                . $this->exportName()
                . $this->exportSurname()
                . '</compressed-personaldetails>';
    }

    public function exportExtended(): string
    {
        return '<extended-personaldetails>'
                . $this->exportName()
                . $this->exportSurname()
                . $this->exportEmail()
                . $this->exportPhoneNumber()
                . '</extended-personaldetails>';
    }

    private function exportName(): string
    {
        return $this->name->export();
    }

    private function exportSurname(): string
    {
        return $this->surname->export();
    }

    private function exportEmail()
    {
        return $this->email->export();
    }

    private function exportPhoneNumber()
    {
        return $this->phoneNumber->export();
    }
}
