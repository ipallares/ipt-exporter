<?php

declare(strict_types=1);

namespace App\exporter\domain\model\sections;

use App\exporter\domain\model\blocks\AcademicExperience;
use App\exporter\domain\model\interfaces\MultipleContentLengthExportInterface;
use InvalidArgumentException;

class AcademicExperiences implements MultipleContentLengthExportInterface
{
    /** @var array array<int, AcademicExperience> $academicExperiences */
    private array $academicExperiences;

    /**
     * @param array<int, AcademicExperience> $academicExperiences
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $academicExperiences)
    {
        foreach($academicExperiences as $academicExperience) {
            if (!$academicExperience instanceof AcademicExperience) {
                throw new InvalidArgumentException('All elements in an AcademicExperiences obejct must be of type AcademicExperience');
            }
        }
        $this->academicExperiences = $academicExperiences;
    }

    public function exportCompressed(): string
    {
        $result = '<compressed-academicexperiences>';
        foreach($this->academicExperiences as $academicExperience) {
            /** @var AcademicExperiences $academicExperience */
            $result .= $academicExperience->exportCompressed();
        }
        $result .= '</compressed-academicexperiences>';

        return $result;
    }

    public function exportExtended(): string
    {
        $result = '<extended-academicexperiences>';
        foreach($this->academicExperiences as $academicExperience) {
            /** @var AcademicExperience $academicExperience */
            $result .= $academicExperience->exportExtended();
        }
        $result .= '</extended-academicexperiences>';

        return $result;
    }

    /**
     * @return array<int, AcademicExperience>
     */
    public function getAcademicExperiences(): array
    {
        return $this->academicExperiences;
    }
}
