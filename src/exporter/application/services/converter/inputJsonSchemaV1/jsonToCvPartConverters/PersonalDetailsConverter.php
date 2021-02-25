<?php

declare(strict_types=1);

namespace App\exporter\application\services\converter\inputJsonSchemaV1\jsonToCvPartConverters;

use App\exporter\application\services\converter\JsonToCvPartConverterInterface;
use App\exporter\domain\model\fields\Email;
use App\exporter\domain\model\fields\Name;
use App\exporter\domain\model\fields\PhoneNumber;
use App\exporter\domain\model\fields\Surname;
use App\exporter\domain\model\sections\PersonalDetails;

class PersonalDetailsConverter implements JsonToCvPartConverterInterface
{

    /**
     * @param object $cv- Json Object in valid cv-schema-v1.json format
     *
     * @return PersonalDetails
     */
    public function convert(object $cv): PersonalDetails
    {
        $personalDetails = $cv->personalDetails;
        $name = new Name($personalDetails->name);
        $surname = new Surname($personalDetails->surname);
        $email = new Email($personalDetails->email);
        $phoneNumber = new PhoneNumber($personalDetails->phoneNumber);

        return new PersonalDetails($name, $surname, $email, $phoneNumber);
    }
}
