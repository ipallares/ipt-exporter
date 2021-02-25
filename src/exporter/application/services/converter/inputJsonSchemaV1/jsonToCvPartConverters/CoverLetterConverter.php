<?php

declare(strict_types=1);

namespace App\exporter\application\services\converter\inputJsonSchemaV1\jsonToCvPartConverters;

use App\exporter\application\services\converter\JsonToCvPartConverterInterface;
use App\exporter\domain\model\sections\CoverLetter;

class CoverLetterConverter implements JsonToCvPartConverterInterface
{

    /**
     * @param object $cv- Json Object in valid cv-schema-v1.json format
     *
     * @return CoverLetter
     */
    public function convert(object $cv): CoverLetter
    {
        $coverLetter = $cv->coverLetter;

        return new CoverLetter($coverLetter->text);
    }
}
