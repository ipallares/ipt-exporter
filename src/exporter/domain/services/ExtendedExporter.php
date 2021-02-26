<?php

declare(strict_types=1);

namespace App\exporter\domain\services;

use App\exporter\domain\model\sections\AcademicExperiences;
use App\exporter\domain\model\sections\CoverLetter;
use App\exporter\domain\model\sections\PersonalDetails;
use App\exporter\domain\model\sections\WorkExperiences;
use App\exporter\domain\services\interfaces\ContentLengthTypeExporterInterface;

class ExtendedExporter implements ContentLengthTypeExporterInterface
{
    public const CONTENT_LENGTH_TYPE_EXTENDED = 'extended';

    public function personalDetails(PersonalDetails $personalDetails): string
    {
        return $personalDetails->exportExtended();
    }

    public function coverLetter(CoverLetter $coverLetter): string
    {
        return $coverLetter->exportExtended();
    }

    public function workExperience(WorkExperiences $workExperiences): string
    {
        return $workExperiences->exportExtended();
    }

    public function academicExperience(AcademicExperiences $academicExperiences): string
    {
        return $academicExperiences->exportExtended();
    }

    public function supports(string $contentLengthType): bool
    {
        return self::CONTENT_LENGTH_TYPE_EXTENDED === $contentLengthType;
    }
}
