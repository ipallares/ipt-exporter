<?php

declare(strict_types=1);

namespace App\exporter\domain\model;

use App\exporter\domain\model\sections\AcademicExperiences;
use App\exporter\domain\model\sections\CoverLetter;
use App\exporter\domain\model\sections\PersonalDetails;
use App\exporter\domain\model\sections\WorkExperiences;
use InvalidArgumentException;

class CV
{

    private const ACADEMIC_EXPERIENCES_KEY = 'academicExperiences';
    private const COVER_LETTER_KEY = 'coverLetter';
    private const PERSONAL_DETAILS_KEY = 'personalDetails';
    private const WORK_EXPERIENCES_KEY = 'workExperiences';

    private const CV_PART_KEYS = [
        self::ACADEMIC_EXPERIENCES_KEY,
        self::COVER_LETTER_KEY,
        self::PERSONAL_DETAILS_KEY,
        self::WORK_EXPERIENCES_KEY,
    ];

    private PersonalDetails $personalDetails;

    private CoverLetter $coverLetter;

    private WorkExperiences $workExperiences;

    private AcademicExperiences $academicExperiences;

    private function __construct(
        PersonalDetails $personalDetails,
        CoverLetter $coverLetter,
        WorkExperiences $workExperiences,
        AcademicExperiences $academicExperiences
    ) {
        $this->personalDetails = $personalDetails;
        $this->coverLetter = $coverLetter;
        $this->workExperiences = $workExperiences;
        $this->academicExperiences = $academicExperiences;
    }

    public static function fromValueObjects(PersonalDetails $personalDetails, CoverLetter $coverLetter, WorkExperiences $workExperiences, AcademicExperiences $academicExperience): self
    {
        return new self($personalDetails, $coverLetter, $workExperiences, $academicExperience);
    }

    public static function fromIndexedArray(array $cvParts): self
    {
        self::validateIndexedArray($cvParts);

        return new self(
            $cvParts[self::PERSONAL_DETAILS_KEY],
            $cvParts[self::COVER_LETTER_KEY],
            $cvParts[self::WORK_EXPERIENCES_KEY],
            $cvParts[self::ACADEMIC_EXPERIENCES_KEY]
        );
    }

    private static function validateIndexedArray(array $cvParts): void
    {
        if (self::isInvalidIndexedArray($cvParts)) {
            throw new InvalidArgumentException('CV constructor did not get all expected elements');
        }
    }

    private static function isInvalidIndexedArray(array $cvParts)
    {
        return self::areAllExpectedKeysInArray(self::CV_PART_KEYS, $cvParts);
    }

    private static function areAllExpectedKeysInArray(array $expectedKeys, array $indexedArray): bool
    {
        return 0 <  count(array_diff( $expectedKeys, array_keys($indexedArray)));
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
        return $this->academicExperiences->exportCompressed();
    }

    public function exportPersonalDetailsExtended(): string
    {
        return $this->personalDetails->exportExtended();
    }

    public function exportCoverLetterExtended(): string
    {
        return $this->coverLetter->exportExtended();
    }

    public function exportWorkExperiencesExtended(): string
    {
        return $this->workExperiences->exportExtended();
    }

    public function exportAcademicExperiencesExtended(): string
    {
        return $this->academicExperiences->exportExtended();
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

    public function getAcademicExperiences(): AcademicExperiences
    {
        return $this->academicExperiences;
    }
}


