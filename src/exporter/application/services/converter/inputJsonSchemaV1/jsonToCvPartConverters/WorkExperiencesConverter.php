<?php

declare(strict_types=1);

namespace App\exporter\application\services\converter\inputJsonSchemaV1\jsonToCvPartConverters;

use App\exporter\application\services\converter\JsonToCvPartConverterInterface;
use App\exporter\domain\model\blocks\DateRange;
use App\exporter\domain\model\blocks\WorkExperience;
use App\exporter\domain\model\sections\WorkExperiences;
use Exception;

class WorkExperiencesConverter implements JsonToCvPartConverterInterface
{
    /**
     * @param object $cv- Json Object in valid cv-schema-v1.json format
     *
     * @throws Exception
     */
    public function convert(object $cv): WorkExperiences
    {
        $workExperiences = $cv->workExperiences;

        return new WorkExperiences($this->convertWorkExperiences($workExperiences));
    }

    /**
     * @param array<int, mixed> $workExperiences
     *
     * @return array<int, WorkExperience>
     *
     * @throws Exception
     */
    private function convertWorkExperiences(array $workExperiences): array
    {
        $result = [];
        foreach($workExperiences as $workExperience) {
            $result[] = $this->convertWorkExperience($workExperience);
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    private function convertWorkExperience(object $workExperience): WorkExperience
    {
        $schoolName = $workExperience->companyName;
        $title = $workExperience->position;
        $iniDate = $workExperience->startDate;
        $endDate = $workExperience->endDate;
        $dateRange = DateRange::fromStrings($iniDate, $endDate);
        $additionalInfo = $workExperience->description;

        return new WorkExperience($schoolName, $title, $dateRange, $additionalInfo);
    }
}
