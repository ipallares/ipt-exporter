<?php

declare(strict_types=1);

namespace App\exporter\domain\model\sections;

use App\exporter\domain\model\blocks\WorkExperience;
use InvalidArgumentException;

class WorkExperiences
{
    /** @var array<int, WorkExperience> $workExperiences */
    private array $workExperiences;

    /**
     * @param array<int, WorkExperience> $workExperiences
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $workExperiences)
    {
        foreach($workExperiences as $workExperience) {
            if (!$workExperience instanceof WorkExperience) {
                throw new InvalidArgumentException('All elements in an WorkExperiences object must be of type WorkExperience');
            }
        }

        $this->workExperiences = $workExperiences;
    }

    public function exportCompressed()
    {
        $result = '<compressed-workexperiences>';
        foreach($this->workExperiences as $workExperience) {
            /** @var WorkExperience $workExperience */
            $result .= $workExperience->exportCompressed();
        }
        $result .= '<compressed-workexperiences>';

        return $result;
    }

    public function exportExtended()
    {
        $result = '<extended-workexperiences>';
        foreach($this->workExperiences as $workExperience) {
            /** @var WorkExperience $workExperience */
            $result .= $workExperience->exportExtended();
        }
        $result .= '<extended-workexperiences>';

        return $result;
    }

    public function getWorkExperiences(): array
    {
        return $this->workExperiences;
    }
}

// IPT: TODO: Apply Iterator Pattern
