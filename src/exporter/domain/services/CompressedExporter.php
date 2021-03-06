<?php

declare(strict_types=1);

namespace App\exporter\domain\services;

use App\exporter\domain\model\sections\AcademicExperiences;
use App\exporter\domain\model\sections\CoverLetter;
use App\exporter\domain\model\sections\PersonalDetails;
use App\exporter\domain\model\sections\WorkExperiences;
use App\exporter\domain\services\interfaces\ContentLengthTypeExporterInterface;

class CompressedExporter implements ContentLengthTypeExporterInterface
{

    public const CONTENT_LENGTH_TYPE_COMPRESSED = 'compressed';

    public function personalDetails(PersonalDetails $personalDetails): string
    {
        return $personalDetails->exportCompressed();
    }

    public function coverLetter(CoverLetter $coverLetter): string
    {
        return '';
    }

    public function workExperience(WorkExperiences $workExperiences): string
    {
        return $workExperiences->exportCompressed();
    }

    public function academicExperience(AcademicExperiences $academicExperiences): string
    {
        return $academicExperiences->exportCompressed();
    }

    public function supports(string $contentLengthType): bool
    {
        return self::CONTENT_LENGTH_TYPE_COMPRESSED === $contentLengthType;
    }
}
