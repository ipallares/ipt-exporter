<?php

declare(strict_types=1);

namespace App\exporter\domain\model;

use App\exporter\domain\model\sections\AcademicExperiences;
use App\exporter\domain\model\sections\CoverLetter;
use App\exporter\domain\model\sections\PersonalDetails;
use App\exporter\domain\model\sections\WorkExperiences;

class CV
{
    private PersonalDetails $personalDetails;

    private CoverLetter $coverLetter;

    private WorkExperiences $workExperiences;

    private AcademicExperiences $academicExperience;

    public function __construct(PersonalDetails $personalDetails, CoverLetter $coverLetter, WorkExperiences $workExperiences, AcademicExperiences $academicExperience)
    {
        $this->personalDetails = $personalDetails;
        $this->coverLetter = $coverLetter;
        $this->workExperiences = $workExperiences;
        $this->academicExperience = $academicExperience;
    }

    public function exportPersonalDetailsCompressed(): string
    {
        return $this->personalDetails->exportCompressed();
    }

    public function exportWorkExperiencesCompressed(): string
    {
        return $this->workExperiences->exportCompressed();
    }

    public function exportAcademicExperiencesCompressed(): string
    {
        return $this->academicExperience->exportCompressed();
    }

    public function exportPersonalDetailsExtended(): string
    {
        return $this->personalDetails->exportExtended();
    }

    public function exportCoverLetterExtended(): string
    {
        return $this->coverLetter->export();
    }

    public function exportWorkExperiencesExtended(): string
    {
        return $this->workExperiences->exportExtended();
    }

    public function exportAcademicExperiencesExtended(): string
    {
        return $this->academicExperience->exportExtended();
    }

    public function getPersonalDetails(): PersonalDetails
    {
        return $this->personalDetails;
    }

    public function getCoverLetter(): CoverLetter
    {
        return $this->coverLetter;
    }

    public function getWorkExperiences(): WorkExperiences
    {
        return $this->workExperiences;
    }

    public function getAcademicExperience(): AcademicExperiences
    {
        return $this->academicExperience;
    }
}
// IPT: TODO: BilderPattern to instantiate this object


