<?php

declare(strict_types=1);

namespace App\exporter\domain\services;

use App\exporter\domain\model\sections\AcademicExperiences;
use App\exporter\domain\model\sections\CoverLetter;
use App\exporter\domain\model\sections\PersonalDetails;
use App\exporter\domain\model\sections\WorkExperiences;
use App\exporter\domain\services\interfaces\ContentLengthTypeExporter;

class CompressedExporter implements ContentLengthTypeExporter
{

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
}
