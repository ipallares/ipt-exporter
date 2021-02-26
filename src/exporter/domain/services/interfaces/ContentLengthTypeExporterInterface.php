<?php

declare(strict_types=1);

namespace App\exporter\domain\services\interfaces;

use App\exporter\domain\model\sections\AcademicExperiences;
use App\exporter\domain\model\sections\CoverLetter;
use App\exporter\domain\model\sections\PersonalDetails;
use App\exporter\domain\model\sections\WorkExperiences;

interface ContentLengthTypeExporterInterface
{
    public function personalDetails(PersonalDetails $personalDetails): string;

    public function coverLetter(CoverLetter $coverLetter): string;

    public function workExperience(WorkExperiences $workExperiences): string;

    public function academicExperience(AcademicExperiences $academicExperiences): string;

    public function supports(string $contentLengthType): bool;
}
