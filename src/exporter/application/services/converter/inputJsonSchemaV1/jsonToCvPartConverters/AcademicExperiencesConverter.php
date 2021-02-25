<?php

declare(strict_types=1);

namespace App\exporter\application\services\converter\inputJsonSchemaV1\jsonToCvPartConverters;

use App\exporter\application\services\converter\JsonToCvPartConverterInterface;
use App\exporter\domain\model\blocks\AcademicExperience;
use App\exporter\domain\model\blocks\DateRange;
use App\exporter\domain\model\sections\AcademicExperiences;
use Exception;

class AcademicExperiencesConverter implements JsonToCvPartConverterInterface
{

    /**
     * @param object $cv- Json Object in valid cv-schema-v1.json format
     *
     * @throws Exception
     */
    public function convert(object $cv): AcademicExperiences
    {
        $academicExperiences = $cv->academicExperiences;

        return new AcademicExperiences($this->convertAcademicExperiences($academicExperiences));
    }

    /**
     * @param array<int, mixed> $academicExperiences
     *
     * @return array<int, AcademicExperience>
     *
     * @throws Exception
     */
    private function convertAcademicExperiences(array $academicExperiences): array
    {
        $result = [];
        foreach($academicExperiences as $academicExperience) {
            $result[] = $this->convertAcademicExperience($academicExperience);
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    private function convertAcademicExperience(object $academicExperience): AcademicExperience
    {
        $schoolName = $academicExperience->schoolName;
        $title = $academicExperience->title;
        $iniDate = $academicExperience->startDate;
        $endDate = $academicExperience->endDate;
        $dateRange = DateRange::fromStrings($iniDate, $endDate);
        $additionalInfo = $academicExperience->description;

        return new AcademicExperience($schoolName, $title, $dateRange, $additionalInfo);
    }
}
