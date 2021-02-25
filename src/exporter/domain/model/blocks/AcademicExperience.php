<?php

declare(strict_types=1);

namespace App\exporter\domain\model\blocks;

use App\exporter\domain\model\interfaces\MultipleContentLengthExportInterface;

class AcademicExperience implements MultipleContentLengthExportInterface
{
    private string $schoolName;
    private string $title;
    private DateRange $dateRange;
    private string $additionalInfo;

    public function __construct(string $schoolName, string $title, DateRange $dateRange, string $additionalInfo = '')
    {
        $this->schoolName = $schoolName;
        $this->title = $title;
        $this->dateRange = $dateRange;
        $this->additionalInfo = $additionalInfo;
    }

    public function exportCompressed(): string
    {
        return '<compressed-academicexperience>'
            . $this->exportDateRange()
            . $this->exportSchoolName()
            . $this->exportTitle()
            . '</compressed-academicexperience>';
    }

    public function exportExtended(): string
    {
        return '<extended-academicexperience>'
            . $this->exportDateRange()
            . $this->exportSchoolName()
            . $this->exportTitle()
            . $this->exportAdditionalInfo()
            . "</extended-academicexperience>";
    }

    public function getSchoolName(): string
    {
        return $this->schoolName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDateRange(): DateRange
    {
        return $this->dateRange;
    }

    public function getAdditionalInfo(): string
    {
        return $this->additionalInfo;
    }

    private function exportSchoolName(): string
    {
        return "<schoolname>$this->schoolName</schoolname>";
    }

    private function exportTitle(): string
    {
        return "<title>$this->title</title>";
    }

    private function exportDateRange(): string
    {
        return $this->dateRange->export();
    }

    private function exportAdditionalInfo(): string
    {
        return "<additionalinfo>$this->additionalInfo</additionalinfo>";
    }
}
