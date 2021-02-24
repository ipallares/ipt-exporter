<?php

declare(strict_types=1);

namespace App\exporter\domain\services\interfaces;

use App\exporter\domain\model\sections\AcademicExperiences;
use App\exporter\domain\model\sections\PersonalDetails;
use App\exporter\domain\model\sections\WorkExperiences;

interface ContentLengthTypeExporter
{
    public function personalDetails(PersonalDetails $personalDetails): string;

    public function coverLetter(string $coverLetter): string;

    public function workExperience(WorkExperiences $workExperiences): string;

    public function academicExperience(AcademicExperiences $academicExperiences): string;
}
